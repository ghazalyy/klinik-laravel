@extends('layouts.dokter')
@section('title', 'Detail Rekam Medis #' . $rekamMedis->id)

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8 flex items-center justify-between no-print">
        <div>
            <a href="{{ route('dokter.rekam-medis.index') }}" class="text-xs font-bold text-blue-600 hover:underline flex items-center gap-1">
                ⬅️ Kembali ke Daftar
            </a>
            <h3 class="text-2xl font-bold text-slate-800 mt-2">Detail Rekam Medis</h3>
            <p class="text-slate-500 text-sm mt-1">Laporan rekam medis lengkap untuk kunjungan pasien.</p>
        </div>
        <div class="flex gap-2">
            <button onclick="window.print()" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2">
                🖨️ Cetak Dokumen
            </button>
            <a href="{{ route('dokter.rekam-medis.edit', $rekamMedis->id) }}" class="bg-amber-50 hover:bg-amber-100 text-amber-700 px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2">
                ✏️ Edit Data
            </a>
        </div>
    </div>

    <!-- Medical Document Design -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xl shadow-slate-100/50 p-10 relative overflow-hidden" id="printable-area">
        <!-- Logo / Kop Surat -->
        <div class="flex flex-col md:flex-row md:items-center justify-between border-b-2 border-slate-800 pb-6 mb-8 gap-4">
            <div>
                <h2 class="text-2xl font-black text-blue-900 tracking-tight uppercase italic">Klinik Pratama Orinda</h2>
                <p class="text-xs text-slate-400 font-medium mt-1">Jl. Mawar Melati No. 45, Jakarta Selatan</p>
                <p class="text-[10px] text-slate-400">Telp: (021) 7654321 • Email: info@klinikorinda.com</p>
            </div>
            <div class="text-left md:text-right">
                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-[10px] font-black uppercase tracking-widest">
                    Dokumen Resmi Klinik
                </span>
                <p class="text-xs font-mono text-slate-400 mt-2">RM-ID: #{{ str_pad($rekamMedis->id, 6, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>

        <!-- Meta Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8 pb-6 border-b border-slate-100">
            <div class="space-y-4">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest leading-none">Informasi Pasien</h4>
                <div class="space-y-1">
                    <p class="text-base font-extrabold text-slate-800">{{ $rekamMedis->pasien->nama_lengkap }}</p>
                    <p class="text-xs text-slate-500">Telepon: {{ $rekamMedis->pasien->no_telepon ?? '-' }}</p>
                    <p class="text-xs text-slate-500">Alamat: {{ $rekamMedis->pasien->alamat ?? '-' }}</p>
                </div>
            </div>
            <div class="space-y-4 text-left md:text-right">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest leading-none">Informasi Pemeriksa</h4>
                <div class="space-y-1">
                    <p class="text-base font-extrabold text-slate-800">dr. {{ $rekamMedis->dokter->user->nama_lengkap }}</p>
                    <p class="text-xs text-slate-500">Spesialisasi: {{ $rekamMedis->dokter->spesialisasi }}</p>
                    <p class="text-xs text-slate-500">Tanggal Pemeriksaan: <span class="font-semibold text-slate-800">{{ $rekamMedis->tanggal_periksa->format('d F Y') }}</span></p>
                </div>
            </div>
        </div>

        <!-- Medical Details -->
        <div class="space-y-8">
            <!-- Keluhan -->
            <div class="space-y-2">
                <h5 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Keluhan Utama (Anamnesis)</h5>
                <p class="text-slate-800 bg-slate-50 rounded-2xl p-5 text-sm leading-relaxed border border-slate-100">
                    {{ $rekamMedis->keluhan }}
                </p>
            </div>

            <!-- Diagnosa -->
            <div class="space-y-2">
                <h5 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Diagnosa Medis</h5>
                <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5">
                    <p class="text-blue-900 font-extrabold text-base">{{ $rekamMedis->diagnosa }}</p>
                </div>
            </div>

            <!-- Tindakan -->
            <div class="space-y-2">
                <h5 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Tindakan Medis</h5>
                <p class="text-slate-800 bg-slate-50 rounded-2xl p-5 text-sm leading-relaxed border border-slate-100">
                    {{ $rekamMedis->tindakan }}
                </p>
            </div>

            <!-- Resep Obat -->
            <div class="space-y-2">
                <h5 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Resep Obat</h5>
                <div class="bg-emerald-50 border border-emerald-100 text-emerald-900 rounded-2xl p-5 font-mono text-sm leading-relaxed">
                    {!! nl2br(e($rekamMedis->resep_obat)) !!}
                </div>
            </div>

            <!-- Catatan Tambahan -->
            @if($rekamMedis->catatan)
            <div class="space-y-2">
                <h5 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Catatan Tambahan</h5>
                <p class="text-slate-600 italic bg-slate-50 rounded-2xl p-5 text-sm leading-relaxed border border-slate-100">
                    {{ $rekamMedis->catatan }}
                </p>
            </div>
            @endif
        </div>

        <!-- Footer / Tanda Tangan -->
        <div class="mt-16 pt-8 border-t border-slate-100 flex justify-between items-end">
            <div class="text-xs text-slate-400">
                <p>Sumber Sesi: 
                    @if($rekamMedis->booking_id)
                        Online (Booking ID #{{ $rekamMedis->booking_id }})
                    @elseif($rekamMedis->antrean_offline_id)
                        Offline (Antrean ID #{{ $rekamMedis->antrean_offline_id }})
                    @else
                        Kunjungan Umum (Walk-in)
                    @endif
                </p>
                <p class="mt-1">Dibuat otomatis pada {{ $rekamMedis->created_at->format('d/m/Y H:i') }} WIB</p>
            </div>
            <div class="text-center w-64">
                <p class="text-xs text-slate-400 mb-12">Dokter Pemeriksa,</p>
                <div class="w-24 h-px bg-slate-400 mx-auto mb-2"></div>
                <p class="text-xs font-bold text-slate-800">dr. {{ $rekamMedis->dokter->user->nama_lengkap }}</p>
                <p class="text-[10px] text-slate-400">SIP: {{ str_pad($rekamMedis->dokter->id, 8, '0', STR_PAD_LEFT) }}/SIP/2026</p>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .no-print {
        display: none !important;
    }
    body {
        background-color: white !important;
        color: black !important;
    }
    #printable-area {
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
    }
}
</style>
@endsection
