@extends('layouts.app')

@section('header-title', 'Mata Kuliah')
@section('header-subtitle', 'Manajemen kurikulum, beban SKS, dan dosen pengampu')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-lg font-bold text-slate-800">Daftar Mata Kuliah</h2>
            <p class="text-xs text-slate-500">Kelola mata kuliah, penempatan prodi, semester, dan dosen pengampu</p>
        </div>
        <a href="{{ route('admin.mata-kuliah.create') }}" class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold shadow-xs shadow-indigo-600/30 transition">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Mata Kuliah</span>
        </a>
    </div>

    <!-- Filter & Pencarian (Issue 8) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-4">
        <form action="{{ route('admin.mata-kuliah.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="relative flex-1 w-full">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400 text-xs">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" name="search" value="{{ $search }}"
                    class="w-full pl-9 pr-4 py-2 text-xs rounded-xl border border-slate-200 focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 placeholder:text-slate-400"
                    placeholder="Cari berdasarkan kode MK, nama mata kuliah, prodi, atau dosen...">
            </div>
            <div class="flex items-center space-x-2 w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold transition">
                    Cari
                </button>
                @if($search)
                    <a href="{{ route('admin.mata-kuliah.index') }}" class="px-3 py-2 rounded-xl border border-slate-200 text-xs text-slate-600 hover:bg-slate-50 transition">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabel Mata Kuliah -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-xs font-semibold text-slate-500 uppercase tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3.5">Kode MK</th>
                        <th class="px-6 py-3.5">Nama Mata Kuliah</th>
                        <th class="px-6 py-3.5">Program Studi</th>
                        <th class="px-6 py-3.5 text-center">SKS</th>
                        <th class="px-6 py-3.5 text-center">Semester</th>
                        <th class="px-6 py-3.5">Dosen Pengampu</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($mkList as $mk)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="px-6 py-3.5 font-mono text-xs font-bold text-slate-900">{{ $mk->kode_mk }}</td>
                            <td class="px-6 py-3.5 font-semibold text-slate-800">{{ $mk->nama_mk }}</td>
                            <td class="px-6 py-3.5">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-700">
                                    {{ $mk->prodi->nama_prodi ?? '-' }} ({{ $mk->prodi->jenjang ?? '' }})
                                </span>
                            </td>
                            <td class="px-6 py-3.5 text-center">
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-indigo-50 text-indigo-700 font-bold text-xs">
                                    {{ $mk->sks }}
                                </span>
                            </td>
                            <td class="px-6 py-3.5 text-center font-medium text-slate-700">
                                Sem. {{ $mk->semester }}
                            </td>
                            <td class="px-6 py-3.5 text-xs text-slate-700">
                                <i class="fa-solid fa-user-tie text-slate-400 mr-1.5"></i>
                                {{ $mk->dosen->nama ?? '-' }}
                            </td>
                            <td class="px-6 py-3.5 text-right space-x-2">
                                <a href="{{ route('admin.mata-kuliah.edit', $mk) }}" class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-xs font-medium text-indigo-600 hover:bg-indigo-50 transition">
                                    <i class="fa-regular fa-pen-to-square mr-1"></i> Edit
                                </a>
                                <form action="{{ route('admin.mata-kuliah.destroy', $mk) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata kuliah ini?');">
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
                            <td colspan="7" class="px-6 py-8 text-center text-slate-400">
                                {{ $search ? 'Tidak ada data mata kuliah yang cocok dengan pencarian.' : 'Belum ada mata kuliah.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($mkList->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $mkList->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

