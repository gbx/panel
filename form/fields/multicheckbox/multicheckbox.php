<ul>
  <?php foreach($this->option('options') AS $key => $text): ?>
  <li>
    <label class="inline input">
      <?php echo form::checkbox($this->name(), $key == $this->value()) ?>
      <?php echo html($text) ?>
    </label>
  </li>
  <?php endforeach ?>
</ul>