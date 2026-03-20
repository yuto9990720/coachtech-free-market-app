<?php $__env->startSection('content'); ?>
<div class="purchase-page">
    <div class="purchase-item">
        <div class="purchase-item__image-wrap">
            <?php if(str_starts_with($item->image, 'http')): ?>
                <img src="<?php echo e($item->image); ?>" alt="<?php echo e($item->name); ?>" class="purchase-item__image">
            <?php else: ?>
                <img src="<?php echo e(Storage::url($item->image)); ?>" alt="<?php echo e($item->name); ?>" class="purchase-item__image">
            <?php endif; ?>
        </div>
        <div class="purchase-item__info">
            <p class="purchase-item__name"><?php echo e($item->name); ?></p>
            <p class="purchase-item__price">¥<?php echo e(number_format($item->price)); ?></p>
        </div>
    </div>

    <form action="<?php echo e(route('purchase.store', $item)); ?>" method="POST" class="purchase-form">
        <?php echo csrf_field(); ?>

        
        <div class="purchase-section">
            <h2 class="purchase-section__title">支払い方法</h2>
            <select name="payment_method" id="payment_method"
                    class="form-select <?php $__errorArgs = ['payment_method'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input--error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    onchange="updatePaymentDisplay(this.value)">
                <option value="">選択してください</option>
                <option value="convenience" <?php echo e(old('payment_method') == 'convenience' ? 'selected' : ''); ?>>
                    コンビニ支払い
                </option>
                <option value="card" <?php echo e(old('payment_method') == 'card' ? 'selected' : ''); ?>>
                    カード支払い
                </option>
            </select>
            <?php $__errorArgs = ['payment_method'];
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

        
        <div class="purchase-section">
            <div class="purchase-section__header">
                <h2 class="purchase-section__title">配送先</h2>
                <a href="<?php echo e(route('address.edit', $item)); ?>" class="purchase-section__edit-link">変更する</a>
            </div>
            <div class="address-display">
                <p>〒<?php echo e($address['postal_code'] ?? ''); ?></p>
                <p><?php echo e($address['address'] ?? ''); ?></p>
                <?php if(!empty($address['building'])): ?>
                    <p><?php echo e($address['building']); ?></p>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="purchase-summary">
            <table class="purchase-summary__table">
                <tr>
                    <th>商品代金</th>
                    <td>¥<?php echo e(number_format($item->price)); ?></td>
                </tr>
                <tr>
                    <th>支払い方法</th>
                    <td id="payment-method-display">-</td>
                </tr>
            </table>
        </div>

        <button type="submit" class="btn btn--primary btn--full">購入する</button>
    </form>
</div>

<script>
const paymentLabels = {
    convenience: 'コンビニ支払い',
    card: 'カード支払い',
};

function updatePaymentDisplay(value) {
    document.getElementById('payment-method-display').textContent = paymentLabels[value] || '-';
}

// 初期表示
const sel = document.getElementById('payment_method');
if (sel.value) updatePaymentDisplay(sel.value);
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/purchase/index.blade.php ENDPATH**/ ?>