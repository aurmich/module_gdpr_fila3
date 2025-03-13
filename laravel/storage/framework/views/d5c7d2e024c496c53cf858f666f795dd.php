<html lang="en" class="<?php echo e($theme == 'dark' ? 'dark' : ''); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title><?php echo e(__('health::notifications.health_results')); ?></title>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <?php echo e($assets); ?>

</head>

<body class="antialiased bg-gray-100 mt-7 md:mt-12 dark:bg-gray-900">
    <div class="mx-auto max-w-7xl lg:px-8 sm:px-6">
        <div class="flex flex-wrap justify-center space-y-3">
            <h4 class="w-full text-2xl font-bold text-center text-gray-900 dark:text-white"><?php echo e(__('health::notifications.laravel_health')); ?></h4>
            <div class="flex justify-center w-full">
                <?php if (isset($component)) { $__componentOriginalbb345d5951545b4ca3383b830d240c9c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbb345d5951545b4ca3383b830d240c9c = $attributes; } ?>
<?php $component = Spatie\Health\Components\Logo::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('health-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Spatie\Health\Components\Logo::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbb345d5951545b4ca3383b830d240c9c)): ?>
<?php $attributes = $__attributesOriginalbb345d5951545b4ca3383b830d240c9c; ?>
<?php unset($__attributesOriginalbb345d5951545b4ca3383b830d240c9c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbb345d5951545b4ca3383b830d240c9c)): ?>
<?php $component = $__componentOriginalbb345d5951545b4ca3383b830d240c9c; ?>
<?php unset($__componentOriginalbb345d5951545b4ca3383b830d240c9c); ?>
<?php endif; ?>
            </div>
            <?php if($lastRanAt): ?>
                <div class="<?php echo e($lastRanAt->diffInMinutes() > 5 ? 'text-red-400' : 'text-gray-400 dark:text-gray-500'); ?> text-sm text-center font-medium">
                    <?php echo e(__('health::notifications.check_results_from')); ?> <?php echo e($lastRanAt->diffForHumans()); ?>

                </div>
            <?php endif; ?>
        </div>
        <div class="px-2 my-6 md:mt-8 md:px-0">
            <?php if(count($checkResults?->storedCheckResults ?? [])): ?>
                <dl class=" grid grid-cols-1 gap-2.5 sm:gap-3 md:gap-5 md:grid-cols-2 lg:grid-cols-3">
                    <?php $__currentLoopData = $checkResults->storedCheckResults; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-start px-4 space-x-2 overflow-hidden py-5 text-opacity-0 transition transform bg-white shadow-md shadow-gray-200 dark:shadow-black/25 dark:shadow-md dark:bg-gray-800 rounded-xl sm:p-6 md:space-x-3 md:min-h-[130px] dark:border-t dark:border-gray-700">
                            <?php if (isset($component)) { $__componentOriginal0b948ab06671ca1470ad6cb790b0e34f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b948ab06671ca1470ad6cb790b0e34f = $attributes; } ?>
<?php $component = Spatie\Health\Components\StatusIndicator::resolve(['result' => $result] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('health-status-indicator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Spatie\Health\Components\StatusIndicator::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b948ab06671ca1470ad6cb790b0e34f)): ?>
<?php $attributes = $__attributesOriginal0b948ab06671ca1470ad6cb790b0e34f; ?>
<?php unset($__attributesOriginal0b948ab06671ca1470ad6cb790b0e34f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b948ab06671ca1470ad6cb790b0e34f)): ?>
<?php $component = $__componentOriginal0b948ab06671ca1470ad6cb790b0e34f; ?>
<?php unset($__componentOriginal0b948ab06671ca1470ad6cb790b0e34f); ?>
<?php endif; ?>
                            <div>
                                <dd class="-mt-1 font-bold text-gray-900 dark:text-white md:mt-1 md:text-xl">
                                    <?php echo e($result->label); ?>

                                </dd>
                                <dt class="mt-0 text-sm font-medium text-gray-600 dark:text-gray-300 md:mt-1">
                                    <?php if(!empty($result->notificationMessage)): ?>
                                        <?php echo e($result->notificationMessage); ?>

                                    <?php else: ?>
                                        <?php echo e($result->shortSummary); ?>

                                    <?php endif; ?>
                                </dt>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </dl>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
<?php /**PATH /var/www/html/_bases/base_fixcity_fila3/laravel/vendor/spatie/laravel-health/resources/views/list.blade.php ENDPATH**/ ?>