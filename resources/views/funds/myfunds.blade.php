@extends('layouts.app')

@section('title', $fund->name)

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <div class="container mx-auto p-6">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            {{-- Fund Image and Details Container --}}
            <div class="flex flex-col md:flex-row bg-gray-100 p-4 rounded-lg shadow-inner">
                {{-- Fund Image --}}
                <div class="flex-shrink-0 md:w-1/3 mb-4 md:mb-0">
                    <div class="relative" >
                    <img src="{{ $fund->image ? asset('storage/' . str_replace('public/', '', $fund->image)) : 'https://via.placeholder.com/300' }}" alt="{{ $fund->name }}" class="w-full h-64 object-cover rounded-lg shadow-md">

                        <!-- <img src="{$fund->image ? asset('storage/' . str_replace('public/', '', $fund->image) : 'https://via.placeholder.com/300' }}" alt="{{ $fund->name }}" class="w-full h-64 object-cover rounded-lg shadow-md"> -->
                            <!-- style="background-image: url('{{ $fund->image ? asset('storage/' . str_replace('public/', '', $fund->image)) : 'https://via.placeholder.com/300' }}');" -->
                    </div>
                     
                    
                    {{-- Actions Buttons Container --}}
                    <div class="mt-2 flex flex-row gap-4 w-full">
                        <button id="editButton"
                                class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 w-full transition duration-300">Edit</button>
                        <form action="{{ route('funds.destroy', $fund->id) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this fund?');" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-600 text-white py-2 px-4 rounded hover:bg-red-700 w-full transition duration-300">Delete</button>
                        </form>
                    </div>
                </div>

                {{-- Fund Details --}}
                <div class="md:ml-8 md:w-2/3">
                    <h1 class="text-3xl font-bold mb-4 text-gray-800">{{ $fund->name }}</h1>
                    <p class="text-gray-800 text-lg mb-2"><strong>Fund Amount:</strong> Rs. {{ number_format($fund->fund_amount, 2) }}</p>
                    <p class="text-gray-800 text-lg mb-2"><strong>Start Date:</strong> {{ $fund->start_date }}</p>
                    <p class="text-gray-800 text-lg mb-2"><strong>End Date:</strong> {{ $fund->end_date }}</p>
                    <!-- <p class="text-gray-800 text-lg mb-2"><strong>Category ID:</strong> {{ $fund->category_id }}</p> -->
                    <p class="text-gray-800 text-lg mb-2"><strong>Description:</strong> {{ $fund->details }}</p>
                    <p class="text-gray-800 text-lg mb-2"><strong>Owner Email:</strong> {{ $fund->owner_email }}</p>
                    <!-- <p class="text-gray-800 text-lg mb-2"><strong>Status:</strong> {{ ucfirst($fund->status) }}</p> -->
                    <p class="text-gray-800 text-lg mb-2"><strong>Created At:</strong> {{ $fund->created_at->format('d M Y, H:i') }}</p>
                    <p class="text-gray-800 text-lg mb-2"><strong>Updated At:</strong> {{ $fund->updated_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Fund Modal --}}
    <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-70 z-50 hidden">
        <div class="bg-white p-8 border border-gray-300 shadow-lg rounded-lg w-full max-w-lg relative">
            <button id="closeModal" class="absolute top-4 right-4 text-red-600 text-2xl hover:text-red-700">&times;</button>
            <h3 class="text-xl font-semibold mb-4">Edit Fund</h3>
            <form action="{{ route('funds.update', $fund->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
            
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
                            placeholder="Name" value="{{ old('name', $fund->name) }}" required>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
            
                    <!-- Fund Amount -->
                    <div>
                        <label for="fund_amount" class="block text-sm font-medium text-gray-700">Fund Amount</label>
                        <input type="number" id="fund_amount" name="fund_amount"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('fund_amount') border-red-500 @enderror"
                            placeholder="Fund Amount" value="{{ old('fund_amount', $fund->fund_amount) }}" required>
                        @error('fund_amount')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
            
                    <!-- Start Date -->
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" id="start_date" name="start_date"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('start_date') border-red-500 @enderror"
                            value="{{ old('start_date', $fund->start_date) }}" required>
                        @error('start_date')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
            
                    <!-- End Date -->
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                        <input type="date" id="end_date" name="end_date"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('end_date') border-red-500 @enderror"
                            value="{{ old('end_date', $fund->end_date) }}" required>
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
                                    {{ old('category_id', $fund->category_id) == $category->id ? 'selected' : '' }}>
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
                            rows="4" placeholder="Provide detailed information about the fundraising">{{ old('details', $fund->details) }}</textarea>
                        @error('details')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
            
                    <!-- Image -->
                    <div class="col-span-2">
                        <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                        <input type="file" id="image" name="image"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('image') border-red-500 @enderror">
                        <p class="text-sm text-gray-600 mt-1">Current Image: <a href="{{ asset('funds/' . $fund->image) }}" target="_blank">{{ $fund->image }}</a></p>
                        @error('image')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            
                <button type="submit"
                    class="w-full py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">Update Fund</button>
            </form>
            
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('editButton').addEventListener('click', function() {
                document.getElementById('editModal').classList.remove('hidden');
            });
            document.getElementById('closeModal').addEventListener('click', function() {
                document.getElementById('editModal').classList.add('hidden');
            });
        });
    </script>

@endsection