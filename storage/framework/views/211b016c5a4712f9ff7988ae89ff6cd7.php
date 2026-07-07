<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Admin Panel SIPANDA'); ?> - Kec. Cicalengka</title>
    
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
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 text-secondary-800 font-sans min-h-screen flex flex-col md:flex-row antialiased">

    <!-- Sidebar -->
    <aside class="w-full md:w-64 bg-secondary-900 text-slate-300 flex flex-col shrink-0 border-r border-secondary-800">
        <!-- Logo & Branding -->
        <div class="h-20 flex items-center px-6 border-b border-secondary-800 justify-between">
            <div class="flex items-center space-x-3">
                <img src="<?php echo e(asset('logo-icon.png')); ?>?v=3" alt="SIPANDA Logo" class="w-9 h-9 object-contain rounded-full bg-white p-0.5 border border-slate-700">
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
        <nav id="sidebar-menu" class="hidden md:flex flex-col flex-grow p-4 space-y-1.5">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-200 <?php echo e(Route::is('admin.dashboard') ? 'bg-primary-600 text-white shadow-md shadow-primary-900/30' : 'hover:bg-secondary-800 hover:text-white'); ?>">
                <!-- Dashboard Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="<?php echo e(route('admin.pengajuan')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-200 <?php echo e(Route::is('admin.pengajuan') || Route::is('admin.pengajuan.detail') ? 'bg-primary-600 text-white shadow-md shadow-primary-900/30' : 'hover:bg-secondary-800 hover:text-white'); ?>">
                <!-- File/Document Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
                <span>Data Pengajuan</span>
            </a>

            <a href="<?php echo e(route('admin.umkm')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-200 <?php echo e(Route::is('admin.umkm') ? 'bg-primary-600 text-white shadow-md shadow-primary-900/30' : 'hover:bg-secondary-800 hover:text-white'); ?>">
                <!-- Badge/UMKM Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                </svg>
                <span>UMKM Terdaftar</span>
            </a>

            <a href="<?php echo e(route('admin.laporan')); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-200 <?php echo e(Route::is('admin.laporan') ? 'bg-primary-600 text-white shadow-md shadow-primary-900/30' : 'hover:bg-secondary-800 hover:text-white'); ?>">
                <!-- Print/Report Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0a2.25 2.25 0 0 1-2.23 2.14H8.57a2.25 2.25 0 0 1-2.23-2.14m11.32 0L17.5 13.5m-11.32 0L6.5 13.5m11 0h.008v.008h-.008V13.5Zm-11 0h.008v.008h-.008V13.5ZM6.5 9h11m-11 0a2.25 2.25 0 0 1 2.25-2.25h6.5A2.25 2.25 0 0 1 18 9m-11.5 0V7.5A2.25 2.25 0 0 1 8.75 5.25h6.5A2.25 2.25 0 0 1 17.5 7.5V9" />
                </svg>
                <span>Cetak Laporan</span>
            </a>

            <!-- Divider -->
            <div class="border-t border-secondary-800 my-4"></div>

            <a href="<?php echo e(route('landing')); ?>" target="_blank" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold hover:bg-secondary-800 hover:text-white transition-all">
                <!-- Eye Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                <span>Lihat Website</span>
            </a>

            <form action="<?php echo e(route('admin.logout')); ?>" method="POST" class="mt-auto">
                <?php echo csrf_field(); ?>
                <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold text-red-400 hover:bg-red-950/20 hover:text-red-300 transition-all text-left">
                    <!-- Logout Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                    <span>Keluar</span>
                </button>
            </form>
        </nav>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-grow flex flex-col min-h-screen overflow-x-hidden">
        <!-- Top Bar -->
        <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-6 shrink-0">
            <div class="flex items-center space-x-3">
                <span class="text-sm text-slate-500 font-semibold md:block hidden">Seksi Pemberdayaan Masyarakat Kecamatan Cicalengka</span>
            </div>
            
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center font-bold text-primary-700">
                        <?php echo e(substr(Auth::user()->name ?? 'A', 0, 1)); ?>

                    </div>
                    <span class="text-sm font-semibold text-slate-700"><?php echo e(Auth::user()->name ?? 'Administrator'); ?></span>
                </div>
            </div>
        </header>

        <!-- Dynamic Content -->
        <main class="flex-grow p-6 md:p-8">
            <?php echo $__env->yieldContent('admin_content'); ?>
        </main>
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
<?php /**PATH C:\Users\ADVAN\Downloads\sipanda\resources\views/layouts/admin.blade.php ENDPATH**/ ?>