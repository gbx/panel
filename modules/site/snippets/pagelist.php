<ul class="pages items clear">

  <?php $n=0; foreach($children as $child): $n++; ?>
  <?php view::snippet('site > page', array('child' => $child)) ?>
  <?php endforeach ?>

</ul>

<?php if(isset($pagination)): ?>
<?php if($pagination->pages() > 0): ?>
<nav role="navigation" class="pagination clear">

  <h1 class="is-hidden">Pagination</h1>

  <ul>
    <?php if($pagination->hasPrevPage()): ?>
    <li class="prev"><a href="<?php echo $pagination->prevPageURL() ?>" rel="prev">&lsaquo;</a></li>
    <?php else: ?>
    <li class="prev"><span>&lsaquo;</span></li>
    <?php endif ?>

    <?php if($pagination->hasNextPage()): ?>
    <li class="next"><a href="<?php echo $pagination->nextPageURL() ?>" rel="next">&rsaquo;</a></li>
    <?php else: ?>
    <li class="next"><span>&rsaquo;</span></li>
    <?php endif ?>
  </ul>

</nav>
<?php endif ?>
<?php endif ?>