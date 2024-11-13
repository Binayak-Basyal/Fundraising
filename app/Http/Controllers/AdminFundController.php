<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fund; // Import the Fund model

class AdminFundController extends Controller
{
    public function index()
    {
        // Retrieve all funds from the database
        $funds = Fund::with('category')->get(); // Eager load the category relationship

        // Return the view with the funds data
        return view('admin.fund', compact('funds'));
    }
    public function destroy($id)
    {
        $fund = Fund::findOrFail($id);
        $fund->delete();

        return redirect()->route('admin.fund.index')->with('success', 'Fund deleted successfully.');
    }
}
