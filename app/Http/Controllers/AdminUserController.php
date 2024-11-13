<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminUserController extends Controller
{
    public function showAllUsers()
{
    $users = User::all();
    $pendingUsers = User::where('status', 'pending')->get(); // Adjust this query to your actual status column logic
    return view('admin.user', compact('users', 'pendingUsers'));
}

    

public function approve($id)
{
   
    $statusApproved = 1; 

    $user = User::findOrFail($id);
    $user->status = $statusApproved; 
    $user->save();

    return redirect()->route('admin.users')->with('success', 'User approved successfully');
}


    public function decline($id)
    {
        $user = User::findOrFail($id);

        // Send email to the user
        Mail::raw('Your account has not been confirmed. Please try again later.', function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Account Decline Notification');
        });

        $user->delete(); // or set a specific status if you don't want to delete

        return redirect()->route('admin.users')->with('success', 'User declined and email sent successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully');
    }
}
