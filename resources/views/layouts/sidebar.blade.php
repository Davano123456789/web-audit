<!-- Sidebar Container -->
<aside id="sidebar-container" class="fixed inset-y-0 left-0 w-64 bg-slate-900 border-r border-slate-800 text-slate-400 select-none z-50 transform -translate-x-full lg:translate-x-0 lg:static lg:flex lg:flex-col transition-transform duration-300 ease-in-out">
    
    <!-- Branding Header -->
    <div class="h-16 flex items-center justify-between px-6 border-b border-slate-800 bg-slate-950/40">
        <a href="/" class="flex items-center space-x-3 group">
            <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center shadow-md shadow-indigo-600/20 group-hover:scale-105 transition-transform duration-200">
                <!-- Glowing audit shield SVG icon -->
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <div class="flex flex-col">
                <span class="text-sm font-bold text-white tracking-wide group-hover:text-indigo-400 transition-colors">Web Audit</span>
            </div>
        </a>

        <!-- Mobile Close Button -->
        <button id="mobile-sidebar-close" class="lg:hidden p-1.5 rounded-md hover:bg-slate-800 text-slate-500 hover:text-slate-200 transition-colors" title="Tutup Menu">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Navigation Menu Items -->
    <div class="flex-1 overflow-y-auto px-4 py-6 space-y-7">
        
            <!-- Navigation Group: MAIN -->
            <div>
                <div class="px-3 text-[10px] font-semibold text-slate-500 uppercase tracking-widest mb-3">Menu Utama</div>
                <div class="space-y-1">
                    
                    <!-- Dashboard Link -->
                    <a href="/" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium hover:bg-slate-800/60 hover:text-slate-100 transition-all duration-200 group {{ request()->is('/') ? 'bg-slate-800 text-white' : '' }}">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    @if(auth()->user()->role === 'admin')
                        <!-- Domain COBIT -->
                        <a href="{{ route('admin.domains.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium hover:bg-slate-800/60 hover:text-slate-100 transition-all duration-200 group {{ request()->routeIs('admin.domains.*') ? 'bg-slate-800 text-white' : '' }}">
                            <svg class="w-5 h-5 text-slate-500 group-hover:text-slate-300 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                            </svg>
                            <span>Domain COBIT</span>
                        </a>

                        <!-- Proses TI/IT -->
                        <a href="{{ route('admin.processes.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium hover:bg-slate-800/60 hover:text-slate-100 transition-all duration-200 group {{ request()->routeIs('admin.processes.*') ? 'bg-slate-800 text-white' : '' }}">
                            <svg class="w-5 h-5 text-slate-500 group-hover:text-slate-300 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span>Proses TI</span>
                        </a>

                        <!-- Pertanyaan -->
                        <a href="{{ route('admin.questions.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium hover:bg-slate-800/60 hover:text-slate-100 transition-all duration-200 group {{ request()->routeIs('admin.questions.*') ? 'bg-slate-800 text-white' : '' }}">
                            <svg class="w-5 h-5 text-slate-500 group-hover:text-slate-300 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Pertanyaan</span>
                        </a>

                        <!-- Pengguna -->
                        <a href="{{ route('admin.asesors.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium hover:bg-slate-800/60 hover:text-slate-100 transition-all duration-200 group {{ request()->routeIs('admin.asesors.*') ? 'bg-slate-800 text-white' : '' }}">
                            <svg class="w-5 h-5 text-slate-500 group-hover:text-slate-300 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>Pengguna</span>
                        </a>
                    @endif

                    <!-- Profil Saya -->
                    <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium hover:bg-slate-800/60 hover:text-slate-100 transition-all duration-200 group {{ request()->routeIs('profile.*') ? 'bg-slate-800 text-white' : '' }}">
                        <svg class="w-5 h-5 text-slate-500 group-hover:text-slate-300 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>Profil Saya</span>
                    </a>

                </div>
            </div>

            <!-- Navigation Group: ASSESSMENT -->
            <div>
                <div class="px-3 text-[10px] font-semibold text-slate-500 uppercase tracking-widest mb-3">Assessment</div>
                <div class="space-y-1">
                    
                    <!-- Proyek -->
                    <a href="{{ route('admin.projects.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium hover:bg-slate-800/60 hover:text-slate-100 transition-all duration-200 group {{ request()->routeIs('admin.projects.*') ? 'bg-slate-800 text-white' : '' }}">
                        <svg class="w-5 h-5 text-slate-500 group-hover:text-slate-300 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span>Proyek</span>
                    </a>

                </div>
            </div>

    </div>

    <!-- Active User Sidebar Profile Profile -->
    <div class="p-4 border-t border-slate-800 bg-slate-950/20 flex items-center justify-between">
        <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 group min-w-0 flex-1">
            @if(auth()->user()->photo)
                <img src="{{ Storage::url(auth()->user()->photo) }}" alt="Foto Profil" class="w-9 h-9 rounded-full object-cover border border-slate-700 shadow-sm group-hover:border-indigo-500 transition-colors">
            @else
                <div class="w-9 h-9 rounded-full bg-indigo-600 border border-indigo-500 flex items-center justify-center font-bold text-white text-xs shadow-sm group-hover:scale-105 transition-transform">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
            @endif
            <div class="flex flex-col min-w-0">
                <span class="text-xs font-semibold text-slate-200 truncate group-hover:text-white transition-colors">{{ auth()->user()->name }}</span>
                <span class="text-[10px] text-slate-500 truncate group-hover:text-slate-400 transition-colors">{{ auth()->user()->email }}</span>
            </div>
        </a>
        
        <!-- Logout button -->
        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="p-1.5 rounded-md hover:bg-slate-800 text-slate-500 hover:text-red-400 transition-colors" title="Keluar">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </button>
        </form>
    </div>

</aside>

<!-- Mobile Sidebar Backdrop Overlay -->
<div id="sidebar-backdrop" class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-40 hidden transition-opacity duration-300 opacity-0 lg:hidden"></div>
