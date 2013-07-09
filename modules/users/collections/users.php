<?php

// direct access protection
if(!defined('KIRBY')) die('Direct access is not allowed');

// load the user model
app::load('users > models/user');

/**
 * Users
 * 
 * @package   Kirby Panel
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://getkirby.com/license
 */
class Users extends Collection {

  /**
   * Constructor
   */
  public function __construct() {

    $files = dir::read(KIRBY_SITE_ROOT_PANEL_ACCOUNTS);

    foreach($files as $file) {
      $username = f::name($file);

      if($user = User::load($username)) {
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

    $user = User::load($username);
    
    if(empty($user)) return false;
            
    $user->token = $token;
    return $user;

  }
  
}