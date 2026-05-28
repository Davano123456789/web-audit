@extends('layouts.master')

@section('title', 'Web Audit - Buat Proyek Baru')

@section('content')
<!-- Header Section -->
<div class="flex items-center space-x-3 pb-4 border-b border-slate-100 mb-6">
    <a href="{{ route('admin.projects.index') }}" class="p-1.5 bg-white border border-slate-200 rounded-lg text-slate-400 hover:text-slate-600 transition-colors shadow-3xs" title="Kembali ke Daftar">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
    </a>
    <div>
        <h1 class="text-xl font-bold text-slate-900 tracking-tight">Buat Proyek Audit Baru</h1>
        <p class="text-[10px] text-slate-500">Tugaskan kuesioner proses COBIT 2019 kepada Asesor terpilih.</p>
    </div>
</div>

<div class="max-w-4xl mx-auto">
    <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-2xs space-y-6">
        <div>
            <h2 class="text-sm font-bold text-slate-800">Formulir Pendelegasian Audit</h2>
            <p class="text-[10px] text-slate-400 mt-0.5">Isi detail proyek dan centang proses COBIT yang diaktifkan.</p>
        </div>

        <form action="{{ route('admin.projects.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Left Column (Metadata): 5 Cols -->
                <div class="lg:col-span-5 space-y-5">
                    <!-- Name Input -->
                    <div>
                        <label for="name" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wide">Nama Proyek *</label>
                        <input type="text" id="name" name="name" required value="{{ old('name') }}" class="mt-1.5 w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 focus:bg-white transition-all" placeholder="Audit TI Kantor Cabang - 2026">
                    </div>

                    <!-- Description Input -->
                    <div>
                        <label for="description" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wide">Deskripsi Proyek</label>
                        <textarea id="description" name="description" rows="4" class="mt-1.5 w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 focus:bg-white transition-all" placeholder="Penilaian tingkat kematangan tata kelola keamanan operasional TI kantor cabang..."></textarea>
                    </div>

                    <!-- Asesor Selection (Hidden) -->
                    <input type="hidden" name="asesor_id" value="{{ auth()->id() }}">
                </div>

                <!-- Right Column (Checkboxes Table): 7 Cols -->
                <div class="lg:col-span-7 flex flex-col">
                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wide mb-2">Proses Assessment *</label>
                    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden flex-1 max-h-96 overflow-y-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200 text-slate-400 text-[10px] font-bold uppercase tracking-wider select-none">
                                    <th class="py-2.5 px-4 w-12 text-center">
                                        <input type="checkbox" id="check-all-processes" class="h-3.5 w-3.5 text-sky-500 border-slate-200 rounded focus:ring-sky-500 transition-all cursor-pointer">
                                    </th>
                                    <th class="py-2.5 px-4 text-[10px] text-slate-500 uppercase tracking-wider">Nama Proses</th>
                                    <th class="py-2.5 px-4 text-[10px] text-slate-500 uppercase tracking-wider">Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                                @foreach($processes as $process)
                                    <tr class="hover:bg-slate-50/50 transition-colors cursor-pointer" onclick="toggleProcessRow('proc-{{ $process->code }}')">
                                        <td class="py-3 px-4 text-center" onclick="event.stopPropagation()">
                                            <input type="checkbox" name="processes[]" id="proc-{{ $process->code }}" value="{{ $process->code }}" class="h-3.5 w-3.5 text-sky-500 border-slate-200 rounded focus:ring-sky-500 transition-all cursor-pointer">
                                        </td>
                                        <td class="py-3 px-4 font-bold text-sky-500">{{ $process->code }}</td>
                                        <td class="py-3 px-4 text-slate-700 font-medium">{{ $process->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-5 border-t border-slate-100">
                <a href="{{ route('admin.projects.index') }}" class="px-5 py-2 bg-slate-150 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition-colors">Batal</a>
                <button type="submit" class="px-5 py-2 bg-sky-500 hover:bg-sky-600 text-white rounded-xl text-xs font-bold shadow-3xs transition-colors">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkAll = document.getElementById('check-all-processes');
        if (checkAll) {
            checkAll.addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('input[name="processes[]"]');
                checkboxes.forEach(cb => cb.checked = this.checked);
            });
        }
    });

    function toggleProcessRow(id) {
        const cb = document.getElementById(id);
        if (cb) cb.checked = !cb.checked;
    }
</script>
@endsection
