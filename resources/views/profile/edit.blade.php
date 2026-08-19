@extends('layouts.master')

@section('title', 'Web Audit - Profil Saya')

@section('content')
<!-- Header Section -->
<div class="flex items-center space-x-3 pb-4 border-b border-slate-100 mb-6">
    <div class="p-1.5 bg-white border border-slate-200 rounded-lg text-indigo-600 shadow-3xs">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
    </div>
    <div>
        <h1 class="text-xl font-bold text-slate-900 tracking-tight">Profil Saya</h1>
        <p class="text-[10px] text-slate-500">Kelola dan perbarui informasi profil pribadi Anda di dalam sistem.</p>
    </div>
</div>

<div class="max-w-md mx-auto">
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

    <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-2xs space-y-6">
        <div>
            <h2 class="text-sm font-bold text-slate-800">Ubah Informasi Profil</h2>
            <p class="text-[10px] text-slate-400 mt-0.5">Tanda bintang merah (<span class="text-rose-500">*</span>) menunjukkan kolom yang wajib diisi.</p>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Name Input -->
            <div>
                <label for="name" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wide">Nama Pengguna <span class="text-rose-500">*</span></label>
                <input type="text" id="name" name="name" required value="{{ old('name', $user->name) }}" class="mt-1.5 w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all">
                @error('name')
                    <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email Input -->
            <div>
                <label for="email" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wide">Alamat Email <span class="text-rose-500">*</span></label>
                <input type="email" id="email" name="email" required value="{{ old('email', $user->email) }}" class="mt-1.5 w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all">
                @error('email')
                    <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Phone Input -->
            <div>
                <label for="phone" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wide">Nomor Telepon</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="mt-1.5 w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all" placeholder="Contoh: 08123456789">
                @error('phone')
                    <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Address Input -->
            <div>
                <label for="address" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wide">Alamat Tinggal</label>
                <textarea id="address" name="address" rows="2" class="mt-1.5 w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all" placeholder="Alamat lengkap tinggal...">{{ old('address', $user->address) }}</textarea>
                @error('address')
                    <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Photo Input -->
            <div>
                <label for="photo" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wide">Foto Profil</label>
                <div class="flex items-center space-x-3 mt-2 mb-3">
                    @if($user->photo)
                        <img src="{{ Storage::url($user->photo) }}" alt="Foto Profil" class="w-12 h-12 rounded-full object-cover border border-slate-200">
                    @else
                        <div class="w-12 h-12 rounded-full bg-indigo-600/10 text-indigo-600 flex items-center justify-center font-bold text-sm">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                    @endif
                    <div class="flex flex-col">
                        <span class="text-[10px] font-semibold text-slate-600">Unggah Foto Baru</span>
                        <span class="text-[8px] text-slate-400">JPEG, PNG, JPG, GIF (Maks. 2MB)</span>
                    </div>
                </div>
                <input type="file" id="photo" name="photo" accept="image/*" class="mt-1.5 w-full text-xs text-slate-400 file:mr-2 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:bg-slate-100 file:text-slate-650 hover:file:bg-slate-200 file:transition-colors bg-slate-50 border border-slate-200 rounded-xl p-1">
                @error('photo')
                    <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password Input -->
            <div>
                <label for="password" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wide">Kata Sandi Baru</label>
                <input type="password" id="password" name="password" class="mt-1.5 w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all" placeholder="Biarkan kosong jika tidak ingin diubah">
                @error('password')
                    <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-2">
                <a href="/" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition-colors">Batal</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-2xs transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
