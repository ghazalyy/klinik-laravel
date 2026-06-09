@extends('layouts.pasien')
@section('title', 'Riwayat Rekam Medis')

@section('content')
<div class="mb-8">
    <h3 class="text-2xl font-bold text-slate-800">Riwayat Rekam Medis Anda</h3>
    <p class="text-slate-500 text-sm mt-1">Daftar lengkap rekam medis dari pemeriksaan kesehatan Anda di Klinik Pratama Orinda.</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left border-collapse">
            <thead class="bg-slate-50/50 text-slate-400 uppercase text-xs border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4 font-bold tracking-widest">Tanggal Periksa</th>
                    <th class="px-6 py-4 font-bold tracking-widest">Dokter Pemeriksa</th>
                    <th class="px-6 py-4 font-bold tracking-widest">Keluhan</th>
                    <th class="px-6 py-4 font-bold tracking-widest">Diagnosa</th>
                    <th class="px-6 py-4 font-bold tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($rekamMedis as $rm)
                <tr class="hover:bg-slate-50/20 transition">
                    <td class="px-6 py-4 text-slate-600 font-semibold">
                        {{ $rm->tanggal_periksa->format('d M Y') }}
                        <div class="text-[10px] text-slate-400 font-mono">RM #{{ $rm->id }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs">
                                dr
                            </div>
                            <div>
                                <p class="font-bold text-slate-700">dr. {{ $rm->dokter->user->nama_lengkap }}</p>
                                <p class="text-[10px] text-slate-400">{{ $rm->dokter->spesialisasi }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-slate-600">
                        <p class="truncate max-w-xs">{{ $rm->keluhan }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 bg-blue-50 text-blue-700 font-bold rounded-lg text-xs">
                            {{ $rm->diagnosa }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('pasien.rekam-medis.show', $rm->id) }}" class="px-4 py-2 bg-blue-50 hover:bg-blue-100 text-blue-600 text-xs font-bold rounded-xl transition inline-block">
                            👁️ Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-16 text-center text-slate-400 italic">
                        <div class="text-3xl mb-3">📁</div>
                        Belum ada riwayat pemeriksaan medis tercatat.
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
