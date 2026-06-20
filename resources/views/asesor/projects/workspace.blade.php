@extends('layouts.master')

@section('title', 'Web Audit - Lembar Kerja Asesmen')

@section('content')
<!-- Header Section -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0 pb-4 border-b border-slate-100 mb-6 select-none">
    <div class="flex items-center space-x-3">
        <a href="{{ route('admin.projects.show', $project->id) }}" class="p-1.5 bg-white border border-slate-200 rounded-lg text-slate-400 hover:text-slate-600 transition-colors shadow-3xs" title="Kembali ke Detail Proyek">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <div>
            <div class="flex items-center space-x-2">
                <span class="text-xs font-bold px-2 py-0.5 bg-indigo-50 border border-indigo-100/60 rounded text-indigo-600">{{ $projectProcess->process_code }}</span>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">{{ $projectProcess->cobitProcess->name }}</h1>
            </div>
            <p class="text-[10px] text-slate-500 mt-0.5">Lembar Kerja Penilaian Mandiri COBIT 2019 • Proyek: {{ $project->name }}</p>
        </div>
    </div>
</div>

<!-- Sequential Steps / Capability Level Timeline -->
<div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-2xs mb-8 select-none">
    <h3 class="text-xs font-bold text-slate-700 mb-4">Tahapan Penilaian Kapabilitas (Sequential Assessment)</h3>
    <div class="relative flex items-center justify-between">
        <!-- Horizontal Line Background -->
        <div class="absolute left-0 right-0 top-1/2 -translate-y-1/2 h-0.5 bg-slate-100 -z-10"></div>
        
        <!-- Step 1: Lvl 2 -->
        <div class="flex flex-col items-center space-y-1.5 bg-white px-3 relative">
            <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs border transition-all duration-300
                @if($activeLevel > 2) bg-emerald-500 border-emerald-500 text-white
                @elseif($activeLevel == 2) bg-sky-500 border-sky-500 text-white ring-4 ring-sky-50
                @else bg-slate-100 border-slate-200 text-slate-400 @endif">
                @if($activeLevel > 2) ✓ @else 2 @endif
            </div>
            <span class="text-[9px] font-bold @if($activeLevel == 2) text-sky-600 @else text-slate-400 @endif">Level 2</span>
        </div>

        <!-- Step 2: Lvl 3 -->
        <div class="flex flex-col items-center space-y-1.5 bg-white px-3 relative">
            <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs border transition-all duration-300
                @if($activeLevel > 3) bg-emerald-500 border-emerald-500 text-white
                @elseif($activeLevel == 3) bg-sky-500 border-sky-500 text-white ring-4 ring-sky-50
                @else bg-slate-100 border-slate-200 text-slate-400 @endif">
                @if($activeLevel > 3) ✓ @else 3 @endif
            </div>
            <span class="text-[9px] font-bold @if($activeLevel == 3) text-sky-600 @else text-slate-400 @endif">Level 3</span>
        </div>

        <!-- Step 3: Lvl 4 -->
        <div class="flex flex-col items-center space-y-1.5 bg-white px-3 relative">
            <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs border transition-all duration-300
                @if($activeLevel > 4) bg-emerald-500 border-emerald-500 text-white
                @elseif($activeLevel == 4) bg-sky-500 border-sky-500 text-white ring-4 ring-sky-50
                @else bg-slate-100 border-slate-200 text-slate-400 @endif">
                @if($activeLevel > 4) ✓ @else 4 @endif
            </div>
            <span class="text-[9px] font-bold @if($activeLevel == 4) text-sky-600 @else text-slate-400 @endif">Level 4</span>
        </div>

        <!-- Step 4: Lvl 5 -->
        <div class="flex flex-col items-center space-y-1.5 bg-white px-3 relative">
            <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs border transition-all duration-300
                @if($activeLevel == 5) bg-sky-500 border-sky-500 text-white ring-4 ring-sky-50
                @else bg-slate-100 border-slate-200 text-slate-400 @endif">
                5
            </div>
            <span class="text-[9px] font-bold @if($activeLevel == 5) text-sky-600 @else text-slate-400 @endif">Level 5</span>
        </div>
    </div>
</div>

