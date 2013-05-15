<div class="form">
  <h1>Delete the picture for <?php echo html($user->username()) ?></h1>

  <p>
    Do you really want to delete the picture for <strong><?php echo html($user->username()) ?></strong><br />
    <em>There's no undo!</em>
  </p>

  <?php echo $form ?>
</div>

