@extends('layouts.app')
@section('title', 'Profil Saya')

@section('content')
<div class="max-w-2xl mx-auto py-12 px-4">
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-blue-600 h-32"></div>
        <div class="px-8 pb-8">
            <div class="relative -mt-12 flex justify-center">
                <div class="w-24 h-24 bg-white rounded-full p-2 shadow-md">
                    <div class="w-full h-full bg-blue-100 rounded-full flex items-center justify-center text-3xl font-bold text-blue-600">
                        {{ substr(auth()->user()->nama_lengkap, 0, 1) }}
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4 mb-8">
                <h2 class="text-2xl font-bold text-gray-800">{{ auth()->user()->nama_lengkap }}</h2>
                <p class="text-gray-500 uppercase text-xs font-bold tracking-widest">{{ auth()->user()->role }}</p>
            </div>

            <form action="{{ route('profil.update') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Username</label>
                        <input type="text" value="{{ auth()->user()->username }}" class="w-full px-4 py-2 bg-gray-50 border rounded-lg text-gray-400 cursor-not-allowed" disabled>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ auth()->user()->nama_lengkap }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">No. Telepon</label>
                        <input type="text" name="no_telepon" value="{{ auth()->user()->no_telepon }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Ganti Password <span class="text-[10px] text-gray-300">(Kosongi jika tidak diubah)</span></label>
                        <input type="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Alamat</label>
                    <textarea name="alamat" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">{{ auth()->user()->alamat }}</textarea>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-100">
                        SIMPAN PERUBAHAN
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
