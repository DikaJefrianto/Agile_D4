<?php $__env->startSection('title'); ?>
    <?php echo e(__('Karyawan Create')); ?> - <?php echo e(config('app.name')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('admin-content'); ?>
<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
    <div x-data="{ pageName: '<?php echo e(__('New Karyawan')); ?>' }">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90"><?php echo e(__('New Karyawan')); ?></h2>
            <nav>
                <ol class="flex items-center gap-1.5">
                    <li>
                        <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="<?php echo e(route('admin.dashboard')); ?>">
                            <?php echo e(__('Home')); ?><i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                    <li>
                        <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="<?php echo e(route('admin.karyawans.index')); ?>">
                            <?php echo e(__('Karyawans')); ?><i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                    <li class="text-sm text-gray-800 dark:text-white/90"><?php echo e(__('New Karyawan')); ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="space-y-6">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-5 py-4 sm:px-6 sm:py-5">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90"><?php echo e(__('Create New Karyawan')); ?></h3>
            </div>
            <div class="p-5 space-y-6 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                <?php echo $__env->make('backend.layouts.partials.messages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                <form action="<?php echo e(route('admin.karyawans.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        
                        <div>
                            <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 dark:text-gray-400"><?php echo e(__('Nama Lengkap')); ?></label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" value="<?php echo e(old('nama_lengkap')); ?>" required autofocus
                                placeholder="<?php echo e(__('Enter Full Name')); ?>"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800
                                       h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm
                                       text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden
                                       dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-400"><?php echo e(__('Email')); ?></label>
                            <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>" required
                                placeholder="<?php echo e(__('Enter Email')); ?>"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800
                                       h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm
                                       text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden
                                       dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-400"><?php echo e(__('Password')); ?></label>
                            <input type="password" name="password" id="password" required placeholder="<?php echo e(__('Enter Password')); ?>" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-400"><?php echo e(__('Confirm Password')); ?></label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="<?php echo e(__('Confirm Password')); ?>" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                        </div>
                        
                        <div>
                            <label for="no_hp" class="block text-sm font-medium text-gray-700 dark:text-gray-400"><?php echo e(__('No HP')); ?></label>
                            <input type="text" name="no_hp" id="no_hp" value="<?php echo e(old('no_hp')); ?>" required
                                placeholder="<?php echo e(__('Enter Phone Number')); ?>"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800
                                       h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm
                                       text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden
                                       dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                        </div>
                        
                        <div>
                            <label for="alamat" class="block text-sm font-medium text-gray-700 dark:text-gray-400"><?php echo e(__('Alamat')); ?></label>
                            <input type="text" name="alamat" id="alamat" value="<?php echo e(old('alamat')); ?>" required
                                placeholder="<?php echo e(__('Enter Address')); ?>"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800
                                       h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm
                                       text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden
                                       dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                        </div>
                        
                        <div>
                            <label for="foto" class="block text-sm font-medium text-gray-700 dark:text-gray-400"><?php echo e(__('Foto (opsional)')); ?></label>
                            <input type="file" name="foto" id="foto"
                                class="mt-1 block w-full text-gray-700 dark:text-gray-300">
                        </div>
                        
                        <div>
                            <label for="jabatan" class="block text-sm font-medium text-gray-700 dark:text-gray-400"><?php echo e(__('Jabatan (opsional)')); ?></label>
                            <input type="text" name="jabatan" id="jabatan" value="<?php echo e(old('jabatan')); ?>"
                                placeholder="<?php echo e(__('Enter Position')); ?>"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800
                                       h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm
                                       text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden
                                       dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                        </div>
                        

                        
                        <div>
                            <label for="perusahaan_id" class="block text-sm font-medium text-gray-700 dark:text-gray-400"><?php echo e(__('Pilih Perusahaan')); ?></label>
                            <select name="perusahaan_id" id="perusahaan_id" required
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800
                                       h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm
                                       text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden
                                       dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                <option value=""><?php echo e(__('Select Perusahaan')); ?></option>
                                <?php $__currentLoopData = $perusahaans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perusahaan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($perusahaan->id); ?>" <?php echo e(old('perusahaan_id') == $perusahaan->id ? 'selected' : ''); ?>>
                                        <?php echo e($perusahaan->nama); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    
                    <div class="mt-6 flex justify-start gap-4">
                        <button type="submit" class="btn-primary"><?php echo e(__('Save')); ?></button>
                        <a href="<?php echo e(route('admin.karyawans.index')); ?>" class="btn-default"><?php echo e(__('Cancel')); ?></a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Project\LaraDashboard\resources\views/backend/pages/karyawans/create.blade.php ENDPATH**/ ?>