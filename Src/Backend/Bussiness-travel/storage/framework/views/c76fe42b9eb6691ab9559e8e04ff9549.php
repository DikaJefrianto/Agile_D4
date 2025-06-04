<div class="<?php echo e($class ?? 'bg-white'); ?> dark:bg-slate-800 w-full h-[152px] rounded-2xl border border-light-purple dark:border-slate-800 overflow-hidden z-10 p-6 pb-0">
    <div class="flex justify-between">
        <p class="text-[#090909] dark:text-gray-100 text-sm font-medium"><?php echo e($label); ?></p>

        <div class="">
            <button type="button" data-tooltip-target="data-tooltip" data-tooltip-placement="bottom"
                onclick="window.location.href='<?php echo e($url ?? '#'); ?>'"
                class="hidden sm:inline-flex items-center justify-center text-gray-500 w-8 h-8 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm">
                <img src="<?php echo e(asset('/images/icons/move.svg')); ?>" class="dark:invert">
            </button>
        </div>
    </div>

    <div class="flex mt-6 gap-6">
        <div class="bg-white rounded-lg border border-[#EFEFFF] p-2.5 shadow-sm">
            <img src="<?php echo e($icon ?? asset('images/icons/user.svg')); ?>" alt="">
        </div>

        <div class="text-[#090909] dark:text-gray-100 text-3xl font-medium">
            <?php echo e($number ?? 0); ?>

        </div>
    </div>

    <div class="w-40 h-40 rounded-full blur-3xl" style="background: <?php echo e($bg ?? ''); ?>;">
    </div>
</div>
<?php /**PATH /Users/maniruzzamanakash/workspace/laravel-role/resources/views/backend/pages/dashboard/card.blade.php ENDPATH**/ ?>