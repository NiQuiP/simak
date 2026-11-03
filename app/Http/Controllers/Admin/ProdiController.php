<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    public function index()
    {
        $prodiList = Prodi::withCount(['mahasiswa', 'mataKuliah'])->orderBy('kode_prodi')->paginate(10);
        return view('admin.prodi.index', compact('prodiList'));
    }

    public function create()
    {
        return view('admin.prodi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_prodi' => ['required', 'string', 'max:10', 'unique:prodi,kode_prodi'],
            'nama_prodi' => ['required', 'string', 'max:100'],
            'jenjang' => ['required', 'string', 'max:5'],
        ], [
            'kode_prodi.unique' => 'Kode Program Studi sudah terdaftar.',
        ]);

        Prodi::create($validated);

        return redirect()->route('admin.prodi.index')->with('success', 'Program Studi berhasil ditambahkan!');
    }

    public function edit(Prodi $prodi)
    {
        return view('admin.prodi.edit', compact('prodi'));
    }

    public function update(Request $request, Prodi $prodi)
    {
        $validated = $request->validate([
            'kode_prodi' => ['required', 'string', 'max:10', 'unique:prodi,kode_prodi,' . $prodi->id],
            'nama_prodi' => ['required', 'string', 'max:100'],
            'jenjang' => ['required', 'string', 'max:5'],
        ], [
            'kode_prodi.unique' => 'Kode Program Studi sudah terdaftar.',
        ]);

        $prodi->update($validated);

        return redirect()->route('admin.prodi.index')->with('success', 'Program Studi berhasil diperbarui!');
    }

    public function destroy(Prodi $prodi)
    {
        if ($prodi->mahasiswa()->exists() || $prodi->mataKuliah()->exists()) {
            return back()->with('error', 'Program Studi tidak dapat dihapus karena masih memiliki relasi data mahasiswa atau mata kuliah.');
        }

        $prodi->delete();
        return redirect()->route('admin.prodi.index')->with('success', 'Program Studi berhasil dihapus!');
    }
}

