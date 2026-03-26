<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\ReviewDokter;

class SpkController extends Controller
{
    public function index()
    {
        $dokters = Dokter::with(['user', 'reviewDokter'])->get();

        // SAW Method
        // Kriteria: C1=rating_pelayanan (bobot 0.6), C2=rating_komunikasi (bobot 0.4)
        $c1_weight = 0.6;
        $c2_weight = 0.4;

        $data = $dokters->map(function ($dokter) {
            $reviews = $dokter->reviewDokter;
            $jumlah  = $reviews->count();
            return [
                'dokter'             => $dokter,
                'jumlah_review'      => $jumlah,
                'avg_pelayanan'      => $jumlah ? round($reviews->avg('rating_pelayanan'), 2) : 0,
                'avg_komunikasi'     => $jumlah ? round($reviews->avg('rating_komunikasi'), 2) : 0,
            ];
        });

        // Normalisasi (benefit criteria)
        $maxPelayanan  = $data->max('avg_pelayanan') ?: 1;
        $maxKomunikasi = $data->max('avg_komunikasi') ?: 1;

        $ranked = $data->map(function ($row) use ($maxPelayanan, $maxKomunikasi, $c1_weight, $c2_weight) {
            $normPelayanan  = $row['avg_pelayanan'] / $maxPelayanan;
            $normKomunikasi = $row['avg_komunikasi'] / $maxKomunikasi;
            $nilai_akhir    = ($normPelayanan * $c1_weight) + ($normKomunikasi * $c2_weight);
            return array_merge($row, [
                'norm_pelayanan'  => round($normPelayanan, 4),
                'norm_komunikasi' => round($normKomunikasi, 4),
                'nilai_akhir'     => round($nilai_akhir, 4),
            ]);
        })->sortByDesc('nilai_akhir')->values();

        return view('admin.spk', compact('ranked', 'c1_weight', 'c2_weight'));
    }
}
