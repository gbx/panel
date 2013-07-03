<h1 class="main-headline is-hidden">Overview</h1>

<?php if(!$page->isSite()): ?>
<h2 class="main-subheadline">Path</h2>

<ul class="page-overview-item breadcrumb has-no-bullets is-floating">
  <li class="breadcrumb-item"><a href="<?php echo module()->url() ?>">Site</a></li>
  <?php foreach($breadcrumb as $item): ?>
  <li class="breadcrumb-item<?php e($item->isActive(), ' is-active') ?>"><a href="<?php echo module()->pageURL($item, 'overview') ?>"><?php echo html($item->title()) ?></a></li>
  <?php endforeach ?>
</ul>  

<hr />
<?php endif ?>

<h2 class="main-subheadline">
  <a href="<?php echo module()->pageURL($page, 'content') ?>">Content</a>
</h2>

<ul class="page-overview-items columns">
  <?php foreach($page->content()->data() as $key => $value): ?>
  <li class="page-overview-item column three<?php e(@$x++%2, ' last') ?>">
    <a href="<?php echo module()->pageURL($page, 'content') ?>"><strong><?php echo str::ucfirst($key) ?>:</strong>
    <?php echo str::short(html(str::unhtml($value)), 140) ?></a>
  </li>
  <?php endforeach ?>
</ul>

<hr />

<h2 class="main-subheadline">
  <a href="<?php echo module()->pageURL($page, 'pages') ?>">
    Subpages 
    <small class="round button count">
      <?php echo $children->count() ?><?php e($children->count() < $children->pagination()->items(), ' of ' . $children->pagination()->items()) ?>
    </small>
  </a>
</h2>
<?php view::snippet('site > pages', array('children' => $children, 'pagination' => $pagination)) ?>

<?php if($children->count()): ?>
<p class="more"><a href="<?php echo module()->pageURL($page, 'pages') ?>">Show all subpages…</a></p>
<?php else: ?>
<p class="empty">This page has no subpages yet <button class="round button submit"><i class="icon plus">✚</i> New page</button></p>
<?php endif ?>
<hr />

<h2 class="main-subheadline">
  <a href="<?php echo module()->pageURL($page, 'files') ?>">
    Files
    <small class="round button count">
      <?php echo $files->count() ?><?php e($files->count() < $files->pagination()->items(), ' of ' . $files->pagination()->items()) ?>
    </small>
  </a>
</h2>
<?php view::snippet('site > files', array('files' => $files)) ?>

<?php if($files->count()): ?>
<p class="more"><a href="<?php echo module()->pageURL($page, 'files') ?>">Show all files…</a></p>
<?php else: ?>
<p class="empty">This page has no files yet <button class="round button submit"><i class="icon plus">✚</i> Upload file</button></p>
<?php endif ?>

<hr />

<h2 class="main-subheadline">Info</h2>

<ul class="page-overview-items columns">
  <li class="page-overview-item column three">
    <a href="<?php echo $page->url() ?>"><strong>Link:</strong> <?php echo url::short($page->url()) ?></a>
  </li>
  <li class="page-overview-item column three last">
    <strong>Template:</strong>
    <?php echo html($page->template()) ?>
  </li>
  <li class="page-overview-item column three">
    <strong>Modified:</strong>
    <?php echo date('d.m.Y H:i', $page->modified()) ?>
  </li>
  <li class="page-overview-item column three last">
    <strong>Sort:</strong>
    <?php e($page->num() != '', $page->num(), 'unsorted') ?>
  </li>
</ul>
