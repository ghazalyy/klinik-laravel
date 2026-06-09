@extends('layouts.dokter')
@section('title', 'Tambah Rekam Medis')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <a href="{{ route('dokter.rekam-medis.index') }}" class="text-xs font-bold text-blue-600 hover:underline flex items-center gap-1">
                ⬅️ Kembali ke Daftar
            </a>
            <h3 class="text-2xl font-bold text-slate-800 mt-2">Tambah Rekam Medis Baru</h3>
            <p class="text-slate-500 text-sm mt-1">Isi rekam medis pemeriksaan kesehatan pasien secara menyeluruh.</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-rose-50 border border-rose-100 text-rose-700 rounded-2xl">
            <p class="font-bold text-sm">Terjadi kesalahan input:</p>
            <ul class="list-disc list-inside text-xs mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="premium-card rounded-2xl p-8 bg-white border border-slate-100 shadow-sm">
        <form method="POST" action="{{ route('dokter.rekam-medis.store') }}" class="space-y-6">
            @csrf

            <!-- Data Pasien -->
            <div class="bg-blue-50/50 border border-blue-100/50 rounded-2xl p-5 mb-6">
                <h4 class="text-sm font-extrabold text-blue-800 uppercase tracking-wider mb-3">Informasi Pasien</h4>
                
                @if($booking)
                    <input type="hidden" name="pasien_id" value="{{ $booking->pasien_id }}">
                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Pasien</p>
                            <p class="text-slate-800 font-bold mt-0.5">{{ $booking->pasien->nama_lengkap }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Sesi Konsultasi</p>
                            <p class="text-slate-800 font-bold mt-0.5">Booking #{{ $booking->id }} (Online)</p>
                        </div>
                    </div>
                @elseif($antreanOffline)
                    <input type="hidden" name="pasien_id" value="{{ $antreanOffline->pasien_id }}">
                    <input type="hidden" name="antrean_offline_id" value="{{ $antreanOffline->id }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Pasien</p>
                            <p class="text-slate-800 font-bold mt-0.5">{{ $antreanOffline->pasien->nama_lengkap }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Sesi Konsultasi</p>
                            <p class="text-slate-800 font-bold mt-0.5">Antrean #{{ $antreanOffline->nomor_antrean }} (Offline)</p>
                        </div>
                    </div>
                @else
                    <div class="space-y-2">
                        <label for="pasien_id" class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Pilih Pasien</label>
                        <select name="pasien_id" id="pasien_id" required class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                            <option value="">-- Pilih Pasien Terdaftar --</option>
                            @foreach($pasiens as $pasien)
                                <option value="{{ $pasien->id }}" {{ old('pasien_id') == $pasien->id ? 'selected' : '' }}>
                                    {{ $pasien->nama_lengkap }} ({{ $pasien->username }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>

            <!-- Form Fields -->
            <div class="grid grid-cols-1 gap-6">
                <!-- Tanggal Periksa -->
                <div>
                    <label for="tanggal_periksa" class="text-xs font-bold text-slate-500 uppercase tracking-wider block mb-2">Tanggal Periksa</label>
                    <input type="date" name="tanggal_periksa" id="tanggal_periksa" 
                        value="{{ old('tanggal_periksa', date('Y-m-d')) }}" required
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Keluhan / Anamnesis -->
                <div>
                    <label for="keluhan" class="text-xs font-bold text-slate-500 uppercase tracking-wider block mb-2">Keluhan Utama (Anamnesis)</label>
                    <textarea name="keluhan" id="keluhan" rows="3" placeholder="Masukkan keluhan pasien saat datang..." required
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('keluhan') }}</textarea>
                </div>

                <!-- Diagnosa -->
                <div>
                    <label for="diagnosa" class="text-xs font-bold text-slate-500 uppercase tracking-wider block mb-2">Diagnosa Medis</label>
                    <input type="text" name="diagnosa" id="diagnosa" placeholder="Contoh: Hipertensi Primer, Influenza, Dyspepsia" 
                        value="{{ old('diagnosa') }}" required
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Tindakan Medis -->
                <div>
                    <label for="tindakan" class="text-xs font-bold text-slate-500 uppercase tracking-wider block mb-2">Tindakan Medis / Pengobatan</label>
                    <textarea name="tindakan" id="tindakan" rows="3" placeholder="Tindakan yang diberikan (misal: Edukasi diet, pembersihan luka, dll)" required
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('tindakan') }}</textarea>
                </div>

                <!-- Resep Obat -->
                <div>
                    <label for="resep_obat" class="text-xs font-bold text-slate-500 uppercase tracking-wider block mb-2">Resep Obat</label>
                    <textarea name="resep_obat" id="resep_obat" rows="3" placeholder="Contoh: Paracetamol 500mg 3x1 tablet sesudah makan" required
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('resep_obat') }}</textarea>
                </div>

                <!-- Catatan Tambahan -->
                <div>
                    <label for="catatan" class="text-xs font-bold text-slate-500 uppercase tracking-wider block mb-2">Catatan Tambahan (Opsional)</label>
                    <textarea name="catatan" id="catatan" rows="2" placeholder="Catatan pantangan makan atau anjuran kontrol kembali..."
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('catatan') }}</textarea>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                <a href="{{ route('dokter.rekam-medis.index') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-bold rounded-xl transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition shadow-md shadow-blue-200">
                    💾 Simpan Rekam Medis
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
