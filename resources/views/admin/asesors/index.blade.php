@extends('layouts.master')

@section('title', 'Web Audit - Manajemen Asesor')

@section('content')
<!-- Header Section -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0 pb-4 border-b border-slate-100">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Manajemen Akun Asesor</h1>
        <p class="text-xs text-slate-500 mt-1">Daftarkan dan kelola hak akses para auditor/asesor lapangan di sistem.</p>
    </div>
    <div>
        <!-- Link to dedicated create page -->
        <a href="{{ route('admin.asesors.create') }}" class="flex items-center space-x-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-2xs hover:scale-[1.01] transition-all">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            <span>Daftarkan Asesor Baru</span>
        </a>
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

<!-- Full Width Table -->
<div class="bg-white border border-slate-100 rounded-2xl shadow-2xs overflow-hidden">
    <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
        <div>
            <h2 class="text-sm font-bold text-slate-800">Daftar Asesor Terdaftar</h2>
            <p class="text-[10px] text-slate-400 mt-0.5">Daftar pengguna dengan peran asesor yang dapat menjalankan kuesioner.</p>
        </div>
        <span class="text-[10px] font-bold text-slate-500 bg-slate-50 border border-slate-100 px-2.5 py-1 rounded-full">Total: {{ $asesors->count() }} Asesor</span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-slate-400 text-[10px] font-bold uppercase tracking-wider select-none">
                    <th class="py-4 px-6">Nama Asesor</th>
                    <th class="py-4 px-6">Alamat Email</th>
                    <th class="py-4 px-6">Mulai Terdaftar</th>
                    <th class="py-4 px-6 text-right">Tindakan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                @forelse($asesors as $asesor)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-4 px-6 font-semibold text-slate-800">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-600/10 text-indigo-600 flex items-center justify-center font-bold text-xs">
                                    {{ strtoupper(substr($asesor->name, 0, 2)) }}
                                </div>
                                <span>{{ $asesor->name }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-6 font-medium text-slate-500">{{ $asesor->email }}</td>
                        <td class="py-4 px-6 text-slate-400">{{ $asesor->created_at->format('d M Y') }}</td>
                        <td class="py-4 px-6 text-right space-x-2">
                            <!-- Link to edit page -->
                            <a href="{{ route('admin.asesors.edit', $asesor->id) }}" class="inline-block px-2.5 py-1.5 bg-slate-50 text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 font-semibold rounded-lg transition-colors text-[10px]" title="Ubah Data">Ubah</a>
                            
                            <!-- Delete action -->
                            <button type="button" onclick="confirmDelete('{{ $asesor->id }}')" class="px-2.5 py-1.5 bg-rose-50 text-rose-600 font-semibold rounded-lg hover:bg-rose-100 transition-colors text-[10px]" title="Hapus Akun">Hapus</button>
                            <form id="delete-form-{{ $asesor->id }}" action="{{ route('admin.asesors.destroy', $asesor->id) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-8 px-6 text-center text-slate-400 font-medium">Belum ada akun Asesor yang didaftarkan.</td>
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
            text: 'Menghapus akun Asesor ini akan menghapus seluruh data proyek dan riwayat penugasan terkait secara permanen!',
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
