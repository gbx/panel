<?php if($hasPages || $children->count() > 0): ?>

  <?php if($children->count() == 0): ?>

  <div class="blank">

    <div class="blank-box">
      <p><strong><?php echo html($page->title()) ?></strong> has no subpages yet.</p>
      <button class="round button" data-event="action" data-action="iframe" href="<?php echo module()->pageURL('this', 'pages/add') ?>">+ New page</button>
    </div>

  </div>

  <?php else: ?>

  <ul class="pages items clear">

    <?php $n=0; foreach($children as $child): $n++; ?>
    <?php $model = new PageModel($child) ?>
    <li>
      <article class="item page<?php e($child->isErrorPage(), ' is-error'); e($child->isHomePage(), ' is-home') ?>">

        <?php if($cover = $model->cover()): ?>
        <div data-event="action" data-action="go" href="<?php echo module()->pageURL($child, 'pages') ?>" class="page-num has-thumb" style="background: url(<?php echo PanelThumb($cover, array('width' => 100, 'height' => 100, 'crop' => true), false) ?>); background-size: cover"><span><?php e($child->num() == '', '—', $child->num()) ?></span></div>
        <?php else: ?>
        <div data-event="action" data-action="go" href="<?php echo module()->pageURL($child, 'pages') ?>" class="page-num"><?php e($child->num() == '', '—', $child->num()) ?></div>
        <?php endif ?>

        <div class="item-info page-info">
          <h1><a href="<?php echo module()->pageURL($child, 'pages') ?>" class="item-headline page-headline"><?php echo html($child->title()) ?></a></h1>
          <!--<p><a href="<?php echo module()->pageURL($child, 'pages') ?>" class="item-subheadline page-subheadline"><?php echo html($child->uri()) ?></a></p>-->
        </div>

        <div class="page-tabs">
          <ul>
            <li><a href="<?php echo module()->pageURL($child, 'pages') ?>">Pages <small><?php echo $child->children()->count() ?></small></a></li>
            <li><a href="<?php echo module()->pageURL($child, 'content') ?>">Text</a></li>
            <li><a href="<?php echo module()->pageURL($child, 'files') ?>">Files <small><?php echo $child->files()->filterBy('type', '!=', 'content')->count() ?></small></a></li>
          </ul>
        </div>

        <nav class="item-options page-options" role="navigation">
          <h1 class="is-hidden">Page Options</h1>
          <a class="toggle" href="#page-options-<?php echo $n ?>" data-event="action" data-action="dropdown">Toggle Options</a>
          <div id="page-options-<?php echo $n ?>" class="dropdown">
            <ul>
              <!--<li><a data-event="action" data-action="iframe" href="<?php echo module()->pageURL($child, 'pages/move') ?>">Move to…</a></li>-->
              <!--<li><a data-event="action" data-action="iframe" href="<?php echo module()->pageURL($child, 'pages/template') ?>">Template</a></li>-->
              <li><a target="_blank" href="<?php echo $child->url() ?>">Preview</a></li>
              <li><a data-event="action" data-action="iframe" href="<?php echo module()->pageURL($child, 'pages/url') ?>">URL</a></li>
              <li><a data-event="action" data-action="iframe" href="<?php echo module()->pageURL($child, 'pages/delete') ?>">Delete</a></li>
            </ul>
          </div>
        </nav>

      </article>
    </li>
    <?php endforeach ?>

  </ul>

  <?php if($hasPages): ?>
  <nav role="navigation" class="editbar">

    <h1 class="is-hidden">Edit-Bar</h1>

    <div class="editbar-content">
    
      <div class="editbar-content-left">
        <button data-event="action" data-action="iframe" href="<?php echo module()->pageURL('this', 'pages/add') ?>" class="round button">+ New Page</button>
      </div>
      <div class="editbar-content-right">
        <!--<button class="round button">Sort</button>-->
      </div>
    </div>

  </nav>
  <?php endif ?>

  <?php endif ?>

<?php else: ?>

  <div class="blank">
    <div class="blank-box">
      <h3><?php echo l::get('nopages.title') ?></h3>
      <em class="empty"><?php echo l::get('nopages.text') ?></em>
    </div>
  </div>

<?php endif ?>