<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body>
    <form id="stripe-form" action="<?php echo e($checkoutUrl); ?>" method="POST">
        <?php echo csrf_field(); ?>
    </form>
    <script>
        document.getElementById('stripe-form').submit();
    </script>
</body>

</html>
<?php /**PATH /var/www/html/resources/views/purchase/stripe_redirect.blade.php ENDPATH**/ ?>