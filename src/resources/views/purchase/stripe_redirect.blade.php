<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body>
    <form id="stripe-form" action="{{ $checkoutUrl }}" method="POST">
        @csrf
    </form>
    <script>
        document.getElementById('stripe-form').submit();
    </script>
</body>

</html>
