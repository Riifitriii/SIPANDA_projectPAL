@extends('layouts.admin')

@section('title', 'Detail Verifikasi Pengajuan - ' . $submission->nomor_pengajuan)

@section('admin_content')
<div class="space-y-6 animate-fadeIn relative">

    <!-- Toast Notification untuk Salin NIB & Buka Link Resmi -->
    <div id="nib-toast" class="fixed top-6 right-6 z-50 transform -translate-y-12 opacity-0 pointer-events-none transition-all duration-300 ease-out flex items-center space-x-3 px-4 py-3 rounded-2xl bg-secondary-900/95 backdrop-blur text-white shadow-xl border border-slate-700 text-xs font-semibold max-w-md">
        <div id="nib-toast-icon" class="w-6 h-6 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
            </svg>
        </div>
        <span id="nib-toast-message" class="leading-snug"></span>
    </div>

    <div class="flex items-center space-x-3">
        <a href="{{ route('admin.pengajuan') }}" class="inline-flex items-center text-xs font-bold text-slate-500 hover:text-primary-600">
            &larr; Kembali ke Daftar Pengajuan
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-green-50 border border-green-100 text-green-700 text-xs font-semibold flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <div class="lg:col-span-7 bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 sm:p-8 space-y-6">
            <div class="border-b border-slate-100 pb-4 flex justify-between items-center">
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">No. Pengajuan</span>
                    <h2 class="text-xl font-bold text-secondary-900 font-mono tracking-wide">{{ $submission->nomor_pengajuan }}</h2>
                </div>

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
                    <div class="flex items-center space-x-2 mt-1">
                        <p class="text-secondary-800 font-mono font-bold">{{ $submission->nib ?: '-' }}</p>
                        @if($submission->nib)
                            <button type="button" onclick="copyNibToClipboard()" 
                                class="inline-flex items-center space-x-1 px-2 py-0.5 rounded text-[11px] font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 hover:text-secondary-900 transition-colors cursor-pointer"
                                title="Salin Nomor NIB">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3 h-3 text-slate-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                                </svg>
                                <span class="copy-feedback-text">Salin</span>
                            </button>
                        @endif
                    </div>
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

            <div class="space-y-2">
                <span class="text-xs text-slate-400 font-semibold block">Foto Tempat Usaha / Produk:</span>
                <div class="relative rounded-2xl overflow-hidden border border-slate-200 max-h-[350px]">
                    <img src="{{ asset($submission->foto_usaha) }}" alt="Foto Usaha" class="w-full h-full object-cover">
                </div>
            </div>
        </div>

        <div class="lg:col-span-5 bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 sm:p-8 space-y-6">
            <h3 class="text-lg font-bold text-secondary-900 border-b border-slate-100 pb-3">Tindakan Verifikasi</h3>

            <!-- Bantuan Cek NIB Manual via OSS -->
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-secondary-900 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-primary-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                        </svg>
                        Verifikasi Keabsahan NIB
                    </span>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                        oss.go.id
                    </span>
                </div>

                @if($submission->nib)
                    <div class="flex items-center justify-between bg-white px-3 py-2 rounded-lg border border-slate-200 text-xs">
                        <span class="text-slate-400 font-semibold">NIB:</span>
                        <div class="flex items-center space-x-2">
                            <span class="font-mono font-bold text-secondary-900">{{ $submission->nib }}</span>
                            <button type="button" onclick="copyNibToClipboard()" 
                                class="text-[11px] font-bold text-primary-600 hover:text-primary-800 underline cursor-pointer copy-feedback-text">
                                Salin
                            </button>
                        </div>
                    </div>

                    <a href="https://oss.go.id" target="_blank" rel="noopener noreferrer"
                        onclick="handleOssClick()"
                        class="w-full inline-flex items-center justify-center space-x-2 py-2.5 px-4 rounded-xl text-xs font-bold text-white bg-primary-600 hover:bg-primary-700 transition-colors shadow-sm cursor-pointer active:scale-98">
                        <span>Cek di Portal Resmi OSS</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                        </svg>
                    </a>

                    <p class="text-[10px] text-slate-400 text-center">
                        Terbuka di tab baru sebagai bantuan cek manual sebelum menyetujui data.
                    </p>
                @else
                    <p class="text-xs text-slate-500">
                        Pemohon belum mencantumkan NIB. Anda dapat mengecek legalitas usaha di portal OSS.
                    </p>
                    <a href="https://oss.go.id" target="_blank" rel="noopener noreferrer"
                        class="w-full inline-flex items-center justify-center space-x-2 py-2 px-3 rounded-lg text-xs font-bold text-primary-700 bg-primary-50 hover:bg-primary-100 border border-primary-200 transition-colors">
                        <span>Buka Portal OSS (oss.go.id)</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                        </svg>
                    </a>
                @endif
            </div>

            @if($submission->status === 'Perlu Perbaikan')
                <!-- Tautan Perbaikan Khusus untuk Dikirim ke Pemohon -->
                <div class="p-4 rounded-xl bg-orange-50/80 border border-orange-200/90 space-y-2.5">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-orange-950 flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-orange-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                            </svg>
                            Tautan Perbaikan untuk Pemohon
                        </span>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-orange-100 text-orange-800 border border-orange-200">
                            Formulir Khusus
                        </span>
                    </div>
                    <p class="text-[11px] text-orange-800 leading-relaxed">
                        Kirim tautan ini ke pemilik UMKM via WhatsApp agar pemohon dapat memperbarui berkas lamanya secara mandiri:
                    </p>
                    <div class="flex items-center justify-between bg-white px-3 py-2 rounded-lg border border-orange-200 text-xs">
                        <span class="font-mono text-slate-700 text-[11px] truncate mr-2">{{ route('pengajuan.perbaikan', $submission->nomor_pengajuan) }}</span>
                        <button type="button" onclick="copyPerbaikanLink()" class="font-bold text-orange-700 hover:text-orange-900 underline shrink-0 cursor-pointer">
                            Salin Link
                        </button>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.pengajuan.verifikasi', $submission->id) }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <span class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Tentukan Status Baru:</span>
                    <div class="space-y-3">
                        <label class="flex items-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition-colors">
                            <input type="radio" name="status" value="Menunggu Verifikasi" class="h-4.5 w-4.5 text-primary-600 focus:ring-primary-500" {{ $submission->status === 'Menunggu Verifikasi' ? 'checked' : '' }} onchange="toggleNoteField(false)">
                            <span class="ml-3 text-sm font-semibold text-amber-700 bg-amber-50 px-2 py-0.5 rounded border border-amber-100">Menunggu Verifikasi</span>
                        </label>
                        
                        <label class="flex items-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition-colors">
                            <input type="radio" name="status" value="Perlu Perbaikan" class="h-4.5 w-4.5 text-primary-600 focus:ring-primary-500" {{ $submission->status === 'Perlu Perbaikan' ? 'checked' : '' }} onchange="toggleNoteField(true)">
                            <span class="ml-3 text-sm font-semibold text-orange-700 bg-orange-50 px-2 py-0.5 rounded border border-orange-100">Perlu Perbaikan</span>
                        </label>

                        <label class="flex items-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition-colors">
                            <input type="radio" name="status" value="Disetujui" class="h-4.5 w-4.5 text-primary-600 focus:ring-primary-500" {{ $submission->status === 'Disetujui' ? 'checked' : '' }} onchange="toggleNoteField(false)">
                            <span class="ml-3 text-sm font-semibold text-green-700 bg-green-50 px-2 py-0.5 rounded border border-green-100">Disetujui (Terdata)</span>
                        </label>

                        <label class="flex items-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition-colors">
                            <input type="radio" name="status" value="Ditolak" class="h-4.5 w-4.5 text-primary-600 focus:ring-primary-500" {{ $submission->status === 'Ditolak' ? 'checked' : '' }} onchange="toggleNoteField(true)">
                            <span class="ml-3 text-sm font-semibold text-red-700 bg-red-50 px-2 py-0.5 rounded border border-red-100">Ditolak</span>
                        </label>
                    </div>
                    @error('status')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

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
                    <button type="submit" class="w-full py-3.5 rounded-xl text-sm font-bold text-white bg-primary-600 hover:bg-primary-700 transition-colors shadow-md shadow-primary-50 cursor-pointer">
                        Simpan Keputusan Verifikasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const NIB_VALUE = "{{ $submission->nib ?? '' }}";

    function showToast(message) {
        const toast = document.getElementById('nib-toast');
        const toastMsg = document.getElementById('nib-toast-message');
        if (!toast || !toastMsg) return;

        toastMsg.innerHTML = message;
        toast.classList.remove('-translate-y-12', 'opacity-0', 'pointer-events-none');
        toast.classList.add('translate-y-0', 'opacity-100');

        clearTimeout(window.__nibToastTimeout);
        window.__nibToastTimeout = setTimeout(() => {
            toast.classList.remove('translate-y-0', 'opacity-100');
            toast.classList.add('-translate-y-12', 'opacity-0', 'pointer-events-none');
        }, 3000);
    }

    function copyNibToClipboard(silent = false) {
        if (!NIB_VALUE) return;

        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(NIB_VALUE).then(() => {
                showCopyFeedback();
                if (!silent) showToast(`Nomor NIB <strong>${NIB_VALUE}</strong> berhasil disalin!`);
            }).catch(() => {
                fallbackCopyText(NIB_VALUE, silent);
            });
        } else {
            fallbackCopyText(NIB_VALUE, silent);
        }
    }

    function fallbackCopyText(text, silent) {
        const temp = document.createElement('input');
        temp.value = text;
        document.body.appendChild(temp);
        temp.select();
        try {
            document.execCommand('copy');
            showCopyFeedback();
            if (!silent) showToast(`Nomor NIB <strong>${text}</strong> berhasil disalin!`);
        } catch (err) {
            if (!silent) alert('Nomor NIB: ' + text);
        }
        document.body.removeChild(temp);
    }

    function showCopyFeedback() {
        document.querySelectorAll('.copy-feedback-text').forEach(el => {
            const original = el.innerText;
            el.innerText = 'Tersalin!';
            setTimeout(() => {
                el.innerText = original;
            }, 2000);
        });
    }

    function handleOssClick() {
        if (NIB_VALUE) {
            copyNibToClipboard(true);
            showToast(`NIB <strong>${NIB_VALUE}</strong> disalin! Membuka portal resmi OSS...`);
        }
    }

    function copyPerbaikanLink() {
        const link = "{{ route('pengajuan.perbaikan', $submission->nomor_pengajuan) }}";
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(link).then(() => {
                showToast('Tautan formulir perbaikan berhasil disalin ke clipboard!');
            }).catch(() => {
                fallbackCopyText(link, false);
            });
        } else {
            fallbackCopyText(link, false);
        }
    }

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

    window.addEventListener('load', function() {
        const checkedRadio = document.querySelector('input[name="status"]:checked');
        if (checkedRadio) {
            toggleNoteField(checkedRadio.value === 'Perlu Perbaikan' || checkedRadio.value === 'Ditolak');
        }
    });
</script>
@endsection
