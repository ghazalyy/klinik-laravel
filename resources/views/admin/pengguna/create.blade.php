@extends('layouts.admin')
@section('title', 'Tambah Pengguna')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.pengguna.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-700 font-medium transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Daftar Pengguna
        </a>
        <h3 class="text-xl font-bold text-slate-800 mt-2">Tambah Pengguna Baru</h3>
        <p class="text-xs text-slate-500 mt-1 uppercase tracking-wider font-medium">Buat akun baru untuk Admin, Dokter, atau Pasien</p>
    </div>

    <div class="premium-card bg-white rounded-2xl shadow-sm border border-slate-200/60 p-8">
        <form action="{{ route('admin.pengguna.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Nama Lengkap --}}
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 transition @error('nama_lengkap') border-red-400 bg-red-50 @enderror"
                       placeholder="Nama lengkap pengguna">
                @error('nama_lengkap') <p class="text-red-500 text-[11px] mt-1 font-medium">{{ $message }}</p> @enderror
            </div>

            {{-- Username --}}
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Username <span class="text-red-500">*</span></label>
                <input type="text" name="username" value="{{ old('username') }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 transition font-mono @error('username') border-red-400 bg-red-50 @enderror"
                       placeholder="Username unik (tanpa spasi)">
                @error('username') <p class="text-red-500 text-[11px] mt-1 font-medium">{{ $message }}</p> @enderror
            </div>

            {{-- Role --}}
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Role Akses <span class="text-red-500">*</span></label>
                <select name="role" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 transition @error('role') border-red-400 bg-red-50 @enderror">
                    <option value="">-- Pilih Role --</option>
                    <option value="admin"  {{ old('role') === 'admin'  ? 'selected' : '' }}>Admin</option>
                    <option value="dokter" {{ old('role') === 'dokter' ? 'selected' : '' }}>Dokter</option>
                    <option value="pasien" {{ old('role') === 'pasien' ? 'selected' : '' }}>Pasien</option>
                </select>
                @error('role') <p class="text-red-500 text-[11px] mt-1 font-medium">{{ $message }}</p> @enderror
            </div>

            {{-- No. Telepon --}}
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">No. Telepon</label>
                <input type="text" name="no_telepon" value="{{ old('no_telepon') }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 transition @error('no_telepon') border-red-400 bg-red-50 @enderror"
                       placeholder="Contoh: 08123456789">
                @error('no_telepon') <p class="text-red-500 text-[11px] mt-1 font-medium">{{ $message }}</p> @enderror
            </div>

            {{-- Alamat --}}
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Alamat</label>
                <textarea name="alamat" rows="2"
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 transition resize-none @error('alamat') border-red-400 bg-red-50 @enderror"
                          placeholder="Alamat lengkap (opsional)">{{ old('alamat') }}</textarea>
                @error('alamat') <p class="text-red-500 text-[11px] mt-1 font-medium">{{ $message }}</p> @enderror
            </div>

            {{-- Password --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 transition @error('password') border-red-400 bg-red-50 @enderror"
                           placeholder="Min. 6 karakter">
                    @error('password') <p class="text-red-500 text-[11px] mt-1 font-medium">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 transition"
                           placeholder="Ulangi password">
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-6 py-2.5 rounded-xl shadow transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Pengguna
                </button>
                <a href="{{ route('admin.pengguna.index') }}"
                   class="text-sm text-slate-500 hover:text-slate-700 font-medium transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
