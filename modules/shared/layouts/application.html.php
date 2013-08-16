<!DOCTYPE html>
<html lang="en">
<head>

  <?php echo $meta ?>

  <title><?php echo html($title) ?></title>

  <?php

  echo css(array(
    'assets/css/shared/application.css',
    '@auto',
    $css
  ));

  ?>

</head>

<body>

  <header class="header">

    <h1 class="is-hidden">Kirby Panel</h1>

    <nav class="topbar" role="navigation">
      <h1 class="topbar-headline is-hidden">Topbar</h1>

      <div class="topbar-dropdown">

        <a data-event="action" data-action="dropdown" href="#menu-dropdown">
          <i>-</i>
          <i>-</i>
          <i>-</i>
        </a>

        <ul id="menu-dropdown" class="dropdown is-left-aligned">
          <?php foreach($menu as $item): ?>
          <li class="dropdown-item"><a href="<?php echo $item->url() ?>"><?php echo html($item->title()) ?></a></li>
          <?php endforeach ?> 
        </ul>

      </div>

      <figure class="topbar-avatar">

        <a data-event="action" data-action="dropdown" href="#user-dropdown">
          <img src="<?php echo $user->avatar()->url() ?>">
        </a>

        <ul id="user-dropdown" class="dropdown is-right-aligned">
          <li class="dropdown-item"><a href="<?php echo url('users > users::edit', $user->username()) ?>">Your Account</a></li>
          <li class="dropdown-item"><a data-event="action" data-action="iframe" href="<?php echo url('users > picture::upload', $user->username()) ?>">Your Picture</a></li>
          <li class="dropdown-item"><a href="<?php echo url('logout') ?>">Logout</a></li>
        </ul>

      </figure>

    </nav>

    <?php if(!empty($navbar)): ?>
    <nav class="navbar" role="navigation">
      <div class="navbar-inner">
        <?php echo $navbar ?>
      </div>
    </nav>
    <?php endif ?>

  </header>

  <main class="main" role="main">      
  
    <?php if(!empty($sidebar)): ?>
    <nav class="sidebar">
      <?php echo $sidebar ?>
    </nav>
    <?php endif ?>

    <section class="content<?php e(!empty($sidebar), ' with-sidebar') ?><?php e(!empty($metabar), ' with-metabar') ?>">
      <?php echo $content ?>
    </section>

    <?php if(!empty($metabar)): ?>
    <nav class="metabar">
      <?php echo $metabar ?>
    </nav>
    <?php endif ?>

  </main>

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