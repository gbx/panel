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
class Panel extends Kirby\App {

  // The current logged in app user
  protected $user = null;
 
  // All available users
  protected $users = null;

  // All available groups
  protected $groups = null;

  public function routes() {  

    if($this->users()->count()) {

      if($this->user() && $this->user()->isLoggedIn()) {
        router::register(array('GET'), '/', 'site > overview::index');
      } else {
        router::register(array('GET', 'POST'), '/', 'auth > auth::login');
      }

    } else {
      // open the installer
      router::register(array('GET', 'POST'), '/', 'installation > installation::index');
    }

  }

  protected function configure($params = array()) {

    // load custom panel config files
    f::load(KIRBY_SITE_ROOT_PANEL_CONFIG . DS . 'config.php');
    f::load(KIRBY_SITE_ROOT_PANEL_CONFIG . DS . 'config.' . server::get('server_name') . '.php');
    f::load(KIRBY_SITE_ROOT_PANEL_CONFIG . DS . 'config.' . server::get('server_addr') . '.php');

  }

  // run panel authentication
  protected function authenticate() {
    if(!in_array($this->module()->name(), array('auth', 'installation'))) {
      if(!$this->user() || !$this->user()->isLoggedIn()) go($this->url('/'));
    }
  }

  protected function localize() {

    // load the default localization stuff
    parent::localize();

    // set default locale settings for php functions
    if(c::get('app.locale')) setlocale(LC_ALL, c::get('app.locale'));

    // load the global language file
    f::load($this->modules()->get('shared')->root() . DS . 'languages' . DS . 'en.php');    

    // load the current module's language file 
    f::load($this->module()->root() . DS . 'languages' . DS . 'en.php');    

  }

  /**
   * Returns the currently logged in user object
   * 
   * @return object KirbyUser
   */
  public function user() {
    if(!is_null($this->user)) return $this->user;
    static::load('users > collections/users');
    return $this->user = Users::findCurrent();
  }

  /**
   * Returns all available users
   * 
   * @return object KirbyUsers
   */
  public function users() {
    if(!is_null($this->users)) return $this->users;
    static::load('users > collections/users');
    return $this->users = new Users();
  }

  /**
   * Returns all available groups
   * 
   * @return object KirbyGroups
   */
  public function groups() {
    if(!is_null($this->groups)) return $this->groups;
    static::load('users > collections/groups');
    return $this->groups = new Groups();
  }

    
  public function moduleList() {

    $modules = array();
  
    foreach(c::get('panel.modules') as $m) {
      if($module = $this->modules()->find($m)) $modules[] = $module;
    }

    return $modules;

  }

}