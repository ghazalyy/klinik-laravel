@extends('layouts.admin')
@section('title', 'SPK Pemeringkatan Dokter (SAW)')

@section('content')
<div class="mb-6 bg-blue-50 border border-blue-200 rounded-xl p-4 text-sm text-blue-700">
    <strong>Metode SAW (Simple Additive Weighting)</strong>
    — Kriteria: C1 = Rating Pelayanan (bobot <strong>{{ $c1_weight * 100 }}%</strong>),
    C2 = Rating Komunikasi (bobot <strong>{{ $c2_weight * 100 }}%</strong>)
</div>

@if($ranked->isEmpty())
    <div class="bg-white rounded-xl p-12 text-center text-gray-500">Belum ada data review dokter.</div>
@else
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Rank</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Dokter</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Jml Review</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase">C1 Pelayanan</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase">C2 Komunikasi</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Norm C1</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Norm C2</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Nilai Akhir</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($ranked as $i => $row)
                <tr class="{{ $i === 0 ? 'bg-yellow-50' : '' }}">
                    <td class="px-4 py-3 font-bold text-lg">
                        @if($i === 0) 🥇 @elseif($i === 1) 🥈 @elseif($i === 2) 🥉 @else #{{ $i+1 }} @endif
                    </td>
                    <td class="px-4 py-3">
                        <p class="font-semibold text-gray-800">{{ $row['dokter']->user->nama_lengkap }}</p>
                        <p class="text-gray-500 text-xs">{{ $row['dokter']->spesialisasi }}</p>
                    </td>
                    <td class="px-4 py-3 text-center">{{ $row['jumlah_review'] }}</td>
                    <td class="px-4 py-3 text-center text-yellow-600 font-semibold">{{ $row['avg_pelayanan'] }}/5</td>
                    <td class="px-4 py-3 text-center text-blue-600 font-semibold">{{ $row['avg_komunikasi'] }}/5</td>
                    <td class="px-4 py-3 text-center text-gray-600">{{ $row['norm_pelayanan'] }}</td>
                    <td class="px-4 py-3 text-center text-gray-600">{{ $row['norm_komunikasi'] }}</td>
                    <td class="px-4 py-3 text-center font-bold text-green-700 text-base">{{ $row['nilai_akhir'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
