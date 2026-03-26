<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Klinik Pratama Orinda')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'] } } } }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="flex items-center gap-2 font-bold text-xl text-blue-700">
                    🏥 Klinik Pratama Orinda
                </a>
                <div class="hidden md:flex items-center gap-6 text-sm font-medium">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600 transition">Beranda</a>
                    <a href="{{ route('jadwal') }}" class="text-gray-600 hover:text-blue-600 transition">Jadwal</a>
                    <a href="{{ route('tentang') }}" class="text-gray-600 hover:text-blue-600 transition">Tentang</a>
                    @auth
                        <a href="{{ route('profil') }}" class="text-gray-600 hover:text-blue-600 transition">{{ Auth::user()->nama_lengkap }}</a>
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Dashboard Admin</a>
                        @elseif(Auth::user()->role === 'dokter')
                            <a href="{{ route('dokter.dashboard') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">Dashboard Dokter</a>
                        @else
                            <a href="{{ route('pasien.dashboard') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Dashboard</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">@csrf
                            <button type="submit" class="text-gray-500 hover:text-red-600 transition">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 transition">Login</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-lg flex items-center gap-2">
                ✅ {{ session('success') }}
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-lg flex items-center gap-2">
                ❌ {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-16 py-10">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-lg font-bold">🏥 Klinik Pratama Orinda</p>
            <p class="text-gray-400 text-sm mt-2">Kesehatan Anda adalah Prioritas Kami</p>
            <p class="text-gray-500 text-xs mt-4">© {{ date('Y') }} Klinik Pratama Orinda. All rights reserved.</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
