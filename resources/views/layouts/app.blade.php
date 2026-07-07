<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIPANDA - Kecamatan Cicalengka')</title>
    
    <!-- Meta SEO -->
    <meta name="description" content="SIPANDA (Sistem Informasi Pengajuan dan Pendataan UMKM) - Seksi Pemberdayaan Masyarakat Kecamatan Cicalengka. Fasilitas pendataan dan administrasi UMKM.">
    <meta name="keywords" content="SIPANDA, UMKM, Cicalengka, Pendataan UMKM, Kabupaten Bandung, Pemberdayaan Masyarakat">
    <meta name="author" content="Pemerintah Kecamatan Cicalengka">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        },
                        secondary: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    },
                    fontFamily: {
                        sans: ['Outfit', 'Inter', 'sans-serif'],
                        inter: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        .glass-nav {
            background-color: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        }
    </style>
</head>
<body class="bg-slate-50 text-secondary-800 font-sans min-h-screen flex flex-col justify-between antialiased">

    <!-- Header / Sticky Navbar -->
    <header class="sticky top-0 z-50 glass-nav transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('landing') }}" class="flex items-center space-x-3 group">
                        <img src="{{ asset('logo-icon.png') }}?v=3" alt="SIPANDA Logo" class="w-12 h-12 object-contain rounded-full bg-white p-0.5 border border-slate-200 shadow-sm group-hover:scale-105 transition-transform duration-300">
                        <div>
                            <span class="text-2xl font-bold tracking-tight text-secondary-900 bg-gradient-to-r from-primary-700 to-emerald-500 bg-clip-text text-transparent">SIPANDA</span>
                            <p class="text-[10px] text-secondary-500 font-medium tracking-widest uppercase">Kec. Cicalengka</p>
                        </div>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('landing') }}#hero" class="text-sm font-semibold text-secondary-600 hover:text-primary-600 transition-colors duration-200">Beranda</a>
                    <a href="{{ route('landing') }}#tentang" class="text-sm font-semibold text-secondary-600 hover:text-primary-600 transition-colors duration-200">Tentang</a>
                    <a href="{{ route('landing') }}#alur" class="text-sm font-semibold text-secondary-600 hover:text-primary-600 transition-colors duration-200">Alur</a>
                    <a href="{{ route('landing') }}#syarat" class="text-sm font-semibold text-secondary-600 hover:text-primary-600 transition-colors duration-200">Syarat</a>
                    <a href="{{ route('cek-status') }}" class="text-sm font-semibold text-secondary-600 hover:text-primary-600 transition-colors duration-200">Cek Status</a>
                    <a href="{{ route('ajukan') }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-primary-600 to-emerald-500 hover:from-primary-700 hover:to-emerald-600 shadow-md shadow-primary-100 hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5">
                        Ajukan Pendataan
                    </a>
                </nav>

                <!-- Mobile Menu Button -->
                <div class="flex items-center md:hidden">
                    <button type="button" onclick="toggleMobileMenu()" class="inline-flex items-center justify-center p-2 rounded-xl text-secondary-600 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-500" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Buka menu utama</span>
                        <svg class="h-6 w-6" id="menu-icon-open" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <svg class="hidden h-6 w-6" id="menu-icon-close" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu, show/hide based on menu state. -->
        <div class="hidden md:hidden border-b border-slate-100 bg-white" id="mobile-menu">
            <div class="px-4 pt-2 pb-6 space-y-3">
                <a href="{{ route('landing') }}#hero" onclick="toggleMobileMenu()" class="block px-4 py-2.5 rounded-xl text-base font-semibold text-secondary-700 hover:bg-slate-50 hover:text-primary-600 transition-colors">Beranda</a>
                <a href="{{ route('landing') }}#tentang" onclick="toggleMobileMenu()" class="block px-4 py-2.5 rounded-xl text-base font-semibold text-secondary-700 hover:bg-slate-50 hover:text-primary-600 transition-colors">Tentang</a>
                <a href="{{ route('landing') }}#alur" onclick="toggleMobileMenu()" class="block px-4 py-2.5 rounded-xl text-base font-semibold text-secondary-700 hover:bg-slate-50 hover:text-primary-600 transition-colors">Alur</a>
                <a href="{{ route('landing') }}#syarat" onclick="toggleMobileMenu()" class="block px-4 py-2.5 rounded-xl text-base font-semibold text-secondary-700 hover:bg-slate-50 hover:text-primary-600 transition-colors">Syarat</a>
                <a href="{{ route('cek-status') }}" onclick="toggleMobileMenu()" class="block px-4 py-2.5 rounded-xl text-base font-semibold text-secondary-700 hover:bg-slate-50 hover:text-primary-600 transition-colors">Cek Status</a>
                <div class="pt-2">
                    <a href="{{ route('ajukan') }}" onclick="toggleMobileMenu()" class="block w-full text-center px-4 py-3 rounded-xl text-base font-semibold text-white bg-gradient-to-r from-primary-600 to-emerald-500 hover:from-primary-700 hover:to-emerald-600 shadow-md transition-all">
                        Ajukan Pendataan
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-secondary-900 text-slate-400 py-16 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
                <!-- Branding Cicalengka -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('logo-icon.png') }}?v=3" alt="SIPANDA Logo" class="w-10 h-10 object-contain rounded-full bg-white p-0.5 border border-slate-850">
                        <span class="text-xl font-bold tracking-tight text-white">SIPANDA KEC. CICALENGKA</span>
                    </div>
                    <p class="text-sm leading-relaxed text-slate-400">
                        Sistem Informasi Pengajuan dan Pendataan UMKM di Seksi Pemberdayaan Masyarakat Kecamatan Cicalengka, Kabupaten Bandung.
                    </p>
                    <p class="text-xs text-slate-500">
                        &copy; {{ date('Y') }} Seksi Pemberdayaan Masyarakat Kecamatan Cicalengka. All rights reserved.
                    </p>
                </div>

                <!-- Alamat Instansi -->
                <div class="space-y-4">
                    <h3 class="text-white font-semibold text-lg">Kontak & Alamat</h3>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li class="flex items-start space-x-3">
                            <!-- Pin Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-primary-500 shrink-0 mt-0.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                            <span>Jl. Raya Cicalengka No. 320, Cicalengka Kulon, Kec. Cicalengka, Kabupaten Bandung, Jawa Barat 40395</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <!-- Envelope Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-primary-500 shrink-0">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                            <span>kecamatan.cicalengka@bandungkab.go.id</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <!-- Phone Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-primary-500 shrink-0">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.387a12.035 12.035 0 0 1-7.108-7.108c-.115-.44.05-1.21.387-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                            </svg>
                            <span>(022) 7949015</span>
                        </li>
                    </ul>
                </div>

                <!-- Tautan Berguna -->
                <div class="space-y-4">
                    <h3 class="text-white font-semibold text-lg">Tautan Terkait</h3>
                    <ul class="space-y-2.5 text-sm text-slate-400">
                        <li><a href="https://www.bandungkab.go.id/" target="_blank" rel="noopener noreferrer" class="hover:text-primary-400 transition-colors">Website Pemkab Bandung</a></li>
                        <li><a href="https://jabarprov.go.id/" target="_blank" rel="noopener noreferrer" class="hover:text-primary-400 transition-colors">Website Pemprov Jabar</a></li>
                        <li><a href="{{ route('admin.login') }}" class="hover:text-primary-400 transition-colors flex items-center space-x-1.5">
                            <span>Portal Admin Internal</span>
                            <!-- Lock icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                            </svg>
                        </a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-slate-800 pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500">
                <p>Didukung oleh Seksi Pemberdayaan Masyarakat Kecamatan Cicalengka.</p>
                <div class="flex space-x-4 mt-4 sm:mt-0">
                    <a href="#" class="hover:underline">Kebijakan Privasi</a>
                    <a href="#" class="hover:underline">Syarat Layanan</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Script for mobile menu -->
    <script>
        function toggleMobileMenu() {
            var menu = document.getElementById('mobile-menu');
            var iconOpen = document.getElementById('menu-icon-open');
            var iconClose = document.getElementById('menu-icon-close');
            
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                iconOpen.classList.add('hidden');
                iconClose.classList.remove('hidden');
            } else {
                menu.classList.add('hidden');
                iconOpen.classList.remove('hidden');
                iconClose.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
