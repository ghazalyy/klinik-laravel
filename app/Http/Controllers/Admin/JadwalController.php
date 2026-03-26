<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalDokter;
use App\Models\Dokter;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwals = JadwalDokter::with('dokter.user')->orderBy('dokter_id')->get();
        $dokters = Dokter::with('user')->get();
        return view('admin.jadwal.index', compact('jadwals', 'dokters'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dokter_id'     => 'required|exists:dokter,id',
            'hari'          => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai'     => 'required',
            'jam_selesai'   => 'required',
            'jenis_layanan' => 'required|in:Online,Offline',
        ]);
        JadwalDokter::create($validated);
        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $jadwal = JadwalDokter::findOrFail($id);
        $validated = $request->validate([
            'status' => 'required|in:tersedia,tidak_tersedia',
        ]);
        $jadwal->update($validated);
        return redirect()->route('admin.jadwal.index')->with('success', 'Status jadwal diperbarui.');
    }

    public function destroy($id)
    {
        JadwalDokter::findOrFail($id)->delete();
        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal dihapus.');
    }
}
