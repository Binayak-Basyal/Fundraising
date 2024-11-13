<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this user?");
        }
    </script>
    <meta http-equiv="refresh" content="10">
</head>

<body class="bg-gray-100 font-sans antialiased">

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

    <main class="container mx-auto mt-8">
        <!-- Pending Users Section -->
        <section class="mb-8">
            <h1
                class="text-2xl font-bold text-center bg-gradient-to-r from-blue-500 to-blue-800 text-white py-4 rounded">
                User Approval Requests</h1>
            <div class="bg-white p-6 shadow rounded mt-4">
                <p class="text-gray-700 text-center mb-4">This table displays the pending user approval requests.</p>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">User ID</th>
                                <th class="py-2 px-4 border-b">First Name</th>
                                <th class="py-2 px-4 border-b">Last Name</th>
                                <th class="py-2 px-4 border-b">Email</th>
                                <th class="py-2 px-4 border-b">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendingUsers as $user)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $user->id }}</td>
                                    <td class="py-2 px-4 border-b">{{ $user->first_name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $user->last_name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                                    <td class="py-2 px-4 border-b">
                                        <form method="POST" action="{{ route('admin.users.approve', $user->id) }}"
                                            class="inline-block mr-2">
                                            @csrf
                                            <input type="submit" name="approve_user" value="Approve"
                                                class="bg-green-500 text-white py-1 px-2 rounded hover:bg-green-600">
                                        </form>
                                        <form method="POST" action="{{ route('admin.users.decline', $user->id) }}"
                                            class="inline-block">
                                            @csrf
                                            <input type="submit" name="decline_user" value="Decline"
                                                class="bg-red-500 text-white py-1 px-2 rounded hover:bg-red-600">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            @if ($pendingUsers->isEmpty())
                                <tr>
                                    <td colspan="5" class="py-2 px-4 border-b text-center">No pending approval
                                        requests.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- All Users Section -->
        <section>
            <h1
                class="text-2xl font-bold text-center bg-gradient-to-r from-green-500 to-green-800 text-white py-4 rounded">
                All Users</h1>
            <div class="bg-white p-6 shadow rounded mt-4">
                <p class="text-gray-700 text-center mb-4">This table displays all registered users.</p>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">User ID</th>
                                <th class="py-2 px-4 border-b">First Name</th>
                                <th class="py-2 px-4 border-b">Middle Name</th>
                                <th class="py-2 px-4 border-b">Last Name</th>
                                <th class="py-2 px-4 border-b">Phone</th>
                                <th class="py-2 px-4 border-b">Address</th>
                                <th class="py-2 px-4 border-b">Email</th>
                                <th class="py-2 px-4 border-b">DOB</th>
                                <th class="py-2 px-4 border-b">Gender</th>
                                <th class="py-2 px-4 border-b w-24">Profile Picture</th>
                                <th class="py-2 px-4 border-b">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $user->id }}</td>
                                    <td class="py-2 px-4 border-b">{{ $user->first_name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $user->middle_name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $user->last_name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $user->phone }}</td>
                                    <td class="py-2 px-4 border-b">{{ $user->address }}</td>
                                    <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                                    <td class="py-2 px-4 border-b">{{ $user->dob }}</td>
                                    <td class="py-2 px-4 border-b">{{ $user->gender }}</td>
                                    <td class="py-2 px-4 border-b w-24">
                                        @if ($user->user_pic)
                                            <img src="{{ asset('storage/profile_pics/' . $user->user_pic) }}"
                                                alt="Profile Picture"
                                                class="h-12 w-12 object-cover mx-auto rounded-full">
                                        @else
                                            <img src="{{ asset('icons/pi.png') }}" alt="Default Avatar"
                                                class="h-12 w-12 object-cover mx-auto rounded-full">
                                        @endif
                                    </td>
                                    <td class="py-2 px-4 border-b">
                                        <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}"
                                            class="inline-block" onsubmit="return confirmDelete();">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" value="Delete"
                                                class="bg-red-500 text-white py-1 px-2 rounded hover:bg-red-600">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>
</body>

</html>
