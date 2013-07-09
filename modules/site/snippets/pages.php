<div class="columns">

  <div class="column three">
    <h2 class="main-subheadline">
      Sorted 
      <button data-event="action" data-action="iframe" href="<?php echo module()->pageURL('this', 'pages/add') ?>" class="round submit button"><i class="icon plus">✚</i> New</button>
    </h2>
    <?php if($visibleChildren->count()): ?>
    <?php view::snippet('site > pagelist', array('children' => $visibleChildren, 'pagination' => $visiblePagination)) ?>
    <?php else: ?>
    <p class="empty"><strong><?php echo html($page->title()) ?></strong> has no sorted subpages</p>
    <?php endif ?>
  </div>

  <div class="column three last">
    <h2 class="main-subheadline">
      Unsorted
      <button data-event="action" data-action="iframe" href="<?php echo module()->pageURL('this', 'pages/add') ?>" class="round submit button"><i class="icon plus">✚</i> New</button>
    </h2>
    <?php if($invisibleChildren->count()): ?>
    <?php view::snippet('site > pagelist', array('children' => $invisibleChildren, 'pagination' => $invisiblePagination)) ?>
    <?php else: ?>
    <p class="empty"><strong><?php echo html($page->title()) ?></strong> has no unsorted subpages</p>
    <?php endif ?>
  </div>

</div>