@extends('layouts.admin')
@section('title', 'Edit Dokter: ' . $dokter->user->nama_lengkap)

@section('content')
<div class="max-w-2xl bg-white rounded-xl shadow-sm border border-gray-100 p-8">
    <form action="{{ route('admin.dokter.update', $dokter->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-sm font-bold text-gray-700">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ $dokter->user->nama_lengkap }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>
            </div>
            <div class="space-y-2">
                <label class="text-sm font-bold text-gray-700">Spesialisasi</label>
                <input type="text" name="spesialisasi" value="{{ $dokter->spesialisasi }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>
            </div>
            <div class="space-y-2">
                <label class="text-sm font-bold text-gray-700">Harga Sesi (Rp)</label>
                <input type="number" name="harga_sesi" value="{{ $dokter->harga_sesi }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>
            </div>
            <div class="space-y-2">
                <label class="text-sm font-bold text-gray-700">Status Online</label>
                <select name="status_online" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="Online" {{ $dokter->status_online === 'Online' ? 'selected' : '' }}>Online</option>
                    <option value="Offline" {{ $dokter->status_online === 'Offline' ? 'selected' : '' }}>Offline</option>
                </select>
            </div>
            <div class="col-span-2 space-y-2">
                <label class="text-sm font-bold text-gray-700">Ganti Foto Profil</label>
                <div class="flex items-center gap-4">
                    <img src="{{ asset('storage/'.$dokter->foto_profil) }}" class="w-16 h-16 rounded-full object-cover bg-gray-100" onerror="this.src='https://ui-avatars.com/api/?name='+encodeURI('{{ $dokter->user->nama_lengkap }}')">
                    <input type="file" name="foto_profil" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
            </div>
        </div>
        <div class="space-y-2">
            <label class="text-sm font-bold text-gray-700">Deskripsi/Bio</label>
            <textarea name="deskripsi" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">{{ $dokter->deskripsi }}</textarea>
        </div>
        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('admin.dokter.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 transition">Batal</a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Update Dokter</button>
        </div>
    </form>
</div>
@endsection
