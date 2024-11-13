@extends('layouts.app')

@section('title', $fund->name)

@section('content')
<div class="container mx-auto mt-12 p-6 bg-gray-100 rounded-lg shadow-lg">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <!-- Left Column: Fund Details -->
        <div class="bg-white p-8 rounded-lg shadow-md">
            <div class="text-center">
                <h1 class="text-5xl font-extrabold text-gray-800">{{ $fund->name }}</h1>
                {{-- <p class="mt-4 text-lg text-gray-600">{{ $fund->details }}</p> --}}
            </div>
            
            <div class="mt-8">
                <h2 class="text-3xl font-semibold text-green-700">Fund Details</h2>
                <div class="mt-4 space-y-4">
                    <p class="text-lg text-gray-700"><span class="font-bold">Goal Amount:</span> Rs.{{ number_format($fund->fund_amount, 2) }}</p>
                    <p class="text-lg text-gray-700"><span class="font-bold">Total Donations:</span> Rs.{{ number_format($totalDonations, 2) }}</p>
                    <p class="text-lg text-gray-700"><span class="font-bold">Remaining Amount:</span> Rs.{{ number_format($remainingAmount, 2) }}</p>
                </div>
                <div class="mt-4 flex">
                    <div class="h-64 w-1/2 bg-cover bg-center" style="background-image: url('{{ $fund->image ? asset('storage/' . str_replace('public/', '', $fund->image)) : 'https://via.placeholder.com/300' }}');"></div>
                    <div class="w-1/2 pl-4">
                        <h2 class="text-3xl font-semibold text-green-700">About:</h2>
                        <p class="mt-2 text-lg text-gray-700">{{ $fund->details }}</p>
                    </div>
                </div>
                
            </div>
        </div>

        <!-- Right Column: Donation Form -->
        <div class="bg-gradient-to-r from-green-400 to-blue-500 text-white p-8 rounded-lg shadow-md">
            <h2 class="text-3xl font-bold">Make a Donation</h2>
            <form method="POST" action="{{ route('funds.donate') }}" class="mt-6 space-y-6">
                @csrf
                <input type="hidden" name="fund_id" value="{{ $fund->id }}">
                
                <div>
                    <label for="donation_amount" class="block text-lg font-medium">Donation Amount</label>
                    <input type="number" name="donation_amount" id="donation_amount" class="w-full p-3 rounded-lg text-gray-800" required>
                    <small class="text-red-500 hidden" id="amountError">
                        Donation amount cannot exceed Rs.{{ number_format($remainingAmount, 2) }}
                    </small>
                </div>
                
                <div>
                    <label for="message" class="block text-lg font-medium">Message (optional)</label>
                    <textarea name="message" id="message" class="w-full p-3 rounded-lg text-gray-800"></textarea>
                </div>
                
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-white text-green-500 px-6 py-3 rounded-lg font-semibold shadow-md hover:bg-gray-100 transition duration-300">
                        Donate
                    </button>
                    <button type="button" id="closePopup" class="bg-gray-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-gray-700 transition duration-300">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('donation_amount').addEventListener('input', function () {
        const remainingAmount = {{ $remainingAmount }};
        const donationAmount = parseFloat(this.value);

        if (donationAmount > remainingAmount) {
            document.getElementById('amountError').classList.remove('hidden');
        } else {
            document.getElementById('amountError').classList.add('hidden');
        }
    });
</script>
@endsection
