<?php if($hasContent && $hasBlueprint): ?>

<div class="form">    
  <h1 class="form-headline is-hidden">Form</h1>
  <?php echo $alert ?>
  <?php echo $form ?>      
</div>

<?php elseif($hasContent): ?>

<div class="blank">
  <div class="blank-box">
    <h3>Missing blueprint</h3>
    
    <p><em>There's no <strong><?php echo $page->intendedTemplate() ?>.php</strong> blueprint for this page yet</em></p>

  </div>
</div>

<?php else: ?>

<div class="blank">
  <div class="blank-box">
    <h3><?php echo l::get('nocontent.title') ?></h3>
    <em class="empty"><?php echo l::get('nocontent.text') ?></em>
  </div>
</div>

<?php endif ?>