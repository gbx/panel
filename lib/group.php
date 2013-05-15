<?php

// direct access protection
if(!defined('KIRBY')) die('Direct access is not allowed');

/**
 * Group
 * 
 * @package Kirby Panel
 */
class PanelGroup extends Object {

  /**
   * Load the group by id
   * 
   * @param string $id
   * @return array
   */
  static public function find($id) {

    // check for an existing user account file
    $file = ROOT_SITE_PANEL_GROUPS . DS . $id . '.php';
    
    if(!file_exists($file)) return false;
    
    // load the account credentials    
    content::start();
    require($file);
    $group = content::stop();
    $group = yaml($group);

    if(!is_array($group)) return false;

    // check for required fields
    $missing = a::missing($group, array('name'));
    
    if(!empty($missing)) return false;

    // add the id
    $group['id'] = $id;
    
    return new self($group);
  
  }

  /**
   * Returns all users in this group
   * 
   * @return object PanelUsers
   */
  public function users() {
    return app()->users()->filterBy('group', $this->id());
  }

}