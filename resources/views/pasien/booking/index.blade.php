@extends('layouts.pasien')
@section('title', 'Booking Konsultasi')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-xl font-semibold text-gray-700 mb-6">Form Booking Konsultasi</h2>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
            @foreach($errors->all() as $error)<p class="text-sm">• {{ $error }}</p>@endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('pasien.booking.store') }}" class="bg-white rounded-xl shadow-sm p-8 space-y-6">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Dokter</label>
            <select name="dokter_id" id="dokter_select" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                <option value="">-- Pilih Dokter --</option>
                @foreach($dokters as $d)
                    <option value="{{ $d->id }}" {{ old('dokter_id') == $d->id ? 'selected' : '' }}>
                        {{ $d->user->nama_lengkap }} — {{ $d->spesialisasi }} (Rp {{ number_format($d->harga_sesi, 0, ',', '.') }})
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Booking</label>
            <input type="date" name="tanggal_booking" value="{{ old('tanggal_booking') }}"
                min="{{ date('Y-m-d') }}" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
        </div>

        <div id="jadwal_section" class="hidden">
            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Jadwal <span class="text-gray-400">(opsional)</span></label>
            <select name="jadwal_id" id="jadwal_select"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                <option value="">-- Tanpa Jadwal Spesifik --</option>
            </select>
        </div>

        <div class="bg-blue-50 rounded-lg p-4 text-sm text-blue-700">
            ℹ️ Setelah booking, Anda akan diarahkan ke halaman pembayaran via <strong>Midtrans Snap</strong>.
        </div>

        <button type="submit"
            class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
            Buat Booking →
        </button>
    </form>
</div>

@push('scripts')
<script>
const jadwalData = @json($dokters->keyBy('id')->map(fn($d) => $d->jadwalDokter->where('status', 'tersedia')->values()));

document.getElementById('dokter_select').addEventListener('change', function() {
    const id = this.value;
    const section = document.getElementById('jadwal_section');
    const select = document.getElementById('jadwal_select');

    select.innerHTML = '<option value="">-- Tanpa Jadwal Spesifik --</option>';

    if (id && jadwalData[id]) {
        jadwalData[id].forEach(j => {
            select.innerHTML += `<option value="${j.id}">${j.hari} ${j.jam_mulai.substring(0,5)}-${j.jam_selesai.substring(0,5)} (${j.jenis_layanan})</option>`;
        });
        section.classList.remove('hidden');
    } else {
        section.classList.add('hidden');
    }
});
</script>
@endpush
@endsection
