<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AntreanOffline;
use App\Models\Dokter;
use Illuminate\Http\Request;

class AntreanController extends Controller
{
    public function index()
    {
        $antreans = AntreanOffline::with(['pasien', 'dokter.user'])
            ->whereDate('tanggal_kunjungan', today())
            ->orderBy('nomor_antrean')
            ->get();
        $dokters = Dokter::with('user')->get();
        return view('admin.antrean.index', compact('antreans', 'dokters'));
    }

    public function updateStatus(Request $request, $id)
    {
        $antrean = AntreanOffline::findOrFail($id);
        $validated = $request->validate([
            'status' => 'required|in:menunggu,dipanggil,selesai,batal',
        ]);
        $antrean->update($validated);
        return redirect()->route('admin.antrean.index')->with('success', 'Status antrean diperbarui.');
    }
}
