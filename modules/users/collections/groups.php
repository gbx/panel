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

    $files = dir::read(KIRBY_PROJECT_ROOT_PANEL_GROUPS);

    foreach($files as $file) {
      $id = f::name($file);

      if($group = Group::find($id)) {
        $this->set($id, $group);
      }

    }

  }
 
  public function toOptions() {

    $options = array();
    
    foreach($this as $group) {
      $options[$group->id()] = $group->name();
    }

    return $options;

  }

}