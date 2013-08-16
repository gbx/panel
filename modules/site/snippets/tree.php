<ul>
  <?php foreach($subpages AS $p): ?>
  <?php $blueprint = new Blueprint($p); ?>
  <li class="depth-<?php echo $p->depth() ?>">
    <a<?php echo (!$active and ($p->isActive() or ($blueprint->subpages() == false and $p->isOpen()))) ? ' class="is-active"' : '' ?> href="<?php echo url() . '/page/update/' . $p->uri() ?>"><small><?php e($p->num(), $p->num(), '-') ?></small> <?php echo $p->title() ?></a>
    <?php if($blueprint->subpages() != false and $p->hasChildren() and $p->isOpen()): ?>
    <?php echo new Snippet('site > tree', array('subpages' => $p->children(), 'active' => $active)) ?>
    <?php endif ?>
  </li>
  <?php endforeach ?>
</ul>