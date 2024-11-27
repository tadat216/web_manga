<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @cloudinaryJS
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Mobile menu button -->
        <div class="fixed top-0 left-0 z-50 block lg:hidden">
            <button id="mobile-menu-button" class="p-4 text-gray-600 hover:text-gray-900">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        <!-- Sidebar -->
        <div id="sidebar" class="fixed inset-y-0 left-0 w-64 bg-gray-800 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
            <div class="flex items-center justify-center h-16 bg-gray-900">
                <span class="text-white text-xl font-semibold">Quản trị viên</span>
            </div>
            
            <nav class="mt-5 px-2">
                <a href="{{ route('admin.home') }}" class="group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md text-white hover:bg-gray-700 transition ease-in-out duration-150">
                    <span>Trang chủ</span>
                </a>

                <a href="{{ route('user.home') }}" class="group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md text-white hover:bg-gray-700 transition ease-in-out duration-150">
                    <span>Trang người dùng</span>
                </a>

                {{-- Link quản lý truyện --}}
                <a href="{{ route('admin.books') }}" class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md text-white hover:bg-gray-700 transition ease-in-out duration-150">
                    <span>Quản lý truyện</span>
                </a>

                {{-- Link quản lý thể loại --}}
                <a href="{{ route('admin.genres') }}" class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md text-white hover:bg-gray-700 transition ease-in-out duration-150">
                    <span>Quản lý thể loại</span>
                </a>

                {{-- Link quản lý người dùng --}}
                <a href="{{ route('admin.users') }}" class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md text-white hover:bg-gray-700 transition ease-in-out duration-150">
                    <span>Quản lý người dùng</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="lg:pl-64">
            <!-- Top Navigation -->
            <nav class="bg-white shadow-sm">
                <div class="mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <div class="flex-shrink-0 flex items-center">
                                <!-- Logo -->
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="text-gray-600 hover:text-gray-900">
                                        Đăng xuất
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="py-10">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full');
        });
    </script>
    @yield('scripts')
</body>
</html>
