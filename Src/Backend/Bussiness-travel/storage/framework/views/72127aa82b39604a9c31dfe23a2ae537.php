<?php $__env->startSection('title'); ?>
    <?php echo e(__('Karyawan')); ?> | <?php echo e(config('app.name')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('admin-content'); ?>

<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
    <div x-data="{ pageName: '<?php echo e(__('Karyawan')); ?>' }">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                <?php echo e(__('Karyawan')); ?>

            </h2>
            <nav>
                <ol class="flex items-center gap-1.5">
                    <li>
                        <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
                           href="<?php echo e(route('admin.dashboard')); ?>">
                            <?php echo e(__('Home')); ?> <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                    <li class="text-sm text-gray-800 dark:text-white/90">
                        <?php echo e(__('Karyawan')); ?>

                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="space-y-6">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-5 py-4 sm:px-6 sm:py-5 flex justify-between items-center">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90"><?php echo e(__('Daftar Karyawan')); ?></h3>
                <?php echo $__env->make('backend.partials.search-form', [
                    'placeholder' => __('Search by name or email'),
                ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('karyawan.create')): ?>
                    <a href="<?php echo e(route('admin.karyawans.create')); ?>" class="btn-primary">
                        <i class="bi bi-plus-circle mr-2"></i> <?php echo e(__('New Karyawan')); ?>

                    </a>
                <?php endif; ?>
            </div>

            <div class="space-y-3 border-t border-gray-100 dark:border-gray-800 overflow-x-auto">
                <?php echo $__env->make('backend.layouts.partials.messages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                <table class="w-full dark:text-gray-400">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <th class="p-2 text-left px-5"><?php echo e(__('Sl')); ?></th>
                            <th class="p-2 text-left px-5"><?php echo e(__('Nama Lengkap')); ?></th>
                            <th class="p-2 text-left px-5"><?php echo e(__('Email')); ?></th>
                            <th class="p-2 text-left px-5"><?php echo e(__('Username')); ?></th>
                            <th class="p-2 text-left px-5"><?php echo e(__('Telepon')); ?></th>
                            <th class="p-2 text-left px-5"><?php echo e(__('Foto')); ?></th>
                            <th class="p-2 text-left px-5"><?php echo e(__('Alamat')); ?></th>
                            <th class="p-2 text-left px-5"><?php echo e(__('Jabatan')); ?></th>
                            <th class="p-2 text-left px-5"><?php echo e(__('Action')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $karyawans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="<?php echo e(!$loop->last ? 'border-b border-gray-100 dark:border-gray-800' : ''); ?>">
                                <td class="px-5 py-4"><?php echo e($loop->iteration); ?></td>
                                <td class="px-5 py-4"><?php echo e($item->nama_lengkap); ?></td>
                                <td class="px-5 py-4"><?php echo e($item->user->email); ?></td>
                                <td class="px-5 py-4"><?php echo e($item->user->username); ?></td>
                                <td class="px-5 py-4"><?php echo e($item->no_hp ?? '-'); ?></td>
                                <td class="px-5 py-4">
                                    <?php if($item->foto): ?>
                                        <img src="<?php echo e(Storage::url($item->foto)); ?>" class="w-10 h-10 rounded" alt="">
                                    <?php else: ?>
                                        —
                                    <?php endif; ?>
                                </td>
                                <td class="px-5 py-4"><?php echo e($item->alamat ?? '-'); ?></td>
                                <td class="px-5 py-4"><?php echo e($item->jabatan ?? '-'); ?></td>
                                <td class="flex items-center px-5 py-4 gap-2">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('karyawan.edit')): ?>
                                        <a href="<?php echo e(route('admin.karyawans.edit', $item)); ?>" class="btn-default !p-2" title="<?php echo e(__('Edit')); ?>">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('karyawan.delete')): ?>
                                        <a data-modal-target="delete-modal-<?php echo e($item->id); ?>" data-modal-toggle="delete-modal-<?php echo e($item->id); ?>" class="btn-danger !p-2 cursor-pointer" title="<?php echo e(__('Delete')); ?>">
                                            <i class="bi bi-trash"></i>
                                        </a>

                                        <!-- Delete Modal -->
                                        <div id="delete-modal-<?php echo e($item->id); ?>" tabindex="-1" class="hidden fixed inset-0 z-50 flex items-center justify-center">
                                            <div class="relative p-4 w-full max-w-md bg-white rounded-lg shadow-lg dark:bg-gray-700 z-60">
                                                <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="delete-modal-<?php echo e($item->id); ?>">
                                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                    </svg>
                                                    <span class="sr-only"><?php echo e(__('Close modal')); ?></span>
                                                </button>
                                                <div class="p-4 md:p-5 text-center">
                                                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                    </svg>
                                                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400"><?php echo e(__('Are you sure you want to delete this karyawan?')); ?></h3>
                                                    <form id="delete-form-<?php echo e($item->id); ?>" action="<?php echo e(route('admin.karyawans.destroy', $item)); ?>" method="POST">
                                                        <?php echo method_field('DELETE'); ?>
                                                        <?php echo csrf_field(); ?>

                                                        <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                            <?php echo e(__('Yes, Confirm')); ?>

                                                        </button>
                                                        <button data-modal-hide="delete-modal-<?php echo e($item->id); ?>" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"><?php echo e(__('No, cancel')); ?></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <p class="text-gray-500 dark:text-gray-400"><?php echo e(__('No karyawan found.')); ?></p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <?php if(method_exists($karyawans, 'links')): ?>
                    <div class="my-4 px-4 sm:px-6">
                        <?php echo e($karyawans->links()); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Project\LaraDashboard\resources\views/backend/pages/karyawans/index.blade.php ENDPATH**/ ?>