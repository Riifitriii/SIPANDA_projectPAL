<?php $__env->startSection('title', 'Cek Status Pengajuan UMKM - SIPANDA Cicalengka'); ?>

<?php $__env->startSection('content'); ?>
<section class="py-16 bg-slate-50 min-h-[70vh] flex items-center">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        
        <!-- Header Page -->
        <div class="text-center space-y-3 mb-10">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-secondary-900 tracking-tight">Cek Status Pengajuan Pendataan</h1>
            <p class="text-sm text-secondary-500 max-w-md mx-auto">
                Masukkan nomor pengajuan unik Anda (format: <code class="font-mono text-primary-600 bg-primary-50 px-1.5 py-0.5 rounded">SPD-YYYYMMDD-XXXX</code>) untuk memantau status validasi admin.
            </p>
        </div>

        <!-- Search Card -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-md mb-8">
            <form action="<?php echo e(route('cek-status')); ?>" method="GET" class="space-y-4">
                <div>
                    <label for="nomor_pengajuan" class="block text-xs font-bold text-secondary-700 uppercase tracking-wider mb-2">Nomor Pengajuan Pendataan</label>
                    <div class="relative flex rounded-xl shadow-sm">
                        <input type="text" name="nomor_pengajuan" id="nomor_pengajuan" value="<?php echo e(old('nomor_pengajuan', request('nomor_pengajuan', session('result') ? session('result')->nomor_pengajuan : ''))); ?>" placeholder="Contoh: SPD-20260703-0001" class="w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all <?php $__errorArgs = ['nomor_pengajuan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 focus:ring-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <button type="submit" class="absolute right-1.5 top-1.5 bottom-1.5 px-6 rounded-lg text-sm font-bold text-white bg-gradient-to-r from-primary-600 to-emerald-500 hover:from-primary-700 hover:to-emerald-600 transition-colors">
                            Cari
                        </button>
                    </div>
                    <?php $__errorArgs = ['nomor_pengajuan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-xs text-red-500 mt-1.5"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </form>

            <?php if(session('error') || (isset($error) && $error)): ?>
                <div class="mt-4 p-4 rounded-2xl bg-red-50 border border-red-100 text-red-700 text-xs font-medium flex items-start space-x-2.5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 shrink-0 mt-0.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                    <span><?php echo e(session('error') ?? $error); ?></span>
                </div>
            <?php endif; ?>
        </div>

        <?php if(session('result') || (isset($submission) && $submission)): ?>
            <?php
                $sub = session('result') ?? $submission;
            ?>
            <!-- Search Result Details -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-lg p-6 sm:p-8 space-y-6 animate-fadeIn">
                <div class="border-b border-slate-100 pb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <span class="text-xs text-secondary-400 font-semibold block">HASIL PENCARIAN PENGAJUAN</span>
                        <h3 class="text-xl font-bold text-secondary-900 tracking-tight"><?php echo e($sub->nama_usaha); ?></h3>
                    </div>
                    
                    <!-- Dynamic Badges -->
                    <div>
                        <?php if($sub->status === 'Menunggu Verifikasi'): ?>
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5"></span>
                                Menunggu Verifikasi
                            </span>
                        <?php elseif($sub->status === 'Perlu Perbaikan'): ?>
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-orange-50 text-orange-700 border border-orange-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-orange-500 mr-1.5"></span>
                                Perlu Perbaikan
                            </span>
                        <?php elseif($sub->status === 'Disetujui'): ?>
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-green-50 text-green-700 border border-green-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5"></span>
                                Disetujui (Terdata)
                            </span>
                        <?php elseif($sub->status === 'Ditolak'): ?>
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></span>
                                Ditolak
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Admin Action Notification / Alert Card -->
                <?php if($sub->status === 'Perlu Perbaikan'): ?>
                    <div class="bg-orange-50 border border-orange-200 text-orange-900 rounded-2xl p-5 space-y-2 border-l-4 border-l-orange-500">
                        <div class="flex items-center space-x-2">
                            <!-- Warning Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-orange-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                            <span class="font-bold text-sm">Catatan Perbaikan dari Admin:</span>
                        </div>
                        <p class="text-xs leading-relaxed text-orange-800">
                            <?php echo e($sub->catatan_admin ?? 'Mohon segera hubungi kantor Kecamatan Cicalengka atau periksa kembali isian form Anda.'); ?>

                        </p>
                    </div>
                <?php elseif($sub->status === 'Ditolak'): ?>
                    <div class="bg-red-50 border border-red-200 text-red-900 rounded-2xl p-5 space-y-2 border-l-4 border-l-red-500">
                        <div class="flex items-center space-x-2">
                            <!-- Shield X / Error Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-red-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="font-bold text-sm">Alasan Penolakan Pengajuan:</span>
                        </div>
                        <p class="text-xs leading-relaxed text-red-800">
                            <?php echo e($sub->catatan_admin ?? 'Pengajuan tidak disetujui karena berkas atau informasi tidak valid/sesuai syarat.'); ?>

                        </p>
                    </div>
                <?php elseif($sub->status === 'Disetujui'): ?>
                    <div class="bg-green-50 border border-green-200 text-green-900 rounded-2xl p-5 space-y-1.5 border-l-4 border-l-green-500">
                        <div class="flex items-center space-x-2">
                            <!-- Success Check Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 text-green-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 01 1.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12Z" />
                            </svg>
                            <span class="font-bold text-sm">Selamat! UMKM Anda Telah Terdata Resmi</span>
                        </div>
                        <p class="text-xs leading-relaxed text-green-800">
                            Usaha Anda kini terdaftar secara sah dalam database UMKM Kecamatan Cicalengka dan memenuhi syarat program pemberdayaan masyarakat.
                        </p>
                    </div>
                <?php endif; ?>

                <!-- Informational fields -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
                    <div>
                        <span class="text-xs text-secondary-400 font-semibold block">Nomor Pengajuan:</span>
                        <p class="font-mono text-secondary-800 font-semibold mt-0.5"><?php echo e($sub->nomor_pengajuan); ?></p>
                    </div>
                    <div>
                        <span class="text-xs text-secondary-400 font-semibold block">Tanggal Pengajuan:</span>
                        <p class="text-secondary-800 font-semibold mt-0.5"><?php echo e($sub->created_at->locale('id')->translatedFormat('d F Y, H:i')); ?> WIB</p>
                    </div>
                    <div>
                        <span class="text-xs text-secondary-400 font-semibold block">Nama Pemilik:</span>
                        <p class="text-secondary-800 font-semibold mt-0.5"><?php echo e($sub->nama_pemilik); ?></p>
                    </div>
                    <div>
                        <span class="text-xs text-secondary-400 font-semibold block">Nomor Telepon/WA:</span>
                        <p class="text-secondary-800 font-semibold mt-0.5"><?php echo e($sub->nomor_telepon); ?></p>
                    </div>
                    <div>
                        <span class="text-xs text-secondary-400 font-semibold block">Kategori Usaha:</span>
                        <p class="text-secondary-800 font-semibold mt-0.5"><?php echo e($sub->jenis_usaha); ?></p>
                    </div>
                    <div>
                        <span class="text-xs text-secondary-400 font-semibold block">Desa & Alamat:</span>
                        <p class="text-secondary-800 font-semibold mt-0.5"><?php echo e($sub->desa); ?>, <?php echo e($sub->alamat_lengkap); ?></p>
                    </div>
                    <div>
                        <span class="text-xs text-secondary-400 font-semibold block">Nomor Induk Berusaha (NIB):</span>
                        <p class="font-mono text-secondary-800 font-semibold mt-0.5"><?php echo e($sub->nib ?? '-'); ?></p>
                    </div>
                    <div>
                        <span class="text-xs text-secondary-400 font-semibold block">Nomor Sertifikat Halal:</span>
                        <p class="font-mono text-secondary-800 font-semibold mt-0.5"><?php echo e($sub->sertifikasi_halal ?? '-'); ?></p>
                    </div>
                </div>

                <?php if($sub->foto_usaha): ?>
                <div>
                    <span class="text-xs text-secondary-400 font-semibold block mb-2">Dokumentasi Terunggah:</span>
                    <div class="w-48 h-32 rounded-2xl overflow-hidden border border-slate-100">
                        <img src="<?php echo e(asset($sub->foto_usaha)); ?>" alt="Foto usaha terdata" class="w-full h-full object-cover">
                    </div>
                </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADVAN\Downloads\sipanda\resources\views/cek-status.blade.php ENDPATH**/ ?>