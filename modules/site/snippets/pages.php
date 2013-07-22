<div class="columns">

  <div class="column three">
    <h2 class="beta">Visible pages</h2>
    <?php if($visibleChildren->count()): ?>
    <?php view::snippet('site > pagelist', array('children' => $visibleChildren, 'pagination' => $visiblePagination)) ?>
    <?php else: ?>
    <p class="empty">This page has no sorted subpages</p>
    <?php endif ?>
  </div>

  <div class="column three last">
    <h2 class="beta">Invisible pages</h2>
    <?php if($invisibleChildren->count()): ?>
    <?php view::snippet('site > pagelist', array('children' => $invisibleChildren, 'pagination' => $invisiblePagination)) ?>
    <?php else: ?>
    <p class="empty">This page has no unsorted subpages</p>
    <?php endif ?>
  </div>

</div>