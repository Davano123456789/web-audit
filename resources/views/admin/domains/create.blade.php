@extends('layouts.master')

@section('title', 'Web Audit - Tambah Domain COBIT')

@section('content')
<!-- Header Section -->
<div class="flex items-center space-x-3 pb-4 border-b border-slate-100 mb-6">
    <a href="{{ route('admin.domains.index') }}" class="p-1.5 bg-white border border-slate-200 rounded-lg text-slate-400 hover:text-slate-600 transition-colors shadow-3xs" title="Kembali ke Daftar">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
    </a>
    <div>
        <h1 class="text-xl font-bold text-slate-900 tracking-tight">Tambah Domain COBIT Baru</h1>
        <p class="text-[10px] text-slate-500">Mendaftarkan domain dasar (Governance/Management) COBIT 2019.</p>
    </div>
</div>

<div class="max-w-xl mx-auto">
    <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-2xs space-y-6">
        <div>
            <h2 class="text-sm font-bold text-slate-800">Formulir Informasi Domain</h2>
            <p class="text-[10px] text-slate-400 mt-0.5">Harap isi kolom dengan informasi standar COBIT 2019.</p>
        </div>

        <form action="{{ route('admin.domains.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Domain ID Input -->
            <div>
                <label for="id" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wide">ID Domain (e.g. APO, BAI, MEA)</label>
                <input type="text" id="id" name="id" required value="{{ old('id') }}" class="mt-1.5 w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all" placeholder="APO">
                @error('id')
                    <p class="text-[10px] text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Domain Name Input -->
            <div>
                <label for="name" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wide">Nama Domain (e.g. Align, Plan and Organize)</label>
                <input type="text" id="name" name="name" required value="{{ old('name') }}" class="mt-1.5 w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all" placeholder="Align, Plan and Organize">
                @error('name')
                    <p class="text-[10px] text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description Textarea -->
            <div>
                <label for="description" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wide">Deskripsi Domain</label>
                <textarea id="description" name="description" rows="4" class="mt-1.5 w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all" placeholder="Menjelaskan ruang lingkup atau fokus area dari domain tata kelola/manajemen ini...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-[10px] text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-2">
                <a href="{{ route('admin.domains.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition-colors">Batal</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-2xs transition-colors">
                    Simpan Domain
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
