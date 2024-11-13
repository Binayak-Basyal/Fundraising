<div class="min-h-screen flex flex-col">
    <header class="bg-gray-800 py-4">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <!-- Logo and Mobile Menu Toggle -->
            <div class="flex items-center">
                <button class="text-white focus:outline-none md:hidden" aria-label="Toggle menu" onclick="toggleLeftMenu()">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
                <div class="md:hidden ml-5 flex justify-center">
                    <img src="/icons/fl.png" alt="Mobile Logo" class="h-12">
                </div>
                <img src="/icons/logo.png" alt="Logo" class="hidden md:block h-12">
            </div>

            <!-- Mobile Dropdown Menu -->
            <div class="absolute bg-white rounded-lg shadow-lg top-28 left-0 hidden w-60 z-50" id="leftMenu" aria-labelledby="menu-button">
                <div class="py-2">
                    <form action="" method="GET" class="block px-4 py-2">
                        <input type="search" size="20" name="searchTerm" placeholder="Search..."
                               class="bg-gray-700 text-white px-4 py-2 rounded-md w-full mb-2">
                    </form>
                    <a href="{{ route('home') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-200" onclick="toggleLeftMenu()">Home</a>
                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-200" onclick="toggleLeftMenu()">Categories</a>
                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-200" onclick="toggleLeftMenu()">Get Donation</a>
                </div>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex space-x-6">
                <a href="{{ route('home') }}" class="text-white hover:text-gray-300">Home</a>
                <a href="{{ route('allfunds') }}" class="text-white hover:text-gray-300">Campaign</a>
                <a href="{{ route('fundhere') }}" class="text-white hover:text-gray-300">Get Donation</a>
            </nav>

            <!-- Search, Cart, and User Profile -->
            <div class="flex items-center space-x-12">
                <!-- Search Form -->
                {{-- <form action="" method="GET" class="flex items-center bg-gray-700 text-white rounded-md p-1">
                    <input type="search" size="20" name="searchTerm" placeholder="Search..."
                           class="bg-gray-700 text-white px-3 py-1 rounded-l-md focus:outline-none w-full">
                    <button type="submit" class="p-2 rounded-r-md focus:outline-none">
                        <img src="/icons/search.png" alt="Search" class="h-6">
                    </button>
                </form> --}}

                <!-- User Profile -->
                <div class="relative">
                    @auth
                        <img src="{{ auth()->user()->user_pic ? asset('storage/profile_pics/' . auth()->user()->user_pic) : asset('icons/pi.png') }}"
                             alt="User" class="h-12 w-12 rounded-full cursor-pointer" onclick="toggleMenu()">
                             <span class="text-white ml-2">{{ auth()->user()->first_name }}</span>

                    @else
                        <img src="{{ asset('icons/pi.png') }}"
                             alt="User" class="h-12 w-12 rounded-full cursor-pointer" onclick="window.location.href = '{{ route('login') }}'">
                    @endauth

                    <div class="absolute bg-white rounded-lg shadow-lg top-18 right-0 hidden w-60 z-50" id="subMenu">
                        <div class="py-2">
                            @auth
                                <a href="{{ route('profile.index') }}"
                                   class="flex items-center px-4 py-2 text-gray-800 hover:bg-gray-200">
                                    <img src="/icons/profile.png" alt="Edit Profile" class="h-6 w-6 mr-2"> Edit Profile
                                </a>
                                <a href=""
                                   class="flex items-center px-4 py-2 text-gray-800 hover:bg-gray-200">
                                    <img src="/icons/setting.png" alt="Settings & Privacy" class="h-6 w-6 mr-2"> Settings & Privacy
                                </a>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                   class="flex items-center px-4 py-2 text-gray-800 hover:bg-gray-200">
                                    <img src="/icons/logout.png" alt="Logout" class="h-6 w-6 mr-2"> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="flex-grow">
        @yield('content')
    </div>
</div>

<!-- JavaScript Functions -->
<script>
    function toggleMenu() {
        const menu = document.getElementById('subMenu');
        menu.classList.toggle('hidden');
    }

    function toggleLeftMenu() {
        const leftMenu = document.getElementById("leftMenu");
        leftMenu.classList.toggle("hidden");
    }

    // Close the menus when clicking outside
    document.addEventListener('click', (event) => {
        const leftMenu = document.getElementById('leftMenu');
        const subMenu = document.getElementById('subMenu');
        if (!leftMenu.contains(event.target) && !event.target.matches('[onclick="toggleLeftMenu()"]')) {
            leftMenu.classList.add('hidden');
        }
        if (!subMenu.contains(event.target) && !event.target.matches('[onclick="toggleMenu()"]')) {
            subMenu.classList.add('hidden');
        }
    });
</script>
