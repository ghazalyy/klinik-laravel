@extends('layouts.admin')
@section('title', 'Riwayat Semua Pembayaran')

@section('content')
<div class="mb-6">
    <p class="text-gray-600">Seluruh catatan transaksi pembayaran baik via Midtrans maupun manual.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">ID Bayar</th>
                    <th class="px-6 py-3">Pasien</th>
                    <th class="px-6 py-3">Dokter</th>
                    <th class="px-6 py-3">Jumlah</th>
                    <th class="px-6 py-3">Metode</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($pembayarans as $p)
                <tr>
                    <td class="px-6 py-4 text-gray-400 font-mono">#{{ $p->id }}</td>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $p->booking->pasien->nama_lengkap }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $p->booking->dokter->user->nama_lengkap }}</td>
                    <td class="px-6 py-4 font-bold">Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-[10px] bg-gray-100 text-gray-600 uppercase font-bold">
                            {{ $p->metode_pembayaran }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase
                            {{ $p->booking->status_pembayaran === 'lunas' ? 'bg-green-100 text-green-700' :
                               ($p->booking->status_pembayaran === 'ditolak' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                            {{ $p->booking->status_pembayaran }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-500 text-xs">{{ $p->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 bg-gray-50">
        {{ $pembayarans->links() }}
    </div>
</div>
@endsection
