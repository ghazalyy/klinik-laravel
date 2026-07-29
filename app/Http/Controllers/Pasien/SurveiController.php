<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\SurveiKepuasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveiController extends Controller
{
    public function index()
    {
        $pasienId = Auth::id();
        $riwayatSurvei = SurveiKepuasan::where('pasien_id', $pasienId)
            ->orderByDesc('created_at')
            ->get();

        return view('pasien.survei.index', compact('riwayatSurvei'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rating_pendaftaran'   => 'required|integer|min:1|max:5',
            'rating_fasilitas'     => 'required|integer|min:1|max:5',
            'rating_pelayanan_staf'=> 'required|integer|min:1|max:5',
            'rating_kebersihan'    => 'required|integer|min:1|max:5',
            'rekomendasi_nps'      => 'required|integer|min:1|max:10',
            'saran_masukan'        => 'nullable|string|max:1000',
        ]);

        SurveiKepuasan::create([
            'pasien_id'            => Auth::id(),
            'rating_pendaftaran'   => $validated['rating_pendaftaran'],
            'rating_fasilitas'     => $validated['rating_fasilitas'],
            'rating_pelayanan_staf'=> $validated['rating_pelayanan_staf'],
            'rating_kebersihan'    => $validated['rating_kebersihan'],
            'rekomendasi_nps'      => $validated['rekomendasi_nps'],
            'saran_masukan'        => $validated['saran_masukan'] ?? null,
        ]);

        return redirect()->route('pasien.survei.index')
            ->with('success', 'Terima kasih atas partisipasi Anda dalam survei kepuasan layanan Klinik Orinda!');
    }
}
