<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
</head>
<body class="auth-body">
    <header class="header">
        <div class="header__inner">
            <a href="<?php echo e(route('items.index')); ?>" class="header__logo">
                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="COACHTECH">
            </a>
        </div>
    </header>

    <main class="main">
        <?php echo $__env->yieldContent('content'); ?>
    </main>
</body>
</html><?php /**PATH /var/www/html/resources/views/layouts/auth.blade.php ENDPATH**/ ?>