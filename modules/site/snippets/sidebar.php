<h1 class="sidebar-headline is-hidden">Sidebar</h1>

<!--
<section class="sidebar-info">

  <?php if($page->isSite()): ?>
  <h1><a href="<?php echo module()->url() ?>">Your Site</a></h1>
  <?php else: ?>
  <h1><a href="<?php echo module()->pageURL($page, 'overview') ?>"><?php echo widont(html($page->title())) ?></a></h1>
  <?php endif ?>
  <h2><a href="<?php echo $page->url() ?>" target="_blank"><?php echo url::short($page->url()) ?></a><h2>

</section>
-->

<ul class="sidebar-items has-no-bullets">

  <?php if($page->isSite()): ?>

  <li class="sidebar-item<?php e($active == 'overview', ' is-active') ?>"><a href="<?php echo module()->pageURL($page, 'overview') ?>">Overview</a></li>
  <li class="sidebar-item<?php e($active == 'content', ' is-active') ?>"><a href="<?php echo module()->pageURL($page, 'content') ?>">Info</a></li>
  <li class="sidebar-item<?php e($active == 'pages',   ' is-active') ?>"><a href="<?php echo module()->pageURL($page, 'pages') ?>">Pages <small class="sidebar-item-count"><?php echo $children->count() ?></small></a></li>
  <li class="sidebar-item<?php e($active == 'files',   ' is-active') ?>"><a href="<?php echo module()->pageURL($page, 'files') ?>">Global files <small class="sidebar-item-count"><?php echo $files->count() ?></small></a></li>

  <?php else: ?>

  <li class="sidebar-item<?php e($active == 'overview', ' is-active') ?>"><a href="<?php echo module()->pageURL($page, 'overview') ?>">Overview</a></li>
  <li class="sidebar-item<?php e($active == 'content',  ' is-active') ?>"><a href="<?php echo module()->pageURL($page, 'content') ?>">Content</a></li>
  <li class="sidebar-item<?php e($active == 'pages',    ' is-active') ?>"><a href="<?php echo module()->pageURL($page, 'pages') ?>">Subpages <small class="sidebar-item-count"><?php echo $children->count() ?></small></a></li>
  <li class="sidebar-item<?php e($active == 'files',    ' is-active') ?>"><a href="<?php echo module()->pageURL($page, 'files') ?>">Files <small class="sidebar-item-count"><?php echo $files->count() ?></small></a></li>

  <?php endif ?>

</ul>
