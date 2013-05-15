<?php

// direct access protection
if(!defined('KIRBY')) die('Direct access is not allowed');

/**
 * Users
 * 
 * @package Kirby Panel
 */
class PanelUsers extends Collection {

  /**
   * Constructor
   */
  public function __construct() {

    $files = dir::read(KIRBY_PROJECT_ROOT_PANEL_ACCOUNTS);

    foreach($files as $file) {
      $username = f::name($file);

      if($user = PanelUser::load($username)) {
        $this->set($username, $user);
      }

    }

  }

  /**
   * Get the current user
   */
  static public function findCurrent() {

    $token = cookie::get('auth');
    
    if(empty($token)) return false;
        
    $username = s::get($token, false);

    if(empty($username)) return false;

    $user = PanelUser::load($username);
    
    if(empty($user)) return false;
            
    $user->token = $token;
    return $user;

  }
  
}