<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return view('profile');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('profile', ['user' => $user]);
    }

    public function approve($userId)
    {
        $user = User::findOrFail($userId);
        $user->status = 'approved'; // Update status to approved
        $user->save();

        return redirect()->route('user.index')->with('success', 'User approved successfully.');
    }

    public function decline($userId)
    {
        $user = User::findOrFail($userId);
        $user->status = 'declined'; // Update status to declined
        $user->save();

        return redirect()->route('user.index')->with('success', 'User declined successfully.');
    }

    public function update(Request $request)
{
    // Validate incoming request data
    $validatedData = $request->validate([
        'first_name' => 'required|string|max:255',
        'middle_name' => 'nullable|string|max:255',
        'last_name' => 'required|string|max:255',
        'phone' => 'required|string|max:15',
        'dob' => 'required|date',
        'address' => 'required|string|max:255',
        'gender' => 'required|in:Male,Female,Other', // Add validation for gender
        'user_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Find the authenticated user
    $user = User::findOrFail(Auth::id());
    // Update user information
    $user->first_name = $validatedData['first_name'];
    $user->middle_name = $validatedData['middle_name'];
    $user->last_name = $validatedData['last_name'];
    $user->phone = $validatedData['phone'];
    $user->dob = $validatedData['dob'];
    $user->address = $validatedData['address'];
    $user->gender = $validatedData['gender']; // Save the gender

    // Handle profile picture upload
    if ($request->hasFile('user_pic')) {
        $file = $request->file('user_pic');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/profile_pics', $fileName);
        $user->user_pic = $fileName;
    }

    // Save the updated user
    $user->save();

    // Redirect back with success message
    return redirect()->route('profile.index')->with('success', 'Profile updated successfully!');
}


}
