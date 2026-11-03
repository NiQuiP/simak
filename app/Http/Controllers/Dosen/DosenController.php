<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\MataKuliah;
use App\Models\Krs;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenController extends Controller
{
    protected function getDosen()
    {
        return Auth::user()->dosen;
    }

    public function dashboard()
    {
        $dosen = $this->getDosen();

        if (!$dosen) {
            abort(404, 'Profil dosen tidak ditemukan.');
        }

        $mataKuliahList = MataKuliah::with(['prodi'])
            ->withCount('krs')
            ->where('dosen_id', $dosen->id)
            ->get();

        $totalMK = $mataKuliahList->count();
        $totalMahasiswa = Krs::whereIn('mata_kuliah_id', $mataKuliahList->pluck('id'))->distinct('mahasiswa_id')->count('mahasiswa_id');

        return view('dosen.dashboard', compact('dosen', 'mataKuliahList', 'totalMK', 'totalMahasiswa'));
    }

    public function mataKuliahIndex()
    {
        $dosen = $this->getDosen();
        $mataKuliahList = MataKuliah::with('prodi')
            ->withCount('krs')
            ->where('dosen_id', $dosen->id)
            ->get();

        return view('dosen.mata-kuliah.index', compact('mataKuliahList'));
    }

    public function mataKuliahMahasiswa(MataKuliah $mataKuliah)
    {
        $dosen = $this->getDosen();
        if ($mataKuliah->dosen_id !== $dosen->id) {
            abort(403, 'Anda bukan pengampu mata kuliah ini.');
        }

        $krsList = Krs::with(['mahasiswa.prodi', 'nilai'])
            ->where('mata_kuliah_id', $mataKuliah->id)
            ->get();

        return view('dosen.mata-kuliah.mahasiswa', compact('mataKuliah', 'krsList'));
    }

    public function inputNilaiIndex()
    {
        $dosen = $this->getDosen();
        $mataKuliahList = MataKuliah::with('prodi')
            ->withCount('krs')
            ->where('dosen_id', $dosen->id)
            ->get();

        return view('dosen.nilai.index', compact('mataKuliahList'));
    }

    public function inputNilaiForm(MataKuliah $mataKuliah)
    {
        $dosen = $this->getDosen();
        if ($mataKuliah->dosen_id !== $dosen->id) {
            abort(403, 'Anda bukan pengampu mata kuliah ini.');
        }

        $krsList = Krs::with(['mahasiswa.prodi', 'nilai'])
            ->where('mata_kuliah_id', $mataKuliah->id)
            ->get();

        return view('dosen.nilai.form', compact('mataKuliah', 'krsList'));
    }

    public function simpanNilai(Request $request, MataKuliah $mataKuliah)
    {
        $dosen = $this->getDosen();
        if ($mataKuliah->dosen_id !== $dosen->id) {
            abort(403, 'Anda bukan pengampu mata kuliah ini.');
        }

        $dataNilai = $request->input('nilai', []);

        foreach ($dataNilai as $krsId => $item) {
            $angka = isset($item['angka']) && $item['angka'] !== '' ? (float) $item['angka'] : null;

            if ($angka !== null && ($angka < 0 || $angka > 100)) {
                return back()->with('error', 'Nilai angka harus berada di antara 0 dan 100.');
            }

            $huruf = !empty($item['huruf']) ? strtoupper($item['huruf']) : Nilai::konversiNilai($angka);

            Nilai::updateOrCreate(
                ['krs_id' => $krsId],
                [
                    'nilai_angka' => $angka,
                    'nilai_huruf' => $huruf,
                ]
            );
        }

        return redirect()->route('dosen.nilai.index')->with('success', 'Nilai mahasiswa untuk mata kuliah ' . $mataKuliah->nama_mk . ' berhasil disimpan!');
    }
}

