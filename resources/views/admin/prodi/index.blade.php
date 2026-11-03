@extends('layouts.app')

@section('header-title', 'Program Studi')
@section('header-subtitle', 'Manajemen daftar jurusan dan jenjang pendidikan')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-lg font-bold text-slate-800">Daftar Program Studi</h2>
            <p class="text-xs text-slate-500">Kelola prodi, kode jurusan, serta relasi jenjang</p>
        </div>
        <a href="{{ route('admin.prodi.create') }}" class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold shadow-xs shadow-indigo-600/30 transition">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Prodi</span>
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-xs font-semibold text-slate-500 uppercase tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3.5">Kode Prodi</th>
                        <th class="px-6 py-3.5">Nama Program Studi</th>
                        <th class="px-6 py-3.5">Jenjang</th>
                        <th class="px-6 py-3.5">Total Mahasiswa</th>
                        <th class="px-6 py-3.5">Total MK</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($prodiList as $prodi)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="px-6 py-3.5 font-mono text-xs font-bold text-slate-900">{{ $prodi->kode_prodi }}</td>
                            <td class="px-6 py-3.5 font-medium text-slate-800">{{ $prodi->nama_prodi }}</td>
                            <td class="px-6 py-3.5">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                    {{ $prodi->jenjang }}
                                </span>
                            </td>
                            <td class="px-6 py-3.5">{{ $prodi->mahasiswa_count }} Mahasiswa</td>
                            <td class="px-6 py-3.5">{{ $prodi->mata_kuliah_count }} Mata Kuliah</td>
                            <td class="px-6 py-3.5 text-right space-x-2">
                                <a href="{{ route('admin.prodi.edit', $prodi) }}" class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-xs font-medium text-indigo-600 hover:bg-indigo-50 transition">
                                    <i class="fa-regular fa-pen-to-square mr-1"></i> Edit
                                </a>
                                <form action="{{ route('admin.prodi.destroy', $prodi) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus prodi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-xs font-medium text-rose-600 hover:bg-rose-50 transition">
                                        <i class="fa-regular fa-trash-can mr-1"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-400">
                                Belum ada data program studi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($prodiList->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $prodiList->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

