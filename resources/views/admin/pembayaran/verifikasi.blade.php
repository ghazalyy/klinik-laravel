@extends('layouts.admin')
@section('title', 'Verifikasi Pembayaran')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <p class="text-gray-600">Verifikasi bukti transfer manual dari pasien.</p>
    <a href="{{ route('admin.pembayaran.riwayat') }}" class="text-blue-600 text-sm font-bold hover:underline">Lihat Riwayat Semua →</a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($pembayarans as $p)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
        <div class="p-4 border-b bg-gray-50 flex justify-between items-center">
            <span class="text-xs font-bold text-gray-500">BOOKING #{{ $p->booking_id }}</span>
            <span class="text-xs text-gray-400">{{ $p->created_at->diffForHumans() }}</span>
        </div>
        <div class="p-4 flex-1 space-y-4">
            <div>
                <p class="text-xs text-gray-400 uppercase font-bold">Pasien</p>
                <p class="font-bold text-gray-800">{{ $p->booking->pasien->nama_lengkap }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase font-bold">Dokter</p>
                <p class="text-sm text-gray-700">{{ $p->booking->dokter->user->nama_lengkap }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase font-bold">Jumlah Bayar</p>
                <p class="text-xl font-bold text-green-600">Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</p>
            </div>
            @if($p->bukti_transfer)
            <div>
                <p class="text-xs text-gray-400 uppercase font-bold mb-2">Bukti Transfer</p>
                <a href="{{ asset('storage/'.$p->bukti_transfer) }}" target="_blank" class="block rounded-lg overflow-hidden border hover:opacity-80 transition">
                    <img src="{{ asset('storage/'.$p->bukti_transfer) }}" class="w-full h-40 object-cover bg-gray-100">
                </a>
            </div>
            @endif
        </div>
        <div class="p-4 bg-gray-50 grid grid-cols-2 gap-3">
            <form action="{{ route('admin.pembayaran.tolak', $p->id) }}" method="POST">
                @csrf
                <button type="submit" class="w-full py-2 bg-white border border-red-200 text-red-600 rounded-lg text-xs font-bold hover:bg-red-50 transition">TOLAK</button>
            </form>
            <form action="{{ route('admin.pembayaran.approve', $p->id) }}" method="POST">
                @csrf
                <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded-lg text-xs font-bold hover:bg-blue-700 transition">TERIMA</button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-full bg-white rounded-xl p-12 text-center text-gray-400 font-medium italic border border-dashed">
        Tidak ada pembayaran yang butuh verifikasi saat ini.
    </div>
    @endforelse
</div>
@endsection
