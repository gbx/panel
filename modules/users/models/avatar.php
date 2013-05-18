<?php

// direct access protection
if(!defined('KIRBY')) die('Direct access is not allowed');

/**
 * Avatar
 * 
 * @package   Kirby Panel
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://getkirby.com/license
 */
class Avatar {

  // the avatar's user
  protected $user = null;

  /**
   * Constructor
   * 
   * @param object $user The user object
   */
  public function __construct($user) {
    $this->user = $user;
  }

  /**
   * Returns the url to the user's avatar
   * 
   * @return string
   */
  public function url($size = 80) {

    if($root = $this->root()) {
      $asset = new Asset($this->root());
      return PanelThumb($asset, array('width' => $size, 'height' => $size, 'crop' => true), $tag = false);
    } else {
      return app()->url('shared > assets/images/avatar.png');
    }

  }

  /**
   * Returns the main dir for user accounts
   * 
   * @return string
   */
  public function dir() {
    return KIRBY_PROJECT_ROOT_PANEL_ACCOUNTS;
  }

  /**
   * Returns the unix timestamp for when the avatar file has been modified for the last time
   * 
   * @return int
   */
  public function modified() {
    return f::modified($this->root());    
  }

  /**
   * Try to find the avatar file
   * 
   * @return mixed
   */
  public function root() {
    // search for an uploaded image for the user
    return a::first(glob($this->dir() . DS . $this->user->username() . '.{jpg,gif,png}', GLOB_BRACE));
  }

  /**
   * Checks if an avatar exists
   * 
   * @return boolean
   */
  public function exists() {
    return $this->root() ? true : false;    
  }

  /**
   * Deletes the avatar if it exists
   * 
   * @return boolean
   */
  public function delete() {
    if($root = $this->root()) return f::remove($root);
    return true;
  }

  /**
   * Moves the avatar to a new username
   * 
   * @return boolean
   */
  public function move() {

    // don't move avatars if the user is new
    if($this->user->isNew()) return true;

    // don't do anything if the username didn't change
    if($this->user->old('username') == $this->user->username()) return true;

    // fake user for the old username
    $old = new User();
    $old->username = $this->user->old('username');

    // don't do anything if the old avatar does not exist.
    if(!$old->avatar()->exists()) return true;

    // new root
    $new = $this->dir() . DS . $this->user->username() . '.' . f::extension($old->avatar()->root());

    // try to move the file
    return f::move($old->avatar()->root(), $new);

  }

}