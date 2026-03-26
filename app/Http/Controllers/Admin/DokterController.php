<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\User;
use App\Models\JadwalDokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DokterController extends Controller
{
    public function index()
    {
        $dokters = Dokter::with('user')->get();
        return view('admin.dokter.index', compact('dokters'));
    }

    public function create()
    {
        return view('admin.dokter.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'username'     => 'required|string|max:50|unique:users,username',
            'password'     => 'required|string|min:6',
            'spesialisasi' => 'required|string|max:100',
            'deskripsi'    => 'nullable|string',
            'harga_sesi'   => 'required|numeric|min:0',
            'foto_profil'  => 'nullable|image|max:2048',
        ]);

        $user = User::create([
            'nama_lengkap' => $validated['nama_lengkap'],
            'username'     => $validated['username'],
            'password'     => Hash::make($validated['password']),
            'role'         => 'dokter',
        ]);

        $fotoPath = 'default.png';
        if ($request->hasFile('foto_profil')) {
            $fotoPath = $request->file('foto_profil')->store('foto_dokter', 'public');
        }

        Dokter::create([
            'user_id'      => $user->id,
            'spesialisasi' => $validated['spesialisasi'],
            'deskripsi'    => $validated['deskripsi'],
            'harga_sesi'   => $validated['harga_sesi'],
            'foto_profil'  => $fotoPath,
        ]);

        return redirect()->route('admin.dokter.index')->with('success', 'Dokter berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $dokter = Dokter::with('user')->findOrFail($id);
        return view('admin.dokter.edit', compact('dokter'));
    }

    public function update(Request $request, $id)
    {
        $dokter = Dokter::with('user')->findOrFail($id);
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'spesialisasi' => 'required|string|max:100',
            'deskripsi'    => 'nullable|string',
            'harga_sesi'   => 'required|numeric|min:0',
            'status_online'=> 'required|in:Online,Offline',
            'foto_profil'  => 'nullable|image|max:2048',
        ]);

        $dokter->user->update(['nama_lengkap' => $validated['nama_lengkap']]);

        if ($request->hasFile('foto_profil')) {
            $validated['foto_profil'] = $request->file('foto_profil')->store('foto_dokter', 'public');
        } else {
            unset($validated['foto_profil']);
        }
        unset($validated['nama_lengkap']);

        $dokter->update($validated);

        return redirect()->route('admin.dokter.index')->with('success', 'Data dokter berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $dokter = Dokter::findOrFail($id);
        $dokter->user->delete(); // cascade ke dokter
        return redirect()->route('admin.dokter.index')->with('success', 'Dokter berhasil dihapus.');
    }

    public function show($id) {
        return redirect()->route('admin.dokter.edit', $id);
    }
}
