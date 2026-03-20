<?php $__env->startSection('content'); ?>
<div class="item-detail">
    <div class="item-detail__image-wrap">
        <?php if(str_starts_with($item->image, 'http')): ?>
            <img src="<?php echo e($item->image); ?>" alt="<?php echo e($item->name); ?>" class="item-detail__image">
        <?php else: ?>
            <img src="<?php echo e(Storage::url($item->image)); ?>" alt="<?php echo e($item->name); ?>" class="item-detail__image">
        <?php endif; ?>
    </div>

    <div class="item-detail__info">
        <h1 class="item-detail__name"><?php echo e($item->name); ?></h1>

        <?php if($item->brand): ?>
            <p class="item-detail__brand"><?php echo e($item->brand); ?></p>
        <?php endif; ?>

        <p class="item-detail__price">
            <span class="item-detail__price-symbol">¥</span><?php echo e(number_format($item->price)); ?>

            <span class="item-detail__price-tax">（税込）</span>
        </p>

        <div class="item-detail__actions">
            
            <button
                id="like-btn"
                class="like-btn <?php echo e($isLiked ? 'like-btn--active' : ''); ?>"
                data-item-id="<?php echo e($item->id); ?>"
                data-liked="<?php echo e($isLiked ? 'true' : 'false'); ?>"
                <?php if(auth()->guard()->guest()): ?> disabled <?php endif; ?>
            >
                <span class="like-btn__icon">♥</span>
                <span class="like-btn__count" id="like-count"><?php echo e($item->likes->count()); ?></span>
            </button>

            
            <div class="comment-count">
                <span class="comment-count__icon">💬</span>
                <span class="comment-count__num" id="comment-count"><?php echo e($item->comments->count()); ?></span>
            </div>
        </div>

        <?php if(!$item->is_sold): ?>
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('purchase.index', $item)); ?>" class="btn btn--primary btn--full">購入手続きへ</a>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="btn btn--primary btn--full">購入手続きへ</a>
            <?php endif; ?>
        <?php else: ?>
            <button class="btn btn--disabled btn--full" disabled>売り切れ</button>
        <?php endif; ?>

        <section class="item-detail__section">
            <h2 class="item-detail__section-title">商品説明</h2>
            <p class="item-detail__description"><?php echo e($item->description); ?></p>
        </section>

        <section class="item-detail__section">
            <h2 class="item-detail__section-title">商品情報</h2>
            <table class="item-info-table">
                <tr>
                    <th class="item-info-table__label">カテゴリー</th>
                    <td class="item-info-table__value">
                        <?php $__currentLoopData = $item->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="tag"><?php echo e($category->name); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </td>
                </tr>
                <tr>
                    <th class="item-info-table__label">商品の状態</th>
                    <td class="item-info-table__value"><?php echo e($item->condition->name); ?></td>
                </tr>
            </table>
        </section>

        <section class="item-detail__section">
            <h2 class="item-detail__section-title">
                コメント（<span id="comment-count-title"><?php echo e($item->comments->count()); ?></span>）
            </h2>

            <div class="comment-list" id="comment-list">
                <?php $__currentLoopData = $item->comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="comment">
                        <div class="comment__user">
                            <?php if($comment->user->profile_image): ?>
                                <img src="<?php echo e(Storage::url($comment->user->profile_image)); ?>"
                                     alt="<?php echo e($comment->user->name); ?>" class="comment__avatar">
                            <?php else: ?>
                                <div class="comment__avatar comment__avatar--default"></div>
                            <?php endif; ?>
                            <span class="comment__username"><?php echo e($comment->user->name); ?></span>
                        </div>
                        <p class="comment__content"><?php echo e($comment->content); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <?php if(auth()->guard()->check()): ?>
                <form action="<?php echo e(route('comment.store', $item)); ?>" method="POST" class="comment-form">
                    <?php echo csrf_field(); ?>
                    <label class="form-label" for="content">商品へのコメント</label>
                    <textarea
                        id="content"
                        name="content"
                        rows="4"
                        class="form-input form-textarea <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input--error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        placeholder="コメントを入力してください"
                    ><?php echo e(old('content')); ?></textarea>
                    <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="form-error"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <button type="submit" class="btn btn--secondary btn--full">コメントを送信する</button>
                </form>
            <?php else: ?>
                <p class="auth-notice">
                    コメントするには<a href="<?php echo e(route('login')); ?>">ログイン</a>が必要です。
                </p>
            <?php endif; ?>
        </section>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const likeBtn = document.getElementById('like-btn');
    if (!likeBtn || likeBtn.disabled) return;

    likeBtn.addEventListener('click', function () {
        const itemId = this.dataset.itemId;
        const token  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(`/like/${itemId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
            },
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById('like-count').textContent = data.count;
            if (data.liked) {
                likeBtn.classList.add('like-btn--active');
            } else {
                likeBtn.classList.remove('like-btn--active');
            }
        });
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/items/show.blade.php ENDPATH**/ ?>