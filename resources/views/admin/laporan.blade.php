@extends('layouts.admin')
@section('title', 'Laporan Rekapitulasi')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h3 class="text-xl font-bold text-slate-800 tracking-tight">Ikhtisar Operasional</h3>
        <p class="text-xs text-slate-500 mt-1 uppercase tracking-wider font-medium">Laporan menyeluruh aktivitas klinik periode ini</p>
    </div>
    <a href="{{ route('admin.laporan.export') }}" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-blue-200 transition transform active:scale-95">
        <span>📥</span> Unduh Laporan .CSV
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
    <div class="premium-card p-6 rounded-2xl bg-white border-l-4 border-l-blue-500">
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Pendapatan</p>
        <p class="text-2xl font-extrabold text-slate-800 mt-2 tracking-tighter italic">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
    </div>
    <div class="premium-card p-6 rounded-2xl bg-white border-l-4 border-l-emerald-500">
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Konsultasi Selesai</p>
        <p class="text-2xl font-extrabold text-slate-800 mt-2 tracking-tighter italic">{{ $bookingSelesai }} <span class="text-xs font-normal text-slate-400 not-italic ml-1">Sesi</span></p>
    </div>
    <div class="premium-card p-6 rounded-2xl bg-white border-l-4 border-l-purple-500">
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Booking Bulan Ini</p>
        <p class="text-2xl font-extrabold text-slate-800 mt-2 tracking-tighter italic">{{ $bookingBulanIni }} <span class="text-xs font-normal text-slate-400 not-italic ml-1">Baru</span></p>
    </div>
    <div class="premium-card p-6 rounded-2xl bg-white border-l-4 border-l-rose-500">
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pasien Terdaftar</p>
        <p class="text-2xl font-extrabold text-slate-800 mt-2 tracking-tighter italic">{{ $pasienTerdaftar }} <span class="text-xs font-normal text-slate-400 not-italic ml-1">Orang</span></p>
    </div>
</div>

<div class="premium-card rounded-2xl overflow-hidden bg-white border border-slate-200/60">
    <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/30">
        <h3 class="font-bold text-slate-800 tracking-tight">Semua Catatan Transaksi</h3>
        <span class="text-[10px] bg-blue-50 text-blue-600 px-2 py-0.5 rounded font-bold border border-blue-100 uppercase tracking-tighter">Realtime Update</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">ID</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pasien / Dokter</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tanggal</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">Biaya</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Bayar</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Sesi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($bookings as $b)
                <tr class="hover:bg-slate-50/80 transition-colors">
                    <td class="px-6 py-4 text-slate-400 font-mono text-xs">#{{ $b->id }}</td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-slate-800 tracking-tight">{{ $b->pasien->nama_lengkap }}</p>
                        <p class="text-[10px] text-slate-400 font-medium">Dr. {{ $b->dokter->user->nama_lengkap }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-[13px] font-medium text-slate-600">{{ $b->tanggal_booking->translatedFormat('d M Y') }}</p>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <p class="font-extrabold text-slate-800">Rp {{ number_format($b->pembayaran->jumlah_bayar ?? 0, 0, ',', '.') }}</p>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $payClass = $b->status_pembayaran === 'lunas' ? 'text-emerald-600 bg-emerald-50 border-emerald-100' : 'text-amber-600 bg-amber-50 border-amber-100';
                        @endphp
                        <span class="px-2 py-0.5 rounded-lg text-[10px] font-extrabold uppercase border {{ $payClass }} tracking-tighter">
                            {{ $b->status_pembayaran }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-2 py-0.5 rounded-lg text-[10px] font-extrabold uppercase tracking-tighter {{ $b->status_sesi === 'selesai' ? 'bg-blue-50 text-blue-700 border border-blue-100' : 'bg-slate-100 text-slate-500' }}">
                            {{ $b->status_sesi }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    @if($bookings->hasPages())
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
        {{ $bookings->links() }}
    </div>
    @endif
</div>
@endsection
