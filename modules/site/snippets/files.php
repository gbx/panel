<ul class="items assets columns">

  <?php $n=0; foreach($files as $file): $n++; ?>
  <li class="column three<?php e($n%2 == 0, ' last') ?>">
    <article class="item asset">

      <figure class="asset-preview">
        <?php if($file->type() == 'image'): ?>
        <a rel="zoom" href="<?php echo $file->url() ?>" target="_blank"><img src="<?php echo thumb($file, array('width' => 120, 'height' => 120))->url() ?>" alt="<?php echo html($file->title()) ?>" /></a>
        <?php else: ?>
        <a href="<?php echo $file->url() ?>" target="_blank"><small><?php echo $file->extension() ?></small></a>
        <?php endif ?>
      </figure>

      <div class="item-info asset-info is-centered">
        <h1><a class="item-headline asset-headline" tabindex="-1" target="_blank" href="<?php echo $file->url() ?>"><?php echo $file->filename() ?></a></h1>
        <h2><a class="item-subheadline asset-subheadline" tabindex="-1" target="_blank" href="<?php echo $file->url() ?>"><?php echo $file->niceSize() ?></a></h2>
      </div>

      <nav class="item-options asset-options" role="navigation">
        <h1 class="is-hidden">Asset Options</h1>
        <a class="toggle" href="#asset-options-<?php echo $n ?>" data-event="action" data-action="dropdown">Toggle Options</a>
        <ul id="asset-options-<?php echo $n ?>" class="dropdown has-no-bullets">
          <li class="dropdown-item"><a data-event="action" data-action="iframe" href="<?php echo module()->fileURL($file, 'edit') ?>">Edit File</a></li>
          <li class="dropdown-item"><a data-event="action" data-action="iframe" href="<?php echo module()->fileURL($file, 'replace') ?>">Replace File</a></li>
          <li class="dropdown-item"><a data-event="action" data-action="iframe" href="<?php echo module()->fileURL($file, 'delete') ?>">Delete File</a></li>
        </ul>
      </nav>

    </article>
  </li>
  <?php endforeach ?>

</ul>
