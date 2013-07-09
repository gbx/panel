<h1 class="main-headline is-hidden">Overview</h1>

<?php if($subpages): ?>
<?php echo $subpages ?>
<hr />
<?php endif ?>

<h2 class="main-subheadline">
  <a href="<?php echo module()->pageURL($page, 'content') ?>">Meta</a>
</h2>

<ul class="page-overview-items columns">
  <?php foreach($page->content()->data() as $key => $value): ?>
  <li class="page-overview-item column three<?php e(@$x++%2, ' last') ?>">
    <a href="<?php echo module()->pageURL($page, 'content') ?>"><strong><?php echo str::ucfirst($key) ?>:</strong>
    <?php echo str::short(html(str::unhtml($value)), 140) ?></a>
  </li>
  <?php endforeach ?>
</ul>
