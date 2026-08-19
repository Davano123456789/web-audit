@extends('layouts.master')

@section('title', 'Web Audit - Perbarui Akun Asesor')

@section('content')
<!-- Header Section -->
<div class="flex items-center space-x-3 pb-4 border-b border-slate-100 mb-6">
    <a href="{{ route('admin.asesors.index') }}" class="p-1.5 bg-white border border-slate-200 rounded-lg text-slate-400 hover:text-slate-600 transition-colors shadow-3xs" title="Kembali ke Daftar">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
    </a>
    <div>
        <h1 class="text-xl font-bold text-slate-900 tracking-tight">Perbarui Akun Pengguna</h1>
        <p class="text-[10px] text-slate-500">Ubah informasi nama, alamat email, foto profil, atau perbarui kata sandi akun.</p>
    </div>
</div>

<div class="max-w-md mx-auto">
    <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-2xs space-y-6">
        <div>
            <h2 class="text-sm font-bold text-slate-800">Formulir Pembaruan Akun</h2>
            <p class="text-[10px] text-slate-400 mt-0.5">Tanda bintang merah (<span class="text-rose-500">*</span>) menunjukkan kolom yang wajib diisi.</p>
        </div>

        <form action="{{ route('admin.asesors.update', $asesor->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Name Input -->
            <div>
                <label for="name" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wide">Nama Pengguna <span class="text-rose-500">*</span></label>
                <input type="text" id="name" name="name" required value="{{ old('name', $asesor->name) }}" class="mt-1.5 w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all" placeholder="Contoh: joko_sahara">
            </div>

            <!-- Email Input -->
            <div>
                <label for="email" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wide">Alamat Email <span class="text-rose-500">*</span></label>
                <input type="email" id="email" name="email" required value="{{ old('email', $asesor->email) }}" class="mt-1.5 w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all" placeholder="asesor@webaudit.com">
            </div>

            <!-- Phone Input -->
            <div>
                <label for="phone" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wide">Nomor Telepon</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', $asesor->phone) }}" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="mt-1.5 w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all" placeholder="Contoh: 08123456789">
            </div>

            <!-- Address Input -->
            <div>
                <label for="address" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wide">Alamat Tinggal</label>
                <textarea id="address" name="address" rows="2" class="mt-1.5 w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all" placeholder="Alamat lengkap tinggal...">{{ old('address', $asesor->address) }}</textarea>
            </div>

            <!-- Photo Input -->
            <div>
                <label for="photo" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wide">Foto Profil</label>
                @if($asesor->photo)
                    <div class="flex items-center space-x-3 mt-2 mb-3">
                        <img src="{{ Storage::url($asesor->photo) }}" alt="Foto Profil" class="w-12 h-12 rounded-full object-cover border border-slate-200">
                        <span class="text-[10px] text-slate-400">Gambar saat ini terpasang</span>
                    </div>
                @endif
                <input type="file" id="photo" name="photo" accept="image/*" class="mt-1.5 w-full text-xs text-slate-400 file:mr-2 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:bg-slate-100 file:text-slate-650 hover:file:bg-slate-200 file:transition-colors bg-slate-50 border border-slate-200 rounded-xl p-1">
            </div>

            <!-- Password Input -->
            <div>
                <label for="password" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wide">Kata Sandi Baru</label>
                <input type="password" id="password" name="password" class="mt-1.5 w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all" placeholder="Biarkan kosong jika tidak ingin diubah">
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-2">
                <a href="{{ route('admin.asesors.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition-colors">Batal</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-2xs transition-colors">
                    Perbarui Akun
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
