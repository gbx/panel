<!DOCTYPE html>
<html lang="en">
<head>

  <?php view::snippet('shared > meta') ?>

  <title><?php echo html($title) ?></title>

  <?php

  // css
  echo assets::css('shared > assets/css/app.css');  
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

  <div class="app">

    <header class="topbar">

      <h1 class="topbar-headline is-hidden">Kirby Panel</h1>

      <nav class="topbar-menu clear" role="navigation">

        <h1 class="topbar-menu-headline is-hidden">Main Menu</h1>

        <ul class="topbar-menu-items">
          <li class="topbar-menu-item user">
            <a data-event="action" data-action="dropdown" href="#user-dropdown"><img src="<?php echo app()->user()->avatar()->url() ?>" /></a>
            <ul id="user-dropdown" class="dropdown is-left-aligned">
              <li><a data-event="action" data-action="iframe" href="<?php echo app()->url('users/' . app()->user()->username() . '/edit') ?>">Account</a></li>              
              <li><a data-event="action" data-action="iframe" href="<?php echo app()->url('users/' . app()->user()->username() . '/picture/upload') ?>">Picture</a></li>              
              <li><a href="<?php echo app()->url('logout') ?>">Logout</a></li>              
            </ul>
          </li>
          <?php foreach(app()->moduleList() as $module): ?>
          <li class="topbar-menu-item"><a<?php e($module->isActive(), ' class="is-active"') ?> href="<?php echo $module->url() ?>"><?php echo html($module->title()) ?></a></li>
          <?php endforeach ?> 
        </ul>
      </nav>

    </header>

    <section class="main">
      <?php if(isset($header)) echo $header ?>

      <div class="content">
        <?php echo $content ?>
      </div>
    </section>

  </div>

  <noscript>
    <p>Please activate javascript in your browser</p>
  </noscript>

</body>
</html>