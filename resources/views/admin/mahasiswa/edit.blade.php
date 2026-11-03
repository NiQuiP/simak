@extends('layouts.app')

@section('header-title', 'Edit Mahasiswa')
@section('header-subtitle', 'Perbarui data dan profil mahasiswa')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 sm:p-8">
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
            <div>
                <h2 class="text-base font-bold text-slate-800">Form Edit Mahasiswa</h2>
                <p class="text-xs text-slate-400">Edit data mahasiswa {{ $mahasiswa->nama }} ({{ $mahasiswa->nim }})</p>
            </div>
            <a href="{{ route('admin.mahasiswa.index') }}" class="text-xs text-slate-500 hover:text-slate-800">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.mahasiswa.update', $mahasiswa) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="nim" class="block text-xs font-semibold text-slate-700 mb-1.5">Nomor Induk Mahasiswa (NIM)</label>
                    <input type="text" name="nim" id="nim" value="{{ old('nim', $mahasiswa->nim) }}" required
                        class="w-full px-3.5 py-2.5 rounded-xl border @error('nim') border-rose-500 @else border-slate-200 @enderror focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm">
                    @error('nim')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nama" class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Lengkap Mahasiswa</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $mahasiswa->nama) }}" required
                        class="w-full px-3.5 py-2.5 rounded-xl border @error('nama') border-rose-500 @else border-slate-200 @enderror focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm">
                    @error('nama')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">Alamat Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $mahasiswa->user->email ?? '') }}" required
                        class="w-full px-3.5 py-2.5 rounded-xl border @error('email') border-rose-500 @else border-slate-200 @enderror focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm">
                    @error('email')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="prodi_id" class="block text-xs font-semibold text-slate-700 mb-1.5">Program Studi</label>
                    <select name="prodi_id" id="prodi_id" required
                        class="w-full px-3.5 py-2.5 rounded-xl border @error('prodi_id') border-rose-500 @else border-slate-200 @enderror focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm">
                        @foreach($prodiList as $prodi)
                            <option value="{{ $prodi->id }}" {{ old('prodi_id', $mahasiswa->prodi_id) == $prodi->id ? 'selected' : '' }}>
                                {{ $prodi->nama_prodi }} ({{ $prodi->jenjang }}) - {{ $prodi->kode_prodi }}
                            </option>
                        @endforeach
                    </select>
                    @error('prodi_id')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="jenis_kelamin" class="block text-xs font-semibold text-slate-700 mb-1.5">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" required
                        class="w-full px-3.5 py-2.5 rounded-xl border @error('jenis_kelamin') border-rose-500 @else border-slate-200 @enderror focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm">
                        <option value="L" {{ old('jenis_kelamin', $mahasiswa->jenis_kelamin) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $mahasiswa->jenis_kelamin) === 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tanggal_lahir" class="block text-xs font-semibold text-slate-700 mb-1.5">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $mahasiswa->tanggal_lahir) }}" required
                        class="w-full px-3.5 py-2.5 rounded-xl border @error('tanggal_lahir') border-rose-500 @else border-slate-200 @enderror focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm">
                    @error('tanggal_lahir')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="angkatan" class="block text-xs font-semibold text-slate-700 mb-1.5">Tahun Angkatan</label>
                    <input type="number" name="angkatan" id="angkatan" value="{{ old('angkatan', $mahasiswa->angkatan) }}" required min="2000" max="{{ date('Y') + 1 }}"
                        class="w-full px-3.5 py-2.5 rounded-xl border @error('angkatan') border-rose-500 @else border-slate-200 @enderror focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm">
                    @error('angkatan')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="no_hp" class="block text-xs font-semibold text-slate-700 mb-1.5">Nomor Handphone (WhatsApp)</label>
                    <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $mahasiswa->no_hp) }}"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm">
                </div>

                <div>
                    <label for="alamat" class="block text-xs font-semibold text-slate-700 mb-1.5">Alamat Tempat Tinggal</label>
                    <textarea name="alamat" id="alamat" rows="1"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm">{{ old('alamat', $mahasiswa->alamat) }}</textarea>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.mahasiswa.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
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

