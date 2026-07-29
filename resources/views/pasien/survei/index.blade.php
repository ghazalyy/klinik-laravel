@extends('layouts.pasien')
@section('title', 'Survei Kepuasan Pasien')

@section('content')
<div class="max-w-4xl mx-auto space-y-8" x-data="{
    pendaftaran: 5,
    fasilitas: 5,
    staf: 5,
    kebersihan: 5,
    nps: 9
}">
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl p-8 text-white shadow-xl relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 opacity-10 text-9xl font-black select-none pointer-events-none">⭐</div>
        <div class="relative z-10 max-w-2xl">
            <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-bold uppercase tracking-wider text-blue-100 mb-3 inline-block">Survei CRM Klinik</span>
            <h1 class="text-3xl font-extrabold tracking-tight mb-2">Survei Kepuasan Layanan Klinik</h1>
            <p class="text-blue-100 text-sm leading-relaxed">
                Masukan dan penilaian Anda sangat berharga bagi kami untuk terus meningkatkan kualitas pelayanan medis, kebersihan, dan kenyamanan di Klinik Orinda.
            </p>
        </div>
    </div>

    <!-- Main Survey Card -->
    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-xl">
        <form action="{{ route('pasien.survei.store') }}" method="POST" class="space-y-8">
            @csrf

            <div class="border-b border-slate-100 pb-4">
                <h2 class="text-xl font-bold text-slate-800">Formulir Penilaian Layanan</h2>
                <p class="text-xs text-slate-400 mt-1">Berikan penilaian objektif Anda mengenai pengalaman berobat dan berkunjung di klinik kami.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- 1. Pendaftaran & Loket -->
                <div class="bg-slate-50/80 p-6 rounded-2xl border border-slate-100 space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="font-bold text-slate-800 text-sm flex items-center gap-2">
                            <span>📝</span> Pelayanan Pendaftaran & Kasir
                        </label>
                        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-lg" x-text="pendaftaran + ' / 5 Star'"></span>
                    </div>
                    <p class="text-xs text-slate-500">Kecepatan, kemudahan, dan ketepatan alur pendaftaran antrean.</p>
                    <div class="flex items-center gap-2 pt-2">
                        @for($i = 1; $i <= 5; $i++)
                        <button type="button" @click="pendaftaran = {{ $i }}" class="flex-1 py-3 rounded-xl border text-sm font-bold transition-all flex items-center justify-center gap-1"
                            :class="pendaftaran >= {{ $i }} ? 'bg-amber-400 border-amber-500 text-white shadow-sm shadow-amber-200' : 'bg-white border-slate-200 text-slate-400 hover:border-slate-300'">
                            ★ {{ $i }}
                        </button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating_pendaftaran" :value="pendaftaran">
                </div>

                <!-- 2. Kualitas Fasilitas -->
                <div class="bg-slate-50/80 p-6 rounded-2xl border border-slate-100 space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="font-bold text-slate-800 text-sm flex items-center gap-2">
                            <span>🏥</span> Kelengkapan & Kualitas Fasilitas
                        </label>
                        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-lg" x-text="fasilitas + ' / 5 Star'"></span>
                    </div>
                    <p class="text-xs text-slate-500">Kenyamanan ruang tunggu, pendingin udara, kursi, dan sarana umum.</p>
                    <div class="flex items-center gap-2 pt-2">
                        @for($i = 1; $i <= 5; $i++)
                        <button type="button" @click="fasilitas = {{ $i }}" class="flex-1 py-3 rounded-xl border text-sm font-bold transition-all flex items-center justify-center gap-1"
                            :class="fasilitas >= {{ $i }} ? 'bg-amber-400 border-amber-500 text-white shadow-sm shadow-amber-200' : 'bg-white border-slate-200 text-slate-400 hover:border-slate-300'">
                            ★ {{ $i }}
                        </button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating_fasilitas" :value="fasilitas">
                </div>

                <!-- 3. Keramahan Staf -->
                <div class="bg-slate-50/80 p-6 rounded-2xl border border-slate-100 space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="font-bold text-slate-800 text-sm flex items-center gap-2">
                            <span>👥</span> Keramahan & Respons Staf / Perawat
                        </label>
                        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-lg" x-text="staf + ' / 5 Star'"></span>
                    </div>
                    <p class="text-xs text-slate-500">Sikap sopan, kejelasan informasi, dan kesigapan petugas klinik.</p>
                    <div class="flex items-center gap-2 pt-2">
                        @for($i = 1; $i <= 5; $i++)
                        <button type="button" @click="staf = {{ $i }}" class="flex-1 py-3 rounded-xl border text-sm font-bold transition-all flex items-center justify-center gap-1"
                            :class="staf >= {{ $i }} ? 'bg-amber-400 border-amber-500 text-white shadow-sm shadow-amber-200' : 'bg-white border-slate-200 text-slate-400 hover:border-slate-300'">
                            ★ {{ $i }}
                        </button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating_pelayanan_staf" :value="staf">
                </div>

                <!-- 4. Kebersihan Lingkungan -->
                <div class="bg-slate-50/80 p-6 rounded-2xl border border-slate-100 space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="font-bold text-slate-800 text-sm flex items-center gap-2">
                            <span>✨</span> Kebersihan & Kerapian Klinik
                        </label>
                        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-lg" x-text="kebersihan + ' / 5 Star'"></span>
                    </div>
                    <p class="text-xs text-slate-500">Kebersihan toilet, area medis, ruang tunggu, serta kerapian lingkungan.</p>
                    <div class="flex items-center gap-2 pt-2">
                        @for($i = 1; $i <= 5; $i++)
                        <button type="button" @click="kebersihan = {{ $i }}" class="flex-1 py-3 rounded-xl border text-sm font-bold transition-all flex items-center justify-center gap-1"
                            :class="kebersihan >= {{ $i }} ? 'bg-amber-400 border-amber-500 text-white shadow-sm shadow-amber-200' : 'bg-white border-slate-200 text-slate-400 hover:border-slate-300'">
                            ★ {{ $i }}
                        </button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating_kebersihan" :value="kebersihan">
                </div>
            </div>

            <!-- Net Promoter Score (NPS 1-10) -->
            <div class="bg-indigo-50/60 p-6 rounded-2xl border border-indigo-100 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <label class="font-bold text-slate-800 text-sm flex items-center gap-2">
                            <span>📣</span> Rekomendasi Klinik (Net Promoter Score)
                        </label>
                        <p class="text-xs text-slate-500 mt-0.5">Seberapa mungkin Anda merekomendasikan Klinik Orinda kepada kerabat atau keluarga?</p>
                    </div>
                    <span class="text-sm font-extrabold text-indigo-700 bg-indigo-100 px-3 py-1 rounded-xl" x-text="nps + ' / 10'"></span>
                </div>

                <div class="grid grid-cols-5 md:grid-cols-10 gap-2 pt-2">
                    @for($i = 1; $i <= 10; $i++)
                    <button type="button" @click="nps = {{ $i }}"
                        class="py-2.5 rounded-xl border font-bold text-xs transition-all flex items-center justify-center"
                        :class="nps === {{ $i }} ? 'bg-indigo-600 border-indigo-700 text-white shadow-md shadow-indigo-200 scale-105' : 'bg-white border-slate-200 text-slate-700 hover:border-indigo-300'">
                        {{ $i }}
                    </button>
                    @endfor
                </div>
                <div class="flex justify-between text-[11px] font-semibold text-slate-400 px-1">
                    <span>1: Sangat Tidak Mungkin</span>
                    <span>10: Sangat Rekomendasi</span>
                </div>
                <input type="hidden" name="rekomendasi_nps" :value="nps">
            </div>

            <!-- Ulasan, Kritik & Saran -->
            <div class="space-y-2">
                <label class="block text-sm font-bold text-slate-800">Ulasan, Kritik & Saran Tambahan (Opsional)</label>
                <textarea name="saran_masukan" rows="4" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none transition text-sm text-slate-800 placeholder-slate-400" placeholder="Tuliskan masukan atau saran konstruktif Anda untuk Klinik Orinda..."></textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-base rounded-2xl shadow-lg shadow-blue-200 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                <span>🚀</span> KIRIM SURVEI KEPUASAN
            </button>
        </form>
    </div>

    <!-- Riwayat Survei Pasien -->
    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-xl space-y-6">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Riwayat Tanggapan Survei Saya</h3>
                <p class="text-xs text-slate-400">Daftar survei kepuasan yang pernah Anda kirimkan sebelumnya.</p>
            </div>
            <span class="px-3 py-1 bg-slate-100 text-slate-700 font-bold text-xs rounded-full">{{ $riwayatSurvei->count() }} Kali Pengisian</span>
        </div>

        @if($riwayatSurvei->isEmpty())
        <div class="text-center py-10 text-slate-400">
            <span class="text-4xl block mb-2">📋</span>
            <p class="text-sm font-medium">Anda belum pernah mengisi survei kepuasan.</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[11px] tracking-wider">
                    <tr>
                        <th class="px-4 py-3 rounded-l-xl">Tanggal</th>
                        <th class="px-4 py-3">Pendaftaran</th>
                        <th class="px-4 py-3">Fasilitas</th>
                        <th class="px-4 py-3">Pelayanan Staf</th>
                        <th class="px-4 py-3">Kebersihan</th>
                        <th class="px-4 py-3">NPS</th>
                        <th class="px-4 py-3 rounded-r-xl">Saran & Masukan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($riwayatSurvei as $s)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-4 py-4 font-semibold text-slate-700 whitespace-nowrap">
                            {{ $s->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-4 py-4 text-amber-500 font-bold">★ {{ $s->rating_pendaftaran }}</td>
                        <td class="px-4 py-4 text-amber-500 font-bold">★ {{ $s->rating_fasilitas }}</td>
                        <td class="px-4 py-4 text-amber-500 font-bold">★ {{ $s->rating_pelayanan_staf }}</td>
                        <td class="px-4 py-4 text-amber-500 font-bold">★ {{ $s->rating_kebersihan }}</td>
                        <td class="px-4 py-4">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-extrabold bg-indigo-50 text-indigo-700">
                                {{ $s->rekomendasi_nps }} / 10
                            </span>
                        </td>
                        <td class="px-4 py-4 text-slate-600 italic text-xs max-w-xs truncate">
                            {{ $s->saran_masukan ? '"' . $s->saran_masukan . '"' : '-' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection
