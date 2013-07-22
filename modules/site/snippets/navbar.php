<?php if(!$page->isSite()): ?>
  <ul class="nav breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo module()->url() ?>">Your site</a></li>
    <?php foreach($breadcrumb as $item): ?>
    <li class="breadcrumb-item<?php e($item->isActive(), ' is-active') ?>"><a href="<?php echo module()->pageURL($item, 'overview') ?>"><?php echo html($item->title()) ?></a></li>
    <?php endforeach ?>
  </ul>
<?php endif ?>

<header>

  <h1 class="alpha">
    <a data-event="action" data-action="dropdown" href="#page-dropdown"><?php echo html($headline) ?><?php if($active != 'overview'): ?>: <small><?php echo $tabs[$active] ?></small><?php endif ?></a>
  </h1>

  <ul class="dropdown is-left-aligned" id="page-dropdown">
    <?php foreach($tabs as $uri => $tab): ?>
    <li class="dropdown-item<?php e($uri == $active, ' is-active') ?>"><a href="<?php echo module()->pageURL('this', $uri) ?>"><?php echo html($tab) ?></a></li>
    <?php endforeach ?>
  </ul>

</header>

<section class="navbar-options">
  <?php if($active == 'files'): ?>
  <button data-event="action" data-action="iframe" href="<?php echo module()->pageURL('this', 'files/upload') ?>" class="round button submit"><i class="icon plus">✚</i> Upload file</button>  
  <?php elseif($active == 'pages'): ?>
  <button data-event="action" data-action="iframe" href="<?php echo module()->pageURL('this', 'pages/add') ?>" class="round button submit"><i class="icon plus">✚</i> Add page</button>  
  <?php endif ?>
</section>
