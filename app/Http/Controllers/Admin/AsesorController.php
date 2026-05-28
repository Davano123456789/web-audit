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
        $asesors = User::where('role', 'asesor')->latest()->get();
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
        ], [
            'name.required' => 'Nama asesor wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar di sistem.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal berisi 6 karakter.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'asesor',
        ]);

        return redirect()->route('admin.asesors.index')->with('success', 'Akun Asesor berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified Asesor.
     */
    public function edit($id)
    {
        $asesor = User::where('role', 'asesor')->findOrFail($id);
        return view('admin.asesors.edit', compact('asesor'));
    }

    /**
     * Update the specified Asesor in storage.
     */
    public function update(Request $request, $id)
    {
        $asesor = User::where('role', 'asesor')->findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($asesor->id)],
            'password' => ['nullable', 'string', 'min:6'],
        ], [
            'name.required' => 'Nama asesor wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar di sistem.',
            'password.min' => 'Kata sandi minimal berisi 6 karakter.',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $asesor->update($data);

        return redirect()->route('admin.asesors.index')->with('success', 'Akun Asesor berhasil diperbarui.');
    }

    /**
     * Remove the specified Asesor from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->role !== 'asesor') {
            return back()->with('error', 'Tindakan tidak sah.');
        }

        $user->delete();

        return redirect()->route('admin.asesors.index')->with('success', 'Akun Asesor berhasil dihapus.');
    }
}
