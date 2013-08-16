<?php 

use Kirby\Form\Field\Buttons;

buttons::add(array(
  'h1'     => '<button data-type="tag" data-tag-open="# ">' . l::get('form.buttons.h1', 'h1') . '</button>',
  'h2'     => '<button data-type="tag" data-tag-open="## ">' . l::get('form.buttons.h2', 'h2') . '</button>',
  'h3'     => '<button data-type="tag" data-tag-open="### ">' . l::get('form.buttons.h3', 'h3') . '</button>',
  'bold'   => '<button data-type="tag" data-tag-open="**" data-tag-close="**" data-tag-sample="' . l::get('form.buttons.bold.sample', 'bold text') . '">' . l::get('form.buttons.bold', 'bold') . '</button>',
  'italic' => '<button data-type="tag" data-tag-open="*" data-tag-close="*" data-tag-sample="' . l::get('form.buttons.italic.sample', 'italic text') . '">' . l::get('form.buttons.italic', 'italic') . '</button>',
  'link'   => '<button data-event="action" data-action="iframe" href="' . url('insert/link') . '">' . l::get('form.buttons.link', 'link') . '</button>',
  'email'  => '<button data-event="action" data-action="iframe" href="' . url('insert/email') . '">' . l::get('form.buttons.email', 'email') . '</button>',
));