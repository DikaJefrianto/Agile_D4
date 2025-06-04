<?php $__env->startSection('title'); ?>
    <?php echo e(__('CRM Dashboard | ' . config('app.name'))); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('crm-admin-content'); ?>
<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
    <div x-data="{ pageName: '<?php echo e(__('Dashboard')); ?>' }">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90"><?php echo e(__('Dashboard')); ?></h2>
        </div>
    </div>

    <div class="space-y-6">
        <div class="grid grid-cols-12 gap-4 md:gap-6">
            <div class="col-span-12 space-y-6">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 md:gap-6">
                    <div class="mt-5 grid grid-cols-2 gap-4 md:grid-cols-4 lg:grid-cols-4 md:gap-6">
                        <?php echo $__env->make('backend.pages.dashboard.partials.card', [
                            'icon_svg' => asset('images/icons/user.svg'),
                            'label' => __('Customers'),
                            'value' => $total_active_customers,
                            'bg' => '#00D7FF',
                            'class' => 'bg-white',
                            'url' => route('admin.crm.customers.index'),
                        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('crm::layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/maniruzzamanakash/workspace/laravel-role/Modules/Crm/resources/views/pages/dashboard/index.blade.php ENDPATH**/ ?>