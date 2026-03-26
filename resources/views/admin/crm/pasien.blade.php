@extends('layouts.admin')
@section('title', 'Detail Pasien: ' . $pasien->nama_lengkap)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Patient Profile -->
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex flex-col items-center text-center">
                <div class="w-24 h-24 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-4xl font-bold mb-4">
                    {{ substr($pasien->nama_lengkap, 0, 1) }}
                </div>
                <h3 class="text-xl font-bold text-gray-800">{{ $pasien->nama_lengkap }}</h3>
                <p class="text-sm text-gray-500">{{ $pasien->username }}</p>
                <div class="w-full h-px bg-gray-100 my-4"></div>
                <div class="text-left w-full space-y-3">
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold">Telepon</p>
                        <p class="text-sm text-gray-700">{{ $pasien->no_telepon ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold">Alamat</p>
                        <p class="text-sm text-gray-700">{{ $pasien->alamat ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold">Terdaftar Sejak</p>
                        <p class="text-sm text-gray-700">{{ $pasien->created_at->format('d F Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Patient History -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Booking History -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-800">Riwayat Booking Online</h3>
                <span class="text-xs font-bold bg-blue-50 text-blue-600 px-2 py-1 rounded-full">{{ $bookings->count() }} Total</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3">ID</th>
                            <th class="px-6 py-3">Dokter</th>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3">Status Bayar</th>
                            <th class="px-6 py-3">Status Sesi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($bookings as $b)
                        <tr>
                            <td class="px-6 py-4">#{{ $b->id }}</td>
                            <td class="px-6 py-4">
                                <p class="font-medium">{{ $b->dokter->user->nama_lengkap }}</p>
                                <p class="text-xs text-gray-400 text-truncate">{{ $b->dokter->spesialisasi }}</p>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $b->tanggal_booking->format('d/m/Y') }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase
                                    {{ $b->status_pembayaran === 'lunas' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ $b->status_pembayaran }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase
                                    {{ $b->status_sesi === 'selesai' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700' }}">
                                    {{ $b->status_sesi }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Offline Queue History -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-bold text-gray-800">Riwayat Antrean Offline</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3">Dokter</th>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3">Nomor</th>
                            <th class="px-6 py-3">Tujuan</th>
                            <th class="px-6 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($antrean as $a)
                        <tr>
                            <td class="px-6 py-4 font-medium">{{ $a->dokter->user->nama_lengkap }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $a->tanggal_kunjungan->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 font-bold text-blue-600">A-{{ $a->nomor_antrean }}</td>
                            <td class="px-6 py-4 text-gray-500 truncate max-w-[150px]">{{ $a->tujuan_kunjungan ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase bg-gray-100 text-gray-700">
                                    {{ $a->status }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
