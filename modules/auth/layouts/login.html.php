<!DOCTYPE html>
<html class="login">
<head>

<title><?php echo html($title) ?></title>

<?php view::snippet('shared > meta') ?>

<?php echo assets::css('shared > assets/css/app.css') ?>
<?php echo assets::css('auth > assets/css/auth.css') ?>

</head>
<body>
<?php echo $content ?>
</body>
</html>