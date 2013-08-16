<?php

/**
 * Authentication Module
 * 
 * @package Kirby Panel
 */
class AuthModule extends Module {

  public function routes() {
    route::register('login',  'auth > auth::login',  array('method' => 'GET|POST'));
    route::register('logout', 'auth > auth::logout', array('method' => 'GET', 'filter' => 'auth'));
  }

}