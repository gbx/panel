<?php 

use Kirby\Form\Field\Buttons;

$page = app::module('site')->page();

buttons::add(array(
  'image' => '<button data-event="action" data-action="iframe" href="' . url('page/image/' . $page->uri()) . '">' . l::get('form.buttons.image', 'image') . '</button>',
));