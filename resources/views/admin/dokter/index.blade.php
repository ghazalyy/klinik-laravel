@extends('layouts.admin')
@section('title', 'Kelola Dokter')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <p class="text-gray-600">Daftar dokter yang terdaftar di sistem.</p>
    <a href="{{ route('admin.dokter.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
        <span>+</span> Tambah Dokter
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-center">Foto</th>
                    <th class="px-6 py-3">Nama Dokter</th>
                    <th class="px-6 py-3">Spesialisasi</th>
                    <th class="px-6 py-3">Harga Sesi</th>
                    <th class="px-6 py-3">Status Online</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($dokters as $d)
                <tr>
                    <td class="px-6 py-4 text-center">
                        <img src="{{ asset('storage/'.$d->foto_profil) }}" alt="{{ $d->user->nama_lengkap }}" class="w-10 h-10 rounded-full object-cover mx-auto bg-gray-100" onerror="this.src='https://ui-avatars.com/api/?name='+encodeURI('{{ $d->user->nama_lengkap }}')+'&background=random'">
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $d->user->nama_lengkap }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $d->spesialisasi }}</td>
                    <td class="px-6 py-4 text-gray-700 font-semibold">Rp {{ number_format($d->harga_sesi, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase
                            {{ $d->status_online === 'Online' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                            {{ $d->status_online }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.dokter.edit', $d->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">Edit</a>
                            <form action="{{ route('admin.dokter.destroy', $d->id) }}" method="POST" onsubmit="return confirm('Hapus dokter ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
