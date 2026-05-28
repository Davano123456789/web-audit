@extends('layouts.master')

@section('title', 'Web Audit - Edit Pertanyaan')

@section('content')
<!-- Header Section -->
<div class="flex items-center space-x-3 pb-4 border-b border-slate-100 mb-6">
    <a href="{{ route('admin.questions.index') }}" class="p-1.5 bg-white border border-slate-200 rounded-lg text-slate-400 hover:text-slate-600 transition-colors shadow-3xs" title="Kembali ke Daftar">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
    </a>
    <div>
        <h1 class="text-xl font-bold text-slate-900 tracking-tight">Edit Pertanyaan Kuesioner</h1>
        <p class="text-[10px] text-slate-500">Perbarui pemetaan sub-praktik, tingkat kapabilitas, atau butir pertanyaan.</p>
    </div>
</div>

<div class="max-w-xl mx-auto">
    <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-2xs space-y-6">
        <div>
            <h2 class="text-sm font-bold text-slate-800">Formulir Edit Pertanyaan</h2>
            <p class="text-[10px] text-slate-400 mt-0.5">Seluruh kolom wajib diisi.</p>
        </div>

        <form action="{{ route('admin.questions.update', $question->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Process Select -->
            <div>
                <label for="process_code" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wide">Proses COBIT</label>
                <select id="process_code" name="process_code" required class="mt-1.5 w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-700 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all">
                    @foreach($processes as $process)
                        <option value="{{ $process->code }}" {{ old('process_code', $question->practice->process_code ?? '') == $process->code ? 'selected' : '' }}>
                            {{ $process->code }} - {{ $process->name }}
                        </option>
                    @endforeach
                </select>
                @error('process_code')
                    <p class="text-[10px] text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Sub-Practice Code Input -->
            <div>
                <label for="practice_code" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wide">Kode Praktik Manajemen (e.g. DSS01.01)</label>
                <input type="text" id="practice_code" name="practice_code" required value="{{ old('practice_code', $question->practice_code) }}" class="mt-1.5 w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all" placeholder="DSS01.01">
                @error('practice_code')
                    <p class="text-[10px] text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Sub-Practice Name Input -->
            <div>
                <label for="practice_name" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wide">Nama Praktik Manajemen (e.g. Melakukan prosedur operasional)</label>
                <input type="text" id="practice_name" name="practice_name" required value="{{ old('practice_name', $question->practice->name ?? '') }}" class="mt-1.5 w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all" placeholder="Melakukan prosedur operasional">
                @error('practice_name')
                    <p class="text-[10px] text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Level Select -->
            <div>
                <label for="level" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wide">Skala Capability Level</label>
                <select id="level" name="level" required class="mt-1.5 w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-700 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all">
                    <option value="2" {{ old('level', $question->level) == 2 ? 'selected' : '' }}>Level 2 (Basic Managed)</option>
                    <option value="3" {{ old('level', $question->level) == 3 ? 'selected' : '' }}>Level 3 (Established)</option>
                    <option value="4" {{ old('level', $question->level) == 4 ? 'selected' : '' }}>Level 4 (Predictable)</option>
                    <option value="5" {{ old('level', $question->level) == 5 ? 'selected' : '' }}>Level 5 (Optimizing)</option>
                </select>
                @error('level')
                    <p class="text-[10px] text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Question Textarea -->
            <div>
                <label for="question_text" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wide">Butir Pertanyaan Kuesioner</label>
                <textarea id="question_text" name="question_text" rows="4" required class="mt-1.5 w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all" placeholder="Apakah organisasi melakukan...?">{{ old('question_text', $question->question_text) }}</textarea>
                @error('question_text')
                    <p class="text-[10px] text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>


            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-2">
                <a href="{{ route('admin.questions.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition-colors">Batal</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-2xs transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
