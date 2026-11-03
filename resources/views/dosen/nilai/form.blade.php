@extends('layouts.app')

@section('header-title', 'Form Input Nilai Mahasiswa')
@section('header-subtitle', $mataKuliah->nama_mk . ' (' . $mataKuliah->kode_mk . ')')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <span class="font-mono text-xs font-bold text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded">{{ $mataKuliah->kode_mk }}</span>
                <h2 class="text-lg font-bold text-slate-800">{{ $mataKuliah->nama_mk }}</h2>
            </div>
            <p class="text-xs text-slate-500 mt-1">Masukkan nilai angka (0 - 100). Nilai huruf otomatis dihitung atau dapat disesuaikan manual.</p>
        </div>
        <a href="{{ route('dosen.nilai.index') }}" class="self-start sm:self-auto px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
            <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Daftar MK
        </a>
    </div>

    <!-- Acuan Konversi Nilai -->
    <div class="bg-indigo-50/60 border border-indigo-100 rounded-xl p-4 text-xs text-indigo-900 flex flex-wrap items-center gap-4">
        <span class="font-bold flex items-center">
            <i class="fa-solid fa-circle-info mr-1.5 text-indigo-600"></i> Standar Konversi:
        </span>
        <span>A: &ge; 85</span>
        <span>B: 70 - 84.99</span>
        <span>C: 55 - 69.99</span>
        <span>D: 40 - 54.99</span>
        <span>E: &lt; 40</span>
    </div>

    <form action="{{ route('dosen.nilai.simpan', $mataKuliah) }}" method="POST">
        @csrf

        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-xs font-semibold text-slate-500 uppercase tracking-wider border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-3.5">NIM</th>
                            <th class="px-6 py-3.5">Nama Mahasiswa</th>
                            <th class="px-6 py-3.5">Program Studi</th>
                            <th class="px-6 py-3.5 w-44">Nilai Angka (0-100)</th>
                            <th class="px-6 py-3.5 w-36">Nilai Huruf</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($krsList as $krs)
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="px-6 py-3.5 font-mono text-xs font-bold text-slate-900">{{ $krs->mahasiswa->nim }}</td>
                                <td class="px-6 py-3.5 font-medium text-slate-800">{{ $krs->mahasiswa->nama }}</td>
                                <td class="px-6 py-3.5 text-xs text-slate-500">{{ $krs->mahasiswa->prodi->nama_prodi ?? '-' }}</td>
                                <td class="px-6 py-3.5">
                                    <input type="number" step="0.01" min="0" max="100"
                                        name="nilai[{{ $krs->id }}][angka]"
                                        value="{{ old('nilai.' . $krs->id . '.angka', $krs->nilai->nilai_angka ?? '') }}"
                                        data-krs-id="{{ $krs->id }}"
                                        class="nilai-angka w-full px-3 py-1.5 rounded-lg border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm font-mono font-semibold"
                                        placeholder="0 - 100">
                                </td>
                                <td class="px-6 py-3.5">
                                    <select name="nilai[{{ $krs->id }}][huruf]" id="huruf_{{ $krs->id }}"
                                        class="w-full px-3 py-1.5 rounded-lg border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm font-bold">
                                        <option value="">-</option>
                                        @php
                                            $currHuruf = old('nilai.' . $krs->id . '.huruf', $krs->nilai->nilai_huruf ?? '');
                                        @endphp
                                        <option value="A" {{ $currHuruf === 'A' ? 'selected' : '' }}>A</option>
                                        <option value="B" {{ $currHuruf === 'B' ? 'selected' : '' }}>B</option>
                                        <option value="C" {{ $currHuruf === 'C' ? 'selected' : '' }}>C</option>
                                        <option value="D" {{ $currHuruf === 'D' ? 'selected' : '' }}>D</option>
                                        <option value="E" {{ $currHuruf === 'E' ? 'selected' : '' }}>E</option>
                                    </select>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-400">
                                    Belum ada mahasiswa yang mengambil mata kuliah ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($krsList->isNotEmpty())
                <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end space-x-3">
                    <a href="{{ route('dosen.nilai.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-100 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold shadow-xs shadow-indigo-600/30 transition">
                        <i class="fa-solid fa-floppy-disk mr-1.5"></i> Simpan Seluruh Nilai
                    </button>
                </div>
            @endif
        </div>
    </form>

</div>

<script>
    // Auto calculate nilai huruf saat nilai angka berubah
    document.querySelectorAll('.nilai-angka').forEach(input => {
        input.addEventListener('input', function() {
            const krsId = this.getAttribute('data-krs-id');
            const selectHuruf = document.getElementById('huruf_' + krsId);
            const val = parseFloat(this.value);

            if (isNaN(val) || this.value === '') {
                selectHuruf.value = '';
                return;
            }

            if (val >= 85) selectHuruf.value = 'A';
            else if (val >= 70) selectHuruf.value = 'B';
            else if (val >= 55) selectHuruf.value = 'C';
            else if (val >= 40) selectHuruf.value = 'D';
            else selectHuruf.value = 'E';
        });
    });
</script>
@endsection

