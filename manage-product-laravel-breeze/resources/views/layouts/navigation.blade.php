<nav class="sticky  top-0 right-0 z-50 w-full  bg-white border-b border-gray-200 shadow-sm">
    <div class="px-4 py-3 lg:px-6">
        <div class="flex items-center justify-between">
            <!-- Mobile sidebar toggle -->
            <div class="flex items-center">
                <button type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
                    data-drawer-target="top-bar-sidebar" data-drawer-toggle="top-bar-sidebar"
                    aria-controls="top-bar-sidebar">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                        </path>
                    </svg>
                </button>

                <div class="ml-3 md:ml-0 flex items-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/7708/7708151.png" class="mr-3 h-6 sm:h-9" alt="Logo" />
                    <h1 class="text-lg font-bold text-gray-800">Online Shop Admin</h1>
                </div>
            </div>

            <!-- Right side: user menu -->
            <div class="flex items-center space-x-4">
                <!-- User dropdown -->
                <div class="relative">
                    <button type="button"
                        class="flex items-center text-sm rounded-full focus:ring-2 focus:ring-blue-300"
                        id="user-menu-button" data-dropdown-toggle="user-dropdown" data-dropdown-offset-distance="10"
                        data-dropdown-offset-skidding="0">
                        <span class="sr-only">Open user menu</span>
                        <div
                            class="w-8 h-8 rounded-full bg-black flex items-center justify-center text-white font-semibold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    </button>

                    <!-- Dropdown menu -->
                    <div class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50"
                        id="user-dropdown">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                            <p class="text-sm text-gray-500 truncate">{{ Auth::user()->email }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>

                        <div class="border-t border-gray-100"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                Sign out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
