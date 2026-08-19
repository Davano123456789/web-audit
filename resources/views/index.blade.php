@extends('layouts.master')

@section('title', 'Web Audit - Dasbor Utama')

@section('content')
<!-- Header Section -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0 pb-4 border-b border-slate-100 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Selamat Datang Kembali, {{ auth()->user()->name }}!</h1>
        <p class="text-xs text-slate-500 mt-1">Sistem informasi audit teknologi informasi berbasis standar COBIT 2019.</p>
    </div>
    
    @if(auth()->user()->role === 'admin')
        <div>
            <!-- Primary Action Button for admin -->
            <a href="{{ route('admin.projects.create') }}" class="flex items-center space-x-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-2xs hover:scale-[1.01] transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                <span>Buat Proyek Audit</span>
            </a>
        </div>
    @else
        <div>
            <!-- Primary Action Button for asesor -->
            <a href="{{ route('admin.projects.index') }}" class="flex items-center space-x-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-2xs hover:scale-[1.01] transition-all">
                <span>Lihat Proyek</span>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    @endif
</div>

@if(auth()->user()->role === 'admin')
    <!-- ==================== ADMIN DASHBOARD ==================== -->
    
    <!-- Metric Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        <!-- Card 1: Total Projects -->
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-2xs group">
            <div class="flex justify-between items-start">
                <div class="space-y-2">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Proyek Audit</p>
                    <h3 class="text-3xl font-extrabold text-slate-800 tracking-tight group-hover:text-indigo-600 transition-colors">{{ $totalProjects }}</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 shrink-0">
                    <svg class="w-5.5 h-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
            <div class="text-[10px] text-slate-400 font-medium mt-4">
                Jumlah keseluruhan asesmen terdaftar
            </div>
        </div>

        <!-- Card 2: Total Asesors -->
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-2xs group">
            <div class="flex justify-between items-start">
                <div class="space-y-2">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Asesor Terdaftar</p>
                    <h3 class="text-3xl font-extrabold text-slate-800 tracking-tight group-hover:text-indigo-600 transition-colors">{{ $totalAsesors }}</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 shrink-0">
                    <svg class="w-5.5 h-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-[10px] text-slate-400 font-medium mt-4">
                Asesor lapangan pengisi kuesioner
            </div>
        </div>

        <!-- Card 3: Total Questions -->
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-2xs group">
            <div class="flex justify-between items-start">
                <div class="space-y-2">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Bank Pertanyaan</p>
                    <h3 class="text-3xl font-extrabold text-slate-800 tracking-tight group-hover:text-indigo-600 transition-colors">{{ $totalQuestions }}</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 shrink-0">
                    <svg class="w-5.5 h-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-[10px] text-slate-400 font-medium mt-4">
                Butir kuesioner terpetakan ke level 2-5
            </div>
        </div>
    </div>

    <!-- Recent Audits Table Section -->
    <div class="bg-white border border-slate-100 rounded-2xl shadow-2xs overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-sm font-bold text-slate-800">Riwayat Proyek Audit Terbaru</h2>
                <p class="text-[10px] text-slate-400 mt-0.5">Daftar proyek penilaian kapabilitas terdaftar terbaru</p>
            </div>
            <a href="{{ route('admin.projects.index') }}" class="text-[10px] font-bold text-indigo-600 hover:underline">Lihat Semua Proyek &rarr;</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-400 text-[10px] font-bold uppercase tracking-wider select-none">
                        <th class="py-4 px-6">Nama Proyek</th>
                        <th class="py-4 px-6">Tanggal Pembuatan</th>
                        <th class="py-4 px-6">Asesor Ditugaskan</th>
                        <th class="py-4 px-6 text-center">Status</th>
                        <th class="py-4 px-6 text-center">Indeks Kematangan</th>
                        <th class="py-4 px-6 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                    @forelse($recentProjects as $project)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex flex-col">
                                    <span class="font-semibold text-slate-800">{{ $project->name }}</span>
                                    <span class="text-[9px] text-slate-400 mt-0.5">{{ Str::limit($project->description, 50) }}</span>
                                </div>
                            </td>
                            <!-- Tanggal Pembuatan -->
                            <td class="py-4 px-6 text-slate-600">
                                {{ $project->created_at->format('d/m/Y') }}
                            </td>
                            
                            <td class="py-4 px-6 font-semibold text-slate-700">
                                {{ $project->asesor->name }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if($project->status === 'completed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-emerald-50 border border-emerald-100 text-emerald-600 text-[9px] font-bold">Selesai</span>
                                @elseif($project->status === 'in_progress')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-600 text-[9px] font-bold">Berjalan</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-slate-100 border border-slate-200 text-slate-600 text-[9px] font-bold">Draft</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center font-bold text-slate-700">
                                {{ $project->maturity_index ? number_format($project->maturity_index, 2) : '-' }}
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('admin.projects.show', $project->id) }}" class="px-2.5 py-1.5 bg-slate-50 text-slate-700 font-semibold rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors text-[10px]" title="Detail Laporan">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 px-6 text-center text-slate-400 font-medium">Belum ada proyek audit yang dibuat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@else
    <!-- ==================== ASESOR DASHBOARD ==================== -->

    <!-- Metric Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        <!-- Card 1: Assigned Projects -->
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-2xs group">
            <div class="flex justify-between items-start">
                <div class="space-y-2">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Proyek Ditugaskan</p>
                    <h3 class="text-3xl font-extrabold text-slate-800 tracking-tight group-hover:text-indigo-600 transition-colors">{{ $myProjectsCount }}</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 shrink-0">
                    <svg class="w-5.5 h-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
            <div class="text-[10px] text-slate-400 font-medium mt-4">
                Total proyek audit aktif didelegasikan ke Anda
            </div>
        </div>

        <!-- Card 2: Completed Projects -->
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-2xs group">
            <div class="flex justify-between items-start">
                <div class="space-y-2">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Audit Selesai</p>
                    <h3 class="text-3xl font-extrabold text-emerald-600 tracking-tight">{{ $myCompletedCount }}</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 shrink-0">
                    <svg class="w-5.5 h-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
            <div class="text-[10px] text-slate-400 font-medium mt-4">
                Tugas proyek yang selesai dievaluasi penuh
            </div>
        </div>

        <!-- Card 3: Pending Audits -->
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-2xs group">
            <div class="flex justify-between items-start">
                <div class="space-y-2">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Audit Berjalan (Pending)</p>
                    <h3 class="text-3xl font-extrabold text-amber-600 tracking-tight">{{ $myProjectsCount - $myCompletedCount }}</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 shrink-0">
                    <svg class="w-5.5 h-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-[10px] text-slate-400 font-medium mt-4">
                Proyek yang memerlukan aksi pengisian asesmen
            </div>
        </div>
    </div>

    <!-- Active Tasks Projects list -->
    <div class="bg-white border border-slate-100 rounded-2xl shadow-2xs overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-sm font-bold text-slate-800">Daftar Proyek Aktif Anda</h2>
                <p class="text-[10px] text-slate-400 mt-0.5">Penugasan audit aktif terdaftar terbaru</p>
            </div>
            <a href="{{ route('admin.projects.index') }}" class="text-[10px] font-bold text-indigo-600 hover:underline">Lihat Semua Tugas &rarr;</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-400 text-[10px] font-bold uppercase tracking-wider select-none">
                        <th class="py-4 px-6">Nama Proyek</th>
                        <th class="py-4 px-6">Tanggal Pembuatan</th>
                        <th class="py-4 px-6 text-center">Jumlah Proses</th>
                        <th class="py-4 px-6 text-center">Status</th>
                        <th class="py-4 px-6 text-center">Maturity Index</th>
                        <th class="py-4 px-6 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                    @forelse($myActiveProjects as $project)
                        <tr class="hover:bg-slate-55/40 transition-colors">
                            <td class="py-4 px-6 font-semibold text-slate-800">
                                <div class="flex flex-col">
                                    <span>{{ $project->name }}</span>
                                    <span class="text-[9px] text-slate-400 font-normal mt-0.5">{{ Str::limit($project->description, 50) }}</span>
                                </div>
                            </td>
                            <!-- Tanggal Pembuatan -->
                            <td class="py-4 px-6 text-slate-600">
                                {{ $project->created_at->format('d/m/Y') }}
                            </td>
                            
                            <td class="py-4 px-6 text-center font-bold text-slate-700">
                                {{ $project->project_processes_count }} proses
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if($project->status === 'completed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-emerald-50 border border-emerald-100 text-emerald-600 text-[9px] font-bold">Selesai</span>
                                @elseif($project->status === 'in_progress')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-600 text-[9px] font-bold">Berjalan</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-slate-100 border border-slate-200 text-slate-600 text-[9px] font-bold">Draft</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center font-extrabold text-slate-700">
                                {{ $project->maturity_index ? number_format($project->maturity_index, 2) : '-' }}
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('admin.projects.show', $project->id) }}" class="px-2.5 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-colors text-[10px]" title="Buka Proyek">Mulai / Lanjutkan</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 px-6 text-center text-slate-400 font-medium">Belum ada tugas proyek audit yang ditugaskan kepada Anda.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endif
@endsection
