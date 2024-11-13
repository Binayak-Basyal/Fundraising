<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .error {
            border-color: #f56565;
        }

        .error-bubble {
            display: none;
            position: absolute;
            background-color: #f56565;
            color: #fff;
            padding: 5px;
            border-radius: 4px;
            font-size: 12px;`
            white-space: nowrap;
        }

        .overlay {
            background-color: rgba(0, 0, 0, 0.5);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 999;
        }

        .modal-content {
            max-width: 900px;
            margin: auto;
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="relative max-w-4xl mx-auto p-6">
        <!-- Back Button -->
        <a href="{{ asset('/') }}"
            class="absolute top-6 left-6 bg-blue-600 text-white py-2 px-4 rounded-full shadow-md hover:bg-blue-700 transition">Back</a>

        <!-- Profile Display -->
        <div id="profile" class="bg-white p-8 rounded-lg shadow-lg">
            <div class="flex flex-col items-center">
                <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-blue-500 mb-4">
                    @if (Auth::user()->user_pic)
                        <img src="{{ asset('storage/profile_pics/' . Auth::user()->user_pic) }}" alt="Profile Picture"
                            class="w-full h-full object-cover">
                    @else
                        <img src="https://via.placeholder.com/150" alt="Placeholder" class="w-full h-full object-cover">
                    @endif
                </div>
                <h1 class="text-4xl font-bold text-gray-800">{{ Auth::user()->name }}</h1>
                <p class="text-lg text-gray-600 mt-1">{{ Auth::user()->bio }}</p>
            </div>
            <hr class="my-6 border-gray-300">
            <div class="space-y-4">
                @foreach ([['Name', Auth::user()->first_name . ' ' . Auth::user()->middle_name . ' ' . Auth::user()->last_name], ['Phone Number', Auth::user()->phone], ['Date of Birth', Auth::user()->dob], ['Email', Auth::user()->email], ['Gender', Auth::user()->gender], ['Address', Auth::user()->address]] as [$label, $value])
                    <div class="flex justify-between items-center">
                        <h2 class="text-lg font-medium text-gray-800">{{ $label }}:</h2>
                        <span class="ml-2 text-gray-600">{{ $value }}</span>
                    </div>
                @endforeach
            </div>
            <div class="mt-6 text-center">
                <button id="makeVisible"
                    class="bg-blue-600 text-white py-2 px-6 rounded-full shadow-md hover:bg-blue-700 transition"
                    onclick="toggleEdit()">Edit Profile</button>
            </div>
        </div>

        <!-- Edit Profile Form -->
        <div id="editpage"
            class="overlay flex justify-center items-center bg-gray-900 bg-opacity-50 fixed inset-0 z-50">
            <div
                class="bg-white p-6 rounded-lg shadow-lg modal-content relative max-w-md mx-auto overflow-auto max-h-screen">
                <button id="closeEdit" class="absolute top-4 right-4 text-red-600 hover:text-red-800 text-2xl"
                    onclick="toggleEdit()">&times;</button>
                <h2 class="text-2xl font-bold mb-4 text-gray-800">Edit Profile</h2>
                <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div class="flex flex-col items-center">
                        <div class="relative w-24 h-24 mb-4">
                            <input type="file" id="userPicInput" name="user_pic" accept="image/*"
                                class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewImage()">
                            <label for="userPicInput"
                                class="w-24 h-24 rounded-full border-4 border-blue-500 cursor-pointer overflow-hidden flex items-center justify-center bg-gray-100">
                                <img id="imagePreviewImg"
                                    src="{{ Auth::user()->user_pic ? asset('storage/profile_pics/' . Auth::user()->user_pic) : 'https://via.placeholder.com/150' }}"
                                    alt="Profile Picture" class="w-full h-full object-cover">
                                <span
                                    class="absolute inset-0 flex items-center justify-center text-white text-xl font-semibold bg-black bg-opacity-50 transition-opacity duration-300 hover:opacity-0">+</span>
                            </label>
                            <p id="fileName" class="mt-2 text-gray-600">
                                {{ old('user_pic', Auth::user()->user_pic ? basename(Auth::user()->user_pic) : 'No file chosen') }}
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row md:space-x-4">
                        <div class="flex-1 mb-4">
                            <label for="first_name" class="block text-gray-700 font-medium mb-1">First Name</label>
                            <input type="text" name="first_name" id="first_name"
                                class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500"
                                value="{{ old('first_name', Auth::user()->first_name) }}" placeholder="First Name">
                        </div>
                        <div class="flex-1 mb-4">
                            <label for="middle_name" class="block text-gray-700 font-medium mb-1">Middle Name</label>
                            <input type="text" name="middle_name" id="middle_name"
                                class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500"
                                value="{{ old('middle_name', Auth::user()->middle_name) }}" placeholder="Middle Name">
                        </div>
                        <div class="flex-1 mb-4">
                            <label for="last_name" class="block text-gray-700 font-medium mb-1">Last Name</label>
                            <input type="text" name="last_name" id="last_name"
                                class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500"
                                value="{{ old('last_name', Auth::user()->last_name) }}" placeholder="Last Name">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="phone" class="block text-gray-700 font-medium mb-1">Phone Number</label>
                        <input type="text" name="phone" id="phone"
                            class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500"
                            value="{{ old('phone', Auth::user()->phone) }}" placeholder="Phone Number">
                    </div>
                    <div class="mb-4">
                        <label for="dob" class="block text-gray-700 font-medium mb-1">Date of Birth</label>
                        <input type="date" name="dob" id="dob"
                            class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500"
                            value="{{ old('dob', Auth::user()->dob) }}" placeholder="Date of Birth">
                    </div>
                    <div class="mb-4">
                        <span class="block text-gray-700 font-medium mb-1">Gender</span>
                        <div class="flex space-x-6">
                            @foreach (['Male', 'Female', 'Other'] as $gender)
                                <div class="flex items-center">
                                    <input type="radio" name="gender" id="gender_{{ strtolower($gender) }}"
                                        value="{{ $gender }}" class="h-4 w-4 text-blue-500"
                                        {{ old('gender', Auth::user()->gender) == $gender ? 'checked' : '' }}>
                                    <label for="gender_{{ strtolower($gender) }}"
                                        class="ml-2 text-gray-700">{{ $gender }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="address" class="block text-gray-700 font-medium mb-1">Address</label>
                        <input type="text" name="address" id="address"
                            class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500"
                            value="{{ old('address', Auth::user()->address) }}" placeholder="Address">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-blue-600 text-white py-2 px-6 rounded-full shadow-md hover:bg-blue-700 transition">Save
                            Changes</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- <!-- Change Password Form -->
        <div id="passwordChangeForm" class="mt-8">
            <div class="bg-white p-8 rounded-lg shadow-lg max-w-4xl mx-auto">
                <h2 class="text-2xl font-semibold mb-6 text-gray-800">Change Password</h2>
                <form action="{{ route('password.change') }}" method="post" class="space-y-6"
                    onsubmit="return validatePasswordForm()">
                    @csrf
                    <div>
                        <label for="oldPassword" class="block text-gray-700 font-semibold mb-2">Old Password</label>
                        <input type="password" name="old_password" id="oldPassword"
                            class="w-full p-3 border rounded-lg focus:outline-none focus:border-blue-500"
                            placeholder="Enter your old password">
                    </div>
                    <div>
                        <label for="newPassword" class="block text-gray-700 font-semibold mb-2">New Password</label>
                        <input type="password" name="new_password" id="newPassword"
                            class="w-full p-3 border rounded-lg focus:outline-none focus:border-blue-500"
                            placeholder="Enter a new password">
                        <div class="error-bubble">Password must be at least 8 characters long</div>
                    </div>
                    <div>
                        <label for="confirmPassword" class="block text-gray-700 font-semibold mb-2">Confirm
                            Password</label>
                        <input type="password" name="confirm_password" id="confirmPassword"
                            class="w-full p-3 border rounded-lg focus:outline-none focus:border-blue-500"
                            placeholder="Confirm your new password">
                        <div class="error-bubble">Passwords do not match</div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-blue-600 text-white py-2 px-4 rounded-lg shadow-md hover:bg-blue-700 transition">Change
                            Password</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Account Section -->
        <div id="deleteAccount" class="mt-8 max-w-4xl mx-auto">
            <div class="bg-white p-8 rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold mb-6 text-gray-800">Delete Account</h2>
                <form action="{{ route('profile.destroy') }}" method="post" class="space-y-4">
                    @csrf
                    @method('DELETE')
                    <p class="text-gray-700">Are you sure you want to delete your account? This action cannot be
                        undone.
                    </p>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-red-600 text-white py-2 px-4 rounded-lg shadow-md hover:bg-red-700 transition">Delete
                            Account</button>
                    </div>
                </form>
            </div>
        </div> --}}
    </div>

    <script>
        function toggleEdit() {
            const profile = document.getElementById('profile');
            const editPage = document.getElementById('editpage');
            const overlay = document.querySelector('.overlay');

            if (profile.style.display === 'none') {
                profile.style.display = 'block';
                overlay.style.display = 'none';
            } else {
                profile.style.display = 'none';
                overlay.style.display = 'flex';
            }
        }

        function previewImage() {
            const fileInput = document.getElementById('userPicInput');
            const previewImg = document.getElementById('imagePreviewImg');
            const fileName = document.getElementById('fileName');

            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                }

                reader.readAsDataURL(fileInput.files[0]);
                fileName.textContent = fileInput.files[0].name;
            } else {
                previewImg.src = 'https://via.placeholder.com/150';
                fileName.textContent = 'No file chosen';
            }
        }
    </script>
</body>

</html>
