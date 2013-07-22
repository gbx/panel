<h1 class="main-headline is-hidden">Overview</h1>

<div class="columns page-overview-info">

  <div class="column three">

    <h2 class="beta">
      <a href="<?php echo module()->pageURL($page, 'content') ?>">Content</a>
    </h2>

    <?php if($page->content()): ?>
    <ul>
      <?php foreach($page->content()->data() as $key => $value): ?>
      <li>
        <a href="<?php echo module()->pageURL($page, 'content') ?>"><strong><?php echo str::ucfirst($key) ?>:</strong>
        <small><?php echo str::short(html(str::unhtml($value)), 140) ?></a></small>
      </li>
      <?php endforeach ?>
    </ul>
    <?php else: ?>
    <p class="empty">There's no content for this page available</p>
    <?php endif ?>
  </div>

  <div class="column three last">

    <h2 class="beta">Info</h2>

    <ul>
      <li>
        <a href="<?php echo $page->url() ?>"><strong>Link:</strong> <small><?php echo url::short($page->url()) ?></small></a>
      </li>
      <li>
        <strong>Template:</strong>
        <small><?php echo html($page->template()) ?></small>
      </li>
      <li>
        <strong>Modified:</strong>
        <small><?php echo date('d.m.Y H:i', $page->modified()) ?></small>
      </li>
    </ul>

  </div>
</div>

<div class="columns">

  <div class="column three">
    <h2 class="beta">
      <a href="<?php echo module()->pageURL($page, 'pages') ?>">Pages</a>
    </h2>

    <?php view::snippet('site > pagelist', array('children' => $page->children()->limit(10))) ?>

  </div>

  <div class="column three last">
    <h2 class="beta">
      <a href="<?php echo module()->pageURL($page, 'files') ?>">Files</a>
    </h2>

  </div>

</div>
