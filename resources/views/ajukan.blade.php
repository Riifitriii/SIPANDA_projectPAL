@extends('layouts.app')

@section('title', 'Form Pengajuan Pendataan UMKM - SIPANDA Cicalengka')

@section('content')
<section class="py-16 bg-slate-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Page -->
        <div class="text-center space-y-3 mb-12">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-secondary-900 tracking-tight">Form Pengajuan Pendataan UMKM</h1>
            <p class="text-sm text-secondary-500 max-w-lg mx-auto">
                Lengkapi seluruh formulir di bawah ini dengan data asli dan dapat dipertanggungjawabkan untuk diverifikasi oleh Seksi Pemberdayaan Masyarakat Kecamatan Cicalengka.
            </p>
        </div>

        @if(session('success_submission'))
        <!-- Success Card -->
        <div class="bg-white rounded-3xl p-8 border border-primary-200 shadow-xl shadow-primary-50/50 mb-8 border-l-8 border-l-primary-600 animate-fadeIn space-y-6">
            <div class="flex items-center space-x-4">
                <div class="w-14 h-14 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 shrink-0">
                    <!-- Double Check icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-7 h-7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-secondary-955">Pengajuan Berhasil Dikirim!</h3>
                    <p class="text-xs text-secondary-500">Silakan simpan nomor pengajuan di bawah ini untuk memantau status secara berkala.</p>
                </div>
            </div>

            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div>
                    <span class="text-xs text-secondary-400 font-semibold block">NOMOR PENGAJUAN ANDA:</span>
                    <span class="text-2xl font-black text-primary-700 tracking-wider block" id="nomor-copy">{{ session('success_submission')['nomor_pengajuan'] }}</span>
                </div>
                <button onclick="copyToClipboard()" class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-3 rounded-xl text-xs font-bold text-white bg-secondary-900 hover:bg-secondary-800 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5A3.375 3.375 0 006.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0015 2.25h-1.5a2.251 2.251 0 00-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 00-9-9z" />
                    </svg>
                    Salin Kode
                </button>
            </div>

            <div class="bg-primary-50 rounded-2xl p-5 border border-primary-100/50 space-y-2">
                <span class="text-sm font-bold text-primary-900 block">Informasi Usaha Terdaftar:</span>
                <ul class="text-xs text-primary-800 space-y-1">
                    <li><strong>Nama Usaha:</strong> {{ session('success_submission')['nama_usaha'] }}</li>
                    <li><strong>Nama Pemilik:</strong> {{ session('success_submission')['nama_pemilik'] }}</li>
                    <li><strong>Status Awal:</strong> Menunggu Verifikasi (Proses validasi membutuhkan 1-3 hari kerja)</li>
                </ul>
            </div>

            <div class="flex justify-end pt-2">
                <a href="{{ route('cek-status') }}" class="inline-flex items-center text-sm font-bold text-primary-600 hover:text-primary-700">
                    Cek Status Sekarang &rarr;
                </a>
            </div>
        </div>
        @endif

        <!-- Form Pengajuan -->
        <form action="{{ route('ajukan.submit') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-md space-y-10">
            @csrf

            <!-- 1. DATA PEMILIK -->
            <div class="space-y-6">
                <div class="border-b border-slate-100 pb-4 flex items-center space-x-3">
                    <span class="w-8 h-8 rounded-lg bg-primary-100 text-primary-700 flex items-center justify-center font-bold text-sm">1</span>
                    <h3 class="text-lg font-bold text-secondary-900">Identitas Pemilik Usaha</h3>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="nama_pemilik" class="block text-xs font-bold text-secondary-700 uppercase tracking-wider mb-2">Nama Lengkap Pemilik (Sesuai KTP) <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_pemilik" id="nama_pemilik" value="{{ old('nama_pemilik') }}" placeholder="Contoh: Asep Sunandar" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('nama_pemilik') border-red-400 focus:ring-red-400 @enderror">
                        @error('nama_pemilik')
                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nomor_telepon" class="block text-xs font-bold text-secondary-700 uppercase tracking-wider mb-2">Nomor Telepon / WhatsApp <span class="text-red-500">*</span></label>
                        <input type="text" name="nomor_telepon" id="nomor_telepon" value="{{ old('nomor_telepon') }}" placeholder="Contoh: 081234567890" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('nomor_telepon') border-red-400 focus:ring-red-400 @enderror">
                        @error('nomor_telepon')
                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- 2. INFORMASI USAHA -->
            <div class="space-y-6">
                <div class="border-b border-slate-100 pb-4 flex items-center space-x-3">
                    <span class="w-8 h-8 rounded-lg bg-primary-100 text-primary-700 flex items-center justify-center font-bold text-sm">2</span>
                    <h3 class="text-lg font-bold text-secondary-900">Informasi Profil Usaha</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="nama_usaha" class="block text-xs font-bold text-secondary-700 uppercase tracking-wider mb-2">Nama Usaha / Produk <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_usaha" id="nama_usaha" value="{{ old('nama_usaha') }}" placeholder="Contoh: Keripik Singkong Cicalengka" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('nama_usaha') border-red-400 focus:ring-red-400 @enderror">
                        @error('nama_usaha')
                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jenis_usaha" class="block text-xs font-bold text-secondary-700 uppercase tracking-wider mb-2">Kategori / Jenis Usaha <span class="text-red-500">*</span></label>
                        <select name="jenis_usaha" id="jenis_usaha" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('jenis_usaha') border-red-400 focus:ring-red-400 @enderror">
                            <option value="">-- Pilih Jenis Usaha --</option>
                            <option value="Kuliner (Makanan & Minuman)" {{ old('jenis_usaha') == 'Kuliner (Makanan & Minuman)' ? 'selected' : '' }}>Kuliner (Makanan & Minuman)</option>
                            <option value="Kriya & Kerajinan Tangan" {{ old('jenis_usaha') == 'Kriya & Kerajinan Tangan' ? 'selected' : '' }}>Kriya & Kerajinan Tangan</option>
                            <option value="Fashion & Konveksi" {{ old('jenis_usaha') == 'Fashion & Konveksi' ? 'selected' : '' }}>Fashion & Konveksi</option>
                            <option value="Pertanian & Peternakan" {{ old('jenis_usaha') == 'Pertanian & Peternakan' ? 'selected' : '' }}>Pertanian & Peternakan</option>
                            <option value="Jasa & Perdagangan" {{ old('jenis_usaha') == 'Jasa & Perdagangan' ? 'selected' : '' }}>Jasa & Perdagangan</option>
                            <option value="Kecantikan & Kesehatan" {{ old('jenis_usaha') == 'Kecantikan & Kesehatan' ? 'selected' : '' }}>Kecantikan & Kesehatan</option>
                            <option value="Lainnya" {{ old('jenis_usaha') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('jenis_usaha')
                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="nib" class="block text-xs font-bold text-secondary-700 uppercase tracking-wider mb-2">Nomor Induk Berusaha (NIB) <span class="text-secondary-400 font-normal">(Opsional)</span></label>
                        <input type="text" name="nib" id="nib" value="{{ old('nib') }}" placeholder="Contoh: 9120001234567" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('nib') border-red-400 focus:ring-red-400 @enderror">
                        @error('nib')
                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="sertifikasi_halal" class="block text-xs font-bold text-secondary-700 uppercase tracking-wider mb-2">Nomor Sertifikat Halal <span class="text-secondary-400 font-normal">(Opsional)</span></label>
                        <input type="text" name="sertifikasi_halal" id="sertifikasi_halal" value="{{ old('sertifikasi_halal') }}" placeholder="Contoh: ID32110001234567890" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('sertifikasi_halal') border-red-400 focus:ring-red-400 @enderror">
                        @error('sertifikasi_halal')
                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="deskripsi_usaha" class="block text-xs font-bold text-secondary-700 uppercase tracking-wider mb-2">Deskripsi Usaha <span class="text-red-500">*</span></label>
                    <textarea name="deskripsi_usaha" id="deskripsi_usaha" rows="4" placeholder="Jelaskan produk yang Anda jual, keunggulan usaha, proses pembuatan, atau model pelayanan usaha Anda..." class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('deskripsi_usaha') border-red-400 focus:ring-red-400 @enderror">{{ old('deskripsi_usaha') }}</textarea>
                    @error('deskripsi_usaha')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- 3. LOKASI USAHA -->
            <div class="space-y-6">
                <div class="border-b border-slate-100 pb-4 flex items-center space-x-3">
                    <span class="w-8 h-8 rounded-lg bg-primary-100 text-primary-700 flex items-center justify-center font-bold text-sm">3</span>
                    <h3 class="text-lg font-bold text-secondary-900">Lokasi Tempat Usaha</h3>
                </div>

                <div>
                    <label for="desa" class="block text-xs font-bold text-secondary-700 uppercase tracking-wider mb-2">Desa Wilayah Kecamatan Cicalengka <span class="text-red-500">*</span></label>
                    <select name="desa" id="desa" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('desa') border-red-400 focus:ring-red-400 @enderror">
                        <option value="">-- Pilih Desa --</option>
                        @php
                            $desaList = [
                                'Babakan Peuteuy', 'Cicalengka Kulon', 'Cicalengka Wetan', 
                                'Cikuya', 'Dampit', 'Margaasih', 'Nagrog', 'Narawita', 
                                'Panenjoan', 'Tenjolaya', 'Waluya', 'Tanjungwangi'
                            ];
                        @endphp
                        @foreach($desaList as $d)
                            <option value="{{ $d }}" {{ old('desa') == $d ? 'selected' : '' }}>{{ $d }}</option>
                        @endforeach
                    </select>
                    @error('desa')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="alamat_lengkap" class="block text-xs font-bold text-secondary-700 uppercase tracking-wider mb-2">Alamat Usaha Lengkap <span class="text-red-500">*</span></label>
                    <textarea name="alamat_lengkap" id="alamat_lengkap" rows="3" placeholder="Contoh: Jl. Dipatiukur No. 12, RT 02 RW 05 (Samping Masjid Al-Hidayah)" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('alamat_lengkap') border-red-400 focus:ring-red-400 @enderror">{{ old('alamat_lengkap') }}</textarea>
                    @error('alamat_lengkap')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- 4. DOKUMENTASI -->
            <div class="space-y-6">
                <div class="border-b border-slate-100 pb-4 flex items-center space-x-3">
                    <span class="w-8 h-8 rounded-lg bg-primary-100 text-primary-700 flex items-center justify-center font-bold text-sm">4</span>
                    <h3 class="text-lg font-bold text-secondary-900">Dokumentasi Tempat Usaha / Produk</h3>
                </div>

                <div>
                    <label class="block text-xs font-bold text-secondary-700 uppercase tracking-wider mb-2">Unggah Foto Fisik Usaha atau Produk <span class="text-red-500">*</span></label>
                    
                    <div class="mt-2 flex justify-center rounded-2xl border-2 border-dashed border-slate-200 px-6 pt-5 pb-6 hover:border-primary-400 transition-colors">
                        <div class="space-y-1 text-center">
                            <!-- Upload Icon -->
                            <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-secondary-600">
                                <label for="foto_usaha" class="relative cursor-pointer rounded-md bg-white font-semibold text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-primary-500 focus-within:ring-offset-2">
                                    <span>Pilih Gambar Usaha</span>
                                    <input id="foto_usaha" name="foto_usaha" type="file" class="sr-only" onchange="previewImage(this)">
                                </label>
                                <p class="pl-1">atau seret file ke sini</p>
                            </div>
                            <p class="text-xs text-secondary-400">PNG, JPG, JPEG, WEBP maksimal 2MB</p>
                        </div>
                    </div>

                    <!-- Image Preview Area -->
                    <div id="preview-wrapper" class="mt-4 hidden">
                        <span class="text-xs font-bold text-secondary-500 block mb-1">Pratinjau Foto:</span>
                        <div class="relative w-48 h-32 rounded-xl overflow-hidden border border-slate-200">
                            <img id="image-preview" src="#" alt="Pratinjau foto usaha" class="w-full h-full object-cover">
                            <button type="button" onclick="removePreview()" class="absolute top-1.5 right-1.5 w-6 h-6 rounded-full bg-red-600 text-white flex items-center justify-center shadow-md hover:bg-red-700">
                                <span class="text-xs font-bold">&times;</span>
                            </button>
                        </div>
                    </div>

                    @error('foto_usaha')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-end gap-3">
                <a href="{{ route('landing') }}" class="w-full sm:w-auto text-center px-6 py-3 rounded-xl text-sm font-semibold text-secondary-600 hover:bg-slate-100 transition-colors">
                    Batal
                </a>
                <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-primary-600 to-emerald-500 hover:from-primary-700 hover:to-emerald-600 shadow-md shadow-primary-100 hover:shadow-lg transition-all">
                    Kirim Pengajuan Pendataan
                </button>
            </div>
        </form>
    </div>
</section>

<!-- Script for Image Preview & Clipboard -->
<script>
    function previewImage(input) {
        const previewWrapper = document.getElementById('preview-wrapper');
        const previewImg = document.getElementById('image-preview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewWrapper.classList.remove('hidden');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    function removePreview() {
        const fileInput = document.getElementById('foto_usaha');
        const previewWrapper = document.getElementById('preview-wrapper');
        
        fileInput.value = '';
        previewWrapper.classList.add('hidden');
    }

    function copyToClipboard() {
        const nomorCopy = document.getElementById('nomor-copy').innerText;
        navigator.clipboard.writeText(nomorCopy).then(() => {
            alert('Nomor pengajuan berhasil disalin!');
        });
    }
</script>
@endsection
