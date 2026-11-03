@extends('layouts.app')

@section('header-title', 'Data Mahasiswa')
@section('header-subtitle', 'Manajemen direktori mahasiswa terdaftar di sistem SIMAK')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-lg font-bold text-slate-800">Daftar Mahasiswa</h2>
            <p class="text-xs text-slate-500">Kelola akun dan profil mahasiswa per program studi</p>
        </div>
        <a href="{{ route('admin.mahasiswa.create') }}" class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold shadow-xs shadow-indigo-600/30 transition">
            <i class="fa-solid fa-user-plus"></i>
            <span>Tambah Mahasiswa</span>
        </a>
    </div>

    <!-- Filter & Pencarian (Issue 6) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-4">
        <form action="{{ route('admin.mahasiswa.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="relative flex-1 w-full">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400 text-xs">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" name="search" value="{{ $search }}"
                    class="w-full pl-9 pr-4 py-2 text-xs rounded-xl border border-slate-200 focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 placeholder:text-slate-400"
                    placeholder="Cari berdasarkan NIM, nama, atau prodi...">
            </div>
            <div class="flex items-center space-x-2 w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold transition">
                    Cari
                </button>
                @if($search)
                    <a href="{{ route('admin.mahasiswa.index') }}" class="px-3 py-2 rounded-xl border border-slate-200 text-xs text-slate-600 hover:bg-slate-50 transition">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabel Mahasiswa -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-xs font-semibold text-slate-500 uppercase tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3.5">NIM</th>
                        <th class="px-6 py-3.5">Nama & Email</th>
                        <th class="px-6 py-3.5">Program Studi</th>
                        <th class="px-6 py-3.5">Gender / Angkatan</th>
                        <th class="px-6 py-3.5">Kontak / No HP</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($mahasiswaList as $mhs)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="px-6 py-3.5 font-mono text-xs font-bold text-slate-900">{{ $mhs->nim }}</td>
                            <td class="px-6 py-3.5">
                                <div class="font-medium text-slate-800">{{ $mhs->nama }}</div>
                                <div class="text-xs text-slate-400">{{ $mhs->user->email ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-3.5">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700">
                                    {{ $mhs->prodi->nama_prodi ?? '-' }} ({{ $mhs->prodi->jenjang ?? '' }})
                                </span>
                            </td>
                            <td class="px-6 py-3.5 text-xs">
                                <span class="font-semibold {{ $mhs->jenis_kelamin === 'L' ? 'text-blue-600' : 'text-pink-600' }}">
                                    {{ $mhs->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                                <div class="text-slate-400">Angkatan {{ $mhs->angkatan }}</div>
                            </td>
                            <td class="px-6 py-3.5 text-xs text-slate-600">
                                {{ $mhs->no_hp ?? '-' }}
                            </td>
                            <td class="px-6 py-3.5 text-right space-x-2">
                                <a href="{{ route('admin.mahasiswa.edit', $mhs) }}" class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-xs font-medium text-indigo-600 hover:bg-indigo-50 transition">
                                    <i class="fa-regular fa-pen-to-square mr-1"></i> Edit
                                </a>
                                <form action="{{ route('admin.mahasiswa.destroy', $mhs) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data mahasiswa ini beserta akun loginnnya?');">
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
                                {{ $search ? 'Tidak ada data mahasiswa yang cocok dengan pencarian.' : 'Belum ada data mahasiswa.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($mahasiswaList->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $mahasiswaList->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

