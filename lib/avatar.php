<?php

// direct access protection
if(!defined('KIRBY')) die('Direct access is not allowed');

/**
 * Avatar
 * 
 * @package Kirby Panel
 */
class PanelAvatar {

  protected $user = null;

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

  public function dir() {
    return ROOT_SITE_PANEL_ACCOUNTS;
  }

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

  public function exists() {
    return $this->root() ? true : false;    
  }

  public function delete() {
    if($root = $this->root()) return f::remove($root);
    return true;
  }

}