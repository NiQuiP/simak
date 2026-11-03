<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - SIMAK</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <!-- Logo & Header Card -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-indigo-600 text-white shadow-lg shadow-indigo-600/30 text-2xl mb-4">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <h1 class="text-2xl font-bold text-white tracking-tight">SIMAK</h1>
            <p class="text-slate-400 text-sm mt-1">Sistem Informasi Mahasiswa</p>
        </div>

        <div class="bg-white rounded-2xl shadow-2xl p-6 sm:p-8 border border-slate-100">
            <h2 class="text-xl font-bold text-slate-800 mb-1">Selamat Datang</h2>
            <p class="text-xs text-slate-500 mb-6">Silakan masuk menggunakan akun terdaftar Anda.</p>

            @if(session('success'))
                <div class="mb-4 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs flex items-center space-x-2">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->has('email'))
                <div class="mb-4 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs flex items-center space-x-2">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ $errors->first('email') }}</span>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">Alamat Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400 text-sm">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm placeholder:text-slate-400 transition"
                            placeholder="nama@simak.ac.id">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-700 mb-1.5">Kata Sandi</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400 text-sm">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" name="password" id="password" required
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm placeholder:text-slate-400 transition"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-slate-600">Ingat saya</span>
                    </label>
                </div>

                <button type="submit"
                    class="w-full mt-2 py-3 px-4 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm shadow-md shadow-indigo-600/30 transition-all flex items-center justify-center space-x-2">
                    <span>Masuk ke Akun</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </form>

            <!-- Quick Credential Helper -->
            <div class="mt-6 pt-5 border-t border-slate-100">
                <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Akun Uji Coba (Demo):</p>
                <div class="grid grid-cols-1 gap-2 text-xs">
                    <div class="p-2.5 rounded-lg bg-slate-50 border border-slate-200/60 flex items-center justify-between">
                        <div>
                            <span class="font-bold text-slate-700">Admin:</span>
                            <code class="text-indigo-600 ml-1">admin@simak.ac.id</code>
                        </div>
                        <span class="text-slate-400 text-[10px]">pass: password</span>
                    </div>
                    <div class="p-2.5 rounded-lg bg-slate-50 border border-slate-200/60 flex items-center justify-between">
                        <div>
                            <span class="font-bold text-slate-700">Dosen:</span>
                            <code class="text-indigo-600 ml-1">dosen@simak.ac.id</code>
                        </div>
                        <span class="text-slate-400 text-[10px]">pass: password</span>
                    </div>
                    <div class="p-2.5 rounded-lg bg-slate-50 border border-slate-200/60 flex items-center justify-between">
                        <div>
                            <span class="font-bold text-slate-700">Mahasiswa:</span>
                            <code class="text-indigo-600 ml-1">mahasiswa@simak.ac.id</code>
                        </div>
                        <span class="text-slate-400 text-[10px]">pass: password</span>
                    </div>
                </div>
            </div>
        </div>

        <p class="text-center text-xs text-slate-400 mt-6">
            SIMAK &copy; {{ date('Y') }} UTS Pemrograman Web
        </p>
    </div>

</body>
</html>

