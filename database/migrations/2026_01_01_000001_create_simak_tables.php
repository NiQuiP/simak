<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tabel prodi
        Schema::create('prodi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_prodi', 10)->unique();
            $table->string('nama_prodi', 100);
            $table->string('jenjang', 5); // misal S1, D3, S2
            $table->timestamps();
        });

        // 2. Tabel dosen
        Schema::create('dosen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nidn', 20)->unique();
            $table->string('nama', 100);
            $table->string('no_hp', 15)->nullable();
            $table->timestamps();
        });

        // 3. Tabel mahasiswa
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('prodi_id')->constrained('prodi')->onDelete('restrict');
            $table->string('nim', 15)->unique();
            $table->string('nama', 100);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tanggal_lahir');
            $table->text('alamat')->nullable();
            $table->string('no_hp', 15)->nullable();
            $table->year('angkatan');
            $table->timestamps();
        });

        // 4. Tabel mata_kuliah
        Schema::create('mata_kuliah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prodi_id')->constrained('prodi')->onDelete('restrict');
            $table->foreignId('dosen_id')->constrained('dosen')->onDelete('restrict');
            $table->string('kode_mk', 10)->unique();
            $table->string('nama_mk', 100);
            $table->tinyInteger('sks');
            $table->tinyInteger('semester');
            $table->timestamps();
        });

        // 5. Tabel krs
        Schema::create('krs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->onDelete('cascade');
            $table->foreignId('mata_kuliah_id')->constrained('mata_kuliah')->onDelete('cascade');
            $table->string('tahun_ajaran', 9); // misal 2024/2025
            $table->enum('semester', ['ganjil', 'genap']);
            $table->timestamps();
        });

        // 6. Tabel nilai
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('krs_id')->constrained('krs')->onDelete('cascade');
            $table->decimal('nilai_angka', 5, 2)->nullable();
            $table->string('nilai_huruf', 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai');
        Schema::dropIfExists('krs');
        Schema::dropIfExists('mata_kuliah');
        Schema::dropIfExists('mahasiswa');
        Schema::dropIfExists('dosen');
        Schema::dropIfExists('prodi');
    }
};

