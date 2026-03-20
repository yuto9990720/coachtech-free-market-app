<?php $__env->startSection('content'); ?>
<div class="auth">
    <h1 class="auth__title">メール認証</h1>

    <p class="auth__description">
        登録したメールアドレスに認証メールを送信しました。<br>
        メール内のリンクをクリックして認証を完了してください。
    </p>

    <?php if(session('status') == 'verification-link-sent'): ?>
        <div class="alert alert--success">認証メールを再送信しました。</div>
    <?php endif; ?>

    <div class="auth__actions">
        <a href="<?php echo e(route('verification.send')); ?>" class="btn btn--secondary btn--full"
           onclick="event.preventDefault(); document.getElementById('resend-form').submit();">
            認証はこちらから
        </a>

        <form id="resend-form" action="<?php echo e(route('verification.send')); ?>" method="POST" style="display:none;">
            <?php echo csrf_field(); ?>
        </form>

        <form action="/logout" method="POST" class="auth__logout-form">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn--outline btn--full">ログアウト</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/auth/verify-email.blade.php ENDPATH**/ ?>