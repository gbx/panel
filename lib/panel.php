<?php

// direct access protection
if(!defined('KIRBY')) die('Direct access is not allowed');

/**
 * Panel
 * 
 * @package   Kirby Panel
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://getkirby.com/license
 */
class Panel extends App {

  // The current logged in app user
  protected $user = null;
 
  // All available users
  protected $users = null;

  // All available groups
  protected $groups = null;

  protected function configure($params = array()) {

    // load custom panel config files
    f::load(KIRBY_PROJECT_ROOT_PANEL_CONFIG . DS . 'config.php');
    f::load(KIRBY_PROJECT_ROOT_PANEL_CONFIG . DS . 'config.' . server::get('server_name') . '.php');

    // get all config options that have been stored so far
    $defaults = c::get();

    // merge them with the passed late options again
    $config = array_merge($defaults, $params);

    // store them again
    c::set($config);

  }

  // run panel authentication
  protected function authenticate() {
    if($this->modules()->findActive()->name() != 'auth') {
      $user = $this->user();
      if(!$user || !$user->isLoggedIn()) go(app()->url('/'));
    }    
  }

  /**
   * Returns the currently logged in user object
   * 
   * @return object KirbyUser
   */
  public function user() {
    if(!is_null($this->user)) return $this->user;
    self::load('users > collections/users');
    return $this->user = Users::findCurrent();
  }

  /**
   * Returns all available users
   * 
   * @return object KirbyUsers
   */
  public function users() {
    if(!is_null($this->users)) return $this->users;
    self::load('users > collections/users');
    return $this->users = new Users();
  }

  /**
   * Returns all available groups
   * 
   * @return object KirbyGroups
   */
  public function groups() {
    if(!is_null($this->groups)) return $this->groups;
    self::load('users > collections/groups');
    return $this->groups = new Groups();
  }

  public function defaultModule() {
    if($this->user() && $this->user()->isLoggedIn()) {
      return $this->modules()->get('site');
    } else {
      return $this->modules()->get('auth');
    }
  }

  public function moduleList() {

    $modules = array();
    
    foreach(c::get('panel.modules') as $m) {
      if($module = $this->modules()->find($m)) $modules[] = $module;
    }

    return $modules;

  }

}