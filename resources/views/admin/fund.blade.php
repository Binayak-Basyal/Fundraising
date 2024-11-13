<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funds Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
    <header class="w-full bg-indigo-600 text-white flex justify-between items-center p-4">
        <div class="logo">
            <img src="{{ asset('icons/logo.png') }}" alt="Logo" class="h-10">
        </div>
        <nav class="navbar flex space-x-4">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-200">Home</a>
            <a href="{{ route('admin.users') }}" class="hover:text-gray-200">Manage Users</a>
            <a href="{{ route('admin.fund.index') }}" class="hover:text-gray-200">Manage Funds</a>
            <a href="{{ route('admin.categories.index') }}" class="hover:text-gray-200">Manage Categories</a>
            <a href="{{ route('admin.kmeans') }}" class="hover:text-gray-200">K-Means Clustering</a>
        </nav>
        <form action="{{ route('admin.logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit"
                class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-md relative overflow-hidden btn">
                Logout
            </button>
        </form>
    </header>

    <div class="container mx-auto py-8 flex-grow">
        <h1
            class="text-4xl font-bold text-center mb-8 bg-gradient-to-r from-blue-400 to-blue-800 text-white py-4 rounded-lg shadow-lg">
            Funds Details
        </h1>
        <div class="bg-white p-8 rounded-lg shadow-lg">
            <p class="text-center text-gray-600 mb-6">This table displays the details of all funds.</p>
            <hr class="mb-6">
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="py-2 px-4 border">Fund Name</th>
                            <th class="py-2 px-4 border">Fund Amount</th>
                            <th class="py-2 px-4 border">Start Date</th>
                            <th class="py-2 px-4 border">End Date</th>
                            <th class="py-2 px-4 border">Category</th>
                            <th class="py-2 px-4 border">Details</th>
                            <th class="py-2 px-4 border">Image</th>
                            <th class="py-2 px-4 border">Owner Email</th>
                            <th class="py-2 px-4 border">Status</th>
                            <th class="py-2 px-4 border">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($funds as $fund)
                            <tr>
                                <td class="py-2 px-4 border">{{ $fund->name }}</td>
                                <td class="py-2 px-4 border">{{ number_format($fund->fund_amount, 2) }}</td>
                                <td class="py-2 px-4 border">
                                    {{ \Carbon\Carbon::parse($fund->start_date)->format('Y-m-d') }}</td>
                                <td class="py-2 px-4 border">
                                    {{ \Carbon\Carbon::parse($fund->end_date)->format('Y-m-d') }}</td>
                                <td class="py-2 px-4 border">{{ $fund->category->name ?? 'N/A' }}</td>
                                <td class="py-2 px-4 border">{{ $fund->details }}</td>
                                <td class="py-2 px-4 border">
                                    @if ($fund->image)
                                        <img src="{{ asset('storage/' . $fund->image) }}" alt="Fund Image"
                                            class="h-16 w-16 object-cover">
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="py-2 px-4 border">{{ $fund->owner_email }}</td>
                                <td class="py-2 px-4 border">{{ $fund->status }}</td>
                                <td class="py-2 px-4 border">
                                    {{-- <form action="{{ route('fund.destroy', $fund->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">Delete</button>
                                    </form> --}}
                                    <form class="inline-block" method="POST"
                                        action="{{ route('admin.fund.destroy', $fund->id) }}"
                                        onsubmit="return confirm('Are you sure you want to delete this book?')">
                                        @csrf
                                        @method('DELETE')
                                        <input
                                            class="bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded cursor-pointer"
                                            type="submit" value="Delete">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <footer class="bg-gray-800 text-white py-4 mt-8">
        <div class="container mx-auto text-center">
            &copy; 2024 Your Company. All rights reserved.
        </div>
    </footer>
</body>

</html>
