<!DOCTYPE html>
<html lang="id" x-data="{ temaGelap: localStorage.getItem('temaGelap') === 'true' }" x-init="$watch('temaGelap', val => localStorage.setItem('temaGelap', val))" :class="{ 'dark': temaGelap }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — SIGAP BDG</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: 'class' }</script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>* { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 min-h-screen flex items-center justify-center px-4 transition-colors duration-200">

    <div class="w-full max-w-sm">
        <div class="text-center mb-8">
            <a href="{{ route('beranda') }}" class="inline-flex items-center gap-2 mb-6">
                <div class="w-8 h-8 bg-indigo-600 rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <span class="font-bold text-slate-800 dark:text-white">SIGAP BDG</span>
            </a>
            <h1 class="text-xl font-bold text-slate-900 dark:text-white mb-1">Masuk ke akun Anda</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Khusus pegawai dan administrator terdaftar.</p>
        </div>

        @if($errors->any())
        <div class="mb-5 bg-red-50 dark:bg-red-950/50 border border-red-200 dark:border-red-700/40 rounded-xl px-4 py-3 flex items-start gap-2.5">
            <svg class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="text-sm text-red-600 dark:text-red-400">{{ $errors->first() }}</p>
        </div>
        @endif

        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm">
            <form method="POST" action="{{ route('proses.masuk') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm text-slate-800 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" placeholder="nama@email.com">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Kata Sandi</label>
                    <input type="password" id="password" name="password" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm text-slate-800 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" placeholder="••••••••">
                </div>
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-xl transition shadow-sm mt-1">
                    Masuk
                </button>
            </form>
        </div>

        <div class="mt-5 flex items-center justify-between">
            <p class="text-sm text-slate-500 dark:text-slate-400">
                Belum punya akun?
                <a href="{{ route('daftar') }}" class="text-indigo-600 dark:text-indigo-400 font-medium hover:underline">Daftar</a>
            </p>
            <button @click="temaGelap = !temaGelap" class="flex items-center gap-1.5 text-xs text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition">
                <span x-show="!temaGelap"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg></span>
                <span x-show="temaGelap"><svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/></svg></span>
            </button>
        </div>
    </div>

</body>
</html>