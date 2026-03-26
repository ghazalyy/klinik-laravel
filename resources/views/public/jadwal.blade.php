@extends('layouts.app')
@section('title', 'Jadwal Dokter')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">📅 Jadwal Dokter</h1>

    @foreach($dokters as $dokter)
    <div class="bg-white rounded-xl shadow-sm mb-6 overflow-hidden">
        <div class="bg-blue-700 text-white p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-xl">👨‍⚕️</div>
            <div>
                <p class="font-bold text-lg">{{ $dokter->user->nama_lengkap }}</p>
                <p class="text-blue-200 text-sm">{{ $dokter->spesialisasi }} — Rp {{ number_format($dokter->harga_sesi, 0, ',', '.') }}/sesi</p>
            </div>
            <span class="ml-auto px-3 py-1 rounded-full text-xs font-semibold
                {{ $dokter->status_online === 'Online' ? 'bg-green-400 text-green-900' : 'bg-gray-400 text-white' }}">
                {{ $dokter->status_online === 'Online' ? '🟢 Online' : '🔴 Offline' }}
            </span>
        </div>
        @if($dokter->jadwalDokter->isEmpty())
            <p class="p-6 text-gray-500 text-sm">Belum ada jadwal.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Hari</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Jam Mulai</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Jam Selesai</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Jenis</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($dokter->jadwalDokter as $j)
                        <tr>
                            <td class="px-6 py-3 font-medium">{{ $j->hari }}</td>
                            <td class="px-6 py-3">{{ substr($j->jam_mulai, 0, 5) }}</td>
                            <td class="px-6 py-3">{{ substr($j->jam_selesai, 0, 5) }}</td>
                            <td class="px-6 py-3">
                                <span class="px-2 py-1 rounded-full text-xs {{ $j->jenis_layanan === 'Online' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">
                                    {{ $j->jenis_layanan }}
                                </span>
                            </td>
                            <td class="px-6 py-3">
                                <span class="px-2 py-1 rounded-full text-xs {{ $j->status === 'tersedia' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $j->status === 'tersedia' ? 'Tersedia' : 'Tidak Tersedia' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    @endforeach
</div>
@endsection
