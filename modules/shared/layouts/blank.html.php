<!DOCTYPE html>
<html lang="en">
<head>

  <?php view::snippet('shared > meta') ?>

  <title><?php echo html($title) ?></title>

  <?php

  // css
  echo assets::css('shared > assets/css/blank.css');  
  echo assets::css('auto');  
  echo assets::css(@$css);  

  // js
  echo assets::js(array(
    'shared > assets/js/jquery.js',
    'shared > assets/js/jquery.ui.js',
    'shared > assets/js/jquery.customSelect.js',
    'shared > assets/js/app.js',
  ));  
  
  echo assets::js('auto');
  echo assets::js(@$js);

  ?>

</head>

<body>

  <?php echo $content ?>

  <noscript>
    <p>Please activate javascript in your browser</p>
  </noscript>

</body>
</html>