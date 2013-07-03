<?php if($hasPages || $invisibleChildren->count() > 0 || $visibleChildren->count() > 0): ?>

  <?php if($invisibleChildren->count() == 0 && $visibleChildren->count() == 0): ?>

  <div class="blank">

    <div class="blank-box">
      <p><strong><?php echo html($page->title()) ?></strong> has no subpages yet.</p>
      <button class="round submit button" data-event="action" data-action="iframe" href="<?php echo module()->pageURL('this', 'pages/add') ?>"><i class="icon plus">✚</i> New page</button>
    </div>

  </div>

  <?php else: ?>

    <div class="columns">

      <div class="column three">
        <h2 class="main-subheadline">
          Sorted 
          <button data-event="action" data-action="iframe" href="<?php echo module()->pageURL('this', 'pages/add') ?>" class="round submit button"><i class="icon plus">✚</i> New</button>
        </h2>
        <?php if($visibleChildren->count()): ?>
        <?php view::snippet('site > pages', array('children' => $visibleChildren, 'pagination' => $visiblePagination)) ?>
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
        <?php view::snippet('site > pages', array('children' => $invisibleChildren, 'pagination' => $invisiblePagination)) ?>
        <?php else: ?>
        <p class="empty"><strong><?php echo html($page->title()) ?></strong> has no unsorted subpages</p>
        <?php endif ?>
      </div>

    </div>

  <?php endif ?>


<?php else: ?>

  <div class="blank">
    <div class="blank-box">
      <h3><?php echo l::get('nopages.title') ?></h3>
      <em class="empty"><?php echo l::get('nopages.text') ?></em>
    </div>
  </div>

<?php endif ?>