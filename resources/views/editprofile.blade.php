<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="container mx-auto px-4 py-6">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Edit Profile</h2>

        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name) }}"
                       class="mt-1 p-2 block w-full border rounded-lg">
            </div>

            <div class="mb-4">
                <label for="middle_name" class="block text-sm font-medium text-gray-700">Middle Name</label>
                <input type="text" name="middle_name" id="middle_name" value="{{ old('middle_name', $user->middle_name) }}"
                       class="mt-1 p-2 block w-full border rounded-lg">
            </div>

            <div class="mb-4">
                <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $user->last_name) }}"
                       class="mt-1 p-2 block w-full border rounded-lg">
            </div>

            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                       class="mt-1 p-2 block w-full border rounded-lg">
            </div>

            <div class="mb-4">
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <input type="text" name="address" id="address" value="{{ old('address', $user->address) }}"
                       class="mt-1 p-2 block w-full border rounded-lg">
            </div>

            <div class="mb-4">
                <label for="dob" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                <input type="date" name="dob" id="dob" value="{{ old('dob', $user->dob) }}"
                       class="mt-1 p-2 block w-full border rounded-lg">
            </div>

            <div class="mb-4">
                <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                <select name="gender" id="gender" class="mt-1 p-2 block w-full border rounded-lg">
                    <option value="">Select Gender</option>
                    <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="user_pic" class="block text-sm font-medium text-gray-700">Profile Picture</label>
                <input type="file" name="user_pic" id="user_pic" class="mt-1 p-2 block w-full border rounded-lg">

                @if($user->user_pic)
                    <img src="{{ asset('storage/' . $user->user_pic) }}" alt="Profile Picture" class="mt-2 mb-2 rounded-md w-24 h-24 object-cover">
                @endif
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-lg shadow-md hover:bg-blue-700">
                    Update Profile
                </button>
            </div>
        </form>

        <!-- Change Password -->
        <hr class="my-6">
        <h2 class="text-2xl font-bold mb-4">Change Password</h2>

        <form action="{{ route('profile.change-password') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                <input type="password" name="current_password" id="current_password" class="mt-1 p-2 block w-full border rounded-lg">
            </div>

            <div class="mb-4">
                <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                <input type="password" name="new_password" id="new_password" class="mt-1 p-2 block w-full border rounded-lg">
            </div>

            <div class="mb-4">
                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="mt-1 p-2 block w-full border rounded-lg">
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full bg-yellow-600 text-white p-3 rounded-lg shadow-md hover:bg-yellow-700">
                    Change Password
                </button>
            </div>
        </form>

        <!-- Delete Account -->
        <hr class="my-6">
        <h2 class="text-2xl font-bold mb-4">Delete Account</h2>

        <form action="{{ route('profile.delete') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
            @csrf

            <div class="mt-6">
                <button type="submit" class="w-full bg-red-600 text-white p-3 rounded-lg shadow-md hover:bg-red-700">
                    Delete Account
                </button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
