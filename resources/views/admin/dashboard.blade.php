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
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
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
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
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
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
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
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.5a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
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
