<!DOCTYPE html>
<html lang="en">
<head>

  <?php view::snippet('shared > meta') ?>

  <title><?php echo html($title) ?></title>

  <?php

  // css
  echo assets::css('shared > assets/css/application.css');  
  echo assets::css('auto');  
  echo assets::css(@$css);  

  // js
  echo assets::js(array(
    'shared > assets/js/jquery.js',
    'shared > assets/js/jquery.ui.js',
    'shared > assets/js/jquery.autosize.js',
    'shared > assets/js/jquery.customSelect.js',
    'shared > assets/js/application.js',
  ));  

  echo assets::js('auto');
  echo assets::js(@$js);

  ?>

</head>

<body>

  <header class="header">

    <h1 class="is-hidden">Kirby Panel</h1>

    <nav class="topbar" role="navigation">
      <h1 class="topbar-headline is-hidden">Topbar</h1>

      <figure class="topbar-avatar">

        <a data-event="action" data-action="dropdown" href="#user-dropdown">
          <img src="<?php echo app()->user()->avatar()->url() ?>">
        </a>

        <ul id="user-dropdown" class="dropdown is-left-aligned">
          <li class="dropdown-item"><a data-event="action" data-action="iframe" href="<?php echo app()->url('users/' . app()->user()->username() . '/edit') ?>">Your Account</a></li>
          <li class="dropdown-item"><a data-event="action" data-action="iframe" href="<?php echo app()->url('users/' . app()->user()->username() . '/picture/upload') ?>">Your Picture</a></li>
          <li class="dropdown-item"><a href="<?php echo app()->url('logout') ?>">Logout</a></li>
        </ul>

      </figure>

      <div class="topbar-dropdown">

        <a data-event="action" data-action="dropdown" href="#menu-dropdown">
          <i>-</i>
          <i>-</i>
          <i>-</i>
        </a>

        <ul id="menu-dropdown" class="dropdown">
          <?php foreach(app()->moduleList() as $module): ?>
          <li class="dropdown-item<?php e($module->isActive(), ' is-active') ?>"><a href="<?php echo $module->url() ?>"><?php echo html($module->title()) ?></a></li>
          <?php endforeach ?> 
        </ul>

      </div>

    </nav>

    <?php if(isset($navbar) && !empty($navbar)): ?>
    <nav class="navbar" role="navigation">
      <div class="navbar-inner">
        <?php echo $navbar ?>
      </div>
    </nav>
    <?php endif ?>

  </header>

  <main class="main" role="main">      

    <?php if(isset($sidebar)): ?>
    <nav class="sidebar" role="navigation">      
    <?php echo $sidebar ?>
    </nav>

    <?php endif ?>
    <section class="content<?php e(isset($sidebar), ' with-sidebar') ?>">
    <?php echo $content ?>
    </section>
  </main>

  <noscript>
    <p>Please activate javascript in your browser</p>
  </noscript>

</body>
</html>