<?php $__env->startSection('content'); ?>
<div class="items-page">
    <nav class="tab-nav">
        <a
            href="<?php echo e(route('items.index', ['search' => $search])); ?>"
            class="tab-nav__item <?php echo e($tab !== 'mylist' ? 'tab-nav__item--active' : ''); ?>"
        >おすすめ</a>
        <a
            href="<?php echo e(route('items.index', ['tab' => 'mylist', 'search' => $search])); ?>"
            class="tab-nav__item <?php echo e($tab === 'mylist' ? 'tab-nav__item--active' : ''); ?>"
        >マイリスト</a>
    </nav>

    <div class="items-grid">
        <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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
            <p class="items-empty">商品がありません。</p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/items/index.blade.php ENDPATH**/ ?>