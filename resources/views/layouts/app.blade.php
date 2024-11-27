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
  <nav class="bg-white shadow-lg relative z-50">
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
              <div class="absolute hidden group-hover:block bg-white shadow-lg py-2 rounded-md z-50"
                style="width: 800px">
                <div class="grid grid-cols-4 gap-2">
                  @foreach ($genres->chunk(8) as $genreChunk)
                    <div class="px-1">
                      @foreach ($genreChunk as $genre)
                        <a href="{{ route('user.genres.show', $genre->id) }}"
                          class="block px-3 py-1 text-sm text-gray-700 hover:bg-gray-100 whitespace-nowrap">
                          {{ $genre->title }}
                        </a>
                      @endforeach
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Auth Links -->
        <div class="hidden md:flex items-center space-x-3">
          @auth
            <div class="relative group">
              <button
                class="flex items-center space-x-1 py-4 px-2 text-gray-700 hover:text-blue-500 transition duration-300">
                <span>{{ Auth::user()->name }}</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </button>
              <div class="absolute hidden group-hover:block right-0 bg-white shadow-lg py-2 rounded-md w-48">

                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                  Trang cá nhân
                </a>
                @role('admin')
                  <a href="{{ route('admin.home') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Trang quản trị
                  </a>
                @endrole
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Đăng xuất
                  </button>
                </form>
              </div>
            </div>
          @else
            <a href="{{ route('login') }}"
              class="py-2 px-4 text-gray-700 hover:text-blue-500 transition duration-300">Đăng nhập</a>
            <a href="{{ route('register') }}"
              class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-600 transition duration-300">Đăng ký</a>
          @endauth
        </div>

        <!-- Mobile menu button -->
        <div class="md:hidden flex items-center">
          <button class="outline-none mobile-menu-button">
            <svg class="w-6 h-6 text-gray-500 hover:text-blue-500" fill="none" stroke-linecap="round"
              stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
              <path d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile menu -->
    <div class="hidden mobile-menu md:hidden">
      <a href="/" class="block py-2 px-4 text-sm hover:bg-gray-100">Trang chủ</a>
      <div class="relative" x-data="{ open: false }">
        <button @click="open = !open"
          class="block w-full text-left py-2 px-4 text-sm hover:bg-gray-100 flex justify-between items-center">
          <span>Thể loại</span>
          <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>
        <div class="bg-gray-50" x-show="open" style="display: none">
          @foreach ($genres as $genre)
            <a href="{{ route('user.genres.show', $genre->id) }}"
              class="block py-2 px-6 text-sm text-gray-700 hover:bg-gray-100">
              {{ $genre->title }}
            </a>
          @endforeach
        </div>
      </div>
      @auth

        <a href="{{ route('profile.edit') }}" class="block py-2 px-4 text-sm hover:bg-gray-100">Trang cá nhân</a>
        @role('admin')
          <a href="{{ route('admin.home') }}" class="block py-2 px-4 text-sm hover:bg-gray-100">Trang quản trị</a>
        @endrole
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="w-full text-left py-2 px-4 text-sm hover:bg-gray-100">
            Đăng xuất
          </button>
        </form>
      @else
        <a href="{{ route('login') }}" class="block py-2 px-4 text-sm hover:bg-gray-100">Đăng nhập</a>
        <a href="{{ route('register') }}" class="block py-2 px-4 text-sm hover:bg-gray-100">Đăng ký</a>
      @endauth
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
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
      <!-- Nội dung chính (3/4) -->
      <div class="md:col-span-3">
        @yield('content')
      </div>

      <!-- Sidebar (1/4) -->
      <div class="md:col-span-1">
        @yield('sidebar')
      </div>
    </div>
  </main>

  <script>
    // Mobile menu toggle
    const btn = document.querySelector("button.mobile-menu-button");
    const menu = document.querySelector(".mobile-menu");

    btn.addEventListener("click", () => {
      menu.classList.toggle("hidden");
    });

    // Mobile genre dropdown toggle
    const genreBtn = document.querySelector(".mobile-menu button");
    const genreMenu = document.querySelector(".mobile-menu .bg-gray-50");

    genreBtn.addEventListener("click", () => {
      genreMenu.style.display = genreMenu.style.display === "none" ? "block" : "none";
      genreBtn.querySelector("svg").classList.toggle("rotate-180");
    });
  </script>
</body>

</html>
