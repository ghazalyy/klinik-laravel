<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\AntreanOffline;
use App\Models\Dokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AntreanController extends Controller
{
    public function index()
    {
        $dokters = Dokter::with('user')->get();
        return view('pasien.antrean.index', compact('dokters'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dokter_id'        => 'required|exists:dokter,id',
            'tujuan_kunjungan' => 'nullable|string|max:500',
        ]);

        // Nomor antrean: hitung yang sudah ada hari ini untuk dokter ini + 1
        $nomor = AntreanOffline::where('dokter_id', $validated['dokter_id'])
            ->whereDate('tanggal_kunjungan', today())
            ->count() + 1;

        $antrean = AntreanOffline::create([
            'pasien_id'        => Auth::id(),
            'dokter_id'        => $validated['dokter_id'],
            'nomor_antrean'    => $nomor,
            'tanggal_kunjungan'=> today(),
            'tujuan_kunjungan' => $validated['tujuan_kunjungan'],
        ]);

        return redirect()->route('pasien.antrean.riwayat')
            ->with('success', "Berhasil mengambil nomor antrean #{$antrean->nomor_antrean}.");
    }

    public function riwayat()
    {
        $antreans = AntreanOffline::where('pasien_id', Auth::id())
            ->with('dokter.user')
            ->orderByDesc('tanggal_kunjungan')
            ->paginate(15);

        return view('pasien.antrean.riwayat', compact('antreans'));
    }
}
