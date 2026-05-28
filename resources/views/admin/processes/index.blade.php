@extends('layouts.master')

@section('title', 'Web Audit - Proses Assessment')

@section('content')
<!-- Header Section -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0 pb-4 border-b border-slate-100 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Proses Assessment</h1>
        <p class="text-xs text-slate-500 mt-1">Kelola daftar proses tata kelola dan manajemen teknologi informasi berdasarkan kerangka kerja COBIT 2019.</p>
    </div>
</div>

<!-- SweetAlert Success Notification -->
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

<!-- Full Width Table -->
<div class="bg-white border border-slate-100 rounded-2xl shadow-2xs overflow-hidden">
    <div class="px-6 py-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-sm font-bold text-slate-800">Tabel</h2>
            <p class="text-[10px] text-slate-400 mt-0.5">Daftar Proses Assessment</p>
        </div>
        <div>
            <!-- Tambah Button -->
            <a href="{{ route('admin.processes.create') }}" class="inline-flex items-center space-x-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-2xs hover:scale-[1.01] transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                <span>Tambah Proses Assessment</span>
            </a>
        </div>
    </div>

    <!-- Table Content -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-slate-400 text-[10px] font-bold uppercase tracking-wider select-none">
                    <th class="py-4 px-6 w-16 text-center">No.</th>
                    <th class="py-4 px-6 w-32">Kode Proses</th>
                    <th class="py-4 px-6">Nama Proses</th>
                    <th class="py-4 px-6 text-right w-40">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                @forelse($processes as $index => $process)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-4 px-6 text-center font-bold text-slate-400 select-none">{{ $index + 1 }}</td>
                        <td class="py-4 px-6 font-bold text-slate-800 select-all">
                            <div class="flex flex-col">
                                <span>{{ $process->code }}</span>
                                <span class="text-[9px] text-slate-400 font-normal">Domain: {{ $process->domain_id }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="font-semibold text-slate-800">{{ $process->name }}</span>
                        </td>
                        <td class="py-4 px-6 text-right space-x-1.5">
                            <a href="{{ route('admin.processes.edit', $process->code) }}" class="inline-block px-2.5 py-1.5 bg-amber-50 text-amber-600 font-semibold rounded-lg hover:bg-amber-100 transition-colors text-[10px]" title="Ubah Proses">Ubah</a>
                            <button type="button" onclick="confirmDelete('{{ $process->code }}')" class="px-2.5 py-1.5 bg-rose-50 text-rose-600 font-semibold rounded-lg hover:bg-rose-100 transition-colors text-[10px]" title="Hapus Proses">Hapus</button>
                            <form id="delete-form-{{ $process->code }}" action="{{ route('admin.processes.destroy', $process->code) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-8 px-6 text-center text-slate-400 font-medium">Belum ada proses assessment terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmDelete(code) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Menghapus proses ini akan menghapus semua data sub-praktik, bank pertanyaan, dan respon asesmen terkait secara permanen!',
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
                document.getElementById('delete-form-' + code).submit();
            }
        });
    }
</script>
@endsection
