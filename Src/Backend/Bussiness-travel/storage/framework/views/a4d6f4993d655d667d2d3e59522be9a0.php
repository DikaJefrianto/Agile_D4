

<?php $__env->startSection('title'); ?>
    <?php echo e(__('Dashboard')); ?> | <?php echo e(config('app.name')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('before_vite_build'); ?>
    <script>
        var userGrowthData = <?php echo json_encode($user_growth_data['data'], 15, 512) ?>;
        var userGrowthLabels = <?php echo json_encode($user_growth_data['labels'], 15, 512) ?>;
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('admin-content'); ?>
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div x-data="{ pageName: '<?php echo e(__('Dashboard')); ?>' }">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90"><?php echo e(__('Dashboard')); ?></h2>
            </div>
        </div>

        
        <div class="grid grid-cols-12 gap-4 md:gap-6">
            <div class="col-span-12 space-y-6">
                <div class="grid grid-cols-2 gap-4 md:grid-cols-4 lg:grid-cols-4 md:gap-6">
                    <?php echo $__env->make('backend.pages.dashboard.partials.card', [
                        'icon_svg' => asset('images/icons/user.svg'),
                        'label' => __('Users'),
                        'value' => $total_users,
                        'bg' => '#635BFF',
                        'class' => 'bg-white',
                        'url' => route('admin.users.index'),
                    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php echo $__env->make('backend.pages.dashboard.partials.card', [
                        'icon_svg' => asset('images/icons/key.svg'),
                        'label' => __('Roles'),
                        'value' => $total_roles,
                        'bg' => '#00D7FF',
                        'class' => 'bg-white',
                        'url' => route('admin.roles.index'),
                    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php echo $__env->make('backend.pages.dashboard.partials.card', [
                        'icon' => 'bi bi-shield-check',
                        'label' => __('Permissions'),
                        'value' => $total_permissions,
                        'bg' => '#FF4D96',
                        'class' => 'bg-white',
                        'url' => route('admin.permissions.index'),
                    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php echo $__env->make('backend.pages.dashboard.partials.card', [
                        'icon' => 'bi bi-translate',
                        'label' => __('Translations'),
                        'value' => $languages['total'] . ' / ' . $languages['active'],
                        'bg' => '#22C55E',
                        'class' => 'bg-white',
                        'url' => route('admin.translations.index'),
                    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>
        </div>


        
        <div class="mt-6">
            <div class="grid grid-cols-12 gap-4 md:gap-6">
                <div class="col-span-12">
                    <div class="grid grid-cols-12 gap-4 md:gap-6">
                        <div class="col-span-12 md:col-span-8">
                            <?php echo $__env->make('backend.pages.dashboard.partials.user-growth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>
                        <div class="col-span-12 md:col-span-4">
                            <?php echo $__env->make('backend.pages.dashboard.partials.user-history', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Project\Agile_D4\Src\Backend\Bussiness-travel\resources\views/backend/pages/dashboard/index.blade.php ENDPATH**/ ?>