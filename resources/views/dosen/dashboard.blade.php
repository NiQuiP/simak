@extends('layouts.app')

@section('header-title', 'Dashboard Dosen')
@section('header-subtitle', 'Ringkasan kegiatan mengajar dan statistik mahasiswa bimbingan')

@section('content')
<div class="space-y-6">

    <!-- Profil Singkat Dosen -->
    <div class="bg-gradient-to-r from-indigo-700 to-indigo-900 rounded-2xl p-6 text-white shadow-md shadow-indigo-900/20">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="w-14 h-14 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center text-2xl font-bold">
                    <i class="fa-solid fa-chalkboard-user"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold">{{ $dosen->nama }}</h2>
                    <p class="text-xs text-indigo-200 mt-0.5">NIDN: {{ $dosen->nidn }} &bull; No. HP: {{ $dosen->no_hp ?? '-' }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                    Status: Dosen Aktif
                </span>
            </div>
        </div>
    </div>

    <!-- Statistik Ringkas (Issue 12) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Mata Kuliah Diampu</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $totalMK }} MK</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-book-open"></i>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Mahasiswa Terdaftar</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $totalMahasiswa }} Mahasiswa</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>
    </div>

    <!-- Tabel Daftar Mata Kuliah & Jumlah Mahasiswa (Issue 12) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-800">Mata Kuliah yang Diampu</h2>
                <p class="text-xs text-slate-400">Daftar kelas dan jumlah mahasiswa yang terdaftar di tiap MK</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-xs font-semibold text-slate-500 uppercase tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3.5">Kode MK</th>
                        <th class="px-6 py-3.5">Nama Mata Kuliah</th>
                        <th class="px-6 py-3.5">Program Studi</th>
                        <th class="px-6 py-3.5 text-center">SKS</th>
                        <th class="px-6 py-3.5 text-center">Semester</th>
                        <th class="px-6 py-3.5 text-center">Jumlah Mahasiswa</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($mataKuliahList as $mk)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="px-6 py-3.5 font-mono text-xs font-bold text-slate-900">{{ $mk->kode_mk }}</td>
                            <td class="px-6 py-3.5 font-semibold text-slate-800">{{ $mk->nama_mk }}</td>
                            <td class="px-6 py-3.5">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-700">
                                    {{ $mk->prodi->nama_prodi ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-3.5 text-center font-bold text-slate-700">{{ $mk->sks }}</td>
                            <td class="px-6 py-3.5 text-center">Sem. {{ $mk->semester }}</td>
                            <td class="px-6 py-3.5 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700">
                                    {{ $mk->krs_count }} Mahasiswa
                                </span>
                            </td>
                            <td class="px-6 py-3.5 text-right space-x-2">
                                <a href="{{ route('dosen.mata-kuliah.mahasiswa', $mk) }}" class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-xs font-medium text-slate-700 hover:bg-slate-100 transition">
                                    <i class="fa-solid fa-users mr-1"></i> Mahasiswa
                                </a>
                                <a href="{{ route('dosen.nilai.form', $mk) }}" class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-xs font-medium text-indigo-600 hover:bg-indigo-50 transition">
                                    <i class="fa-solid fa-pen-to-square mr-1"></i> Input Nilai
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-slate-400">
                                Belum ada mata kuliah yang ditugaskan kepada Anda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

