<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - SIPANDA Cicalengka</title>
    
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
    <style>
        .login-bg {
            background-image: url('{{ asset("bg-login-real.jpg") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body class="login-bg min-h-screen flex items-center justify-center p-4 relative overflow-hidden antialiased">
    <!-- Background Deco -->
    <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full bg-primary-600/10 blur-3xl -z-10"></div>
    <div class="absolute -bottom-40 -left-40 w-96 h-96 rounded-full bg-emerald-500/10 blur-3xl -z-10"></div>

    <div class="w-full max-w-md bg-white rounded-3xl p-8 border border-slate-100 shadow-2xl space-y-8">
        <!-- Logo & Title -->
        <div class="text-center space-y-2.5">
            <img src="{{ asset('logo-icon.png') }}?v=3" alt="SIPANDA Logo" class="w-16 h-16 object-contain rounded-full bg-white p-1 border border-slate-200 shadow-md mx-auto">
            <h1 class="text-2xl font-bold tracking-tight text-secondary-950">Portal Admin SIPANDA</h1>
            <p class="text-xs text-secondary-500">Kecamatan Cicalengka, Kabupaten Bandung</p>
        </div>

        @if($errors->any())
            <div class="p-4 rounded-xl bg-red-50 border border-red-100 text-red-700 text-xs font-semibold space-y-1">
                @foreach($errors->all() as $error)
                    <p class="flex items-center">
                        <span class="w-1 h-1 rounded-full bg-red-500 mr-2 shrink-0"></span>
                        {{ $error }}
                    </p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="block text-xs font-bold text-secondary-700 uppercase tracking-wider mb-2">Alamat Email Admin</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="admin@cicalengka.go.id" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
            </div>

            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="password" class="block text-xs font-bold text-secondary-700 uppercase tracking-wider">Kata Sandi</label>
                </div>
                <input type="password" name="password" id="password" required placeholder="••••••••" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" class="h-4.5 w-4.5 rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                    <label for="remember" class="ml-2 block text-xs font-bold text-secondary-700 select-none">Ingat Sesi Saya</label>
                </div>
            </div>

            <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-4 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-primary-600 to-emerald-500 hover:from-primary-700 hover:to-emerald-600 transition-all shadow-md shadow-primary-100">
                Masuk ke Dashboard
            </button>
        </form>

        <div class="text-center pt-2">
            <a href="{{ route('landing') }}" class="text-xs font-bold text-secondary-500 hover:text-primary-600">
                &larr; Kembali ke Landing Page
            </a>
        </div>
    </div>
</body>
</html>
