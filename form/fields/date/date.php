<?php 

echo PanelForm::text(
  $this->name(),
  $this->value(),
  $this->attr(array(
    'data-format'   => $this->option('format', 'yy-mm-dd'),
    'data-language' => panel()->user()->language(),
  ))
);
