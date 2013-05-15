<!DOCTYPE html>
<html lang="en">
<head>

  <?php app()->snippet('shared > meta') ?>

  <title><?php echo html($title) ?></title>

  <?php echo app()->css('shared > assets/css/iframe.css') ?>
  <?php if(isset($css)) foreach($css as $c) echo app()->css($c); ?>

  <?php echo app()->js('shared > assets/js/jquery.js') ?>
  <?php echo app()->js('shared > assets/js/jquery.ui.js') ?>
  <?php echo app()->js('shared > assets/js/jquery.customSelect.js') ?>
  <?php echo app()->js('shared > assets/js/moment.js') ?>
  <?php echo app()->js('shared > assets/js/jquery.pikaday.js') ?>
  <?php echo app()->js('shared > assets/js/app.js') ?>
  <?php echo app()->js('shared > assets/js/iframe.js') ?>
  <?php if(isset($js)) foreach($js as $j) echo app()->js($j); ?>

</head>

<body>

  <div class="app">
    <?php echo $content ?>
  </div>

</body>
</html>