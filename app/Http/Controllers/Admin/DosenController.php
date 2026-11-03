<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DosenController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Dosen::with(['user'])->withCount('mataKuliah');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nidn', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        $dosenList = $query->latest()->paginate(10)->withQueryString();

        return view('admin.dosen.index', compact('dosenList', 'search'));
    }

    public function create()
    {
        return view('admin.dosen.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nidn' => ['required', 'string', 'max:20', 'unique:dosen,nidn'],
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:users,email'],
            'no_hp' => ['nullable', 'string', 'max:15'],
        ], [
            'nidn.unique' => 'NIDN sudah terdaftar.',
            'email.unique' => 'Email sudah terdaftar.',
        ]);

        DB::transaction(function () use ($validated) {
            // Otomatis buat akun user role dosen (Issue 7)
            $user = User::create([
                'name' => $validated['nama'],
                'email' => $validated['email'],
                'password' => Hash::make('password'),
                'role' => 'dosen',
            ]);

            Dosen::create([
                'user_id' => $user->id,
                'nidn' => $validated['nidn'],
                'nama' => $validated['nama'],
                'no_hp' => $validated['no_hp'],
            ]);
        });

        return redirect()->route('admin.dosen.index')->with('success', 'Data Dosen dan akun login berhasil dibuat! (Password default: password)');
    }

    public function edit(Dosen $dosen)
    {
        return view('admin.dosen.edit', compact('dosen'));
    }

    public function update(Request $request, Dosen $dosen)
    {
        $validated = $request->validate([
            'nidn' => ['required', 'string', 'max:20', 'unique:dosen,nidn,' . $dosen->id],
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:users,email,' . $dosen->user_id],
            'no_hp' => ['nullable', 'string', 'max:15'],
        ], [
            'nidn.unique' => 'NIDN sudah terdaftar.',
            'email.unique' => 'Email sudah terdaftar.',
        ]);

        DB::transaction(function () use ($validated, $dosen) {
            $dosen->user->update([
                'name' => $validated['nama'],
                'email' => $validated['email'],
            ]);

            $dosen->update([
                'nidn' => $validated['nidn'],
                'nama' => $validated['nama'],
                'no_hp' => $validated['no_hp'],
            ]);
        });

        return redirect()->route('admin.dosen.index')->with('success', 'Data Dosen berhasil diperbarui!');
    }

    public function destroy(Dosen $dosen)
    {
        if ($dosen->mataKuliah()->exists()) {
            return back()->with('error', 'Dosen tidak dapat dihapus karena masih mengampu mata kuliah aktif.');
        }

        DB::transaction(function () use ($dosen) {
            $user = $dosen->user;
            $dosen->delete();
            if ($user) {
                $user->delete();
            }
        });

        return redirect()->route('admin.dosen.index')->with('success', 'Data Dosen beserta akun berhasil dihapus!');
    }
}

