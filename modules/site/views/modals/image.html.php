<h1 class="main-headline">Insert image</h1>

<div class="images columns">

  <?php if($page->images()->count()): ?>

  <?php $n=0; foreach($page->images() as $image): $n++; ?>
  <figure data-url="<?php echo $image->filename() ?>" class="column w-two<?php e($n%3 == 0, ' last') ?>">
    <div><span><?php echo thumb($image, array('width' => 100, 'height' => 100)) ?></span></div>
    <figcaption>
      <?php echo html($image->filename()) ?>
    </figcaption>
  </figure>
  <?php endforeach ?>

  <?php else: ?>

  <div class="blank">
    <p class="blank-box">This page has no images so far</p>
  </div>

  <?php endif ?>

</div>

<?php echo $form ?>
