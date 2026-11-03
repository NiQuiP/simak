<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SIMAK' }} - Sistem Informasi Mahasiswa</title>
    <!-- Google Fonts Poppins / Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome CDN for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased flex flex-col min-h-screen">

    <div class="flex flex-1 min-h-screen relative overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-slate-900 text-white transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col shadow-xl">
            <!-- Sidebar Header -->
            <div class="h-16 flex items-center justify-between px-6 bg-slate-950/60 border-b border-slate-800">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-600 flex items-center justify-center text-white font-bold shadow-md shadow-indigo-500/20">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <div>
                        <span class="text-lg font-bold tracking-tight text-white block leading-none">SIMAK</span>
                        <span class="text-[10px] text-slate-400 font-medium uppercase tracking-wider">Sistem Akademik</span>
                    </div>
                </div>
                <button id="closeSidebarBtn" class="md:hidden text-slate-400 hover:text-white p-1">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Sidebar Navigation -->
            <div class="flex-1 overflow-y-auto py-5 px-4 space-y-1">
                @php
                    $role = auth()->user()->role ?? '';
                @endphp

                <!-- Role Badge -->
                <div class="mb-4 px-3 py-2 bg-slate-800/80 rounded-xl border border-slate-700/60 flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-full bg-slate-700 flex items-center justify-center text-indigo-400 font-bold text-sm">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="truncate">
                        <p class="text-xs font-semibold text-slate-200 truncate">{{ auth()->user()->name }}</p>
                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold uppercase tracking-wider
                            @if($role === 'admin') bg-rose-500/20 text-rose-300 border border-rose-500/30
                            @elseif($role === 'dosen') bg-emerald-500/20 text-emerald-300 border border-emerald-500/30
                            @else bg-blue-500/20 text-blue-300 border border-blue-500/30 @endif">
                            {{ $role }}
                        </span>
                    </div>
                </div>

                <div class="text-[11px] font-semibold uppercase tracking-wider text-slate-400 px-3 pt-2 pb-1">
                    Menu Utama
                </div>

                @if($role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-gauge-high w-5 text-center mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400' }}"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.prodi.index') }}" class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.prodi.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-shapes w-5 text-center mr-3 {{ request()->routeIs('admin.prodi.*') ? 'text-white' : 'text-slate-400' }}"></i>
                        Program Studi
                    </a>
                    <a href="{{ route('admin.dosen.index') }}" class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.dosen.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-chalkboard-user w-5 text-center mr-3 {{ request()->routeIs('admin.dosen.*') ? 'text-white' : 'text-slate-400' }}"></i>
                        Data Dosen
                    </a>
                    <a href="{{ route('admin.mahasiswa.index') }}" class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.mahasiswa.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-user-graduate w-5 text-center mr-3 {{ request()->routeIs('admin.mahasiswa.*') ? 'text-white' : 'text-slate-400' }}"></i>
                        Data Mahasiswa
                    </a>
                    <a href="{{ route('admin.mata-kuliah.index') }}" class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.mata-kuliah.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-book-bookmark w-5 text-center mr-3 {{ request()->routeIs('admin.mata-kuliah.*') ? 'text-white' : 'text-slate-400' }}"></i>
                        Mata Kuliah
                    </a>

                @elseif($role === 'dosen')
                    <a href="{{ route('dosen.dashboard') }}" class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('dosen.dashboard') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-gauge-high w-5 text-center mr-3 {{ request()->routeIs('dosen.dashboard') ? 'text-white' : 'text-slate-400' }}"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('dosen.mata-kuliah.index') }}" class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('dosen.mata-kuliah.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-chalkboard-user w-5 text-center mr-3 {{ request()->routeIs('dosen.mata-kuliah.*') ? 'text-white' : 'text-slate-400' }}"></i>
                        Mahasiswa per MK
                    </a>
                    <a href="{{ route('dosen.nilai.index') }}" class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('dosen.nilai.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-pen-to-square w-5 text-center mr-3 {{ request()->routeIs('dosen.nilai.*') ? 'text-white' : 'text-slate-400' }}"></i>
                        Input Nilai
                    </a>

                @elseif($role === 'mahasiswa')
                    <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('mahasiswa.dashboard') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-gauge-high w-5 text-center mr-3 {{ request()->routeIs('mahasiswa.dashboard') ? 'text-white' : 'text-slate-400' }}"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('mahasiswa.krs.index') }}" class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('mahasiswa.krs.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-file-signature w-5 text-center mr-3 {{ request()->routeIs('mahasiswa.krs.*') ? 'text-white' : 'text-slate-400' }}"></i>
                        Pengisian KRS
                    </a>
                    <a href="{{ route('mahasiswa.nilai.index') }}" class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('mahasiswa.nilai.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-award w-5 text-center mr-3 {{ request()->routeIs('mahasiswa.nilai.*') ? 'text-white' : 'text-slate-400' }}"></i>
                        Lihat Nilai
                    </a>
                @endif
                <div class="text-[11px] font-semibold uppercase tracking-wider text-slate-400 px-3 pt-4 pb-1">
                    Akun
                </div>
                <a href="{{ route('profile.edit') }}" class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('profile.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-user-gear w-5 text-center mr-3 {{ request()->routeIs('profile.*') ? 'text-white' : 'text-slate-400' }}"></i>
                    Edit Profil
                </a>
            </div>

            <!-- Sidebar Footer -->
            <div class="p-4 border-t border-slate-800">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center space-x-2 px-4 py-2.5 rounded-xl text-sm font-medium text-rose-300 bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/20 transition-colors">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>Keluar (Logout)</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Overlay backdrop for mobile -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-30 hidden md:hidden"></div>

        <!-- Main Content Area -->
        <div class="flex-1 md:pl-64 flex flex-col min-w-0">
            <!-- Topbar -->
            <header class="h-16 bg-white border-b border-slate-200 sticky top-0 z-20 flex items-center justify-between px-4 sm:px-6 shadow-xs">
                <div class="flex items-center space-x-3">
                    <button id="openSidebarBtn" class="md:hidden text-slate-600 hover:text-slate-900 p-2 rounded-lg hover:bg-slate-100">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                    <div>
                        <h1 class="text-base sm:text-lg font-bold text-slate-800 leading-tight">
                            @yield('header-title', 'Dashboard')
                        </h1>
                        <p class="text-xs text-slate-400 hidden sm:block">
                            @yield('header-subtitle', 'Sistem Informasi Mahasiswa')
                        </p>
                    </div>
                </div>

                <div class="flex items-center space-x-3 sm:space-x-4">
                    <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 group text-left">
                        <div class="text-right hidden sm:block">
                            <span class="block text-sm font-semibold text-slate-700 group-hover:text-indigo-600 transition leading-tight">{{ auth()->user()->name }}</span>
                            <span class="block text-xs text-slate-400">{{ auth()->user()->email }}</span>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-indigo-50 border border-indigo-200 text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition flex items-center justify-center font-bold text-sm shadow-xs">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </a>
                </div>
            </header>

            <!-- Alerts / Flash Messages -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto">
                @if(session('success'))
                    <div class="mb-5 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start space-x-3 shadow-xs">
                        <i class="fa-solid fa-circle-check text-emerald-600 mt-0.5 text-lg"></i>
                        <div class="flex-1 text-sm font-medium">
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-5 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-start space-x-3 shadow-xs">
                        <i class="fa-solid fa-circle-exclamation text-rose-600 mt-0.5 text-lg"></i>
                        <div class="flex-1 text-sm font-medium">
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-5 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 shadow-xs">
                        <div class="flex items-center space-x-2 font-semibold text-sm mb-2 text-rose-700">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            <span>Terdapat beberapa kesalahan:</span>
                        </div>
                        <ul class="list-disc list-inside text-xs space-y-1 text-rose-600">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="mt-auto py-4 px-6 border-t border-slate-200 bg-white text-center text-xs text-slate-400">
                &copy; {{ date('Y') }} SIMAK — Sistem Informasi Mahasiswa. UTS Pemrograman Web.
            </footer>
        </div>
    </div>

    <!-- Script for mobile toggle -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const openSidebarBtn = document.getElementById('openSidebarBtn');
        const closeSidebarBtn = document.getElementById('closeSidebarBtn');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function toggleSidebar(open) {
            if (open) {
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
            }
        }

        if (openSidebarBtn) openSidebarBtn.addEventListener('click', () => toggleSidebar(true));
        if (closeSidebarBtn) closeSidebarBtn.addEventListener('click', () => toggleSidebar(false));
        if (sidebarOverlay) sidebarOverlay.addEventListener('click', () => toggleSidebar(false));
    </script>
</body>
</html>

