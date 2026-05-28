<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CobitDomain;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    /**
     * Display a listing of the domains.
     */
    public function index()
    {
        $domains = CobitDomain::all();
        return view('admin.domains.index', compact('domains'));
    }

    /**
     * Show the form for creating a new domain.
     */
    public function create()
    {
        return view('admin.domains.create');
    }

    /**
     * Store a newly created domain in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => ['required', 'string', 'unique:cobit_domains,id', 'max:50'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ], [
            'id.required' => 'ID domain wajib diisi.',
            'id.unique' => 'ID domain sudah terdaftar.',
            'name.required' => 'Nama domain wajib diisi.',
        ]);

        CobitDomain::create([
            'id' => strtoupper($request->id),
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.domains.index')->with('success', 'Domain COBIT baru berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified domain.
     */
    public function edit($id)
    {
        $domain = CobitDomain::findOrFail($id);
        return view('admin.domains.edit', compact('domain'));
    }

    /**
     * Update the specified domain in storage.
     */
    public function update(Request $request, $id)
    {
        $domain = CobitDomain::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ], [
            'name.required' => 'Nama domain wajib diisi.',
        ]);

        $domain->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.domains.index')->with('success', 'Domain COBIT berhasil diperbarui.');
    }

    /**
     * Remove the specified domain from storage.
     */
    public function destroy($id)
    {
        $domain = CobitDomain::findOrFail($id);
        
        // Cascade manually
        foreach ($domain->processes as $process) {
            foreach ($process->practices as $practice) {
                $practice->questions()->delete();
                $practice->delete();
            }
            $process->delete();
        }
        
        $domain->delete();

        return redirect()->route('admin.domains.index')->with('success', 'Domain COBIT berhasil dihapus.');
    }
}
