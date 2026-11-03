<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $dosen = $user->dosen;
        $mahasiswa = $user->mahasiswa;

        return view('profile.edit', compact('user', 'dosen', 'mahasiswa'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ];

        if ($user->isDosen()) {
            $rules['no_hp'] = ['nullable', 'string', 'max:15'];
        } elseif ($user->isMahasiswa()) {
            $rules['no_hp'] = ['nullable', 'string', 'max:15'];
            $rules['alamat'] = ['nullable', 'string'];
        }

        $validated = $request->validate($rules);

        // Update user
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        $user->save();

        // Update profil terkait jika dosen / mahasiswa
        if ($user->isDosen() && $user->dosen) {
            $user->dosen->update([
                'nama' => $validated['name'],
                'no_hp' => $validated['no_hp'] ?? null,
            ]);
        } elseif ($user->isMahasiswa() && $user->mahasiswa) {
            $user->mahasiswa->update([
                'nama' => $validated['name'],
                'no_hp' => $validated['no_hp'] ?? null,
                'alamat' => $validated['alamat'] ?? null,
            ]);
        }

        return back()->with('success', 'Profil Anda berhasil diperbarui!');
    }
}

