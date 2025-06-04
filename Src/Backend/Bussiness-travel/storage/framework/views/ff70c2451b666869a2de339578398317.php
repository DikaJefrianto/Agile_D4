<?php $__env->startSection('title', 'New Customer - CRM | ' . config('app.name')); ?>

<?php $__env->startSection('crm-admin-content'); ?>
<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">New Customer</h2>
        <nav>
            <ol class="flex items-center gap-1.5">
                <li>
                    <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="<?php echo e(route('admin.dashboard')); ?>">
                        Home
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
                <li class="text-sm text-gray-800 dark:text-white/90">New Customer</li>
            </ol>
        </nav>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
    <?php if(config('app.env') == 'production'): ?>
        <?php
            $manifest = json_decode(file_get_contents(asset('build/manifest.json')), true);
        ?>
        <script type="module" src="<?php echo e(asset("build/{$manifest['resources/js/customer.jsx']['file']}")); ?>"></script>
    <?php else: ?>
        <?php echo app('Illuminate\Foundation\Vite')->reactRefresh(); ?>
        <?php echo app('Illuminate\Foundation\Vite')('Modules/Crm/resources/assets/js/customer.js'); ?>
    <?php endif; ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('crm::layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/maniruzzamanakash/workspace/laravel-role/Modules/Crm/resources/views/pages/customers/create.blade.php ENDPATH**/ ?>