<!-- Active Level Header Banner -->
<div class="bg-gradient-to-r from-sky-500 to-indigo-600 rounded-2xl p-6 shadow-xs text-white mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 select-none">
    <div>
        <span class="text-[9px] font-bold uppercase tracking-widest text-sky-200">Level Aktif yang Dinilai:</span>
        <h2 class="text-xl font-black mt-0.5">
            @if($activeLevel == 2) Level 2 — Basic Managed Process
            @elseif($activeLevel == 3) Level 3 — Established Process
            @elseif($activeLevel == 4) Level 4 — Predictable Process
            @elseif($activeLevel == 5) Level 5 — Optimizing Process
            @endif
        </h2>
        <p class="text-xs text-sky-100 mt-1 max-w-xl leading-relaxed opacity-90">
            @if($activeLevel == 2) Menilai apakah aktivitas operasional harian dasar sudah dikelola, terencana, terpantau, dan disesuaikan.
            @elseif($activeLevel == 3) Menilai apakah organisasi menggunakan standar SOP formal tertulis yang tersosialisasi ke seluruh divisi.
            @elseif($activeLevel == 4) Menilai apakah proses diawasi secara kuantitatif berdasarkan parameter statistik dan target capaian mutu terukur.
            @elseif($activeLevel == 5) Menilai apakah proses dioptimalkan terus-menerus melalui perbaikan berkelanjutan dan adopsi inovasi.
            @endif
        </p>
    </div>
    
    <div class="p-3 bg-white/10 rounded-xl flex items-center space-x-2 shrink-0 self-start md:self-auto border border-white/5 backdrop-blur-xs">
        <svg class="w-5 h-5 text-sky-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="text-[10px] font-bold leading-normal text-sky-100">Centang jawaban "Ada" jika kriteria terpenuhi. Total skor minimal 85% untuk lulus.</span>
    </div>
</div>

<!-- Aturan Penilaian & Kriteria Capaian Card -->
<div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-2xs mb-8 select-none">
    <div class="flex items-center space-x-2 border-b border-slate-100 pb-3 mb-4">
        <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
        </svg>
        <h3 class="text-xs font-bold text-slate-700">Panduan Kriteria Capaian & Aturan Kelulusan Level</h3>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs text-slate-650">
        <!-- Left: Kategori Capaian -->
        <div class="space-y-2.5">
            <h4 class="font-bold text-slate-800 text-[11px] uppercase tracking-wide">Kategori Kematangan (Skor Aktivitas):</h4>
            <ul class="space-y-2 text-[11px]">
                <li class="flex items-start space-x-2">
                    <span class="px-1.5 py-0.5 bg-emerald-50 text-emerald-600 rounded font-black">F</span>
                    <div>
                        <strong class="text-slate-700">Fully Achieved (85% - 100%):</strong>
                        <span class="text-slate-500 block mt-0.5">Aktivitas dilakukan secara lengkap, konsisten, dan terdokumentasi penuh.</span>
                    </div>
                </li>
                <li class="flex items-start space-x-2">
                    <span class="px-1.5 py-0.5 bg-sky-50 text-sky-600 rounded font-black">L</span>
                    <div>
                        <strong class="text-slate-700">Largely Achieved (50% - 85%):</strong>
                        <span class="text-slate-500 block mt-0.5">Sebagian besar aktivitas dilakukan dengan baik dan terdapat bukti kerja memadai.</span>
                    </div>
                </li>
                <li class="flex items-start space-x-2">
                    <span class="px-1.5 py-0.5 bg-amber-50 text-amber-600 rounded font-black">P</span>
                    <div>
                        <strong class="text-slate-700">Partially Achieved (15% - 50%):</strong>
                        <span class="text-slate-500 block mt-0.5">Aktivitas mulai diimplementasikan namun masih sporadis dan belum konsisten.</span>
                    </div>
                </li>
                <li class="flex items-start space-x-2">
                    <span class="px-1.5 py-0.5 bg-rose-50 text-rose-600 rounded font-black">N</span>
                    <div>
                        <strong class="text-slate-700">Not Achieved (0% - 15%):</strong>
                        <span class="text-slate-500 block mt-0.5">Aktivitas belum dilakukan atau baru dalam tahap wacana sangat awal.</span>
                    </div>
                </li>
            </ul>
        </div>
        
        <!-- Right: Aturan Kelulusan & Konsekuensi -->
        <div class="space-y-3 p-4 bg-slate-50 rounded-xl border border-slate-100/80">
            <h4 class="font-bold text-slate-800 text-[11px] uppercase tracking-wide">Aturan Transisi Kelulusan Level:</h4>
            <div class="space-y-2 text-[11px] leading-relaxed text-slate-600">
                <p class="flex items-start space-x-2">
                    <span class="text-emerald-500 font-extrabold">✓</span>
                    <span>Jika tingkat aktif mencapai <strong>Fully Achieved (F)</strong>, Anda <strong>LULUS</strong> dan penilaian <strong>lanjut</strong> ke tingkat kapabilitas di atasnya.</span>
                </p>
                <p class="flex items-start space-x-2">
                    <span class="text-amber-500 font-extrabold">⚠️</span>
                    <span>Jika tingkat aktif mencapai <strong>Largely Achieved (L)</strong>, penilaian <strong>berhenti</strong> dan level kapabilitas Anda dikunci pada <strong>level aktif saat ini</strong>.</span>
                </p>
                <p class="flex items-start space-x-2">
                    <span class="text-rose-500 font-extrabold">✕</span>
                    <span>Jika tingkat aktif berada di <strong>Partially (P)</strong> atau <strong>Not Achieved (N)</strong>, penilaian <strong>berhenti</strong> dan level kapabilitas akhir <strong>turun ke level sebelumnya (L - 1)</strong>.</span>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Workspace Question Form -->
