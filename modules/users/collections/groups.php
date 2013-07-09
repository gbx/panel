<?php

// direct access protection
if(!defined('KIRBY')) die('Direct access is not allowed');

// dependencies
app::load('users > models/group');

/**
 * Groups
 * 
 * @package   Kirby Panel
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://getkirby.com/license
 */
class Groups extends Collection {

  /**
   * Constructor
   */
  public function __construct() {
    $this->load();
  }

  public function load() {

    $files = dir::read(KIRBY_SITE_ROOT_PANEL_GROUPS);

    foreach($files as $file) {
      $name = f::name($file);
      if($group = Group::load($name)) {
        $this->set($name, $group);
      }
    }

  }

  public function reload() {
    $this->reset();
    $this->load();
  }
 
  public function toOptions() {

    $options = array();
    
    foreach($this as $group) {
      $options[$group->name()] = $group->name();
    }

    return $options;

  }

}