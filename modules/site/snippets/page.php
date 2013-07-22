<li>
  <article class="item page<?php e($child->isErrorPage(), ' is-error'); e($child->isHomePage(), ' is-home') ?>">

    <div data-event="action" data-action="go" href="<?php echo module()->pageURL($child, 'overview') ?>" class="page-num"><?php e($child->num() == '', '—', $child->num()) ?></div>

    <div class="item-info page-info">
      <h1><a href="<?php echo module()->pageURL($child, 'overview') ?>" class="item-headline page-headline"><?php echo html($child->title()) ?></a></h1>
      <p><a href="<?php echo module()->pageURL($child, 'overview') ?>" class="item-subheadline page-subheadline"><?php echo html($child->uri()) ?></a></p>
    </div>

    <nav class="item-options page-options" role="navigation">
      <h1 class="is-hidden">Page Options</h1>
      <a class="toggle" href="#page-options-<?php echo $child->uid() ?>" data-event="action" data-action="dropdown">Toggle Options</a>
      <ul id="page-options-<?php echo $child->uid() ?>" class="dropdown">
        <!--<li><a data-event="action" data-action="iframe" href="<?php echo module()->pageURL($child, 'pages/move') ?>">Move to…</a></li>-->
        <!--<li><a data-event="action" data-action="iframe" href="<?php echo module()->pageURL($child, 'pages/template') ?>">Template</a></li>-->
        <li class="dropdown-item"><a target="_blank" href="<?php echo $child->url() ?>">Preview</a></li>
        <li class="dropdown-item"><a data-event="action" data-action="iframe" href="<?php echo module()->pageURL($child, 'pages/url') ?>">Change URL</a></li>
        <li class="dropdown-item"><a data-event="action" data-action="iframe" href="<?php echo module()->pageURL($child, 'pages/delete') ?>">Delete page</a></li>
      </ul>
    </nav>

  </article>
</li>
