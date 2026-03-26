@extends('layouts.admin')
@section('title', 'Kelola Jadwal Dokter')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <p class="text-gray-600">Manajemen jadwal operasional dokter (Online/Offline).</p>
    <button onclick="document.getElementById('modal-tambah').classList.remove('hidden')" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
        <span>+</span> Tambah Jadwal
    </button>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Dokter</th>
                    <th class="px-6 py-3">Hari</th>
                    <th class="px-6 py-3">Jam</th>
                    <th class="px-6 py-3">Jenis</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($jadwals as $j)
                <tr>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $j->dokter->user->nama_lengkap }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $j->hari }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ substr($j->jam_mulai, 0, 5) }} - {{ substr($j->jam_selesai, 0, 5) }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase
                            {{ $j->jenis_layanan === 'Online' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">
                            {{ $j->jenis_layanan }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase
                            {{ $j->status === 'tersedia' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst(str_replace('_', ' ', $j->status)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <form action="{{ route('admin.jadwal.update', $j->id) }}" method="POST">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="{{ $j->status === 'tersedia' ? 'tidak_tersedia' : 'tersedia' }}">
                                <button type="submit" class="text-xs font-bold {{ $j->status === 'tersedia' ? 'text-orange-600' : 'text-green-600' }}">
                                    {{ $j->status === 'tersedia' ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.jadwal.destroy', $j->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 text-xs font-bold ml-2">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah (Simple) -->
<div id="modal-tambah" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
        <h3 class="text-lg font-bold mb-4">Tambah Jadwal Baru</h3>
        <form action="{{ route('admin.jadwal.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="text-xs font-bold uppercase text-gray-500">Pilih Dokter</label>
                <select name="dokter_id" class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>
                    @foreach($dokters as $d)
                        <option value="{{ $d->id }}">{{ $d->user->nama_lengkap }}</p>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-xs font-bold uppercase text-gray-500">Hari</label>
                <select name="hari" class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>
                    @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $hari)
                        <option value="{{ $hari }}">{{ $hari }}</p>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-bold uppercase text-gray-500">Jam Mulai</label>
                    <input type="time" name="jam_mulai" class="w-full mt-1 px-4 py-2 border rounded-lg outline-none" required>
                </div>
                <div>
                    <label class="text-xs font-bold uppercase text-gray-500">Jam Selesai</label>
                    <input type="time" name="jam_selesai" class="w-full mt-1 px-4 py-2 border rounded-lg outline-none" required>
                </div>
            </div>
            <div>
                <label class="text-xs font-bold uppercase text-gray-500">Jenis Layanan</label>
                <select name="jenis_layanan" class="w-full mt-1 px-4 py-2 border rounded-lg outline-none" required>
                    <option value="Online">Online (Chat)</p>
                    <option value="Offline">Offline (Klinik)</p>
                </select>
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="document.getElementById('modal-tambah').classList.add('hidden')" class="px-4 py-2 text-gray-500">Batal</button>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg font-bold">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
