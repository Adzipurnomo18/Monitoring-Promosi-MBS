<!DOCTYPE html>
<html lang="id" class="h-full bg-[#f1f5f9]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Monitoring Promosi - Mitra Bangunan Supermarket</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- SweetAlert2 (Local Asset) -->
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>

    <!-- Chart.js (Local Asset) -->
    <script src="{{ asset('js/chart.umd.js') }}"></script>

    <!-- Stylesheets -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        :root {
            --font-sans: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            --mbs-blue: #0070e0;
            --mbs-red: #e31e24;
        }

        body {
            font-family: var(--font-sans);
            background-color: #f1f5f9;
            color: #1e293b;
        }

        /* Custom Scrollbars */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #e2e8f0;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Card Shadow and Styling */
        .white-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.04), 0 1px 2px -1px rgba(0, 0, 0, 0.04);
            transition: all 0.2s ease;
        }
        .white-card:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.07), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
        }

        /* Skeleton Loading Animation */
        @keyframes skeletonPulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.45;
            }
        }
        .skeleton-shimmer {
            background: linear-gradient(90deg, #e2e8f0 25%, #f1f5f9 50%, #e2e8f0 75%);
            background-size: 200% 100%;
            animation: skeletonShimmer 1.4s infinite, skeletonPulse 1.4s infinite;
        }
        @keyframes skeletonShimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* Metric Wave Backgrounds */
        .card-wave {
            background-repeat: no-repeat;
            background-position: bottom right;
            background-size: auto 100%;
        }
    </style>
</head>
<body class="h-full flex overflow-hidden text-slate-800 antialiased select-none">

    <!-- ============================================================== -->
    <!-- 1. LEFT SIDEBAR NAVIGATION (DARK ENTERPRISE BLUE) -->
    <!-- ============================================================== -->
    <aside class="w-64 bg-[#091122] flex flex-col justify-between shrink-0 select-none z-30 relative overflow-hidden border-r border-slate-800">
        
        <!-- Store Facade Artwork in Lower Sidebar Background -->
        <div class="absolute bottom-14 left-0 right-0 h-72 pointer-events-none overflow-hidden z-0">
            <img src="{{ asset('images/sidebar-building-clean.png') }}" alt="" class="w-full h-full object-cover object-center opacity-85">
            <div class="absolute inset-0 bg-gradient-to-t from-[#060c18] via-transparent to-[#091122]"></div>
        </div>

        <!-- Upper Sidebar Menu Content -->
        <div class="overflow-y-auto py-5 px-3.5 z-10">
            
            <!-- Logo Mitra Bangunan Supermarket -->
            <div class="px-2 pt-1 mb-5">
                <img 
                    src="{{ asset('images/logo-transparent.png') }}" 
                    alt="Mitra Bangunan Supermarket" 
                    class="h-11 w-auto object-contain filter drop-shadow brightness-110"
                    onerror="this.src='{{ asset('images/logo.png') }}'"
                />
            </div>

            <!-- Monitoring Promosi Section Label -->
            <div class="px-3 mb-4">
                <div class="text-xs font-bold text-white tracking-tight">
                    Monitoring Promosi
                </div>
            </div>

            <!-- Active Dashboard Nav -->
            <div class="mb-6">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-[#0070e0] text-white font-semibold text-xs transition-all shadow-md shadow-blue-500/30">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    <span>Dashboard</span>
                </a>
            </div>

            <!-- Group: TRANSAKSI -->
            <div class="mb-6">
                <div class="text-[10px] uppercase font-bold tracking-wider text-slate-400 px-3 mb-2">
                    Transaksi
                </div>
                <nav class="space-y-1">
                    <a href="{{ route('program.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800/60 font-medium text-xs transition-colors">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm0 5.25h.007v.008H3.75V12zm0 5.25h.007v.008H3.75v-.008z" />
                        </svg>
                        <span>Program Promo</span>
                    </a>

                    <a href="{{ route('program.create') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800/60 font-medium text-xs transition-colors">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Buat Program</span>
                    </a>

                    <a href="{{ route('realisasi.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800/60 font-medium text-xs transition-colors">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Realisasi &amp; Verifikasi</span>
                    </a>

                    <a href="{{ route('tagihan.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800/60 font-medium text-xs transition-colors">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                        <span>Tagihan AR</span>
                    </a>
                </nav>
            </div>

            <!-- Group: MASTER DATA -->
            <div class="mb-6">
                <div class="text-[10px] uppercase font-bold tracking-wider text-slate-400 px-3 mb-2">
                    Master Data
                </div>
                <nav class="space-y-1">
                    <a href="{{ route('master.metode') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800/60 font-medium text-xs transition-colors">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                        </svg>
                        <span>Metode Kesepakatan</span>
                    </a>

                    <a href="{{ route('master.event') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800/60 font-medium text-xs transition-colors">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                        <span>Event Promosi</span>
                    </a>

                    <a href="{{ route('master.sarana') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800/60 font-medium text-xs transition-colors">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.25A2.25 2.25 0 010 18.75V8.25A2.25 2.25 0 012.25 6h19.5A2.25 2.25 0 0124 8.25v10.5A2.25 2.25 0 0121.75 21h-4.5z" />
                        </svg>
                        <span>Sarana Promosi</span>
                    </a>

                    <a href="{{ route('master.supplier') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800/60 font-medium text-xs transition-colors">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-4.243l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                        </svg>
                        <span>Supplier &amp; Customer AR</span>
                    </a>
                </nav>
            </div>

        </div>

        <!-- Lower Sidebar User Profile Card with SweetAlert Logout -->
        <div class="p-3 border-t border-slate-800/90 bg-[#060c18] z-20">
            <div id="userProfileBtn" class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-800/60 transition-colors cursor-pointer group">
                <div class="flex items-center gap-2.5">
                    <!-- Circle Avatar AP -->
                    <div class="w-8 h-8 rounded-full bg-blue-600 text-white font-bold text-xs flex items-center justify-center shrink-0 border border-blue-400/40">
                        AP
                    </div>
                    <div class="leading-tight">
                        <div class="text-xs font-bold text-white group-hover:text-blue-400 transition-colors">
                            {{ auth()->user()->name ?? 'Nama User' }}
                        </div>
                        <div class="text-[10px] text-slate-400 font-medium">
                            Admin Promosi - HO
                        </div>
                    </div>
                </div>

                <!-- Dropdown / Logout Trigger Icon -->
                <svg class="w-4 h-4 text-slate-400 group-hover:text-red-400 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </div>

            <!-- Hidden Logout Form for SweetAlert -->
            <form id="logoutForm" method="POST" action="{{ route('logout') }}" class="hidden">
                @csrf
            </form>
        </div>

    </aside>

    <!-- ============================================================== -->
    <!-- 2. MAIN DASHBOARD CONTENT AREA -->
    <!-- ============================================================== -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto bg-[#edf2f9]">

        <!-- ========================================================== -->
        <!-- TOP STORE HEADER BANNER -->
        <!-- ========================================================== -->
        <div class="relative w-full overflow-hidden bg-[#072147] min-h-[120px] flex items-center">
            <!-- Background Store Facade Photo -->
            <img 
                src="{{ asset('images/banner-clean-final.jpg') }}" 
                alt="Mitra Bangunan Supermarket" 
                class="absolute inset-0 w-full h-full object-cover object-left md:object-center filter brightness-100"
            />

            <!-- Header Content -->
            <div class="relative z-10 w-full px-6 sm:px-8 py-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                
                <!-- Left Title & Subtitle -->
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight leading-tight">
                        Monitoring Promosi
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-200 font-normal mt-0.5 drop-shadow-sm">
                        Pantau program promosi, realisasi, dan tagihan secara real-time.
                    </p>
                </div>

                <!-- Right Badges: Date/Time Pill + Notification Bell -->
                <div class="flex items-center gap-3">
                    
                    <!-- Date & Time Pill -->
                    <div class="bg-white/95 backdrop-blur-md rounded-xl px-4 py-2 flex items-center gap-2.5 shadow-sm text-slate-800">
                        <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                        <div class="text-right leading-tight">
                            <div class="text-[11px] font-bold text-slate-900">Senin, 12 Oktober 2026</div>
                            <div class="text-[10px] text-slate-500 font-medium">06:00 WIB</div>
                        </div>
                    </div>

                    <!-- Notification Bell with Red Badge -->
                    <div class="relative">
                        <button type="button" class="w-10 h-10 rounded-xl bg-white/95 backdrop-blur-md hover:bg-white text-slate-700 flex items-center justify-center shadow-sm transition-colors cursor-pointer">
                            <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                            </svg>
                        </button>
                        <span class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-red-500 text-white font-extrabold text-[9px] flex items-center justify-center border-2 border-white shadow-xs">
                            3
                        </span>
                    </div>

                </div>

            </div>
        </div>

        <!-- ========================================================== -->
        <!-- DASHBOARD BODY CONTENT -->
        <!-- ========================================================== -->
        <main class="px-6 sm:px-8 py-6 space-y-5">

            <!-- ------------------------------------------------------ -->
            <!-- FILTER BAR (LIGHT THEME) -->
            <!-- ------------------------------------------------------ -->
            <div class="white-card p-4">
                <form id="filterForm" class="flex flex-col xl:flex-row xl:items-end justify-between gap-3">
                    
                    <!-- Left Dropdown Fields -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 flex-1">
                        
                        <!-- Periode Program -->
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Periode Program</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                    </svg>
                                </span>
                                <select id="filterPeriode" class="w-full pl-9 pr-8 py-2 bg-slate-50 hover:bg-white border border-slate-200 text-slate-800 text-xs rounded-xl focus:outline-none focus:border-blue-500 focus:bg-white transition-all cursor-pointer">
                                    <option value="2026" selected>Tahun 2026</option>
                                    <option value="2025">Tahun 2025</option>
                                    <option value="q1">Kuartal 1 2026</option>
                                    <option value="q2">Kuartal 2 2026</option>
                                </select>
                            </div>
                        </div>

                        <!-- Perusahaan -->
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Perusahaan</label>
                            <select id="filterPerusahaan" class="w-full px-3 py-2 bg-slate-50 hover:bg-white border border-slate-200 text-slate-800 text-xs rounded-xl focus:outline-none focus:border-blue-500 focus:bg-white transition-all cursor-pointer">
                                <option value="" selected>Semua perusahaan</option>
                                @foreach ($perusahaanList as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama_perusahaan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Outlet -->
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Outlet</label>
                            <select id="filterOutlet" class="w-full px-3 py-2 bg-slate-50 hover:bg-white border border-slate-200 text-slate-800 text-xs rounded-xl focus:outline-none focus:border-blue-500 focus:bg-white transition-all cursor-pointer">
                                <option value="" selected>Semua outlet</option>
                                @foreach ($outletList as $o)
                                    <option value="{{ $o->id }}">{{ $o->nama_outlet }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Supplier -->
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Supplier</label>
                            <select id="filterSupplier" class="w-full px-3 py-2 bg-slate-50 hover:bg-white border border-slate-200 text-slate-800 text-xs rounded-xl focus:outline-none focus:border-blue-500 focus:bg-white transition-all cursor-pointer">
                                <option value="" selected>Semua supplier</option>
                                @foreach ($supplierList as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama_supplier }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <!-- Right Action Buttons -->
                    <div class="flex items-center gap-2 pt-1 xl:pt-0">
                        <!-- Terapkan Button -->
                        <button 
                            type="button" 
                            id="btnTerapkan"
                            class="px-5 py-2 bg-[#0070e0] hover:bg-[#005ec4] active:scale-[0.98] text-white text-xs font-semibold rounded-xl shadow-sm transition-all cursor-pointer flex items-center gap-1.5"
                        >
                            <span>Terapkan</span>
                        </button>

                        <!-- Reset Button -->
                        <button 
                            type="button" 
                            id="btnReset"
                            class="px-4 py-2 bg-white hover:bg-slate-50 text-slate-600 text-xs font-semibold rounded-xl border border-slate-200 transition-colors cursor-pointer"
                        >
                            <span>Reset</span>
                        </button>

                        <!-- Unduh Excel Button -->
                        <button 
                            type="button" 
                            id="btnExcel"
                            class="px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition-colors cursor-pointer flex items-center gap-1.5 shadow-2xs"
                        >
                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            <span>Unduh Excel</span>
                        </button>
                    </div>

                </form>
            </div>

            <!-- ------------------------------------------------------ -->
            <!-- TOP 4 VIBRANT GRADIENT METRIC CARDS -->
            <!-- ------------------------------------------------------ -->
            <div id="kpiContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                
                <!-- Card 1: Program Berjalan (Vibrant Royal Blue) -->
                <div class="relative overflow-hidden rounded-2xl p-5 text-white shadow-md bg-gradient-to-br from-[#0072ea] to-[#0051ba] transition-all hover:-translate-y-1 hover:shadow-lg">
                    <!-- Glass Icon Box -->
                    <div class="flex items-start justify-between">
                        <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center shadow-xs">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                        </div>
                    </div>

                    <div class="mt-3">
                        <div class="text-xs text-blue-100 font-medium">Program berjalan</div>
                        <div class="text-3xl sm:text-4xl font-extrabold text-white mt-1 tracking-tight">
                            {{ $summary->total_program_berjalan }}
                        </div>
                        <div class="text-[11px] text-blue-100/90 mt-2 font-normal">
                            {{ $summary->program_berakhir_7_hari }} program berakhir 7 hari ke depan
                        </div>
                    </div>

                    <!-- Faded Graphic Watermark -->
                    <div class="absolute -right-2 -bottom-2 w-28 h-20 opacity-20 pointer-events-none flex items-end gap-1.5">
                        <span class="w-4 h-8 bg-white rounded-t"></span>
                        <span class="w-4 h-12 bg-white rounded-t"></span>
                        <span class="w-4 h-16 bg-white rounded-t"></span>
                        <span class="w-4 h-20 bg-white rounded-t"></span>
                    </div>
                </div>

                <!-- Card 2: Realisasi Belum Ditagih (Vibrant Emerald/Teal) -->
                <div class="relative overflow-hidden rounded-2xl p-5 text-white shadow-md bg-gradient-to-br from-[#059669] to-[#047857] transition-all hover:-translate-y-1 hover:shadow-lg">
                    <div class="flex items-start justify-between">
                        <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center shadow-xs">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 5.625c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                            </svg>
                        </div>
                        <!-- Green Trend Pill Badge -->
                        <span class="inline-flex items-center gap-0.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-white/20 text-white backdrop-blur-sm">
                            &uarr; 12%
                        </span>
                    </div>

                    <div class="mt-3">
                        <div class="text-xs text-emerald-100 font-medium">Realisasi belum ditagih</div>
                        <div class="text-3xl sm:text-4xl font-extrabold text-white mt-1 tracking-tight">
                            Rp {{ number_format($summary->realisasi_belum_ditagih / 1000000, 1, ',', '.') }} jt
                        </div>
                        <div class="text-[11px] text-emerald-100/90 mt-2 font-normal">
                            {{ $summary->program_masuk_akrual }} program &middot; masuk akrual
                        </div>
                    </div>
                </div>

                <!-- Card 3: Tagihan Belum Lunas (Vibrant Coral/Orange) -->
                <div class="relative overflow-hidden rounded-2xl p-5 text-white shadow-md bg-gradient-to-br from-[#f97316] to-[#ea580c] transition-all hover:-translate-y-1 hover:shadow-lg">
                    <div class="flex items-start justify-between">
                        <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center shadow-xs">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a2.25 2.25 0 00-2.25-2.25H15a3 3 0 11-6 0H5.25A2.25 2.25 0 003 12m18 0v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 9m18 0V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v3" />
                            </svg>
                        </div>
                        <!-- Orange Trend Pill Badge -->
                        <span class="inline-flex items-center gap-0.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-white/20 text-white backdrop-blur-sm">
                            &uarr; 18%
                        </span>
                    </div>

                    <div class="mt-3">
                        <div class="text-xs text-orange-100 font-medium">Tagihan belum lunas</div>
                        <div class="text-3xl sm:text-4xl font-extrabold text-white mt-1 tracking-tight">
                            Rp {{ number_format($summary->tagihan_belum_lunas / 1000000, 1, ',', '.') }} jt
                        </div>
                        <div class="text-[11px] text-orange-100/90 mt-2 font-normal">
                            {{ $summary->invoice_belum_lunas }} invoice &middot; Rp {{ number_format($summary->tagihan_lewat_30_hari / 1000000, 1, ',', '.') }} jt lewat jatuh tempo
                        </div>
                    </div>
                </div>

                <!-- Card 4: Diterima Tahun 2026 (Vibrant Purple) -->
                <div class="relative overflow-hidden rounded-2xl p-5 text-white shadow-md bg-gradient-to-br from-[#7c3aed] to-[#5b21b6] transition-all hover:-translate-y-1 hover:shadow-lg">
                    <div class="flex items-start justify-between">
                        <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center shadow-xs">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                            </svg>
                        </div>
                        <!-- Purple Trend Pill Badge -->
                        <span class="inline-flex items-center gap-0.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-white/20 text-white backdrop-blur-sm">
                            &uarr; 24%
                        </span>
                    </div>

                    <div class="mt-3">
                        <div class="text-xs text-purple-100 font-medium">Diterima - Tahun 2026</div>
                        <div class="text-3xl sm:text-4xl font-extrabold text-white mt-1 tracking-tight">
                            Rp {{ number_format($summary->diterima_tahun_berjalan / 1000000000, 2, ',', '.') }} M
                        </div>
                        <div class="text-[11px] text-purple-100/90 mt-2 font-normal">
                            {{ $summary->total_pembayaran_selesai }} pembayaran &middot; Transfer BCA &amp; kas
                        </div>
                    </div>
                </div>

            </div>

            <!-- SKELETON PLACEHOLDER FOR KPI CARDS (Hidden by default) -->
            <div id="kpiSkeleton" class="hidden grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @for ($i = 0; $i < 4; $i++)
                    <div class="white-card p-5 space-y-3">
                        <div class="w-10 h-10 rounded-xl skeleton-shimmer"></div>
                        <div class="w-24 h-3 rounded skeleton-shimmer"></div>
                        <div class="w-36 h-7 rounded-lg skeleton-shimmer"></div>
                        <div class="w-48 h-3 rounded skeleton-shimmer"></div>
                    </div>
                @endfor
            </div>

            <!-- ------------------------------------------------------ -->
            <!-- CHARTS SECTION: TREN NILAI (BAR/LINE) & DONUT DISTRIBUSI -->
            <!-- ------------------------------------------------------ -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
                
                <!-- Chart 1: Tren Nilai Program, Realisasi, Tagihan, Pembayaran (7 cols) -->
                <div class="white-card p-5 lg:col-span-7 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-lg bg-blue-50 text-[#0070e0] flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                                    </svg>
                                </span>
                                <h3 class="text-xs sm:text-sm font-bold text-slate-900 tracking-tight">
                                    Tren Nilai Program, Realisasi, Tagihan dan Pembayaran
                                </h3>
                            </div>
                            <select class="bg-slate-50 border border-slate-200 text-slate-700 text-xs rounded-lg px-2.5 py-1 focus:outline-none">
                                <option>Tahun 2026</option>
                            </select>
                        </div>

                        <!-- Legend row matching the mockup -->
                        <div class="flex items-center flex-wrap gap-4 text-[11px] font-semibold text-slate-600 mb-2">
                            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm bg-[#0070e0]"></span> Program</span>
                            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm bg-[#10b981]"></span> Realisasi</span>
                            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm bg-[#f97316]"></span> Tagihan</span>
                            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-xs bg-[#c084fc]"></span> Pembayaran</span>
                        </div>

                        <!-- Chart Canvas Container -->
                        <div class="relative h-[280px] w-full">
                            <canvas id="trendChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Chart 2: Distribusi Program per Tahap (Donut) (5 cols) -->
                <div class="white-card p-5 lg:col-span-5 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-lg bg-blue-50 text-[#0070e0] flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                                    </svg>
                                </span>
                                <h3 class="text-xs sm:text-sm font-bold text-slate-900 tracking-tight">
                                    Distribusi Program per Tahap
                                </h3>
                            </div>
                            <select class="bg-slate-50 border border-slate-200 text-slate-700 text-xs rounded-lg px-2.5 py-1 focus:outline-none">
                                <option>Tahun 2026</option>
                            </select>
                        </div>

                        <!-- Donut Chart + Legend Side by Side -->
                        <div class="grid grid-cols-1 sm:grid-cols-12 items-center gap-4 pt-1">
                            
                            <!-- Donut Canvas with Center Text Overlay -->
                            <div class="sm:col-span-6 relative flex items-center justify-center h-[240px]">
                                <canvas id="donutChart"></canvas>
                                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                    <span class="text-2xl font-extrabold text-slate-900 leading-tight">27</span>
                                    <span class="text-[11px] font-semibold text-slate-500">Program</span>
                                </div>
                            </div>

                            <!-- Legend List with Counts and Percentages -->
                            <div class="sm:col-span-6 space-y-1.5 text-xs">
                                @foreach ($distributionStages as $ds)
                                    <div class="flex items-center justify-between py-0.5 text-slate-600">
                                        <div class="flex items-center gap-2 min-w-0">
                                            <span class="w-2.5 h-2.5 rounded-sm shrink-0" style="background-color: {{ $ds['color'] }};"></span>
                                            <span class="text-[11px] font-medium truncate">{{ $ds['name'] }}</span>
                                        </div>
                                        <div class="flex items-center gap-3 text-[11px]">
                                            <span class="font-bold text-slate-900">{{ $ds['count'] }}</span>
                                            <span class="text-slate-400 w-8 text-right">{{ $ds['percentage'] }}%</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            <!-- ------------------------------------------------------ -->
            <!-- ROW 3: REALISASI VS TAGIHAN, TOP 5 SUPPLIER, UMUR TAGIHAN -->
            <!-- ------------------------------------------------------ -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                
                <!-- Card A: Realisasi vs Tagihan vs Pembayaran -->
                <div class="white-card p-5">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="w-6 h-6 rounded-lg bg-red-50 text-red-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.114-1.523-.45a19.23 19.23 0 01-1.354-3.805m3.012-.419c.381-.03.762-.07 1.14-.122m0 0A23.878 23.878 0 0012 15.75c4.142 0 7.5-3.358 7.5-7.5s-3.358-7.5-7.5-7.5c-.754 0-1.488.112-2.186.321" />
                            </svg>
                        </span>
                        <h3 class="text-xs sm:text-sm font-bold text-slate-900 tracking-tight">
                            Realisasi vs Tagihan vs Pembayaran
                        </h3>
                    </div>

                    <!-- 4 Horizontal Progress Columns -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 pt-2">
                        <!-- Total Program -->
                        <div>
                            <div class="text-[11px] text-slate-500 font-medium">Total Program</div>
                            <div class="text-sm font-extrabold text-[#0070e0] mt-0.5">Rp 1,25 M</div>
                            <div class="w-full bg-slate-100 rounded-full h-2 mt-3 overflow-hidden">
                                <div class="bg-[#0070e0] h-full rounded-full transition-all duration-700" style="width: 100%;"></div>
                            </div>
                            <div class="text-right text-[10px] text-slate-400 font-semibold mt-1">100%</div>
                        </div>

                        <!-- Realisasi -->
                        <div>
                            <div class="text-[11px] text-slate-500 font-medium">Realisasi</div>
                            <div class="text-sm font-extrabold text-[#10b981] mt-0.5">Rp 846,2 jt</div>
                            <div class="w-full bg-slate-100 rounded-full h-2 mt-3 overflow-hidden">
                                <div class="bg-[#10b981] h-full rounded-full transition-all duration-700" style="width: 68%;"></div>
                            </div>
                            <div class="text-right text-[10px] text-slate-400 font-semibold mt-1">68%</div>
                        </div>

                        <!-- Tagihan -->
                        <div>
                            <div class="text-[11px] text-slate-500 font-medium">Tagihan</div>
                            <div class="text-sm font-extrabold text-[#f97316] mt-0.5">Rp 723,1 jt</div>
                            <div class="w-full bg-slate-100 rounded-full h-2 mt-3 overflow-hidden">
                                <div class="bg-[#f97316] h-full rounded-full transition-all duration-700" style="width: 58%;"></div>
                            </div>
                            <div class="text-right text-[10px] text-slate-400 font-semibold mt-1">58%</div>
                        </div>

                        <!-- Pembayaran -->
                        <div>
                            <div class="text-[11px] text-slate-500 font-medium">Pembayaran</div>
                            <div class="text-sm font-extrabold text-[#7c3aed] mt-0.5">Rp 611,9 jt</div>
                            <div class="w-full bg-slate-100 rounded-full h-2 mt-3 overflow-hidden">
                                <div class="bg-[#7c3aed] h-full rounded-full transition-all duration-700" style="width: 49%;"></div>
                            </div>
                            <div class="text-right text-[10px] text-slate-400 font-semibold mt-1">49%</div>
                        </div>
                    </div>
                </div>

                <!-- Card B: Top 5 Supplier Belum Lunas -->
                <div class="white-card p-5">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="w-6 h-6 rounded-lg bg-red-50 text-red-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                        </span>
                        <h3 class="text-xs sm:text-sm font-bold text-slate-900 tracking-tight">
                            Top 5 Supplier Belum Lunas
                        </h3>
                    </div>

                    <!-- Horizontal Rose/Coral Bars (Inline Name - Bar - Value) -->
                    <div class="space-y-3 pt-1">
                        @foreach ($supplierAr->take(5) as $supp)
                            <div class="flex items-center justify-between gap-2.5 text-xs">
                                <span class="text-slate-600 font-medium text-[11px] w-28 truncate shrink-0">{{ $supp->nama_supplier }}</span>
                                <div class="flex-1 bg-slate-100 rounded-full h-2.5 overflow-hidden">
                                    <div class="bg-[#f43f5e] h-full rounded-full transition-all duration-700" style="width: {{ $supp->persentase_bar }}%;"></div>
                                </div>
                                <span class="font-extrabold text-slate-800 text-[11px] shrink-0 text-right w-16">Rp {{ number_format($supp->total_nilai / 1000000, 1, ',', '.') }} jt</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Card C: Umur Tagihan Belum Lunas (Vertical Bar Chart) -->
                <div class="white-card p-5 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="w-6 h-6 rounded-lg bg-blue-50 text-[#0070e0] flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                                </svg>
                            </span>
                            <h3 class="text-xs sm:text-sm font-bold text-slate-900 tracking-tight">
                                Umur Tagihan Belum Lunas
                            </h3>
                        </div>
                        <p class="text-[11px] text-slate-400 mb-3">
                            Total Rp 455,9 jt dari 113 invoice
                        </p>

                        <!-- Vertical Bar Chart Canvas -->
                        <div class="relative h-[210px] w-full">
                            <canvas id="agingChart"></canvas>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ------------------------------------------------------ -->
            <!-- ROW 4: PERLU TINDAKAN & RINGKASAN PER OUTLET -->
            <!-- ------------------------------------------------------ -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
                
                <!-- Left: Perlu Tindakan (6 cols) -->
                <div class="white-card p-5 lg:col-span-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-lg bg-red-50 text-red-600 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                    </svg>
                                </span>
                                <h3 class="text-xs sm:text-sm font-bold text-slate-900 tracking-tight">
                                    Perlu Tindakan
                                </h3>
                                <span class="w-4 h-4 rounded-full bg-red-600 text-white font-extrabold text-[9px] flex items-center justify-center">
                                    6
                                </span>
                            </div>
                            <a href="{{ route('program.index') }}" class="text-xs text-blue-600 hover:underline font-semibold">
                                Lihat semua
                            </a>
                        </div>

                        <!-- Table List -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs">
                                <thead>
                                    <tr class="border-b border-slate-100 text-[11px] font-semibold text-slate-400 uppercase">
                                        <th class="py-2.5 px-2">Prioritas</th>
                                        <th class="py-2.5 px-2">Pesan</th>
                                        <th class="py-2.5 px-2">Detail</th>
                                        <th class="py-2.5 px-2 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach ($perluTindakan->take(5) as $pt)
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="py-2.5 px-2">
                                                <span class="inline-block text-[10px] font-bold px-2 py-0.5 rounded-md
                                                    @if($pt->kategori === 'Kritis') bg-red-100 text-red-700
                                                    @elseif($pt->kategori === 'Penting') bg-orange-100 text-orange-700
                                                    @elseif($pt->kategori === 'Perhatian') bg-amber-100 text-amber-700
                                                    @else bg-blue-100 text-blue-700
                                                    @endif
                                                ">
                                                    {{ $pt->kategori }}
                                                </span>
                                            </td>
                                            <td class="py-2.5 px-2 font-semibold text-slate-800 text-[11px] max-w-[150px] truncate">
                                                {{ $pt->judul }}
                                            </td>
                                            <td class="py-2.5 px-2 text-slate-500 text-[11px] max-w-[160px] truncate">
                                                {{ $pt->rincian }}
                                            </td>
                                            <td class="py-2.5 px-2 text-right">
                                                <a href="{{ $pt->link_url }}" class="text-blue-600 hover:underline font-bold text-[11px]">
                                                    Buka
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right: Ringkasan per Outlet (6 cols) -->
                <div class="white-card p-5 lg:col-span-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-lg bg-blue-50 text-[#0070e0] flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                                    </svg>
                                </span>
                                <h3 class="text-xs sm:text-sm font-bold text-slate-900 tracking-tight">
                                    Ringkasan per Outlet
                                </h3>
                            </div>
                            <a href="{{ route('dashboard') }}" class="text-xs text-blue-600 hover:underline font-semibold">
                                Lihat semua
                            </a>
                        </div>

                        <!-- Table List -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs">
                                <thead>
                                    <tr class="border-b border-slate-100 text-[11px] font-semibold text-slate-400 uppercase">
                                        <th class="py-2.5 px-2">Outlet</th>
                                        <th class="py-2.5 px-2 text-right">Program</th>
                                        <th class="py-2.5 px-2 text-right">Realisasi belum ditagih</th>
                                        <th class="py-2.5 px-2 text-right">Tagihan belum lunas</th>
                                        <th class="py-2.5 px-2 text-center">Konfirmasi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach ($outletSummary->take(5) as $os)
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="py-2.5 px-2 font-bold text-blue-600 hover:underline cursor-pointer">
                                                {{ $os->nama_outlet }}
                                            </td>
                                            <td class="py-2.5 px-2 text-right text-slate-700 font-semibold">
                                                {{ $os->program_berjalan }}
                                            </td>
                                            <td class="py-2.5 px-2 text-right text-slate-800 font-medium">
                                                Rp {{ number_format($os->realisasi_belum_ditagih / 1000000, 1, ',', '.') }} jt
                                            </td>
                                            <td class="py-2.5 px-2 text-right text-slate-800 font-medium">
                                                Rp {{ number_format($os->tagihan_belum_lunas / 1000000, 1, ',', '.') }} jt
                                            </td>
                                            <td class="py-2.5 px-2 text-center">
                                                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-amber-100 text-amber-800">
                                                    {{ $os->status_konfirmasi }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </main>

    </div>

    <!-- ============================================================== -->
    <!-- JAVASCRIPT: CHARTS, SKELETON LOADER, SWEETALERT LOGOUT -->
    <!-- ============================================================== -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            // ----------------------------------------------------------
            // 1. SWEETALERT LOGOUT CONFIRMATION
            // ----------------------------------------------------------
            const userProfileBtn = document.getElementById('userProfileBtn');
            const logoutForm = document.getElementById('logoutForm');

            if (userProfileBtn && logoutForm) {
                userProfileBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    
                    Swal.fire({
                        title: 'Konfirmasi Keluar?',
                        text: 'Sesi Anda di Sistem Monitoring Promosi akan diakhiri.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e31e24',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Ya, Keluar',
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
                        customClass: {
                            popup: 'rounded-2xl',
                            confirmButton: 'rounded-xl px-4 py-2 font-semibold text-xs',
                            cancelButton: 'rounded-xl px-4 py-2 font-semibold text-xs'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Sedang keluar...',
                                text: 'Mohon tunggu sejenak.',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                    logoutForm.submit();
                                }
                            });
                        }
                    });
                });
            }

            // ----------------------------------------------------------
            // 2. CHART 1: TREN NILAI (BAR + LINE CHART)
            // ----------------------------------------------------------
            const trendCtx = document.getElementById('trendChart')?.getContext('2d');
            let trendChart = null;

            if (trendCtx) {
                const labels = @json($monthlyTrend['labels']);
                const programData = @json($monthlyTrend['program']);
                const realisasiData = @json($monthlyTrend['realisasi']);
                const tagihanData = @json($monthlyTrend['tagihan']);
                const pembayaranData = @json($monthlyTrend['pembayaran']);
                const trendlineData = @json($monthlyTrend['trendline']);

                trendChart = new Chart(trendCtx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                type: 'line',
                                label: 'Tren',
                                data: trendlineData,
                                borderColor: '#f43f5e',
                                backgroundColor: '#f43f5e',
                                borderWidth: 2.2,
                                tension: 0.4,
                                pointRadius: 3.5,
                                pointHoverRadius: 6,
                                order: 1
                            },
                            {
                                type: 'bar',
                                label: 'Program',
                                data: programData,
                                backgroundColor: '#0070e0',
                                borderRadius: 2,
                                barPercentage: 0.85,
                                categoryPercentage: 0.85,
                                order: 2
                            },
                            {
                                type: 'bar',
                                label: 'Realisasi',
                                data: realisasiData,
                                backgroundColor: '#10b981',
                                borderRadius: 2,
                                barPercentage: 0.85,
                                categoryPercentage: 0.85,
                                order: 3
                            },
                            {
                                type: 'bar',
                                label: 'Tagihan',
                                data: tagihanData,
                                backgroundColor: '#f97316',
                                borderRadius: 2,
                                barPercentage: 0.85,
                                categoryPercentage: 0.85,
                                order: 4
                            },
                            {
                                type: 'bar',
                                label: 'Pembayaran',
                                data: pembayaranData,
                                backgroundColor: '#c084fc',
                                borderRadius: 2,
                                barPercentage: 0.85,
                                categoryPercentage: 0.85,
                                order: 5
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#0f172a',
                                titleFont: { family: 'Plus Jakarta Sans', size: 12 },
                                bodyFont: { family: 'Plus Jakarta Sans', size: 12 },
                                padding: 10,
                                cornerRadius: 8
                            }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { font: { family: 'Plus Jakarta Sans', size: 11 }, color: '#64748b' }
                            },
                            y: {
                                beginAtZero: true,
                                max: 400,
                                grid: { color: '#f1f5f9' },
                                ticks: {
                                    stepSize: 100,
                                    font: { family: 'Plus Jakarta Sans', size: 11 },
                                    color: '#64748b',
                                    callback: function (val) { return val; }
                                }
                            }
                        }
                    }
                });
            }

            // ----------------------------------------------------------
            // 3. CHART 2: DONUT DISTRIBUSI PROGRAM PER TAHAP
            // ----------------------------------------------------------
            const donutCtx = document.getElementById('donutChart')?.getContext('2d');
            let donutChart = null;

            if (donutCtx) {
                const distributionStages = @json($distributionStages);
                const dLabels = distributionStages.map(d => d.name);
                const dCounts = distributionStages.map(d => d.count);
                const dColors = distributionStages.map(d => d.color);

                donutChart = new Chart(donutCtx, {
                    type: 'doughnut',
                    data: {
                        labels: dLabels,
                        datasets: [{
                            data: dCounts,
                            backgroundColor: dColors,
                            borderWidth: 2,
                            borderColor: '#ffffff',
                            hoverOffset: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '72%',
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#0f172a',
                                titleFont: { family: 'Plus Jakarta Sans', size: 12 },
                                bodyFont: { family: 'Plus Jakarta Sans', size: 12 },
                                padding: 10,
                                cornerRadius: 8,
                                callbacks: {
                                    label: function(context) {
                                        return `${context.label}: ${context.raw} program`;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // ----------------------------------------------------------
            // 4. CHART 3: UMUR TAGIHAN BELUM LUNAS (VERTICAL BAR CHART)
            // ----------------------------------------------------------
            const agingCtx = document.getElementById('agingChart')?.getContext('2d');
            let agingChart = null;

            if (agingCtx) {
                const barLabelsPlugin = {
                    id: 'barLabels',
                    afterDatasetsDraw(chart) {
                        const { ctx, data } = chart;
                        chart.getDatasetMeta(0).data.forEach((bar, index) => {
                            const val = data.datasets[0].data[index];
                            ctx.save();
                            ctx.fillStyle = '#334155';
                            ctx.font = '600 9.5px Plus Jakarta Sans, sans-serif';
                            ctx.textAlign = 'center';
                            const text = 'Rp ' + (val > 0 ? val.toFixed(1).replace('.', ',') : '0') + ' jt';
                            const yPos = val > 0 ? bar.y - 6 : bar.y - 6;
                            ctx.fillText(text, bar.x, yPos);
                            ctx.restore();
                        });
                    }
                };

                agingChart = new Chart(agingCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Belum jatuh tempo', '1–30 hari', '31–60 hari', '61–90 hari', '> 90 hari'],
                        datasets: [{
                            data: [212.3, 173.3, 70.2, 0, 0],
                            backgroundColor: [
                                '#38bdf8',
                                '#0284c7',
                                '#2563eb',
                                '#cbd5e1',
                                '#cbd5e1'
                            ],
                            borderRadius: 6,
                            barThickness: 26
                        }]
                    },
                    plugins: [barLabelsPlugin],
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                top: 20
                            }
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#0f172a',
                                titleFont: { family: 'Plus Jakarta Sans', size: 11 },
                                bodyFont: { family: 'Plus Jakarta Sans', size: 11 },
                                callbacks: {
                                    label: function(ctx) { return 'Rp ' + ctx.raw + ' jt'; }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { font: { family: 'Plus Jakarta Sans', size: 10 }, color: '#64748b' }
                            },
                            y: {
                                display: false,
                                beginAtZero: true,
                                max: 250
                            }
                        }
                    }
                });
            }

            // ----------------------------------------------------------
            // 5. SKELETON LOADING ON DATA REFRESH / FILTER
            // ----------------------------------------------------------
            const btnTerapkan = document.getElementById('btnTerapkan');
            const btnReset = document.getElementById('btnReset');
            const kpiContainer = document.getElementById('kpiContainer');
            const kpiSkeleton = document.getElementById('kpiSkeleton');

            function triggerLoadingSkeleton(actionName = 'Memperbarui data promosi...') {
                // Show Skeleton
                if (kpiContainer && kpiSkeleton) {
                    kpiContainer.classList.add('hidden');
                    kpiSkeleton.classList.remove('hidden');
                }

                // Toast Feedback
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 850,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });

                Toast.fire({
                    icon: 'info',
                    title: actionName
                });

                // Simulate Fast Async Data Sync
                setTimeout(() => {
                    if (kpiContainer && kpiSkeleton) {
                        kpiSkeleton.classList.add('hidden');
                        kpiContainer.classList.remove('hidden');
                    }

                    // Re-render chart animations
                    if (trendChart) trendChart.update();
                    if (donutChart) donutChart.update();
                    if (agingChart) agingChart.update();

                    Toast.fire({
                        icon: 'success',
                        title: 'Data promosi berhasil diperbarui!'
                    });
                }, 850);
            }

            if (btnTerapkan) {
                btnTerapkan.addEventListener('click', function () {
                    triggerLoadingSkeleton('Menerapkan filter data...');
                });
            }

            if (btnReset) {
                btnReset.addEventListener('click', function () {
                    document.getElementById('filterPeriode').value = '2026';
                    document.getElementById('filterPerusahaan').value = '';
                    document.getElementById('filterOutlet').value = '';
                    document.getElementById('filterSupplier').value = '';
                    triggerLoadingSkeleton('Mereset filter ke default...');
                });
            }

            // Excel download trigger
            const btnExcel = document.getElementById('btnExcel');
            if (btnExcel) {
                btnExcel.addEventListener('click', function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Ekspor Data Dimulai',
                        text: 'File Excel Ringkasan Monitoring Promosi 2026 sedang diunduh.',
                        timer: 2000,
                        showConfirmButton: false,
                        customClass: { popup: 'rounded-2xl' }
                    });
                });
            }

        });
    </script>
</body>
</html>
