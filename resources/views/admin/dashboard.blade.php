@extends('layouts.app')

@section('header-title', 'Dashboard Administrator')
@section('header-subtitle', 'Ringkasan data dan aktivitas sistem informasi mahasiswa')

@section('content')
<div class="space-y-6">

    <!-- Card Ringkasan / Stat Cards (Issue 12) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Total Mahasiswa -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Mahasiswa</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $totalMahasiswa }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
        </div>

        <!-- Total Dosen -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Dosen</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $totalDosen }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-chalkboard-user"></i>
            </div>
        </div>

        <!-- Total Mata Kuliah -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Mata Kuliah</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $totalMataKuliah }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-book-bookmark"></i>
            </div>
        </div>

        <!-- Total Program Studi -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Program Studi</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $totalProdi }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-shapes"></i>
            </div>
        </div>
    </div>

    <!-- Tabel Mahasiswa Terbaru (Issue 12) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-800">Mahasiswa Terdaftar Terbaru</h2>
                <p class="text-xs text-slate-400">5 data mahasiswa yang baru ditambahkan ke sistem</p>
            </div>
            <a href="{{ route('admin.mahasiswa.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 flex items-center space-x-1">
                <span>Kelola Semua</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-xs font-semibold text-slate-500 uppercase tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3.5">NIM</th>
                        <th class="px-6 py-3.5">Nama Mahasiswa</th>
                        <th class="px-6 py-3.5">Program Studi</th>
                        <th class="px-6 py-3.5">Angkatan</th>
                        <th class="px-6 py-3.5">Jenis Kelamin</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($mahasiswaTerbaru as $mhs)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="px-6 py-3.5 font-mono text-xs font-semibold text-slate-900">{{ $mhs->nim }}</td>
                            <td class="px-6 py-3.5 font-medium text-slate-800">{{ $mhs->nama }}</td>
                            <td class="px-6 py-3.5">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700">
                                    {{ $mhs->prodi->nama_prodi ?? '-' }} ({{ $mhs->prodi->jenjang ?? '' }})
                                </span>
                            </td>
                            <td class="px-6 py-3.5">{{ $mhs->angkatan }}</td>
                            <td class="px-6 py-3.5">
                                <span class="text-xs {{ $mhs->jenis_kelamin === 'L' ? 'text-blue-600' : 'text-pink-600' }} font-medium">
                                    {{ $mhs->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                            </td>
                            <td class="px-6 py-3.5 text-right">
                                <a href="{{ route('admin.mahasiswa.edit', $mhs) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                                    Detail / Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-400">
                                Belum ada data mahasiswa terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

