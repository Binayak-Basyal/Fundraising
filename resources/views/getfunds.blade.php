{{-- {{ dd($funds) }} --}}
{{-- {{ dd(auth()->user()) }} --}}

@extends('layouts.app')

@section('title', 'Fundraising Page')

@section('content')

    <!-- Success Message -->
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Existing Code -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-attachment: fixed;
            overflow-y: scroll;
        }
    </style>

    <div class="w-full px-4 mt-16">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex justify-end mb-6">
                <button id="makeVisible"
                    class="w-36 h-12 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 transition-colors">Create
                    Fundraiser</button>
            </div>
            <h2 class="text-4xl font-extrabold mb-8 text-gray-900">Your Lists</h2>

            @if (isset($funds) && $funds->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                @foreach ($funds as $fundraiser)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden w-full">
                        <div class="relative">
                            <div class="h-64 bg-cover bg-center"
                            style="background-image: url('{{ $fundraiser->image ? asset('storage/' . str_replace('public/', '', $fundraiser->image)) : 'https://via.placeholder.com/300' }}');">
                       </div>
                       
                            <div class="absolute top-2 left-2">
                                <span class="bg-red-500 text-white text-xs px-2 py-1 rounded">New</span>
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="text-xl font-bold text-gray-800 mb-2 uppercase">{{ $fundraiser->name }}</h3>
                            <p class="text-gray-600 mb-4">Goal: Rs.{{ $fundraiser->fund_amount }}</p>
                            <p class="text-gray-600 mb-4">Start Date: {{ \Carbon\Carbon::parse($fundraiser->start_date)->format('Y-m-d') }}</p>
                            <p class="text-gray-600 mb-4">End Date: {{ \Carbon\Carbon::parse($fundraiser->end_date)->format('Y-m-d') }}</p>
                            <a href="{{ route('funds.myfunds', $fundraiser->id) }}"
                               class="text-blue-500 hover:text-blue-700 font-medium">
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600 text-lg">No data available at the moment. Please check back later.</p>
        @endif
        



            <!-- Create Fundraiser Form -->
            <div id="funds"
                class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-70 z-50 hidden">
                <div class="bg-white p-8 border border-gray-300 shadow-lg rounded-lg w-full max-w-lg relative">
                    <button id="cross"
                        class="absolute top-4 right-4 text-red-600 text-2xl hover:text-red-700">&times;</button>
                    <h3 class="text-xl font-semibold mb-4">Add Fund</h3>
                    <form action="{{ route('fundhere.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @if ($errors->any())
                            <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-700 rounded-lg">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" id="name" name="name"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('name') border-red-500 @enderror"
                                    placeholder="Name" value="{{ old('name') }}" required>
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Fund Amount -->
                            <div>
                                <label for="fund_amount" class="block text-sm font-medium text-gray-700">Fund Amount</label>
                                <input type="number" id="fund_amount" name="fund_amount"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('fund_amount') border-red-500 @enderror"
                                    placeholder="Fund Amount" value="{{ old('fund_amount') }}" required>
                                @error('fund_amount')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Start Date -->
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="date" id="start_date" name="start_date"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('start_date') border-red-500 @enderror"
                                    value="{{ old('start_date') }}" required>
                                @error('start_date')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- End Date -->
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                                <input type="date" id="end_date" name="end_date"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('end_date') border-red-500 @enderror"
                                    value="{{ old('end_date') }}" required>
                                @error('end_date')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                                <select id="category_id" name="category_id"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('category_id') border-red-500 @enderror">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Details -->
                            <div class="col-span-2">
                                <label for="details" class="block text-sm font-medium text-gray-700">Details</label>
                                <textarea id="details" name="details"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('details') border-red-500 @enderror"
                                    rows="4" placeholder="Provide detailed information about the fundraising">{{ old('details') }}</textarea>
                                @error('details')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Image -->
                            <div class="col-span-2">
                                <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                                <input type="file" id="image" name="image"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('image') border-red-500 @enderror">
                                @error('image')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">Get
                            Donation</button>
                    </form>
                </div>
            </div>
              <script>
                  document.addEventListener('DOMContentLoaded', function() {
                      // Handle the visibility of the fundraiser form
                      document.getElementById('makeVisible').addEventListener('click', function() {
                          document.getElementById('funds').classList.remove('hidden');
                      });

                      document.getElementById('cross').addEventListener('click', function() {
                          document.getElementById('funds').classList.add('hidden');
                      });

                      // Set minimum date for start_date and end_date
                      var today = new Date().toISOString().split('T')[0];
                      document.getElementById('start_date').setAttribute('min', today);
                      document.getElementById('end_date').setAttribute('min', today);

                      // Ensure end_date is always after start_date
                      document.getElementById('start_date').addEventListener('change', function() {
                          document.getElementById('end_date').setAttribute('min', this.value);
                      });
                  });
              </script>
          </div>
    </div>

@endsection
