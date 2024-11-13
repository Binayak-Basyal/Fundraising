<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Control Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .btn::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.3);
            transition: left 0.3s ease;
            z-index: -1;
        }

        .btn:hover::before {
            left: 100%;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col items-center">

    <header class="w-full bg-indigo-600 text-white flex justify-between items-center p-4">
        <div class="logo">
            <img src="{{ asset('icons/logo.png') }}" alt="Logo" class="h-10">
        </div>
        <nav class="navbar flex space-x-4">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-200">Home</a>
            <a href="{{ route('admin.users') }}" class="hover:text-gray-200">Manage Users</a>
            <a href="{{ route('admin.fund.index') }}" class="hover:text-gray-200">Manage Funds</a>
            <a href="{{ route('admin.categories.index') }}" class="hover:text-gray-200">Manage Categories</a>
            <a href="{{ route('kmeans.index') }}" class="hover:text-gray-200">K Means Cluster</a> <!-- Added this line -->
        </nav>
        <form action="{{ route('admin.logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit"
                class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-md relative overflow-hidden btn">
                Logout
            </button>
        </form>
    </header>

    <main class="text-center p-6 flex-grow">
        <h1 class="text-4xl font-bold text-gray-800 mb-6">Admin Control Panel</h1>
        <p class="text-gray-600 mb-6">This page is exclusively for administrators to manage and update the website content. With the admin control panel, you have the power to:</p>
        <ul class="list-disc list-inside text-gray-600 mb-6 text-left max-w-2xl mx-auto">
            <li>Add, edit, and remove user accounts</li>
            <li>Manage product listings and inventory</li>
            <li>Create and organize categories for easy navigation</li>
            <li>Access detailed analytics and reports</li>
            <li>Customize the website's design and settings</li>
        </ul>
        <p class="text-gray-600 mb-6">Make use of the options below to effectively maintain and enhance your website:</p>
        <div class="space-y-4">
            <a href="{{ route('admin.users') }}">
                <button class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-md relative overflow-hidden btn">
                    Manage Users
                </button>
            </a>
            <a href="{{ route('admin.fund.index') }}">
                <button class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md relative overflow-hidden btn">
                    Manage Funds
                </button>
            </a>
            <a href="{{ route('admin.categories.index') }}">
                <button class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded-md relative overflow-hidden btn">
                    Manage Categories
                </button>
            </a>
        </div>
    </main>

</body>

</html>
