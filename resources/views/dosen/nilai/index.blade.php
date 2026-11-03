@extends('layouts.app')

@section('header-title', 'Input Nilai')
@section('header-subtitle', 'Pilih kelas mata kuliah untuk menginput atau mengubah nilai mahasiswa')

@section('content')
<div class="space-y-6">

    <div>
        <h2 class="text-lg font-bold text-slate-800">Daftar Kelas Penilaian</h2>
        <p class="text-xs text-slate-500">Pilih mata kuliah untuk menginput nilai angka dan huruf bagi mahasiswa peserta</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($mataKuliahList as $mk)
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex flex-col justify-between hover:border-indigo-300 transition">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="font-mono text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-md">{{ $mk->kode_mk }}</span>
                        <span class="text-xs text-slate-400 font-medium">{{ $mk->sks }} SKS</span>
                    </div>
                    <h3 class="text-base font-bold text-slate-800 mb-1 leading-snug">{{ $mk->nama_mk }}</h3>
                    <p class="text-xs text-slate-500 mb-4">{{ $mk->prodi->nama_prodi ?? '-' }} (Semester {{ $mk->semester }})</p>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-700">{{ $mk->krs_count }} Mahasiswa Terdaftar</span>
                    <a href="{{ route('dosen.nilai.form', $mk) }}" class="inline-flex items-center space-x-1.5 px-3.5 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold shadow-xs transition">
                        <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                        <span>Input Nilai</span>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl p-8 text-center text-slate-400 border border-slate-200">
                Belum ada mata kuliah yang diampu.
            </div>
        @endforelse
    </div>

</div>
@endsection

