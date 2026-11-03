@extends('layouts.app')

@section('header-title', 'Mahasiswa per Mata Kuliah')
@section('header-subtitle', 'Pilih mata kuliah untuk melihat mahasiswa yang mengambil kelas Anda')

@section('content')
<div class="space-y-6">

    <div>
        <h2 class="text-lg font-bold text-slate-800">Daftar Mata Kuliah Diampu</h2>
        <p class="text-xs text-slate-500">Klik tombol "Lihat Mahasiswa" untuk melihat daftar mahasiswa di masing-masing kelas</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($mataKuliahList as $mk)
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex flex-col justify-between hover:border-indigo-300 transition">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="font-mono text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-md">{{ $mk->kode_mk }}</span>
                        <span class="text-xs text-slate-400 font-medium">Semester {{ $mk->semester }}</span>
                    </div>
                    <h3 class="text-base font-bold text-slate-800 mb-1 leading-snug">{{ $mk->nama_mk }}</h3>
                    <p class="text-xs text-slate-500 mb-4">{{ $mk->prodi->nama_prodi ?? '-' }} ({{ $mk->prodi->jenjang ?? '' }})</p>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <div>
                        <span class="text-xs font-semibold text-slate-700 block">{{ $mk->krs_count }} Mahasiswa</span>
                        <span class="text-[11px] text-slate-400 block">{{ $mk->sks }} SKS</span>
                    </div>
                    <a href="{{ route('dosen.mata-kuliah.mahasiswa', $mk) }}" class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold shadow-xs transition">
                        <span>Lihat Mahasiswa</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
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

