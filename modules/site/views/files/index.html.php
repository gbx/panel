<?php if($hasFiles): ?>

  <h1 class="is-hidden">Files</h1>

  <?php if(!$files->count()): ?>

  <div class="blank">

    <div class="blank-box">
      <p><strong><?php echo html($page->title()) ?></strong> has no files yet.</p>
      <button class="round button" data-event="action" data-action="iframe" href="<?php echo module()->pageURL('this','files/upload') ?>">+ Upload</button>
    </div>

  </div>

  <?php else: ?>

  <ul class="items assets clear">

    <?php $n=0; foreach($files as $file): $n++; ?>
    <li>
      <article class="item asset">

        <figure class="asset-preview">
          <?php if($file->type() == 'image'): ?>
          <a rel="zoom" href="<?php echo $file->url() ?>" target="_blank"><img src="<?php echo PanelThumb($file, array('width' => 120, 'height' => 120), false) ?>" alt="<?php echo html($file->title()) ?>" /></a>
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
          <ul id="asset-options-<?php echo $n ?>" class="dropdown">
            <li><a data-event="action" data-action="iframe" href="<?php echo module()->fileURL($file, 'edit') ?>">Edit File</a></li>
            <li><a data-event="action" data-action="iframe" href="<?php echo module()->fileURL($file, 'replace') ?>">Replace File</a></li>
            <li><a data-event="action" data-action="iframe" href="<?php echo module()->fileURL($file, 'delete') ?>">Delete File</a></li>
          </ul>
        </nav>

      </article>
    </li>
    <?php endforeach ?>

  </ul>

  <nav role="navigation" class="editbar">

    <h1 class="is-hidden">Edit-Bar</h1>

    <div class="editbar-content">
    
      <div class="editbar-content-left">
        <button data-event="action" data-action="iframe" href="<?php echo module()->pageURL('this', 'files/upload') ?>" class="round button">+ Upload</button>
      </div>
      <div class="editbar-content-right">
        <!--<button class="round button">Sort</button>-->
      </div>
    </div>

  </nav>

  <?php endif ?>

<?php else: ?>

  <div class="blank">
    <div class="blank-box">
      <h3><?php echo l::get('nofiles.title') ?></h3>
      <em class="empty"><?php echo l::get('nofiles.text') ?></em>
    </div>
  </div>

<?php endif ?>