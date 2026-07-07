<?php $__env->startSection('title', 'Kelola Pengajuan UMKM'); ?>

<?php $__env->startSection('admin_content'); ?>
<div class="space-y-6 animate-fadeIn">
    
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-secondary-900 tracking-tight">Daftar Pengajuan Pendataan</h1>
            <p class="text-xs text-secondary-500 font-semibold mt-1">Gunakan fitur di bawah untuk mencari atau memfilter data pengajuan UMKM masuk.</p>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <form action="<?php echo e(route('admin.pengajuan')); ?>" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-4">
            <!-- Search field -->
            <div class="sm:col-span-6">
                <label for="search" class="block text-[10px] font-bold text-secondary-400 uppercase tracking-widest mb-1.5">Pencarian Data</label>
                <div class="relative">
                    <input type="text" name="search" id="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nama usaha, pemilik, atau no. pengajuan..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm transition-all">
                    <span class="absolute left-3 top-3 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.608 10.608Z" />
                        </svg>
                    </span>
                </div>
            </div>

            <!-- Status filter -->
            <div class="sm:col-span-4">
                <label for="status" class="block text-[10px] font-bold text-secondary-400 uppercase tracking-widest mb-1.5">Filter Status</label>
                <select name="status" id="status" onchange="this.form.submit()" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm transition-all">
                    <option value="">Semua Status</option>
                    <option value="Menunggu Verifikasi" <?php echo e(request('status') == 'Menunggu Verifikasi' ? 'selected' : ''); ?>>Menunggu Verifikasi</option>
                    <option value="Perlu Perbaikan" <?php echo e(request('status') == 'Perlu Perbaikan' ? 'selected' : ''); ?>>Perlu Perbaikan</option>
                    <option value="Disetujui" <?php echo e(request('status') == 'Disetujui' ? 'selected' : ''); ?>>Disetujui</option>
                    <option value="Ditolak" <?php echo e(request('status') == 'Ditolak' ? 'selected' : ''); ?>>Ditolak</option>
                </select>
            </div>

            <!-- Action buttons -->
            <div class="sm:col-span-2 flex items-end">
                <button type="submit" class="w-full py-2.5 rounded-xl text-sm font-bold text-white bg-primary-600 hover:bg-primary-700 transition-colors shadow-md shadow-primary-50">
                    Terapkan
                </button>
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
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
                        <th class="py-4 px-6">Kategori</th>
                        <th class="py-4 px-6">Pemilik</th>
                        <th class="py-4 px-6">Desa</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    <?php $__empty_1 = true; $__currentLoopData = $submissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-4.5 px-6 text-secondary-500 font-medium"><?php echo e($sub->created_at->format('d/m/Y H:i')); ?></td>
                            <td class="py-4.5 px-6 font-mono font-bold text-secondary-900"><?php echo e($sub->nomor_pengajuan); ?></td>
                            <td class="py-4.5 px-6">
                                <div class="w-12 h-12 rounded-xl overflow-hidden border border-slate-100 shadow-sm bg-slate-50 shrink-0">
                                    <img src="<?php echo e(asset($sub->foto_usaha)); ?>" class="w-full h-full object-cover" alt="Foto Usaha">
                                </div>
                            </td>
                            <td class="py-4.5 px-6 font-semibold text-secondary-800"><?php echo e($sub->nama_usaha); ?></td>
                            <td class="py-4.5 px-6 font-mono text-secondary-600 text-xs"><?php echo e($sub->nib ?? '-'); ?></td>
                            <td class="py-4.5 px-6 font-mono text-secondary-600 text-xs"><?php echo e($sub->sertifikasi_halal ?? '-'); ?></td>
                            <td class="py-4.5 px-6 text-secondary-500"><?php echo e($sub->jenis_usaha); ?></td>
                            <td class="py-4.5 px-6 text-secondary-600"><?php echo e($sub->nama_pemilik); ?></td>
                            <td class="py-4.5 px-6 text-secondary-600"><?php echo e($sub->desa); ?></td>
                            <td class="py-4.5 px-6">
                                <?php if($sub->status === 'Menunggu Verifikasi'): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-100">
                                        Menunggu
                                    </span>
                                <?php elseif($sub->status === 'Perlu Perbaikan'): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-orange-50 text-orange-700 border border-orange-100">
                                        Perbaikan
                                    </span>
                                <?php elseif($sub->status === 'Disetujui'): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-green-50 text-green-700 border border-green-100">
                                        Disetujui
                                    </span>
                                <?php elseif($sub->status === 'Ditolak'): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-100">
                                        Ditolak
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="py-4.5 px-6 text-right">
                                <a href="<?php echo e(route('admin.pengajuan.detail', $sub->id)); ?>" class="inline-flex items-center justify-center px-3.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-secondary-700 font-bold rounded-lg text-xs transition-colors">
                                    Detail / Verifikasi
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="11" class="py-12 px-6 text-center text-xs text-secondary-400 font-medium">
                                Tidak ada data pengajuan UMKM yang cocok dengan filter pencarian.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination Links -->
        <?php if($submissions->hasPages()): ?>
            <div class="px-6 py-4 border-t border-slate-100">
                <?php echo e($submissions->links()); ?>

            </div>
        <?php endif; ?>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADVAN\Downloads\sipanda\resources\views/admin/pengajuan.blade.php ENDPATH**/ ?>