<!DOCTYPE html>
<html lang="id" class="h-full bg-[#f1f5f9]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Monitoring Promosi') - Mitra Bangunan Supermarket</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-transparent.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo-transparent.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-transparent.png') }}">

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

        /* Skeleton Pulse and Shimmer Animation */
        @keyframes skeletonPulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.4;
            }
        }
        @keyframes skeletonShimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        .skeleton-shimmer {
            background: linear-gradient(90deg, #e2e8f0 25%, #f1f5f9 50%, #e2e8f0 75%);
            background-size: 200% 100%;
            animation: skeletonShimmer 1.4s infinite, skeletonPulse 1.4s infinite;
        }
    </style>
    @stack('styles')
</head>
<body class="h-full flex overflow-hidden text-slate-800 antialiased select-none">

    <!-- ============================================================== -->
    <!-- 1. LEFT SIDEBAR NAVIGATION (DARK ENTERPRISE BLUE) -->
    <!-- ============================================================== -->
    <aside class="w-64 bg-[#091122] flex flex-col justify-between shrink-0 select-none z-30 relative overflow-hidden border-r border-slate-800">
        
        <!-- Store Facade Artwork in Lower Sidebar Background -->
        <div class="absolute bottom-12 left-0 right-0 h-84 pointer-events-none overflow-hidden z-0">
            <img src="{{ asset('images/sidebar-shadow-hd.png') }}" alt="" class="w-full h-full object-cover object-top opacity-90">
            <div class="absolute inset-0 bg-gradient-to-t from-[#060c18] via-transparent via-50% to-[#091122]"></div>
        </div>

        <!-- Upper Sidebar Menu Content -->
        <div class="overflow-y-auto py-5 px-3.5 z-10 flex-1">
            
            <!-- Logo Mitra Bangunan Supermarket -->
            <div class="px-2 pt-1 mb-5">
                <a href="{{ route('dashboard') }}" class="sidebar-nav-link block">
                    <img 
                        src="{{ asset('images/logo-transparent.png') }}" 
                        alt="Mitra Bangunan Supermarket" 
                        class="h-11 w-auto object-contain filter drop-shadow brightness-110"
                        onerror="this.src='{{ asset('images/logo.png') }}'"
                    />
                </a>
            </div>

            <!-- Monitoring Promosi Section Label -->
            <div class="px-3 mb-4">
                <div class="text-xs font-bold text-white tracking-tight flex items-center justify-between">
                    <span>Monitoring Promosi</span>
                    <span class="text-[10px] text-emerald-400 bg-emerald-500/10 px-1.5 py-0.5 rounded font-mono">v1.2</span>
                </div>
            </div>

            <!-- Active Dashboard Nav -->
            <div class="mb-5">
                <a href="{{ route('dashboard') }}" class="sidebar-nav-link flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold text-xs transition-all {{ request()->routeIs('dashboard') ? 'bg-[#0070e0] text-white shadow-md shadow-blue-500/30' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    <span>Dashboard</span>
                </a>
            </div>

            <!-- Group: TRANSAKSI -->
            <div class="mb-5">
                <div class="text-[10px] uppercase font-bold tracking-wider text-slate-400 px-3 mb-2 flex items-center justify-between">
                    <span>Transaksi</span>
                    <span class="text-[9px] bg-blue-500/20 text-blue-300 px-1.5 py-0.2 rounded font-normal">Inti</span>
                </div>
                <nav class="space-y-1">
                    <a href="{{ route('program.index') }}" class="sidebar-nav-link flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('program.index', 'program.show') ? 'bg-[#0070e0] text-white font-semibold shadow-md shadow-blue-500/30' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('program.index', 'program.show') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm0 5.25h.007v.008H3.75V12zm0 5.25h.007v.008H3.75v-.008z" />
                        </svg>
                        <span>Program Promo</span>
                    </a>

                    <a href="{{ route('program.create') }}" class="sidebar-nav-link flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('program.create') ? 'bg-[#0070e0] text-white font-semibold shadow-md shadow-blue-500/30' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('program.create') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Buat Program</span>
                    </a>

                    <a href="{{ route('realisasi.index') }}" class="sidebar-nav-link flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('realisasi.*') ? 'bg-[#0070e0] text-white font-semibold shadow-md shadow-blue-500/30' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('realisasi.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Realisasi &amp; Verifikasi</span>
                    </a>

                    <a href="{{ route('tagihan.index') }}" class="sidebar-nav-link flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('tagihan.*') ? 'bg-[#0070e0] text-white font-semibold shadow-md shadow-blue-500/30' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('tagihan.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                        <span>Tagihan AR</span>
                    </a>
                </nav>
            </div>

            <!-- Group: MASTER DATA -->
            <div class="mb-4">
                <div class="text-[10px] uppercase font-bold tracking-wider text-slate-400 px-3 mb-2">
                    Master Data
                </div>
                <nav class="space-y-1">
                    <a href="{{ route('master.metode') }}" class="sidebar-nav-link flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('master.metode*') ? 'bg-[#0070e0] text-white font-semibold shadow-md shadow-blue-500/30' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                        </svg>
                        <span>Metode Kesepakatan</span>
                    </a>

                    <a href="{{ route('master.event') }}" class="sidebar-nav-link flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('master.event*') ? 'bg-[#0070e0] text-white font-semibold shadow-md shadow-blue-500/30' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                        <span>Event Promosi</span>
                    </a>

                    <a href="{{ route('master.sarana') }}" class="sidebar-nav-link flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('master.sarana*') ? 'bg-[#0070e0] text-white font-semibold shadow-md shadow-blue-500/30' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.25A2.25 2.25 0 010 18.75V8.25A2.25 2.25 0 012.25 6h19.5A2.25 2.25 0 0124 8.25v10.5A2.25 2.25 0 0121.75 21h-4.5z" />
                        </svg>
                        <span>Sarana Promosi</span>
                    </a>

                    <a href="{{ route('master.supplier') }}" class="sidebar-nav-link flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('master.supplier*') ? 'bg-[#0070e0] text-white font-semibold shadow-md shadow-blue-500/30' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
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
                    <!-- Circle Avatar -->
                    <div class="w-8 h-8 rounded-full bg-blue-600 text-white font-bold text-xs flex items-center justify-center shrink-0 border border-blue-400/40">
                        {{ strtoupper(substr(auth()->user()->name ?? 'AP', 0, 2)) }}
                    </div>
                    <div class="leading-tight">
                        <div class="text-xs font-bold text-white group-hover:text-blue-400 transition-colors truncate max-w-[120px]">
                            {{ auth()->user()->name ?? 'Admin Promosi' }}
                        </div>
                        <div class="text-[10px] text-slate-400 font-medium">
                            Admin Promosi - HO
                        </div>
                    </div>
                </div>

                <!-- Logout Trigger Icon -->
                <button type="button" title="Keluar / Logout" class="text-slate-400 group-hover:text-red-400 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                    </svg>
                </button>
            </div>

            <!-- Hidden Logout Form -->
            <form id="logoutForm" method="POST" action="{{ route('logout') }}" class="hidden">
                @csrf
            </form>
        </div>

    </aside>

    <!-- ============================================================== -->
    <!-- 2. MAIN CONTENT AREA -->
    <!-- ============================================================== -->
    <div id="mainScrollContainer" class="flex-1 flex flex-col min-w-0 overflow-y-auto bg-[#edf2f9]">

        <!-- TOP STORE HEADER BANNER -->
        <div class="relative w-full overflow-hidden bg-[#072147] min-h-[110px] flex items-center">
            <!-- Background Store Facade Photo -->
            <img 
                src="{{ asset('images/banner-clean-hd.jpg') }}" 
                alt="Mitra Bangunan Supermarket" 
                class="absolute inset-0 w-full h-full object-cover object-left md:object-center filter brightness-100"
            />

            <!-- Header Content -->
            <div class="relative z-10 w-full px-6 sm:px-8 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                
                <!-- Title & Subtitle -->
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight leading-tight">
                        @yield('header_title', 'Monitoring Promosi')
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-200 font-normal mt-0.5 drop-shadow-sm">
                        @yield('header_subtitle', 'Pantau program promosi, realisasi, dan tagihan secara real-time.')
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
                            <div id="liveDate" class="text-[11px] font-bold text-slate-900 tabular-nums">
                                {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                            </div>
                            <div id="liveTime" class="text-[10px] text-slate-500 font-medium tabular-nums">
                                {{ \Carbon\Carbon::now()->format('H:i:s') }} WIB
                            </div>
                        </div>
                    </div>

                    <!-- Quick Action: Buat Program Button -->
                    @if(!request()->routeIs('program.create'))
                    <a href="{{ route('program.create') }}" class="sidebar-nav-link hidden sm:inline-flex items-center gap-2 bg-[#0070e0] hover:bg-blue-600 text-white font-bold text-xs px-3.5 py-2.5 rounded-xl shadow-md shadow-blue-900/30 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span>Buat Program</span>
                    </a>
                    @endif
                </div>

            </div>
        </div>

        <!-- MAIN BODY CONTENT -->
        <main class="flex-1 p-5 sm:p-7 max-w-7xl w-full mx-auto space-y-6 relative">
            
            <!-- Global Skeleton Shimmer Animation Placeholder -->
            <div id="pageSkeletonLoader" class="space-y-6 transition-all duration-300">
                <!-- Top Metric Pills Skeleton -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @for ($i = 0; $i < 4; $i++)
                    <div class="white-card p-4 space-y-2.5">
                        <div class="w-24 h-3 rounded skeleton-shimmer"></div>
                        <div class="w-32 h-7 rounded-lg skeleton-shimmer"></div>
                        <div class="w-16 h-2.5 rounded skeleton-shimmer"></div>
                    </div>
                    @endfor
                </div>

                <!-- Filter Toolbar Skeleton -->
                <div class="white-card p-5">
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-3.5">
                        <div class="h-9 rounded-xl skeleton-shimmer"></div>
                        <div class="h-9 rounded-xl skeleton-shimmer"></div>
                        <div class="h-9 rounded-xl skeleton-shimmer"></div>
                        <div class="h-9 rounded-xl skeleton-shimmer"></div>
                    </div>
                </div>

                <!-- Table Skeleton -->
                <div class="white-card overflow-hidden p-5 space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <div class="w-48 h-5 rounded-lg skeleton-shimmer"></div>
                        <div class="w-20 h-4 rounded-full skeleton-shimmer"></div>
                    </div>
                    <div class="space-y-3 pt-2">
                        @for ($j = 0; $j < 5; $j++)
                        <div class="flex items-center gap-4 py-2 border-b border-slate-50">
                            <div class="w-24 h-4 rounded skeleton-shimmer"></div>
                            <div class="flex-1 h-4 rounded skeleton-shimmer"></div>
                            <div class="w-28 h-4 rounded skeleton-shimmer"></div>
                            <div class="w-20 h-4 rounded skeleton-shimmer"></div>
                            <div class="w-16 h-6 rounded-lg skeleton-shimmer"></div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Real Page Content Container -->
            <div id="realContentContainer" class="hidden opacity-0 transition-opacity duration-300">
                @yield('content')
            </div>

        </main>

        <!-- FOOTER -->
        <footer class="mt-auto px-6 py-4 text-center text-xs text-slate-400 border-t border-slate-200/60 bg-white/50 backdrop-blur-sm">
            &copy; {{ date('Y') }} PT Surya Pratama Keramindo &bull; Mitra Bangunan Supermarket Group. Sistem Monitoring Promosi.
        </footer>

    </div>

    <!-- Live Clock Script, Logout Confirmation & Skeleton Reveal -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Live Clock
            function updateClock() {
                const now = new Date();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');
                const liveTimeEl = document.getElementById('liveTime');
                if (liveTimeEl) {
                    liveTimeEl.textContent = `${hours}:${minutes}:${seconds} WIB`;
                }
            }
            setInterval(updateClock, 1000);

            // Skeleton Screen Smooth Reveal Transition
            const skeleton = document.getElementById('pageSkeletonLoader');
            const content = document.getElementById('realContentContainer');

            setTimeout(() => {
                if (skeleton && content) {
                    skeleton.classList.add('hidden');
                    content.classList.remove('hidden');
                    requestAnimationFrame(() => {
                        content.classList.remove('opacity-0');
                    });
                }
            }, 300);

            // Immediate Skeleton Trigger on Sidebar Menu Click
            document.querySelectorAll('.sidebar-nav-link').forEach(link => {
                link.addEventListener('click', function (e) {
                    const href = this.getAttribute('href');
                    if (href && !href.startsWith('#') && href !== window.location.href) {
                        if (skeleton && content) {
                            content.classList.add('opacity-0');
                            setTimeout(() => {
                                content.classList.add('hidden');
                                skeleton.classList.remove('hidden');
                            }, 50);
                        }
                    }
                });
            });

            // User Profile / Logout Trigger
            const userProfileBtn = document.getElementById('userProfileBtn');
            if (userProfileBtn) {
                userProfileBtn.addEventListener('click', function () {
                    Swal.fire({
                        title: 'Konfirmasi Keluar',
                        text: 'Apakah Anda yakin ingin keluar dari sistem Monitoring Promosi?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#e31e24',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Ya, Keluar',
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
                        customClass: {
                            popup: 'rounded-2xl shadow-xl'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('logoutForm').submit();
                        }
                    });
                });
            }

            // Flash Message Toast
            @if(session('success'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    customClass: { popup: 'rounded-2xl' }
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#0070e0',
                    customClass: { popup: 'rounded-2xl' }
                });
            @endif
        });
    </script>
    @stack('scripts')
</body>
</html>
