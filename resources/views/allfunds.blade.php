@extends('layouts.app')

@section('title', 'All Funds')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Custom styles for hover effects */
        .hover-bg-animation {
            background-size: 200% auto;
            transition: background-position 0.5s ease;
        }

        .hover-bg-animation:hover {
            background-position: right center;
        }

        /* Shadow and hover animation for fund cards */
        .fund-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05); /* Subtle border to make cards distinct */
            box-shadow: 0 5px 15px rgba(173, 216, 230, 0.5); /* Soft light blue shadow */
            margin-bottom: 20px; /* Extra margin to separate cards */
        }

        .fund-card:hover {
            transform: translateY(-8px);
            box-shadow: 0px 12px 24px rgba(30, 144, 255, 0.5); /* Blue shadow on hover */
            border-color: rgba(30, 144, 255, 0.7); /* Blue border on hover */
        }
    </style>

    <div class="flex min-h-screen bg-[#F0F8FF] text-gray-800">
        <!-- Sidebar -->
        <aside class="w-64 bg-[#FFF1E6] text-gray-800 p-4 shadow-lg">
            <h2 class="text-xl font-semibold mb-4">Categories</h2>
            <ul>
                @foreach ($categories as $category)
                    <li class="mb-2">
                        <button 
                            class="w-full text-left px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md hover-bg-animation"
                            onclick="filterFunds({{ $category->id }})">
                            {{ $category->category_name }}
                        </button>
                    </li>
                @endforeach
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-3xl font-bold text-gray-800">Campaigns</h1>
            </div>

            <div id="fund-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @forelse ($funds as $fund)  <!-- Use forelse to handle empty states -->
                    <a href="{{ route('funds.show', $fund->id) }}">
                        <div class="bg-white p-4 rounded-lg shadow-md fund-card">
                            <div class="h-64 bg-cover bg-center"
                                 style="background-image: url('{{ $fund->image ? asset('storage/' . str_replace('public/', '', $fund->image)) : 'https://via.placeholder.com/300' }}');">
                            </div>
                            <h2 class="text-xl font-semibold">{{ $fund->name }}</h2>
                            <p class="text-gray-600">Amount: Rs.{{ number_format($fund->fund_amount, 2) }}</p>
                            <p class="text-gray-600">Start Date: {{ \Carbon\Carbon::parse($fund->start_date)->format('d M Y') }}</p>
                            <p class="text-gray-600">End Date: {{ \Carbon\Carbon::parse($fund->end_date)->format('d M Y') }}</p>
                        </div>
                    </a>
                @empty
                    <p class="text-gray-600">No campaigns available at the moment.</p>
                @endforelse
            </div>

            <!-- Pagination Links -->
            <div class="mt-6">
                {{ $funds->appends(request()->input())->links() }} <!-- Appends the current query string to pagination links -->
            </div>
        </main>
    </div>

    <script>
        function filterFunds(categoryId) {
            let url = new URL(window.location.href);
            url.searchParams.set('category_id', categoryId || '');
            url.searchParams.set('page', 1); // Reset to the first page when filtering
            window.location.href = url.toString();
        }
    </script>
@endsection
