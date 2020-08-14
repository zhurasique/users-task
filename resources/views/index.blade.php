
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>upqode</title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <link href="{{ asset('css/loading.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>

<div class="container mt-3" id="form">
    <front-page></front-page>
</div>

<script src="{{ mix('js/app.js') }}"></script>

</body>
</html>

