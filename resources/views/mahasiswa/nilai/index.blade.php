@extends('layouts.app')

@section('header-title', 'Kartu Hasil Studi (KHS)')
@section('header-subtitle', 'Daftar perolehan nilai akademik mahasiswa')

@section('content')
<div class="space-y-6">

    <!-- Header Info Mahasiswa -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-base font-bold text-slate-800">Transkrip Nilai Semester Berjalan</h2>
            <p class="text-xs text-slate-500 mt-0.5">Nama: {{ $mahasiswa->nama }} &bull; NIM: {{ $mahasiswa->nim }} &bull; Prodi: {{ $mahasiswa->prodi->nama_prodi }}</p>
        </div>
        <div class="flex items-center space-x-2">
            <button onclick="window.print()" class="px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition flex items-center space-x-1.5">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Nilai</span>
            </button>
        </div>
    </div>

    <!-- Tabel Nilai Mahasiswa (Issue 11) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
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
                    @php
                        $totalSks = 0;
                        $totalBobot = 0;
                        $jumlahTernilai = 0;
                    @endphp

                    @forelse($krsList as $krs)
                        @php
                            $totalSks += $krs->mataKuliah->sks;
                            $huruf = $krs->nilai->nilai_huruf ?? null;
                            $angka = $krs->nilai->nilai_angka ?? null;
                        @endphp
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="px-6 py-3.5 font-mono text-xs font-bold text-slate-900">{{ $krs->mataKuliah->kode_mk }}</td>
                            <td class="px-6 py-3.5 font-semibold text-slate-800">{{ $krs->mataKuliah->nama_mk }}</td>
                            <td class="px-6 py-3.5 text-center font-bold text-slate-700">{{ $krs->mataKuliah->sks }}</td>
                            <td class="px-6 py-3.5 text-xs text-slate-600">
                                {{ $krs->mataKuliah->dosen->nama ?? '-' }}
                            </td>
                            <td class="px-6 py-3.5 text-center font-mono font-bold text-slate-800">
                                {{ $angka !== null ? number_format($angka, 2) : '-' }}
                            </td>
                            <td class="px-6 py-3.5 text-center">
                                @if($huruf)
                                    @php
                                        // Badge warna nilai huruf (Issue 11: A=hijau, B=biru, C=kuning, D/E=merah)
                                        $badgeStyle = match(strtoupper($huruf)) {
                                            'A' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                                            'B' => 'bg-blue-100 text-blue-800 border-blue-300',
                                            'C' => 'bg-amber-100 text-amber-800 border-amber-300',
                                            default => 'bg-rose-100 text-rose-800 border-rose-300',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl font-bold text-xs border shadow-2xs {{ $badgeStyle }}">
                                        {{ strtoupper($huruf) }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-slate-100 text-slate-400">
                                        Belum Ada Nilai
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-400">
                                Belum ada mata kuliah yang diambil pada KRS.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($krsList->isNotEmpty())
            <div class="p-4 bg-slate-50 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-600">
                <div>
                    <span class="font-semibold text-slate-700">Keterangan Badge:</span>
                    <span class="inline-flex items-center ml-2 mr-1"><span class="w-3 h-3 rounded-full bg-emerald-500 mr-1"></span> A (Sangat Baik)</span>
                    <span class="inline-flex items-center mx-2"><span class="w-3 h-3 rounded-full bg-blue-500 mr-1"></span> B (Baik)</span>
                    <span class="inline-flex items-center mx-2"><span class="w-3 h-3 rounded-full bg-amber-500 mr-1"></span> C (Cukup)</span>
                    <span class="inline-flex items-center mx-2"><span class="w-3 h-3 rounded-full bg-rose-500 mr-1"></span> D/E (Kurang)</span>
                </div>
                <div class="font-bold text-indigo-700 text-sm">
                    Total SKS: {{ $totalSks }}
                </div>
            </div>
        @endif
    </div>

</div>
@endsection

