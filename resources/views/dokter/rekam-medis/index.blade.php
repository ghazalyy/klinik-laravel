@extends('layouts.dokter')
@section('title', 'Rekam Medis Pasien')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h3 class="text-2xl font-bold text-slate-800">Daftar Rekam Medis</h3>
        <p class="text-slate-500 text-sm mt-1">Kelola dan lihat semua riwayat pemeriksaan pasien Anda.</p>
    </div>
    <div>
        <a href="{{ route('dokter.rekam-medis.create') }}" class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition shadow-md shadow-blue-200">
            <span>➕</span> Tambah Rekam Medis
        </a>
    </div>
</div>

<!-- Search Bar -->
<div class="premium-card p-4 rounded-2xl mb-6 bg-white">
    <form method="GET" action="{{ route('dokter.rekam-medis.index') }}" class="flex gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan nama pasien..."
            class="flex-1 px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        <button type="submit" class="px-5 py-2 bg-slate-800 hover:bg-slate-900 text-white text-sm font-bold rounded-xl transition">
            Cari
        </button>
        @if(request('search'))
            <a href="{{ route('dokter.rekam-medis.index') }}" class="px-5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-bold rounded-xl transition flex items-center justify-center">
                Reset
            </a>
        @endif
    </form>
</div>

<!-- Data Table -->
<div class="premium-card rounded-2xl overflow-hidden bg-white">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100">
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tanggal</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Nama Pasien</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Keluhan</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Diagnosa</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Resep Obat</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($rekamMedis as $rm)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="text-slate-600 font-semibold">{{ $rm->tanggal_periksa->format('d M Y') }}</div>
                        <div class="text-[10px] text-slate-400 font-mono">RM #{{ $rm->id }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs">
                                {{ substr($rm->pasien->nama_lengkap, 0, 1) }}
                            </div>
                            <span class="font-bold text-slate-700">{{ $rm->pasien->nama_lengkap }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-slate-600 truncate max-w-xs">{{ $rm->keluhan }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 bg-blue-50 text-blue-700 font-bold rounded-lg text-xs">
                            {{ $rm->diagnosa }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-slate-600 truncate max-w-xs">{{ $rm->resep_obat }}</p>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('dokter.rekam-medis.show', $rm->id) }}" class="p-2 bg-slate-50 hover:bg-slate-100 rounded-lg text-xs font-bold text-slate-600 transition" title="Lihat">
                                👁️ Lihat
                            </a>
                            <a href="{{ route('dokter.rekam-medis.edit', $rm->id) }}" class="p-2 bg-amber-50 hover:bg-amber-100 rounded-lg text-xs font-bold text-amber-700 transition" title="Edit">
                                ✏️ Edit
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="text-3xl mb-3">📁</div>
                        <h5 class="text-slate-400 font-medium italic">Belum ada data rekam medis.</h5>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($rekamMedis->hasPages())
    <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
        {{ $rekamMedis->links() }}
    </div>
    @endif
</div>
@endsection
