<?php
    $submenuId = $item['id'] ?? \Str::slug($item['label']) . '-submenu';
    $isActive = $item['active'] ? 'menu-item-active' : 'menu-item-inactive';
    $showSubmenu = app(\App\Services\MenuService\SidebarMenuService::class)->shouldExpandSubmenu($item);
    $rotateClass = $showSubmenu ? 'rotate-180' : '';
?>

<li class="hover:menu-item-active">
    <button :style="`color: ${textColor}`" class="menu-item group w-full text-left <?php echo e($isActive); ?>" type="button" onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('.menu-item-arrow').classList.toggle('rotate-180')">
        <?php if(!empty($item['icon'])): ?>
            <img src="<?php echo e(asset('images/icons/' . $item['icon'])); ?>" alt="<?php echo e(e($item['label'])); ?>" class="menu-item-icon dark:invert">
        <?php endif; ?>
        <span class="menu-item-text"><?php echo e(e($item['label'])); ?></span>
        <img src="<?php echo e(asset('images/icons/chevron-down.svg')); ?>" alt="Arrow" class="menu-item-arrow dark:invert transition-transform duration-300 <?php echo e($rotateClass); ?>">
    </button>
    <ul id="<?php echo e($submenuId); ?>" class="submenu pl-12 mt-2 space-y-2 overflow-hidden <?php echo e($showSubmenu ? '' : 'hidden'); ?>">
        <?php $__currentLoopData = $item['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('backend.layouts.partials.menu.menu-item', ['item' => $child], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</li>
<?php /**PATH /Users/maniruzzamanakash/workspace/laravel-role/resources/views/backend/layouts/partials/menu/submenu.blade.php ENDPATH**/ ?>