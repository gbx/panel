<!DOCTYPE html>
<html lang="en">
<head>

  <?php echo $meta ?>

  <title><?php echo html($title) ?></title>

  <?php

  echo css(array(
    'assets/css/shared/blank.css',
    '@auto', 
    $css
  ));

  ?>

</head>

<body>

  <?php echo $content ?>

  <noscript>
    <p>Please activate javascript in your browser</p>
  </noscript>

  <?php 

  echo js(array(
    'assets/js/shared/jquery.js',
    'assets/js/shared/jquery.plugins.js',
    'assets/js/shared/application.js',
    '@auto',
    $js
  ));  
  
  ?>

</body>
</html>