<nav class="breadcrumb clear">

  <h1 class="is-hidden">Breadcrumb</h1>

  <ul>
    <li<?php e(!$breadcrumb->count(), ' class="is-active"') ?>><a href="<?php echo module()->pageURL('site', 'pages') ?>"><?php echo module()->site()->title() ?></a></li>
    <?php foreach($breadcrumb as $item): ?>
    <li<?php e($item->isActive(), ' class="is-active"') ?>><a href="<?php echo module()->pageURL($item, 'pages') ?>"><?php echo html($item->title()) ?></a></li>
    <?php endforeach ?>
  </ul>

</nav>