@extends('layouts.pasien')
@section('title', 'Beri Ulasan Dokter')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-gray-800">Ulasan & Rating</h2>
        <p class="text-gray-500 mt-2">Bagaimana pengalaman konsultasi Anda dengan Dr. {{ $booking->dokter->user->nama_lengkap }}?</p>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
        <form action="{{ route('pasien.ulasan.store', $booking->id) }}" method="POST" class="space-y-8">
            @csrf
            
            <!-- Pelayanan -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-4">Rating Pelayanan Medis / Tindakan</label>
                <div class="flex items-center gap-4">
                    @for($i=1; $i<=5; $i++)
                    <label class="cursor-pointer">
                        <input type="radio" name="rating_pelayanan" value="{{ $i }}" class="hidden peer" required>
                        <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-gray-50 text-gray-400 border border-transparent peer-checked:bg-yellow-400 peer-checked:text-white peer-checked:border-yellow-500 transition-all font-bold">
                            {{ $i }}
                        </div>
                    </label>
                    @endfor
                </div>
            </div>

            <!-- Komunikasi -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-4">Rating Komunikasi / Penjelasan Dokter</label>
                <div class="flex items-center gap-4">
                    @for($i=1; $i<=5; $i++)
                    <label class="cursor-pointer">
                        <input type="radio" name="rating_komunikasi" value="{{ $i }}" class="hidden peer" required>
                        <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-gray-50 text-gray-400 border border-transparent peer-checked:bg-blue-500 peer-checked:text-white peer-checked:border-blue-600 transition-all font-bold">
                            {{ $i }}
                        </div>
                    </label>
                    @endfor
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Ulasan / Kritik & Saran (Opsional)</label>
                <textarea name="ulasan" rows="4" class="w-full px-4 py-3 bg-gray-50 border border-transparent rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none transition" placeholder="Tuliskan ulasan Anda..."></textarea>
            </div>

            <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-blue-200 shadow-lg transition">
                KIRIM ULASAN
            </button>
        </form>
    </div>
</div>
@endsection
