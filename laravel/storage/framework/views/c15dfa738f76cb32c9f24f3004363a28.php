<input
    <?php echo e($attributes
            ->merge([
                'id' => $getId(),
                'type' => 'hidden',
                $applyStateBindingModifiers('wire:model') => $getStatePath(),
            ], escape: false)
            ->merge($getExtraAttributes(), escape: false)
            ->class(['fi-fo-hidden'])); ?>

/>
<?php /**PATH /var/www/html/_bases/base_fixcity_fila3/laravel/vendor/filament/forms/resources/views/components/hidden.blade.php ENDPATH**/ ?>