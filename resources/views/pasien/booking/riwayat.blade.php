@extends('layouts.pasien')
@section('title', 'Riwayat Booking')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Booking ID</th>
                    <th class="px-6 py-3">Dokter</th>
                    <th class="px-6 py-3">Tanggal Konsultasi</th>
                    <th class="px-6 py-3">Pembayaran</th>
                    <th class="px-6 py-3">Status Sesi</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($bookings as $b)
                <tr>
                    <td class="px-6 py-4 text-gray-400 font-mono">#{{ $b->id }}</td>
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-800">{{ $b->dokter->user->nama_lengkap }}</p>
                        <p class="text-[10px] text-gray-400">{{ $b->dokter->spesialisasi }}</p>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $b->tanggal_booking->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase
                            {{ $b->status_pembayaran === 'lunas' ? 'bg-green-100 text-green-700' :
                               ($b->status_pembayaran === 'ditolak' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                            {{ $b->status_pembayaran }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded text-[10px] font-bold uppercase
                            {{ $b->status_sesi === 'selesai' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100' }}">
                            {{ $b->status_sesi }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            @if($b->status_pembayaran === 'pending')
                                <a href="{{ route('pasien.pembayaran.show', $b->id) }}" class="text-xs font-bold text-blue-600 hover:underline">Bayar</a>
                            @endif

                            @if($b->status_pembayaran === 'lunas')
                                <a href="{{ route('chat.room', $b->id) }}" class="text-xs font-bold text-green-600 hover:underline">Chat</a>
                            @endif

                            @if($b->status_sesi === 'selesai' && !$b->reviewDokter)
                                <a href="{{ route('pasien.ulasan.show', $b->id) }}" class="text-xs font-bold text-orange-600 hover:underline">Beri Ulasan</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400 font-medium italic">Belum ada riwayat booking.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 bg-gray-50">
        {{ $bookings->links() }}
    </div>
</div>
@endsection
