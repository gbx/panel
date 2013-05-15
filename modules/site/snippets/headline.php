<div class="main-headline-container<?php e($back, ' has-back-button') ?><?php e($options, ' has-options') ?>">
  <?php if($back): ?>
  <a class="back" title="<?php echo html($back['title']) ?>" href="<?php echo $back['url'] ?>">&lsaquo;</a>
  <?php endif ?>
  <h1 class="main-headline"><a href="<?php echo html($url) ?>"><?php echo html($text) ?></a></h1>

  <?php if($options): ?>
  <nav class="options" role="navigation">
  
    <h1 class="options-headline is-hidden">Options headline</h1>

    <a data-event="action" data-action="dropdown" class="toggle" href="#page-options">Options</a>

    <ul id="page-options" class="dropdown">
      <li><a target="_blank" href="<?php echo $page->url() ?>">Preview</a></li>
      <li><a data-event="action" data-action="iframe" href="<?php echo module()->pageURL($page, 'pages/url') ?>">URL</a></li>
      <li><a data-event="action" data-action="iframe" href="<?php echo module()->pageURL($page, 'pages/delete') ?>">Delete</a></li>
    </ul>

  </nav>
  <?php endif ?>

</div>
