<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Mahasiswa::with(['prodi', 'user']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nim', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhereHas('prodi', function ($p) use ($search) {
                      $p->where('nama_prodi', 'like', "%{$search}%");
                  });
            });
        }

        $mahasiswaList = $query->latest()->paginate(10)->withQueryString();

        return view('admin.mahasiswa.index', compact('mahasiswaList', 'search'));
    }

    public function create()
    {
        $prodiList = Prodi::orderBy('nama_prodi')->get();
        return view('admin.mahasiswa.create', compact('prodiList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim' => ['required', 'string', 'max:15', 'unique:mahasiswa,nim'],
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:users,email'],
            'prodi_id' => ['required', 'exists:prodi,id'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tanggal_lahir' => ['required', 'date'],
            'alamat' => ['nullable', 'string'],
            'no_hp' => ['nullable', 'string', 'max:15'],
            'angkatan' => ['required', 'digits:4', 'integer'],
        ], [
            'nim.unique' => 'NIM sudah digunakan.',
            'email.unique' => 'Email sudah terdaftar untuk akun user lain.',
        ]);

        DB::transaction(function () use ($validated) {
            // Otomatis buat akun user role mahasiswa (Issue 6)
            $user = User::create([
                'name' => $validated['nama'],
                'email' => $validated['email'],
                'password' => Hash::make('password'), // password default
                'role' => 'mahasiswa',
            ]);

            Mahasiswa::create([
                'user_id' => $user->id,
                'prodi_id' => $validated['prodi_id'],
                'nim' => $validated['nim'],
                'nama' => $validated['nama'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'alamat' => $validated['alamat'],
                'no_hp' => $validated['no_hp'],
                'angkatan' => $validated['angkatan'],
            ]);
        });

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Data Mahasiswa dan akun login berhasil dibuat! (Password default: password)');
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        $prodiList = Prodi::orderBy('nama_prodi')->get();
        return view('admin.mahasiswa.edit', compact('mahasiswa', 'prodiList'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $validated = $request->validate([
            'nim' => ['required', 'string', 'max:15', 'unique:mahasiswa,nim,' . $mahasiswa->id],
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:users,email,' . $mahasiswa->user_id],
            'prodi_id' => ['required', 'exists:prodi,id'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tanggal_lahir' => ['required', 'date'],
            'alamat' => ['nullable', 'string'],
            'no_hp' => ['nullable', 'string', 'max:15'],
            'angkatan' => ['required', 'digits:4', 'integer'],
        ], [
            'nim.unique' => 'NIM sudah digunakan.',
            'email.unique' => 'Email sudah terdaftar untuk akun user lain.',
        ]);

        DB::transaction(function () use ($validated, $mahasiswa) {
            $mahasiswa->user->update([
                'name' => $validated['nama'],
                'email' => $validated['email'],
            ]);

            $mahasiswa->update([
                'prodi_id' => $validated['prodi_id'],
                'nim' => $validated['nim'],
                'nama' => $validated['nama'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'alamat' => $validated['alamat'],
                'no_hp' => $validated['no_hp'],
                'angkatan' => $validated['angkatan'],
            ]);
        });

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Data Mahasiswa berhasil diperbarui!');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        DB::transaction(function () use ($mahasiswa) {
            $user = $mahasiswa->user;
            $mahasiswa->delete();
            if ($user) {
                $user->delete();
            }
        });

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Data Mahasiswa beserta akun berhasil dihapus!');
    }
}

