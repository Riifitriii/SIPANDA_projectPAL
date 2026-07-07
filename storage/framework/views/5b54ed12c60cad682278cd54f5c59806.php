<?php $__env->startSection('title', 'UMKM Terdaftar'); ?>

<?php $__env->startSection('admin_content'); ?>
<div class="space-y-6 animate-fadeIn">
    
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-secondary-900 tracking-tight">Data UMKM Terdaftar Resmi</h1>
            <p class="text-xs text-secondary-500 font-semibold mt-1">Daftar pelaku usaha Kecamatan Cicalengka yang telah lolos verifikasi administrasi.</p>
        </div>
        
        <div>
            <a href="<?php echo e(route('admin.laporan', ['desa' => request('desa')])); ?>" target="_blank" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-secondary-900 hover:bg-secondary-800 transition-colors shadow-md shadow-slate-100">
                <!-- Print Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0a2.25 2.25 0 0 1-2.23 2.14H8.57a2.25 2.25 0 0 1-2.23-2.14m11.32 0L17.5 13.5m-11.32 0L6.5 13.5m11 0h.008v.008h-.008V13.5Zm-11 0h.008v.008h-.008V13.5ZM6.5 9h11m-11 0a2.25 2.25 0 0 1 2.25-2.25h6.5A2.25 2.25 0 0 1 18 9m-11.5 0V7.5A2.25 2.25 0 0 1 8.75 5.25h6.5A2.25 2.25 0 0 1 17.5 7.5V9" />
                </svg>
                Cetak Laporan
            </a>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <form action="<?php echo e(route('admin.umkm')); ?>" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-4">
            <!-- Search field -->
            <div class="sm:col-span-6">
                <label for="search" class="block text-[10px] font-bold text-secondary-400 uppercase tracking-widest mb-1.5">Pencarian UMKM</label>
                <div class="relative">
                    <input type="text" name="search" id="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nama usaha, pemilik, kategori, no. pengajuan..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm transition-all">
                    <span class="absolute left-3 top-3 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.608 10.608Z" />
                        </svg>
                    </span>
                </div>
            </div>

            <!-- Desa filter -->
            <div class="sm:col-span-4">
                <label for="desa" class="block text-[10px] font-bold text-secondary-400 uppercase tracking-widest mb-1.5">Filter Desa Wilayah</label>
                <select name="desa" id="desa" onchange="this.form.submit()" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm transition-all">
                    <option value="">Semua Desa</option>
                    <?php
                        $desaList = [
                            'Babakan Peuteuy', 'Cicalengka Kulon', 'Cicalengka Wetan', 
                            'Cikuya', 'Dampit', 'Margaasih', 'Nagrog', 'Narawita', 
                            'Panenjoan', 'Tenjolaya', 'Waluya', 'Tanjungwangi'
                        ];
                    ?>
                    <?php $__currentLoopData = $desaList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($d); ?>" <?php echo e(request('desa') == $d ? 'selected' : ''); ?>><?php echo e($d); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                        <th class="py-4 px-6">No. Pengajuan</th>
                        <th class="py-4 px-6">Foto</th>
                        <th class="py-4 px-6">Nama Usaha</th>
                        <th class="py-4 px-6">NIB</th>
                        <th class="py-4 px-6">Sertifikat Halal</th>
                        <th class="py-4 px-6">Kategori</th>
                        <th class="py-4 px-6">Pemilik</th>
                        <th class="py-4 px-6">Kontak</th>
                        <th class="py-4 px-6">Desa</th>
                        <th class="py-4 px-6">Alamat Usaha</th>
                        <th class="py-4 px-6">Tanggal Terbit</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    <?php $__empty_1 = true; $__currentLoopData = $umkms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-4.5 px-6 font-mono font-bold text-secondary-900"><?php echo e($u->nomor_pengajuan); ?></td>
                            <td class="py-4.5 px-6">
                                <div class="w-12 h-12 rounded-xl overflow-hidden border border-slate-100 shadow-sm bg-slate-50 shrink-0">
                                    <img src="<?php echo e(asset($u->foto_usaha)); ?>" class="w-full h-full object-cover" alt="Foto Usaha">
                                </div>
                            </td>
                            <td class="py-4.5 px-6 font-semibold text-secondary-800"><?php echo e($u->nama_usaha); ?></td>
                            <td class="py-4.5 px-6 font-mono text-secondary-600 text-xs"><?php echo e($u->nib ?? '-'); ?></td>
                            <td class="py-4.5 px-6 font-mono text-secondary-600 text-xs"><?php echo e($u->sertifikasi_halal ?? '-'); ?></td>
                            <td class="py-4.5 px-6 text-secondary-500"><?php echo e($u->jenis_usaha); ?></td>
                            <td class="py-4.5 px-6 text-secondary-600 font-medium"><?php echo e($u->nama_pemilik); ?></td>
                            <td class="py-4.5 px-6 text-primary-700 font-bold">
                                <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $u->nomor_telepon)); ?>" target="_blank" class="hover:underline flex items-center space-x-1">
                                    <span><?php echo e($u->nomor_telepon); ?></span>
                                </a>
                            </td>
                            <td class="py-4.5 px-6 text-secondary-600"><?php echo e($u->desa); ?></td>
                            <td class="py-4.5 px-6 text-secondary-500 max-w-xs truncate" title="<?php echo e($u->alamat_lengkap); ?>"><?php echo e($u->alamat_lengkap); ?></td>
                            <td class="py-4.5 px-6 text-secondary-400"><?php echo e($u->created_at->format('d/m/Y')); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="11" class="py-12 px-6 text-center text-xs text-secondary-400 font-medium">
                                Tidak ada data UMKM terdaftar yang cocok dengan filter pencarian.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination Links -->
        <?php if($umkms->hasPages()): ?>
            <div class="px-6 py-4 border-t border-slate-100">
                <?php echo e($umkms->links()); ?>

            </div>
        <?php endif; ?>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADVAN\Downloads\sipanda\resources\views/admin/umkm.blade.php ENDPATH**/ ?>