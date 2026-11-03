<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataKuliah;
use App\Models\Prodi;
use App\Models\Dosen;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = MataKuliah::with(['prodi', 'dosen']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_mk', 'like', "%{$search}%")
                  ->orWhere('nama_mk', 'like', "%{$search}%")
                  ->orWhereHas('prodi', fn($p) => $p->where('nama_prodi', 'like', "%{$search}%"))
                  ->orWhereHas('dosen', fn($d) => $d->where('nama', 'like', "%{$search}%"));
            });
        }

        $mkList = $query->orderBy('semester')->orderBy('kode_mk')->paginate(10)->withQueryString();

        return view('admin.mata-kuliah.index', compact('mkList', 'search'));
    }

    public function create()
    {
        $prodiList = Prodi::orderBy('nama_prodi')->get();
        $dosenList = Dosen::orderBy('nama')->get();
        return view('admin.mata-kuliah.create', compact('prodiList', 'dosenList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_mk' => ['required', 'string', 'max:10', 'unique:mata_kuliah,kode_mk'],
            'nama_mk' => ['required', 'string', 'max:100'],
            'prodi_id' => ['required', 'exists:prodi,id'],
            'dosen_id' => ['required', 'exists:dosen,id'],
            'sks' => ['required', 'integer', 'min:1', 'max:6'],
            'semester' => ['required', 'integer', 'min:1', 'max:8'],
        ], [
            'kode_mk.unique' => 'Kode Mata Kuliah sudah digunakan.',
        ]);

        MataKuliah::create($validated);

        return redirect()->route('admin.mata-kuliah.index')->with('success', 'Mata Kuliah berhasil ditambahkan!');
    }

    public function edit(MataKuliah $mataKuliah)
    {
        $prodiList = Prodi::orderBy('nama_prodi')->get();
        $dosenList = Dosen::orderBy('nama')->get();
        return view('admin.mata-kuliah.edit', compact('mataKuliah', 'prodiList', 'dosenList'));
    }

    public function update(Request $request, MataKuliah $mataKuliah)
    {
        $validated = $request->validate([
            'kode_mk' => ['required', 'string', 'max:10', 'unique:mata_kuliah,kode_mk,' . $mataKuliah->id],
            'nama_mk' => ['required', 'string', 'max:100'],
            'prodi_id' => ['required', 'exists:prodi,id'],
            'dosen_id' => ['required', 'exists:dosen,id'],
            'sks' => ['required', 'integer', 'min:1', 'max:6'],
            'semester' => ['required', 'integer', 'min:1', 'max:8'],
        ], [
            'kode_mk.unique' => 'Kode Mata Kuliah sudah digunakan.',
        ]);

        $mataKuliah->update($validated);

        return redirect()->route('admin.mata-kuliah.index')->with('success', 'Mata Kuliah berhasil diperbarui!');
    }

    public function destroy(MataKuliah $mataKuliah)
    {
        if ($mataKuliah->krs()->exists()) {
            return back()->with('error', 'Mata kuliah tidak dapat dihapus karena sudah diambil oleh mahasiswa dalam KRS.');
        }

        $mataKuliah->delete();
        return redirect()->route('admin.mata-kuliah.index')->with('success', 'Mata Kuliah berhasil dihapus!');
    }
}

