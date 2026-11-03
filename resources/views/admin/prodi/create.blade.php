@extends('layouts.app')

@section('header-title', 'Tambah Program Studi')
@section('header-subtitle', 'Tambahkan data program studi baru ke sistem')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 sm:p-8">
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
            <div>
                <h2 class="text-base font-bold text-slate-800">Form Tambah Program Studi</h2>
                <p class="text-xs text-slate-400">Pastikan kode prodi unik dan sesuai format akademik</p>
            </div>
            <a href="{{ route('admin.prodi.index') }}" class="text-xs text-slate-500 hover:text-slate-800">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.prodi.store') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label for="kode_prodi" class="block text-xs font-semibold text-slate-700 mb-1.5">Kode Program Studi</label>
                <input type="text" name="kode_prodi" id="kode_prodi" value="{{ old('kode_prodi') }}" required
                    class="w-full px-3.5 py-2.5 rounded-xl border @error('kode_prodi') border-rose-500 @else border-slate-200 @enderror focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm placeholder:text-slate-400"
                    placeholder="Contoh: IF, SI, TI">
                @error('kode_prodi')
                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="nama_prodi" class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Program Studi</label>
                <input type="text" name="nama_prodi" id="nama_prodi" value="{{ old('nama_prodi') }}" required
                    class="w-full px-3.5 py-2.5 rounded-xl border @error('nama_prodi') border-rose-500 @else border-slate-200 @enderror focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm placeholder:text-slate-400"
                    placeholder="Contoh: Informatika, Sistem Informasi">
                @error('nama_prodi')
                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="jenjang" class="block text-xs font-semibold text-slate-700 mb-1.5">Jenjang Pendidikan</label>
                <select name="jenjang" id="jenjang" required
                    class="w-full px-3.5 py-2.5 rounded-xl border @error('jenjang') border-rose-500 @else border-slate-200 @enderror focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm">
                    <option value="" disabled selected>Pilih Jenjang</option>
                    <option value="D3" {{ old('jenjang') === 'D3' ? 'selected' : '' }}>D3 (Diploma 3)</option>
                    <option value="D4" {{ old('jenjang') === 'D4' ? 'selected' : '' }}>D4 (Diploma 4)</option>
                    <option value="S1" {{ old('jenjang') === 'S1' ? 'selected' : '' }}>S1 (Strata 1)</option>
                    <option value="S2" {{ old('jenjang') === 'S2' ? 'selected' : '' }}>S2 (Strata 2)</option>
                </select>
                @error('jenjang')
                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.prodi.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold shadow-xs shadow-indigo-600/30 transition">
                    Simpan Program Studi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

