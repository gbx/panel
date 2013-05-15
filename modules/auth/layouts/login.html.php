<!DOCTYPE html>
<html class="login">
<head>

<title><?php echo html($title) ?></title>

<?php app()->snippet('shared > meta') ?>

<?php echo app()->css('shared > assets/css/app.css') ?>
<?php echo app()->css('auth > assets/css/auth.css') ?>

</head>
<body>
<?php echo $content ?>
</body>
</html>