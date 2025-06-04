<?php $__env->startSection('title'); ?>
    <?php echo e(__('Perusahaans')); ?> | <?php echo e(config('app.name')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('admin-content'); ?>
<div class="p-4 mx-auto max-w-7xl md:p-6">
    <div x-data="{ pageName: '<?php echo e(__('Edit Perusahaan')); ?>' }">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90"><?php echo e(__('Edit Perusahaan')); ?></h2>
            <a href="<?php echo e(route('admin.perusahaans.index')); ?>" class="btn-primary inline-flex items-center gap-2">
                <i class="bi bi-arrow-left"></i> <?php echo e(__('Kembali')); ?>

            </a>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 p-6">
        <?php echo $__env->make('backend.layouts.partials.messages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <form action="<?php echo e(route('admin.perusahaans.update', $perusahaan)); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-400"><?php echo e(__('Nama')); ?></label>
                    <input type="text" name="nama" id="nama" value="<?php echo e(old('nama', $perusahaan->nama)); ?>" required maxlength="255" placeholder="<?php echo e(__('Masukkan Nama Perusahaan')); ?>"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30" />
                    <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-400"><?php echo e(__('Username')); ?></label>
                    <input type="text" name="username" id="username" value="<?php echo e(old('username', $perusahaan->user->username ?? '')); ?>" required maxlength="255" placeholder="<?php echo e(__('Masukkan Username')); ?>"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30" />
                    <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-400"><?php echo e(__('Email')); ?></label>
                    <input type="email" name="email" id="email" value="<?php echo e(old('email', $perusahaan->email)); ?>" required maxlength="255" placeholder="<?php echo e(__('Masukkan Email')); ?>"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30" />
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-400"><?php echo e(__('Password Baru (opsional)')); ?></label>
                    <input type="password" name="password" id="password" minlength="8" placeholder="<?php echo e(__('Masukkan Password Baru')); ?>"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30" />
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-400"><?php echo e(__('Konfirmasi Password')); ?></label>
                    <input type="password" name="password_confirmation" id="password_confirmation" minlength="8" placeholder="<?php echo e(__('Konfirmasi Password Baru')); ?>"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30" />
                </div>

                <div class="sm:col-span-2">
                    <label for="alamat" class="block text-sm font-medium text-gray-700 dark:text-gray-400"><?php echo e(__('Alamat')); ?></label>
                    <input type="text" name="alamat" id="alamat" value="<?php echo e(old('alamat', $perusahaan->alamat)); ?>" required maxlength="255" placeholder="<?php echo e(__('Masukkan Alamat')); ?>"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30" />
                    <?php $__errorArgs = ['alamat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="sm:col-span-2">
                    <label for="keterangan" class="block text-sm font-medium text-gray-700 dark:text-gray-400"><?php echo e(__('Keterangan')); ?></label>
                    <input type="text" name="keterangan" id="keterangan" value="<?php echo e(old('keterangan', $perusahaan->keterangan)); ?>" required maxlength="255" placeholder="<?php echo e(__('Masukkan Keterangan')); ?>"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30" />
                    <?php $__errorArgs = ['keterangan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
            </div>

            <div class="mt-6 flex justify-start gap-4">
                <button type="submit" class="btn-primary"><?php echo e(__('Simpan')); ?></button>
                <a href="<?php echo e(route('admin.perusahaans.index')); ?>" class="btn-default"><?php echo e(__('Batal')); ?></a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Project\LaraDashboard\resources\views/backend/pages/perusahaans/edit.blade.php ENDPATH**/ ?>