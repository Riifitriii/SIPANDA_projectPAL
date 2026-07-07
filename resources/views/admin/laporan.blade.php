<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data UMKM Terdaftar - Kecamatan Cicalengka</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

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
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        @media print {
            body {
                background-color: white;
                color: black;
                font-size: 11px;
            }
            .no-print {
                display: none !important;
            }
            .print-padding {
                padding: 0 !important;
            }
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 font-sans p-6 sm:p-12 print-padding">

    <!-- Print Control Bar (Hidden when printing) -->
    <div class="max-w-6xl mx-auto mb-6 bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between no-print">
        <div class="text-xs text-slate-500 font-medium">
            <span>Pratinjau Cetak Laporan UMKM. Gunakan layout <strong>Landscape</strong> untuk hasil terbaik.</span>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.umkm') }}" class="px-4 py-2 rounded-lg text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                Kembali
            </a>
            <button onclick="window.print()" class="px-5 py-2 rounded-lg text-xs font-bold text-white bg-primary-600 hover:bg-primary-700 transition-colors shadow-md shadow-primary-100">
                Cetak Laporan
            </button>
        </div>
    </div>

    <!-- Printable Paper Sheet -->
    <div class="max-w-6xl mx-auto bg-white p-8 sm:p-12 border border-slate-200 shadow-lg print:border-none print:shadow-none min-h-screen flex flex-col justify-between">
        
        <div class="space-y-8">
            <!-- Kop Surat (Government Header) -->
            <div class="flex items-center justify-center border-b-4 border-double border-slate-900 pb-4 relative">
                <div class="text-center">
                    <h3 class="text-base font-bold uppercase tracking-wider text-slate-900">Pemerintah Kabupaten Bandung</h3>
                    <h2 class="text-lg font-extrabold uppercase tracking-wide text-slate-900 mt-0.5">Kecamatan Cicalengka</h2>
                    <h1 class="text-xl font-black uppercase tracking-widest text-slate-900 mt-0.5">Seksi Pemberdayaan Masyarakat</h1>
                    <p class="text-[10px] text-slate-500 mt-1 italic">Jl. Raya Cicalengka No. 320, Cicalengka, Kabupaten Bandung, Jawa Barat 40395 - Telp: (022) 7949015</p>
                </div>
            </div>

            <!-- Document Title -->
            <div class="text-center space-y-1">
                <h4 class="text-sm font-bold uppercase tracking-wide text-slate-800 decoration-1 underline underline-offset-4">Laporan Data UMKM Terdaftar Resmi</h4>
                <p class="text-xs text-slate-600">Wilayah Desa: <strong>{{ $selectedDesa }}</strong> | Per Tanggal: <strong>{{ now()->locale('id')->translatedFormat('d F Y') }}</strong></p>
            </div>

            <!-- Data Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse border border-slate-300 text-xs">
                    <thead>
                        <tr class="bg-slate-100 text-slate-700 font-bold border-b border-slate-300">
                            <th class="py-2.5 px-3 border border-slate-300 text-center w-10">No</th>
                            <th class="py-2.5 px-3 border border-slate-300">No. Pengajuan</th>
                            <th class="py-2.5 px-3 border border-slate-300">Nama Usaha</th>
                            <th class="py-2.5 px-3 border border-slate-300">Pemilik</th>
                            <th class="py-2.5 px-3 border border-slate-300">NIB</th>
                            <th class="py-2.5 px-3 border border-slate-300">Sertifikat Halal</th>
                            <th class="py-2.5 px-3 border border-slate-300">Kategori</th>
                            <th class="py-2.5 px-3 border border-slate-300">Desa</th>
                            <th class="py-2.5 px-3 border border-slate-300">Alamat Lengkap</th>
                            <th class="py-2.5 px-3 border border-slate-300">No. Telepon</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-300">
                        @forelse($umkms as $index => $u)
                            <tr class="hover:bg-slate-50/50">
                                <td class="py-2 px-3 border border-slate-300 text-center font-medium">{{ $index + 1 }}</td>
                                <td class="py-2 px-3 border border-slate-300 font-mono font-semibold">{{ $u->nomor_pengajuan }}</td>
                                <td class="py-2 px-3 border border-slate-300 font-bold">{{ $u->nama_usaha }}</td>
                                <td class="py-2 px-3 border border-slate-300 font-medium">{{ $u->nama_pemilik }}</td>
                                <td class="py-2 px-3 border border-slate-300 font-mono">{{ $u->nib ?? '-' }}</td>
                                <td class="py-2 px-3 border border-slate-300 font-mono">{{ $u->sertifikasi_halal ?? '-' }}</td>
                                <td class="py-2 px-3 border border-slate-300 text-slate-600">{{ $u->jenis_usaha }}</td>
                                <td class="py-2 px-3 border border-slate-300">{{ $u->desa }}</td>
                                <td class="py-2 px-3 border border-slate-300 text-slate-600">{{ $u->alamat_lengkap }}</td>
                                <td class="py-2 px-3 border border-slate-300 font-semibold">{{ $u->nomor_telepon }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="py-6 px-3 border border-slate-300 text-center text-slate-400">
                                    Belum ada data pelaku UMKM terdaftar yang terverifikasi untuk wilayah desa ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Signature/Approval Block -->
        <div class="mt-16 grid grid-cols-2 gap-8 text-xs font-semibold">
            <!-- Left Side: Empty or PM officer -->
            <div class="space-y-16">
                <div class="space-y-1 text-center">
                    <p>Mengetahui,</p>
                    <p class="font-bold">Kepala Seksi Pemberdayaan Masyarakat</p>
                </div>
                <div class="text-center font-bold">
                    <span class="underline block">....................................................</span>
                    <span class="text-[10px] text-slate-500 font-medium block">NIP. ....................................................</span>
                </div>
            </div>

            <!-- Right Side: Camat Cicalengka -->
            <div class="space-y-16">
                <div class="space-y-1 text-center">
                    <p>Cicalengka, {{ now()->locale('id')->translatedFormat('d F Y') }}</p>
                    <p class="font-bold">Camat Cicalengka</p>
                </div>
                <div class="text-center font-bold">
                    <span class="underline block">....................................................</span>
                    <span class="text-[10px] text-slate-500 font-medium block">NIP. ....................................................</span>
                </div>
            </div>
        </div>
        
    </div>

</body>
</html>
