<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Dokter;

class PublicController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return match (Auth::user()->role) {
                'admin'  => redirect()->route('admin.dashboard'),
                'dokter' => redirect()->route('dokter.dashboard'),
                default  => redirect()->route('pasien.dashboard'),
            };
        }

        $dokters = Dokter::with('user')->where('status_online', 'Online')->get();
        $allDokters = Dokter::with('user')->get();
        return view('public.index', compact('dokters', 'allDokters'));
    }

    public function jadwal()
    {
        $dokters = Dokter::with(['user', 'jadwalDokter'])->get();
        return view('public.jadwal', compact('dokters'));
    }

    public function tentang()
    {
        return view('public.tentang');
    }

    public function profil()
    {
        $user = Auth::user();
        return view('public.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();
        $rules = [
            'nama_lengkap' => 'required|string|max:100',
            'no_telepon'   => 'nullable|string|max:20',
            'alamat'       => 'nullable|string',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:6|confirmed';
        }

        $validated = $request->validate($rules);

        $user->nama_lengkap = $validated['nama_lengkap'];
        $user->no_telepon   = $validated['no_telepon'] ?? $user->no_telepon;
        $user->alamat       = $validated['alamat'] ?? $user->alamat;

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
