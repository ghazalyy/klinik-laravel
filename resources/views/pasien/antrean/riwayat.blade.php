@extends('layouts.pasien')
@section('title', 'Riwayat Antrean Offline')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">No. Antrean</th>
                    <th class="px-6 py-3">Dokter</th>
                    <th class="px-6 py-3">Tujuan</th>
                    <th class="px-6 py-3">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($antreans as $a)
                <tr class="{{ $a->tanggal_kunjungan->isToday() ? 'bg-blue-50' : '' }}">
                    <td class="px-6 py-4 text-gray-600">{{ $a->tanggal_kunjungan->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 font-bold text-lg text-blue-700">A-{{ $a->nomor_antrean }}</td>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $a->dokter->user->nama_lengkap }}</td>
                    <td class="px-6 py-4 text-gray-500 truncate max-w-xs">{{ $a->tujuan_kunjungan ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase
                            {{ $a->status === 'menunggu' ? 'bg-yellow-100 text-yellow-700' :
                               ($a->status === 'dipanggil' ? 'bg-blue-100 text-blue-700' :
                               ($a->status === 'selesai' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700')) }}">
                            {{ $a->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400 font-medium italic">Anda belum pernah mengambil antrean.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 bg-gray-50">
        {{ $antreans->links() }}
    </div>
</div>
@endsection
