<?php

// direct access protection
if(!defined('KIRBY')) die('Direct access is not allowed');

/**
 * User
 * 
 * A model for the currently logged in 
 * app user
 * 
 * @package   Kirby Panel
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://getkirby.com/license
 */
class User extends Model {

  protected $primaryKeyName = 'username';
  protected $avatar = null;

  /**
   * Checks if the user is logged in
   * 
   * @return boolean 
   */
  public function isLoggedIn() {
    return ($this->token && cookie::get('auth') && $this->token == cookie::get('auth')) ? true : false;
  }
  
  /**
   * Returns the url to the user's avatar
   * 
   * @return object
   */
  public function avatar() {
    if(!is_null($this->avatar)) return $this->avatar;
    app::load('users > models/avatar');
    return $this->avatar = new Avatar($this);
  }

  /**
   * Checks if the user is in the admin group
   * 
   * @return boolean
   */
  public function isAdmin() {
    return $this->group() == 'admin';
  }

  /**
   * Login the user with the passed credentials
   * If no credentials are passed, the credentials are
   * being fetched from the request
   * 
   * @param array $credentials array('username' => 'myuser', 'password' => 'mypass')
   * @return boolean
   */
  static public function login($credentials = array()) {
  
    $defaults = array(
      'username' => get('username'), 
      'password' => get('password')
    );

    $credentials = array_merge($defaults, $credentials);

    $username = $credentials['username'];
    $password = $credentials['password'];

    s::restart();
    
    if(empty($username) || empty($password)) return false;

    $account = self::load($username);
    
    if(!$account) return false;
    
    // check for matching usernames
    if(str::lower($account->username) != str::lower($username)) return false;
    
    // check for a matching password
    if(!self::checkPassword($account, $password)) return false;

    // check for the admin group
    if($account->group != 'admin') return false;

    // generate a random token
    $token = str::random(32);
        
    // add the secret token. 
    $account->token = $token;
    
    // store the token in the cookie
    // and the user data in the session    
    cookie::set('auth', $token, 60*24);        
    s::set($token, $account->username);
        
    return true;
              
  }

  /**
   * Kill the session of the current user
   */
  public function logout() {
    
    // overwrite the token      
    $token = str::random();
    // the cookie is valid for 24 hours
    cookie::set('auth', $token, 60*60*24);
    
    // restart the session    
    s::restart();
    
  }

  /**
   * Checks the password with the configured method (sha1, md5)
   * 
   * @param string $user An associative array with all info about the user
   * @param string $password 
   * @return boolean
   */
  static public function checkPassword($user, $password) {
    
    // check for empty passwords    
    if(empty($password) || empty($user->password)) return false;
        
    // handle the different 
    // encryption types        
    switch($user->encrypt) {
      // sha1 encoded
      case 'sha1':
        return (sha1($password) == $user->password) ? true : false;
        break;
      // md5 encoded
      case 'md5':
        return (md5($password) == $user->password) ? true : false;
        break;
      // plain passwords
      default:
        return ($password == $user->password) ? true : false;
        break;    
    }    
    
    // we should never get here
    // but let's make sure
    return false;

  }
  
  protected function file() {
    return KIRBY_PROJECT_ROOT_PANEL_ACCOUNTS . DS . $this->username() . '.php';
  }

  /**
   * Load the user info array by username
   * 
   * @param string $username
   * @return array
   */
  static public function load($username) {

    // check for an existing user account file
    $file = KIRBY_PROJECT_ROOT_PANEL_ACCOUNTS . DS . $username . '.php';
    
    if(!file_exists($file)) return false;
    
    // load the account credentials    
    content::start();
    require($file);
    $account = content::stop();
    $account = yaml($account);

    if(!is_array($account)) return false;

    // check for required fields
    $missing = a::missing($account, array('username', 'password'));
    
    if(!empty($missing)) return false;
    
    return new User($account);
  
  }

  protected function store() {
  
    if(!@touch($this->file())) {
      $this->raise('store', 'The account file is not writable');
      return false;
    }

    $content = array();

    $content[] = '<?php if(!defined(\'KIRBY\')) exit ?>';
    $content[] = '';
    
    foreach($this->toArray() as $key => $value) {
      $content[] = strtolower($key) . ': ' . $value;
    }

    return f::write($this->file(), implode(PHP_EOL, $content));    
  
  }

  public function isNew() {
    return !$this->old('username');
  }

  protected function validate() {

    // on new users or users with a new username, make sure that 
    // this won't overwrite an existing account
    if($this->old('username') != $this->username() and app()->users()->get($this->username)) {
      $this->raise('username', 'The username is already taken');
    }

    $this->v(array(
      'username' => array('required', 'min' => 3),
      'email'    => array('required', 'email'),
      'group'    => array('in' => app()->groups()->keys()), 
      'password' => array('required', 'confirmed'),
    ));

    // check if enough admins are left if this user is no 
    // longer supposed to be an admin
    if($this->old('group') == 'admin' and $this->group != 'admin') {

      // if this has been the last admin, it's not allowed 
      // to move him to another group
      if(app()->groups()->admin()->users()->count() == 0) {
        $this->raise('group', 'You must have one admin left at least');
      }

    }

  }

  protected function insert() {
    return $this->store();
  }

  protected function update() {
    return $this->store();
  }

  public function delete() {

    // delete the avatar first
    $this->avatar()->delete();

    // delete the user account file next
    return f::remove($this->file());    
  
  }

}