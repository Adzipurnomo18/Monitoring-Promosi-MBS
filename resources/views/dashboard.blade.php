<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard - Monitoring Promosi | Mitra Bangunan Supermarket</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            background-color: #f8fafc;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 flex flex-col">

    <!-- Top Navigation -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo-transparent.png') }}" alt="MBS Logo" class="h-10 w-auto" onerror="this.src='{{ asset('images/logo.png') }}'">
                <div class="border-l border-slate-200 pl-3">
                    <h1 class="text-sm font-bold text-slate-900 leading-none">Monitoring Promosi</h1>
                    <span class="text-[11px] text-slate-500 font-medium">Mitra Bangunan Supermarket</span>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="hidden sm:flex flex-col text-right">
                    <span class="text-xs font-semibold text-slate-800">{{ auth()->user()->name ?? 'Administrator' }}</span>
                    <span class="text-[11px] text-slate-500">{{ auth()->user()->email ?? 'admin@mitrabangunan.com' }}</span>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-3.5 py-1.5 rounded-lg border border-slate-200 hover:bg-slate-50 text-xs font-semibold text-slate-700 transition-colors flex items-center gap-1.5 cursor-pointer">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                        </svg>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if (session('status'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center justify-between">
                <span>{{ session('status') }}</span>
                <span class="text-xs font-semibold text-emerald-600">Aktif</span>
            </div>
        @endif

        <!-- Welcome Banner -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-[#0056b3] to-[#0070e0] text-white p-8 shadow-lg mb-8">
            <div class="relative z-10 max-w-2xl">
                <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-medium mb-3">
                    Sistem Informasi Internal
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Selamat Datang di Monitoring Promosi
                </h2>
                <p class="mt-2 text-blue-100 text-sm leading-relaxed">
                    Kelola dan pantau seluruh program promosi supplier, realisasi di toko, verifikasi dokumen, serta tagihan secara real-time.
                </p>
            </div>
            <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
        </div>

        <!-- Metric Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Program Aktif</span>
                    <span class="w-8 h-8 rounded-lg bg-blue-50 text-[#0070e0] flex items-center justify-center font-bold text-xs">01</span>
                </div>
                <div class="text-3xl font-extrabold text-slate-900">24</div>
                <p class="text-xs text-slate-500 mt-1">Program promosi supplier berjalan</p>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Menunggu Verifikasi</span>
                    <span class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-xs">02</span>
                </div>
                <div class="text-3xl font-extrabold text-amber-600">8</div>
                <p class="text-xs text-slate-500 mt-1">Dokumen realisasi promosi perlu dicek</p>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Status Tagihan</span>
                    <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-xs">03</span>
                </div>
                <div class="text-3xl font-extrabold text-emerald-600">100%</div>
                <p class="text-xs text-slate-500 mt-1">Sistem pencatatan tagihan sinkron</p>
            </div>
        </div>
    </main>

</body>
</html>
