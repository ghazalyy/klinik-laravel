@extends('layouts.dokter')
@section('title', 'Riwayat Pasien')

@section('content')
<div class="mb-8">
    <h3 class="text-2xl font-bold text-slate-800">Riwayat Konsultasi</h3>
    <p class="text-slate-500 text-sm mt-1">Daftar semua pasien yang pernah melakukan konsultasi dengan Anda.</p>
</div>

<div class="premium-card rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100">
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tanggal</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Nama Pasien</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Status Sesi</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Penilaian</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Ulasan Pasien</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($riwayat as $b)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="text-slate-600 font-semibold">{{ $b->tanggal_booking->format('d M Y') }}</div>
                        <div class="text-[10px] text-slate-400 font-medium">ID #{{ $b->id }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs">
                                {{ substr($b->pasien->nama_lengkap, 0, 1) }}
                            </div>
                            <span class="font-bold text-slate-700">{{ $b->pasien->nama_lengkap }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-[10px] font-bold uppercase tracking-widest px-2 py-0.5 rounded-md
                            {{ $b->status_sesi === 'selesai' ? 'bg-blue-50 text-blue-600' : 'bg-slate-100 text-slate-400' }}">
                            {{ $b->status_sesi }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($b->reviewDokter)
                            <div class="flex flex-col gap-1">
                                <div class="flex items-center gap-1">
                                    <span class="text-amber-400">★</span>
                                    <span class="text-[11px] font-bold text-slate-700">{{ ($b->reviewDokter->rating_pelayanan + $b->reviewDokter->rating_komunikasi) / 2 }}</span>
                                </div>
                                <div class="text-[9px] text-slate-400 uppercase tracking-tighter">Pelayanan: {{ $b->reviewDokter->rating_pelayanan }} • Komunikasi: {{ $b->reviewDokter->rating_komunikasi }}</div>
                            </div>
                        @else
                            <span class="text-[10px] text-slate-400 italic">Belum direview</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-[11px] text-slate-500 italic max-w-xs truncate">
                            "{{ $b->reviewDokter->ulasan ?? '-' }}"
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-16 text-center">
                        <div class="text-3xl mb-3">📁</div>
                        <h5 class="text-slate-400 font-medium italic">Belum ada data riwayat pasien.</h5>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($riwayat->hasPages())
    <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
        {{ $riwayat->links() }}
    </div>
    @endif
</div>
@endsection
