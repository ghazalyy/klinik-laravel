<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dokter | @yield('title', 'Panel') — Klinik Orinda</title>
    
    <!-- Fonts: Outfit (Headings) & Inter (Body) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        h1, h2, h3, h4 { font-family: 'Outfit', sans-serif; }
        
        .sidebar-glass {
            background: linear-gradient(180deg, #1e3a8a 0%, #1e3a8a 100%);
            backdrop-filter: blur(12px);
        }
        
        .nav-active {
            background: rgba(255, 255, 255, 0.1);
            border-left: 4px solid #3b82f6;
            color: #fff !important;
        }

        .premium-card {
            background: #fff;
            border: 1px solid rgba(226, 232, 240, 0.6);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .premium-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.04);
            transform: translateY(-2px);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 20px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
    @stack('styles')
</head>
<body class="antialiased text-slate-900 overflow-hidden">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 sidebar-glass text-white hidden lg:flex flex-col flex-shrink-0 z-40">
            <div class="p-6 border-b border-white/5">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-blue-500 rounded-xl flex items-center justify-center font-bold text-lg shadow-lg">K</div>
                    <span class="text-xl font-extrabold tracking-tight text-white uppercase italic">Orinda</span>
                </a>
                <p class="text-[10px] uppercase tracking-[0.2em] text-blue-400 mt-2 font-bold opacity-70">Panel Dokter</p>
            </div>

            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
                <p class="text-[10px] text-blue-400 font-bold uppercase px-4 py-3 mt-2 opacity-50 tracking-widest">Main Menu</p>
                
                <a href="{{ route('dokter.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition text-sm text-blue-100 hover:bg-white/5 {{ request()->routeIs('dokter.dashboard') ? 'nav-active' : '' }}">
                    <span class="text-lg opacity-70">📊</span>
                    <span class="font-medium text-[13px]">Dashboard</span>
                </a>

                <a href="{{ route('dokter.riwayat') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition text-sm text-blue-100 hover:bg-white/5 {{ request()->routeIs('dokter.riwayat') ? 'nav-active' : '' }}">
                    <span class="text-lg opacity-70">👥</span>
                    <span class="font-medium text-[13px]">Riwayat Pasien</span>
                </a>

                <p class="text-[10px] text-blue-400 font-bold uppercase px-4 py-3 mt-6 opacity-50 tracking-widest">Konsultasi</p>
                <div class="px-4 py-2 bg-blue-800/30 rounded-xl border border-blue-500/20">
                    <p class="text-[11px] text-blue-200 leading-relaxed">Konsultasi online aktif akan muncul di dashboard secara otomatis.</p>
                </div>
            </nav>

            <div class="p-4 bg-black/20 mt-auto">
                <div class="flex items-center gap-3 mb-4 px-2">
                    <div class="w-9 h-9 rounded-full bg-blue-600 border border-blue-400/30 flex items-center justify-center font-bold text-xs">
                        {{ substr(auth()->user()->nama_lengkap, 0, 1) }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-[11px] font-bold truncate">{{ auth()->user()->nama_lengkap }}</p>
                        <p class="text-[10px] text-blue-300 opacity-70">Dokter Spesialis</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full py-2 bg-red-500/10 hover:bg-red-500/20 text-red-100/80 rounded-xl text-xs font-bold transition flex items-center justify-center gap-2 border border-red-500/20">
                        🚪 Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col h-screen overflow-hidden">
            <!-- Navbar -->
            <header class="bg-white/80 backdrop-blur-md border-b border-slate-200 px-8 py-4 flex items-center justify-between sticky top-0 z-30">
                <div class="flex flex-col">
                    <h2 class="text-lg font-extrabold text-slate-800 tracking-tight">@yield('title', 'Dashboard Overview')</h2>
                    <p class="text-[10px] text-slate-400 font-medium uppercase tracking-widest">{{ now()->translatedFormat('l, d F Y') }}</p>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="w-px h-6 bg-slate-200"></div>
                    <div class="w-8 h-8 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-xs">🔔</div>
                </div>
            </header>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto p-8">
                @if(session('success'))
                    <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl flex items-center gap-3 shadow-sm animate-in fade-in slide-in-from-top-4 duration-500">
                        <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center text-white text-xs">✓</div>
                        <p class="text-[13px] font-semibold">{{ session('success') }}</p>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mb-8 p-4 bg-rose-50 border border-rose-100 text-rose-700 rounded-2xl flex items-center gap-3 shadow-sm animate-in fade-in slide-in-from-top-4 duration-500">
                        <div class="w-8 h-8 bg-rose-500 rounded-lg flex items-center justify-center text-white text-xs">!</div>
                        <p class="text-[13px] font-semibold">{{ session('error') }}</p>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
</body>
</html>
