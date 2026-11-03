@extends('layouts.app')

@section('header-title', 'Pengaturan Profil')
@section('header-subtitle', 'Perbarui informasi identitas pribadi, kontak, dan kata sandi Anda')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 sm:p-8">
        <div class="flex items-center space-x-4 mb-6 pb-6 border-b border-slate-100">
            <div class="w-16 h-16 rounded-2xl bg-indigo-50 border border-indigo-200 text-indigo-600 flex items-center justify-center text-2xl font-bold shadow-xs">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h2 class="text-lg font-bold text-slate-800">{{ $user->name }}</h2>
                <p class="text-xs text-slate-400">{{ $user->email }}</p>
                <span class="inline-flex items-center px-2 py-0.5 mt-1 rounded text-[10px] font-semibold uppercase tracking-wider
                    @if($user->role === 'admin') bg-rose-500/10 text-rose-600 border border-rose-500/20
                    @elseif($user->role === 'dosen') bg-emerald-500/10 text-emerald-600 border border-emerald-500/20
                    @else bg-blue-500/10 text-blue-600 border border-blue-500/20 @endif">
                    Peran: {{ $user->role }}
                </span>
            </div>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Informasi Akun Utama -->
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Informasi Akun</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                            class="w-full px-3.5 py-2.5 rounded-xl border @error('name') border-rose-500 @else border-slate-200 @enderror focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm">
                        @error('name')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">Alamat Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                            class="w-full px-3.5 py-2.5 rounded-xl border @error('email') border-rose-500 @else border-slate-200 @enderror focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm">
                        @error('email')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Informasi Tambahan Sesuai Role -->
            @if($user->isDosen())
                <div class="pt-4 border-t border-slate-100">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Informasi Dosen</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">NIDN (Nomor Induk Dosen)</label>
                            <input type="text" value="{{ $dosen->nidn ?? '-' }}" disabled
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-500 text-sm font-mono cursor-not-allowed">
                            <span class="text-[11px] text-slate-400">NIDN dikelola oleh Administrator</span>
                        </div>
                        <div>
                            <label for="no_hp" class="block text-xs font-semibold text-slate-700 mb-1.5">Nomor Handphone (WhatsApp)</label>
                            <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $dosen->no_hp ?? '') }}"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm placeholder:text-slate-400"
                                placeholder="081234567890">
                        </div>
                    </div>
                </div>

            @elseif($user->isMahasiswa())
                <div class="pt-4 border-t border-slate-100">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Informasi Akademik & Kontak</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">NIM</label>
                            <input type="text" value="{{ $mahasiswa->nim ?? '-' }}" disabled
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-500 text-sm font-mono cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Program Studi</label>
                            <input type="text" value="{{ $mahasiswa->prodi->nama_prodi ?? '-' }} ({{ $mahasiswa->prodi->jenjang ?? '' }})" disabled
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-500 text-sm cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Angkatan</label>
                            <input type="text" value="{{ $mahasiswa->angkatan ?? '-' }}" disabled
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-500 text-sm cursor-not-allowed">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="no_hp" class="block text-xs font-semibold text-slate-700 mb-1.5">Nomor Handphone (WhatsApp)</label>
                            <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $mahasiswa->no_hp ?? '') }}"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm placeholder:text-slate-400"
                                placeholder="081234567890">
                        </div>
                        <div>
                            <label for="alamat" class="block text-xs font-semibold text-slate-700 mb-1.5">Alamat Tempat Tinggal</label>
                            <textarea name="alamat" id="alamat" rows="1"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm">{{ old('alamat', $mahasiswa->alamat ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Ganti Kata Sandi -->
            <div class="pt-4 border-t border-slate-100">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Ganti Kata Sandi</h3>
                <p class="text-xs text-slate-400 mb-3">Kosongkan jika Anda tidak ingin mengganti kata sandi.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-xs font-semibold text-slate-700 mb-1.5">Kata Sandi Baru</label>
                        <input type="password" name="password" id="password"
                            class="w-full px-3.5 py-2.5 rounded-xl border @error('password') border-rose-500 @else border-slate-200 @enderror focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm"
                            placeholder="Minimal 6 karakter">
                        @error('password')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 mb-1.5">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm"
                            placeholder="Ulangi kata sandi baru">
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold shadow-xs shadow-indigo-600/30 transition flex items-center space-x-1.5">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Perubahan Profil</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

