<div class="form">

  <h1>Change the URL…</h1>

  <?php if($page->isHomePage() or $page->isErrorPage()): ?>
  <p>Sorry, but the URL for this page cannot be changed.</p>
  <?php endif ?>  

  <?php echo $form ?>

</div>