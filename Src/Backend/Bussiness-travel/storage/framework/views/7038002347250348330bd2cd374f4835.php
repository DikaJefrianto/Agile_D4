<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')->reactRefresh(); ?>
    <?php echo e(module_vite('build-crm', 'resources/assets/css/customer.css')); ?>

    <?php echo e(module_vite('build-crm', 'resources/assets/js/customer.js')); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('title', $customer->full_name . ' - Details | CRM - ' . config('app.name')); ?>

<?php $__env->startSection('admin-content'); ?>
    <div id="customer-detail-page" data-customer="<?php echo e(@json_encode($customer)); ?>"></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/maniruzzamanakash/workspace/laravel-role/Modules/Crm/resources/views/pages/customers/show.blade.php ENDPATH**/ ?>