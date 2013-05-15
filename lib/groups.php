<?php

// direct access protection
if(!defined('KIRBY')) die('Direct access is not allowed');

/**
 * Groups
 * 
 * @package Kirby Panel
 */
class PanelGroups extends Collection {

  /**
   * Constructor
   */
  public function __construct() {

    $files = dir::read(ROOT_SITE_PANEL_GROUPS);

    foreach($files as $file) {
      $id = f::name($file);

      if($group = PanelGroup::find($id)) {
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