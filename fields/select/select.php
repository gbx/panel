<?php

echo PanelForm::select(
  $this->name(),
  $this->option('options'),
  $this->value(), 
  $this->attr(array('class' => 'customizable'))
);

