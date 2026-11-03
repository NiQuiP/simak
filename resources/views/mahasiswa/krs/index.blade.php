@extends('layouts.app')

@section('header-title', 'Kartu Rencana Studi (KRS)')
@section('header-subtitle', 'Pilih mata kuliah yang akan diambil untuk semester ini')

@section('content')
<div class="space-y-6">

    <!-- Ringkasan Info KRS Mahasiswa (Issue 9) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-base font-bold text-slate-800">Program Studi: {{ $mahasiswa->prodi->nama_prodi }} ({{ $mahasiswa->prodi->jenjang }})</h2>
            <p class="text-xs text-slate-500 mt-0.5">Tahun Ajaran: 2024/2025 &bull; Semester: Ganjil &bull; NIM: {{ $mahasiswa->nim }}</p>
        </div>
        <div class="flex items-center space-x-4 bg-slate-50 px-4 py-2.5 rounded-xl border border-slate-200/80">
            <div>
                <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">Total SKS Terpilih</span>
                <span id="displayTotalSks" class="text-lg font-bold text-indigo-600 block leading-tight">{{ $totalSksDiambil }} SKS</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-bold">
                <i class="fa-solid fa-calculator"></i>
            </div>
        </div>
    </div>

    <!-- Form Pemilihan KRS -->
    <form action="{{ route('mahasiswa.krs.simpan') }}" method="POST">
        @csrf

        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-slate-800">Daftar Mata Kuliah Tersedia</h3>
                    <p class="text-xs text-slate-400">Centang mata kuliah yang ingin Anda ambil pada semester ini</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-xs font-semibold text-slate-500 uppercase tracking-wider border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-3.5 text-center w-16">Pilih</th>
                            <th class="px-6 py-3.5">Kode MK</th>
                            <th class="px-6 py-3.5">Nama Mata Kuliah</th>
                            <th class="px-6 py-3.5 text-center">Semester</th>
                            <th class="px-6 py-3.5 text-center">Beban SKS</th>
                            <th class="px-6 py-3.5">Dosen Pengampu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($mkTersedia as $mk)
                            @php
                                $isChecked = in_array($mk->id, $krsDiambilIds);
                            @endphp
                            <tr class="hover:bg-slate-50/60 transition {{ $isChecked ? 'bg-indigo-50/30' : '' }}">
                                <td class="px-6 py-3.5 text-center">
                                    <input type="checkbox" name="mata_kuliah[]" value="{{ $mk->id }}"
                                        data-sks="{{ $mk->sks }}"
                                        {{ $isChecked ? 'checked' : '' }}
                                        class="mk-checkbox w-4 h-4 rounded text-indigo-600 border-slate-300 focus:ring-indigo-500 cursor-pointer">
                                </td>
                                <td class="px-6 py-3.5 font-mono text-xs font-bold text-slate-900">{{ $mk->kode_mk }}</td>
                                <td class="px-6 py-3.5 font-semibold text-slate-800">{{ $mk->nama_mk }}</td>
                                <td class="px-6 py-3.5 text-center text-xs font-medium text-slate-600">Sem. {{ $mk->semester }}</td>
                                <td class="px-6 py-3.5 text-center">
                                    <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-indigo-50 text-indigo-700 font-bold text-xs">
                                        {{ $mk->sks }}
                                    </span>
                                </td>
                                <td class="px-6 py-3.5 text-xs text-slate-600">
                                    <i class="fa-solid fa-chalkboard-user text-slate-400 mr-1.5"></i>
                                    {{ $mk->dosen->nama ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-slate-400">
                                    Tidak ada mata kuliah yang tersedia untuk Program Studi Anda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-500">
                    Pastikan pilihan Anda sudah benar sebelum menyimpan.
                </span>
                <button type="submit" class="inline-flex items-center space-x-2 px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold shadow-xs shadow-indigo-600/30 transition">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan KRS</span>
                </button>
            </div>
        </div>
    </form>

</div>

<script>
    // Real-time kalkulasi total SKS yang dicentang
    const checkboxes = document.querySelectorAll('.mk-checkbox');
    const displayTotalSks = document.getElementById('displayTotalSks');

    function calculateTotalSKS() {
        let total = 0;
        checkboxes.forEach(cb => {
            if (cb.checked) {
                total += parseInt(cb.getAttribute('data-sks') || 0);
            }
        });
        displayTotalSks.textContent = total + ' SKS';
    }

    checkboxes.forEach(cb => {
        cb.addEventListener('change', calculateTotalSKS);
    });
</script>
@endsection

