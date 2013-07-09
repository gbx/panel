<h1 class="navbar-headline is-hidden">Breadcrumb</h1>

<ul class="nav breadcrumb">
  <li class="breadcrumb-item"><a href="<?php echo module()->url() ?>">Site</a></li>
  <?php foreach($breadcrumb as $item): ?>
  <li class="breadcrumb-item<?php e($item->isActive(), ' is-active') ?>"><a href="<?php echo module()->pageURL($item, 'overview') ?>"><?php echo html($item->title()) ?></a></li>
  <?php endforeach ?>
  <li class="breadcrumb-item is-active tabs with-selector">
    <a href="<?php echo module()->pageURL('this', $active) ?>"><?php echo html($tabs[$active]) ?></a>

    <select class="breadcrumb-item-sibling-selector" onchange="window.location.href = this.value">
      <?php foreach($tabs as $uri => $tab): ?>
      <option value="<?php echo module()->pageURL('this', $uri) ?>"<?php e($uri == $active, ' selected="selected"') ?>><?php echo html($tab) ?></option>
      <?php endforeach ?>
    </select>

  </li>

</ul>