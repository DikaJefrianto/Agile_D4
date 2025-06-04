<?php $__env->startSection('title'); ?>
    <?php echo e(__('Customers | CRM - ' . config('app.name'))); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('crm-admin-content'); ?>
<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Customers</h2>
        <nav>
            <ol class="flex items-center gap-1.5">
                <li>
                    <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="<?php echo e(route('admin.dashboard')); ?>">
                        Home
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
                <li class="text-sm text-gray-800 dark:text-white/90">Customers</li>
            </ol>
        </nav>
    </div>

    <!-- Customers Table -->
    <div class="space-y-6">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-5 py-4 sm:px-6 sm:py-5 flex justify-between items-center">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Customers</h3>

                <?php echo $__env->make('backend.partials.search-form', [
                    'placeholder' => __('Search by name or email'),
                ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                <?php if(auth()->user()->can('customer.edit')): ?>
                    <a href="<?php echo e(route('admin.crm.customers.create')); ?>" class="btn-primary">
                        <i class="bi bi-plus-circle mr-2"></i>
                        <?php echo e(__('New Customer')); ?>

                    </a>
                <?php endif; ?>
            </div>
            <div class="space-y-3 border-t border-gray-100 dark:border-gray-800 overflow-x-auto">
                <?php echo $__env->make('backend.layouts.partials.messages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <table id="dataTable" class="w-full dark:text-gray-400">
                    <thead class="bg-light text-capitalize">
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <th width="5%" class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5"><?php echo e(__('Sl')); ?></th>
                            <th width="15%" class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5"  ><?php echo e(__('Name')); ?></th>
                            <th width="10%" class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5"><?php echo e(__('Email')); ?></th>
                            <th width="10%" class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5"><?php echo e(__('Phone')); ?></th>
                            <th width="20%" class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5"><?php echo e(__('Status')); ?></th>
                            <th width="15%" class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5"><?php echo e(__('Life Stage')); ?></th>
                            <?php ld_apply_filters('customer_list_page_table_header_before_action', '') ?>
                            <th width="15%" class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5"><?php echo e(__('Action')); ?></th>
                            <?php ld_apply_filters('customer_list_page_table_header_after_action', '') ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <td class="px-5 py-4"><?php echo e($loop->index + 1); ?></td>
                                <td class="px-5 py-4 flex items-center md:min-w-[200px]">
                                    <a data-tooltip-target="tooltip-customer-<?php echo e($customer->id); ?>" href="<?php echo e(route('admin.crm.customers.show', $customer->uuid)); ?>" class="flex items-center">
                                        <img src="<?php echo e(ld_apply_filters('user_list_page_avatar_item', $customer->user->getGravatarUrl(40), $customer->user)); ?>" alt="<?php echo e($customer->name); ?>" class="w-10 h-10 rounded-full mr-3">
                                        <?php echo e($customer->full_name); ?>

                                    </a>
                                    <div id="tooltip-customer-<?php echo e($customer->id); ?>" href="<?php echo e(route('admin.crm.customers.show', $customer->uuid)); ?>" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                        <?php echo e(__('View Customer')); ?>

                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </td>
                                <td class="px-5 py-4"><?php echo e($customer->email); ?></td>
                                <td class="px-5 py-4"><?php echo e($customer->phone); ?></td>
                                <td class="px-3 py-4">
                                    <span class="max-w-max bg-gray-200 dark:bg-gray-800 text-black p-1 px-4 rounded-full text-sm font-semibold dark:text-gray-50" style="color: <?php echo e($customer->status->color); ?>;">
                                        <?php echo e($customer->status->name); ?>

                                    </span>
                                </td>
                                <td class="px-3 py-4">
                                    <span class="max-w-max flex gap-1 bg-gray-200 dark:bg-gray-800 text-black p-1 px-4 rounded-full text-sm font-semibold dark:text-gray-50" style="color: <?php echo e($customer->type->color()); ?>;">
                                        <i class="<?php echo e($customer->type->icon()); ?> mr-2"></i>
                                        <?php echo e($customer->type->label()); ?>

                                    </span>
                                </td>
                                <?php ld_apply_filters('customer_list_page_table_row_before_action', '', $customer) ?>
                                <td class="flex px-5 py-4 text-center">
                                    <?php if(auth()->user()->can('customer.edit')): ?>
                                        <a data-tooltip-target="tooltip-edit-customer-<?php echo e($customer->id); ?>" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" href="<?php echo e(route('admin.crm.customers.edit', $customer->id)); ?>">
                                            <i class="bi bi-pencil text-sm"></i>
                                        </a>
                                        <div id="tooltip-edit-customer-<?php echo e($customer->id); ?>" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                            Edit Customer
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if(auth()->user()->can('customer.delete')): ?>
                                        <a data-modal-target="delete-modal-<?php echo e($customer->id); ?>" data-modal-toggle="delete-modal-<?php echo e($customer->id); ?>" data-tooltip-target="tooltip-delete-customer-<?php echo e($customer->id); ?>" class="text-white bg-gradient-to-r from-red-500 via-red-600 to-red-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" href="javascript:void(0);">
                                            <i class="bi bi-trash text-sm"></i>
                                        </a>
                                        <div id="tooltip-delete-customer-<?php echo e($customer->id); ?>" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                            Delete Customer
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>

                                        <div id="delete-modal-<?php echo e($customer->id); ?>" tabindex="-1" class="hidden fixed inset-0 z-50 items-center justify-center">
                                            <!-- Modal Content -->
                                            <div class="relative p-4 w-full max-w-md bg-white rounded-lg shadow-lg dark:bg-gray-700 z-60">
                                                <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="delete-modal-<?php echo e($customer->id); ?>">
                                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                                <div class="p-4 md:p-5 text-center">
                                                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                    </svg>
                                                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this customer?</h3>
                                                    <form id="delete-form-<?php echo e($customer->id); ?>" action="<?php echo e(route('admin.crm.customers.destroy', $customer->id)); ?>" method="POST">
                                                        <?php echo method_field('DELETE'); ?>
                                                        <?php echo csrf_field(); ?>

                                                        <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                            Yes, Confirm
                                                        </button>
                                                        <button data-modal-hide="delete-modal-<?php echo e($customer->id); ?>" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No, cancel</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <?php ld_apply_filters('customer_list_page_table_row_after_action', '', $customer) ?>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <p class="text-gray-500 dark:text-gray-400"><?php echo e(__('No customers found')); ?></p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <div class="my-4 px-4 sm:px-6">
                    <?php echo e($customers->links()); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('crm::layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/maniruzzamanakash/workspace/laravel-role/Modules/Crm/resources/views/pages/customers/index.blade.php ENDPATH**/ ?>