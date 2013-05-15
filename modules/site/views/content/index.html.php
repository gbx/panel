<?php if($hasContent): ?>

<div class="form">    
  <h1 class="form-headline is-hidden">Form</h1>
  <?php echo $alert ?>
  <?php echo $form ?>      
</div>

<?php else: ?>

<div class="blank">
  <div class="blank-box">
    <h3><?php echo l::get('nocontent.title') ?></h3>
    <em class="empty"><?php echo l::get('nocontent.text') ?></em>
  </div>
</div>

<?php endif ?>