@extends('layouts.dokter')
@section('title', 'Dashboard Dokter')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h3 class="text-2xl font-bold text-slate-800">Halo, dr. {{ $dokter->user->nama_lengkap }}</h3>
        <p class="text-slate-500 text-sm mt-1">Spesialisasi: <span class="font-semibold text-blue-600">{{ $dokter->spesialisasi }}</span></p>
    </div>
    <div class="bg-blue-50 px-4 py-2 rounded-xl border border-blue-100 flex items-center gap-3">
        <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
        <span class="text-xs font-bold text-blue-700 uppercase tracking-wider">Status: Online</span>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="premium-card p-6 rounded-2xl">
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total Pasien Hari Ini</p>
        <h4 class="text-3xl font-extrabold text-slate-800">{{ $bookingsHariIni->count() }}</h4>
    </div>
    <div class="premium-card p-6 rounded-2xl border-l-4 border-l-blue-500">
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Sesi Aktif</p>
        <h4 class="text-3xl font-extrabold text-blue-600">{{ $bookingsHariIni->where('status_sesi', 'aktif')->count() }}</h4>
    </div>
    <div class="premium-card p-6 rounded-2xl">
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Menunggu</p>
        <h4 class="text-3xl font-extrabold text-amber-500">{{ $bookingsHariIni->where('status_sesi', 'menunggu')->count() }}</h4>
    </div>
</div>

<div class="flex items-center justify-between mb-4">
    <h2 class="text-lg font-extrabold text-slate-800 tracking-tight">Sesi Konsultasi Online</h2>
    <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-full text-[10px] font-bold uppercase tracking-wider">{{ today()->format('d F Y') }}</span>
</div>

@if($bookingsHariIni->isEmpty())
    <div class="premium-card rounded-2xl p-12 text-center shadow-sm">
        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">☕</div>
        <h4 class="text-slate-800 font-bold text-lg">Belum Ada Pasien</h4>
        <p class="text-slate-500 text-sm mt-1">Jadwal konsultasi online Anda untuk hari ini masih kosong.</p>
    </div>
@else
    <div class="grid grid-cols-1 gap-4">
        @foreach($bookingsHariIni as $booking)
        <div class="premium-card rounded-2xl p-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 font-bold text-lg">
                    {{ substr($booking->pasien->nama_lengkap, 0, 1) }}
                </div>
                <div>
                    <h5 class="font-bold text-slate-800">{{ $booking->pasien->nama_lengkap }}</h5>
                    <p class="text-[11px] text-slate-400 font-medium">Booking ID #{{ $booking->id }} • {{ $booking->waktu_mulai_sesi ? $booking->waktu_mulai_sesi->format('H:i') : 'Menunggu' }}</p>
                    <div class="mt-1">
                        <span class="text-[10px] font-bold uppercase tracking-widest px-2 py-0.5 rounded-md
                            {{ $booking->status_sesi === 'menunggu' ? 'bg-amber-50 text-amber-600' :
                               ($booking->status_sesi === 'aktif' ? 'bg-blue-50 text-blue-600' : 'bg-slate-50 text-slate-500') }}">
                            ● {{ $booking->status_sesi }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                @if($booking->status_pembayaran === 'lunas')
                    <a href="{{ route('chat.room', $booking->id) }}" class="flex-1 md:flex-none flex items-center justify-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition shadow-md shadow-blue-200">
                        <span>💬</span> Chat Konsultasi
                    </a>
                @else
                    <div class="text-[10px] font-bold text-rose-500 uppercase px-3 py-1 bg-rose-50 rounded-lg border border-rose-100">
                        Pembayaran: {{ $booking->status_pembayaran }}
                    </div>
                @endif

                <form method="POST" action="{{ route('dokter.update.status', $booking->id) }}" class="flex-1 md:flex-none">
                    @csrf
                    @if($booking->status_sesi === 'menunggu')
                        <input type="hidden" name="status_sesi" value="aktif">
                        <button type="submit" class="w-full flex items-center justify-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition shadow-md shadow-blue-200">
                            ▶ Mulai Sesi
                        </button>
                    @elseif($booking->status_sesi === 'aktif')
                        <input type="hidden" name="status_sesi" value="selesai">
                        <button type="submit" class="w-full flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-900 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition">
                            ✅ Selesaikan
                        </button>
                    @endif
                </form>
            </div>
        </div>
        @endforeach
    </div>
@endif
@endsection