<form id="workspace-form" action="{{ route('asesor.projects.workspace.submit', [$project->id, $projectProcess->process_code]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    <input type="hidden" name="level" value="{{ $activeLevel }}">

    <!-- Tabular Assessment Table Card -->
    <div class="bg-white border border-slate-100 rounded-2xl shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-400 text-[10px] font-bold uppercase tracking-wider select-none">
                        <th class="py-3.5 px-4 w-52">Praktik Manajemen</th>
                        <th class="py-3.5 px-4">Pertanyaan</th>
                        <th class="py-3.5 px-4 w-20 text-center">Ada</th>
                        <th class="py-3.5 px-4 w-72">Bukti Hasil Kerja</th>
                        <th class="py-3.5 px-4 w-20 text-center">Skor</th>
                        <th class="py-3.5 px-4 w-24 text-center">Level</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-650">
                    @php
                        $groupedQuestions = $questions->groupBy('practice_code');
                    @endphp
                    
                    @foreach($groupedQuestions as $practiceCode => $qGroup)
                        @foreach($qGroup as $index => $question)
                            @php
                                $response = $responses->get($question->id);
                                $selectedAnswer = $response ? $response->answer : 'N';
                                $noteVal = $response ? $response->notes : '';
                                $isChecked = in_array($selectedAnswer, ['F', 'L']);
                            @endphp
                            <tr class="hover:bg-slate-50/40 transition-colors">
                                <!-- Col 1: Praktik Manajemen (Merged via rowspan for the first item in group) -->
                                @if($index === 0)
                                    <td rowspan="{{ $qGroup->count() }}" class="py-4 px-4 font-bold text-slate-700 align-top border-r border-slate-100 leading-normal bg-slate-50/10">
                                        {{ $question->practice_code }}
                                        <span class="font-medium text-slate-500 block text-[10px] mt-1 leading-normal">
                                            ({{ $question->practice->name ?? 'Praktik' }})
                                        </span>
                                    </td>
                                @endif
                                
                                <!-- Col 2: Pertanyaan -->
                                <td class="py-4 px-4 align-top leading-relaxed text-slate-650 font-medium">
                                    <p>{{ $question->question_text }}</p>
                                    @if($question->expected_evidence)
                                        <div class="text-[9px] text-slate-450 bg-slate-50/50 border border-slate-100 rounded-lg p-2 flex items-start space-x-1.5 mt-2 select-none">
                                            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span><strong>Rekomendasi Bukti:</strong> {{ $question->expected_evidence }}</span>
                                        </div>
                                    @endif
                                </td>
                                
                                <!-- Col 3: Ada Checkbox (Interactive Input) -->
                                <td class="py-4 px-4 text-center align-top select-none border-x border-slate-100">
                                    <input type="hidden" name="answers[{{ $question->id }}]" value="N">
                                    <input type="checkbox" id="ada-{{ $question->id }}" value="F" 
                                           data-group="{{ $question->practice_code }}" data-qid="{{ $question->id }}"
                                           onchange="calculateWorkspaceScores()" {{ $isChecked ? 'checked' : '' }} 
                                           class="ada-cb h-4.5 w-4.5 text-sky-500 border-slate-200 rounded focus:ring-sky-500 transition-all cursor-pointer">
                                </td>
                                
                                <!-- Col 4: Bukti Hasil Kerja Text Input & File Upload -->
                                <td class="py-4 px-4 align-top space-y-2 border-r border-slate-100">
                                    <textarea name="notes[{{ $question->id }}]" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 focus:bg-white transition-all" placeholder="Catatan bukti dokumen atau pemenuhan kriteria...">{{ $noteVal }}</textarea>
                                    
                                    <div class="flex items-center justify-between gap-2">
                                        <input type="file" name="evidence_files[{{ $question->id }}]" class="w-full text-[10px] text-slate-400 file:mr-2 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-[9px] file:font-bold file:bg-slate-100 file:text-slate-600 hover:file:bg-slate-200 file:transition-colors bg-slate-50/50 border border-slate-100 rounded-lg p-1">
                                        
                                        @if($response && $response->evidence_file)
                                            <a href="{{ Storage::url($response->evidence_file) }}" download target="_blank" class="text-[9px] text-sky-500 font-extrabold hover:underline shrink-0">Buka Bukti</a>
                                        @endif
                                    </div>
                                </td>
                                
                                <!-- Col 5: Skor (Calculated & Merged) -->
                                @if($index === 0)
                                    <td rowspan="{{ $qGroup->count() }}" class="py-4 px-4 text-center align-top border-r border-slate-100 bg-slate-50/10 font-bold text-slate-800">
                                        <input type="text" id="score-{{ $practiceCode }}" readonly class="w-12 bg-white border border-slate-200 rounded-lg py-1 text-center text-xs font-black text-slate-750 focus:outline-none">
                                    </td>
                                @endif
                                
                                <!-- Col 6: Level / Rating (Calculated & Merged) -->
                                @if($index === 0)
                                    <td rowspan="{{ $qGroup->count() }}" class="py-4 px-4 text-center align-top bg-slate-50/10 font-bold text-slate-800">
                                        <input type="text" id="rating-{{ $practiceCode }}" readonly class="w-12 bg-white border border-slate-200 rounded-lg py-1 text-center text-xs font-black text-slate-750 focus:outline-none">
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @endforeach
                    
                    <!-- Total Row (Calculated) -->
                    <tr class="bg-slate-50/60 font-bold text-slate-800 border-t-2 border-slate-200">
                        <td colspan="2" class="py-3.5 px-4 text-right pr-6 uppercase tracking-wider select-none text-[10px] text-slate-500">Total</td>
                        <td class="py-3.5 px-4 border-x border-slate-200 bg-slate-100/10"></td>
                        <td class="py-3.5 px-4 border-r border-slate-200 bg-slate-100/10"></td>
                        <td class="py-3.5 px-4 text-center select-none border-r border-slate-200 bg-slate-100/20">
                            <div class="flex flex-col items-center space-y-1">
                                <span class="text-[8px] text-slate-400 font-bold uppercase tracking-widest leading-none">Skor (%)</span>
                                <input type="text" id="total-score" readonly class="w-12 bg-white border border-slate-200 rounded-lg py-1.5 text-center text-xs font-black text-slate-700 focus:outline-none">
                            </div>
                        </td>
                        <td class="py-3.5 px-4 text-center select-none bg-slate-100/20">
                            <div class="flex flex-col items-center space-y-1">
                                <span class="text-[8px] text-slate-400 font-bold uppercase tracking-widest leading-none">K. Level</span>
                                <input type="text" id="total-rating" readonly class="w-12 bg-white border border-slate-200 rounded-lg py-1.5 text-center text-xs font-black text-slate-700 focus:outline-none">
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Form Submit and Actions -->
    <div class="flex items-center justify-end space-x-3 pb-8 select-none">
        <a href="{{ route('admin.projects.show', $project->id) }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition-colors">Kembali ke Lembar Kerja</a>
        <a href="{{ route('admin.projects.index') }}" class="px-5 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-xl text-xs font-bold transition-colors">Kembali</a>
        <button type="submit" id="submit-btn" class="inline-flex items-center space-x-2 px-6 py-2.5 bg-sky-500 hover:bg-sky-600 text-white rounded-xl text-xs font-bold shadow-3xs transition-all hover:scale-[1.01]">
            <span id="btn-text">Simpan dan Lanjutkan</span>
            <svg id="btn-spinner" class="w-4 h-4 text-white animate-spin hidden" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </button>
    </div>
