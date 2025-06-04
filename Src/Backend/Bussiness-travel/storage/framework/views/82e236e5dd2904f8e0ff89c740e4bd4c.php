<?php
    $menuService = app(\App\Services\MenuService\AdminMenuService::class);
    $menuGroups = $menuService->getMenu();
    $sidebarTextDark = config('settings.sidebar_text_dark', '#ffffff');
    $sidebarTextLite = config('settings.sidebar_text_lite', '#090909');
?>

<nav
    x-data="{
        isDark: document.documentElement.classList.contains('dark'),
        textColor: '',
        init() {
            this.updateColor();
            const observer = new MutationObserver(() => this.updateColor());
            observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
        },
        updateColor() {
            this.isDark = document.documentElement.classList.contains('dark');
            this.textColor = this.isDark ? '<?php echo e($sidebarTextDark); ?>' : '<?php echo e($sidebarTextLite); ?>';
        }
    }"
    x-init="init()"
    class="transition-all duration-300 ease-in-out"
>
    <?php $__currentLoopData = $menuGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupName => $groupItems): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo ld_apply_filters('sidebar_menu_group_before_' . Str::slug($groupName), ''); ?>

        <div>
            <?php echo ld_apply_filters('sidebar_menu_group_heading_before_' . Str::slug($groupName), ''); ?>

            <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400 px-5">
                <?php echo e(__($groupName)); ?>

            </h3>
            <?php echo ld_apply_filters('sidebar_menu_group_heading_after_' . Str::slug($groupName), ''); ?>

            <ul class="flex flex-col mb-6">
                <?php echo ld_apply_filters('sidebar_menu_before_all_' . Str::slug($groupName), ''); ?>

                <?php echo $menuService->render($groupItems); ?>

                <?php echo ld_apply_filters('sidebar_menu_after_all_' . Str::slug($groupName), ''); ?>

            </ul>
        </div>
        <?php echo ld_apply_filters('sidebar_menu_group_after_' . Str::slug($groupName), ''); ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</nav>
<?php /**PATH /Users/maniruzzamanakash/workspace/laravel-role/resources/views/backend/layouts/partials/sidebar-menu.blade.php ENDPATH**/ ?>