<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .error {
            border-color: red;
        }

        .error-bubble {
            display: none;
            position: absolute;
            background-color: red;
            color: #fff;
            padding: 5px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex flex-col items-center justify-center min-h-screen py-6">
        <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold">Sign up</h2>
            </div>
            <p class="text-sm text-gray-600 mb-4">It's quick and easy</p>
            <hr class="mb-4">
            <form id="signupForm" action="{{ url('/register') }}" method="POST">
                @csrf
                <div class="flex mb-4 space-x-2">
                    <div class="w-1/2">
                        <label for="fname" class="block text-sm font-medium text-gray-700">First Name</label>
                        <input type="text" name="first_name" id="fname" placeholder="First Name" class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
                        @error('first_name')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-1/2">
                        <label for="lname" class="block text-sm font-medium text-gray-700">Last Name</label>
                        <input type="text" name="last_name" id="lname" placeholder="Last Name" class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
                        @error('last_name')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="flex mb-4 space-x-2">
                    <div class="w-1/2">
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone No.</label>
                        <input type="text" name="phone" id="phone" placeholder="Phone Number" class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
                        @error('phone')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-1/2">
                        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                        <input type="text" name="address" id="address" placeholder="Your Address" class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
                        @error('address')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="flex mb-4 space-x-2">
                    <div class="w-1/2">
                        <label for="dob" class="block text-sm font-medium text-gray-700">Birthday</label>
                        <input type="date" name="dob" id="dob" class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
                        @error('dob')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-1/2">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" placeholder="Your Email" class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
                        @error('email')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="flex mb-4 space-x-2">
                    <div class="w-1/2">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" id="password" placeholder="Password" class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
                        @error('password')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-1/2">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
                    </div>
                </div>
                <div class="mt-6">
                    <input type="submit" value="Sign Up" class="w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded-md cursor-pointer">
                </div>
            </form>
            <hr class="my-4">
            <div class="text-center">
                <a href="{{ url('/login') }}" class="py-2 px-4 bg-gray-200 text-gray-700 font-semibold rounded-md cursor-pointer">LOG IN</a>
            </div>
        </div>
    </div>
</body>

</html>
