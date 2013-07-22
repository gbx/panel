<h1 class="main-headline is-hidden">Overview</h1>

<?php if($subpages): ?>
<?php echo $subpages ?>
<hr />
<?php endif ?>

<h2 class="beta">
  <a href="<?php echo module()->pageURL($page, 'content') ?>">Meta</a>
</h2>

<div class="page-overview-info columns">
  <ul>
    <?php foreach($page->content()->data() as $key => $value): ?>
    <li class="column three<?php e(@$x++%2, ' last') ?>">
      <a href="<?php echo module()->pageURL($page, 'content') ?>">
        <strong><?php echo str::ucfirst($key) ?>:</strong>
        <small><?php echo str::short(html(str::unhtml($value)), 140) ?></small>
      </a>
    </li>
    <?php endforeach ?>
  </ul>
</div>