<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Trang đọc truyện</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between">
                <div class="flex space-x-7">
                    <!-- Logo -->
                    <div>
                        <a href="/" class="flex items-center py-4">
                            <span class="font-bold text-xl text-gray-700">TruyệnHay</span>
                        </a>
                    </div>

                    <!-- Nav Links -->
                    <div class="hidden md:flex items-center space-x-1">
                        <a href="/" class="py-4 px-2 text-gray-700 hover:text-blue-500 transition duration-300">Trang chủ</a>
                        
                        <!-- Dropdown Thể loại -->
                        <div class="relative group">
                            <button class="py-4 px-2 text-gray-700 hover:text-blue-500 transition duration-300 flex items-center">
                                Thể loại
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            
                            <!-- Dropdown menu -->
                            <div class="absolute hidden group-hover:block w-48 bg-white shadow-lg py-2 rounded-md">
                                @foreach($genres as $genre)
                                    <a href="#" 
                                       class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        {{ $genre->title }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button class="outline-none mobile-menu-button">
                        <svg class="w-6 h-6 text-gray-500 hover:text-blue-500"
                            fill="none" stroke-linecap="round" 
                            stroke-linejoin="round" stroke-width="2" 
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="hidden mobile-menu md:hidden">
            <a href="/" class="block py-2 px-4 text-sm hover:bg-gray-100">Trang chủ</a>
            <div class="relative">
                <button class="block w-full text-left py-2 px-4 text-sm hover:bg-gray-100">
                    Thể loại
                </button>
                <div class="hidden px-4 py-2">
                    @foreach($genres as $genre)
                        <a href="#" 
                           class="block py-2 text-sm hover:text-blue-500">
                            {{ $genre->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Heading -->
    @isset($header)
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    <!-- Page Content -->
    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <script>
        // Mobile menu toggle
        const btn = document.querySelector("button.mobile-menu-button");
        const menu = document.querySelector(".mobile-menu");
        
        btn.addEventListener("click", () => {
            menu.classList.toggle("hidden");
        });
    </script>
</body>
</html>
