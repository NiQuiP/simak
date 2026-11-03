<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Prodi;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Krs;
use App\Models\Nilai;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Utama (Issue 3: minimal 1 admin, 1 dosen, 1 mahasiswa)
        $adminUser = User::create([
            'name' => 'Administrator SIMAK',
            'email' => 'admin@simak.ac.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $dosenUser1 = User::create([
            'name' => 'Dr. Ir. Budi Santoso, M.Kom.',
            'email' => 'dosen@simak.ac.id',
            'password' => Hash::make('password'),
            'role' => 'dosen',
        ]);

        $mhsUser1 = User::create([
            'name' => 'Ahmad Fauzi',
            'email' => 'mahasiswa@simak.ac.id',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
        ]);

        // Dosen user lainnya (minimal 5 total dosen)
        $dosenUser2 = User::create([
            'name' => 'Siti Nurhaliza, M.T.',
            'email' => 'siti@simak.ac.id',
            'password' => Hash::make('password'),
            'role' => 'dosen',
        ]);
        $dosenUser3 = User::create([
            'name' => 'Prof. Eko Prasetyo, Ph.D.',
            'email' => 'eko@simak.ac.id',
            'password' => Hash::make('password'),
            'role' => 'dosen',
        ]);
        $dosenUser4 = User::create([
            'name' => 'Rina Wijaya, S.Kom., M.Cs.',
            'email' => 'rina@simak.ac.id',
            'password' => Hash::make('password'),
            'role' => 'dosen',
        ]);
        $dosenUser5 = User::create([
            'name' => 'Hendra Gunawan, M.Kom.',
            'email' => 'hendra@simak.ac.id',
            'password' => Hash::make('password'),
            'role' => 'dosen',
        ]);

        // Mahasiswa user lainnya (minimal 5 total mahasiswa)
        $mhsUser2 = User::create([
            'name' => 'Dewi Sartika',
            'email' => 'dewi@simak.ac.id',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
        ]);
        $mhsUser3 = User::create([
            'name' => 'Rizky Pratama',
            'email' => 'rizky@simak.ac.id',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
        ]);
        $mhsUser4 = User::create([
            'name' => 'Anisa Rahmawati',
            'email' => 'anisa@simak.ac.id',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
        ]);
        $mhsUser5 = User::create([
            'name' => 'Bambang Pamungkas',
            'email' => 'bambang@simak.ac.id',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
        ]);

        // 2. Data Program Studi (5 data)
        $prodi1 = Prodi::create(['kode_prodi' => 'IF', 'nama_prodi' => 'Informatika', 'jenjang' => 'S1']);
        $prodi2 = Prodi::create(['kode_prodi' => 'SI', 'nama_prodi' => 'Sistem Informasi', 'jenjang' => 'S1']);
        $prodi3 = Prodi::create(['kode_prodi' => 'TI', 'nama_prodi' => 'Teknologi Informasi', 'jenjang' => 'S1']);
        $prodi4 = Prodi::create(['kode_prodi' => 'TE', 'nama_prodi' => 'Teknik Elektro', 'jenjang' => 'S1']);
        $prodi5 = Prodi::create(['kode_prodi' => 'MI', 'nama_prodi' => 'Manajemen Informatika', 'jenjang' => 'D3']);

        // 3. Data Dosen (5 data)
        $dosen1 = Dosen::create(['user_id' => $dosenUser1->id, 'nidn' => '0011223344', 'nama' => $dosenUser1->name, 'no_hp' => '081234567801']);
        $dosen2 = Dosen::create(['user_id' => $dosenUser2->id, 'nidn' => '0011223345', 'nama' => $dosenUser2->name, 'no_hp' => '081234567802']);
        $dosen3 = Dosen::create(['user_id' => $dosenUser3->id, 'nidn' => '0011223346', 'nama' => $dosenUser3->name, 'no_hp' => '081234567803']);
        $dosen4 = Dosen::create(['user_id' => $dosenUser4->id, 'nidn' => '0011223347', 'nama' => $dosenUser4->name, 'no_hp' => '081234567804']);
        $dosen5 = Dosen::create(['user_id' => $dosenUser5->id, 'nidn' => '0011223348', 'nama' => $dosenUser5->name, 'no_hp' => '081234567805']);

        // 4. Data Mahasiswa (5 data)
        $mhs1 = Mahasiswa::create([
            'user_id' => $mhsUser1->id,
            'prodi_id' => $prodi1->id,
            'nim' => '230101001',
            'nama' => $mhsUser1->name,
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '2004-05-14',
            'alamat' => 'Jl. Merdeka No. 10, Jakarta',
            'no_hp' => '082100000001',
            'angkatan' => 2023,
        ]);
        $mhs2 = Mahasiswa::create([
            'user_id' => $mhsUser2->id,
            'prodi_id' => $prodi1->id,
            'nim' => '230101002',
            'nama' => $mhsUser2->name,
            'jenis_kelamin' => 'P',
            'tanggal_lahir' => '2004-08-20',
            'alamat' => 'Jl. Sudirman No. 45, Bandung',
            'no_hp' => '082100000002',
            'angkatan' => 2023,
        ]);
        $mhs3 = Mahasiswa::create([
            'user_id' => $mhsUser3->id,
            'prodi_id' => $prodi2->id,
            'nim' => '230201001',
            'nama' => $mhsUser3->name,
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '2003-12-11',
            'alamat' => 'Jl. Diponegoro No. 8, Surabaya',
            'no_hp' => '082100000003',
            'angkatan' => 2023,
        ]);
        $mhs4 = Mahasiswa::create([
            'user_id' => $mhsUser4->id,
            'prodi_id' => $prodi2->id,
            'nim' => '230201002',
            'nama' => $mhsUser4->name,
            'jenis_kelamin' => 'P',
            'tanggal_lahir' => '2004-02-18',
            'alamat' => 'Jl. Gajah Mada No. 12, Semarang',
            'no_hp' => '082100000004',
            'angkatan' => 2023,
        ]);
        $mhs5 = Mahasiswa::create([
            'user_id' => $mhsUser5->id,
            'prodi_id' => $prodi3->id,
            'nim' => '230301001',
            'nama' => $mhsUser5->name,
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '2003-09-05',
            'alamat' => 'Jl. Malioboro No. 25, Yogyakarta',
            'no_hp' => '082100000005',
            'angkatan' => 2023,
        ]);

        // 5. Data Mata Kuliah (6 data)
        $mk1 = MataKuliah::create([
            'prodi_id' => $prodi1->id,
            'dosen_id' => $dosen1->id,
            'kode_mk' => 'IF101',
            'nama_mk' => 'Pemrograman Web',
            'sks' => 3,
            'semester' => 3,
        ]);
        $mk2 = MataKuliah::create([
            'prodi_id' => $prodi1->id,
            'dosen_id' => $dosen1->id,
            'kode_mk' => 'IF102',
            'nama_mk' => 'Basis Data Lanjut',
            'sks' => 3,
            'semester' => 3,
        ]);
        $mk3 = MataKuliah::create([
            'prodi_id' => $prodi1->id,
            'dosen_id' => $dosen2->id,
            'kode_mk' => 'IF103',
            'nama_mk' => 'Struktur Data & Algoritma',
            'sks' => 4,
            'semester' => 3,
        ]);
        $mk4 = MataKuliah::create([
            'prodi_id' => $prodi2->id,
            'dosen_id' => $dosen3->id,
            'kode_mk' => 'SI201',
            'nama_mk' => 'Analisis dan Desain Sistem',
            'sks' => 3,
            'semester' => 3,
        ]);
        $mk5 = MataKuliah::create([
            'prodi_id' => $prodi2->id,
            'dosen_id' => $dosen4->id,
            'kode_mk' => 'SI202',
            'nama_mk' => 'Manajemen Proyek TI',
            'sks' => 3,
            'semester' => 3,
        ]);
        $mk6 = MataKuliah::create([
            'prodi_id' => $prodi3->id,
            'dosen_id' => $dosen5->id,
            'kode_mk' => 'TI301',
            'nama_mk' => 'Jaringan Komputer',
            'sks' => 3,
            'semester' => 3,
        ]);

        // 6. Data KRS
        $krs1 = Krs::create([
            'mahasiswa_id' => $mhs1->id,
            'mata_kuliah_id' => $mk1->id,
            'tahun_ajaran' => '2024/2025',
            'semester' => 'ganjil',
        ]);
        $krs2 = Krs::create([
            'mahasiswa_id' => $mhs1->id,
            'mata_kuliah_id' => $mk2->id,
            'tahun_ajaran' => '2024/2025',
            'semester' => 'ganjil',
        ]);
        $krs3 = Krs::create([
            'mahasiswa_id' => $mhs1->id,
            'mata_kuliah_id' => $mk3->id,
            'tahun_ajaran' => '2024/2025',
            'semester' => 'ganjil',
        ]);
        $krs4 = Krs::create([
            'mahasiswa_id' => $mhs2->id,
            'mata_kuliah_id' => $mk1->id,
            'tahun_ajaran' => '2024/2025',
            'semester' => 'ganjil',
        ]);
        $krs5 = Krs::create([
            'mahasiswa_id' => $mhs3->id,
            'mata_kuliah_id' => $mk4->id,
            'tahun_ajaran' => '2024/2025',
            'semester' => 'ganjil',
        ]);

        // 7. Data Nilai
        Nilai::create([
            'krs_id' => $krs1->id,
            'nilai_angka' => 88.50,
            'nilai_huruf' => 'A',
        ]);
        Nilai::create([
            'krs_id' => $krs2->id,
            'nilai_angka' => 78.00,
            'nilai_huruf' => 'B',
        ]);
        Nilai::create([
            'krs_id' => $krs3->id,
            'nilai_angka' => null,
            'nilai_huruf' => null,
        ]);
        Nilai::create([
            'krs_id' => $krs4->id,
            'nilai_angka' => 91.00,
            'nilai_huruf' => 'A',
        ]);
        Nilai::create([
            'krs_id' => $krs5->id,
            'nilai_angka' => 65.50,
            'nilai_huruf' => 'C',
        ]);
    }
}
