<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\Fund;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DonationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'fund_id' => 'required|exists:funds,id',
        ]);

        try {
            // Begin a transaction
            DB::beginTransaction();

            // Retrieve the fund and calculate remaining amount
            $fund = Fund::findOrFail($request->fund_id);
            $raisedAmount = Donation::where('fund_id', $request->fund_id)->sum('amount');
            $maxDonationAmount = $fund->fund_amount - $raisedAmount;

            // Check if the donation amount exceeds the allowable amount
            if ($request->amount > $maxDonationAmount) {
                return redirect()->back()->with('error', 'Donation amount exceeds the remaining fund amount. You can donate up to ' . $maxDonationAmount . ' only.');
            }

            // Store the donation
            $donation = new Donation();
            $donation->user_id = Auth::id();
            $donation->fund_id = $request->fund_id;
            $donation->amount = $request->amount;
            $donation->donor_name = Auth::user()->name;
            $donation->save();

            // Update the fund's raised amount
            if ($raisedAmount + $request->amount >= $fund->fund_amount) {
                $fund->is_active = false;
                $fund->save();
            }

            // Commit the transaction
            DB::commit();

            return redirect()->route('funds.show', $request->fund_id)
                             ->with('success', 'Thank you for your donation!');
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();

            // Log the error message
            Log::error($e->getMessage());

            return redirect()->route('funds.show', $request->fund_id)
                             ->with('error', 'An error occurred while processing your donation. Please try again.');
        }
    }
}
