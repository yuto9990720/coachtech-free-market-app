<?php $__env->startSection('content'); ?>
<div class="address-page">
    <h1 class="page-title">住所の変更</h1>

    <form action="<?php echo e(route('address.update', $item)); ?>" method="POST" class="address-form">
        <?php echo csrf_field(); ?>

        <div class="form-group">
            <label class="form-label" for="postal_code">郵便番号</label>
            <input
                type="text"
                id="postal_code"
                name="postal_code"
                value="<?php echo e(old('postal_code', $address['postal_code'] ?? '')); ?>"
                placeholder="123-4567"
                class="form-input <?php $__errorArgs = ['postal_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input--error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
            >
            <?php $__errorArgs = ['postal_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="form-error"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group">
            <label class="form-label" for="address">住所</label>
            <input
                type="text"
                id="address"
                name="address"
                value="<?php echo e(old('address', $address['address'] ?? '')); ?>"
                class="form-input <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input--error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
            >
            <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="form-error"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group">
            <label class="form-label" for="building">建物名</label>
            <input
                type="text"
                id="building"
                name="building"
                value="<?php echo e(old('building', $address['building'] ?? '')); ?>"
                class="form-input"
            >
        </div>

        <button type="submit" class="btn btn--primary btn--full">更新する</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/purchase/address.blade.php ENDPATH**/ ?>