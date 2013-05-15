<div class="form">
  <h1>Delete this page</h1>

  <?php if($page->isErrorPage()): ?>
  <p>
    So sorry, but the <strong>error page</strong> cannot be deleted.
  </p>    
  <?php elseif($page->isHomePage()): ?>
  <p>
    So sorry, but the <strong>home page</strong> cannot be deleted.
  </p>  
  <?php else: ?>
  <p>
    Do you really want to delete <strong><?php echo html($page->title()) ?></strong><br />
    <em>There's no undo!</em>
  </p>
  <?php endif ?>
  <?php echo $form ?>

</div>