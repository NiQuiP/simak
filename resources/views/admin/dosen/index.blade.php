@extends('layouts.app')

@section('header-title', 'Data Dosen')
@section('header-subtitle', 'Manajemen daftar dosen dan tenaga pengajar')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-lg font-bold text-slate-800">Daftar Dosen Pengajar</h2>
            <p class="text-xs text-slate-500">Kelola identitas, NIDN, dan akun dosen</p>
        </div>
        <a href="{{ route('admin.dosen.create') }}" class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold shadow-xs shadow-indigo-600/30 transition">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Dosen</span>
        </a>
    </div>

    <!-- Filter & Pencarian (Issue 7) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-4">
        <form action="{{ route('admin.dosen.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="relative flex-1 w-full">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400 text-xs">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" name="search" value="{{ $search }}"
                    class="w-full pl-9 pr-4 py-2 text-xs rounded-xl border border-slate-200 focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 placeholder:text-slate-400"
                    placeholder="Cari berdasarkan NIDN, nama dosen, atau nomor HP...">
            </div>
            <div class="flex items-center space-x-2 w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold transition">
                    Cari
                </button>
                @if($search)
                    <a href="{{ route('admin.dosen.index') }}" class="px-3 py-2 rounded-xl border border-slate-200 text-xs text-slate-600 hover:bg-slate-50 transition">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabel Dosen -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-xs font-semibold text-slate-500 uppercase tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3.5">NIDN</th>
                        <th class="px-6 py-3.5">Nama & Gelar</th>
                        <th class="px-6 py-3.5">Email Akun</th>
                        <th class="px-6 py-3.5">Nomor Handphone</th>
                        <th class="px-6 py-3.5">MK Diampu</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($dosenList as $dosen)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="px-6 py-3.5 font-mono text-xs font-bold text-slate-900">{{ $dosen->nidn }}</td>
                            <td class="px-6 py-3.5 font-medium text-slate-800">{{ $dosen->nama }}</td>
                            <td class="px-6 py-3.5 text-xs text-slate-500">{{ $dosen->user->email ?? '-' }}</td>
                            <td class="px-6 py-3.5 text-xs text-slate-600">{{ $dosen->no_hp ?? '-' }}</td>
                            <td class="px-6 py-3.5">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">
                                    {{ $dosen->mata_kuliah_count }} Mata Kuliah
                                </span>
                            </td>
                            <td class="px-6 py-3.5 text-right space-x-2">
                                <a href="{{ route('admin.dosen.edit', $dosen) }}" class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-xs font-medium text-indigo-600 hover:bg-indigo-50 transition">
                                    <i class="fa-regular fa-pen-to-square mr-1"></i> Edit
                                </a>
                                <form action="{{ route('admin.dosen.destroy', $dosen) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data dosen ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-xs font-medium text-rose-600 hover:bg-rose-50 transition">
                                        <i class="fa-regular fa-trash-can mr-1"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-400">
                                {{ $search ? 'Tidak ada data dosen yang cocok dengan pencarian.' : 'Belum ada data dosen.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($dosenList->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $dosenList->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

