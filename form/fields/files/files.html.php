<section class="items with-large-previews">

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

  <?php foreach($this->items() as $item): ?>
  <article class="item">
    <?php if($item->type() == 'image'): ?>
    <figure class="item-preview" style="background: url('<?php echo $item->url() ?>'); background-size: cover">
      <a href=""></a>
    </figure>
    <?php endif ?>

    <header class="item-info">
      <h1 class="item-title"><a href=""><?php echo html($item->filename()) ?></a></h1>    
      <h2 class="item-subtitle"><a href=""><?php echo html($item->type()) ?></a></h2>    
    </header>
    
    <nav class="item-options">
      <h1 class="is-invisible">Item options</h1>
      <a class="item-options-toggle" href="">Options</a>
    </nav>
  </article>
  <?php endforeach ?>

</section>