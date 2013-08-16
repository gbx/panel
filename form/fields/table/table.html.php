<section class="items<?php e($this->attribute('previews'), ' with-small-previews'); ?>">

  <header class="items-header">
    <h1 class="items-headline">
      <a href="#dropdown"><?php echo html($this->attribute('label')) ?></a>
    </h1>

    <?php if($this->items()->pagination()->hasPages()): ?>
    <nav class="items-pagination">
      <?php if($this->items()->pagination()->hasPrevPage()): ?>
      <a href="<?php echo $this->items()->pagination()->prevPageURL() ?>" class="prev">previous</a>
      <?php endif ?>
      <?php if($this->items()->pagination()->hasNextPage()): ?>
      <a href="<?php echo $this->items()->pagination()->nextPageURL() ?>" class="next">next</a>
      <?php endif ?>
    </nav>
    <?php endif ?>

  </header>

  <?php if(!$this->items()->count()): ?>
  
  <a href="#" class="empty">Add…</a>

  <?php else: ?>

  <?php foreach($this->items() as $item): ?>
  <article class="item">
  
    <?php if($preview = $this->preview($item)): ?>
    <figure class="item-preview">
      <a href=""><img src="<?php echo $preview ?>" /></a>
    </figure>
    <?php endif ?>

    <header class="item-info">
      <h1 class="item-title"><a href="<?php echo url('page/update/' . $item->uri()) ?>"><?php echo html($item->title()) ?></a></h1>    
      <h2 class="item-subtitle"><a href="<?php echo url('page/update/' . $item->uri()) ?>"><?php echo html($item->uri()) ?></a></h2>    
    </header>
    
    <nav class="item-options">
      <h1 class="is-invisible">Item options</h1>
      <a data-event="action" data-action="dropdown" class="item-options-toggle" href="#item-<?php echo $item->id() ?>-options">Options</a>

      <ul class="dropdown" id="item-<?php echo $item->id() ?>-options">
        <li class="dropdown-item"><a target="_blank" href="<?php echo $item->url() ?>">Preview</a></li>
        <li class="dropdown-item"><a data-event="action" data-action="iframe" href="<?php echo url('site > page::url', array('uri' => $item->uri())) ?>">Change URL…</a></li>
        <li class="dropdown-item"><a data-event="action" data-action="iframe" href="<?php echo url('site > page::template', array('uri' => $item->uri())) ?>">Change Template…</a></li>
        <li class="dropdown-item"><a data-event="action" data-action="iframe" href="<?php echo url('site > page::delete', array('uri' => $item->uri())) ?>">Delete</a></li>
      </ul>
    </nav>
  </article>
  <?php endforeach ?>
  <?php endif ?>

</section>