<h1 class="navbar-headline is-hidden">Breadcrumb</h1>

<ul class="breadcrumb has-no-bullets is-floating">
  <li class="breadcrumb-item"><a href="<?php echo module()->url() ?>">Site</a></li>
  <?php foreach($breadcrumb as $item): ?>

    <?php if($item->isActive()): ?>
    <li class="breadcrumb-item is-active<?php e($item->siblings()->count(), ' with-selector') ?>">
      <a href="<?php echo module()->pageURL($item, 'overview') ?>"><?php echo html($item->title()) ?></a>

      <?php if($item->siblings()->count()): ?>
      <select class="breadcrumb-item-sibling-selector" onchange="window.location.href = this.value">
        <?php foreach($item->siblings() as $sibling): ?>
        <option value="<?php echo module()->pageURL($sibling, 'overview') ?>" <?php e($sibling->is($item), ' selected="selected"') ?>><?php echo html($sibling->title()) ?></option>
        <?php endforeach ?>
      </select>
      <?php endif ?>

    </li>    
    <?php else: ?>
    <li class="breadcrumb-item"><a href="<?php echo module()->pageURL($item, 'overview') ?>"><?php echo html($item->title()) ?></a></li>
    <?php endif ?>

  <?php endforeach ?>
</ul>