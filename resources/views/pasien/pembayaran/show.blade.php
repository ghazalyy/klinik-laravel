@extends('layouts.pasien')
@section('title', 'Pembayaran Aman')

@section('content')
<div class="max-w-2xl mx-auto py-10">
    <div class="text-center mb-10">
        <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Selesaikan Pembayaran</h2>
        <p class="text-slate-500 mt-2 font-medium">Lakukan pembayaran untuk mengonfirmasi sesi konsultasi Anda</p>
    </div>

    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden transition-all hover:shadow-2xl hover:shadow-slate-200/60">
        <div class="bg-slate-50 px-8 py-6 border-b border-slate-100 flex items-center justify-between">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Detail Transaksi</span>
            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-tighter">#INV-{{ $booking->id }}</span>
        </div>
        
        <div class="p-8">
            <div class="grid grid-cols-2 gap-8 mb-10">
                <div class="space-y-1">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Dokter Spesialis</p>
                    <p class="text-lg font-bold text-slate-800 tracking-tight leading-tight">Dr. {{ $booking->dokter->user->nama_lengkap }}</p>
                    <p class="text-xs text-slate-400 italic">Spesialisasi: {{ $booking->dokter->spesialisasi }}</p>
                </div>
                <div class="space-y-1 text-right">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Jadwal Sesi</p>
                    <p class="text-lg font-bold text-slate-800 tracking-tight leading-tight">{{ $booking->tanggal_booking->translatedFormat('d F Y') }}</p>
                    <p class="text-xs text-slate-400 italic">{{ $booking->jadwalDokter->hari ?? '' }} | {{ $booking->jadwalDokter->jam_mulai ?? '' }}</p>
                </div>
            </div>

            <div class="bg-blue-600 rounded-2xl p-8 text-white relative overflow-hidden mb-10 group transition-all duration-500">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl group-hover:scale-125 transition-transform duration-700"></div>
                <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-black/10 rounded-full blur-2xl"></div>
                
                <div class="relative z-10 flex flex-col items-center">
                    <p class="text-[10px] font-bold text-blue-200 uppercase tracking-[0.3em] mb-2 font-mono">Total Tagihan</p>
                    <p class="text-5xl font-black tracking-tighter italic">Rp {{ number_format($booking->pembayaran->jumlah_bayar, 0, ',', '.') }}</p>
                    <div class="mt-4 flex items-center gap-2 text-[10px] bg-white/20 px-3 py-1 rounded-full font-bold uppercase tracking-wider">
                        <span>🔒</span> Transaksi Terenkripsi
                    </div>
                </div>
            </div>

            @if($booking->status_pembayaran === 'lunas')
                <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 p-6 rounded-2xl flex flex-col items-center gap-2 transform transition hover:scale-105 duration-300">
                    <div class="w-12 h-12 bg-emerald-500 rounded-full flex items-center justify-center text-white text-xl shadow-lg border-4 border-emerald-100 animate-bounce">✓</div>
                    <p class="font-black text-lg tracking-tight">Pembayaran Terverifikasi!</p>
                    <p class="text-xs opacity-80 font-medium">Silakan cek riwayat booking untuk memulai chat.</p>
                </div>
            @else
                <form action="{{ route('pasien.pembayaran.checkout', $booking->id) }}" method="POST">
                    @csrf
                    <button type="submit" 
                        class="w-full py-5 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-2xl text-xl shadow-2xl shadow-blue-200 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-3">
                        <span class="text-2xl">💳</span> 
                        <span>KONFIRMASI & BAYAR</span>
                    </button>
                </form>
                <div class="mt-6 flex flex-col items-center gap-3">
                    <div class="flex items-center gap-4 opacity-40 transition-all duration-300">
                        <span class="font-bold text-xs uppercase tracking-widest text-slate-400">Powered by</span>
                        <span class="font-bold text-sm text-blue-600 tracking-wider font-mono">PAYMENTKU</span>
                    </div>
                    <p class="text-[10px] text-slate-400 font-medium max-w-xs text-center leading-relaxed">
                        Klik tombol di atas untuk membuka jendela aman Paymentku. Anda dapat membayar menggunakan E-Wallet, Virtual Account, maupun QRIS.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
