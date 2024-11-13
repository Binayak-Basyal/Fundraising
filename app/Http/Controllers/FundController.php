<?php

namespace App\Http\Controllers;

use App\Models\Fund; // Ensure you have a Fund model
use App\Models\Category; // Assuming categories are needed for funds
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Donation;

class FundController extends Controller
{

    public function home()
    {
        // Your logic here, e.g., fetching data for the home page
        return view('home'); // Adjust this to your actual view
    }
    public function index()
    {
        $userId = Auth::id();
        $funds = Fund::where('user_id', $userId)->get(); // Update this if your field name is different
        $categories = Category::all();
        return view('funds.index', compact('funds', 'categories'));
    }



    public function adminIndex()
    {
        $funds = Fund::with('category')->get(); // Assuming you have a relationship with Category
        return view('admin.funds.index', compact('funds')); // Create an admin view for funds
    }

//     public function userIndex(Request $request)
// {
//     // Fetch all categories (you may want to include any relationships if needed)
//     $categories = Category::all();

//     // Start a query for funds
//     $fundsQuery = Fund::query();

//     // Check for filtering by category (if applicable)
//     if ($request->filled('category_id')) {
//         $fundsQuery->where('category_id', $request->input('category_id'));
//     }

//     // Exclude funds owned by the logged-in user
//     if (Auth::check()) {
//         $fundsQuery->where('owner_email', '!=', Auth::user()->email);
//     }

//     // Retrieve the filtered funds with pagination
//     $funds = $fundsQuery->orderBy('created_at', 'desc')->paginate(10); // Adjust number as needed

//     // Return the view with categories and funds
//     return view('allfunds', compact('categories', 'funds'));
// }

public function userIndex(Request $request)
{
    // Fetch all categories (you may want to include any relationships if needed)
    $categories = Category::all();

    // Start a query for funds
    $fundsQuery = Fund::query();

    // Check for filtering by category (if applicable)
    if ($request->filled('category_id')) {
        $fundsQuery->where('category_id', $request->input('category_id'));
    }

    // Exclude funds owned by the logged-in user
    if (Auth::check()) {
        $fundsQuery->where('owner_email', '!=', Auth::user()->email);
    }

    // Retrieve the filtered funds with pagination
    $funds = $fundsQuery->orderBy('created_at', 'desc')->paginate(10); // Adjust number as needed

    // Return the view with categories and funds
    return view('allfunds', compact('categories', 'funds'));
}

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'fund_amount' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'category_id' => 'required|exists:categories,id',
            'details' => 'nullable|string',
            'image' => 'required|image|max:2048', // Adjust as needed
        ]);
    
        // Create a new fund
        $fund = Fund::create([
            'name' => $request->name,
            'fund_amount' => $request->fund_amount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'category_id' => $request->category_id,
            'details' => $request->details,
            'image' => $request->file('image')->store('public/funds'), // Store the uploaded image in public directory
            'owner_email' => Auth::user()->email, // Get owner's email from session
        ]);
    
        // Redirect or return response
        return redirect()->route('fundhere')->with('success', 'Fund created successfully!');
    }
    

    public function show($id)
    {
        $fund = Fund::findOrFail($id);

        // Calculate the total amount raised
        $raisedAmount = DB::table('donations')
            ->where('fund_id', $fund->id)
            ->sum('amount');

        return view('funds.show', compact('fund', 'raisedAmount'));
    }


    public function update(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'fund_amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'category_id' => 'required|exists:categories,id',
            'details' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Find the fund by ID
        $fund = Fund::findOrFail($id);
    
        // Check if an image file is uploaded
        if ($request->hasFile('image')) {
            // Store the uploaded image in the public directory
            $imagePath = $request->file('image')->store('public/funds');
            $validatedData['image'] = $imagePath;
        }
    
        // Update the fund with validated data
        $fund->update($validatedData);
    
        // Redirect to the fund's page with a success message
        return redirect()->route('funds.myfunds', $fund->id)->with('success', 'Fund updated successfully.');
    }

    public function destroy($id)
    {
        $fund = Fund::findOrFail($id);
        $fund->delete();

        return redirect()->route('funds.index')->with('success', 'Fund deleted successfully');
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('searchTerm');

        $funds = Fund::where(function ($query) use ($searchTerm) {
            $query->where('name', 'LIKE', "%{$searchTerm}%")
                ->orWhere('details', 'LIKE', "%{$searchTerm}%");
        })
            ->where('owner_email', '!=', Auth::user()->email)
            ->get();

        return view('funds.search_results', compact('funds', 'searchTerm')); // Create a view for search results
    }
    public function showSellForm()
    {
        // Get the logged-in user's ID
        $userId = Auth::id();

        // Fetch funds associated with the logged-in user
        $funds = Fund::where('owner_email', Auth::user()->email)->get(); // Change 'owner_email' to 'user_id' if necessary

        // Check if funds are fetched
        // dd($funds); // Uncomment to debug if needed

        // Fetch categories if needed
        $categories = Category::all();

        // Return the view with funds and categories
        return view('getfunds', compact('funds', 'categories'));
    }


    public function displayFund($id)
{
    $fund = Fund::findOrFail($id);
    $totalDonations = $fund->donations()->sum('amount');
    $remainingAmount = $fund->fund_amount - $totalDonations;

    return view('funds.show', compact('fund', 'totalDonations', 'remainingAmount'));
}



public function donate(Request $request)
{
    // Validate the request
    $request->validate([
        'fund_id' => 'required|exists:funds,id',
        'donation_amount' => 'required|numeric|min:1',
        'message' => 'nullable|string|max:255',
    ]);

    $fund = Fund::findOrFail($request->fund_id);
    $donationAmount = $request->donation_amount;

    // Check if the donation amount is valid
    if ($donationAmount > $fund->fund_amount) {
        return redirect()->back()->withErrors(['donation_amount' => 'Donation amount cannot exceed the remaining fund amount.']);
    }

    // Create a new donation record
    Donation::create([
        'user_id' => Auth::id(), // Assuming you want to associate the donation with the authenticated user
        'fund_id' => $fund->id,
        'amount' => $donationAmount,
        'message' => $request->message,
    ]);

    // Update the fund's remaining amount
    $fund->fund_amount -= $donationAmount;
    $fund->save();

    // Redirect back with success message
    return redirect()->route('funds.show', $fund->id)->with('success', 'Thank you for your donation!');
}

public function myfunds($id)
{
    // Retrieve the specific fund by ID
    $fund = Fund::with('category')->findOrFail($id);

    // Retrieve all categories
    $categories = Category::all();

    // Return the view with the fund and categories data
    return view('funds.myfunds', compact('fund', 'categories'));
}
    

   
}
