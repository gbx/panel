<?php

/**
 * Authentication Module
 * 
 * @package Kirby Panel
 */
class AuthModule extends Module {

  protected $title = 'Authentication';
  protected $name = 'auth';
  protected $layout = 'auth > login';
  protected $defaultController = 'auth';
  protected $singleController  = true;
  protected $visible = false;

}
