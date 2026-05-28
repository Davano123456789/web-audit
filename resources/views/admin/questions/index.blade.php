@extends('layouts.master')

@section('title', 'Web Audit - Bank Pertanyaan')

@section('content')
<!-- Header Section -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0 pb-4 border-b border-slate-100">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Pengelolaan Bank Pertanyaan</h1>
        <p class="text-xs text-slate-500 mt-1">Kelola dan input pertanyaan kuesioner audit yang dipetakan per tingkat kapabilitas COBIT 2019.</p>
    </div>
    <a href="{{ route('admin.questions.create') }}" class="inline-flex items-center space-x-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-2xs transition-colors w-fit">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>
        <span>Tambah Pertanyaan</span>
    </a>
</div>

<!-- SweetAlert Success & Error Notifications -->
@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
                background: '#ffffff',
                iconColor: '#10b981',
                customClass: {
                    popup: 'rounded-2xl border border-slate-100 shadow-xl'
                }
            });
        });
    </script>
@endif

@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                background: '#ffffff',
                customClass: {
                    popup: 'rounded-2xl border border-slate-100 shadow-xl'
                }
            });
        });
    </script>
@endif

<!-- Filters Card -->
<div class="bg-white border border-slate-100 rounded-2xl p-4 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div class="text-xs font-semibold text-slate-700">Filter Pencarian Praktik COBIT</div>
    <form method="GET" action="{{ route('admin.questions.index') }}" class="flex items-center space-x-3 w-full sm:w-auto">
        <select name="practice" onchange="this.form.submit()" class="w-full sm:w-64 bg-slate-50 border border-slate-200 rounded-lg px-3 py-1.5 text-xs text-slate-600 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
            <option value="">-- Tampilkan Semua Pertanyaan --</option>
            @foreach($practices as $practice)
                <option value="{{ $practice->code }}" {{ request('practice') == $practice->code ? 'selected' : '' }}>
                    {{ $practice->code }} - {{ Str::limit($practice->name, 40) }}
                </option>
            @endforeach
        </select>
        @if(request('practice'))
            <a href="{{ route('admin.questions.index') }}" class="text-xs text-indigo-600 font-semibold hover:underline shrink-0">Reset</a>
        @endif
    </form>
</div>

<!-- Table Card -->
<div class="bg-white border border-slate-100 rounded-2xl shadow-2xs overflow-hidden space-y-4">
    <div class="px-6 py-5 border-b border-slate-100">
        <h2 class="text-sm font-bold text-slate-800">Tabel</h2>
        <p class="text-[10px] text-slate-400 mt-0.5">Daftar Pertanyaan</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-slate-400 text-[10px] font-bold uppercase tracking-wider select-none">
                    <th class="py-4 px-6 w-16 text-center">No.</th>
                    <th class="py-4 px-6 w-24">Kode Proses</th>
                    <th class="py-4 px-6 w-20 text-center">Level</th>
                    <th class="py-4 px-6 w-56">Praktik Manajemen</th>
                    <th class="py-4 px-6">Pertanyaan</th>
                    <th class="py-4 px-6 text-right w-40">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                @forelse($questions as $index => $question)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-4 px-6 text-center font-bold text-slate-400 select-none">{{ $index + 1 }}</td>
                        <td class="py-4 px-6 font-bold text-slate-700 select-all">{{ $question->practice->process_code ?? '-' }}</td>
                        <td class="py-4 px-6 text-center font-semibold text-slate-700">
                            <span class="inline-block px-2.5 py-0.5 rounded-full font-bold text-[10px] bg-indigo-50 text-indigo-600">{{ $question->level }}</span>
                        </td>
                        <td class="py-4 px-6 font-semibold text-slate-700 max-w-xs leading-normal">
                            <div class="flex flex-col">
                                <span>{{ $question->practice_code }}</span>
                                <span class="text-[9px] text-slate-400 font-normal mt-0.5">{{ $question->practice->name ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-6 space-y-1.5">
                            <p class="font-medium text-slate-800 leading-normal">{{ $question->question_text }}</p>
                            @if($question->expected_evidence)
                                <div class="p-2 bg-indigo-50/40 border border-indigo-100/50 rounded-lg text-[9px] text-indigo-600 flex items-start space-x-1.5 max-w-lg">
                                    <svg class="w-3.5 h-3.5 text-indigo-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span><strong class="text-indigo-700">Rekomendasi Bukti:</strong> {{ $question->expected_evidence }}</span>
                                </div>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right space-x-1.5">
                            <a href="{{ route('admin.questions.edit', $question->id) }}" class="inline-block px-2.5 py-1.5 bg-amber-50 text-amber-600 font-semibold rounded-lg hover:bg-amber-100 transition-colors text-[10px]" title="Ubah Pertanyaan">Ubah</a>
                            <button type="button" onclick="confirmDelete('{{ $question->id }}')" class="px-2.5 py-1.5 bg-rose-50 text-rose-600 font-semibold rounded-lg hover:bg-rose-100 transition-colors text-[10px]" title="Hapus Pertanyaan">Hapus</button>
                            <form id="delete-form-{{ $question->id }}" action="{{ route('admin.questions.destroy', $question->id) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 px-6 text-center text-slate-400 font-medium">Tidak ada pertanyaan ditemukan untuk kriteria ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Menghapus pertanyaan ini akan menghapus seluruh data respon/jawaban asesmen dari asesor terkait secara permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48', // rose-600
            cancelButtonColor: '#64748b', // slate-500
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            background: '#ffffff',
            customClass: {
                popup: 'rounded-2xl border border-slate-100 shadow-xl'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection
