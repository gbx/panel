<nav class="tabs clear" role="navigation">

  <h1 class="is-hidden">Tabs</h1>

  <ul>
    <?php foreach($tabs as $tab): ?>
    <li class="tab">
      <a href="<?php echo $tab['url'] ?>"<?php e($tab['active'], ' class="is-active"') ?>>
        <?php echo html($tab['title']) ?><?php if(isset($tab['count'])) echo '<small class="tab-count">' . $tab['count'] . '</small>'; ?>
      </a>
    </li>
    <?php endforeach ?>
  </ul>

</nav>