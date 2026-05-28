@extends('layouts.master')

@section('title', 'Web Audit - Hasil Asesmen Proses')

@section('content')
<!-- Header Section -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0 pb-4 border-b border-slate-100 mb-6">
    <div class="flex items-center space-x-3">
        <a href="{{ route('asesor.projects.show', $project->id) }}" class="p-1.5 bg-white border border-slate-200 rounded-lg text-slate-400 hover:text-slate-600 transition-colors shadow-3xs" title="Kembali ke Detail Proyek">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <div>
            <div class="flex items-center space-x-2">
                <span class="text-xs font-bold px-2 py-0.5 bg-indigo-50 border border-indigo-100/60 rounded text-indigo-600">{{ $projectProcess->process_code }}</span>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">{{ $projectProcess->cobitProcess->name }}</h1>
            </div>
            <p class="text-[10px] text-slate-500 mt-0.5">Asesmen Selesai • Proyek: {{ $project->name }}</p>
        </div>
    </div>
</div>

<div class="max-w-2xl mx-auto space-y-8">
    
    <!-- Achievement Banner Card -->
    <div class="bg-white border border-slate-100 rounded-2xl p-8 shadow-2xs text-center space-y-6">
        <div class="space-y-2">
            <span class="inline-block px-3 py-1 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-full text-[9px] font-bold uppercase tracking-widest">Penilaian Selesai</span>
            <h2 class="text-base font-bold text-slate-800">Tingkat Kapabilitas Tercapai</h2>
        </div>

        <!-- Shield Badge Illustration -->
        <div class="relative w-28 h-28 mx-auto flex items-center justify-center">
            <!-- Outer Glow Rings -->
            <div class="absolute inset-0 bg-indigo-500/10 rounded-full animate-pulse"></div>
            
            <!-- Shield Graphic -->
            <div class="w-20 h-20 rounded-2xl rotate-45 flex items-center justify-center shadow-md relative
                @if($capabilityLevel >= 4) bg-gradient-to-br from-amber-400 to-amber-500 text-white border-amber-300
                @elseif($capabilityLevel >= 2) bg-gradient-to-br from-indigo-500 to-indigo-600 text-white border-indigo-400
                @else bg-gradient-to-br from-slate-400 to-slate-500 text-white border-slate-300 @endif">
                
                <div class="-rotate-45 flex flex-col items-center justify-center">
                    <span class="text-[8px] font-bold uppercase tracking-widest opacity-80 leading-none">Level</span>
                    <span class="text-3xl font-black mt-0.5 leading-none">{{ $capabilityLevel }}</span>
                </div>
            </div>
        </div>

        <div class="space-y-1.5 max-w-md mx-auto">
            <h3 class="text-lg font-black text-slate-800">
                @if($capabilityLevel == 5) Level 5 — Optimizing
                @elseif($capabilityLevel == 4) Level 4 — Predictable
                @elseif($capabilityLevel == 3) Level 3 — Established
                @elseif($capabilityLevel == 2) Level 2 — Basic Managed
                @elseif($capabilityLevel == 1) Level 1 — Initial
                @else Level 0 — Incomplete / Non-existent
                @endif
            </h3>
            <p class="text-xs text-slate-500 leading-relaxed">
                @if($capabilityLevel == 5) Proses terus-menerus dioptimalkan secara proaktif melalui perbaikan berkelanjutan dan adopsi praktik inovatif terbaik.
                @elseif($capabilityLevel == 4) Proses diawasi dan dikendalikan secara kuantitatif berdasarkan parameter statistik dan target capaian mutu terukur.
                @elseif($capabilityLevel == 3) Proses dijalankan menggunakan kriteria operasional standar dan kebijakan tertulis (SOP) yang didokumentasikan resmi.
                @elseif($capabilityLevel == 2) Proses dasar operasional dikelola secara teratur, terencana, terpantau, dan disesuaikan.
                @elseif($capabilityLevel == 1) Proses dijalankan secara ad-hoc informal tanpa konsistensi atau bukti tertulis yang terstruktur.
                @else Proses tidak dijalankan atau gagal memenuhi kriteria dasar kelulusan Level 2 (kepatuhan F/L di bawah 85%).
                @endif
            </p>
        </div>
    </div>

    <!-- Levels Evaluation History Breakdown -->
    <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-2xs space-y-4">
        <h3 class="text-xs font-bold text-slate-700 select-none border-b border-slate-100 pb-3">Rincian Evaluasi Tingkat Kapabilitas</h3>
        
        <div class="space-y-3.5">
            @foreach([2, 3, 4, 5] as $lvl)
                @php
                    $step = $history[$lvl] ?? null;
                @endphp
                <div class="flex items-center justify-between p-3.5 rounded-xl border
                    @if($step && $step['status'] === 'passed') bg-emerald-50/20 border-emerald-100/60
                    @elseif($step && $step['status'] === 'failed') bg-rose-50/20 border-rose-100/60
                    @else bg-slate-50/50 border-slate-100 @endif">
                    
                    <div class="flex items-center space-x-3">
                        <!-- Left Status Icon -->
                        <div class="w-6 h-6 rounded-full flex items-center justify-center font-bold text-[10px] shrink-0
                            @if($step && $step['status'] === 'passed') bg-emerald-500 text-white
                            @elseif($step && $step['status'] === 'failed') bg-rose-500 text-white
                            @else bg-slate-100 text-slate-400 border border-slate-200 @endif">
                            @if($step && $step['status'] === 'passed') ✓
                            @elseif($step && $step['status'] === 'failed') ✗
                            @else - @endif
                        </div>

                        <div class="space-y-0.5">
                            <span class="text-xs font-bold text-slate-700">Level {{ $lvl }}</span>
                            <span class="text-[9px] text-slate-400 block">
                                @if($step && $step['status'] === 'skipped')
                                    Diabaikan (Tidak ada butir pertanyaan untuk Level {{ $lvl }})
                                @elseif($step)
                                    Evaluasi: {{ $step['fl_count'] }} F/L dari {{ $step['questions_count'] }} pertanyaan
                                @else
                                    Terkunci (Gagal pada tingkat kapabilitas sebelumnya)
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- Right Badge -->
                    <div>
                        @if($step && $step['status'] === 'passed')
                            <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-[9px] font-bold">Lulus ({{ number_format($step['score'], 0) }}%)</span>
                        @elseif($step && $step['status'] === 'failed')
                            <span class="px-2.5 py-1 bg-rose-100 text-rose-700 rounded-lg text-[9px] font-bold">Gagal ({{ number_format($step['score'], 0) }}%)</span>
                        @elseif($step && $step['status'] === 'skipped')
                            <span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-lg text-[9px] font-bold">Terlewati</span>
                        @else
                            <span class="px-2.5 py-1 bg-slate-100 text-slate-400 rounded-lg text-[9px] font-bold">Terkunci</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-2">
        <a href="{{ route('asesor.projects.show', $project->id) }}" class="inline-flex items-center justify-center space-x-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-2xs hover:scale-[1.01] transition-all">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali ke Detail Proyek</span>
        </a>

        <!-- Reset & Re-Assess Button -->
        <form action="{{ route('asesor.projects.workspace.reset', [$project->id, $projectProcess->process_code]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengatur ulang (reset) penilaian ini? Seluruh jawaban dan berkas bukti dokumen pendukung yang telah diunggah akan dihapus secara permanen dari sistem.');" class="inline">
            @csrf
            <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-xl text-xs font-bold transition-all flex items-center justify-center space-x-1.5 border border-rose-100">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                <span>Hapus & Ulangi Asesmen</span>
            </button>
        </form>
    </div>

</div>
@endsection
