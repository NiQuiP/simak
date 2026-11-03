@extends('layouts.app')

@section('header-title', 'Mahasiswa: ' . $mataKuliah->nama_mk)
@section('header-subtitle', 'Daftar peserta mata kuliah ' . $mataKuliah->kode_mk . ' (' . $mataKuliah->sks . ' SKS)')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <span class="font-mono text-xs font-bold text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded">{{ $mataKuliah->kode_mk }}</span>
                <h2 class="text-lg font-bold text-slate-800">{{ $mataKuliah->nama_mk }}</h2>
            </div>
            <p class="text-xs text-slate-500 mt-1">Program Studi: {{ $mataKuliah->prodi->nama_prodi }} &bull; Semester {{ $mataKuliah->semester }} &bull; Total: {{ $krsList->count() }} Mahasiswa</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('dosen.mata-kuliah.index') }}" class="px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
            </a>
            <a href="{{ route('dosen.nilai.form', $mataKuliah) }}" class="inline-flex items-center space-x-1.5 px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold shadow-xs transition">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>Input Nilai Mahasiswa</span>
            </a>
        </div>
    </div>

    <!-- Tabel Mahasiswa di MK -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-xs font-semibold text-slate-500 uppercase tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3.5">NIM</th>
                        <th class="px-6 py-3.5">Nama Mahasiswa</th>
                        <th class="px-6 py-3.5">Program Studi</th>
                        <th class="px-6 py-3.5">Tahun Ajaran</th>
                        <th class="px-6 py-3.5 text-center">Nilai Angka</th>
                        <th class="px-6 py-3.5 text-center">Nilai Huruf</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($krsList as $krs)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="px-6 py-3.5 font-mono text-xs font-bold text-slate-900">{{ $krs->mahasiswa->nim }}</td>
                            <td class="px-6 py-3.5 font-medium text-slate-800">{{ $krs->mahasiswa->nama }}</td>
                            <td class="px-6 py-3.5 text-xs text-slate-600">{{ $krs->mahasiswa->prodi->nama_prodi ?? '-' }}</td>
                            <td class="px-6 py-3.5 text-xs text-slate-500">{{ $krs->tahun_ajaran }} ({{ ucfirst($krs->semester) }})</td>
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
                                Belum ada mahasiswa yang mengambil mata kuliah ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