</form>

<!-- Success Transition Modal -->
<div id="transition-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center hidden select-none">
    <div class="bg-white border border-slate-100 rounded-2xl p-8 max-w-sm w-full mx-4 shadow-xl text-center space-y-5 animate-scale-up">
        <div class="w-14 h-14 bg-emerald-50 border border-emerald-100 rounded-full flex items-center justify-center text-emerald-500 mx-auto">
            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <div class="space-y-1.5">
            <h3 class="text-base font-bold text-slate-800" id="modal-title">Selamat! Level Berhasil Dilewati</h3>
            <p class="text-xs text-slate-500 leading-normal" id="modal-message">Kriteria kapabilitas berhasil dipenuhi. Halaman akan memuat tingkat kapabilitas berikutnya.</p>
        </div>
    </div>
</div>

<!-- Inline Custom Script for Interactive Live Scores -->
<script>
    function calculateWorkspaceScores() {
        const groups = {};
        let totalQuestions = 0;
        let totalChecked = 0;

        // Find all checkboxes with class 'ada-cb'
        const checkboxes = document.querySelectorAll('.ada-cb');
        checkboxes.forEach(cb => {
            const groupCode = cb.getAttribute('data-group');
            const qid = cb.getAttribute('data-qid');

            if (!groups[groupCode]) {
                groups[groupCode] = { total: 0, checked: 0 };
            }
            groups[groupCode].total++;
            totalQuestions++;

            if (cb.checked) {
                groups[groupCode].checked++;
                totalChecked++;
            }

            // === FIX: sync hidden input so server receives correct answer ===
            const hiddenInput = document.querySelector('input[type="hidden"][name="answers[' + qid + ']"]');
            if (hiddenInput) {
                hiddenInput.value = cb.checked ? 'F' : 'N';
            }
        });

        // Update each group score and rating level
        for (const groupCode in groups) {
            const { total, checked } = groups[groupCode];
            const percent = total > 0 ? Math.round((checked / total) * 100) : 0;
            
            let rating = 'N';
            if (percent >= 85) rating = 'F';
            else if (percent >= 50) rating = 'L';
            else if (percent >= 15) rating = 'P';

            // Update display elements
            const scoreInput = document.getElementById('score-' + groupCode);
            const ratingInput = document.getElementById('rating-' + groupCode);
            if (scoreInput) scoreInput.value = percent;
            if (ratingInput) ratingInput.value = rating;
        }

        // Update total scores
        const totalPercent = totalQuestions > 0 ? Math.round((totalChecked / totalQuestions) * 100) : 0;
        let totalRating = 'N';
        if (totalPercent >= 85) totalRating = 'F';
        else if (totalPercent >= 50) totalRating = 'L';
        else if (totalPercent >= 15) totalRating = 'P';

        const totalScoreInput = document.getElementById('total-score');
        const totalRatingInput = document.getElementById('total-rating');
        if (totalScoreInput) totalScoreInput.value = totalPercent;
        if (totalRatingInput) totalRatingInput.value = totalRating;
    }

    // Call once on page load to initialize all scores and level displays
    document.addEventListener('DOMContentLoaded', function() {
        calculateWorkspaceScores();
    });

    document.getElementById('workspace-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = e.target;
        const submitBtn = document.getElementById('submit-btn');
        const btnText = document.getElementById('btn-text');
        const btnSpinner = document.getElementById('btn-spinner');

        // Loading State
        submitBtn.disabled = true;
        btnText.textContent = 'Memproses Asesmen...';
        btnSpinner.classList.remove('hidden');

        // Send AJAX Request
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show Success Transition Modal
                const modal = document.getElementById('transition-modal');
                const modalTitle = document.getElementById('modal-title');
                const modalMessage = document.getElementById('modal-message');

                if (data.status === 'completed') {
                    modalTitle.textContent = 'Penilaian Selesai!';
                    modalMessage.textContent = data.message + ' Halaman akan memuat rekapitulasi penilaian kapabilitas.';
                    modal.classList.remove('hidden');
                    
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else if (data.status === 'advanced') {
                    modalTitle.textContent = 'Lulus Level Aktif!';
                    modalMessage.textContent = data.message;
                    modal.classList.remove('hidden');

                    setTimeout(() => {
                        window.location.reload();
                    }, 2500);
                } else {
                    // Just a save check
                    alert(data.message);
                    window.location.reload();
                }
            } else {
                alert('Terjadi kesalahan saat memproses data. Silakan coba kembali.');
                // Reset states
                submitBtn.disabled = false;
                btnText.textContent = 'Simpan dan Lanjutkan';
                btnSpinner.classList.add('hidden');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kendala jaringan. Periksa koneksi Anda dan coba kembali.');
            // Reset states
            submitBtn.disabled = false;
            btnText.textContent = 'Simpan dan Lanjutkan';
            btnSpinner.classList.add('hidden');
        });
    });
</script>
@endsection
