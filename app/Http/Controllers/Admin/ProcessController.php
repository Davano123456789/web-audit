<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CobitProcess;
use App\Models\CobitDomain;
use Illuminate\Http\Request;

class ProcessController extends Controller
{
    /**
     * Display a listing of the processes.
     */
    public function index()
    {
        $processes = CobitProcess::with('domain')->get();
        return view('admin.processes.index', compact('processes'));
    }

    /**
     * Show the form for creating a new process.
     */
    public function create()
    {
        $domains = CobitDomain::all();
        return view('admin.processes.create', compact('domains'));
    }

    /**
     * Store a newly created process in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'unique:cobit_processes,code', 'max:50'],
            'domain_id' => ['required', 'exists:cobit_domains,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ], [
            'code.required' => 'Kode proses wajib diisi.',
            'code.unique' => 'Kode proses sudah terdaftar.',
            'domain_id.required' => 'Wajib memilih domain COBIT.',
            'domain_id.exists' => 'Domain tidak valid.',
            'name.required' => 'Nama proses wajib diisi.',
        ]);

        $processData = [
            'code' => strtoupper($request->code),
            'domain_id' => $request->domain_id,
            'name' => $request->name,
        ];

        if ($request->has('description')) {
            $processData['description'] = $request->description;
        }

        CobitProcess::create($processData);

        return redirect()->route('admin.processes.index')->with('success', 'Proses Assessment baru berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified process.
     */
    public function edit($code)
    {
        $process = CobitProcess::findOrFail($code);
        $domains = CobitDomain::all();
        return view('admin.processes.edit', compact('process', 'domains'));
    }

    /**
     * Update the specified process in storage.
     */
    public function update(Request $request, $code)
    {
        $process = CobitProcess::findOrFail($code);

        $request->validate([
            'domain_id' => ['required', 'exists:cobit_domains,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ], [
            'domain_id.required' => 'Wajib memilih domain COBIT.',
            'domain_id.exists' => 'Domain tidak valid.',
            'name.required' => 'Nama proses wajib diisi.',
        ]);

        $updateData = [
            'domain_id' => $request->domain_id,
            'name' => $request->name,
        ];

        if ($request->has('description')) {
            $updateData['description'] = $request->description;
        }

        $process->update($updateData);

        return redirect()->route('admin.processes.index')->with('success', 'Proses Assessment berhasil diperbarui.');
    }

    /**
     * Remove the specified process from storage.
     */
    public function destroy($code)
    {
        $process = CobitProcess::findOrFail($code);
        
        // Relational practices will cascade if database is set or we delete manually
        foreach ($process->practices as $practice) {
            $practice->questions()->delete();
            $practice->delete();
        }
        
        $process->delete();

        return redirect()->route('admin.processes.index')->with('success', 'Proses Assessment berhasil dihapus.');
    }
}
