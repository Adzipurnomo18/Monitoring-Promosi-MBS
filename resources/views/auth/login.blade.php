<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Masuk - Monitoring Promosi | Mitra Bangunan Supermarket</title>

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
            --mbs-blue: #0070e0;
            --mbs-blue-dark: #0056b3;
            --mbs-red: #e31e24;
        }

        body {
            font-family: var(--font-sans);
            background-color: #0b1e38;
            color: #1f2937;
            overflow-x: hidden;
        }

        /* Keyframes for silky smooth load animations */
        @keyframes pageFadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        @keyframes bgScaleSlow {
            0% { transform: scale(1.08); filter: brightness(0.85); }
            100% { transform: scale(1.0); filter: brightness(1); }
        }

        @keyframes slideInFromLeft {
            0% {
                opacity: 0;
                transform: translateX(-40px);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInFromBottom {
            0% {
                opacity: 0;
                transform: translateY(35px) scale(0.97);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes ribbonSlideIn {
            0% {
                opacity: 0;
                transform: translate(80px, -80px) rotate(35deg);
            }
            100% {
                opacity: 1;
                transform: translate(0, 0) rotate(35deg);
            }
        }

        @keyframes cardLightShimmer {
            0% {
                transform: translateX(-160%) skewX(-25deg);
                opacity: 0;
            }
            20% {
                opacity: 0.55;
            }
            100% {
                transform: translateX(260%) skewX(-25deg);
                opacity: 0;
            }
        }

        @keyframes floatSubtle {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-4px); }
        }

        .animate-page-enter {
            animation: pageFadeIn 0.8s ease-out forwards;
        }

        .animate-bg-zoom {
            animation: bgScaleSlow 2.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .anim-stagger-1 {
            animation: slideInFromLeft 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.15s both;
        }

        .anim-stagger-2 {
            animation: slideInFromLeft 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.3s both;
        }

        .anim-stagger-3 {
            animation: slideInFromLeft 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.45s both;
        }

        .anim-stagger-4 {
            animation: slideInFromLeft 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.6s both;
        }

        .anim-stagger-5 {
            animation: slideInFromLeft 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.75s both;
        }

        .anim-card-float {
            animation: slideInFromBottom 0.9s cubic-bezier(0.16, 1, 0.3, 1) 0.2s both;
        }

        .anim-ribbons {
            animation: ribbonSlideIn 1.1s cubic-bezier(0.16, 1, 0.3, 1) 0.1s both;
        }

        .anim-shimmer {
            animation: cardLightShimmer 1.5s cubic-bezier(0.16, 1, 0.3, 1) 1.0s forwards;
        }

        /* Glass Feature Card Styling */
        .feature-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.14);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.25);
            transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .feature-card:hover {
            transform: translateX(8px);
            background: rgba(255, 255, 255, 0.14);
            border-color: rgba(255, 255, 255, 0.32);
            box-shadow: 0 16px 32px -6px rgba(0, 0, 0, 0.35);
        }

        /* Floating Login Card */
        .login-card-shadow {
            box-shadow: 
                0 30px 70px -15px rgba(2, 28, 68, 0.28),
                0 15px 30px -10px rgba(0, 0, 0, 0.12),
                0 0 0 1px rgba(0, 0, 0, 0.03);
        }

        /* Diagonal Accent Ribbons in Top-Right */
        .ribbon-cyan {
            background: linear-gradient(135deg, #0088ff 0%, #00b4d8 100%);
            box-shadow: 0 8px 24px rgba(0, 136, 255, 0.35);
        }

        .ribbon-red {
            background: linear-gradient(135deg, #f02828 0%, #d90429 100%);
            box-shadow: 0 8px 24px rgba(240, 40, 40, 0.35);
        }

        .ribbon-blue {
            background: linear-gradient(135deg, #0056b3 0%, #003d80 100%);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #0d2244;
        }
        ::-webkit-scrollbar-thumb {
            background: #1e3a6a;
            border-radius: 3px;
        }
    </style>
</head>
<body class="h-full min-h-screen relative flex items-center justify-center p-0 m-0 overflow-x-hidden select-none antialiased animate-page-enter">

    <!-- MASTER CONTAINER -->
    <div class="w-full min-h-screen relative flex flex-col lg:flex-row overflow-hidden bg-[#0a192f]">

        <!-- ============================================================== -->
        <!-- BACKGROUND LAYER: STORE BUILDING + NAVY OVERLAY -->
        <!-- ============================================================== -->
        <div class="absolute inset-0 z-0 overflow-hidden">
            <!-- Store Facade Image with slow zoom animation -->
            <img 
                src="{{ asset('images/store-building.jpg') }}" 
                alt="Mitra Bangunan Supermarket Storefront" 
                class="w-full h-full object-cover object-left md:object-center animate-bg-zoom filter"
            />

            <!-- Left Dark Translucent Gradient for Text Readability -->
            <div class="absolute inset-0 bg-gradient-to-r from-[#061730]/95 via-[#082046]/85 to-[#0b2b5e]/40 lg:to-[#082046]/20"></div>

            <!-- Soft Radial Vignette for Depth -->
            <div class="absolute inset-0 bg-radial from-transparent via-[#051329]/30 to-[#040e20]/80"></div>
        </div>

        <!-- ============================================================== -->
        <!-- TOP-RIGHT DECORATIVE BRAND RIBBONS -->
        <!-- ============================================================== -->
        <div class="hidden lg:block absolute -top-24 -right-16 z-10 pointer-events-none anim-ribbons">
            <div class="relative w-96 h-96">
                <!-- Cyan/Blue ribbon -->
                <div class="absolute top-12 -right-8 w-80 h-10 ribbon-cyan rounded-full transform -rotate-45 opacity-90"></div>
                <!-- Red ribbon -->
                <div class="absolute top-24 -right-4 w-80 h-10 ribbon-red rounded-full transform -rotate-45 opacity-95"></div>
                <!-- Dark blue accent ribbon -->
                <div class="absolute top-36 right-0 w-80 h-8 ribbon-blue rounded-full transform -rotate-45 opacity-75"></div>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- LEFT HERO SECTION (MONITORING PROMOSI + 3 FEATURE CARDS) -->
        <!-- ============================================================== -->
        <div class="relative z-20 w-full lg:w-[58%] xl:w-[60%] flex flex-col justify-between p-6 sm:p-10 lg:p-14 xl:p-16 min-h-[520px] lg:min-h-screen text-white">

            <!-- Top Header & Brand Info -->
            <div class="max-w-xl">
                <!-- Title Group -->
                <div class="anim-stagger-1">
                    <h1 class="text-4xl sm:text-5xl xl:text-6xl font-extrabold tracking-tight text-white drop-shadow-md leading-tight">
                        Monitoring<br/>
                        <span class="text-white">Promosi</span>
                    </h1>

                    <!-- Two-tone Underline Pill (Red & Blue) matching MBS Brand -->
                    <div class="flex items-center gap-1.5 mt-3 mb-4">
                        <span class="w-10 h-1.5 rounded-full bg-[#e31e24] shadow-sm shadow-red-500/50"></span>
                        <span class="w-14 h-1.5 rounded-full bg-[#0070e0] shadow-sm shadow-blue-500/50"></span>
                    </div>
                </div>

                <!-- Subtitle Description -->
                <p class="anim-stagger-2 text-slate-200 text-base sm:text-lg leading-relaxed font-normal mt-2 drop-shadow">
                    Pantau program promosi, realisasi, dan tagihan dalam satu sistem.
                </p>

                <!-- 3 Feature Highlights Cards Stack -->
                <div class="mt-8 space-y-4 max-w-lg">
                    
                    <!-- Card 1: Program Promosi -->
                    <div class="feature-card anim-stagger-3 rounded-2xl p-4 sm:p-4.5 flex items-center gap-4 cursor-default">
                        <!-- Icon Box (Bar Chart) -->
                        <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center shrink-0 shadow-md">
                            <svg class="w-6 h-6 text-[#0070e0]" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4 19h4V9H4v10zm6 0h4V5h-4v14zm6 0h4v-7h-4v7z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-white text-base tracking-tight">Program Promosi</h3>
                            <p class="text-slate-200 text-xs sm:text-[13px] leading-snug mt-0.5">
                                Lihat seluruh program promosi secara real-time.
                            </p>
                        </div>
                    </div>

                    <!-- Card 2: Realisasi & Verifikasi -->
                    <div class="feature-card anim-stagger-4 rounded-2xl p-4 sm:p-4.5 flex items-center gap-4 cursor-default">
                        <!-- Icon Box (Document with lines / check) -->
                        <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center shrink-0 shadow-md">
                            <svg class="w-6 h-6 text-[#0070e0]" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-white text-base tracking-tight">Realisasi &amp; Verifikasi</h3>
                            <p class="text-slate-200 text-xs sm:text-[13px] leading-snug mt-0.5">
                                Pantau progres realisasi, proses verifikasi, hingga status tagihan.
                            </p>
                        </div>
                    </div>

                    <!-- Card 3: Tagihan & Pembayaran -->
                    <div class="feature-card anim-stagger-5 rounded-2xl p-4 sm:p-4.5 flex items-center gap-4 cursor-default">
                        <!-- Icon Box (Credit Card) -->
                        <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center shrink-0 shadow-md">
                            <svg class="w-6 h-6 text-[#0070e0]" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                                <line x1="2" y1="10" x2="22" y2="10"></line>
                                <line x1="6" y1="15" x2="9" y2="15"></line>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-white text-base tracking-tight">Tagihan &amp; Pembayaran</h3>
                            <p class="text-slate-200 text-xs sm:text-[13px] leading-snug mt-0.5">
                                Kelola tagihan, pantau jatuh tempo, dan pembayaran dengan mudah.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Bottom Footer Note on Left Side -->
            <div class="anim-stagger-5 mt-8 pt-4 flex items-center gap-2.5 text-xs sm:text-[13px] text-slate-300 font-medium">
                <span class="w-6 h-0.5 rounded-full bg-[#e31e24]"></span>
                <span>Sistem Informasi Internal &bull; Mitra Bangunan Supermarket</span>
            </div>

        </div>

        <!-- ============================================================== -->
        <!-- RIGHT LOGIN CARD SECTION -->
        <!-- ============================================================== -->
        <div class="relative z-30 w-full lg:w-[42%] xl:w-[40%] flex items-center justify-center p-4 sm:p-6 lg:p-10 xl:p-12">

            <!-- Floating White Card Container -->
            <div id="card3d" class="w-full max-w-[430px] bg-white rounded-3xl sm:rounded-[32px] p-7 sm:p-9 login-card-shadow relative overflow-hidden transition-all duration-300 anim-card-float">
                
                <!-- Ambient Subtle Top Light Sheen -->
                <div class="absolute -top-32 -left-32 w-64 h-64 bg-blue-100/40 rounded-full blur-3xl pointer-events-none"></div>

                <!-- Animated Light Shimmer Strip -->
                <div class="absolute inset-0 w-1/2 h-full bg-gradient-to-r from-transparent via-white/40 to-transparent pointer-events-none anim-shimmer"></div>

                <!-- Logo Mitra Bangunan Supermarket -->
                <div class="text-center pt-1 mb-5">
                    <img 
                        src="{{ asset('images/logo-transparent.png') }}" 
                        alt="Mitra Bangunan Supermarket" 
                        class="h-14 sm:h-16 w-auto mx-auto object-contain transition-transform duration-300 hover:scale-105"
                        onerror="this.src='{{ asset('images/logo.png') }}'"
                    />
                </div>

                <!-- Form Header -->
                <div class="text-center mb-6">
                    <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 tracking-tight">
                        Monitoring Promosi
                    </h2>
                    <p class="text-xs sm:text-sm text-gray-500 font-normal mt-0.5">
                        Sistem Informasi Internal
                    </p>
                </div>

                <!-- Session Alert / Feedback -->
                @if (session('status'))
                    <div class="mb-4 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm flex items-center gap-2.5 transition-all">
                        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs sm:text-sm flex items-center gap-2.5 transition-all">
                        <svg class="w-4 h-4 text-red-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login.post') }}" id="loginForm" class="space-y-4">
                    @csrf

                    <!-- Email atau Username Field -->
                    <div>
                        <label for="login" class="block text-xs sm:text-[13px] font-semibold text-gray-700 mb-1.5">
                            Email atau username
                        </label>
                        <div class="relative flex items-center group">
                            <!-- Left User Icon -->
                            <div class="absolute left-3.5 text-gray-400 group-focus-within:text-[#0070e0] transition-colors pointer-events-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                            </div>
                            <!-- Input -->
                            <input 
                                type="text" 
                                id="login" 
                                name="login" 
                                value="{{ old('login') }}" 
                                required 
                                autofocus 
                                placeholder="Masukkan email atau username"
                                class="w-full pl-11 pr-4 py-3 bg-[#F9FAFB] hover:bg-white focus:bg-white border border-gray-200 rounded-xl text-gray-900 text-xs sm:text-sm placeholder-gray-400 focus:outline-none focus:border-[#0070e0] focus:ring-4 focus:ring-[#0070e0]/10 transition-all duration-200"
                            />
                        </div>
                    </div>

                    <!-- Kata Sandi Field -->
                    <div>
                        <label for="password" class="block text-xs sm:text-[13px] font-semibold text-gray-700 mb-1.5">
                            Kata sandi
                        </label>
                        <div class="relative flex items-center group">
                            <!-- Left Lock Icon -->
                            <div class="absolute left-3.5 text-gray-400 group-focus-within:text-[#0070e0] transition-colors pointer-events-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                            </div>
                            <!-- Input -->
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                required 
                                placeholder="Masukkan kata sandi"
                                class="w-full pl-11 pr-11 py-3 bg-[#F9FAFB] hover:bg-white focus:bg-white border border-gray-200 rounded-xl text-gray-900 text-xs sm:text-sm placeholder-gray-400 focus:outline-none focus:border-[#0070e0] focus:ring-4 focus:ring-[#0070e0]/10 transition-all duration-200"
                            />
                            <!-- Right Eye Toggle Button -->
                            <button 
                                type="button" 
                                id="togglePasswordBtn" 
                                title="Lihat/Sembunyikan kata sandi"
                                class="absolute right-3 text-gray-400 hover:text-gray-700 p-1 focus:outline-none transition-colors cursor-pointer"
                            >
                                <!-- Eye Icon (Show) -->
                                <svg id="eyeOpenIcon" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <!-- Eye Slash Icon (Hide) -->
                                <svg id="eyeSlashIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Options: Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between pt-1 text-xs sm:text-[13px]">
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input 
                                type="checkbox" 
                                name="remember" 
                                id="remember" 
                                class="w-4 h-4 rounded text-[#0070e0] border-gray-300 focus:ring-[#0070e0] cursor-pointer"
                            />
                            <span class="text-gray-600 font-medium">Ingat saya</span>
                        </label>
                        <button 
                            type="button" 
                            id="forgotPasswordBtn"
                            class="text-[#0070e0] hover:text-[#0056b3] font-semibold hover:underline transition-colors cursor-pointer"
                        >
                            Lupa kata sandi?
                        </button>
                    </div>

                    <!-- Submit Button: Masuk ke Dashboard -->
                    <div class="pt-2">
                        <button 
                            type="submit" 
                            id="submitButton"
                            class="w-full py-3.5 px-5 bg-gradient-to-r from-[#0070e0] to-[#0056b3] hover:from-[#0062c4] hover:to-[#004799] active:scale-[0.99] text-white font-semibold text-xs sm:text-sm rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 transition-all duration-200 flex items-center justify-center gap-2.5 cursor-pointer relative overflow-hidden group"
                        >
                            <!-- Spinner while submitting -->
                            <svg id="loadingSpinner" class="w-4 h-4 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>

                            <!-- Login Right Arrow in Bracket Icon -->
                            <svg id="loginIcon" class="w-5 h-5 transition-transform group-hover:translate-x-1 duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                            </svg>

                            <span id="buttonText">Masuk ke Dashboard</span>
                        </button>
                    </div>
                </form>

                <!-- Divider "atau" -->
                <div class="relative my-6 text-center">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <span class="relative bg-white px-3 text-xs text-gray-400 font-medium tracking-wider">
                        atau
                    </span>
                </div>

                <!-- Security Note: Akses khusus pengguna berwenang -->
                <div class="flex items-center justify-center gap-2 text-xs text-gray-500 font-medium">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                    </svg>
                    <span>Akses khusus pengguna berwenang</span>
                </div>

                <!-- Demo helper pill (quick autofill) -->
                <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between text-[11px] text-gray-400">
                    <span>Akun Demo: <strong>admin</strong> / <strong>admin123</strong></span>
                    <button 
                        type="button" 
                        id="autofillDemoBtn"
                        class="text-[#0070e0] hover:underline font-medium cursor-pointer"
                    >
                        Isi Otomatis
                    </button>
                </div>

            </div>

        </div>

    </div>

    <!-- ============================================================== -->
    <!-- FORGOT PASSWORD MODAL DIALOG -->
    <!-- ============================================================== -->
    <div id="forgotModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">
        <div id="modalBox" class="w-full max-w-sm bg-white rounded-2xl p-6 shadow-2xl transform scale-95 transition-all duration-300 text-center">
            <div class="w-12 h-12 rounded-full bg-blue-50 text-[#0070e0] mx-auto flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Bantuan Kata Sandi</h3>
            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed mb-6">
                Untuk menjaga keamanan Sistem Monitoring Promosi, pemulihan kata sandi dilakukan secara terpusat. Silakan hubungi bagian <strong>IT Support / Administrator MBS</strong>.
            </p>
            <div class="space-y-2">
                <button 
                    type="button" 
                    id="closeModalBtn"
                    class="w-full py-2.5 px-4 bg-[#0070e0] hover:bg-[#0056b3] text-white font-semibold text-xs sm:text-sm rounded-xl transition-colors cursor-pointer"
                >
                    Saya Mengerti
                </button>
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- JAVASCRIPT: INTERACTIVE ANIMATIONS & CONTROLS -->
    <!-- ============================================================== -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Password Visibility Toggle
            const togglePasswordBtn = document.getElementById('togglePasswordBtn');
            const passwordInput = document.getElementById('password');
            const eyeOpenIcon = document.getElementById('eyeOpenIcon');
            const eyeSlashIcon = document.getElementById('eyeSlashIcon');

            if (togglePasswordBtn && passwordInput) {
                togglePasswordBtn.addEventListener('click', function () {
                    const isPassword = passwordInput.getAttribute('type') === 'password';
                    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                    eyeOpenIcon.classList.toggle('hidden', isPassword);
                    eyeSlashIcon.classList.toggle('hidden', !isPassword);
                });
            }

            // 2. Form Submit Animation & Spinner
            const loginForm = document.getElementById('loginForm');
            const submitButton = document.getElementById('submitButton');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const loginIcon = document.getElementById('loginIcon');
            const buttonText = document.getElementById('buttonText');

            if (loginForm && submitButton) {
                loginForm.addEventListener('submit', function () {
                    submitButton.disabled = true;
                    submitButton.classList.add('opacity-85', 'cursor-not-allowed');
                    loadingSpinner.classList.remove('hidden');
                    loginIcon.classList.add('hidden');
                    buttonText.textContent = 'Memverifikasi...';
                });
            }

            // 3. Demo Autofill Button
            const autofillDemoBtn = document.getElementById('autofillDemoBtn');
            const loginInput = document.getElementById('login');

            if (autofillDemoBtn && loginInput && passwordInput) {
                autofillDemoBtn.addEventListener('click', function () {
                    loginInput.value = 'admin';
                    passwordInput.value = 'admin123';
                    loginInput.classList.add('ring-2', 'ring-[#0070e0]');
                    setTimeout(() => loginInput.classList.remove('ring-2', 'ring-[#0070e0]'), 500);
                });
            }

            // 4. Forgot Password Modal
            const forgotPasswordBtn = document.getElementById('forgotPasswordBtn');
            const forgotModal = document.getElementById('forgotModal');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const modalBox = document.getElementById('modalBox');

            function openModal() {
                forgotModal.classList.remove('opacity-0', 'pointer-events-none');
                forgotModal.classList.add('opacity-100');
                modalBox.classList.remove('scale-95');
                modalBox.classList.add('scale-100');
            }

            function closeModal() {
                forgotModal.classList.remove('opacity-100');
                forgotModal.classList.add('opacity-0', 'pointer-events-none');
                modalBox.classList.remove('scale-100');
                modalBox.classList.add('scale-95');
            }

            if (forgotPasswordBtn) forgotPasswordBtn.addEventListener('click', openModal);
            if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
            if (forgotModal) {
                forgotModal.addEventListener('click', function (e) {
                    if (e.target === forgotModal) closeModal();
                });
            }

            // 5. Desktop Subtle 3D Card Parallax / Tilt
            const card3d = document.getElementById('card3d');
            if (card3d && window.innerWidth >= 1024) {
                document.addEventListener('mousemove', function (e) {
                    const x = (window.innerWidth / 2 - e.clientX) / 75;
                    const y = (window.innerHeight / 2 - e.clientY) / 75;
                    card3d.style.transform = `perspective(1000px) rotateY(${-x}deg) rotateX(${y}deg)`;
                });

                document.addEventListener('mouseleave', function () {
                    card3d.style.transform = 'perspective(1000px) rotateY(0deg) rotateX(0deg)';
                });
            }
        });
    </script>
</body>
</html>
