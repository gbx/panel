<!DOCTYPE html>
<html lang="en">
<head>

  <?php view::snippet('shared > meta') ?>

  <title><?php echo html($title) ?></title>

  <?php

  // css
  echo assets::css('shared > assets/css/iframe.css');  
  echo assets::css('auto');  
  echo assets::css(@$css);  

  // js
  echo assets::js(array(
    'shared > assets/js/jquery.js',
    'shared > assets/js/jquery.ui.js',
    'shared > assets/js/jquery.customSelect.js',
    'shared > assets/js/app.js',
    'shared > assets/js/iframe.js',
  ));  
  
  echo assets::js('auto');
  echo assets::js(@$js);

  ?>

</head>

<body>

  <div class="app">
    <?php echo $content ?>
  </div>

</body>
</html>