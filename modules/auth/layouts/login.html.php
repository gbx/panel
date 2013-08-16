<!DOCTYPE html>
<html class="login">
<head>

<title><?php echo html($title) ?></title>

<?php echo snippet::create('shared > meta') ?>
<?php echo css('assets/css/shared/application.css') ?>
<?php echo css('assets/css/auth/auth.css') ?>

</head>
<body>
  <?php echo $content ?>
</body>
</html>