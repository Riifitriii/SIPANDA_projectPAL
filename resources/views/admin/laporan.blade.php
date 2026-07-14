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

    @vite(['resources/css/app.css'])
    <style>
        @media print {
            body {
                background-color: white;
                color: black;
                font-size: 12px !important;
                margin: 0 !important;
                padding: 0 !important; /* Reset body padding on print */
            }
            .no-print {
                display: none !important;
            }
            @page {
                size: auto;
                margin: 0;
            }
            .printable-sheet {
                width: 100% !important;
                max-width: 100% !important;
                padding: 8mm 20mm 15mm 20mm !important; /* 8mm top padding to fit closely at the top */
                margin: 0 !important;
                border: none !important;
                box-shadow: none !important;
                min-height: auto !important;
                height: auto !important;
                display: block !important;
            }
            .signature-block {
                page-break-inside: avoid;
                break-inside: avoid;
            }
        }
        .report-font {
            font-family: 'Times New Roman', 'Palatino Linotype', 'Georgia', serif;
            font-size: 12px !important;
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
    <div class="max-w-6xl mx-auto bg-white p-8 sm:p-12 border border-slate-200 shadow-lg print:border-none print:shadow-none min-h-screen flex flex-col justify-between report-font printable-sheet">
        
        <div class="space-y-6">
            <!-- Header Group (Kop Surat + Line) -->
            <div class="space-y-3">
                <!-- Kop Surat (Government Header) -->
                <div class="flex items-center justify-center relative">
                    <div class="flex items-center">
                        <img src="{{ asset('logo-bandung.png') }}" alt="Logo Kabupaten Bandung" class="w-20 h-20 object-contain mr-5 shrink-0">
                        <div class="text-center">
                            <h3 class="font-bold uppercase tracking-wider text-slate-900" style="font-size: 15px !important; line-height: 1.2;">Pemerintah Kabupaten Bandung</h3>
                            <h2 class="font-extrabold uppercase tracking-wide text-slate-900 mt-0.5" style="font-size: 15px !important; line-height: 1.2;">Kecamatan Cicalengka</h2>
                            <h1 class="font-black uppercase tracking-widest text-slate-900 mt-0.5" style="font-size: 19px !important; line-height: 1.2;">Seksi Pemberdayaan Masyarakat</h1>
                            <p class="text-slate-500 mt-1.5 italic" style="font-size: 8.5px !important; line-height: 1.3;">
                                Jl. Raya Timur Cicalengka No. 344 Kabupaten Bandung Telp. 0227949205 Email :<br>
                                kec.cicalengka@bandungkab.go.id Website : kecamatancicalengka.bandungkab.go.id
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Traditional Indonesian Letterhead Line (Thick Bold and Thin Line) -->
                <div class="space-y-[2px]">
                    <div class="border-b-[3px] border-slate-900"></div>
                    <div class="border-b-[1px] border-slate-900"></div>
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
        <div class="mt-16 grid grid-cols-2 gap-8 text-xs font-semibold signature-block">
            <!-- Left signature: Kepala Seksi -->
            <div class="space-y-16 text-center">
                <div class="space-y-1">
                    <p>Mengetahui,</p>
                    <p class="font-bold text-slate-900">Kepala Seksi Pemberdayaan Masyarakat</p>
                </div>
                <div class="font-bold">
                    <span class="underline block">....................................................</span>
                    <span class="text-[10px] text-slate-500 font-medium block">NIP. ....................................................</span>
                </div>
            </div>

            <!-- Right signature: Camat -->
            <div class="space-y-16 text-center">
                <div class="space-y-1">
                    <p>Cicalengka, {{ now()->locale('id')->translatedFormat('d F Y') }}</p>
                    <p class="font-bold text-slate-900">Camat Cicalengka</p>
                </div>
                <div class="font-bold">
                    <span class="underline block">....................................................</span>
                    <span class="text-[10px] text-slate-500 font-medium block">NIP. ....................................................</span>
                </div>
            </div>
        </div>
        
    </div>

</body>
</html>
