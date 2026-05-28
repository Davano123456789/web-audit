@extends('layouts.master')

@section('title', 'Web Audit - Tugas Audit Anda')

@section('content')
<!-- Header Section -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0 pb-4 border-b border-slate-100 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Tugas Audit Anda</h1>
        <p class="text-xs text-slate-500 mt-1">Daftar proyek penilaian kapabilitas COBIT 2019 yang ditugaskan kepada Anda.</p>
    </div>
</div>

<!-- Project List -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @forelse($projects as $project)
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-2xs hover:shadow-xs transition-shadow flex flex-col justify-between space-y-6">
            <div class="space-y-3">
                <!-- Status Badge and Date -->
                <div class="flex justify-between items-center">
                    <span class="text-[10px] text-slate-400 font-semibold">{{ $project->created_at->format('d M Y') }}</span>
                    @if($project->status === 'completed')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-emerald-50 border border-emerald-100 text-emerald-600 text-[9px] font-bold">Selesai</span>
                    @elseif($project->status === 'in_progress')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-600 text-[9px] font-bold">Berjalan</span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-slate-100 border border-slate-200 text-slate-600 text-[9px] font-bold">Draft</span>
                    @endif
                </div>

                <!-- Project Info -->
                <div class="space-y-1">
                    <h2 class="text-base font-bold text-slate-800 leading-snug">{{ $project->name }}</h2>
                    <p class="text-xs text-slate-500 leading-relaxed">{{ Str::limit($project->description, 120) ?: 'Tidak ada deskripsi.' }}</p>
                </div>
            </div>

            <!-- Project Metrics and Action -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-6">
                    <div class="flex flex-col">
                        <span class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">Proses</span>
                        <span class="text-sm font-extrabold text-slate-700 mt-0.5">{{ $project->project_processes_count }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">Kematangan</span>
                        <span class="text-sm font-extrabold text-indigo-600 mt-0.5">{{ $project->maturity_index ? number_format($project->maturity_index, 2) : '-' }}</span>
                    </div>
                </div>
                
                <a href="{{ route('asesor.projects.show', $project->id) }}" class="inline-flex items-center space-x-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-2xs hover:scale-[1.02] active:scale-[0.98] transition-all">
                    <span>Buka Proyek</span>
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    @empty
        <div class="col-span-full bg-white border border-slate-100 rounded-2xl p-12 text-center shadow-2xs">
            <svg class="w-12 h-12 text-slate-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <h3 class="text-sm font-bold text-slate-700 mb-1">Belum Ada Tugas Ditugaskan</h3>
            <p class="text-xs text-slate-400">Hubungi Administrator untuk mendelegasikan proyek audit COBIT kepada akun Anda.</p>
        </div>
    @endforelse
</div>
@endsection
