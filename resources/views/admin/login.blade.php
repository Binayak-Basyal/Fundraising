<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="flex flex-col items-center justify-center min-h-screen py-6">
        <!-- Login Form -->
        <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-md" id="loginPage">
            <div class="mb-4 text-center">
                <h2 class="text-2xl font-bold">Log In</h2>
            </div>
            <hr class="mb-4">
            
            <!-- Success Message -->
            @if(session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-4">
                {{ session('success') }}
            </div>
            @endif
            
            <form action="{{ route('admin.login') }}" method="POST" class="mt-6">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" placeholder="something@gmail.com" class="mt-1 p-2 block w-full border rounded-md @error('email') border-red-500 @enderror" value="{{ old('email') }}" required>
                    @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" placeholder="Password" class="mt-1 p-2 block w-full border rounded-md @error('password') border-red-500 @enderror" required>
                    @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <input type="submit" value="LOG IN" class="w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded-md cursor-pointer">
                </div>
            </form>
            
        </div>
    </div>
</body>

</html>
