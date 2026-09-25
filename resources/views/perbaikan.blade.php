@extends('layouts.app')

@section('title', 'Perbaikan Data Pengajuan UMKM - SIPANDA Cicalengka')

@section('content')
<section class="py-16 bg-slate-50 min-h-[75vh]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        @if(!$isVerified)
        {{-- ========================================================================= --}}
        {{-- TAHAP 1: VERIFIKASI KEPEMILIKAN PENGAJUAN (NOMOR PENGAJUAN + NOMOR TELEPON) --}}
        {{-- ========================================================================= --}}
        <div class="max-w-md mx-auto">
            <div class="text-center space-y-2 mb-6">
                <div style="width: 52px; height: 52px; border-radius: 16px; background: #ecfdf5; color: #16a34a; border: 1px solid #bbf7d0; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 8px; box-shadow: 0 4px 10px rgba(22, 163, 74, 0.1);">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 24px; height: 24px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                </div>
                <h1 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -0.02em;">Verifikasi Kepemilikan</h1>
                <p style="font-size: 13px; color: #64748b; line-height: 1.5; margin: 4px 0 0 0;">
                    Untuk melindungi keamanan data UMKM Anda, masukkan nomor telepon/WhatsApp yang Anda daftarkan di awal untuk membuka formulir perbaikan.
                </p>
            </div>

            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 24px; padding: 28px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05); display: flex; flex-direction: column; gap: 20px;">
                
                <!-- Info Pengajuan Rapi (Non-Overlapping) -->
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 16px; padding: 14px 16px;">
                    <div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0; gap: 8px;">
                        <span style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; flex-shrink: 0;">Nomor Pengajuan:</span>
                        <span style="font-family: monospace; font-size: 12px; font-weight: 800; color: #15803d; background: #dcfce7; padding: 3px 8px; border-radius: 6px; border: 1px solid #bbf7d0;">
                            {{ $submission->nomor_pengajuan }}
                        </span>
                    </div>
                    <div style="display: flex; align-items: center; justify-content: space-between; padding-top: 10px; gap: 8px;">
                        <span style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; flex-shrink: 0;">Nama Usaha:</span>
                        <span style="font-size: 13px; font-weight: 800; color: #0f172a; text-align: right; word-break: break-word;">
                            {{ $submission->nama_usaha }}
                        </span>
                    </div>
                </div>

                <!-- Catatan Admin Singkat -->
                @if($submission->catatan_admin)
                <div style="background: #fffbeb; border: 1px solid #fde68a; border-left: 4px solid #f59e0b; border-radius: 14px; padding: 14px 16px;">
                    <div style="display: flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 800; color: #92400e; margin-bottom: 4px;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width: 15px; height: 15px; color: #d97706; flex-shrink: 0;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                        <span>Catatan Perbaikan dari Admin:</span>
                    </div>
                    <p style="font-size: 12px; color: #78350f; margin: 0; line-height: 1.5; padding-left: 21px; font-weight: 500;">
                        {{ $submission->catatan_admin }}
                    </p>
                </div>
                @endif

                @if(session('verification_error'))
                <div style="padding: 12px 14px; border-radius: 12px; background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; font-size: 12px; font-weight: 500; display: flex; align-items: flex-start; gap: 8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 16px; height: 16px; flex-shrink: 0; margin-top: 2px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                    <span>{{ session('verification_error') }}</span>
                </div>
                @endif

                <!-- Form Verifikasi Nomor Telepon -->
                <form action="{{ route('pengajuan.perbaikan.verifikasi', $submission->nomor_pengajuan) }}" method="POST" style="display: flex; flex-direction: column; gap: 16px; margin: 0;">
                    @csrf
                    <div>
                        <label for="nomor_telepon" style="display: block; font-size: 11px; font-weight: 800; color: #334155; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px;">
                            Nomor Telepon / WhatsApp Pendaftaran <span style="color: #ef4444;">*</span>
                        </label>
                        <div>
                            <input type="text" name="nomor_telepon" id="nomor_telepon" value="{{ old('nomor_telepon') }}" 
                                placeholder="Contoh: 081234567890" autofocus required
                                style="width: 100%; box-sizing: border-box; padding: 12px 14px; border-radius: 12px; border: 1.5px solid #cbd5e1; font-size: 14px; color: #0f172a; outline: none; transition: border-color 0.2s, box-shadow 0.2s;"
                                onfocus="this.style.borderColor='#16a34a'; this.style.boxShadow='0 0 0 3px rgba(22, 163, 74, 0.15)';"
                                onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none';">
                        </div>
                        <p style="font-size: 11px; color: #64748b; margin: 6px 0 0 0; line-height: 1.4;">
                            Format penulisan bebas (dapat diawali 08, 62, atau memakai spasi/tanda hubung). Sistem akan mencocokkan secara otomatis.
                        </p>
                        @error('nomor_telepon')
                            <p style="font-size: 11px; color: #ef4444; margin: 4px 0 0 0;">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" 
                            style="width: 100%; box-sizing: border-box; display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 13px 20px; border-radius: 12px; font-size: 13px; font-weight: 800; color: #ffffff; background: linear-gradient(135deg, #15803d, #16a34a); border: none; cursor: pointer; box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3); transition: all 0.2s;"
                            onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 16px rgba(22, 163, 74, 0.4)';"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(22, 163, 74, 0.3)';">
                        <span>Verifikasi & Buka Formulir Perbaikan</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width: 15px; height: 15px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>
                </form>

                <div style="text-align: center; padding-top: 14px; border-top: 1px solid #f1f5f9;">
                    <a href="{{ route('cek-status', ['nomor_pengajuan' => $submission->nomor_pengajuan]) }}" 
                       style="font-size: 12px; font-weight: 600; color: #64748b; text-decoration: none; transition: color 0.2s;"
                       onmouseover="this.style.color='#0f172a';"
                       onmouseout="this.style.color='#64748b';">
                        &larr; Kembali ke Halaman Cek Status
                    </a>
                </div>
            </div>
        </div>


        @else
        {{-- ========================================================================= --}}
        {{-- TAHAP 2: FORMULIR EDIT DATA IN-PLACE (SUDAH TERVERIFIKASI TELEPONNYA)     --}}
        {{-- ========================================================================= --}}
        <div class="space-y-8 animate-fadeIn">
            
            <div class="text-center space-y-3 mb-6">
                <div class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-full bg-orange-100 text-orange-800 text-xs font-bold border border-orange-200">
                    <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span>
                    <span>Mode Perbaikan Berkas Pengajuan</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-secondary-900 tracking-tight">Formulir Perbaikan Data UMKM</h1>
                <p class="text-sm text-secondary-500 max-w-xl mx-auto">
                    Nomor Pengajuan: <strong class="font-mono text-primary-700">{{ $submission->nomor_pengajuan }}</strong> (Data akan diperbarui langsung pada nomor pengajuan yang sama).
                </p>
            </div>

            @if(session('verification_success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-800 text-xs font-medium flex items-center space-x-2.5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-emerald-600 shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
                <span>{{ session('verification_success') }}</span>
            </div>
            @endif

            <!-- Catatan Admin Banner Utama -->
            <div class="bg-orange-50 border border-orange-200 text-orange-900 rounded-3xl p-6 sm:p-7 space-y-3 border-l-8 border-l-orange-500 shadow-sm">
                <div class="flex items-center space-x-2.5">
                    <div class="w-8 h-8 rounded-xl bg-orange-500 text-white flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4.5 h-4.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-sm sm:text-base text-orange-950">Catatan Perbaikan dari Tim Verifikator:</h3>
                        <p class="text-[11px] text-orange-700">Mohon teliti instruksi di bawah ini saat memperbarui formulir.</p>
                    </div>
                </div>
                <div class="bg-white/80 backdrop-blur rounded-2xl p-4 border border-orange-200/60 text-xs sm:text-sm leading-relaxed text-orange-950 font-medium">
                    {{ $submission->catatan_admin ?: 'Silakan periksa kembali kelengkapan identitas, NIB, dan dokumentasi usaha Anda.' }}
                </div>
            </div>

            <!-- Formulir Update Data -->
            <form action="{{ route('pengajuan.perbaikan.update', $submission->nomor_pengajuan) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-md space-y-10">
                @csrf
                @method('PUT')

                <!-- 1. Identitas Pemilik -->
                <div class="space-y-6">
                    <div class="border-b border-slate-100 pb-4 flex items-center space-x-3">
                        <span class="w-8 h-8 rounded-lg bg-primary-100 text-primary-700 flex items-center justify-center font-bold text-sm">1</span>
                        <div>
                            <h3 class="text-lg font-bold text-secondary-900">Identitas Pemilik Usaha</h3>
                            <p class="text-xs text-secondary-400">Pastikan data pemilik sesuai dengan KTP</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="nama_pemilik" class="block text-xs font-bold text-secondary-700 uppercase tracking-wider mb-2">Nama Lengkap Pemilik (Sesuai KTP) <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_pemilik" id="nama_pemilik" value="{{ old('nama_pemilik', $submission->nama_pemilik) }}" placeholder="Contoh: Asep Sunandar" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('nama_pemilik') border-red-400 focus:ring-red-400 @enderror">
                            @error('nama_pemilik')
                                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nomor_telepon" class="block text-xs font-bold text-secondary-700 uppercase tracking-wider mb-2">Nomor Telepon / WhatsApp <span class="text-red-500">*</span></label>
                            <input type="text" name="nomor_telepon" id="nomor_telepon" value="{{ old('nomor_telepon', $submission->nomor_telepon) }}" placeholder="Contoh: 081234567890" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('nomor_telepon') border-red-400 focus:ring-red-400 @enderror">
                            @error('nomor_telepon')
                                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- 2. Profil Usaha -->
                <div class="space-y-6">
                    <div class="border-b border-slate-100 pb-4 flex items-center space-x-3">
                        <span class="w-8 h-8 rounded-lg bg-primary-100 text-primary-700 flex items-center justify-center font-bold text-sm">2</span>
                        <div>
                            <h3 class="text-lg font-bold text-secondary-900">Informasi Profil Usaha</h3>
                            <p class="text-xs text-secondary-400">Periksa nama, kategori, NIB, dan deskripsi usaha</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="nama_usaha" class="block text-xs font-bold text-secondary-700 uppercase tracking-wider mb-2">Nama Usaha / Produk <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_usaha" id="nama_usaha" value="{{ old('nama_usaha', $submission->nama_usaha) }}" placeholder="Contoh: Keripik Singkong Cicalengka" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('nama_usaha') border-red-400 focus:ring-red-400 @enderror">
                            @error('nama_usaha')
                                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="jenis_usaha" class="block text-xs font-bold text-secondary-700 uppercase tracking-wider mb-2">Kategori / Jenis Usaha <span class="text-red-500">*</span></label>
                            @php
                                $currentJenis = old('jenis_usaha', $submission->jenis_usaha);
                                $kategoriList = [
                                    'Kuliner (Makanan & Minuman)',
                                    'Kriya & Kerajinan Tangan',
                                    'Fashion & Konveksi',
                                    'Pertanian & Peternakan',
                                    'Jasa & Perdagangan',
                                    'Kecantikan & Kesehatan',
                                    'Lainnya'
                                ];
                            @endphp
                            <select name="jenis_usaha" id="jenis_usaha" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('jenis_usaha') border-red-400 focus:ring-red-400 @enderror">
                                <option value="">-- Pilih Jenis Usaha --</option>
                                @foreach($kategoriList as $kat)
                                    <option value="{{ $kat }}" {{ $currentJenis == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                @endforeach
                            </select>
                            @error('jenis_usaha')
                                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="nib" class="block text-xs font-bold text-secondary-700 uppercase tracking-wider mb-2">Nomor Induk Berusaha (NIB) <span class="text-red-500">*</span></label>
                            <input type="text" name="nib" id="nib" value="{{ old('nib', $submission->nib) }}" placeholder="Contoh: 9120001234567" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('nib') border-red-400 focus:ring-red-400 @enderror">
                            @error('nib')
                                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="sertifikasi_halal" class="block text-xs font-bold text-secondary-700 uppercase tracking-wider mb-2">Nomor Sertifikat Halal <span class="text-secondary-400 font-normal">(Opsional)</span></label>
                            <input type="text" name="sertifikasi_halal" id="sertifikasi_halal" value="{{ old('sertifikasi_halal', $submission->sertifikasi_halal) }}" placeholder="Contoh: ID32110001234567890" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('sertifikasi_halal') border-red-400 focus:ring-red-400 @enderror">
                            @error('sertifikasi_halal')
                                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="deskripsi_usaha" class="block text-xs font-bold text-secondary-700 uppercase tracking-wider mb-2">Deskripsi Usaha <span class="text-red-500">*</span></label>
                        <textarea name="deskripsi_usaha" id="deskripsi_usaha" rows="4" placeholder="Jelaskan produk yang Anda jual, keunggulan usaha, proses pembuatan, atau model pelayanan usaha Anda..." class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('deskripsi_usaha') border-red-400 focus:ring-red-400 @enderror">{{ old('deskripsi_usaha', $submission->deskripsi_usaha) }}</textarea>
                        @error('deskripsi_usaha')
                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- 3. Lokasi Usaha -->
                <div class="space-y-6">
                    <div class="border-b border-slate-100 pb-4 flex items-center space-x-3">
                        <span class="w-8 h-8 rounded-lg bg-primary-100 text-primary-700 flex items-center justify-center font-bold text-sm">3</span>
                        <div>
                            <h3 class="text-lg font-bold text-secondary-900">Lokasi Tempat Usaha</h3>
                            <p class="text-xs text-secondary-400">Wilayah administratif Kecamatan Cicalengka</p>
                        </div>
                    </div>

                    <div>
                        <label for="desa" class="block text-xs font-bold text-secondary-700 uppercase tracking-wider mb-2">Desa Wilayah Kecamatan Cicalengka <span class="text-red-500">*</span></label>
                        <select name="desa" id="desa" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('desa') border-red-400 focus:ring-red-400 @enderror">
                            <option value="">-- Pilih Desa --</option>
                            @php
                                $currentDesa = old('desa', $submission->desa);
                                $desaList = [
                                    'Babakan Peuteuy', 'Cicalengka Kulon', 'Cicalengka Wetan', 
                                    'Cikuya', 'Dampit', 'Margaasih', 'Nagrog', 'Narawita', 
                                    'Panenjoan', 'Tenjolaya', 'Waluya', 'Tanjungwangi'
                                ];
                            @endphp
                            @foreach($desaList as $d)
                                <option value="{{ $d }}" {{ $currentDesa == $d ? 'selected' : '' }}>{{ $d }}</option>
                            @endforeach
                        </select>
                        @error('desa')
                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="alamat_lengkap" class="block text-xs font-bold text-secondary-700 uppercase tracking-wider mb-2">Alamat Usaha Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="alamat_lengkap" id="alamat_lengkap" rows="3" placeholder="Contoh: Jl. Dipatiukur No. 12, RT 02 RW 05" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('alamat_lengkap') border-red-400 focus:ring-red-400 @enderror">{{ old('alamat_lengkap', $submission->alamat_lengkap) }}</textarea>
                        @error('alamat_lengkap')
                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- 4. Dokumentasi Foto Usaha (Opsional saat perbaikan) -->
                <div class="space-y-6">
                    <div class="border-b border-slate-100 pb-4 flex items-center space-x-3">
                        <span class="w-8 h-8 rounded-lg bg-primary-100 text-primary-700 flex items-center justify-center font-bold text-sm">4</span>
                        <div>
                            <h3 class="text-lg font-bold text-secondary-900">Dokumentasi Tempat Usaha / Produk</h3>
                            <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">Opsional saat perbaikan</span>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-amber-50/70 border border-amber-200/80 text-xs text-amber-900 leading-relaxed flex items-start space-x-2.5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-amber-600 shrink-0 mt-0.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                        <div>
                            <strong>Ketentuan Foto Perbaikan:</strong>
                            <p class="mt-0.5">
                                Jika foto lama masih sesuai dan tidak perlu diubah, Anda <strong>tidak perlu mengunggah foto baru</strong> (foto lama tetap digunakan).
                                Jika Anda mengunggah foto baru, file foto lama akan <strong>dihapus secara otomatis</strong> dari server agar penyimpanan tetap bersih.
                            </p>
                        </div>
                    </div>

                    <!-- Tampilan Foto Saat Ini -->
                    @if($submission->foto_usaha)
                    <div class="space-y-2">
                        <span class="block text-xs font-bold text-secondary-700 uppercase tracking-wider">Foto yang Saat Ini Digunakan:</span>
                        <div class="flex items-start space-x-4 p-4 rounded-2xl bg-slate-50 border border-slate-200">
                            <div class="w-36 h-24 rounded-xl overflow-hidden border border-slate-200 shadow-sm shrink-0">
                                <img src="{{ asset($submission->foto_usaha) }}" alt="Foto usaha lama" class="w-full h-full object-cover">
                            </div>
                            <div class="text-xs space-y-1">
                                <p class="font-bold text-secondary-800">Foto Terpasang Saat Ini</p>
                                <p class="text-secondary-500 text-[11px]">Foto ini akan tetap dipakai apabila Anda tidak memilih foto baru di bawah.</p>
                                <a href="{{ asset($submission->foto_usaha) }}" target="_blank" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-semibold pt-1">
                                    <span>Lihat Foto Asli Penuh &rarr;</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Upload Foto Baru -->
                    <div>
                        <label class="block text-xs font-bold text-secondary-700 uppercase tracking-wider mb-2">
                            Unggah Foto Baru <span class="text-secondary-400 font-normal">(Kosongkan jika tidak ingin mengganti)</span>
                        </label>
                        
                        <div id="upload-box" class="mt-2 relative rounded-2xl border-2 border-dashed border-slate-200 hover:border-primary-400 transition-all overflow-hidden bg-slate-50/50">
                            <label for="foto_usaha" class="cursor-pointer block w-full h-full min-h-[180px] flex items-center justify-center p-6 text-center">
                                <input id="foto_usaha" name="foto_usaha" type="file" class="sr-only" onchange="previewImage(this)">

                                <div id="upload-initial" class="space-y-2">
                                    <svg class="mx-auto h-10 w-10 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm justify-center text-secondary-600 font-medium">
                                        <span class="text-primary-600 hover:text-primary-500 font-semibold">Pilih Foto Pengganti Baru</span>
                                        <p class="pl-1">atau seret file ke sini</p>
                                    </div>
                                    <p class="text-xs text-secondary-400">PNG, JPG, JPEG, WEBP maksimal 2MB (Opsional)</p>
                                </div>

                                <div id="upload-preview" class="absolute inset-0 hidden w-full h-full group">
                                    <img id="image-preview" src="#" alt="Pratinjau foto baru" class="w-full h-full object-cover">

                                    <div class="absolute inset-0 bg-slate-950/40 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center">
                                        <span class="text-xs font-bold text-white bg-slate-900/80 px-4 py-2 rounded-xl backdrop-blur-sm border border-white/10 shadow-lg">
                                            Klik gambar untuk memilih foto lain
                                        </span>
                                    </div>
                                </div>
                            </label>

                            <button type="button" id="btn-remove" onclick="removePreview(event)" class="absolute top-3 right-3 z-10 px-3 py-1.5 rounded-full bg-red-600/90 hover:bg-red-700 text-white text-xs font-bold flex items-center space-x-1 shadow-lg transition-colors hidden cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <span>Batal Ganti Foto</span>
                            </button>
                        </div>

                        @error('foto_usaha')
                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Aksi Form -->
                <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <a href="{{ route('cek-status', ['nomor_pengajuan' => $submission->nomor_pengajuan]) }}" class="w-full sm:w-auto text-center px-6 py-3.5 rounded-xl text-sm font-semibold text-secondary-600 hover:bg-slate-100 transition-colors">
                        &larr; Batalkan & Kembali ke Cek Status
                    </a>
                    
                    <button type="submit" 
                            style="background: linear-gradient(135deg, #15803d, #16a34a); color: #ffffff;"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 rounded-xl text-sm font-bold shadow-md shadow-primary-100 hover:shadow-lg transition-all cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                        <span>Simpan Perbaikan & Ajukan Ulang</span>
                    </button>
                </div>
            </form>
        </div>
        @endif

    </div>
</section>

<script>
    function previewImage(input) {
        const uploadInitial = document.getElementById('upload-initial');
        const uploadPreview = document.getElementById('upload-preview');
        const previewImg = document.getElementById('image-preview');
        const btnRemove = document.getElementById('btn-remove');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                uploadInitial.classList.add('hidden');
                uploadPreview.classList.remove('hidden');
                btnRemove.classList.remove('hidden');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    function removePreview(event) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }
        
        const fileInput = document.getElementById('foto_usaha');
        const uploadInitial = document.getElementById('upload-initial');
        const uploadPreview = document.getElementById('upload-preview');
        const previewImg = document.getElementById('image-preview');
        const btnRemove = document.getElementById('btn-remove');
        
        if (fileInput) fileInput.value = '';
        if (previewImg) previewImg.src = '#';
        if (uploadInitial) uploadInitial.classList.remove('hidden');
        if (uploadPreview) uploadPreview.classList.add('hidden');
        if (btnRemove) btnRemove.classList.add('hidden');
    }
</script>
@endsection
