<div class="form">
  <h1><?php echo l::get('files.delete.title') ?></h1>
  <p>
    Do you really want to delete <strong><?php echo html($file->filename()) ?></strong><br />
    <em>There's no undo!</em>
  </p>
  <?php echo $form ?>
</div>