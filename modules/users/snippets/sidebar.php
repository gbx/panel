<section class="sidebar-section">
  <h1 class="sidebar-section-headline">Groups</h1>
  
  <ul>
    <?php foreach($groups as $group): ?>
    <li><a<?php e($group['active'], ' class="is-active"') ?> href="<?php echo html($group['url']) ?>"><?php echo html($group['name']) ?></a></li>
    <?php endforeach ?>
  </ul>

</section>