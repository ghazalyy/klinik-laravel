@extends('layouts.admin')
@section('title', 'Data Pengguna')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h3 class="text-xl font-bold text-slate-800">Daftar Akun Pengguna</h3>
        <p class="text-xs text-slate-500 mt-1 uppercase tracking-wider font-medium">Kelola akses, role, dan data pengguna sistem</p>
    </div>
    <a href="{{ route('admin.pengguna.create') }}"
       class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Pengguna
    </a>
</div>

@if(session('success'))
<div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-semibold flex items-center gap-2">
    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm font-semibold flex items-center gap-2">
    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    {{ session('error') }}
</div>
@endif

<div class="premium-card rounded-2xl overflow-hidden shadow-sm border border-slate-200/60 bg-white">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50/50">
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Profil Pengguna</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Username</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kontak</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Role Akses</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tanggal Gabung</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($users as $u)
                <tr class="hover:bg-slate-50/80 transition-colors">
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center font-bold text-slate-500 text-xs shadow-sm">
                                {{ substr($u->nama_lengkap, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 tracking-tight">{{ $u->nama_lengkap }}</p>
                                <p class="text-[10px] text-slate-400">{{ $u->alamat ?? 'Alamat belum diatur' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <span class="font-mono text-[13px] text-slate-500 bg-slate-100 px-2 py-0.5 rounded border border-slate-200">@ {{ $u->username }}</span>
                    </td>
                    <td class="px-6 py-5">
                        <p class="text-[13px] text-slate-600 font-medium">{{ $u->no_telepon ?? '-' }}</p>
                    </td>
                    <td class="px-6 py-5">
                        @php
                            $roleClasses = [
                                'admin'  => 'bg-indigo-50 text-indigo-700 border-indigo-100',
                                'dokter' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                'pasien' => 'bg-sky-50 text-sky-700 border-sky-100',
                            ];
                            $class = $roleClasses[$u->role] ?? 'bg-slate-50 text-slate-700 border-slate-100';
                        @endphp
                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold uppercase border {{ $class }} tracking-tighter">
                            {{ $u->role }}
                        </span>
                    </td>
                    <td class="px-6 py-5">
                        <p class="text-[12px] text-slate-500 font-medium tracking-tight">{{ $u->created_at->translatedFormat('d M Y') }}</p>
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex items-center justify-center gap-2">
                            {{-- Edit --}}
                            <a href="{{ route('admin.pengguna.edit', $u->id) }}"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 hover:bg-amber-100 border border-amber-200 text-amber-700 text-[11px] font-bold rounded-lg transition-colors">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>

                            {{-- Hapus --}}
                            @if($u->id !== auth()->id())
                            <form action="{{ route('admin.pengguna.destroy', $u->id) }}" method="POST"
                                  onsubmit="return confirm('Hapus pengguna {{ $u->nama_lengkap }}? Tindakan ini tidak dapat dibatalkan.')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 hover:bg-red-100 border border-red-200 text-red-700 text-[11px] font-bold rounded-lg transition-colors">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>
                            </form>
                            @else
                            <span class="text-[10px] text-slate-400 italic px-3">Anda</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
