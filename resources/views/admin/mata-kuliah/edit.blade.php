@extends('layouts.app')

@section('header-title', 'Edit Mata Kuliah')
@section('header-subtitle', 'Perbarui kurikulum mata kuliah dan dosen pengampu')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 sm:p-8">
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
            <div>
                <h2 class="text-base font-bold text-slate-800">Form Edit Mata Kuliah</h2>
                <p class="text-xs text-slate-400">Edit mata kuliah {{ $mataKuliah->nama_mk }}</p>
            </div>
            <a href="{{ route('admin.mata-kuliah.index') }}" class="text-xs text-slate-500 hover:text-slate-800">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.mata-kuliah.update', $mataKuliah) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="kode_mk" class="block text-xs font-semibold text-slate-700 mb-1.5">Kode Mata Kuliah</label>
                    <input type="text" name="kode_mk" id="kode_mk" value="{{ old('kode_mk', $mataKuliah->kode_mk) }}" required
                        class="w-full px-3.5 py-2.5 rounded-xl border @error('kode_mk') border-rose-500 @else border-slate-200 @enderror focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm">
                    @error('kode_mk')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nama_mk" class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Mata Kuliah</label>
                    <input type="text" name="nama_mk" id="nama_mk" value="{{ old('nama_mk', $mataKuliah->nama_mk) }}" required
                        class="w-full px-3.5 py-2.5 rounded-xl border @error('nama_mk') border-rose-500 @else border-slate-200 @enderror focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm">
                    @error('nama_mk')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="prodi_id" class="block text-xs font-semibold text-slate-700 mb-1.5">Program Studi</label>
                    <select name="prodi_id" id="prodi_id" required
                        class="w-full px-3.5 py-2.5 rounded-xl border @error('prodi_id') border-rose-500 @else border-slate-200 @enderror focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm">
                        @foreach($prodiList as $prodi)
                            <option value="{{ $prodi->id }}" {{ old('prodi_id', $mataKuliah->prodi_id) == $prodi->id ? 'selected' : '' }}>
                                {{ $prodi->nama_prodi }} ({{ $prodi->jenjang }})
                            </option>
                        @endforeach
                    </select>
                    @error('prodi_id')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="dosen_id" class="block text-xs font-semibold text-slate-700 mb-1.5">Dosen Pengampu</label>
                    <select name="dosen_id" id="dosen_id" required
                        class="w-full px-3.5 py-2.5 rounded-xl border @error('dosen_id') border-rose-500 @else border-slate-200 @enderror focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm">
                        @foreach($dosenList as $dosen)
                            <option value="{{ $dosen->id }}" {{ old('dosen_id', $mataKuliah->dosen_id) == $dosen->id ? 'selected' : '' }}>
                                {{ $dosen->nama }} (NIDN: {{ $dosen->nidn }})
                            </option>
                        @endforeach
                    </select>
                    @error('dosen_id')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="sks" class="block text-xs font-semibold text-slate-700 mb-1.5">Beban SKS (1 - 6)</label>
                    <input type="number" name="sks" id="sks" value="{{ old('sks', $mataKuliah->sks) }}" required min="1" max="6"
                        class="w-full px-3.5 py-2.5 rounded-xl border @error('sks') border-rose-500 @else border-slate-200 @enderror focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm">
                    @error('sks')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="semester" class="block text-xs font-semibold text-slate-700 mb-1.5">Semester (1 - 8)</label>
                    <input type="number" name="semester" id="semester" value="{{ old('semester', $mataKuliah->semester) }}" required min="1" max="8"
                        class="w-full px-3.5 py-2.5 rounded-xl border @error('semester') border-rose-500 @else border-slate-200 @enderror focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm">
                    @error('semester')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.mata-kuliah.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold shadow-xs shadow-indigo-600/30 transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

