@extends('layouts.admin')
@section('title', 'CRM Analitik Pasien')

@section('content')
<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <p class="text-sm font-medium text-gray-500">Total Pasien</p>
        <p class="text-3xl font-bold text-blue-600 mt-2">{{ $totalPasien }}</p>
        <p class="text-xs text-green-600 mt-1">+{{ $pasienBaru }} bulan ini</p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <p class="text-sm font-medium text-gray-500">Total Konsultasi</p>
        <p class="text-3xl font-bold text-purple-600 mt-2">{{ $totalBooking }}</p>
        <p class="text-xs text-purple-600 mt-1">{{ $bookingBulanIni }} bulan ini</p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <p class="text-sm font-medium text-gray-500">Pasien Loyal (Selesai)</p>
        <p class="text-3xl font-bold text-green-600 mt-2">{{ $pasienSelesai }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Trend Chart -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-semibold mb-4">Tren Kunjungan (6 Bulan Terakhir)</h3>
        <canvas id="trendChart" height="200"></canvas>
    </div>

    <!-- Popular Doctors -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-semibold mb-4">Dokter Terpopuler</h3>
        <div class="space-y-4">
            @foreach($dokterPopuler as $dp)
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-xl">👨‍⚕️</div>
                    <div>
                        <p class="font-medium text-gray-800">{{ $dp->dokter->user->nama_lengkap }}</p>
                        <p class="text-xs text-gray-500">{{ $dp->dokter->spesialisasi }}</p>
                    </div>
                </div>
                <span class="px-3 py-1 bg-blue-50 text-blue-700 text-xs font-bold rounded-full">{{ $dp->total }} Booking</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Patient Satisfaction Survey Analytics Section -->
<div class="mb-8 space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                <span>⭐</span> Analitik Kepuasan Pasien (CRM Survey)
            </h3>
            <p class="text-xs text-gray-500 mt-1">Umpan balik dan penilaian kualitas layanan fasilitas klinik secara keseluruhan dari pasien.</p>
        </div>
        <span class="px-3 py-1.5 bg-indigo-50 text-indigo-700 font-extrabold text-xs rounded-xl border border-indigo-100">
            Total {{ $totalSurvei }} Tanggapan
        </span>
    </div>

    <!-- Survey Score Cards -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 text-center">
            <p class="text-xs text-gray-400 font-semibold uppercase">Pendaftaran</p>
            <p class="text-2xl font-black text-amber-500 mt-1">★ {{ $avgPendaftaran }} <span class="text-xs font-normal text-gray-400">/ 5</span></p>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 text-center">
            <p class="text-xs text-gray-400 font-semibold uppercase">Fasilitas</p>
            <p class="text-2xl font-black text-amber-500 mt-1">★ {{ $avgFasilitas }} <span class="text-xs font-normal text-gray-400">/ 5</span></p>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 text-center">
            <p class="text-xs text-gray-400 font-semibold uppercase">Pelayanan Staf</p>
            <p class="text-2xl font-black text-amber-500 mt-1">★ {{ $avgPelayananStaf }} <span class="text-xs font-normal text-gray-400">/ 5</span></p>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 text-center">
            <p class="text-xs text-gray-400 font-semibold uppercase">Kebersihan</p>
            <p class="text-2xl font-black text-amber-500 mt-1">★ {{ $avgKebersihan }} <span class="text-xs font-normal text-gray-400">/ 5</span></p>
        </div>
        <div class="bg-indigo-600 p-4 rounded-xl shadow-md text-white text-center col-span-2 md:col-span-1">
            <p class="text-xs text-indigo-200 font-semibold uppercase">NPS Rekomendasi</p>
            <p class="text-2xl font-black mt-1">{{ $avgNps }} <span class="text-xs font-normal text-indigo-200">/ 10</span></p>
        </div>
    </div>

    <!-- Recent Feedback Table -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h4 class="text-base font-bold text-gray-800 mb-4">Umpan Balik & Saran Pasien Terbaru</h4>
        @if($surveiTerbaru->isEmpty())
        <p class="text-xs text-gray-400 text-center py-4">Belum ada survei kepuasan yang diisi oleh pasien.</p>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">Pasien</th>
                        <th class="px-4 py-3">Rata-Rata Rating</th>
                        <th class="px-4 py-3">NPS</th>
                        <th class="px-4 py-3">Kritik / Saran Masukan</th>
                        <th class="px-4 py-3">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($surveiTerbaru as $st)
                    @php
                        $avg = round(($st->rating_pendaftaran + $st->rating_fasilitas + $st->rating_pelayanan_staf + $st->rating_kebersihan) / 4, 1);
                    @endphp
                    <tr>
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $st->pasien->nama_lengkap }}</td>
                        <td class="px-4 py-3 text-amber-500 font-bold">★ {{ $avg }} / 5</td>
                        <td class="px-4 py-3">
                            <span class="px-2.5 py-1 bg-indigo-50 text-indigo-700 text-xs font-bold rounded-lg">
                                {{ $st->rekomendasi_nps }} / 10
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-600 text-xs italic max-w-sm truncate">
                            {{ $st->saran_masukan ? '"' . $st->saran_masukan . '"' : '-' }}
                        </td>
                        <td class="px-4 py-3 text-gray-400 text-xs whitespace-nowrap">
                            {{ $st->created_at->diffForHumans() }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>

<!-- Inactive Patients -->
<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h3 class="text-lg font-semibold mb-4">Pasien Tidak Aktif (>90 Hari)</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Nama Pasien</th>
                    <th class="px-4 py-3">Telepon</th>
                    <th class="px-4 py-3">Terakhir Booking</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($pasienTidakAktif as $p)
                <tr>
                    <td class="px-4 py-3 font-medium">{{ $p->nama_lengkap }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $p->no_telepon ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-500">
                        {{ $p->bookings->max('tanggal_booking') ? \Carbon\Carbon::parse($p->bookings->max('tanggal_booking'))->format('d M Y') : 'N/A' }}
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('admin.crm.pasien', $p->id) }}" class="text-blue-600 hover:underline">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode(collect($trendData)->pluck('bulan')) !!},
            datasets: [{
                label: 'Jumlah Kunjungan',
                data: {!! json_encode(collect($trendData)->pluck('jumlah')) !!},
                borderColor: '#2563eb',
                tension: 0.4,
                fill: true,
                backgroundColor: 'rgba(37, 99, 235, 0.1)'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });
</script>
@endpush
@endsection
