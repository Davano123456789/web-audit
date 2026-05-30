<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditProject;
use App\Models\AuditProjectProcess;
use App\Models\CobitProcess;
use App\Models\User;
use Illuminate\Http\Request;

class AuditProjectController extends Controller
{
    /**
     * Display a listing of the audit projects.
     */
    public function index()
    {
        $query = AuditProject::with('asesor');
        
        if (auth()->user()->role !== 'admin') {
            $query->where('asesor_id', auth()->id());
        }

        $projects = $query->latest()->get();
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new audit project.
     */
    public function create()
    {
        $asesors = User::all();
        $processes = CobitProcess::with('domain')->get();
        return view('admin.projects.create', compact('asesors', 'processes'));
    }

    /**
     * Store a newly created audit project in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'asesor_id' => ['required', 'exists:users,id'],
            'processes' => ['required', 'array', 'min:1'],
            'processes.*' => ['exists:cobit_processes,code'],
        ], [
            'name.required' => 'Nama proyek audit wajib diisi.',
            'asesor_id.required' => 'Wajib memilih Asesor pelaksana.',
            'asesor_id.exists' => 'Asesor terpilih tidak valid.',
            'processes.required' => 'Wajib memilih minimal 1 proses COBIT untuk diaudit.',
            'processes.min' => 'Wajib memilih minimal 1 proses COBIT untuk diaudit.',
        ]);

        // Create the main project
        $project = AuditProject::create([
            'name' => $request->name,
            'description' => $request->description,
            'asesor_id' => $request->asesor_id,
            'status' => 'draft',
        ]);

        // Connect the selected COBIT processes to this project
        foreach ($request->processes as $processCode) {
            AuditProjectProcess::create([
                'project_id' => $project->id,
                'process_code' => $processCode,
                'target_level' => 3, // default target is Level 3
                'status' => 'not_started',
            ]);
        }

        return redirect()->route('admin.projects.index')->with('success', 'Proyek Audit berhasil didelegasikan.');
    }

    /**
     * Display the specified audit project.
     */
    public function show($id)
    {
        $project = AuditProject::with([
            'asesor', 
            'projectProcesses.cobitProcess.domain',
            'projectProcesses.cobitProcess.practices.questions',
            'responses.question'
        ])->findOrFail($id);

        if (auth()->user()->role !== 'admin' && $project->asesor_id !== auth()->id()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk melihat rincian proyek ini.');
        }

        return view('admin.projects.show', compact('project'));
    }

    /**
     * Print the specified audit project report.
     */
    public function printProject($id)
    {
        $project = AuditProject::with([
            'asesor', 
            'projectProcesses.cobitProcess.domain',
            'projectProcesses.cobitProcess.practices.questions',
            'responses.question'
        ])->findOrFail($id);

        if (auth()->user()->role !== 'admin' && $project->asesor_id !== auth()->id()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mencetak proyek ini.');
        }

        return view('admin.projects.print', compact('project'));
    }

    /**
     * Show the form for editing the specified audit project.
     */
    public function edit($id)
    {
        $project = AuditProject::with('projectProcesses')->findOrFail($id);

        if (auth()->user()->role === 'admin') {
            abort(403, 'Akses ditolak. Administrator tidak diperbolehkan mengubah proyek yang telah didelegasikan.');
        }

        if ($project->asesor_id !== auth()->id()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengubah proyek ini.');
        }

        $asesors = User::all();
        $processes = CobitProcess::with('domain')->get();

        // Get currently active processes in this project as an array
        $activeProcesses = $project->projectProcesses->pluck('process_code')->toArray();

        return view('admin.projects.edit', compact('project', 'asesors', 'processes', 'activeProcesses'));
    }

    /**
     * Update the specified audit project in storage.
     */
    public function update(Request $request, $id)
    {
        $project = AuditProject::findOrFail($id);

        if (auth()->user()->role === 'admin') {
            abort(403, 'Akses ditolak. Administrator tidak diperbolehkan mengubah proyek yang telah didelegasikan.');
        }

        if ($project->asesor_id !== auth()->id()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk memperbarui proyek ini.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'asesor_id' => ['required', 'exists:users,id'],
            'status' => ['required', 'in:draft,in_progress,completed'],
            'processes' => ['required', 'array', 'min:1'],
            'processes.*' => ['exists:cobit_processes,code'],
        ], [
            'name.required' => 'Nama proyek audit wajib diisi.',
            'asesor_id.required' => 'Wajib memilih Asesor pelaksana.',
            'processes.required' => 'Wajib memilih minimal 1 proses COBIT.',
        ]);

        $asesorId = auth()->user()->role === 'admin' ? $request->asesor_id : auth()->id();

        $project->update([
            'name' => $request->name,
            'description' => $request->description,
            'asesor_id' => $asesorId,
            'status' => $request->status,
        ]);

        // Sync processes: Delete ones that are no longer checked
        AuditProjectProcess::where('project_id', $project->id)
            ->whereNotIn('process_code', $request->processes)
            ->delete();

        // Add newly checked ones
        foreach ($request->processes as $processCode) {
            AuditProjectProcess::firstOrCreate([
                'project_id' => $project->id,
                'process_code' => $processCode,
            ], [
                'target_level' => 3,
                'status' => 'not_started',
            ]);
        }

        return redirect()->route('admin.projects.index')->with('success', 'Proyek Audit berhasil diperbarui.');
    }

    /**
     * Remove the specified audit project from storage.
     */
    public function destroy($id)
    {
        $project = AuditProject::findOrFail($id);

        if (auth()->user()->role !== 'admin' && $project->asesor_id !== auth()->id()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menghapus proyek ini.');
        }

        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Proyek Audit berhasil dihapus.');
    }
}
