<?php

/**
 * Authentication Module
 * 
 * @package Kirby Panel
 */
class AuthModule extends Module {

  protected $title   = 'Authentication';
  protected $name    = 'auth';
  protected $layout  = 'auth > login';
  protected $visible = false;

  public function routes() {
    router::get('logout', 'auth > auth::logout');
  }

  public function url() {
    return app()->url();
  }

}
