@extends('layouts.admin')
@section('title', 'Monitor Antrean Offline')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <p class="text-gray-600">Daftar pasien yang mengambil nomor antrean hari ini.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">No. Antrean</th>
                    <th class="px-6 py-3">Nama Pasien</th>
                    <th class="px-6 py-3">Dokter Tujuan</th>
                    <th class="px-6 py-3">Tujuan/Keluhan</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($antreans as $a)
                <tr>
                    <td class="px-6 py-4 font-bold text-lg text-blue-700">A-{{ $a->nomor_antrean }}</td>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $a->pasien->nama_lengkap }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $a->dokter->user->nama_lengkap }}</td>
                    <td class="px-6 py-4 text-gray-500 truncate max-w-xs">{{ $a->tujuan_kunjungan ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase
                            {{ $a->status === 'menunggu' ? 'bg-yellow-100 text-yellow-700' :
                               ($a->status === 'dipanggil' ? 'bg-blue-100 text-blue-700' :
                               ($a->status === 'selesai' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700')) }}">
                            {{ $a->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <form action="{{ route('admin.antrean.status', $a->id) }}" method="POST" class="inline-block">
                            @csrf @method('PUT')
                            <select name="status" onchange="this.form.submit()" class="text-xs border rounded p-1 outline-none">
                                <option value="menunggu" {{ $a->status === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="dipanggil" {{ $a->status === 'dipanggil' ? 'selected' : '' }}>Dipanggil</option>
                                <option value="selesai" {{ $a->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="batal" {{ $a->status === 'batal' ? 'selected' : '' }}>Batal</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400 font-medium italic">Belum ada antrean untuk hari ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
