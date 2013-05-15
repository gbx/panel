<ul class="radio">
  <?php foreach($this->option('options') AS $key => $text): ?>
  <li>
    <label class="inline input">
      <?php echo PanelForm::radio($this->name(), $key, $key == $this->value()) ?>
      <?php echo html($text) ?>
    </label>
  </li>
  <?php endforeach ?>
</ul>
