<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sistem Pengaduan Mahasiswa - UNHAS</title>

        <!-- Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            cream: {
                                50: '#fefdf9',
                                100: '#fcfaf1',
                                200: '#f9f3e0',
                                300: '#f5e9c8',
                            },
                            unhas: {
                                50: '#e8f0f5',
                                100: '#c5d9e6',
                                200: '#a2c2d7',
                                300: '#7faac8',
                                400: '#5c93b9',
                                500: '#1B3C53',  // Warna biru utama
                                600: '#163448',
                                700: '#122b3c',
                                800: '#0e2231',
                                900: '#0a1925',
                            }
                        },
                        animation: {
                            'float': 'float 6s ease-in-out infinite',
                            'pulse-glow': 'pulse-glow 2s infinite',
                            'slide-in': 'slide-in 0.6s ease-out',
                        },
                        keyframes: {
                            'float': {
                                '0%, 100%': { transform: 'translateY(0px)' },
                                '50%': { transform: 'translateY(-20px)' },
                            },
                            'pulse-glow': {
                                '0%, 100%': { opacity: '1' },
                                '50%': { opacity: '0.7' },
                            },
                            'slide-in': {
                                'from': { transform: 'translateY(30px)', opacity: '0' },
                                'to': { transform: 'translateY(0)', opacity: '1' },
                            }
                        }
                    }
                }
            }
        </script>

        <!-- Fonts & Icons -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

        <style>
            body {
                font-family: 'Inter', 'Instrument Sans', sans-serif;
            }
            
            .gradient-bg {
                background: linear-gradient(135deg, #fefdf9 0%, #f7f9fb 100%);
            }
            
            .hero-gradient {
                background: linear-gradient(135deg, #1B3C53 0%, #0a1925 100%);
            }
            
            .loading-dots span {
                animation: loading 1.4s infinite ease-in-out both;
                background-color: #1B3C53;
                border-radius: 50%;
                display: inline-block;
                height: 8px;
                width: 8px;
                margin: 0 2px;
            }
            
            .loading-dots span:nth-child(1) { animation-delay: -0.32s; }
            .loading-dots span:nth-child(2) { animation-delay: -0.16s; }
            
            @keyframes loading {
                0%, 80%, 100% { transform: scale(0); }
                40% { transform: scale(1.0); }
            }
            
            .fade-in {
                opacity: 0;
                transform: translateY(30px);
                transition: opacity 0.6s ease, transform 0.6s ease;
            }
            
            .fade-in.visible {
                opacity: 1;
                transform: translateY(0);
            }
            
            .unhas-card {
                border: 1px solid rgba(27, 60, 83, 0.1);
                transition: all 0.3s ease;
            }
            
            .unhas-card:hover {
                border-color: #1B3C53;
                box-shadow: 0 20px 40px rgba(27, 60, 83, 0.15);
                transform: translateY(-5px);
            }
        </style>
    </head>
    <body class="gradient-bg min-h-screen">
        <!-- Header -->
        <header class="fixed top-0 left-0 right-0 bg-white/90 backdrop-blur-lg border-b border-gray-100 z-50 py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-unhas-500 to-unhas-700 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L2 7L12 12L22 7L12 2Z" fill="currentColor"/>
                            <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2"/>
                            <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">SIPEMA UNHAS</h1>
                        <p class="text-sm text-gray-600">Sistem Pengaduan Mahasiswa</p>
                    </div>
                </div>

                <nav class="flex items-center space-x-6">
                    <a href="#features" class="text-gray-700 hover:text-unhas-600 font-medium transition-colors hidden md:block">Fitur</a>
                    <a href="#process" class="text-gray-700 hover:text-unhas-600 font-medium transition-colors hidden md:block">Cara Kerja</a>
                    
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-gradient-to-r from-unhas-500 to-unhas-700 hover:from-unhas-600 hover:to-unhas-800 px-8 py-3 text-white font-semibold rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="border-2 border-unhas-500 hover:border-unhas-600 hover:bg-unhas-50 px-6 py-2.5 text-unhas-600 font-semibold rounded-lg transition-colors duration-300">
                                <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-gradient-to-r from-unhas-500 to-unhas-700 hover:from-unhas-600 hover:to-unhas-800 px-8 py-3 text-white font-semibold rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                                    <i class="fas fa-user-plus mr-2"></i>Daftar
                                </a>
                            @endif
                        @endauth
                    @endif
                </nav>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="pt-24 min-h-screen flex items-center relative overflow-hidden">
            <!-- Background Elements -->
            <div class="absolute top-1/4 left-1/4 w-72 h-72 bg-unhas-100 rounded-full opacity-20 animate-float"></div>
            <div class="absolute bottom-1/4 right-1/4 w-64 h-64 bg-cream-200 rounded-full opacity-30 animate-float" style="animation-delay: 2s;"></div>
            <div class="absolute top-1/3 right-1/3 w-48 h-48 bg-unhas-50 rounded-full opacity-40 animate-float" style="animation-delay: 4s;"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <!-- Left Content -->
                    <div class="space-y-8 fade-in">
                        <div class="space-y-6">
                            <div class="inline-flex items-center px-4 py-2 bg-unhas-100 text-unhas-700 rounded-full text-sm font-semibold">
                                <span class="w-2 h-2 bg-unhas-500 rounded-full mr-2"></span>
                                Platform Resmi Universitas Hasanuddin
                            </div>
                            
                            <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-gray-900 leading-tight">
                                Suara Anda
                                <span class="text-unhas-500 block mt-2">Bermakna Bagi Kita</span>
                            </h1>
                            
                            <p class="text-lg sm:text-xl text-gray-600 leading-relaxed">
                                Wadah aspirasi mahasiswa UNHAS untuk menyampaikan pengaduan, 
                                keluhan, dan masukan yang membangun demi kampus yang lebih baik.
                            </p>
                        </div>

                        <!-- Quick Stats -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            <div class="unhas-card bg-white/80 backdrop-blur-sm p-4 rounded-2xl text-center">
                                <div class="text-2xl font-bold text-unhas-600">1,247</div>
                                <div class="text-sm text-gray-600">Sedang Diproses</div>
                            </div>
                            <div class="unhas-card bg-white/80 backdrop-blur-sm p-4 rounded-2xl text-center">
                                <div class="text-2xl font-bold text-unhas-600">8,956</div>
                                <div class="text-sm text-gray-600">Terselesaikan</div>
                            </div>
                            <div class="unhas-card bg-white/80 backdrop-blur-sm p-4 rounded-2xl text-center">
                                <div class="text-2xl font-bold text-unhas-600">98%</div>
                                <div class="text-sm text-gray-600">Kepuasan</div>
                            </div>
                            <div class="unhas-card bg-white/80 backdrop-blur-sm p-4 rounded-2xl text-center">
                                <div class="text-2xl font-bold text-unhas-600">2.3</div>
                                <div class="text-sm text-gray-600">Hari Rata-rata</div>
                            </div>
                        </div>

                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row gap-6 pt-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="bg-gradient-to-r from-unhas-500 to-unhas-700 hover:from-unhas-600 hover:to-unhas-800 px-10 py-4 text-white font-semibold rounded-xl text-lg shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 flex items-center justify-center">
                                    <i class="fas fa-rocket mr-3"></i>Masuk Dashboard
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="bg-gradient-to-r from-unhas-500 to-unhas-700 hover:from-unhas-600 hover:to-unhas-800 px-10 py-4 text-white font-semibold rounded-xl text-lg shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 flex items-center justify-center">
                                    <i class="fas fa-plus-circle mr-3"></i>Buat Pengaduan Baru
                                </a>
                                <a href="{{ route('login') }}" class="border-2 border-unhas-500 hover:border-unhas-600 hover:bg-unhas-50 px-10 py-4 text-unhas-600 font-semibold rounded-xl text-lg hover:-translate-y-1 transition-all duration-300 flex items-center justify-center">
                                    <i class="fas fa-sign-in-alt mr-3"></i>Masuk Akun
                                </a>
                            @endauth
                        </div>
                    </div>

                    <!-- Right Content - Visual Dashboard -->
                    <div class="relative fade-in">
                        <div class="unhas-card bg-white rounded-3xl p-6 sm:p-8 shadow-2xl transform rotate-1">
                            <!-- Dashboard Header -->
                            <div class="hero-gradient rounded-2xl p-6 text-white mb-8">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
                                    <div>
                                        <h3 class="text-xl sm:text-2xl font-bold">Dashboard Pengaduan</h3>
                                        <p class="opacity-90 text-sm sm:text-base">Real-time Monitoring</p>
                                    </div>
                                    <span class="bg-white/20 px-4 py-2 rounded-full text-sm font-medium animate-pulse inline-flex items-center">
                                        <span class="loading-dots mr-2"><span></span><span></span><span></span></span> LIVE
                                    </span>
                                </div>
                                
                                <!-- Progress Bars -->
                                <div class="space-y-4">
                                    <div>
                                        <div class="flex justify-between mb-1 text-sm">
                                            <span>Pengolahan Data</span>
                                            <span class="font-bold">85%</span>
                                        </div>
                                        <div class="h-2 bg-white/30 rounded-full overflow-hidden">
                                            <div class="h-full bg-white rounded-full" style="width: 85%;"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-1 text-sm">
                                            <span>Verifikasi</span>
                                            <span class="font-bold">92%</span>
                                        </div>
                                        <div class="h-2 bg-white/30 rounded-full overflow-hidden">
                                            <div class="h-full bg-white rounded-full" style="width: 92%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Activity Feed -->
                            <div class="space-y-6">
                                <h4 class="text-lg sm:text-xl font-semibold text-gray-800 flex items-center">
                                    <i class="fas fa-bell text-unhas-500 mr-3"></i>Aktivitas Terkini
                                </h4>
                                
                                <div class="space-y-4">
                                    <div class="unhas-card flex items-center p-3 bg-unhas-50 rounded-xl">
                                        <div class="w-10 h-10 bg-unhas-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                            <i class="fas fa-check text-unhas-600"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-medium text-gray-800 truncate">Pengaduan #2456 diselesaikan</p>
                                            <p class="text-sm text-gray-600">2 menit yang lalu</p>
                                        </div>
                                    </div>
                                    
                                    <div class="unhas-card flex items-center p-3 bg-unhas-50 rounded-xl">
                                        <div class="w-10 h-10 bg-unhas-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                            <i class="fas fa-clock text-unhas-600"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-medium text-gray-800 truncate">Pengaduan baru diterima</p>
                                            <p class="text-sm text-gray-600">15 menit yang lalu</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Floating Icons -->
                        <div class="absolute -top-4 -right-4 w-16 h-16 sm:w-20 sm:h-20 bg-white rounded-2xl shadow-xl flex items-center justify-center animate-float hidden sm:flex">
                            <i class="fas fa-shield-alt text-2xl sm:text-3xl text-unhas-500"></i>
                        </div>
                        <div class="absolute -bottom-4 -left-4 w-14 h-14 bg-unhas-100 rounded-2xl flex items-center justify-center animate-float hidden sm:flex" style="animation-delay: 2s;">
                            <i class="fas fa-bolt text-xl sm:text-2xl text-unhas-600"></i>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-16 sm:py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-white to-cream-50">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-12 sm:mb-16 fade-in">
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Mengapa Memilih SIPEMA?</h2>
                    <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto px-4">Platform pengaduan terintegrasi yang dirancang khusus untuk kebutuhan mahasiswa UNHAS</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
                    <!-- Feature 1 -->
                    <div class="unhas-card bg-white p-6 sm:p-8 rounded-3xl fade-in">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-unhas-100 to-unhas-200 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-user-shield text-2xl sm:text-3xl text-unhas-600"></i>
                        </div>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 text-center">Privasi Terjamin</h3>
                        <p class="text-gray-600 text-center text-sm sm:text-base">Identitas Anda dirahasiakan dengan sistem enkripsi tingkat tinggi</p>
                        <div class="mt-6 pt-6 border-t border-gray-100 text-center">
                            <span class="text-xs sm:text-sm text-unhas-600 font-semibold inline-flex items-center">
                                <i class="fas fa-lock mr-1"></i>Keamanan ISO 27001
                            </span>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="unhas-card bg-white p-6 sm:p-8 rounded-3xl fade-in" style="animation-delay: 0.1s;">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-unhas-100 to-unhas-200 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-bolt text-2xl sm:text-3xl text-unhas-600"></i>
                        </div>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 text-center">Respon Kilat</h3>
                        <p class="text-gray-600 text-center text-sm sm:text-base">Pengaduan ditindaklanjuti maksimal 3 hari kerja oleh tim terkait</p>
                        <div class="mt-6 pt-6 border-t border-gray-100 text-center">
                            <span class="text-xs sm:text-sm text-unhas-600 font-semibold inline-flex items-center">
                                <i class="fas fa-clock mr-1"></i>24/7 Monitoring
                            </span>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="unhas-card bg-white p-6 sm:p-8 rounded-3xl fade-in" style="animation-delay: 0.2s;">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-unhas-100 to-unhas-200 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-chart-line text-2xl sm:text-3xl text-unhas-600"></i>
                        </div>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 text-center">Transparansi Total</h3>
                        <p class="text-gray-600 text-center text-sm sm:text-base">Pantau setiap tahap pengaduan secara real-time dengan dashboard</p>
                        <div class="mt-6 pt-6 border-t border-gray-100 text-center">
                            <span class="text-xs sm:text-sm text-unhas-600 font-semibold inline-flex items-center">
                                <i class="fas fa-eye mr-1"></i>Real-time Tracking
                            </span>
                        </div>
                    </div>

                    <!-- Feature 4 -->
                    <div class="unhas-card bg-white p-6 sm:p-8 rounded-3xl fade-in" style="animation-delay: 0.3s;">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-unhas-100 to-unhas-200 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-handshake text-2xl sm:text-3xl text-unhas-600"></i>
                        </div>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 text-center">Kolaborasi Optimal</h3>
                        <p class="text-gray-600 text-center text-sm sm:text-base">Kerjasama antara mahasiswa, dosen, dan staff untuk solusi terbaik</p>
                        <div class="mt-6 pt-6 border-t border-gray-100 text-center">
                            <span class="text-xs sm:text-sm text-unhas-600 font-semibold inline-flex items-center">
                                <i class="fas fa-users mr-1"></i>Multi-stakeholder
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Process Section -->
        <section id="process" class="py-16 sm:py-20 px-4 sm:px-6 lg:px-8 bg-white">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-12 sm:mb-16 fade-in">
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Bagaimana Cara Kerjanya?</h2>
                    <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto px-4">Hanya 3 langkah sederhana untuk menyampaikan pengaduan Anda</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8 sm:gap-12 relative">
                    <!-- Connecting Line -->
                    <div class="hidden md:block absolute top-1/2 left-0 right-0 h-1 bg-gradient-to-r from-unhas-400/20 via-unhas-400/40 to-unhas-400/20 transform -translate-y-1/2 z-0"></div>

                    <!-- Step 1 -->
                    <div class="relative z-10 fade-in">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 bg-gradient-to-br from-unhas-500 to-unhas-700 rounded-2xl flex items-center justify-center text-white font-bold text-xl sm:text-2xl mb-6 sm:mb-8 mx-auto shadow-lg">
                            1
                        </div>
                        <div class="unhas-card bg-white p-6 sm:p-8 rounded-3xl shadow-xl">
                            <div class="w-12 h-12 sm:w-14 sm:h-14 bg-unhas-100 rounded-xl flex items-center justify-center mb-4 sm:mb-6 mx-auto">
                                <i class="fas fa-user-plus text-xl sm:text-2xl text-unhas-600"></i>
                            </div>
                            <h3 class="text-lg sm:text-xl font-bold text-center text-gray-800 mb-3 sm:mb-4">Daftar & Masuk</h3>
                            <p class="text-gray-600 text-center text-sm sm:text-base">Gunakan NIM dan password kampus Anda untuk mengakses sistem</p>
                            <div class="mt-4 sm:mt-6 text-center">
                                <span class="inline-flex items-center text-xs sm:text-sm text-unhas-600 font-semibold">
                                    <i class="fas fa-fingerprint mr-2"></i>SSO UNHAS
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative z-10 fade-in" style="animation-delay: 0.2s;">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 bg-gradient-to-br from-unhas-500 to-unhas-700 rounded-2xl flex items-center justify-center text-white font-bold text-xl sm:text-2xl mb-6 sm:mb-8 mx-auto shadow-lg">
                            2
                        </div>
                        <div class="unhas-card bg-white p-6 sm:p-8 rounded-3xl shadow-xl">
                            <div class="w-12 h-12 sm:w-14 sm:h-14 bg-unhas-100 rounded-xl flex items-center justify-center mb-4 sm:mb-6 mx-auto">
                                <i class="fas fa-edit text-xl sm:text-2xl text-unhas-600"></i>
                            </div>
                            <h3 class="text-lg sm:text-xl font-bold text-center text-gray-800 mb-3 sm:mb-4">Isi Form Pengaduan</h3>
                            <p class="text-gray-600 text-center text-sm sm:text-base">Jelaskan pengaduan Anda dengan detail dan lampirkan bukti pendukung</p>
                            <div class="mt-4 sm:mt-6 text-center">
                                <span class="inline-flex items-center text-xs sm:text-sm text-unhas-600 font-semibold">
                                    <i class="fas fa-paperclip mr-2"></i>Support Upload File
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative z-10 fade-in" style="animation-delay: 0.4s;">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 bg-gradient-to-br from-unhas-500 to-unhas-700 rounded-2xl flex items-center justify-center text-white font-bold text-xl sm:text-2xl mb-6 sm:mb-8 mx-auto shadow-lg">
                            3
                        </div>
                        <div class="unhas-card bg-white p-6 sm:p-8 rounded-3xl shadow-xl">
                            <div class="w-12 h-12 sm:w-14 sm:h-14 bg-unhas-100 rounded-xl flex items-center justify-center mb-4 sm:mb-6 mx-auto">
                                <i class="fas fa-chart-bar text-xl sm:text-2xl text-unhas-600"></i>
                            </div>
                            <h3 class="text-lg sm:text-xl font-bold text-center text-gray-800 mb-3 sm:mb-4">Pantau & Verifikasi</h3>
                            <p class="text-gray-600 text-center text-sm sm:text-base">Lacak perkembangan dan terima notifikasi setiap ada update</p>
                            <div class="mt-4 sm:mt-6 text-center">
                                <span class="inline-flex items-center text-xs sm:text-sm text-unhas-600 font-semibold">
                                    <i class="fas fa-bell mr-2"></i>Real-time Notification
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Final CTA -->
                <div class="mt-12 sm:mt-20 text-center fade-in">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center bg-gradient-to-r from-unhas-500 to-unhas-700 hover:from-unhas-600 hover:to-unhas-800 px-8 sm:px-12 py-4 sm:py-5 text-white font-bold rounded-2xl text-base sm:text-lg shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                            <i class="fas fa-play-circle mr-3 text-lg sm:text-xl"></i>Lanjutkan ke Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="inline-flex items-center bg-gradient-to-r from-unhas-500 to-unhas-700 hover:from-unhas-600 hover:to-unhas-800 px-8 sm:px-12 py-4 sm:py-5 text-white font-bold rounded-2xl text-base sm:text-lg shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                            <i class="fas fa-rocket mr-3 text-lg sm:text-xl"></i>Mulai Sekarang Gratis
                        </a>
                    @endauth
                    <p class="mt-4 text-gray-600 text-sm sm:text-base">Tidak memerlukan biaya apapun - Layanan untuk seluruh civitas UNHAS</p>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gradient-to-r from-gray-900 to-gray-800 text-white py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="grid md:grid-cols-3 gap-8 sm:gap-12">
                    <div>
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-unhas-500 to-unhas-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-graduation-cap text-xl sm:text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl sm:text-2xl font-bold">SIPEMA UNHAS</h3>
                                <p class="text-unhas-300 text-sm sm:text-base">Sistem Pengaduan Mahasiswa</p>
                            </div>
                        </div>
                        <p class="text-gray-300 mb-6 text-sm sm:text-base">
                            Platform resmi Universitas Hasanuddin untuk menampung aspirasi dan pengaduan mahasiswa demi terciptanya lingkungan kampus yang lebih baik.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-unhas-500 transition-colors">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-unhas-500 transition-colors">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-unhas-500 transition-colors">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg sm:text-xl font-bold mb-6">Kontak</h4>
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-map-marker-alt text-unhas-400 mt-1"></i>
                                <span class="text-gray-300 text-sm sm:text-base">Jl. Perintis Kemerdekaan Km. 10, Makassar</span>
                            </div>
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-phone text-unhas-400 mt-1"></i>
                                <span class="text-gray-300 text-sm sm:text-base">(0411) 586200</span>
                            </div>
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-envelope text-unhas-400 mt-1"></i>
                                <span class="text-gray-300 text-sm sm:text-base">sipema@unhas.ac.id</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg sm:text-xl font-bold mb-6">Waktu Operasional</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center pb-3 border-b border-gray-700">
                                <span class="text-gray-300 text-sm sm:text-base">Senin - Jumat</span>
                                <span class="font-semibold text-unhas-300 text-sm sm:text-base">08:00 - 16:00</span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b border-gray-700">
                                <span class="text-gray-300 text-sm sm:text-base">Sabtu</span>
                                <span class="font-semibold text-unhas-300 text-sm sm:text-base">08:00 - 14:00</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-300 text-sm sm:text-base">Minggu</span>
                                <span class="font-semibold text-unhas-300 text-sm sm:text-base">Tutup</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 sm:mt-12 pt-6 sm:pt-8 border-t border-gray-700 text-center">
                    <p class="text-gray-400 text-sm sm:text-base">© {{ date('Y') }} SIPEMA UNHAS - Universitas Hasanuddin. Hak Cipta Dilindungi.</p>
                    <p class="text-xs sm:text-sm text-gray-500 mt-2">Versi 2.0.1 | Terakhir diperbarui: {{ date('d M Y') }}</p>
                </div>
            </div>
        </footer>

        <!-- Back to Top Button -->
        <button id="backToTop" class="fixed bottom-6 right-6 w-12 h-12 sm:w-14 sm:h-14 bg-unhas-500 text-white rounded-full shadow-2xl flex items-center justify-center hover:bg-unhas-600 transition-colors z-50 opacity-0 transform translate-y-10 transition-all duration-300">
            <i class="fas fa-arrow-up"></i>
        </button>

        <script>
            // Scroll Animation
            const fadeElements = document.querySelectorAll('.fade-in');
            
            const fadeInOnScroll = () => {
                fadeElements.forEach(element => {
                    const elementTop = element.getBoundingClientRect().top;
                    const elementVisible = 150;
                    
                    if (elementTop < window.innerHeight - elementVisible) {
                        element.classList.add('visible');
                    }
                });
            };

            // Back to Top Button
            const backToTopBtn = document.getElementById('backToTop');
            
            window.addEventListener('scroll', () => {
                fadeInOnScroll();
                
                // Show/hide back to top button
                if (window.pageYOffset > 300) {
                    backToTopBtn.style.opacity = '1';
                    backToTopBtn.style.transform = 'translateY(0)';
                } else {
                    backToTopBtn.style.opacity = '0';
                    backToTopBtn.style.transform = 'translateY(10px)';
                }
            });

            // Initial check
            fadeInOnScroll();

            // Back to top functionality
            backToTopBtn.addEventListener('click', () => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            // Add loading animation to stats
            const statNumbers = document.querySelectorAll('.bg-white\\/80 .text-2xl');
            statNumbers.forEach((stat, index) => {
                const originalText = stat.textContent;
                const finalNumber = parseInt(originalText.replace(/,/g, ''));
                if (!isNaN(finalNumber)) {
                    let current = 0;
                    const increment = finalNumber / 50;
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= finalNumber) {
                            current = finalNumber;
                            clearInterval(timer);
                        }
                        stat.textContent = Math.floor(current).toLocaleString();
                    }, 30 + (index * 10));
                }
            });

            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Add pulse animation to CTA buttons on hover
            const ctaButtons = document.querySelectorAll('.bg-gradient-to-r');
            ctaButtons.forEach(button => {
                button.addEventListener('mouseenter', () => {
                    button.style.animation = 'pulse-glow 2s infinite';
                });
                button.addEventListener('mouseleave', () => {
                    button.style.animation = '';
                });
            });
        </script>
    </body>
</html>