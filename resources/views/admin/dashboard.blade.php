@extends('layouts.admin')
@section('title', 'Dashboard Admin')

@section('content')
<!-- Stat Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
    @php
    $cards = [
        ['label' => 'Total Pasien',     'value' => $totalPasien,    'icon' => '👥', 'color' => 'bg-blue-500'],
        ['label' => 'Total Dokter',     'value' => $totalDokter,    'icon' => '👨‍⚕️', 'color' => 'bg-green-500'],
        ['label' => 'Total Booking',    'value' => $totalBooking,   'icon' => '📅', 'color' => 'bg-purple-500'],
        ['label' => 'Menunggu Bayar',   'value' => $pendingBayar,   'icon' => '⏳', 'color' => 'bg-yellow-500'],
        ['label' => 'Antrean Hari Ini', 'value' => $totalAntrean,  'icon' => '🎫', 'color' => 'bg-orange-500'],
        ['label' => 'Total Pendapatan', 'value' => 'Rp '.number_format($totalPendapatan,0,',','.'), 'icon' => '💰', 'color' => 'bg-red-500'],
    ];
    @endphp

    @foreach($cards as $card)
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 {{ str_replace('bg-', 'border-', $card['color']) }}">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">{{ $card['label'] }}</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $card['value'] }}</p>
            </div>
            <span class="text-3xl">{{ $card['icon'] }}</span>
        </div>
    </div>
    @endforeach
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    <a href="{{ route('admin.crm.dashboard') }}" class="bg-blue-600 text-white rounded-xl p-6 hover:bg-blue-700 transition">
        <div class="text-3xl mb-2">📈</div>
        <p class="font-semibold">CRM Dashboard</p>
        <p class="text-blue-200 text-sm">Analitik pasien</p>
    </a>
    <a href="{{ route('admin.spk') }}" class="bg-purple-600 text-white rounded-xl p-6 hover:bg-purple-700 transition">
        <div class="text-3xl mb-2">🏆</div>
        <p class="font-semibold">SPK Dokter</p>
        <p class="text-purple-200 text-sm">Ranking dokter terbaik</p>
    </a>
    <a href="{{ route('admin.pembayaran.verifikasi') }}" class="bg-yellow-500 text-white rounded-xl p-6 hover:bg-yellow-600 transition">
        <div class="text-3xl mb-2">💳</div>
        <p class="font-semibold">Verifikasi Bayar</p>
        <p class="text-yellow-100 text-sm">{{ $pendingBayar }} transaksi pending</p>
    </a>
    <a href="{{ route('admin.pengguna.index') }}" class="bg-green-600 text-white rounded-xl p-6 hover:bg-green-700 transition">
        <div class="text-3xl mb-2">👥</div>
        <p class="font-semibold">Kelola Pengguna</p>
        <p class="text-green-200 text-sm">Manajemen akun</p>
    </a>
</div>
@endsection
