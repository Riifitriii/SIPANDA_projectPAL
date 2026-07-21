@extends('layouts.app')

@section('title', 'SIPANDA - Sistem Informasi Pengajuan & Pendataan UMKM Cicalengka')

@section('content')
<!-- Hero Section -->
<section id="hero" class="relative overflow-hidden bg-gradient-to-b from-primary-50 via-white to-slate-50 py-24 sm:py-32">
    <!-- Background Decoration Grid -->
    <div class="absolute inset-y-0 right-1/2 -z-10 -mr-96 w-[200%] origin-top-right skew-x-[-30deg] bg-white shadow-xl shadow-primary-600/5 ring-1 ring-primary-50 sm:-mr-80 lg:-mr-96" aria-hidden="true"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <!-- Hero Text -->
            <div class="lg:col-span-7 space-y-8 text-center lg:text-left">
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-primary-100 text-primary-800 text-xs font-semibold tracking-wide">
                    <span>Seksi Pemberdayaan Masyarakat Cicalengka</span>
                </div>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-secondary-900 tracking-tight leading-none">
                    Pendataan UMKM Cepat, Transparan, & <span class="bg-gradient-to-r from-primary-600 to-emerald-500 bg-clip-text text-transparent">Akurat</span>
                </h1>
                <p class="text-base sm:text-lg text-secondary-600 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    Selamat datang di <strong>SIPANDA</strong>. Media pendataan digital resmi Kecamatan Cicalengka untuk mempermudah pelaku UMKM mendaftarkan data usahanya agar terintegrasi secara administratif dan mendapat program pemberdayaan berkelanjutan.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                    <a href="{{ route('ajukan') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 rounded-2xl text-base font-bold text-white bg-gradient-to-r from-primary-600 to-emerald-500 hover:from-primary-700 hover:to-emerald-600 shadow-lg shadow-primary-200 transition-all duration-300 hover:-translate-y-1">
                        <!-- Send/Arrow Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                        </svg>
                        Ajukan Pendataan
                    </a>
                    <a href="{{ route('cek-status') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 rounded-2xl text-base font-bold text-secondary-700 bg-white border-2 border-slate-200 hover:bg-slate-50 hover:border-slate-300 transition-all duration-300 hover:-translate-y-1">
                        <!-- Search Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.608 10.608Z" />
                        </svg>
                        Cek Status Pengajuan
                    </a>
                </div>
            </div>
            
            <!-- Hero Decorative Image/Card -->
            <div class="lg:col-span-5 flex justify-center">
                <div class="relative w-full max-w-sm sm:max-w-md">
                    <!-- Deco Gradient Glow -->
                    <div class="absolute -inset-1 rounded-3xl bg-gradient-to-tr from-primary-600 to-emerald-400 opacity-30 blur-2xl -z-10"></div>
                    
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-xl space-y-6">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                            <h3 class="font-bold text-lg text-secondary-900">Statistik UMKM Cicalengka</h3>
                            <span class="text-xs bg-primary-100 text-primary-700 font-semibold px-2.5 py-1 rounded-full">Realtime</span>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 text-center">
                                <span class="text-xs text-secondary-500 font-medium">Kecamatan</span>
                                <p class="text-lg font-bold text-secondary-800 mt-1">Cicalengka</p>
                            </div>
                            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 text-center">
                                <span class="text-xs text-secondary-500 font-medium">Batas Wilayah</span>
                                <p class="text-lg font-bold text-secondary-800 mt-1">12 Desa</p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-secondary-600 font-medium">Pendataan UMKM digital</span>
                                <span class="text-primary-600 font-bold">100% Gratis</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2">
                                <div class="bg-primary-500 h-2 rounded-full" style="width: 100%"></div>
                            </div>
                        </div>
                        <div class="text-[11px] text-secondary-400 text-center italic">
                            *Setiap pengajuan akan divalidasi manual oleh Admin Kecamatan.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tentang Section -->
<section id="tentang" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto space-y-4 mb-16">
            <h2 class="text-xs font-bold tracking-widest text-primary-600 uppercase">Mengenal Program</h2>
            <p class="text-3xl sm:text-4xl font-bold tracking-tight text-secondary-900">Mendorong Pertumbuhan Ekonomi Lokal Cicalengka</p>
            <div class="h-1 w-16 bg-primary-500 mx-auto rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
            @php
            $benefits = [
                [
                    'title' => 'Legalitas & Basis Data',
                    'desc' => 'Membantu pencatatan administratif usaha Anda di database Seksi Pemberdayaan Masyarakat Kecamatan Cicalengka secara legal dan terstruktur.',
                    'icon_path' => 'M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z'
                ],
                [
                    'title' => 'Program Pemberdayaan',
                    'desc' => 'UMKM yang terdata menjadi prioritas utama dalam mendapatkan program pelatihan, pembinaan, sertifikasi produk, bantuan modal, dan pameran.',
                    'icon_path' => 'M10.34 15.84c-.685-.34-1.386-.683-2.071-1.026a2.25 2.25 0 0 0-2.234 0l-2.071 1.026a2.25 2.25 0 0 0-1.07 1.916v1.944a2.25 2.25 0 0 0 2.25 2.25h13.75a2.25 2.25 0 0 0 2.25-2.25v-1.944a2.25 2.25 0 0 0-1.07-1.916l-2.07-1.026a2.25 2.25 0 0 0-2.235 0l-2.071 1.026a2.25 2.25 0 0 1-2.07 0ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z'
                ],
                [
                    'title' => 'Promosi & Ekspansi',
                    'desc' => 'Meningkatkan kredibilitas bisnis Anda untuk kolaborasi program kabupaten, instansi lain, serta kemudahan akses pembinaan pasar.',
                    'icon_path' => 'M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941'
                ]
            ];
            @endphp

            @foreach($benefits as $benefit)
            <div class="group bg-slate-50 hover:bg-white rounded-3xl p-8 border border-slate-100 hover:border-primary-100 hover:shadow-xl transition-all duration-300 space-y-5">
                <div class="w-12 h-12 rounded-2xl bg-primary-100 text-primary-700 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $benefit['icon_path'] }}" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-secondary-900">{{ $benefit['title'] }}</h3>
                <p class="text-sm text-secondary-600 leading-relaxed">
                    {{ $benefit['desc'] }}
                </p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Alur Section -->
<section id="alur" class="py-24 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto space-y-4 mb-16">
            <h2 class="text-xs font-bold tracking-widest text-primary-600 uppercase">Prosedur Mudah</h2>
            <p class="text-3xl sm:text-4xl font-bold tracking-tight text-secondary-900">Alur Pengajuan & Pendataan</p>
            <div class="h-1 w-16 bg-primary-500 mx-auto rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
            <!-- Background line connecting steps on desktop -->
            <div class="hidden md:block absolute top-1/3 left-1/6 right-1/6 h-0.5 bg-slate-200 -z-10"></div>

            @php
            $steps = [
                [
                    'num' => 1,
                    'title' => 'Isi Form Pengajuan',
                    'desc' => 'Lengkapi informasi data pemilik, detail usaha, lokasi, serta unggah foto pendukung usaha Anda melalui form pengajuan.',
                    'icon_path' => 'M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10'
                ],
                [
                    'num' => 2,
                    'title' => 'Verifikasi Admin',
                    'desc' => 'Admin Seksi Pemberdayaan Masyarakat akan memeriksa dan memvalidasi berkas administrasi serta foto lokasi secara berkala.',
                    'icon_path' => 'M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 01 1.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12Z'
                ],
                [
                    'num' => 3,
                    'title' => 'Terdata Resmi',
                    'desc' => 'Setelah disetujui, data UMKM akan otomatis terdaftar secara resmi di Kecamatan dan dapat diunduh/dicetak sebagai laporan berkala.',
                    'icon_path' => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A2.25 2.25 0 0112.75 21.5h-1.5a2.25 2.25 0 01-2.25-2.25v-.109m0-2.178a9.38 9.38 0 00-2.625.372 9.337 9.337 0 00-4.121.952 4.125 4.125 0 007.533 2.493M9 19.128v-.003c0-1.113.285-2.16.786-3.07M15 12.25A3.375 3.375 0 0011.625 9H8.25m6.75 3.25a3.375 3.375 0 11-6.75 0M9 3.75h.008v.008H9V3.75Zm.75 0a.75.75 0 11-1.5 0 .75.75 0 0 1 1.5 0ZM9 7.5h.008v.008H9V7.5Zm.75 0a.75.75 0 11-1.5 0 .75.75 0 0 1 1.5 0Z'
                ]
            ];
            @endphp

            @foreach($steps as $step)
            <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm text-center relative hover:shadow-md transition-shadow">
                <span class="absolute -top-5 left-1/2 -translate-x-1/2 w-10 h-10 rounded-full bg-primary-600 text-white font-bold flex items-center justify-center shadow-md">{{ $step['num'] }}</span>
                <div class="w-14 h-14 rounded-2xl bg-primary-50 flex items-center justify-center text-primary-600 mx-auto mb-6 mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $step['icon_path'] }}" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-secondary-900 mb-2">{{ $step['title'] }}</h3>
                <p class="text-sm text-secondary-500 leading-relaxed">
                    {{ $step['desc'] }}
                </p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Syarat & Ketentuan Section -->
<section id="syarat" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <!-- Left Info -->
            <div class="lg:col-span-5 space-y-6">
                <h2 class="text-xs font-bold tracking-widest text-primary-600 uppercase">Persiapan Berkas</h2>
                <p class="text-3xl sm:text-4xl font-bold tracking-tight text-secondary-900 leading-tight">Syarat & Ketentuan Pengajuan Pendataan</p>
                <div class="h-1 w-16 bg-primary-500 rounded-full"></div>
                <p class="text-secondary-600 text-sm leading-relaxed">
                    Sebelum mengisi formulir pendataan, pastikan Anda memenuhi kriteria dan telah menyiapkan dokumen atau file pendukung agar proses verifikasi berjalan lancar.
                </p>
            </div>

            <!-- Right Requirements Card -->
            <div class="lg:col-span-7 bg-slate-50 rounded-3xl p-8 border border-slate-100 shadow-sm space-y-6">
                @php
                $requirements = [
                    [
                        'num' => 1,
                        'title' => 'Lokasi Usaha di Kecamatan Cicalengka',
                        'desc' => 'Usaha berlokasi fisik di wilayah administratif salah satu dari 12 desa di Kecamatan Cicalengka.'
                    ],
                    [
                        'num' => 2,
                        'title' => 'Kepemilikan dan Kontak Valid',
                        'desc' => 'Nama pemilik merupakan nama asli sesuai KTP. Wajib menyertakan nomor telepon/WhatsApp aktif yang dapat dihubungi oleh petugas.'
                    ],
                    [
                        'num' => 3,
                        'title' => 'Memiliki NIB (Nomor Induk Berusaha)',
                        'desc' => 'Pelaku UMKM wajib memiliki Nomor Induk Berusaha (NIB) yang aktif dan terdaftar resmi dari pemerintah.'
                    ],
                    [
                        'num' => 4,
                        'title' => 'Dokumentasi Foto Usaha',
                        'desc' => 'Siapkan foto produk utama, proses produksi, atau tampak depan fisik toko. Format file gambar berupa JPG, JPEG, PNG, atau WEBP dengan ukuran file maksimal 2 MB.'
                    ],
                    [
                        'num' => 5,
                        'title' => 'Keterangan Usaha Jelas',
                        'desc' => 'Menjelaskan nama usaha, deskripsi barang/jasa yang dijual, alamat lengkap, dan jenis kategori usaha dengan jujur dan aktual.'
                    ]
                ];
                @endphp

                @foreach($requirements as $req)
                <div class="flex items-start space-x-4">
                    <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 shrink-0">
                        <span class="text-sm font-bold">{{ $req['num'] }}</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-secondary-900">{{ $req['title'] }}</h4>
                        <p class="text-xs text-secondary-500 mt-1">{{ $req['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Informasi NIB & OSS Section -->
<section id="nib-oss" class="py-24 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto space-y-4 mb-16">
            <h2 class="text-xs font-bold tracking-widest text-primary-600 uppercase">Informasi Legalitas Usaha</h2>
            <p class="text-3xl sm:text-4xl font-bold tracking-tight text-secondary-900">Pendaftaran NIB Mandiri via OSS</p>
            <div class="h-1 w-16 bg-primary-500 mx-auto rounded-full"></div>
        </div>

        <!-- Section Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
            <!-- Left Info Card -->
            <div class="lg:col-span-7 bg-white rounded-3xl p-8 sm:p-10 border border-slate-100 shadow-sm space-y-6 flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-primary-100 text-primary-700 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-secondary-900">Belum Punya NIB? Daftar Gratis di OSS.go.id</h3>
                    <p class="text-sm text-secondary-600 leading-relaxed">
                        Bagi pelaku UMKM yang belum memiliki Nomor Induk Berusaha (NIB), Anda dapat melakukan pendaftaran NIB secara mandiri, mudah, dan <strong>100% gratis</strong> melalui sistem <strong>OSS (Online Single Submission)</strong> resmi milik Pemerintah Republik Indonesia.
                    </p>
                </div>

                <div class="pt-4 border-t border-slate-100">
                    <a href="https://oss.go.id" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center space-x-2 px-6 py-3.5 rounded-2xl text-sm font-bold text-white bg-gradient-to-r from-primary-600 to-emerald-500 hover:from-primary-700 hover:to-emerald-600 shadow-md shadow-primary-200 transition-all duration-300 hover:-translate-y-0.5">
                        <span>Pendaftaran NIB via OSS.go.id</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Right Clarification / Note Card -->
            <div class="lg:col-span-5 bg-white rounded-3xl p-8 sm:p-10 border border-slate-100 shadow-sm space-y-6 flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-secondary-900">Peran & Fungsi SIPANDA</h3>
                    <p class="text-sm text-secondary-600 leading-relaxed">
                        Sistem SIPANDA dipergunakan khusus untuk pendataan, pembinaan, dan verifikasi administratif pelaku UMKM di wilayah Kecamatan Cicalengka.
                    </p>
                    <div class="p-4 bg-amber-50 rounded-2xl border border-amber-100 text-xs text-amber-900 leading-relaxed font-medium">
                        <strong>Catatan Penting:</strong> SIPANDA <u>TIDAK menerbitkan legalitas usaha</u>. Legalitas usaha resmi (NIB) diterbitkan secara sah oleh Pemerintah RI melalui layanan portal OSS.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="bg-secondary-900 bg-gradient-to-tr from-secondary-900 to-primary-900 text-white py-20 relative overflow-hidden">
    <!-- Grid elements -->
    <div class="absolute inset-0 bg-[linear-gradient(to_right,#1f2937_1px,transparent_1px),linear-gradient(to_bottom,#1f2937_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] opacity-20"></div>
    
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8 space-y-8 relative z-10">
        <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Kembangkan Usaha Anda Bersama Kecamatan Cicalengka</h2>
        <p class="text-slate-300 text-base max-w-xl mx-auto leading-relaxed">
            Daftarkan UMKM Anda sekarang secara online. Tanpa antrean, proses transparan, dan terdata langsung di basis data dinas.
        </p>
        <div class="flex justify-center">
            <a href="{{ route('ajukan') }}" class="inline-flex items-center justify-center px-8 py-4 rounded-2xl text-base font-bold text-secondary-900 bg-gradient-to-r from-primary-400 to-emerald-300 hover:from-primary-500 hover:to-emerald-400 shadow-xl transition-all duration-300 hover:-translate-y-1">
                Mulai Pendataan UMKM
            </a>
        </div>
    </div>
</section>
@endsection
