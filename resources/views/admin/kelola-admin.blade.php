@extends('layouts.admin')

@section('title', 'Kelola Admin - Khusus Super Admin')

@section('admin_content')
<div class="space-y-6 animate-fadeIn">

    <!-- Header & Keterangan -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2 text-xs font-semibold text-secondary-500 mb-1">
                <span>Admin Panel</span>
                <span>&rsaquo;</span>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-amber-50 text-amber-800 border border-amber-300">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="12" height="12" style="width: 12px; height: 12px; margin-right: 4px; display: inline-block;">
                        <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 0 0-4.5 4.5V9H5a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2h-.5V5.5A4.5 4.5 0 0 0 10 1Zm3 8V5.5a3 3 0 1 0-6 0V9h6Z" clip-rule="evenodd" />
                    </svg>
                    Khusus Super Admin
                </span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-secondary-900 tracking-tight">Kelola Akun Admin</h1>
            <p class="text-xs text-secondary-500 font-semibold mt-1">Daftar dan kelola akun staf admin yang berhak mengakses dashboard SIPANDA Kecamatan Cicalengka.</p>
        </div>

        <!-- Counter Ringkasan Admin -->
        <div class="flex items-center gap-2">
            <div class="px-4 py-2 rounded-xl bg-white border border-slate-200 shadow-xs flex items-center space-x-3">
                <div class="text-right">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Total Pengelola</span>
                    <span class="text-lg font-black text-secondary-900 leading-none">{{ $admins->total() }} Akun</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Notifikasi Flash -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-green-50 border border-green-200 text-green-800 text-xs font-semibold flex items-center space-x-3 shadow-xs">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" width="18" height="18" class="text-green-600 shrink-0" style="width: 18px; height: 18px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs font-semibold flex items-center space-x-3 shadow-xs">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="18" height="18" class="text-red-600 shrink-0" style="width: 18px; height: 18px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 7.5h.008v.008H12v-.008Z" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs font-semibold shadow-xs space-y-1">
            <div class="font-bold flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="16" height="16" class="text-red-600 shrink-0" style="width: 16px; height: 16px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                </svg>
                <span>Terdapat kesalahan pada input formulir:</span>
            </div>
            <ul class="list-disc list-inside space-y-0.5 pl-6 text-red-700">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- CARD 1: FORM TAMBAH ADMIN BARU (Full Width, Bersih & Lega) -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pb-4 border-b border-slate-100 gap-2">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-xl bg-primary-100 flex items-center justify-center text-primary-700 shrink-0" style="width: 36px; height: 36px;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="18" height="18" style="width: 18px; height: 18px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-secondary-900">Form Tambah Admin Baru</h2>
                    <p class="text-xs text-secondary-500">Daftarkan akun staf atau petugas baru untuk operasional pelayanan UMKM</p>
                </div>
            </div>

            <!-- Role Badge Information -->
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200 self-start sm:self-auto">
                <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2" style="width: 8px; height: 8px;"></span>
                Role Otomatis: <strong class="ml-1 text-secondary-900">Admin (Biasa)</strong>
            </span>
        </div>

        <form action="{{ route('admin.kelola-admin.store') }}" method="POST">
            @csrf

            <!-- 3 Kolom Input Responsif -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.25rem;">
                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-xs font-bold text-secondary-700 uppercase tracking-wider mb-1.5">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
                </div>

                <!-- Email Resmi -->
                <div>
                    <label for="email" class="block text-xs font-bold text-secondary-700 uppercase tracking-wider mb-1.5">
                        Alamat Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="admin_staff@cicalengka.go.id" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-bold text-secondary-700 uppercase tracking-wider mb-1.5">
                        Password Awal <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password" id="password" placeholder="Minimal 6 karakter" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
                </div>
            </div>

            <!-- Footer Form & Tombol Simpan -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mt-5 pt-4 border-t border-slate-100 gap-3">
                <div class="flex items-center text-xs text-slate-500 space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="16" height="16" class="text-amber-600 shrink-0" style="width: 16px; height: 16px;">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z" clip-rule="evenodd" />
                    </svg>
                    <span><strong>Keamanan:</strong> Akun baru otomatis di-set sebagai <em>Admin Biasa</em> dan setiap penambahan admin akan dicatat di <strong>Log Aktivitas</strong>.</span>
                </div>

                <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-bold text-white bg-primary-600 hover:bg-primary-700 transition-all flex items-center justify-center space-x-2 shadow-md shadow-primary-900/20 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="16" height="16" style="width: 16px; height: 16px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>Simpan Admin Baru</span>
                </button>
            </div>
        </form>
    </div>

    <!-- CARD 2: TABEL DAFTAR AKUN ADMIN (Full Width, Bersih & Rapi) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col">
        <!-- Toolbar Header Tabel -->
        <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-base font-bold text-secondary-900">Daftar Akun Pengelola SIPANDA</h2>
                <p class="text-xs text-secondary-500">Semua akun yang memiliki hak login ke panel administrasi</p>
            </div>

            <!-- Form Pencarian Cepat -->
            <form action="{{ route('admin.kelola-admin') }}" method="GET" class="flex items-center space-x-2">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..."
                        class="w-56 sm:w-64 pl-9 pr-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-1 focus:ring-primary-500">
                    <span class="absolute left-3 top-2.5 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="14" height="14" style="width: 14px; height: 14px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.608 10.608Z" />
                        </svg>
                    </span>
                </div>
                <button type="submit" class="px-3 py-2 rounded-xl text-xs font-bold text-white bg-secondary-900 hover:bg-secondary-800 transition-colors">
                    Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.kelola-admin') }}" class="text-xs text-slate-500 hover:text-slate-800 px-2.5 py-2 rounded-xl border border-slate-200">Reset</a>
                @endif
            </form>
        </div>

        <!-- Tabel Responsif -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" style="min-width: 700px;">
                <thead>
                    <tr class="bg-slate-50 text-[10px] font-bold text-secondary-500 uppercase tracking-widest border-b border-slate-100">
                        <th class="py-4 px-6">Nama Admin</th>
                        <th class="py-4 px-6">Alamat Email</th>
                        <th class="py-4 px-6">Peran (Role)</th>
                        <th class="py-4 px-6">Tanggal Bergabung</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-secondary-700">
                    @forelse($admins as $admin)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <!-- Nama & Inisial Avatar -->
                            <td class="py-4 px-6 font-medium">
                                <div class="flex items-center space-x-3">
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-xs shrink-0 {{ $admin->isSuperAdmin() ? 'bg-amber-100 text-amber-800 border border-amber-300' : 'bg-primary-100 text-primary-800 border border-primary-200' }}" style="width: 36px; height: 36px;">
                                        {{ strtoupper(substr($admin->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="font-bold text-secondary-900 text-sm block">{{ $admin->name }}</span>
                                        @if($admin->id === auth()->id())
                                            <span class="inline-block text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">
                                                Akun Anda (Aktif)
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Email -->
                            <td class="py-4 px-6 text-slate-600 font-mono text-xs">
                                {{ $admin->email }}
                            </td>

                            <!-- Role Badge -->
                            <td class="py-4 px-6">
                                @if($admin->isSuperAdmin())
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-800 border border-amber-300 shadow-2xs">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="13" height="13" class="text-amber-600 mr-1.5 shrink-0" style="width: 13px; height: 13px;">
                                            <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 0 0-4.5 4.5V9H5a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2h-.5V5.5A4.5 4.5 0 0 0 10 1Zm3 8V5.5a3 3 0 1 0-6 0V9h6Z" clip-rule="evenodd" />
                                        </svg>
                                        Super Admin
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2 shrink-0" style="width: 8px; height: 8px;"></span>
                                        Admin
                                    </span>
                                @endif
                            </td>

                            <!-- Tanggal Dibuat -->
                            <td class="py-4 px-6 text-slate-500 text-xs">
                                {{ $admin->created_at ? $admin->created_at->translatedFormat('d F Y, H:i') : '-' }}
                            </td>

                            <!-- Aksi -->
                            <td class="py-4 px-6 text-right">
                                @if($admin->id === auth()->id())
                                    <span class="text-xs text-slate-400 italic">Sedang Login</span>
                                @elseif($admin->isSuperAdmin())
                                    <span class="inline-flex items-center text-[11px] font-semibold text-amber-700 bg-amber-50 px-2.5 py-1 rounded-lg border border-amber-200" title="Akun Super Admin dilindungi dari penghapusan">
                                        Terlindungi
                                    </span>
                                @else
                                    <form action="{{ route('admin.kelola-admin.destroy', $admin->id) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun admin \'{{ $admin->name }}\'? Aksi ini akan dicatat ke Log Aktivitas.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-bold text-red-600 hover:text-white hover:bg-red-600 border border-red-200 transition-all inline-flex items-center space-x-1 shadow-2xs">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="14" height="14" style="width: 14px; height: 14px;">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-10 text-center text-slate-400">
                                Tidak ada data akun admin yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($admins->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $admins->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
