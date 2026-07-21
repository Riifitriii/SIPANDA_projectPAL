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
                color: black !important;
                font-size: 12px !important;
                margin: 0 !important;
                padding: 0 !important;
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
                padding: 8mm 20mm 15mm 20mm !important;
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
                margin-top: 1.5rem !important;
            }
            table, th, td {
                border-color: #000000 !important;
                color: #000000 !important;
            }
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
        .report-font {
            font-family: 'Times New Roman', 'Palatino Linotype', 'Georgia', serif;
            font-size: 12px !important;
            color: #000000 !important;
        }
        .report-font table, .report-font th, .report-font td {
            border-color: #000000 !important;
            color: #000000 !important;
        }
    </style>
</head>
<body class="bg-slate-100 text-black font-sans p-6 sm:p-12 print-padding">

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
    <div class="max-w-6xl mx-auto bg-white p-8 sm:p-12 shadow-lg print:shadow-none report-font printable-sheet">
        
        <div class="space-y-6">
            <!-- Header Group (Kop Surat + Line) -->
            <div class="space-y-3">
                <!-- Kop Surat (Government Header) -->
                <div class="flex items-center justify-center relative">
                    <div class="flex items-center">
                        <img src="{{ asset('logo-bandung.png') }}" alt="Logo Kabupaten Bandung" class="w-20 h-20 object-contain mr-5 shrink-0">
                        <div class="text-center">
                            <h3 class="font-bold uppercase tracking-wider text-black" style="font-size: 15px !important; line-height: 1.2;">Pemerintah Kabupaten Bandung</h3>
                            <h2 class="font-extrabold uppercase tracking-wide text-black mt-0.5" style="font-size: 15px !important; line-height: 1.2;">Kecamatan Cicalengka</h2>
                            <h1 class="font-black uppercase tracking-widest text-black mt-0.5" style="font-size: 19px !important; line-height: 1.2;">Seksi Pemberdayaan Masyarakat</h1>
                            <p class="text-black mt-1.5 italic" style="font-size: 8.5px !important; line-height: 1.3;">
                                Jl. Raya Timur Cicalengka No. 344 Kabupaten Bandung Telp. 0227949205 Email :<br>
                                kec.cicalengka@bandungkab.go.id Website : kecamatancicalengka.bandungkab.go.id
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Traditional Indonesian Letterhead Line (Thick Bold and Thin Line) -->
                <div class="space-y-[2px]">
                    <div class="border-b-[3px] border-black"></div>
                    <div class="border-b-[1px] border-black"></div>
                </div>
            </div>

            <!-- Document Title -->
            <div class="text-center space-y-1 text-black">
                <h4 class="text-sm font-bold uppercase tracking-wide text-black decoration-1 underline underline-offset-4">Laporan Data UMKM Terdaftar Resmi</h4>
                <p class="text-xs text-black">Wilayah Desa: <strong class="text-black">{{ $selectedDesa }}</strong> | Per Tanggal: <strong class="text-black">{{ now()->locale('id')->translatedFormat('d F Y') }}</strong></p>
            </div>

            <!-- Data Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse border border-black text-xs text-black">
                    <thead>
                        <tr class="bg-white text-black font-bold border-b border-black">
                            <th class="py-2.5 px-3 border border-black text-center w-10 text-black">No</th>
                            <th class="py-2.5 px-3 border border-black text-black">No. Pengajuan</th>
                            <th class="py-2.5 px-3 border border-black text-black">Nama Usaha</th>
                            <th class="py-2.5 px-3 border border-black text-black">Pemilik</th>
                            <th class="py-2.5 px-3 border border-black text-black">NIB</th>
                            <th class="py-2.5 px-3 border border-black text-black">Sertifikat Halal</th>
                            <th class="py-2.5 px-3 border border-black text-black">Kategori</th>
                            <th class="py-2.5 px-3 border border-black text-black">Desa</th>
                            <th class="py-2.5 px-3 border border-black text-black">Alamat Lengkap</th>
                            <th class="py-2.5 px-3 border border-black text-black">No. Telepon</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black text-black">
                        @forelse($umkms as $index => $u)
                            <tr class="hover:bg-slate-50/50">
                                <td class="py-2 px-3 border border-black text-center text-black">{{ $index + 1 }}</td>
                                <td class="py-2 px-3 border border-black font-mono text-black">{{ $u->nomor_pengajuan }}</td>
                                <td class="py-2 px-3 border border-black text-black">{{ $u->nama_usaha }}</td>
                                <td class="py-2 px-3 border border-black text-black">{{ $u->nama_pemilik }}</td>
                                <td class="py-2 px-3 border border-black font-mono text-black">{{ $u->nib ?? '-' }}</td>
                                <td class="py-2 px-3 border border-black font-mono text-black">{{ $u->sertifikasi_halal ?? '-' }}</td>
                                <td class="py-2 px-3 border border-black text-black">{{ $u->jenis_usaha }}</td>
                                <td class="py-2 px-3 border border-black text-black">{{ $u->desa }}</td>
                                <td class="py-2 px-3 border border-black text-black">{{ $u->alamat_lengkap }}</td>
                                <td class="py-2 px-3 border border-black text-black">{{ $u->nomor_telepon }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="py-6 px-3 border border-black text-center text-black">
                                    Belum ada data pelaku UMKM terdaftar yang terverifikasi untuk wilayah desa ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Signature/Approval Block -->
        <div class="mt-6 signature-block text-black">
            <!-- Date placed top-right above signature columns (1 line space from table) -->
            <div class="flex justify-end mb-2 text-xs font-semibold text-black">
                <p>Cicalengka, {{ now()->locale('id')->translatedFormat('d F Y') }}</p>
            </div>

            <!-- Two-column signature block -->
            <div class="grid grid-cols-2 gap-8 text-xs font-semibold text-black">
                <!-- Left signature: Kepala Seksi Pemberdayaan Masyarakat -->
                <div class="text-center text-black">
                    <div class="space-y-1">
                        <p class="invisible select-none">Mengetahui,</p>
                        <p class="font-bold text-black">Kepala Seksi Pemberdayaan Masyarakat</p>
                    </div>
                    <!-- 2-line signature gap -->
                    <div class="h-12"></div>
                    <div class="font-bold text-black flex flex-col items-center">
                        <span class="underline block text-black">....................................................</span>
                        <span class="text-[10px] text-black font-medium block mt-1">NIP. ....................................................</span>
                    </div>
                </div>

                <!-- Right signature: Mengetahui, Camat Cicalengka -->
                <div class="text-center text-black">
                    <div class="space-y-1">
                        <p class="text-black">Mengetahui,</p>
                        <p class="font-bold text-black">Camat Cicalengka</p>
                    </div>
                    <!-- 2-line signature gap -->
                    <div class="h-12"></div>
                    <div class="font-bold text-black flex flex-col items-center">
                        <span class="underline block text-black">....................................................</span>
                        <span class="text-[10px] text-black font-medium block mt-1">NIP. ....................................................</span>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

</body>
</html>
