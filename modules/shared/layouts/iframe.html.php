<!DOCTYPE html>
<html lang="en">
<head>

  <?php echo $meta ?>

  <title><?php echo html($title) ?></title>

  <?php

  // css
  echo css(array(
    'assets/css/shared/iframe.css',
    '@auto', 
    $css
  ));

  // js
  echo js(array(
    'assets/js/shared/jquery.js',
    'assets/js/shared/jquery.plugins.js',
    'assets/js/shared/application.js',
    'assets/js/shared/iframe.js',
    '@auto', 
    $js
  ));  
  
  ?>

</head>

<body>

  <main class="main" role="main">
    <?php echo $content ?>
  </main>

</body>
</html>