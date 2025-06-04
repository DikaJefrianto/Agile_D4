<?php $user = Auth::user(); ?>

<?php if($user->can('customer.view') || $user->can('customer.create')): ?>
<li x-data class="hover:menu-item-active">
    <button
        :style="`color: ${textColor}`"
        class="menu-item group w-full text-left <?php echo e(Route::is('admin.crm.*') ? 'menu-item-active' : 'menu-item-inactive'); ?>"
        type="button"
        @click="toggleSubmenu('crm-submenu')"
    >

    <img src="<?php echo e(asset('images/icons/headphone.svg')); ?>" alt="CRM Icon" class="menu-item-icon dark:invert">
        <span class="menu-item-text"><?php echo e(__('CRM')); ?></span>
        <img src="<?php echo e(asset('images/icons/chevron-down.svg')); ?>" alt="Arrow" class="menu-item-arrow dark:invert" :class="submenus['crm-submenu'] ? 'rotate-180' : ''">
    </button>
    <ul
        id="crm-submenu"
        x-show="submenus['crm-submenu']"
        class="submenu pl-12 mt-2 space-y-2"
    >
        <?php if($user->can('crm.dashboard')): ?>
        <li>
            <a
                :style="`color: ${textColor}`"
                href="<?php echo e(route('admin.crm.dashboard')); ?>"
                class="hover:menu-item-active block px-4 py-2 rounded-lg <?php echo e(Route::is('admin.crm.dashboard') ? 'menu-item-active' : 'menu-item-inactive'); ?>"
            >
                <?php echo e(__('CRM Dashboard')); ?>

            </a>
        </li>
        <?php endif; ?>

        <?php if($user->can('customer.view')): ?>
        <li>
            <a
                :style="`color: ${textColor}`"
                href="<?php echo e(route('admin.crm.customers.index')); ?>"
                class="hover:menu-item-active block px-4 py-2 rounded-lg <?php echo e(Route::is('admin.crm.customers.index') || Route::is('admin.crm.customers.edit') ? 'menu-item-active' : 'menu-item-inactive'); ?>"
            >
                <?php echo e(__('Customers')); ?>

            </a>
        </li>
        <?php endif; ?>
        <?php if($user->can('customer.create')): ?>
        <li>
            <a
                :style="`color: ${textColor}`"
                href="<?php echo e(route('admin.crm.customers.create')); ?>"
                class="hover:menu-item-active block px-4 py-2 rounded-lg <?php echo e(Route::is('admin.crm.customers.create') ? 'menu-item-active' : 'menu-item-inactive'); ?>"
            >
                <?php echo e(__('New Customer')); ?>

            </a>
        </li>
        <?php endif; ?>
    </ul>
</li>
<?php endif; ?><?php /**PATH /Users/maniruzzamanakash/workspace/laravel-role/Modules/Crm/resources/views/partials/crm-menu.blade.php ENDPATH**/ ?>