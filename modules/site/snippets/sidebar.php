<section class="sidebar-section">
  <h1 class="sidebar-section-headline">Site</h1>
  
  <ul>
    <li><a<?php e($active == 'dashboard', ' class="is-active"') ?> href="<?php echo url('site > site::dashboard') ?>">Dashboard</a></li>
    <li><a<?php e($active == 'metatags', ' class="is-active"') ?> href="<?php echo url('site > site::metatags') ?>">Metatags</a></li>
  </ul>

</section>

<section class="sidebar-section">
  <h1 class="sidebar-section-headline">Pages</h1>
  <?php echo $tree ?>
</section>