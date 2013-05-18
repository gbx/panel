<?php 

buttons::add(array(
  'image' => '<button data-event="action" data-action="iframe" href="' . app()->module()->pageURL('this', 'insert/image') . '">' . l::get('form.buttons.image', 'image') . '</button>',
));
