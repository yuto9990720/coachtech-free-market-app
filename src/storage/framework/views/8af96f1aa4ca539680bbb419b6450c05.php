<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <a href="<?php echo e(route('items.index')); ?>" class="header__logo">
                <span class="header__logo-text">coachtechフリマ</span>
            </a>

            <?php if(!request()->routeIs('login') && !request()->routeIs('register')): ?>
            <form action="<?php echo e(route('items.index')); ?>" method="GET" class="header__search">
                <input
                    type="text"
                    name="search"
                    value="<?php echo e(request('search')); ?>"
                    placeholder="なにをお探しですか？"
                    class="header__search-input"
                >
                <?php if(request('tab')): ?>
                    <input type="hidden" name="tab" value="<?php echo e(request('tab')); ?>">
                <?php endif; ?>
            </form>

            <nav class="header__nav">
                <?php if(auth()->guard()->check()): ?>
                    <form action="/logout" method="POST" class="header__logout-form">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="header__nav-link header__nav-link--btn">ログアウト</button>
                    </form>
                    <a href="<?php echo e(route('profile.index')); ?>" class="header__nav-link">マイページ</a>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="header__nav-link">ログイン</a>
                <?php endif; ?>
                <a href="<?php echo e(route('exhibition.create')); ?>" class="header__nav-btn">出品する</a>
            </nav>
            <?php endif; ?>
        </div>
    </header>

    <main class="main">
        <?php if(session('success')): ?>
            <div class="alert alert--success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert--error"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </main>
</body>
</html>
<?php /**PATH /var/www/html/resources/views/layouts/app.blade.php ENDPATH**/ ?>