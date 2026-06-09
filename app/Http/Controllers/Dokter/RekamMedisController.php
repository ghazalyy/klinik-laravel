<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;
use App\Models\AntreanOffline;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RekamMedisController extends Controller
{
    public function index(Request $request)
    {
        $dokter = Auth::user()->dokter;
        if (!$dokter) {
            return redirect()->route('login')->with('error', 'Profil dokter tidak ditemukan.');
        }

        $query = RekamMedis::where('dokter_id', $dokter->id)->with('pasien');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('pasien', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%");
            });
        }

        $rekamMedis = $query->latest('tanggal_periksa')->paginate(15);

        return view('dokter.rekam-medis.index', compact('rekamMedis'));
    }

    public function create(Request $request)
    {
        $dokter = Auth::user()->dokter;
        if (!$dokter) {
            return redirect()->route('login')->with('error', 'Profil dokter tidak ditemukan.');
        }

        $booking = null;
        $antreanOffline = null;

        if ($request->has('booking_id')) {
            $booking = Booking::with('pasien')
                ->where('dokter_id', $dokter->id)
                ->findOrFail($request->booking_id);
        }

        if ($request->has('antrean_offline_id')) {
            $antreanOffline = AntreanOffline::with('pasien')
                ->where('dokter_id', $dokter->id)
                ->findOrFail($request->antrean_offline_id);
        }

        $pasiens = User::where('role', 'pasien')->orderBy('nama_lengkap')->get();

        return view('dokter.rekam-medis.create', compact('booking', 'antreanOffline', 'pasiens'));
    }

    public function store(Request $request)
    {
        $dokter = Auth::user()->dokter;
        if (!$dokter) {
            return redirect()->route('login')->with('error', 'Profil dokter tidak ditemukan.');
        }

        $validated = $request->validate([
            'pasien_id'          => 'required|exists:users,id',
            'booking_id'         => 'nullable|exists:booking,id',
            'antrean_offline_id' => 'nullable|exists:antrean_offline,id',
            'tanggal_periksa'    => 'required|date',
            'keluhan'            => 'required|string',
            'diagnosa'           => 'required|string',
            'tindakan'           => 'required|string',
            'resep_obat'         => 'required|string',
            'catatan'            => 'nullable|string',
        ]);

        $validated['dokter_id'] = $dokter->id;

        $rekamMedis = RekamMedis::create($validated);

        // Update status sesi booking ke selesai
        if ($request->filled('booking_id')) {
            $booking = Booking::where('id', $request->booking_id)
                ->where('dokter_id', $dokter->id)
                ->first();
            if ($booking) {
                $booking->update(['status_sesi' => 'selesai']);
            }
        }

        // Update status antrean offline ke selesai
        if ($request->filled('antrean_offline_id')) {
            $antrean = AntreanOffline::where('id', $request->antrean_offline_id)
                ->where('dokter_id', $dokter->id)
                ->first();
            if ($antrean) {
                $antrean->update(['status' => 'selesai']);
            }
        }

        return redirect()->route('dokter.rekam-medis.index')->with('success', 'Rekam medis berhasil disimpan.');
    }

    public function show($id)
    {
        $dokter = Auth::user()->dokter;
        $rekamMedis = RekamMedis::with(['pasien', 'dokter.user'])->findOrFail($id);

        if ($rekamMedis->dokter_id !== $dokter->id) {
            abort(403, 'Anda tidak memiliki akses ke rekam medis ini.');
        }

        return view('dokter.rekam-medis.show', compact('rekamMedis'));
    }

    public function edit($id)
    {
        $dokter = Auth::user()->dokter;
        $rekamMedis = RekamMedis::with('pasien')->findOrFail($id);

        if ($rekamMedis->dokter_id !== $dokter->id) {
            abort(403, 'Anda tidak memiliki akses ke rekam medis ini.');
        }

        return view('dokter.rekam-medis.edit', compact('rekamMedis'));
    }

    public function update(Request $request, $id)
    {
        $dokter = Auth::user()->dokter;
        $rekamMedis = RekamMedis::findOrFail($id);

        if ($rekamMedis->dokter_id !== $dokter->id) {
            abort(403, 'Anda tidak memiliki akses ke rekam medis ini.');
        }

        $validated = $request->validate([
            'tanggal_periksa' => 'required|date',
            'keluhan'          => 'required|string',
            'diagnosa'         => 'required|string',
            'tindakan'         => 'required|string',
            'resep_obat'       => 'required|string',
            'catatan'          => 'nullable|string',
        ]);

        $rekamMedis->update($validated);

        return redirect()->route('dokter.rekam-medis.index')->with('success', 'Rekam medis berhasil diperbarui.');
    }
}
