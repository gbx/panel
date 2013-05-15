<div class="form">

  <h1>Move this page…</h1>
    
  <?php if($page->isHomePage() or $page->isErrorPage()): ?>
  <p>Sorry, but this page cannot be moved.</p>
  <?php endif ?>  

  <?php echo $form ?>

</div>