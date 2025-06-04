<?php
    $isActive = $item['active'] ? 'menu-item-active' : 'menu-item-inactive';
    $target = !empty($item['target']) ? ' target="' . e($item['target']) . '"' : '';
?>

<li class="hover:menu-item-active">
    <a :style="`color: ${textColor}`" href="<?php echo e($item['route'] ?? '#'); ?>" class="menu-item group <?php echo e($isActive); ?>" <?php echo $target; ?>>
        <?php if(!empty($item['icon'])): ?>
            <img src="<?php echo e(asset('images/icons/' . $item['icon'])); ?>" alt="<?php echo e(e($item['label'])); ?>" class="menu-item-icon dark:invert">
        <?php endif; ?>
        <span class="menu-item-text"><?php echo e(e($item['label'])); ?></span>
    </a>
</li>
<?php /**PATH /Users/maniruzzamanakash/workspace/laravel-role/resources/views/backend/layouts/partials/menu/item.blade.php ENDPATH**/ ?>