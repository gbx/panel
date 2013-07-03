<?php

// direct access protection
if(!defined('KIRBY')) die('Direct access is not allowed');

// default config variables
c::set(array( 

  'panel.modules' => array(
    'site',
    'users'
  ),

  'debug' => true,

  'thumb.location.root' => KIRBY_INDEX_ROOT . DS . 'thumbs',
  'thumb.location.url'  => dirname(app()->url()) . '/thumbs',

));