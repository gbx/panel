<?php if($hasFiles): ?>

  <h1 class="main-headline is-hidden">Files</h1>

  <?php if(!$files->count()): ?>

  <div class="blank">

    <div class="blank-box">
      <p><strong><?php echo html($page->title()) ?></strong> has no files yet.</p>
      <button class="round button submit" data-event="action" data-action="iframe" href="<?php echo module()->pageURL('this','files/upload') ?>"><i class="icon plus">✚</i> Upload</button>
    </div>

  </div>

  <?php else: ?>

  <h2 class="beta">
    Files
  </h2>

  <?php view::snippet('site > files', array('files' => $files)) ?>

  <?php endif ?>

<?php else: ?>

  <div class="blank">
    <div class="blank-box">
      <h3><?php echo l::get('nofiles.title') ?></h3>
      <em class="empty"><?php echo l::get('nofiles.text') ?></em>
    </div>
  </div>

<?php endif ?>