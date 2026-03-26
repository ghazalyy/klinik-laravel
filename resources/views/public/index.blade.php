@extends('layouts.app')
@section('title', 'Beranda')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-blue-700 to-blue-900 text-white py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <h1 class="text-5xl font-extrabold leading-tight mb-6">
                Kesehatan Anda<br>adalah <span class="text-yellow-300">Prioritas Kami</span>
            </h1>
            <p class="text-xl text-blue-100 mb-8">Konsultasikan kesehatan Anda dengan dokter-dokter terbaik kami secara online maupun offline. Mudah, cepat, dan terpercaya.</p>
            <div class="flex flex-wrap gap-4">
                @auth
                    <a href="{{ route('pasien.booking.index') }}" class="bg-yellow-400 text-blue-900 font-bold px-8 py-4 rounded-xl hover:bg-yellow-300 transition shadow-lg">
                        📅 Booking Sekarang
                    </a>
                    <a href="{{ route('jadwal') }}" class="border-2 border-white text-white font-semibold px-8 py-4 rounded-xl hover:bg-white hover:text-blue-900 transition">
                        Lihat Jadwal
                    </a>
                @else
                    <a href="{{ route('register') }}" class="bg-yellow-400 text-blue-900 font-bold px-8 py-4 rounded-xl hover:bg-yellow-300 transition shadow-lg">
                        Mulai Sekarang
                    </a>
                    <a href="{{ route('login') }}" class="border-2 border-white text-white font-semibold px-8 py-4 rounded-xl hover:bg-white hover:text-blue-900 transition">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </div>
</section>

<!-- Stats -->
<section class="bg-white py-12 shadow-sm">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div>
                <p class="text-4xl font-bold text-blue-700">{{ $allDokters->count() }}+</p>
                <p class="text-gray-500 text-sm mt-1">Dokter Berpengalaman</p>
            </div>
            <div>
                <p class="text-4xl font-bold text-blue-700">1000+</p>
                <p class="text-gray-500 text-sm mt-1">Pasien Dilayani</p>
            </div>
            <div>
                <p class="text-4xl font-bold text-blue-700">24/7</p>
                <p class="text-gray-500 text-sm mt-1">Layanan Online</p>
            </div>
            <div>
                <p class="text-4xl font-bold text-blue-700">100%</p>
                <p class="text-gray-500 text-sm mt-1">Terverifikasi</p>
            </div>
        </div>
    </div>
</section>

<!-- Layanan -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Layanan Kami</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-md transition text-center">
                <div class="text-5xl mb-4">💻</div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Konsultasi Online</h3>
                <p class="text-gray-500 text-sm">Chat langsung dengan dokter dari kenyamanan rumah Anda. Bayar mudah via Midtrans.</p>
            </div>
            <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-md transition text-center">
                <div class="text-5xl mb-4">🏥</div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Kunjungan Langsung</h3>
                <p class="text-gray-500 text-sm">Ambil nomor antrean online, datang di waktu yang tepat tanpa antri lama.</p>
            </div>
            <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-md transition text-center">
                <div class="text-5xl mb-4">⭐</div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Dokter Terverifikasi</h3>
                <p class="text-gray-500 text-sm">Sistem SPK kami memastikan Anda mendapatkan dokter terbaik berdasarkan rating pasien.</p>
            </div>
        </div>
    </div>
</section>

<!-- Dokter Online -->
@if($dokters->isNotEmpty())
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Dokter Tersedia Sekarang</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($dokters->take(6) as $d)
            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center text-2xl">👨‍⚕️</div>
                    <div>
                        <p class="font-semibold text-gray-800">{{ $d->user->nama_lengkap }}</p>
                        <p class="text-sm text-gray-500">{{ $d->spesialisasi }}</p>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-green-600 bg-green-100 px-3 py-1 rounded-full">🟢 Online</span>
                    <span class="text-blue-600 font-semibold text-sm">Rp {{ number_format($d->harga_sesi, 0, ',', '.') }}</span>
                </div>
                @auth
                    <a href="{{ route('pasien.booking.index') }}" class="block mt-4 text-center bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition text-sm">Booking Sekarang</a>
                @else
                    <a href="{{ route('login') }}" class="block mt-4 text-center bg-gray-100 text-gray-600 py-2 rounded-lg hover:bg-blue-600 hover:text-white transition text-sm">Login untuk Booking</a>
                @endauth
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
