<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AsesorController extends Controller
{
    /**
     * Display a listing of the Asesors.
     */
    public function index()
    {
        $asesors = User::latest()->get();
        return view('admin.asesors.index', compact('asesors'));
    }

    /**
     * Show the form for creating a new Asesor.
     */
    public function create()
    {
        return view('admin.asesors.create');
    }

    /**
     * Store a newly created Asesor in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // max 2MB
        ], [
            'name.required' => 'Nama pengguna wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar di sistem.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal berisi 6 karakter.',
            'photo.image' => 'Berkas foto profil harus berupa gambar.',
            'photo.max' => 'Ukuran foto profil maksimal adalah 2MB.',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = 'profile_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $photoPath = $file->storeAs('profiles', $filename, 'public');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'asesor',
            'phone' => $request->phone,
            'address' => $request->address,
            'photo' => $photoPath,
        ]);

        return redirect()->route('admin.asesors.index')->with('success', 'Akun pengguna berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified Asesor.
     */
    public function edit($id)
    {
        $asesor = User::findOrFail($id);
        return view('admin.asesors.edit', compact('asesor'));
    }

    /**
     * Update the specified Asesor in storage.
     */
    public function update(Request $request, $id)
    {
        $asesor = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($asesor->id)],
            'password' => ['nullable', 'string', 'min:6'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // max 2MB
        ], [
            'name.required' => 'Nama pengguna wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar di sistem.',
            'password.min' => 'Kata sandi minimal berisi 6 karakter.',
            'photo.image' => 'Foto profil harus berupa file gambar.',
            'photo.max' => 'Ukuran foto profil maksimal adalah 2MB.',
        ]);

        $photoPath = $asesor->photo;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = 'profile_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $photoPath = $file->storeAs('profiles', $filename, 'public');

            // Delete old file if exists
            if ($asesor->photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($asesor->photo);
            }
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'photo' => $photoPath,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $asesor->update($data);

        return redirect()->route('admin.asesors.index')->with('success', 'Akun pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified Asesor from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        if ($user->role === 'admin') {
            return back()->with('error', 'Akun Administrator tidak dapat dihapus melalui menu ini.');
        }

        $user->delete();

        return redirect()->route('admin.asesors.index')->with('success', 'Akun Asesor berhasil dihapus.');
    }
}
