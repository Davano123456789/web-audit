@extends('layouts.master')

@section('title', 'Web Audit - Proyek')

@section('content')
<!-- Breadcrumbs & Title Section -->
<div class="space-y-1 pb-4 border-b border-slate-100 select-none">
    <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Proyek</h1>
    <div class="flex items-center space-x-2 text-xs text-slate-400">
        <a href="/" class="hover:text-indigo-600 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
        </a>
        <span>•</span>
        <span class="text-slate-500 font-medium">Proyek</span>
    </div>
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

@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Ups!',
                text: "{{ session('error') }}",
                background: '#ffffff',
                customClass: {
                    popup: 'rounded-2xl border border-slate-100 shadow-xl'
                }
            });
        });
    </script>
@endif

<!-- Full Width Table Card -->
<div class="bg-white border border-slate-100 rounded-2xl shadow-2xs overflow-hidden">
    <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
        <div>
            <h2 class="text-sm font-bold text-slate-800">Tabel</h2>
            <p class="text-[10px] text-slate-400 mt-0.5">Daftar Proyek</p>
        </div>
        
        <!-- Tambah Proyek Button at Card Top Right -->
        <a href="{{ route('admin.projects.create') }}" class="flex items-center space-x-2 px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white rounded-lg text-xs font-semibold shadow-3xs transition-all hover:scale-[1.01]">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah Proyek</span>
        </a>
    </div>

    <!-- Table Navigation Search Filter Block -->
    <div class="px-6 py-4 border-b border-slate-50 flex flex-col sm:flex-row items-center justify-between gap-4 bg-slate-50/20 select-none">
        <div class="flex items-center space-x-2 text-xs text-slate-500">
            <span>Menampilkan</span>
            <select id="entries-limit" class="bg-white border border-slate-200 rounded-md px-2 py-1 text-xs focus:outline-none focus:ring-1 focus:ring-sky-500">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="all">Semua</option>
            </select>
            <span>entri</span>
        </div>
        <div class="relative w-full max-w-xs">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input type="text" id="search-input" placeholder="Cari..." class="w-full bg-white border border-slate-200 rounded-lg pl-9 pr-4 py-1.5 text-xs text-slate-650 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 transition-all">
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-slate-400 text-[10px] font-bold uppercase tracking-wider select-none">
                    <th class="py-4 px-6 w-12 text-center">No.</th>
                    <th class="py-4 px-6">Nama Proyek</th>
                    <th class="py-4 px-6">Tanggal Pembuatan</th>
                    <th class="py-4 px-6">User</th>
                    <th class="py-4 px-6">Proses Assessment</th>
                    <th class="py-4 px-6 text-center w-36">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                @forelse($projects as $project)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <!-- No. Column -->
                        <td class="py-4 px-6 font-medium text-slate-400 text-center select-none">
                            {{ $loop->iteration }}
                        </td>
                        
                        <!-- Nama Proyek -->
                        <td class="py-4 px-6">
                            <div class="flex flex-col">
                                <span class="font-semibold text-slate-800 text-sm">{{ $project->name }}</span>
                                @if($project->description)
                                    <span class="text-[10px] text-slate-400 mt-0.5">{{ Str::limit($project->description, 80) }}</span>
                                @endif
                            </div>
                        </td>
                        
                        <!-- Tanggal Pembuatan -->
                        <td class="py-4 px-6 text-slate-600">
                            {{ $project->created_at->format('d/m/Y') }}
                        </td>
                        
                        <!-- User (Asesor Pelaksana) -->
                        <td class="py-4 px-6 font-semibold text-slate-700">
                            {{ $project->asesor->name }}
                        </td>
                        
                        <!-- Proses Assessment Links -->
                        <td class="py-4 px-6">
                            <div class="flex flex-wrap gap-2.5">
                                @forelse($project->projectProcesses as $projectProcess)
                                    @if(auth()->user()->role === 'admin' && (int) $project->asesor_id !== (int) auth()->id())
                                        <span class="text-slate-500 font-semibold text-xs tracking-wide bg-slate-50 px-2 py-0.5 rounded border border-slate-100" title="Proses {{ $projectProcess->process_code }}">
                                            {{ $projectProcess->process_code }}
                                        </span>
                                    @else
                                        <a href="{{ route('asesor.projects.workspace', [$project->id, $projectProcess->process_code]) }}" 
                                           class="text-sky-500 font-extrabold hover:text-sky-600 hover:underline transition-all text-xs tracking-wide"
                                           title="Buka Workspace Penilaian {{ $projectProcess->process_code }}">
                                            {{ $projectProcess->process_code }}
                                        </a>
                                    @endif
                                @empty
                                    <span class="text-[10px] text-slate-400 italic">Belum ada proses terpilih</span>
                                @endforelse
                            </div>
                        </td>
                        
                        <!-- Aksi Buttons -->
                        <td class="py-4 px-6 text-center">
                            <div class="flex items-center justify-center space-x-1.5">
                                <!-- Detail/Rekap Button -->
                                <a href="{{ route('admin.projects.show', $project->id) }}" 
                                   class="p-1.5 bg-slate-50 text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 rounded-md border border-slate-100 transition-colors" 
                                   title="Detail Laporan Rekapitulasi">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>

                                <!-- Print Button -->
                                <a href="{{ route('admin.projects.print', $project->id) }}" 
                                   target="_blank"
                                   class="p-1.5 bg-slate-50 text-slate-500 hover:bg-emerald-50 hover:text-emerald-600 rounded-md border border-slate-100 transition-colors" 
                                   title="Cetak Lembar Kerja / Laporan">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                    </svg>
                                </a>
                                
                                <!-- Edit Button -->
                                @if(auth()->user()->role !== 'admin')
                                <a href="{{ route('admin.projects.edit', $project->id) }}" 
                                   class="p-1.5 bg-slate-50 text-slate-500 hover:bg-amber-50 hover:text-amber-600 rounded-md border border-slate-100 transition-colors" 
                                   title="Ubah Konfigurasi Proyek">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>
                                @endif
                                
                                <!-- Delete Button -->
                                <button type="button" onclick="confirmDelete('{{ $project->id }}')" 
                                        class="p-1.5 bg-slate-50 text-slate-500 hover:bg-rose-50 hover:text-rose-600 rounded-md border border-slate-100 transition-colors" 
                                        title="Hapus Proyek">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                                <form id="delete-form-{{ $project->id }}" action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 px-6 text-center text-slate-400 font-medium select-none">Belum ada proyek audit yang dibuat.</td>
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
            text: 'Menghapus proyek audit ini akan menghapus semua riwayat penugasan, respon pengisian kuesioner, dan dokumen bukti terkait secara permanen!',
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

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
        const entriesLimit = document.getElementById('entries-limit');
        const tbody = document.querySelector('tbody');

        if (searchInput && entriesLimit && tbody) {
            // Create a custom "no results found" row
            const noResultsRow = document.createElement('tr');
            noResultsRow.id = 'no-results-row';
            noResultsRow.className = 'hidden';
            noResultsRow.innerHTML = `
                <td colspan="5" class="py-8 px-6 text-center text-slate-400 font-medium select-none">
                    Tidak ada proyek yang cocok dengan pencarian Anda.
                </td>
            `;
            tbody.appendChild(noResultsRow);

            function updateTable() {
                const query = searchInput.value.toLowerCase().trim();
                const limitVal = entriesLimit.value;
                const limit = limitVal === 'all' ? Infinity : parseInt(limitVal);
                
                const rows = tbody.querySelectorAll('tr:not(#no-results-row)');
                let visibleCount = 0;
                let matchCount = 0;

                rows.forEach((row) => {
                    const emptyDbRow = row.querySelector('td[colspan]');
                    if (emptyDbRow) {
                        // If DB is empty, show the default empty row only if search is empty
                        row.style.display = query === '' ? '' : 'none';
                        return;
                    }

                    // Extract text for matching
                    const text = row.textContent.toLowerCase();
                    const matchesSearch = text.includes(query);

                    if (matchesSearch) {
                        matchCount++;
                        if (visibleCount < limit) {
                            row.style.display = '';
                            visibleCount++;
                        } else {
                            row.style.display = 'none';
                        }
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Display "no results" row if no rows match the query
                if (query !== '' && matchCount === 0) {
                    noResultsRow.classList.remove('hidden');
                } else {
                    noResultsRow.classList.add('hidden');
                }
            }

            searchInput.addEventListener('input', updateTable);
            entriesLimit.addEventListener('change', updateTable);
            
            // Run initially to apply the default limit (e.g. 10 entries)
            updateTable();
        }
    });
</script>
@endsection
