<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\MataKuliah;
use App\Models\Krs;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    protected function getMahasiswa()
    {
        return Auth::user()->mahasiswa;
    }

    public function dashboard()
    {
        $mahasiswa = $this->getMahasiswa();

        if (!$mahasiswa) {
            abort(404, 'Profil mahasiswa tidak ditemukan.');
        }

        $krsAktif = Krs::with(['mataKuliah.dosen', 'nilai'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->get();

        $totalSKS = $krsAktif->sum(fn($k) => $k->mataKuliah->sks ?? 0);
        $totalMK = $krsAktif->count();

        // Hitung ringkasan nilai
        $nilaiList = $krsAktif->pluck('nilai')->filter(fn($n) => $n && $n->nilai_angka !== null);
        $rataRataNilai = $nilaiList->count() > 0 ? round($nilaiList->avg('nilai_angka'), 2) : 0;

        return view('mahasiswa.dashboard', compact('mahasiswa', 'krsAktif', 'totalSKS', 'totalMK', 'rataRataNilai'));
    }

    public function krsIndex()
    {
        $mahasiswa = $this->getMahasiswa();

        // Ambil mata kuliah yang tersedia sesuai prodi mahasiswa (Issue 9)
        $mkTersedia = MataKuliah::with('dosen')
            ->where('prodi_id', $mahasiswa->prodi_id)
            ->orderBy('semester')
            ->orderBy('kode_mk')
            ->get();

        // KRS yang sudah diambil mahasiswa
        $krsDiambil = Krs::with('mataKuliah.dosen')
            ->where('mahasiswa_id', $mahasiswa->id)
            ->get();

        $krsDiambilIds = $krsDiambil->pluck('mata_kuliah_id')->toArray();
        $totalSksDiambil = $krsDiambil->sum(fn($k) => $k->mataKuliah->sks ?? 0);

        return view('mahasiswa.krs.index', compact('mahasiswa', 'mkTersedia', 'krsDiambil', 'krsDiambilIds', 'totalSksDiambil'));
    }

    public function krsSimpan(Request $request)
    {
        $mahasiswa = $this->getMahasiswa();

        $mataKuliahIds = $request->input('mata_kuliah', []);

        if (empty($mataKuliahIds)) {
            // Jika kosong, konfirmasi atau hapus semua pilihan krs semester ini
            Krs::where('mahasiswa_id', $mahasiswa->id)->delete();
            return redirect()->route('mahasiswa.krs.index')->with('success', 'KRS berhasil diperbarui (tidak ada mata kuliah yang dipilih).');
        }

        // Validasi MK harus dari prodi mahasiswa
        $validMK = MataKuliah::where('prodi_id', $mahasiswa->prodi_id)
            ->whereIn('id', $mataKuliahIds)
            ->pluck('id')
            ->toArray();

        // Hapus KRS yang tidak dicentang lagi
        Krs::where('mahasiswa_id', $mahasiswa->id)
            ->whereNotIn('mata_kuliah_id', $validMK)
            ->delete();

        // Tambah MK yang baru dicentang
        $existingMK = Krs::where('mahasiswa_id', $mahasiswa->id)->pluck('mata_kuliah_id')->toArray();

        foreach ($validMK as $mkId) {
            if (!in_array($mkId, $existingMK)) {
                $krs = Krs::create([
                    'mahasiswa_id' => $mahasiswa->id,
                    'mata_kuliah_id' => $mkId,
                    'tahun_ajaran' => '2024/2025',
                    'semester' => 'ganjil',
                ]);

                // Buat record nilai kosong
                Nilai::create([
                    'krs_id' => $krs->id,
                    'nilai_angka' => null,
                    'nilai_huruf' => null,
                ]);
            }
        }

        return redirect()->route('mahasiswa.krs.index')->with('success', 'KRS berhasil disimpan!');
    }

    public function nilaiIndex()
    {
        $mahasiswa = $this->getMahasiswa();

        $krsList = Krs::with(['mataKuliah.dosen', 'nilai'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->get();

        return view('mahasiswa.nilai.index', compact('mahasiswa', 'krsList'));
    }
}

