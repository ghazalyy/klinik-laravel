<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RekamMedisController extends Controller
{
    public function index()
    {
        $rekamMedis = RekamMedis::where('pasien_id', Auth::id())
            ->with('dokter.user')
            ->latest('tanggal_periksa')
            ->paginate(15);

        return view('pasien.rekam-medis.index', compact('rekamMedis'));
    }

    public function show($id)
    {
        $rekamMedis = RekamMedis::with(['dokter.user'])->findOrFail($id);

        if ($rekamMedis->pasien_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke rekam medis ini.');
        }

        return view('pasien.rekam-medis.show', compact('rekamMedis'));
    }
}
