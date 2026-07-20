<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin SIPANDA') - Kec. Cicalengka</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css'])
    <style>
        .sunda-bilik {
            background-color: #ffffff !important;
            background-image: linear-gradient(rgba(255, 255, 255, 0.80), rgba(255, 255, 255, 0.80)), url('{{ asset("bg-sunda.jpg") }}') !important;
            background-repeat: repeat !important;
            background-size: 500px auto !important;
        }
        .organic-card {
            border: 1px solid rgba(181, 142, 88, 0.15) !important;
            box-shadow: 0 10px 30px -10px rgba(167, 111, 48, 0.08), 0 1px 3px rgba(43, 90, 39, 0.02) !important;
        }
        .bg-white {
            background-color: rgba(255, 255, 255, 0.95) !important;
        }
        /* Style adjustments for sidebar and elements */
        aside {
            background-color: #161a16 !important; /* Deep forest charcoal */
            border-right: 3px solid #b58e58 !important; /* Bamboo Gold border */
        }
        aside .border-secondary-800 {
            border-color: rgba(181, 142, 88, 0.15) !important;
        }
        input:focus, select:focus, textarea:focus {
            border-color: #a76f30 !important;
            box-shadow: 0 0 0 2px rgba(181, 142, 88, 0.2) !important;
        }

        /* Sundanese Decorative Accents */
        .filigree-container {
            position: relative;
            background-color: #ffffff;
            border: 2px solid rgba(181, 142, 88, 0.2);
            border-radius: 1.5rem;
            padding: 2.5rem;
            z-index: 10;
            overflow: hidden;
        }
        .filigree-container::before {
            content: "";
            position: absolute;
            top: 8px; left: 8px; right: 8px; bottom: 8px;
            border: 1px dashed rgba(181, 142, 88, 0.2);
            border-radius: 1.25rem;
            pointer-events: none;
            z-index: 1;
        }
        
        /* Subtle Edge Corner Brackets */
        .corner-decor {
            position: absolute;
            width: 20px;
            height: 20px;
            border: 3px solid #b58e58;
            pointer-events: none;
            z-index: 20;
        }
        .corner-tl { top: 14px; left: 14px; border-right: none; border-bottom: none; }
        .corner-tr { top: 14px; right: 14px; border-left: none; border-bottom: none; }
        .corner-bl { bottom: 14px; left: 14px; border-right: none; border-top: none; }
        .corner-br { bottom: 14px; right: 14px; border-left: none; border-top: none; }

        /* Embossed text effect for main titles */
        h1.text-secondary-900, h1.font-black, h1.tracking-tight, .embossed-heading {
            color: #2b3d26 !important; /* Organic dark olive */
            text-shadow: 1px 1px 0px #ffffff, -1px -1px 0px rgba(0, 0, 0, 0.15) !important;
            font-family: 'Outfit', sans-serif;
        }

        /* Active menu styling - carved bamboo effect in Pasundan Green */
        aside nav a.bg-primary-600 {
            background: linear-gradient(to right, #2d7237, #1f4825) !important;
            border: 2px solid #17361c !important;
            box-shadow: inset 0 1px 3px rgba(255,255,255,0.25), inset 0 -2px 4px rgba(0,0,0,0.45), 0 4px 6px rgba(45, 114, 55, 0.2) !important;
            color: #ffffff !important;
        }
        aside nav a.bg-primary-600 svg {
            color: #ffffff !important;
        }

        /* Form cards design upgrades */
        .bg-white.p-5.rounded-2xl {
            border: 2.5px solid rgba(181, 142, 88, 0.2) !important;
            box-shadow: 0 12px 30px -8px rgba(167, 111, 48, 0.08) !important;
            background-color: rgba(255, 255, 255, 0.96) !important;
            position: relative;
        }
        .bg-white.p-5.rounded-2xl::before {
            content: "";
            position: absolute;
            top: 5px; left: 5px; right: 5px; bottom: 5px;
            border: 1px dashed rgba(181, 142, 88, 0.12);
            border-radius: 0.9rem;
            pointer-events: none;
        }

        /* Ornate details for input borders */
        input[type="text"], select {
            border: 1.5px solid rgba(181, 142, 88, 0.2) !important;
            border-radius: 0.75rem !important;
            background-color: rgba(255, 255, 255, 0.9) !important;
        }

        /* Terapkan button styling (Pasundan Green gradient) */
        button[type="submit"], .bg-primary-600.hover\:bg-primary-700 {
            background: linear-gradient(to right, #2d7237, #1f4825) !important;
            border: 1.5px solid #17361c !important;
            border-radius: 0.75rem !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            text-shadow: 0 1px 2px rgba(0,0,0,0.25);
            box-shadow: 0 4px 12px -2px rgba(45, 114, 55, 0.3) !important;
            transition: all 0.2s ease-in-out;
        }
        button[type="submit"]:hover, .bg-primary-600.hover\:bg-primary-700:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px -1px rgba(45, 114, 55, 0.4) !important;
        }

        /* Keluar button - terracotta style */
        form button.text-red-400 {
            background: linear-gradient(to right, #b95738, #994125) !important;
            border: 2px solid #a76f30 !important;
            color: #faf5eb !important;
            box-shadow: inset 0 1px 3px rgba(255,255,255,0.2), 0 4px 10px rgba(185, 87, 56, 0.15) !important;
        }
        form button.text-red-400 svg {
            color: #faf5eb !important;
        }

        /* Table styling changes to fit organic style */
        table {
            border: 1.5px solid rgba(181, 142, 88, 0.2) !important;
        }
        th {
            background-color: #f1f5ee !important;
            color: #33412a !important;
            border-bottom: 2px solid rgba(181, 142, 88, 0.2) !important;
        }
    </style>
</head>
<body class="sunda-bilik text-secondary-800 font-sans min-h-screen flex flex-col md:flex-row antialiased">

    <!-- Sidebar -->
    <aside class="w-full md:w-64 bg-secondary-900 text-slate-300 flex flex-col shrink-0 border-r border-secondary-800 relative overflow-hidden">
        <!-- Logo & Branding -->
        <div class="h-20 flex items-center px-6 border-b border-secondary-800 justify-between">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('logo-icon.png') }}?v=3" alt="SIPANDA Logo" class="w-9 h-9 object-contain rounded-full bg-white p-0.5 border border-slate-700">
                <div>
                    <span class="text-lg font-bold tracking-tight text-white">SIPANDA</span>
                    <p class="text-[9px] text-primary-400 tracking-wider uppercase font-semibold">Admin Panel</p>
                </div>
            </div>
            
            <!-- Mobile Toggle -->
            <button onclick="toggleMobileSidebar()" class="md:hidden text-slate-400 hover:text-white focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>

        <!-- Menu Navigation -->
        <nav id="sidebar-menu" class="hidden md:flex flex-col flex-grow p-4 space-y-1.5 z-10 relative">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-200 {{ Route::is('admin.dashboard') ? 'bg-primary-600 text-white shadow-md shadow-primary-900/30' : 'hover:bg-secondary-800 hover:text-white' }}">
                <!-- Dashboard Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.pengajuan') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-200 {{ Route::is('admin.pengajuan') || Route::is('admin.pengajuan.detail') ? 'bg-primary-600 text-white shadow-md shadow-primary-900/30' : 'hover:bg-secondary-800 hover:text-white' }}">
                <!-- File/Document Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
                <span>Data Pengajuan</span>
            </a>

            <a href="{{ route('admin.umkm') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-200 {{ Route::is('admin.umkm') ? 'bg-primary-600 text-white shadow-md shadow-primary-900/30' : 'hover:bg-secondary-800 hover:text-white' }}">
                <!-- Badge/UMKM Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                </svg>
                <span>UMKM Terdaftar</span>
            </a>

            <a href="{{ route('admin.laporan') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-200 {{ Route::is('admin.laporan') ? 'bg-primary-600 text-white shadow-md shadow-primary-900/30' : 'hover:bg-secondary-800 hover:text-white' }}">
                <!-- Print/Report Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0a2.25 2.25 0 0 1-2.23 2.14H8.57a2.25 2.25 0 0 1-2.23-2.14m11.32 0L17.5 13.5m-11.32 0L6.5 13.5m11 0h.008v.008h-.008V13.5Zm-11 0h.008v.008h-.008V13.5ZM6.5 9h11m-11 0a2.25 2.25 0 0 1 2.25-2.25h6.5A2.25 2.25 0 0 1 18 9m-11.5 0V7.5A2.25 2.25 0 0 1 8.75 5.25h6.5A2.25 2.25 0 0 1 17.5 7.5V9" />
                </svg>
                <span>Cetak Laporan</span>
            </a>

            <!-- Divider -->
            <div class="border-t border-secondary-800 my-4"></div>

            <a href="{{ route('landing') }}" target="_blank" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold hover:bg-secondary-800 hover:text-white transition-all">
                <!-- Eye Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                <span>Lihat Website</span>
            </a>

            <form action="{{ route('admin.logout') }}" method="POST" class="mt-1">
                @csrf
                <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold text-red-400 hover:bg-red-950/20 hover:text-red-300 transition-all text-left">
                    <!-- Logout Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                    <span>Keluar</span>
                </button>
            </form>
            <!-- Kujang Watermark -->
            <div class="absolute bottom-4 left-4 w-28 h-48 opacity-[0.03] pointer-events-none text-white select-none z-0">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 200" class="w-full h-full fill-current">
                    <path d="M50,10 C40,30 25,60 25,100 C25,130 40,150 48,155 L45,185 C45,190 55,190 55,185 L52,155 C60,150 75,130 75,100 C75,60 60,30 50,10 Z M46,60 A3,3 0 1,1 52,60 A3,3 0 1,1 46,60 Z M45,85 A3,3 0 1,1 51,85 A3,3 0 1,1 45,85 Z M47,110 A3,3 0 1,1 53,110 A3,3 0 1,1 47,110 Z"/>
                </svg>
            </div>
        </nav>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-grow flex flex-col min-h-screen overflow-x-hidden">
        <!-- Top Bar -->
        <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-6 shrink-0 z-10">
            <div class="flex items-center space-x-3">
                <span class="text-sm text-slate-500 font-semibold md:block hidden">Seksi Pemberdayaan Masyarakat Kecamatan Cicalengka</span>
            </div>
            
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center font-bold text-primary-700">
                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                    </div>
                    <span class="text-sm font-semibold text-slate-700">{{ Auth::user()->name ?? 'Administrator' }}</span>
                </div>
            </div>
        </header>

        <!-- Dynamic Content -->
        <main class="flex-grow p-6 md:p-8 relative">
            <div class="filigree-container min-h-full">
                <!-- Ornate corner decors -->
                <div class="corner-decor corner-tl"></div>
                <div class="corner-decor corner-tr"></div>
                <div class="corner-decor corner-bl"></div>
                <div class="corner-decor corner-br"></div>

                <!-- Minimalist Mega Mendung Edge Ornaments -->
                <!-- Top-Right Mega Mendung -->
                <div class="absolute -top-4 -right-12 w-64 h-64 opacity-[0.035] pointer-events-none select-none text-[#b58e58] z-0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 200" fill="none" stroke="currentColor" stroke-width="2.5" class="w-full h-full">
                        <path d="M 120 70 C 145 45, 195 45, 220 70 M 100 100 C 120 80, 160 80, 180 100 M 150 50 C 180 20, 240 20, 270 50 C 300 30, 350 40, 360 70 C 380 90, 390 120, 370 140 C 350 160, 310 160, 290 145 M 130 90 C 150 70, 190 70, 210 90 M 100 120 C 120 100, 160 100, 180 120" />
                    </svg>
                </div>
                <!-- Bottom-Left Mega Mendung -->
                <div class="absolute -bottom-12 -left-12 w-64 h-64 opacity-[0.035] pointer-events-none select-none text-[#b58e58] z-0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 200" fill="none" stroke="currentColor" stroke-width="2.5" class="w-full h-full">
                        <path d="M 180 130 C 155 155, 105 155, 80 130 M 200 100 C 180 120, 140 120, 120 100 M 150 150 C 120 180, 60 180, 30 150 C 0 130, -50 140, -60 110 C -80 90, -90 60, -70 40 C -50 20, -10 20, 10 35 M 170 110 C 150 130, 110 130, 90 110 M 200 80 C 180 100, 140 100, 120 80" />
                    </svg>
                </div>

                <div class="relative z-10">
                    @yield('admin_content')
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="py-4 bg-white border-t border-slate-200 text-center text-xs text-slate-500 shrink-0 z-10">
            <div class="max-w-7xl mx-auto px-6 flex flex-col sm:flex-row items-center justify-between gap-2">
                <div>
                    &copy; {{ date('Y') }} <span class="font-bold text-primary-700">SIPANDA Cicalengka</span>. Seksi Pemberdayaan Masyarakat.
                </div>
                <div class="text-[10px] text-slate-400 font-medium">
                    Created by <span class="font-bold text-slate-600">Fitri Yani Permana (FYP)</span>
                </div>
            </div>
        </footer>
    </div>

    <!-- Mobile sidebar toggler script -->
    <script>
        function toggleMobileSidebar() {
            var menu = document.getElementById('sidebar-menu');
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
            } else {
                menu.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
