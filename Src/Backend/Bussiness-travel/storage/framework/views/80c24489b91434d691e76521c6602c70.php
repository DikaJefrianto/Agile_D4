<?php $__env->startSection('title'); ?>
    <?php echo e(__('Perusahaan')); ?> | <?php echo e(config('app.name')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('admin-content'); ?>
<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
            <?php echo e(__('Perusahaan')); ?>

        </h2>
        <nav>
            <ol class="flex items-center gap-1.5">
                <li>
                    <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="<?php echo e(route('admin.dashboard')); ?>">
                        <?php echo e(__('Home')); ?>

                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
                <li class="text-sm text-gray-800 dark:text-white/90"><?php echo e(__('Perusahaan')); ?></li>
            </ol>
        </nav>
    </div>

    <div class="space-y-6">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-5 py-4 sm:px-6 sm:py-5 flex justify-between items-center">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90"><?php echo e(__('Perusahaan')); ?></h3>

                <?php echo $__env->make('backend.partials.search-form', [
                    'placeholder' => __('Search by name or email'),
                ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php if(auth()->user()->can('perusahaan.create')): ?>
                    <a href="<?php echo e(route('admin.perusahaans.create')); ?>" class="btn-primary">
                        <i class="bi bi-plus-circle mr-2"></i>
                        <?php echo e(__('Tambah Perusahaan')); ?>

                    </a>
                <?php endif; ?>
            </div>

            <div class="space-y-3 border-t border-gray-100 dark:border-gray-800 overflow-x-auto">
                <table class="w-full dark:text-gray-400">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <th class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5"><?php echo e(__('Nama')); ?></th>
                            <th class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5"><?php echo e(__('Email')); ?></th>
                            <th class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5"><?php echo e(__('Alamat')); ?></th>
                            <th class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5"><?php echo e(__('Keterangan')); ?></th>
                            <th class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5"><?php echo e(__('Aksi')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $perusahaans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perusahaan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <td class="px-5 py-4 sm:px-6"><?php echo e($perusahaan->nama); ?></td>
                            <td class="px-5 py-4 sm:px-6"><?php echo e($perusahaan->email); ?></td>
                            <td class="px-5 py-4 sm:px-6"><?php echo e($perusahaan->alamat); ?></td>
                            <td class="px-5 py-4 sm:px-6"><?php echo e($perusahaan->keterangan); ?></td>
                            <td class="flex px-5 py-4 sm:px-6 text-center gap-1">
                                <a class="btn-default !p-3" href="<?php echo e(route('admin.perusahaans.edit', $perusahaan->id)); ?>">
                                    <i class="bi bi-pencil text-sm"></i>
                                </a>

                                <a data-modal-target="delete-modal-<?php echo e($perusahaan->id); ?>" data-modal-toggle="delete-modal-<?php echo e($perusahaan->id); ?>" class="btn-danger !p-3 cursor-pointer">
                                    <i class="bi bi-trash text-sm"></i>
                                </a>

                                <!-- Delete Modal -->
                                <div id="delete-modal-<?php echo e($perusahaan->id); ?>" tabindex="-1" class="hidden fixed inset-0 z-50 flex items-center justify-center">
                                    <div class="relative p-4 w-full max-w-md bg-white rounded-lg shadow-lg dark:bg-gray-700 z-60">
                                        <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="delete-modal-<?php echo e($perusahaan->id); ?>">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                            <span class="sr-only"><?php echo e(__('Close modal')); ?></span>
                                        </button>
                                        <div class="p-4 md:p-5 text-center">
                                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                            </svg>
                                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400"><?php echo e(__('Are you sure you want to delete this company?')); ?></h3>
                                            <form id="delete-form-<?php echo e($perusahaan->id); ?>" action="<?php echo e(route('admin.perusahaans.destroy', $perusahaan->id)); ?>" method="POST">
                                                <?php echo method_field('DELETE'); ?>
                                                <?php echo csrf_field(); ?>

                                                <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                    <?php echo e(__('Yes, Confirm')); ?>

                                                </button>
                                                <button data-modal-hide="delete-modal-<?php echo e($perusahaan->id); ?>" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"><?php echo e(__('No, cancel')); ?></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

                <div class="my-4 px-4 sm:px-6">
                    <?php echo e($perusahaans->links()); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Project\LaraDashboard\resources\views/backend/pages/perusahaans/index.blade.php ENDPATH**/ ?>