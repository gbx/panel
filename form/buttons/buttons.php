<?php 

buttons::add(array(
  'h1'     => '<button data-type="tag" data-tag-open="# ">' . l::get('form.buttons.h1') . '</button>',
  'h2'     => '<button data-type="tag" data-tag-open="## ">' . l::get('form.buttons.h2') . '</button>',
  'h3'     => '<button data-type="tag" data-tag-open="### ">' . l::get('form.buttons.h3') . '</button>',
  'bold'   => '<button data-type="tag" data-tag-open="**" data-tag-close="**" data-tag-sample="' . l::get('form.buttons.bold.sample') . '">' . l::get('form.buttons.bold') . '</button>',
  'italic' => '<button data-type="tag" data-tag-open="*" data-tag-close="*" data-tag-sample="' . l::get('form.buttons.italic.sample') . '">' . l::get('form.buttons.italic') . '</button>',
  'link'   => '<button data-event="action" data-action="iframe" href="' . app()->url('insert/link') . '">' . l::get('form.buttons.link') . '</button>',
  'email'  => '<button data-event="action" data-action="iframe" href="' . app()->url('insert/email') . '">' . l::get('form.buttons.email') . '</button>',
));