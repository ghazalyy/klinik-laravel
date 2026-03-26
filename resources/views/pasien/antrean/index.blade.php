@extends('layouts.pasien')
@section('title', 'Ambil Antrean Offline')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-gray-800">Antrean Walk-in (Offline)</h2>
        <p class="text-gray-500 mt-2">Daftar antrean untuk kunjungan langsung ke klinik hari ini.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
        <form action="{{ route('pasien.antrean.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Pilih Dokter Tujuan</label>
                <select name="dokter_id" class="w-full px-4 py-3 bg-gray-50 border border-transparent rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none transition" required>
                    <option value="">-- Pilih Dokter --</option>
                    @foreach($dokters as $d)
                        <option value="{{ $d->id }}">{{ $d->user->nama_lengkap }} ({{ $d->spesialisasi }})</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Tujuan Kunjungan / Keluhan Singkat</label>
                <textarea name="tujuan_kunjungan" rows="3" class="w-full px-4 py-3 bg-gray-50 border border-transparent rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none transition" placeholder="Contoh: Cek kesehatan berkala, demam, dll."></textarea>
            </div>

            <div class="bg-orange-50 rounded-xl p-4 text-sm text-orange-700 leading-relaxed">
                ⚠️ **PENTING:** Pengambilan nomor antrean online hanya berlaku untuk hari ini. Silakan datang ke klinik sesuai nomor urut yang didapat.
            </div>

            <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-blue-200 shadow-lg transition transform active:scale-95">
                AMBIL NOMOR ANTREAN
            </button>
        </form>
    </div>
</div>
@endsection
