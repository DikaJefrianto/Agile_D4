<?php $__env->startSection('title'); ?>
    <?php echo $__env->yieldContent('crm-title', __('Customers | CRM - ' . config('app.name'))); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')(['Modules/Crm/Resources/assets/css/app.css']); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('admin-content'); ?>
    <div class="crm-module">
        <?php echo $__env->yieldContent('crm-admin-content'); ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/maniruzzamanakash/workspace/laravel-role/Modules/Crm/resources/views/layouts/master.blade.php ENDPATH**/ ?>