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
