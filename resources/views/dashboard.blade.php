<!DOCTYPE html>
<html lang="id" class="h-full bg-[#0a1120]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard Promosi - Monitoring Promosi | MBS Group</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Stylesheets -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        :root {
            --font-sans: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }

        body {
            font-family: var(--font-sans);
            background-color: #0b1325;
            color: #cbd5e1;
        }

        /* Custom Scrollbars */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #09101f;
        }
        ::-webkit-scrollbar-thumb {
            background: #1e293b;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #334155;
        }

        /* Subtle Glow & Card Styles */
        .dashboard-card {
            background-color: #111c34;
            border: 1px solid rgba(255, 255, 255, 0.07);
        }

        .dashboard-card-hover {
            transition: all 0.2s ease-in-out;
        }
        .dashboard-card-hover:hover {
            border-color: rgba(56, 189, 248, 0.25);
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="h-full flex overflow-hidden text-slate-300">

    <!-- ============================================================== -->
    <!-- 1. LEFT SIDEBAR NAVIGATION -->
    <!-- ============================================================== -->
    <aside class="w-64 bg-[#08101e] border-r border-slate-800/80 flex flex-col justify-between shrink-0 select-none z-30">
        
        <!-- Top: Logo & Nav Menus -->
        <div class="overflow-y-auto py-5 px-3">
            
            <!-- Brand Header -->
            <div class="flex items-center gap-3 px-3 mb-7">
                <!-- MB Gold/Orange Badge -->
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center font-black text-slate-950 text-base shadow-md shadow-amber-500/20">
                    MB
                </div>
                <div class="leading-tight">
                    <h2 class="text-sm font-bold text-white tracking-tight">Monitoring Promosi</h2>
                    <span class="text-[11px] text-slate-400 font-medium">MBS Group</span>
                </div>
            </div>

            <!-- Group 1: MONITORING -->
            <div class="mb-6">
                <div class="text-[10px] uppercase font-bold tracking-wider text-slate-500 px-3 mb-2">
                    Monitoring
                </div>
                <nav class="space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-[#0070e0] text-white font-semibold text-xs transition-colors shadow-sm shadow-blue-500/30">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                        </svg>
                        <span>Dashboard</span>
                    </a>
                </nav>
            </div>

            <!-- Group 2: TRANSAKSI -->
            <div class="mb-6">
                <div class="text-[10px] uppercase font-bold tracking-wider text-slate-500 px-3 mb-2">
                    Transaksi
                </div>
                <nav class="space-y-1">
                    <a href="{{ route('program.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/60 font-medium text-xs transition-colors">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm0 5.25h.007v.008H3.75V12zm0 5.25h.007v.008H3.75v-.008z" />
                        </svg>
                        <span>Program Promo</span>
                    </a>

                    <a href="{{ route('program.create') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/60 font-medium text-xs transition-colors">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Buat Program</span>
                    </a>

                    <a href="{{ route('realisasi.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/60 font-medium text-xs transition-colors">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Realisasi &amp; Verifikasi</span>
                    </a>

                    <a href="{{ route('tagihan.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/60 font-medium text-xs transition-colors">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                        <span>Tagihan AR</span>
                    </a>
                </nav>
            </div>

            <!-- Group 3: MASTER DATA -->
            <div class="mb-6">
                <div class="text-[10px] uppercase font-bold tracking-wider text-slate-500 px-3 mb-2">
                    Master Data
                </div>
                <nav class="space-y-1">
                    <a href="{{ route('master.metode') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/60 font-medium text-xs transition-colors">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                        </svg>
                        <span>Metode Kesepakatan</span>
                    </a>

                    <a href="{{ route('master.event') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/60 font-medium text-xs transition-colors">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                        <span>Event Promosi</span>
                    </a>

                    <a href="{{ route('master.sarana') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/60 font-medium text-xs transition-colors">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.25A2.25 2.25 0 010 18.75V8.25A2.25 2.25 0 012.25 6h19.5A2.25 2.25 0 0124 8.25v10.5A2.25 2.25 0 0121.75 21h-4.5z" />
                        </svg>
                        <span>Sarana Promosi</span>
                    </a>

                    <a href="{{ route('master.supplier') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/60 font-medium text-xs transition-colors">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-4.243l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                        </svg>
                        <span>Supplier &amp; Customer AR</span>
                    </a>
                </nav>
            </div>

        </div>

        <!-- Bottom: User Profile Widget -->
        <div class="p-3 border-t border-slate-800/80 bg-[#060c18]">
            <div class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-800/50 transition-colors cursor-pointer group">
                <div class="flex items-center gap-2.5">
                    <!-- Circle Avatar AP -->
                    <div class="w-8 h-8 rounded-full bg-blue-700/80 text-white font-bold text-xs flex items-center justify-center shrink-0 border border-blue-400/30">
                        AP
                    </div>
                    <div class="leading-tight">
                        <div class="text-xs font-bold text-white group-hover:text-blue-400 transition-colors">
                            {{ auth()->user()->name ?? 'Adzi Purnomo' }}
                        </div>
                        <div class="text-[10px] text-slate-400 font-medium">
                            Admin Promosi · HO
                        </div>
                    </div>
                </div>
                <!-- Logout Form Trigger -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" title="Keluar dari sistem" class="text-slate-500 hover:text-red-400 transition-colors p-1 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>

    </aside>

    <!-- ============================================================== -->
    <!-- 2. MAIN CONTENT AREA -->
    <!-- ============================================================== -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto bg-[#0b1325]">

        <!-- TOP BAR (Breadcrumb, Title, Data Contoh, Sync Status, Unduh Excel) -->
        <header class="px-6 sm:px-8 pt-6 pb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-0.5">
                    Monitoring
                </div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-white tracking-tight">
                    Dashboard Promosi
                </h1>
            </div>

            <div class="flex items-center flex-wrap gap-3 text-xs">
                <!-- Data Contoh Badge -->
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[11px] font-semibold bg-amber-500/15 text-amber-300 border border-amber-500/30">
                    Data contoh
                </span>

                <!-- Sync Info -->
                <span class="text-slate-400 text-[11px] hidden lg:inline-block">
                    POS diperbarui 12 Okt 06.00 · Oracle AR 12 Okt 07.00
                </span>

                <!-- Unduh Excel Button -->
                <button type="button" class="px-3.5 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-white font-semibold text-xs border border-slate-700 flex items-center gap-1.5 transition-colors cursor-pointer shadow-sm">
                    <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    <span>Unduh Excel</span>
                </button>
            </div>
        </header>

        <!-- MAIN DASHBOARD BODY -->
        <main class="px-6 sm:px-8 pb-12 space-y-6">

            <!-- ---------------------------------------------------------- -->
            <!-- GLOBAL FILTER CONTAINER -->
            <!-- ---------------------------------------------------------- -->
            <div class="dashboard-card rounded-2xl p-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                    
                    <!-- Periode Dropdown -->
                    <div>
                        <label class="block text-[11px] font-medium text-slate-400 mb-1">Periode (mulai program)</label>
                        <select class="w-full bg-[#0a1120] border border-slate-700 text-white text-xs rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500">
                            <option value="2026" selected>Tahun 2026</option>
                            <option value="2025">Tahun 2025</option>
                            <option value="q1_2026">Kuartal 1 2026</option>
                            <option value="q2_2026">Kuartal 2 2026</option>
                        </select>
                    </div>

                    <!-- Perusahaan Dropdown -->
                    <div>
                        <label class="block text-[11px] font-medium text-slate-400 mb-1">Perusahaan</label>
                        <select class="w-full bg-[#0a1120] border border-slate-700 text-white text-xs rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500">
                            <option value="" selected>Semua perusahaan</option>
                            @foreach ($perusahaanList as $p)
                                <option value="{{ $p->id }}">{{ $p->nama_perusahaan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Outlet Dropdown -->
                    <div>
                        <label class="block text-[11px] font-medium text-slate-400 mb-1">Outlet</label>
                        <select class="w-full bg-[#0a1120] border border-slate-700 text-white text-xs rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500">
                            <option value="" selected>Semua outlet</option>
                            @foreach ($outletList as $o)
                                <option value="{{ $o->id }}">{{ $o->nama_outlet }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Supplier Dropdown -->
                    <div>
                        <label class="block text-[11px] font-medium text-slate-400 mb-1">Supplier</label>
                        <select class="w-full bg-[#0a1120] border border-slate-700 text-white text-xs rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500">
                            <option value="" selected>Semua supplier</option>
                            @foreach ($supplierList as $s)
                                <option value="{{ $s->id }}">{{ $s->nama_supplier }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Reset Filter Button -->
                    <div class="flex items-end">
                        <button type="button" class="w-full bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white border border-slate-700 text-xs font-medium py-2 rounded-lg transition-colors cursor-pointer">
                            Reset filter
                        </button>
                    </div>

                </div>

                <!-- Filter Status Text -->
                <div class="text-[11px] text-slate-400 mt-3 pt-2 border-t border-slate-800/80 flex items-center gap-1.5">
                    <span>Menampilkan: <strong>Tahun 2026</strong> · Semua perusahaan · Semua outlet · Semua supplier</span>
                </div>
            </div>

            <!-- ---------------------------------------------------------- -->
            <!-- TOP 4 KPI CARDS -->
            <!-- ---------------------------------------------------------- -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                
                <!-- Card 1: Program Berjalan -->
                <div class="dashboard-card dashboard-card-hover rounded-2xl p-5">
                    <div class="text-xs text-slate-400 font-medium mb-1">Program berjalan</div>
                    <div class="text-3xl font-extrabold text-white tracking-tight">
                        {{ $summary->total_program_berjalan }}
                    </div>
                    <div class="text-xs text-slate-400 mt-2">
                        {{ $summary->program_berakhir_7_hari }} program berakhir 7 hari ke depan
                    </div>
                </div>

                <!-- Card 2: Realisasi Belum Ditagih -->
                <div class="dashboard-card dashboard-card-hover rounded-2xl p-5">
                    <div class="text-xs text-slate-400 font-medium mb-1">Realisasi belum ditagih</div>
                    <div class="text-3xl font-extrabold text-white tracking-tight">
                        Rp {{ number_format($summary->realisasi_belum_ditagih / 1000000, 1, ',', '.') }} jt
                    </div>
                    <div class="text-xs text-slate-400 mt-2">
                        {{ $summary->program_masuk_akrual }} program · masuk akrual
                    </div>
                </div>

                <!-- Card 3: Tagihan Belum Lunas -->
                <div class="dashboard-card dashboard-card-hover rounded-2xl p-5">
                    <div class="text-xs text-slate-400 font-medium mb-1">Tagihan belum lunas</div>
                    <div class="text-3xl font-extrabold text-white tracking-tight">
                        Rp {{ number_format($summary->tagihan_belum_lunas / 1000000, 1, ',', '.') }} jt
                    </div>
                    <div class="text-xs text-slate-400 mt-2">
                        {{ $summary->invoice_belum_lunas }} invoice · Rp {{ number_format($summary->tagihan_lewat_30_hari / 1000000, 1, ',', '.') }} jt lewat jatuh tempo &gt; 30 hari
                    </div>
                </div>

                <!-- Card 4: Diterima Tahun 2026 -->
                <div class="dashboard-card dashboard-card-hover rounded-2xl p-5">
                    <div class="text-xs text-slate-400 font-medium mb-1">Diterima · Tahun 2026</div>
                    <div class="text-3xl font-extrabold text-white tracking-tight">
                        Rp {{ number_format($summary->diterima_tahun_berjalan / 1000000000, 2, ',', '.') }} M
                    </div>
                    <div class="text-xs text-slate-400 mt-2">
                        {{ $summary->total_pembayaran_selesai }} pembayaran · Transfer BCA &amp; kas
                    </div>
                </div>

            </div>

            <!-- ---------------------------------------------------------- -->
            <!-- WORKFLOW PIPELINE: ALUR PROGRAM PER TAHAP -->
            <!-- ---------------------------------------------------------- -->
            <div class="dashboard-card rounded-2xl p-5">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-sm font-bold text-white tracking-tight">Alur program per tahap</h2>
                        <p class="text-xs text-slate-400 mt-0.5">
                            Jumlah program, nilai, dan lama rata-rata di tahap tersebut · <span class="text-amber-400 font-medium">kartu oranye = tahap paling lama</span>
                        </p>
                    </div>
                    <a href="{{ route('program.index') }}" class="text-xs text-blue-400 hover:text-blue-300 hover:underline font-semibold transition-colors">
                        Lihat semua program
                    </a>
                </div>

                <!-- Pipeline Grid: Row 1 (8 cards) & Row 2 (2 cards) -->
                <div class="space-y-3">
                    
                    <!-- Row 1: Draft to Siap Tagih -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-2.5">
                        @foreach ($stages->take(8) as $stage)
                            <div class="bg-[#0b1426] rounded-xl p-3 border {{ $stage->is_terlama ? 'border-amber-500/80 shadow-md shadow-amber-500/10' : 'border-slate-800' }} hover:border-slate-700 transition-all flex flex-col justify-between">
                                <div>
                                    <!-- Stage Pill Badge -->
                                    <span class="inline-block text-[10px] font-semibold px-2 py-0.5 rounded-md mb-2
                                        @if($stage->kode_tahap === 'draft') bg-slate-800 text-slate-300
                                        @elseif($stage->kode_tahap === 'diajukan') bg-blue-900/60 text-blue-300
                                        @elseif($stage->kode_tahap === 'disetujui') bg-teal-900/60 text-teal-300
                                        @elseif($stage->kode_tahap === 'berjalan') bg-emerald-900/60 text-emerald-300
                                        @elseif($stage->kode_tahap === 'realisasi' || $stage->kode_tahap === 'verifikasi') bg-amber-900/50 text-amber-300
                                        @elseif($stage->kode_tahap === 'konfirmasi_supplier') bg-purple-900/60 text-purple-300
                                        @elseif($stage->kode_tahap === 'siap_tagih') bg-amber-500/20 text-amber-300 border border-amber-500/40
                                        @endif
                                    ">
                                        {{ $stage->nama_tahap }}
                                    </span>
                                    
                                    <div class="text-xl font-extrabold text-white">
                                        {{ $stage->total_program }}
                                    </div>
                                    <div class="text-xs font-semibold text-slate-300 mt-0.5">
                                        Rp {{ number_format($stage->total_nilai / 1000000, 1, ',', '.') }} jt
                                    </div>
                                </div>

                                <div class="text-[10px] mt-2 pt-2 border-t border-slate-800/80 {{ $stage->is_terlama ? 'text-amber-400 font-semibold' : 'text-slate-500' }}">
                                    {{ $stage->keterangan_waktu }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Row 2: Ditagih & Lunas -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-8 gap-2.5">
                        @foreach ($stages->slice(8) as $stage)
                            <div class="bg-[#0b1426] rounded-xl p-3 border border-slate-800 hover:border-slate-700 transition-all flex flex-col justify-between lg:col-span-1">
                                <div>
                                    <span class="inline-block text-[10px] font-semibold px-2 py-0.5 rounded-md mb-2
                                        @if($stage->kode_tahap === 'ditagih') bg-cyan-900/60 text-cyan-300
                                        @elseif($stage->kode_tahap === 'lunas') bg-emerald-900/60 text-emerald-300
                                        @endif
                                    ">
                                        {{ $stage->nama_tahap }}
                                    </span>
                                    
                                    <div class="text-xl font-extrabold text-white">
                                        {{ $stage->total_program }}
                                    </div>
                                    <div class="text-xs font-semibold text-slate-300 mt-0.5">
                                        Rp {{ number_format($stage->total_nilai / 1000000, 1, ',', '.') }} jt
                                    </div>
                                </div>

                                <div class="text-[10px] text-slate-500 mt-2 pt-2 border-t border-slate-800/80">
                                    {{ $stage->keterangan_waktu }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>

            <!-- ---------------------------------------------------------- -->
            <!-- MIDDLE ROW (2 WIDGETS): PERLU TINDAKAN & AGING AR -->
            <!-- ---------------------------------------------------------- -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                
                <!-- Left Widget: PERLU TINDAKAN (7 cols) -->
                <div class="dashboard-card rounded-2xl p-5 lg:col-span-7 flex flex-col justify-between">
                    <div>
                        <h2 class="text-sm font-bold text-white tracking-tight">Perlu tindakan</h2>
                        <p class="text-xs text-slate-400 mt-0.5 mb-4">
                            Muncul otomatis bila melewati batas waktu (SLA), juga dikirim lewat WA/email ke PIC
                        </p>

                        <!-- Items List -->
                        <div class="space-y-3">
                            @foreach ($perluTindakan as $item)
                                <div class="bg-[#0b1426] rounded-xl p-3.5 border border-slate-800/90 flex items-center justify-between gap-4 hover:border-slate-700 transition-colors">
                                    <div class="flex items-start gap-3 min-w-0">
                                        <!-- Badge Tag Kategori -->
                                        <span class="inline-block shrink-0 text-[10px] font-bold px-2.5 py-1 rounded-md
                                            @if($item->kategori === 'Kritis') bg-red-950/80 text-red-400 border border-red-800/50
                                            @elseif($item->kategori === 'Penting') bg-amber-950/80 text-amber-400 border border-amber-800/50
                                            @elseif($item->kategori === 'Perhatian') bg-yellow-950/80 text-yellow-300 border border-yellow-800/50
                                            @elseif($item->kategori === 'Info') bg-blue-950/80 text-blue-400 border border-blue-800/50
                                            @endif
                                        ">
                                            {{ $item->kategori }}
                                        </span>

                                        <div class="min-w-0">
                                            <h4 class="text-xs font-bold text-white truncate">
                                                {{ $item->judul }}
                                            </h4>
                                            <p class="text-[11px] text-slate-400 mt-0.5 truncate">
                                                {{ $item->rincian }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Action Button Buka -->
                                    <a href="{{ $item->link_url }}" class="shrink-0 px-3 py-1 bg-slate-800 hover:bg-slate-700 text-white font-medium text-xs rounded-lg border border-slate-700 transition-colors">
                                        Buka
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Right Widget: UMUR TAGIHAN & SUPPLIER AR (5 cols) -->
                <div class="dashboard-card rounded-2xl p-5 lg:col-span-5 flex flex-col justify-between space-y-6">
                    
                    <!-- Section A: Umur Tagihan Belum Lunas -->
                    <div>
                        <h2 class="text-sm font-bold text-white tracking-tight">Umur tagihan belum lunas</h2>
                        <p class="text-xs text-slate-400 mt-0.5 mb-3.5">
                            Total Rp 455,9 jt dari 113 invoice · warna makin gelap = makin lama
                        </p>

                        <!-- Aging Progress Bars -->
                        <div class="space-y-2.5 text-xs">
                            @foreach ($umurTagihan as $aging)
                                <div class="grid grid-cols-12 items-center gap-2">
                                    <div class="col-span-4 text-[11px] text-slate-300 truncate">
                                        {{ $aging->kategori_umur }}
                                    </div>
                                    <div class="col-span-4 bg-slate-800/80 rounded-full h-2 overflow-hidden">
                                        <div class="h-full rounded-full transition-all duration-500
                                            @if($aging->urutan === 1) bg-sky-400
                                            @elseif($aging->urutan === 2) bg-blue-500
                                            @elseif($aging->urutan === 3) bg-indigo-600
                                            @else bg-slate-600
                                            @endif
                                        " style="width: {{ $aging->persentase }}%;"></div>
                                    </div>
                                    <div class="col-span-4 text-right text-[11px] font-semibold text-slate-200">
                                        Rp {{ number_format($aging->total_nilai / 1000000, 1, ',', '.') }} jt
                                        <span class="text-[10px] text-slate-500 font-normal">· {{ $aging->jumlah_invoice }} inv</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Section B: Belum Lunas Per Supplier -->
                    <div class="pt-4 border-t border-slate-800">
                        <h2 class="text-sm font-bold text-white tracking-tight">Belum lunas per supplier</h2>
                        <p class="text-xs text-slate-400 mt-0.5 mb-3.5">
                            Klik nama supplier untuk memfilter dashboard
                        </p>

                        <div class="space-y-2.5 text-xs">
                            @foreach ($supplierAr as $supp)
                                <div class="grid grid-cols-12 items-center gap-2">
                                    <div class="col-span-4 text-[11px] text-slate-300 hover:text-blue-400 cursor-pointer truncate transition-colors">
                                        {{ $supp->nama_supplier }}
                                    </div>
                                    <div class="col-span-4 bg-slate-800/80 rounded-full h-2 overflow-hidden">
                                        <div class="bg-blue-500 h-full rounded-full transition-all duration-500" style="width: {{ $supp->persentase_bar }}%;"></div>
                                    </div>
                                    <div class="col-span-4 text-right text-[11px] font-semibold text-slate-200">
                                        Rp {{ number_format($supp->total_nilai / 1000000, 1, ',', '.') }} jt
                                        <span class="text-[10px] text-slate-500 font-normal">· {{ $supp->jumlah_invoice }} inv</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

            </div>

            <!-- ---------------------------------------------------------- -->
            <!-- BOTTOM TABLE: RINGKASAN PER OUTLET -->
            <!-- ---------------------------------------------------------- -->
            <div class="dashboard-card rounded-2xl p-5 overflow-hidden">
                <div class="mb-4">
                    <h2 class="text-sm font-bold text-white tracking-tight">Ringkasan per outlet</h2>
                    <p class="text-xs text-slate-400 mt-0.5">
                        Klik nama outlet untuk memfilter · satu program bisa berjalan di beberapa outlet, jadi kolom program tidak dijumlahkan
                    </p>
                </div>

                <!-- Table Container -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="border-b border-slate-800 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">
                                <th class="py-3 px-3">Outlet</th>
                                <th class="py-3 px-3">Perusahaan</th>
                                <th class="py-3 px-3">OU</th>
                                <th class="py-3 px-3 text-right">Program berjalan</th>
                                <th class="py-3 px-3 text-right">Realisasi belum ditagih</th>
                                <th class="py-3 px-3 text-right">Tagihan belum lunas</th>
                                <th class="py-3 px-3 text-center">Konfirmasi realisasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/60 font-medium">
                            @foreach ($outletSummary as $row)
                                <tr class="hover:bg-slate-800/40 transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-400 hover:underline cursor-pointer">
                                        {{ $row->nama_outlet }}
                                    </td>
                                    <td class="py-3 px-3 text-slate-300">
                                        {{ $row->nama_perusahaan }}
                                    </td>
                                    <td class="py-3 px-3 text-slate-400 font-mono text-[11px]">
                                        {{ $row->ou_code }}
                                    </td>
                                    <td class="py-3 px-3 text-right text-slate-200">
                                        {{ $row->program_berjalan }}
                                    </td>
                                    <td class="py-3 px-3 text-right text-slate-200">
                                        Rp {{ number_format($row->realisasi_belum_ditagih / 1000000, 1, ',', '.') }} jt
                                    </td>
                                    <td class="py-3 px-3 text-right text-slate-200">
                                        Rp {{ number_format($row->tagihan_belum_lunas / 1000000, 1, ',', '.') }} jt
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-amber-950/70 text-amber-300 border border-amber-800/40">
                                            {{ $row->status_konfirmasi }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach

                            <!-- Total Row -->
                            <tr class="border-t-2 border-slate-700 font-extrabold text-white bg-slate-900/60">
                                <td class="py-3 px-3" colspan="4">Total</td>
                                <td class="py-3 px-3 text-right text-white">
                                    Rp {{ number_format($outletSummary->sum('realisasi_belum_ditagih') / 1000000, 1, ',', '.') }} jt
                                </td>
                                <td class="py-3 px-3 text-right text-white">
                                    Rp {{ number_format($outletSummary->sum('tagihan_belum_lunas') / 1000000, 1, ',', '.') }} jt
                                </td>
                                <td class="py-3 px-3"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </main>

    </div>

</body>
</html>
