@extends('layouts.admin')

@section('title', 'Log Aktivitas - Khusus Super Admin')

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
            <h1 class="text-2xl sm:text-3xl font-black text-secondary-900 tracking-tight">Log Aktivitas Sistem</h1>
            <p class="text-xs text-secondary-500 font-semibold mt-1">Audit trail lengkap seluruh tindakan login, verifikasi berkas, dan pengelolaan sistem oleh admin.</p>
        </div>

        <!-- Total Counter -->
        <div class="flex items-center gap-2">
            <div class="px-4 py-2 rounded-xl bg-white border border-slate-200 shadow-xs flex items-center space-x-3">
                <div class="text-right">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Total Log</span>
                    <span class="text-lg font-black text-secondary-900 leading-none">{{ $logs->total() }} Baris</span>
                </div>
            </div>
        </div>
    </div>

    <!-- CARD 1: FORM FILTER PENCARIAN (Full Width & Rapi) -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <form action="{{ route('admin.log-aktivitas') }}" method="GET" class="space-y-4">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                
                <!-- Filter Admin -->
                <div>
                    <label for="user_id" class="block text-[11px] font-bold text-secondary-600 uppercase tracking-wider mb-1.5">
                        Pilih Admin
                    </label>
                    <select name="user_id" id="user_id" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="">Semua Admin</option>
                        @foreach($adminList as $admin)
                            <option value="{{ $admin->id }}" {{ request('user_id') == $admin->id ? 'selected' : '' }}>
                                {{ $admin->name }} ({{ $admin->role === 'super_admin' ? 'Super Admin' : 'Admin' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Tanggal Mulai -->
                <div>
                    <label for="start_date" class="block text-[11px] font-bold text-secondary-600 uppercase tracking-wider mb-1.5">
                        Dari Tanggal
                    </label>
                    <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>

                <!-- Filter Tanggal Sampai -->
                <div>
                    <label for="end_date" class="block text-[11px] font-bold text-secondary-600 uppercase tracking-wider mb-1.5">
                        Sampai Tanggal
                    </label>
                    <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>

                <!-- Filter Jenis Aksi -->
                <div>
                    <label for="action" class="block text-[11px] font-bold text-secondary-600 uppercase tracking-wider mb-1.5">
                        Jenis Aksi
                    </label>
                    <select name="action" id="action" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="">Semua Jenis Aksi</option>
                        <option value="login" {{ request('action') == 'login' ? 'selected' : '' }}>Login</option>
                        <option value="logout" {{ request('action') == 'logout' ? 'selected' : '' }}>Logout</option>
                        <option value="verifikasi_pengajuan" {{ request('action') == 'verifikasi_pengajuan' ? 'selected' : '' }}>Verifikasi Pengajuan</option>
                        <option value="tambah_admin" {{ request('action') == 'tambah_admin' ? 'selected' : '' }}>Tambah Admin</option>
                        <option value="hapus_admin" {{ request('action') == 'hapus_admin' ? 'selected' : '' }}>Hapus Admin</option>
                    </select>
                </div>
            </div>

            <!-- Tombol Aksi Filter -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pt-3 border-t border-slate-100 gap-2">
                <div class="text-xs text-slate-400">
                    Menampilkan hasil pencarian berdasarkan kriteria yang dipilih.
                </div>
                <div class="flex items-center space-x-2">
                    @if(request()->hasAny(['user_id', 'start_date', 'end_date', 'action', 'search']))
                        <a href="{{ route('admin.log-aktivitas') }}" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-slate-900 border border-slate-200 hover:bg-slate-50 transition-all">
                            Reset Filter
                        </a>
                    @endif
                    <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold text-white bg-primary-600 hover:bg-primary-700 transition-all flex items-center space-x-1.5 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="14" height="14" style="width: 14px; height: 14px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.608 10.608Z" />
                        </svg>
                        <span>Terapkan Filter</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- CARD 2: TABEL RIWAYAT LOG AKTIVITAS (Full Width & Paginated) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col">
        <!-- Header Tabel -->
        <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h2 class="text-base font-bold text-secondary-900">Riwayat Aktivitas Terdata</h2>
                <p class="text-xs text-secondary-500">Data dimuat bertahap (15 data per halaman) untuk performa cepat dan optimal</p>
            </div>
        </div>

        <!-- Tabel Responsif -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" style="min-width: 760px;">
                <thead>
                    <tr class="bg-slate-50 text-[10px] font-bold text-secondary-500 uppercase tracking-widest border-b border-slate-100">
                        <th class="py-4 px-6" style="width: 170px;">Waktu</th>
                        <th class="py-4 px-6" style="width: 220px;">Admin Pengguna</th>
                        <th class="py-4 px-6" style="width: 160px;">Aksi</th>
                        <th class="py-4 px-6">Deskripsi & Rincian</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-secondary-700">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            
                            <!-- Kolom Waktu -->
                            <td class="py-4 px-6 align-top">
                                <div class="font-bold text-secondary-900 font-mono text-[11px]">
                                    {{ $log->created_at ? $log->created_at->translatedFormat('d M Y, H:i:s') : '-' }}
                                </div>
                                <span class="text-[10px] text-slate-400 block mt-0.5">
                                    {{ $log->created_at ? $log->created_at->diffForHumans() : '' }}
                                </span>
                            </td>

                            <!-- Kolom Admin -->
                            <td class="py-4 px-6 align-top">
                                <div class="flex items-center space-x-2.5">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs shrink-0 {{ ($log->user && $log->user->isSuperAdmin()) ? 'bg-amber-100 text-amber-800 border border-amber-300' : 'bg-primary-100 text-primary-800 border border-primary-200' }}" style="width: 32px; height: 32px;">
                                        {{ strtoupper(substr($log->user->name ?? 'S', 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="font-bold text-secondary-900 block text-xs">
                                            {{ $log->user->name ?? 'Pengguna Dihapus' }}
                                        </span>
                                        @if($log->user && $log->user->role)
                                            <span class="text-[10px] text-slate-500 block">
                                                {{ $log->user->role === 'super_admin' ? 'Super Admin' : 'Admin' }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Kolom Aksi (Badge Berwarna) -->
                            <td class="py-4 px-6 align-top">
                                @php
                                    $actionBadges = [
                                        'login' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-200', 'label' => 'Login'],
                                        'logout' => ['bg' => 'bg-slate-100', 'text' => 'text-slate-600', 'border' => 'border-slate-200', 'label' => 'Logout'],
                                        'verifikasi_pengajuan' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-300', 'label' => 'Verifikasi Pengajuan'],
                                        'tambah_admin' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-800', 'border' => 'border-amber-300', 'label' => 'Tambah Admin'],
                                        'hapus_admin' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-200', 'label' => 'Hapus Admin'],
                                    ];
                                    $currentBadge = $actionBadges[$log->action] ?? ['bg' => 'bg-slate-100', 'text' => 'text-slate-700', 'border' => 'border-slate-200', 'label' => ucfirst(str_replace('_', ' ', $log->action))];
                                @endphp

                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold {{ $currentBadge['bg'] }} {{ $currentBadge['text'] }} border {{ $currentBadge['border'] }}">
                                    {{ $currentBadge['label'] }}
                                </span>
                            </td>

                            <!-- Kolom Deskripsi & Referensi -->
                            <td class="py-4 px-6 align-top">
                                <div class="text-xs text-secondary-800 leading-relaxed font-medium">
                                    {{ $log->description }}
                                </div>

                                <!-- Tautan ke Data Terkait (Subject) -->
                                @if($log->subject_type === 'pengajuan' && $log->subject_id)
                                    <div class="mt-1.5">
                                        <a href="{{ route('admin.pengajuan.detail', $log->subject_id) }}" class="inline-flex items-center text-[11px] font-bold text-primary-700 hover:text-primary-800 hover:underline">
                                            <span>Lihat Berkas Pengajuan</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="12" height="12" class="ml-1" style="width: 12px; height: 12px;">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-slate-400">
                                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-3 text-slate-400" style="width: 48px; height: 48px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="24" height="24" style="width: 24px; height: 24px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </div>
                                <span class="font-semibold block text-sm text-secondary-800">Belum ada riwayat aktivitas</span>
                                <span class="text-xs text-slate-400 mt-1 block">Aktivitas login, logout, atau verifikasi yang dilakukan admin akan tercatat secara otomatis di sini.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($logs->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
