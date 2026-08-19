@extends('layouts.master')

@section('title', 'Web Audit - Rincian Proyek')

@section('content')
<!-- Header Section -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0 pb-4 border-b border-slate-100 mb-6">
    <div class="flex items-center space-x-3">
        <a href="{{ route('admin.projects.index') }}" class="p-1.5 bg-white border border-slate-200 rounded-lg text-slate-400 hover:text-slate-600 transition-colors shadow-3xs" title="Kembali ke Daftar">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <div>
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Rincian Proyek Audit</h1>
            <p class="text-[10px] text-slate-500">Hasil rekapitulasi penilaian kapabilitas COBIT 2019 pada proyek ini.</p>
        </div>
    </div>
    <div class="flex items-center space-x-2.5">
        <span class="text-xs font-bold px-3 py-1.5 rounded-xl border border-slate-200 bg-white text-slate-600 shadow-3xs">
            Status: 
            @if($project->status === 'completed')
                <span class="text-emerald-600">Selesai</span>
            @elseif($project->status === 'in_progress')
                <span class="text-indigo-600">Berjalan</span>
            @else
                <span class="text-slate-500">Draft</span>
            @endif
        </span>
        <a href="{{ route('admin.projects.print', $project->id) }}" target="_blank" class="px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl text-xs transition-all flex items-center space-x-1.5 shadow-3xs hover:scale-[1.01]">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            <span>Cetak Lembar Kerja</span>
        </a>
        @if(auth()->user()->role !== 'admin')
        <a href="{{ route('admin.projects.edit', $project->id) }}" class="px-3.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-xs transition-colors">Ubah Proyek</a>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
    
    <!-- Left Column: Project Summary & Maturity Index (1/3 width) -->
    <div class="space-y-6">
        <!-- Summary Card -->
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-2xs space-y-4">
            <h2 class="text-sm font-bold text-slate-800 border-b border-slate-100 pb-3">Informasi Proyek</h2>
            <div class="space-y-3.5 text-xs">
                <div>
                    <span class="text-slate-400 block mb-0.5">Nama Proyek:</span>
                    <strong class="text-slate-800 font-semibold text-sm leading-snug">{{ $project->name }}</strong>
                </div>
                <div>
                    <span class="text-slate-400 block mb-0.5">Deskripsi:</span>
                    <p class="text-slate-600 leading-relaxed">{{ $project->description ?: 'Tidak ada deskripsi.' }}</p>
                </div>
                <div>
                    <span class="text-slate-400 block mb-0.5">Asesor Pelaksana:</span>
                    <div class="flex items-center space-x-2 mt-1">
                        <div class="w-6 h-6 rounded-full bg-indigo-600/10 text-indigo-600 flex items-center justify-center font-bold text-[10px]">
                            {{ strtoupper(substr($project->asesor->name, 0, 2)) }}
                        </div>
                        <strong class="text-slate-700 font-semibold">{{ $project->asesor->name }}</strong>
                    </div>
                </div>
                <div>
                    <span class="text-slate-400 block mb-0.5">Mulai Audit:</span>
                    <span class="text-slate-600 font-medium">{{ $project->created_at->format('d F Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Maturity Index Score Card -->
        <div class="bg-gradient-to-br from-slate-900 to-slate-950 border border-slate-800 rounded-2xl p-6 shadow-md text-white space-y-4">
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500">Nilai Indeks Kematangan</h2>
            <div class="flex items-baseline space-x-2">
                <span class="text-5xl font-black tracking-tight text-white">{{ $project->maturity_index ? number_format($project->maturity_index, 2) : '-' }}</span>
                <span class="text-xs text-slate-500 font-semibold">dari skala 5.00</span>
            </div>
            
            <div class="p-3 bg-slate-800/40 border border-slate-800 rounded-xl space-y-2.5">
                <div>
                    <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Kesimpulan Level:</h4>
                    <p class="text-xs font-medium text-indigo-300 leading-normal">
                        @if($project->maturity_index)
                            @if($project->maturity_index >= 4.51) Level 5 (Optimized)
                            @elseif($project->maturity_index >= 3.51) Level 4 (Managed)
                            @elseif($project->maturity_index >= 2.51) Level 3 (Defined)
                            @elseif($project->maturity_index >= 1.51) Level 2 (Repeatable)
                            @elseif($project->maturity_index >= 0.51) Level 1 (Initial)
                            @else Level 0 (Non-existent)
                            @endif
                        @else
                            Belum ada perhitungan skor final.
                        @endif
                    </p>
                </div>

                @if($project->maturity_index)
                    <div class="pt-2 border-t border-slate-800/60">
                        <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Keterangan:</h4>
                        <p class="text-[11px] text-slate-350 leading-relaxed font-normal">
                            @if($project->maturity_index >= 4.51)
                                Proses sudah berjalan secara optimal serta berfokus pada peningkatan yang berkelanjutan untuk meningkatkan kinerja proses.
                            @elseif($project->maturity_index >= 3.51)
                                Proses dikelola berdasarkan data dan pengukuran kinerja secara kuantitatif guna untuk meningkatkan efektifitas proses pada suatu organisasi.
                            @elseif($project->maturity_index >= 2.51)
                                Proses sudah memiliki standar dan pedoman yang jelas sehingga dapat diterapkan secara konsisten di seluruh organisasi.
                            @elseif($project->maturity_index >= 1.51)
                                Proses sudah direncanakan serta telah dilakukan pengukuran kinerja, namun belum memiliki standar yang baku pada seluruh organisasi.
                            @elseif($project->maturity_index >= 0.51)
                                Proses sudah dilakukan namun sebagian masih sederhana belum mampu mencapai tujuan Tata Kelola secara optimal.
                            @else
                                Proses belum berjalan dan dilaksanakan sepenuhnya dengan baik, sehingga tujuan Tata Kelola serta manajemen dalam area tersebut belum tercapai.
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Right Column: COBIT Processes Scope & Capability Score Card (2/3 width) -->
    <div class="bg-white border border-slate-100 rounded-2xl shadow-2xs overflow-hidden lg:col-span-2 space-y-6">
        <div class="px-6 py-5 border-b border-slate-100">
            <h2 class="text-sm font-bold text-slate-800">Ruang Lingkup Proses COBIT 2019</h2>
            <p class="text-[10px] text-slate-400 mt-0.5">Daftar proses tata kelola/manajemen TI yang diaktifkan dalam asesmen ini.</p>
        </div>

        <div class="p-6 space-y-6 divide-y divide-slate-100">
            @forelse($project->projectProcesses as $projectProcess)
                <div class="pt-6 first:pt-0 space-y-4">
                    <!-- Process Title & Status -->
                    <div class="flex items-start justify-between">
                        <div class="space-y-1">
                            <div class="flex items-center space-x-2">
                                <span class="text-xs font-bold px-2 py-0.5 bg-indigo-50 border border-indigo-100/60 rounded text-indigo-600">{{ $projectProcess->process_code }}</span>
                                <h3 class="text-sm font-bold text-slate-800 leading-normal">{{ $projectProcess->cobitProcess->name }}</h3>
                            </div>
                            <span class="text-[10px] text-slate-400 block">Domain: {{ $projectProcess->cobitProcess->domain->name }}</span>
                        </div>
                        <div>
                            @if($projectProcess->status === 'completed')
                                <span class="inline-flex items-center px-2 py-0.5 rounded bg-emerald-50 text-emerald-600 text-[9px] font-bold">Selesai Dinilai</span>
                            @elseif($projectProcess->status === 'in_progress')
                                <span class="inline-flex items-center px-2 py-0.5 rounded bg-indigo-50 text-indigo-600 text-[9px] font-bold">Sedang Diisi</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded bg-slate-100 text-slate-600 text-[9px] font-bold">Belum Mulai</span>
                            @endif
                        </div>
                    </div>

                    <!-- Capability Level Score Bar & Action -->
                    <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="space-y-1.5 flex-1 w-full">
                            <div class="flex justify-between items-center text-[10px] font-bold text-slate-500">
                                <span>Hasil Kapabilitas Proses</span>
                                <span class="text-indigo-600">Level {{ $projectProcess->computed_capability_level ?: '0' }} / Target Level {{ $projectProcess->target_level }}</span>
                            </div>
                            <!-- Simple custom progress bar -->
                            <div class="w-full h-2.5 bg-slate-200/60 rounded-full overflow-hidden">
                                @php
                                    $score = $projectProcess->computed_capability_level ?: 0;
                                    $percent = ($score / 5) * 100;
                                @endphp
                                <div class="h-full bg-indigo-600 rounded-full" style="width: {{ $percent }}%"></div>
                            </div>
                        </div>

                        <!-- Action buttons based on status -->
                        <div class="flex items-center space-x-2.5 w-full sm:w-auto shrink-0 justify-end">
                            <div class="w-10 h-10 bg-white border border-slate-100 rounded-xl shadow-3xs flex flex-col items-center justify-center shrink-0">
                                <span class="text-[7px] font-bold text-slate-400 uppercase tracking-widest leading-none">Level</span>
                                <span class="text-base font-black text-indigo-600 leading-none mt-0.5">{{ $projectProcess->computed_capability_level ?: '0' }}</span>
                            </div>
                            
                            @if($projectProcess->status !== 'not_started')
                                <button type="button" onclick="openDetailModal('{{ $projectProcess->process_code }}')" class="inline-flex items-center justify-center px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs shadow-3xs transition-all hover:scale-[1.01] active:scale-[0.99]">
                                    Detail
                                </button>
                            @endif

                            @if(auth()->user()->role !== 'admin' || (int) $project->asesor_id === (int) auth()->id())
                            <a href="{{ route('asesor.projects.workspace', [$project->id, $projectProcess->process_code]) }}" class="inline-flex items-center justify-center px-4 py-2 text-xs font-bold rounded-xl shadow-2xs hover:scale-[1.01] active:scale-[0.99] transition-all min-w-[120px] {{ $projectProcess->status === 'completed' ? 'bg-slate-150 hover:bg-slate-200 text-slate-700 border border-slate-200' : 'bg-sky-500 hover:bg-sky-600 text-white' }}">
                                @if($projectProcess->status === 'completed')
                                    Ulangi Penilaian
                                @elseif($projectProcess->status === 'in_progress')
                                    Lanjutkan Audit
                                @else
                                    Mulai Asesmen
                                @endif
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-8 text-center text-slate-400 font-medium text-xs">Belum ada proses COBIT yang diaktifkan untuk proyek ini.</div>
            @endforelse
        </div>
    </div>

</div>


<!-- Perhitungan Maturity Level Section (Full Width) -->
@php
    $levelNames = [
        0 => 'Non-Existent',
        1 => 'Initial / Ad Hoc',
        2 => 'Repeatable but Intuitive',
        3 => 'Defined Process',
        4 => 'Managed and Measurable',
        5 => 'Optimized',
    ];
    $completedProcesses = $project->projectProcesses->where('status', 'completed');
    $totalLevel = $completedProcesses->sum('computed_capability_level');
    $totalProcesses = $completedProcesses->count();
    $processLevelsStr = $completedProcesses->isNotEmpty() ? $completedProcesses->pluck('computed_capability_level')->implode(' + ') : '0';
@endphp

<div class="mt-8 space-y-6">
    <div class="border-b border-slate-100 pb-3 select-none">
        <h2 class="text-sm font-bold text-slate-800">Detail Analisis & Perhitungan Indeks Kematangan (Maturity Level)</h2>
        <p class="text-[10px] text-slate-400 mt-0.5">Penjelasan transparan mengenai pencapaian skor kematangan berdasarkan panduan standardisasi COBIT 2019.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
        <!-- Card 1: Hasil Pencapaian Level & Rumus -->
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-2xs space-y-4">
            <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider select-none">1. Hasil Pencapaian Level Proses TI</h3>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border border-slate-100 rounded-xl overflow-hidden text-xs">
                    <thead>
                        <tr class="bg-slate-900 text-white text-[10px] font-bold uppercase tracking-wider select-none">
                            <th class="py-2.5 px-4 w-12 text-center">No.</th>
                            <th class="py-2.5 px-4 w-28">Proses TI</th>
                            <th class="py-2.5 px-4">Detail Proses TI</th>
                            <th class="py-2.5 px-4 w-16 text-center">Level</th>
                            <th class="py-2.5 px-4">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-600">
                        @forelse($completedProcesses as $index => $projectProcess)
                            <tr class="hover:bg-slate-50/50">
                                <td class="py-3 px-4 text-center font-medium">{{ $index + 1 }}</td>
                                <td class="py-3 px-4 font-bold text-slate-800 select-all">{{ $projectProcess->process_code }}</td>
                                <td class="py-3 px-4 italic text-slate-500">{{ $projectProcess->cobitProcess->name }}</td>
                                <td class="py-3 px-4 text-center font-bold text-indigo-600 bg-indigo-50/20">{{ $projectProcess->computed_capability_level }}</td>
                                <td class="py-3 px-4 font-medium text-[11px] text-slate-700">
                                    {{ $levelNames[$projectProcess->computed_capability_level] ?? 'Non-Existent' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-slate-400 italic select-none">Belum ada proses yang selesai dinilai. Silakan selesaikan minimal 1 penilaian proses.</td>
                            </tr>
                        @endforelse
                        
                        @if($completedProcesses->isNotEmpty())
                            <tr class="bg-slate-50 font-bold border-t border-slate-200 select-none">
                                <td colspan="3" class="py-3 px-4 text-right pr-6 uppercase tracking-wider text-[10px] text-slate-500">Maturity Level (Rata-rata)</td>
                                <td class="py-3 px-4 text-center text-indigo-700 text-sm font-black bg-indigo-50/30">
                                    {{ number_format($project->maturity_index, 2) }}
                                </td>
                                <td class="py-3 px-4 text-indigo-700 text-[11px]">
                                    @php
                                        $roundedLevel = 0;
                                        if($project->maturity_index >= 4.51) $roundedLevel = 5;
                                        elseif($project->maturity_index >= 3.51) $roundedLevel = 4;
                                        elseif($project->maturity_index >= 2.51) $roundedLevel = 3;
                                        elseif($project->maturity_index >= 1.51) $roundedLevel = 2;
                                        elseif($project->maturity_index >= 0.51) $roundedLevel = 1;
                                    @endphp
                                    Level {{ $roundedLevel }} ({{ $levelNames[$roundedLevel] }})
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            @if($completedProcesses->isNotEmpty())
                <div class="pt-4 space-y-3 border-t border-slate-100">
                    <p class="text-[11px] text-slate-500 leading-relaxed select-none">
                        Penilaian <strong>Maturity Level</strong> COBIT 2019 sesuai dengan standarisasinya yakni jumlah level proses TI dibagi dengan jumlah proses TI yang digunakan / dikerjakan.
                    </p>
                    
                    <!-- Math Formula Display -->
                    <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4 flex flex-col items-center justify-center space-y-3.5 select-none">
                        <div class="flex items-center space-x-4 text-xs font-semibold text-slate-700">
                            <div class="flex flex-col items-center">
                                <span class="border-b border-slate-350 pb-1 px-3">Jumlah Level Proses TI</span>
                                <span class="pt-1">Jumlah Proses TI dikerjakan</span>
                            </div>
                            <span class="text-lg text-slate-450 font-normal">=</span>
                            <div class="flex flex-col items-center">
                                <span class="border-b border-slate-350 pb-1 px-3">{{ $processLevelsStr }}</span>
                                <span class="pt-1">{{ $totalProcesses }}</span>
                            </div>
                            <span class="text-lg text-slate-450 font-normal">=</span>
                            <div class="flex flex-col items-center">
                                <span class="border-b border-slate-350 pb-1 px-3">{{ $totalLevel }}</span>
                                <span class="pt-1">{{ $totalProcesses }}</span>
                            </div>
                            <span class="text-lg text-slate-450 font-normal">=</span>
                            <div class="flex flex-col items-center font-extrabold text-indigo-650 bg-white border border-indigo-100 px-3 py-1.5 rounded-lg text-sm shadow-3xs">
                                <span>{{ number_format($project->maturity_index, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Card 2: Skala Indeks Kematangan -->
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-2xs space-y-4 select-none">
            <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider">2. Skala Indeks Kematangan (Maturity Index Reference)</h3>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border border-slate-100 rounded-xl overflow-hidden text-xs">
                    <thead>
                        <tr class="bg-slate-900 text-white text-[10px] font-bold uppercase tracking-wider select-none">
                            <th class="py-2.5 px-4 w-40">Maturity Index</th>
                            <th class="py-2.5 px-4">Maturity Level</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-600 font-medium">
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-3 px-4 font-bold text-slate-800">0.00 - 0.50</td>
                            <td class="py-3 px-4 text-slate-700">0 - Non-Existent</td>
                        </tr>
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-3 px-4 font-bold text-slate-800">0.51 - 1.50</td>
                            <td class="py-3 px-4 text-slate-700">1 - Initial / ad hoc</td>
                        </tr>
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-3 px-4 font-bold text-slate-800">1.51 - 2.50</td>
                            <td class="py-3 px-4 text-slate-700">2 - Repeatable but Intuitive</td>
                        </tr>
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-3 px-4 font-bold text-slate-800">2.51 - 3.50</td>
                            <td class="py-3 px-4 text-slate-700">3 - Defined Process</td>
                        </tr>
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-3 px-4 font-bold text-slate-800">3.51 - 4.50</td>
                            <td class="py-3 px-4 text-slate-700">4 - Managed and Measurable</td>
                        </tr>
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-3 px-4 font-bold text-slate-800">4.51 - 5.00</td>
                            <td class="py-3 px-4 text-slate-700">5 - Optimized</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Detail Modals for Processes -->
@foreach($project->projectProcesses as $projectProcess)
    @if($projectProcess->status !== 'not_started')
        @php
            $processCode = $projectProcess->process_code;
            // Get responses for this specific process
            $processResponses = $project->responses->filter(function($r) use ($processCode) {
                return $r->question && explode('.', $r->question->practice_code)[0] === $processCode;
            })->sortBy(fn($r) => $r->question->level . '_' . $r->question->practice_code . '_' . $r->question->id);
        @endphp

        <div id="modal-{{ $processCode }}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title-{{ $processCode }}" role="dialog" aria-modal="true">
            <!-- Backdrop -->
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" aria-hidden="true" onclick="closeDetailModal('{{ $processCode }}')"></div>

                <!-- Element to trick browser into centering modal -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Modal Content -->
                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-5xl sm:w-full border border-slate-100">
                    <!-- Header -->
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                        <div class="flex items-center space-x-2.5">
                            <span class="text-xs font-bold px-2 py-0.5 bg-indigo-50 border border-indigo-100 rounded text-indigo-600">{{ $processCode }}</span>
                            <div>
                                <h3 class="text-sm font-bold text-slate-800" id="modal-title-{{ $processCode }}">Detail Hasil Jawaban & Bukti Dukung</h3>
                                <p class="text-[9px] text-slate-400 mt-0.5">{{ $projectProcess->cobitProcess->name }}</p>
                            </div>
                        </div>
                        <button type="button" onclick="closeDetailModal('{{ $processCode }}')" class="p-1 rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-650 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="p-6 max-h-[65vh] overflow-y-auto space-y-4">
                        @if($processResponses->isEmpty())
                            <p class="text-xs text-slate-400 italic text-center py-8">Belum ada data jawaban yang tersimpan untuk proses ini.</p>
                        @else
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border border-slate-100 rounded-xl overflow-hidden text-xs">
                                    <thead>
                                        <tr class="bg-slate-900 text-white text-[10px] font-bold uppercase tracking-wider select-none">
                                            <th class="py-2.5 px-4 w-12 text-center">No.</th>
                                            <th class="py-2.5 px-4 w-28">Praktik</th>
                                            <th class="py-2.5 px-4 w-20 text-center">Level</th>
                                            <th class="py-2.5 px-4">Kriteria Pertanyaan</th>
                                            <th class="py-2.5 px-4 w-32 text-center">Jawaban</th>
                                            <th class="py-2.5 px-4 w-44">Catatan Penjelasan</th>
                                            <th class="py-2.5 px-4 w-32 text-center">Dokumen</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 text-slate-655">
                                        @foreach($processResponses as $pResIndex => $response)
                                            <tr class="hover:bg-slate-50/50">
                                                <td class="py-3 px-4 text-center font-medium">{{ $pResIndex + 1 }}</td>
                                                <td class="py-3 px-4 font-bold text-slate-700 select-all">{{ $response->question->practice_code }}</td>
                                                <td class="py-3 px-4 text-center">
                                                    <span class="px-1.5 py-0.5 bg-slate-100 text-slate-600 rounded text-[10px] font-bold">Lvl {{ $response->question->level }}</span>
                                                </td>
                                                <td class="py-3 px-4 leading-relaxed">{{ $response->question->question_text }}</td>
                                                <td class="py-3 px-4 text-center">
                                                    @if($response->answer === 'F')
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded bg-emerald-50 border border-emerald-100 text-emerald-700 text-[10px] font-bold" title="Fully Achieved (85% - 100%)">Fully Achieved</span>
                                                    @elseif($response->answer === 'L')
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded bg-sky-50 border border-sky-100 text-sky-700 text-[10px] font-bold" title="Largely Achieved (50% - 85%)">Largely Achieved</span>
                                                    @elseif($response->answer === 'P')
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded bg-amber-50 border border-amber-100 text-amber-700 text-[10px] font-bold" title="Partially Achieved (15% - 50%)">Partially Achieved</span>
                                                    @else
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded bg-rose-50 border border-rose-100 text-rose-700 text-[10px] font-bold" title="Not Achieved (0% - 15%)">Not Achieved</span>
                                                    @endif
                                                </td>
                                                <td class="py-3 px-4 leading-normal italic text-slate-500 font-medium">
                                                    {{ $response->notes ?: 'Tidak ada catatan.' }}
                                                </td>
                                                <td class="py-3 px-4 text-center">
                                                    @if($response->evidence_file)
                                                        <a href="{{ asset('storage/' . $response->evidence_file) }}" download target="_blank" class="inline-flex items-center space-x-1 px-2.5 py-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 rounded-lg font-bold transition-all text-[10px] border border-indigo-100">
                                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                            </svg>
                                                            <span>Unduh</span>
                                                        </a>
                                                    @else
                                                        <span class="text-slate-400 italic text-[10px]">Tidak ada berkas</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                    <!-- Footer -->
                    <div class="px-6 py-3 border-t border-slate-100 flex items-center justify-end bg-slate-50">
                        <button type="button" onclick="closeDetailModal('{{ $processCode }}')" class="px-4 py-2 bg-slate-200 hover:bg-slate-250 text-slate-700 rounded-xl text-xs font-bold transition-colors">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

<script>
    function openDetailModal(code) {
        const modal = document.getElementById('modal-' + code);
        if (modal) {
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
    }

    function closeDetailModal(code) {
        const modal = document.getElementById('modal-' + code);
        if (modal) {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    }
</script>
@endsection
