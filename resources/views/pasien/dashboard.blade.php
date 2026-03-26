@extends('layouts.pasien')
@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h3 class="text-2xl font-bold text-slate-800">Halo, {{ $user->nama_lengkap }}!</h3>
    <p class="text-slate-500 text-sm mt-1">Gunakan dashboard ini untuk memantau kesehatan dan jadwal konsultasi Anda.</p>
</div>

<!-- Stat Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="premium-card p-6 rounded-2xl border-l-4 border-l-blue-500">
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Booking Aktif</p>
        <h4 class="text-3xl font-extrabold text-slate-800">{{ $bookingAktif }}</h4>
    </div>
    <div class="premium-card p-6 rounded-2xl border-l-4 border-l-emerald-500">
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Konsultasi Selesai</p>
        <h4 class="text-3xl font-extrabold text-slate-800">{{ $bookingSelesai }}</h4>
    </div>
    <div class="premium-card p-6 rounded-2xl border-l-4 border-l-amber-500">
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Antrean Offline</p>
        <h4 class="text-3xl font-extrabold text-slate-800">{{ $antreanAktif }}</h4>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <a href="{{ route('pasien.booking.index') }}" class="group relative overflow-hidden bg-blue-600 rounded-2xl p-8 hover:shadow-xl hover:shadow-blue-200 transition-all duration-300">
        <div class="relative z-10 flex items-center gap-6 text-white">
            <span class="text-5xl transition-transform group-hover:scale-110 duration-300">📅</span>
            <div>
                <p class="font-extrabold text-xl tracking-tight">Booking Konsultasi</p>
                <p class="text-blue-100 text-sm mt-1">Pilih dokter spesialis & jadwal terbaik</p>
            </div>
        </div>
        <!-- Decorative Circle -->
        <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-white/10 rounded-full"></div>
    </a>
    
    <a href="{{ route('pasien.antrean.index') }}" class="group relative overflow-hidden bg-amber-500 rounded-2xl p-8 hover:shadow-xl hover:shadow-amber-200 transition-all duration-300">
        <div class="relative z-10 flex items-center gap-6 text-white">
            <span class="text-5xl transition-transform group-hover:scale-110 duration-300">🎫</span>
            <div>
                <p class="font-extrabold text-xl tracking-tight">Antrean Offline</p>
                <p class="text-amber-50 text-sm mt-1">Ambil nomor antrean walk-in klinik</p>
            </div>
        </div>
        <!-- Decorative Circle -->
        <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-white/10 rounded-full"></div>
    </a>
</div>

<!-- Booking Terbaru -->
<div class="flex items-center justify-between mb-4 mt-12">
    <h3 class="text-lg font-extrabold text-slate-800 tracking-tight">Riwayat Booking Terbaru</h3>
    <a href="{{ route('pasien.booking.riwayat') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 uppercase tracking-wider transition">Lihat Semua →</a>
</div>

@if($bookingsTerbaru->isEmpty())
    <div class="premium-card rounded-2xl p-12 text-center">
        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">📋</div>
        <h4 class="text-slate-800 font-bold">Belum Ada Riwayat</h4>
        <p class="text-slate-500 text-sm mt-1">Anda belum melakukan booking konsultasi apapun.</p>
    </div>
@else
    <div class="premium-card rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Dokter</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tanggal</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pembayaran</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Status Sesi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($bookingsTerbaru as $b)
                    <tr class="hover:bg-slate-50/50 transition duration-200">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs">
                                    {{ substr($b->dokter->user->nama_lengkap, 0, 1) }}
                                </div>
                                <span class="font-bold text-slate-700">{{ $b->dokter->user->nama_lengkap }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-slate-600 font-semibold">{{ $b->tanggal_booking->format('d M Y') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-[10px] font-bold uppercase tracking-widest px-2.5 py-1 rounded-md
                                {{ $b->status_pembayaran === 'lunas' ? 'bg-emerald-50 text-emerald-600' :
                                   ($b->status_pembayaran === 'ditolak' ? 'bg-rose-50 text-rose-600' : 'bg-amber-50 text-amber-600') }}">
                                {{ $b->status_pembayaran }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-[10px] font-bold uppercase tracking-widest px-2.5 py-1 rounded-md bg-blue-50 text-blue-600 border border-blue-100">
                                {{ $b->status_sesi }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection
