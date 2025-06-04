<?php $__env->startSection('title'); ?>
    <?php echo e(__('CRM Dashboard | ' . config('app.name'))); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('crm-admin-content'); ?>
<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
    <div x-data="{ pageName: 'CRM Dashboard' }">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90" x-text="pageName">Customers</h2>
            <nav>
                <ol class="flex items-center gap-1.5">
                    <li>
                        <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="<?php echo e(route('admin.dashboard')); ?>">
                            Home
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                    <li class="text-sm text-gray-800 dark:text-white/90" x-text="pageName">CRM</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="space-y-6">
        <div class="grid grid-cols-12 gap-4 md:gap-6">
            <div class="col-span-12 space-y-6">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 md:gap-6">
                    <div
                        class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6"
                    >
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800"
                        >
                            <i class="bi bi-people dark:text-white text-2xl"></i>
                        </div>

                        <div class="mt-5 flex items-end justify-between">
                            <?php echo $__env->make('backend.pages.dashboard.partials.card', [
                                'icon_svg' => asset('images/icons/key.svg'),
                                'label' => __('Customers'),
                                'value' => $total_active_customers,
                                'bg' => '#00D7FF',
                                'class' => 'bg-white',
                                'url' => route('admin.customers.index'),
                            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('crm::layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/maniruzzamanakash/workspace/laravel-role/Modules/Crm/resources/views/pages/dashboard.blade.php ENDPATH**/ ?>