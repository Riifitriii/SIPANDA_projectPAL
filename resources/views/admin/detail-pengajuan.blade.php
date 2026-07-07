@extends('layouts.admin')

@section('title', 'Detail Verifikasi Pengajuan - ' . $submission->nomor_pengajuan)

@section('admin_content')
<div class="space-y-6 animate-fadeIn">
    
    <!-- Top breadcrumb and back button -->
    <div class="flex items-center space-x-3">
        <a href="{{ route('admin.pengajuan') }}" class="inline-flex items-center text-xs font-bold text-slate-500 hover:text-primary-600">
            &larr; Kembali ke Daftar Pengajuan
        </a>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-green-50 border border-green-100 text-green-700 text-xs font-semibold flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Main Content Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left Side: Profile Details -->
        <div class="lg:col-span-7 bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 sm:p-8 space-y-6">
            <div class="border-b border-slate-100 pb-4 flex justify-between items-center">
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">No. Pengajuan</span>
                    <h2 class="text-xl font-bold text-secondary-900 font-mono tracking-wide">{{ $submission->nomor_pengajuan }}</h2>
                </div>
                <!-- Status Badge -->
                <div>
                    @if($submission->status === 'Menunggu Verifikasi')
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                            Menunggu Verifikasi
                        </span>
                    @elseif($submission->status === 'Perlu Perbaikan')
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-orange-50 text-orange-700 border border-orange-200">
                            Perlu Perbaikan
                        </span>
                    @elseif($submission->status === 'Disetujui')
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-green-50 text-green-700 border border-green-200">
                            Disetujui
                        </span>
                    @elseif($submission->status === 'Ditolak')
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-200">
                            Ditolak
                        </span>
                    @endif
                </div>
            </div>

            <!-- Profile Fields -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
                <div>
                    <span class="text-xs text-slate-400 font-semibold block">Nama Pemilik:</span>
                    <p class="text-secondary-800 font-bold mt-1">{{ $submission->nama_pemilik }}</p>
                </div>
                <div>
                    <span class="text-xs text-slate-400 font-semibold block">Nomor Telepon / WA:</span>
                    <p class="text-primary-700 font-bold mt-1">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $submission->nomor_telepon) }}" target="_blank" class="hover:underline flex items-center space-x-1.5">
                            <span>{{ $submission->nomor_telepon }}</span>
                            <!-- WA Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-3.5 h-3.5 text-green-500 inline">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.248 8.477 3.514 2.266 2.265 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.717-1.454L0 24zm6.59-4.846c1.6.95 3.498 1.453 5.418 1.454 5.497 0 9.972-4.47 9.976-9.964.001-2.662-1.036-5.164-2.924-7.053C17.228 1.702 14.73 .664 12.015.664c-5.503 0-9.978 4.47-9.982 9.965-.001 1.99.52 3.93 1.509 5.644L2.527 21.9l5.7-.621.42.249z"/>
                            </svg>
                        </a>
                    </p>
                </div>
                <div>
                    <span class="text-xs text-slate-400 font-semibold block">Nama Usaha:</span>
                    <p class="text-secondary-800 font-bold mt-1">{{ $submission->nama_usaha }}</p>
                </div>
                <div>
                    <span class="text-xs text-slate-400 font-semibold block">Kategori Usaha:</span>
                    <p class="text-secondary-800 font-bold mt-1">{{ $submission->jenis_usaha }}</p>
                </div>
                <div>
                    <span class="text-xs text-slate-400 font-semibold block">Nomor Induk Berusaha (NIB):</span>
                    <p class="text-secondary-800 font-mono font-bold mt-1">{{ $submission->nib ?? '-' }}</p>
                </div>
                <div>
                    <span class="text-xs text-slate-400 font-semibold block">Sertifikat Halal:</span>
                    <p class="text-secondary-800 font-mono font-bold mt-1">{{ $submission->sertifikasi_halal ?? '-' }}</p>
                </div>
                <div class="sm:col-span-2">
                    <span class="text-xs text-slate-400 font-semibold block">Deskripsi Usaha:</span>
                    <p class="text-secondary-600 leading-relaxed mt-1 bg-slate-50 p-4 rounded-xl border border-slate-100">{{ $submission->deskripsi_usaha }}</p>
                </div>
                <div>
                    <span class="text-xs text-slate-400 font-semibold block">Desa:</span>
                    <p class="text-secondary-800 font-bold mt-1">{{ $submission->desa }}</p>
                </div>
                <div class="sm:col-span-2">
                    <span class="text-xs text-slate-400 font-semibold block">Alamat Usaha Lengkap:</span>
                    <p class="text-secondary-600 mt-1">{{ $submission->alamat_lengkap }}</p>
                </div>
            </div>

            <!-- Uploaded Image -->
            <div class="space-y-2">
                <span class="text-xs text-slate-400 font-semibold block">Foto Tempat Usaha / Produk:</span>
                <div class="relative rounded-2xl overflow-hidden border border-slate-200 max-h-[350px]">
                    <img src="{{ asset($submission->foto_usaha) }}" alt="Foto Usaha" class="w-full h-full object-cover">
                </div>
            </div>
        </div>

        <!-- Right Side: Verification Form -->
        <div class="lg:col-span-5 bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 sm:p-8 space-y-6">
            <h3 class="text-lg font-bold text-secondary-900 border-b border-slate-100 pb-3">Tindakan Verifikasi</h3>

            <form action="{{ route('admin.pengajuan.verifikasi', $submission->id) }}" method="POST" class="space-y-6">
                @csrf

                <!-- Status Radio Toggles -->
                <div>
                    <span class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Tentukan Status Baru:</span>
                    
                    <div class="space-y-3">
                        <!-- Menunggu Verifikasi -->
                        <label class="flex items-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition-colors">
                            <input type="radio" name="status" value="Menunggu Verifikasi" class="h-4.5 w-4.5 text-primary-600 focus:ring-primary-500" {{ $submission->status === 'Menunggu Verifikasi' ? 'checked' : '' }} onchange="toggleNoteField(false)">
                            <span class="ml-3 text-sm font-semibold text-amber-700 bg-amber-50 px-2 py-0.5 rounded border border-amber-100">Menunggu Verifikasi</span>
                        </label>

                        <!-- Perlu Perbaikan -->
                        <label class="flex items-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition-colors">
                            <input type="radio" name="status" value="Perlu Perbaikan" class="h-4.5 w-4.5 text-primary-600 focus:ring-primary-500" {{ $submission->status === 'Perlu Perbaikan' ? 'checked' : '' }} onchange="toggleNoteField(true)">
                            <span class="ml-3 text-sm font-semibold text-orange-700 bg-orange-50 px-2 py-0.5 rounded border border-orange-100">Perlu Perbaikan</span>
                        </label>

                        <!-- Disetujui -->
                        <label class="flex items-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition-colors">
                            <input type="radio" name="status" value="Disetujui" class="h-4.5 w-4.5 text-primary-600 focus:ring-primary-500" {{ $submission->status === 'Disetujui' ? 'checked' : '' }} onchange="toggleNoteField(false)">
                            <span class="ml-3 text-sm font-semibold text-green-700 bg-green-50 px-2 py-0.5 rounded border border-green-100">Disetujui (Terdata)</span>
                        </label>

                        <!-- Ditolak -->
                        <label class="flex items-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition-colors">
                            <input type="radio" name="status" value="Ditolak" class="h-4.5 w-4.5 text-primary-600 focus:ring-primary-500" {{ $submission->status === 'Ditolak' ? 'checked' : '' }} onchange="toggleNoteField(true)">
                            <span class="ml-3 text-sm font-semibold text-red-700 bg-red-50 px-2 py-0.5 rounded border border-red-100">Ditolak</span>
                        </label>
                    </div>
                    @error('status')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Admin Note / Feedback -->
                <div id="note-field-wrapper">
                    <label for="catatan_admin" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 flex items-center justify-between">
                        <span>Catatan Admin / Umpan Balik:</span>
                        <span id="note-required-badge" class="text-[9px] font-bold text-red-500 hidden">WAJIB DIISI</span>
                    </label>
                    <textarea name="catatan_admin" id="catatan_admin" rows="5" placeholder="Tuliskan keterangan detail di sini. Catatan wajib diisi apabila status diubah menjadi 'Perlu Perbaikan' atau 'Ditolak' agar pemohon mengetahui revisi yang diperlukan..." class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm transition-all">{{ old('catatan_admin', $submission->catatan_admin) }}</textarea>
                    @error('catatan_admin')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2 border-t border-slate-100 flex items-center justify-end">
                    <button type="submit" class="w-full py-3.5 rounded-xl text-sm font-bold text-white bg-primary-600 hover:bg-primary-700 transition-colors shadow-md shadow-primary-50">
                        Simpan Keputusan Verifikasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Dynamic note validation badge script -->
<script>
    function toggleNoteField(isRequired) {
        const badge = document.getElementById('note-required-badge');
        const textarea = document.getElementById('catatan_admin');
        if (isRequired) {
            badge.classList.remove('hidden');
            textarea.placeholder = "Contoh: Mohon perbaiki foto usaha Anda karena resolusinya terlalu gelap, atau isi nama pemilik sesuai KTP.";
        } else {
            badge.classList.add('hidden');
            textarea.placeholder = "Tuliskan keterangan detail di sini (opsional untuk status disetujui)...";
        }
    }
    
    // Trigger onload to check current selected state
    window.addEventListener('load', function() {
        const checkedRadio = document.querySelector('input[name="status"]:checked');
        if (checkedRadio) {
            const val = checkedRadio.value;
            toggleNoteField(val === 'Perlu Perbaikan' || val === 'Ditolak');
        }
    });
</script>
@endsection
