@extends('layouts.app')

@section('header-title', 'Dashboard Mahasiswa')
@section('header-subtitle', 'Ringkasan akademik, informasi KRS aktif, dan transkrip nilai berjalan')

@section('content')
<div class="space-y-6">

    <!-- Card Profil Mahasiswa -->
    <div class="bg-gradient-to-r from-blue-700 via-indigo-700 to-indigo-800 rounded-2xl p-6 text-white shadow-md shadow-indigo-900/20">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="w-14 h-14 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center text-2xl font-bold">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold">{{ $mahasiswa->nama }}</h2>
                    <p class="text-xs text-indigo-200 mt-0.5">
                        NIM: <span class="font-mono font-semibold">{{ $mahasiswa->nim }}</span> &bull; 
                        Prodi: <span class="font-semibold">{{ $mahasiswa->prodi->nama_prodi ?? '-' }} ({{ $mahasiswa->prodi->jenjang ?? '' }})</span> &bull; 
                        Angkatan: {{ $mahasiswa->angkatan }}
                    </p>
                </div>
            </div>
            <div>
                <a href="{{ route('mahasiswa.krs.index') }}" class="inline-flex items-center space-x-1.5 px-4 py-2 rounded-xl bg-white text-indigo-700 text-xs font-bold hover:bg-slate-100 transition shadow-xs">
                    <i class="fa-solid fa-file-pen"></i>
                    <span>Isi / Ubah KRS</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Statistik Akademik Mahasiswa (Issue 12) -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total SKS Diambil</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $totalSKS }} SKS</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Mata Kuliah Semester Ini</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $totalMK }} MK</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-book-open"></i>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Rata-Rata Nilai</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $rataRataNilai > 0 ? $rataRataNilai : '-' }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-star"></i>
            </div>
        </div>
    </div>

    <!-- Info KRS Aktif & Nilai (Issue 12) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-800">Mata Kuliah Semester Aktif</h2>
                <p class="text-xs text-slate-400">Daftar mata kuliah yang Anda daftarkan pada KRS semester ini</p>
            </div>
            <a href="{{ route('mahasiswa.nilai.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 flex items-center space-x-1">
                <span>Lihat Kartu Hasil Studi (KHS)</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-xs font-semibold text-slate-500 uppercase tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3.5">Kode MK</th>
                        <th class="px-6 py-3.5">Nama Mata Kuliah</th>
                        <th class="px-6 py-3.5 text-center">SKS</th>
                        <th class="px-6 py-3.5">Dosen Pengampu</th>
                        <th class="px-6 py-3.5 text-center">Nilai Angka</th>
                        <th class="px-6 py-3.5 text-center">Nilai Huruf</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($krsAktif as $krs)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="px-6 py-3.5 font-mono text-xs font-bold text-slate-900">{{ $krs->mataKuliah->kode_mk }}</td>
                            <td class="px-6 py-3.5 font-semibold text-slate-800">{{ $krs->mataKuliah->nama_mk }}</td>
                            <td class="px-6 py-3.5 text-center font-bold text-slate-700">{{ $krs->mataKuliah->sks }}</td>
                            <td class="px-6 py-3.5 text-xs text-slate-600">
                                {{ $krs->mataKuliah->dosen->nama ?? '-' }}
                            </td>
                            <td class="px-6 py-3.5 text-center font-mono font-bold text-slate-800">
                                {{ $krs->nilai && $krs->nilai->nilai_angka !== null ? number_format($krs->nilai->nilai_angka, 2) : '-' }}
                            </td>
                            <td class="px-6 py-3.5 text-center">
                                @if($krs->nilai && $krs->nilai->nilai_huruf)
                                    @php
                                        $h = $krs->nilai->nilai_huruf;
                                        $color = match($h) {
                                            'A' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                            'B' => 'bg-blue-50 text-blue-700 border-blue-200',
                                            'C' => 'bg-amber-50 text-amber-700 border-amber-200',
                                            default => 'bg-rose-50 text-rose-700 border-rose-200',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $color }}">
                                        {{ $h }}
                                    </span>
                                @else
                                    <span class="text-xs text-slate-400 italic">Belum dinilai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-400">
                                Anda belum mengisi KRS untuk semester ini.
                                <div class="mt-2">
                                    <a href="{{ route('mahasiswa.krs.index') }}" class="text-xs font-semibold text-indigo-600 hover:underline">
                                        Klik di sini untuk mengisi Kartu Rencana Studi (KRS)
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

