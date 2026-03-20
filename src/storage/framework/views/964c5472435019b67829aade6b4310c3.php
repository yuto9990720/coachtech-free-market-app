<?php $__env->startSection('content'); ?>
<div class="mypage">
    <div class="mypage__profile">
        <div class="mypage__avatar-wrap">
            <?php if(auth()->user()->profile_image): ?>
                <img src="<?php echo e(Storage::url(auth()->user()->profile_image)); ?>"
                     alt="<?php echo e(auth()->user()->name); ?>"
                     class="mypage__avatar">
            <?php else: ?>
                <div class="mypage__avatar mypage__avatar--default"></div>
            <?php endif; ?>
        </div>
        <div class="mypage__user-info">
            <p class="mypage__username"><?php echo e(auth()->user()->name); ?></p>
            <a href="<?php echo e(route('profile.edit')); ?>" class="btn btn--outline">プロフィールを編集する</a>
        </div>
    </div>

    <nav class="tab-nav">
        <a href="<?php echo e(route('profile.index', ['page' => 'sell'])); ?>"
           class="tab-nav__item <?php echo e($page !== 'buy' ? 'tab-nav__item--active' : ''); ?>">出品した商品</a>
        <a href="<?php echo e(route('profile.index', ['page' => 'buy'])); ?>"
           class="tab-nav__item <?php echo e($page === 'buy' ? 'tab-nav__item--active' : ''); ?>">購入した商品</a>
    </nav>

    <div class="items-grid">
        <?php if($page === 'buy'): ?>
            <?php $__empty_1 = true; $__currentLoopData = $purchasedItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <a href="<?php echo e(route('items.show', $item)); ?>" class="item-card">
                    <div class="item-card__image-wrap">
                        <?php if(str_starts_with($item->image, 'http')): ?>
                            <img src="<?php echo e($item->image); ?>" alt="<?php echo e($item->name); ?>" class="item-card__image">
                        <?php else: ?>
                            <img src="<?php echo e(Storage::url($item->image)); ?>" alt="<?php echo e($item->name); ?>" class="item-card__image">
                        <?php endif; ?>
                        <span class="item-card__sold">Sold</span>
                    </div>
                    <p class="item-card__name"><?php echo e($item->name); ?></p>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="items-empty">購入した商品はありません。</p>
            <?php endif; ?>
        <?php else: ?>
            <?php $__empty_1 = true; $__currentLoopData = $soldItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <a href="<?php echo e(route('items.show', $item)); ?>" class="item-card">
                    <div class="item-card__image-wrap">
                        <?php if(str_starts_with($item->image, 'http')): ?>
                            <img src="<?php echo e($item->image); ?>" alt="<?php echo e($item->name); ?>" class="item-card__image">
                        <?php else: ?>
                            <img src="<?php echo e(Storage::url($item->image)); ?>" alt="<?php echo e($item->name); ?>" class="item-card__image">
                        <?php endif; ?>
                        <?php if($item->is_sold): ?>
                            <span class="item-card__sold">Sold</span>
                        <?php endif; ?>
                    </div>
                    <p class="item-card__name"><?php echo e($item->name); ?></p>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="items-empty">出品した商品はありません。</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/mypage/index.blade.php ENDPATH**/ ?>