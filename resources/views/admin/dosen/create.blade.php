@extends('layouts.app')

@section('header-title', 'Tambah Dosen')
@section('header-subtitle', 'Pendaftaran data dosen baru dan pembuatan akun otomatis')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 sm:p-8">
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
            <div>
                <h2 class="text-base font-bold text-slate-800">Formulir Tambah Dosen</h2>
                <p class="text-xs text-slate-400">Akun login role dosen otomatis dibuat dengan password default: <strong class="text-indigo-600">password</strong></p>
            </div>
            <a href="{{ route('admin.dosen.index') }}" class="text-xs text-slate-500 hover:text-slate-800">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.dosen.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="nidn" class="block text-xs font-semibold text-slate-700 mb-1.5">Nomor Induk Dosen Nasional (NIDN)</label>
                <input type="text" name="nidn" id="nidn" value="{{ old('nidn') }}" required
                    class="w-full px-3.5 py-2.5 rounded-xl border @error('nidn') border-rose-500 @else border-slate-200 @enderror focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm placeholder:text-slate-400"
                    placeholder="Contoh: 0011223344">
                @error('nidn')
                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="nama" class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Lengkap beserta Gelar</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                    class="w-full px-3.5 py-2.5 rounded-xl border @error('nama') border-rose-500 @else border-slate-200 @enderror focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm placeholder:text-slate-400"
                    placeholder="Contoh: Dr. Ir. Budi Santoso, M.Kom.">
                @error('nama')
                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">Alamat Email (Untuk Login)</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                    class="w-full px-3.5 py-2.5 rounded-xl border @error('email') border-rose-500 @else border-slate-200 @enderror focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm placeholder:text-slate-400"
                    placeholder="dosen@simak.ac.id">
                @error('email')
                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="no_hp" class="block text-xs font-semibold text-slate-700 mb-1.5">Nomor Handphone (WhatsApp)</label>
                <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}"
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm placeholder:text-slate-400"
                    placeholder="Contoh: 081234567890">
                @error('no_hp')
                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.dosen.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold shadow-xs shadow-indigo-600/30 transition">
                    Daftarkan Dosen
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

