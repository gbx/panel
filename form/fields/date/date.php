<?php 

echo form::text(
  $this->name(),
  $this->value(),
  $this->attr(array(
    'data-format'   => $this->option('format', 'yy-mm-dd'),
    'data-language' => panel()->user()->language(),
  ))
);
