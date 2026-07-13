@extends('layouts.admin')

@section('title', 'Dashboard Ringkasan')

@section('admin_content')
<div class="space-y-8 animate-fadeIn">
    
    <!-- Header Section -->
    <div>
        <h1 class="text-2xl sm:text-3xl font-black text-secondary-900 tracking-tight">Ringkasan Statistik SIPANDA</h1>
        <p class="text-xs text-secondary-500 font-semibold mt-1">Data terkini pendataan UMKM Seksi Pemberdayaan Masyarakat Kecamatan Cicalengka.</p>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-5">
        <!-- 1. Total Pengajuan -->
        <a href="{{ route('admin.pengajuan') }}" class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:border-slate-350 hover:shadow-md transition-all duration-200 flex flex-col justify-between group">
            <span class="text-xs text-secondary-500 font-bold uppercase tracking-wider block group-hover:text-primary-600 transition-colors">Total Pengajuan</span>
            <div class="flex items-baseline justify-between mt-4">
                <span class="text-3xl font-black text-secondary-900">{{ $stats['total_pengajuan'] }}</span>
                <span class="p-1.5 rounded-lg bg-slate-100 text-secondary-600 group-hover:bg-primary-50 group-hover:text-primary-600 transition-colors shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 13h6m-6 4h6m2 4H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2z" />
                    </svg>
                </span>
            </div>
        </a>

        <!-- 2. Menunggu Verifikasi -->
        <a href="{{ route('admin.pengajuan', ['status' => 'Menunggu Verifikasi']) }}" class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:border-slate-350 hover:shadow-md transition-all duration-200 flex flex-col justify-between group">
            <span class="text-xs text-secondary-500 font-bold uppercase tracking-wider block group-hover:text-amber-600 transition-colors">Menunggu</span>
            <div class="flex items-baseline justify-between mt-4">
                <span class="text-3xl font-black text-amber-600">{{ $stats['menunggu'] }}</span>
                <span class="p-1.5 rounded-lg bg-amber-50 text-amber-600 group-hover:bg-amber-100 transition-colors shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </span>
            </div>
        </a>

        <!-- 3. Perlu Perbaikan -->
        <a href="{{ route('admin.pengajuan', ['status' => 'Perlu Perbaikan']) }}" class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:border-slate-350 hover:shadow-md transition-all duration-200 flex flex-col justify-between group">
            <span class="text-xs text-secondary-500 font-bold uppercase tracking-wider block group-hover:text-orange-600 transition-colors">Perbaikan</span>
            <div class="flex items-baseline justify-between mt-4">
                <span class="text-3xl font-black text-orange-600">{{ $stats['perbaikan'] }}</span>
                <span class="p-1.5 rounded-lg bg-orange-50 text-orange-600 group-hover:bg-orange-100 transition-colors shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3L2 20h20L12 3zM12 8v5m0 3h.01" />
                    </svg>
                </span>
            </div>
        </a>

        <!-- 4. Disetujui -->
        <a href="{{ route('admin.pengajuan', ['status' => 'Disetujui']) }}" class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:border-slate-350 hover:shadow-md transition-all duration-200 flex flex-col justify-between group">
            <span class="text-xs text-secondary-500 font-bold uppercase tracking-wider block group-hover:text-green-600 transition-colors">Disetujui</span>
            <div class="flex items-baseline justify-between mt-4">
                <span class="text-3xl font-black text-green-600">{{ $stats['disetujui'] }}</span>
                <span class="p-1.5 rounded-lg bg-green-50 text-green-600 group-hover:bg-green-100 transition-colors shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </span>
            </div>
        </a>

        <!-- 5. Ditolak -->
        <a href="{{ route('admin.pengajuan', ['status' => 'Ditolak']) }}" class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:border-slate-350 hover:shadow-md transition-all duration-200 flex flex-col justify-between group">
            <span class="text-xs text-secondary-500 font-bold uppercase tracking-wider block group-hover:text-red-600 transition-colors">Ditolak</span>
            <div class="flex items-baseline justify-between mt-4">
                <span class="text-3xl font-black text-red-600">{{ $stats['ditolak'] }}</span>
                <span class="p-1.5 rounded-lg bg-red-50 text-red-600 group-hover:bg-red-100 transition-colors shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </span>
            </div>
        </a>

        <!-- 6. Terdaftar Resmi -->
        <a href="{{ route('admin.umkm') }}" class="bg-gradient-to-tr from-primary-600 to-emerald-500 text-white p-5 rounded-2xl shadow-md hover:shadow-lg hover:scale-[1.02] transition-all duration-200 flex flex-col justify-between group">
            <span class="text-xs text-primary-100 font-bold uppercase tracking-wider block">UMKM Terdaftar</span>
            <div class="flex items-baseline justify-between mt-4">
                <span class="text-3xl font-black text-white">{{ $stats['total_umkm'] }}</span>
                <span class="p-1.5 rounded-lg bg-white/20 text-white shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18M3 12l2-4h14l2 4M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-7M9 21V15a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v6" />
                    </svg>
                </span>
            </div>
        </a>
    </div>

    <!-- Recent Submissions Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-lg text-secondary-900">Pengajuan Terbaru</h3>
            <a href="{{ route('admin.pengajuan') }}" class="text-xs font-bold text-primary-600 hover:text-primary-700">
                Lihat Semua &rarr;
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-[10px] font-bold text-secondary-500 uppercase tracking-widest border-b border-slate-100">
                        <th class="py-4 px-6">Tanggal</th>
                        <th class="py-4 px-6">No. Pengajuan</th>
                        <th class="py-4 px-6">Foto</th>
                        <th class="py-4 px-6">Nama Usaha</th>
                        <th class="py-4 px-6">NIB</th>
                        <th class="py-4 px-6">Sertifikat Halal</th>
                        <th class="py-4 px-6">Pemilik</th>
                        <th class="py-4 px-6">Desa</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($recentSubmissions as $sub)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-4.5 px-6 text-secondary-500 font-medium">{{ $sub->created_at->format('d/m/Y H:i') }}</td>
                            <td class="py-4.5 px-6 font-mono font-bold text-secondary-900">{{ $sub->nomor_pengajuan }}</td>
                            <td class="py-4.5 px-6">
                                <div class="w-12 h-12 rounded-xl overflow-hidden border border-slate-100 shadow-sm bg-slate-50 shrink-0">
                                    <img src="{{ asset($sub->foto_usaha) }}" class="w-full h-full object-cover" alt="Foto Usaha">
                                </div>
                            </td>
                            <td class="py-4.5 px-6 font-semibold text-secondary-800">{{ $sub->nama_usaha }}</td>
                            <td class="py-4.5 px-6 font-mono text-secondary-600 text-xs">{{ $sub->nib ?? '-' }}</td>
                            <td class="py-4.5 px-6 font-mono text-secondary-600 text-xs">{{ $sub->sertifikasi_halal ?? '-' }}</td>
                            <td class="py-4.5 px-6 text-secondary-600">{{ $sub->nama_pemilik }}</td>
                            <td class="py-4.5 px-6 text-secondary-600">{{ $sub->desa }}</td>
                            <td class="py-4.5 px-6">
                                @if($sub->status === 'Menunggu Verifikasi')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-100">
                                        Menunggu
                                    </span>
                                @elseif($sub->status === 'Perlu Perbaikan')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-orange-50 text-orange-700 border border-orange-100">
                                        Perbaikan
                                    </span>
                                @elseif($sub->status === 'Disetujui')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-green-50 text-green-700 border border-green-100">
                                        Disetujui
                                    </span>
                                @elseif($sub->status === 'Ditolak')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-100">
                                        Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="py-4.5 px-6 text-right">
                                <a href="{{ route('admin.pengajuan.detail', $sub->id) }}" class="inline-flex items-center justify-center px-3.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-secondary-700 font-bold rounded-lg text-xs transition-colors">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="py-12 px-6 text-center text-xs text-secondary-400 font-medium">
                                Belum ada pengajuan UMKM yang dikirimkan masyarakat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
