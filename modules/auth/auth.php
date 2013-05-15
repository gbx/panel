<?php

/**
 * Authentication Module
 * 
 * @package Kirby App
 */
class AuthModule extends AppModule {

  protected $title = 'Authentication';
  protected $name = 'auth';
  protected $layout = 'auth > login';
  protected $defaultController = 'auth';
  protected $singleController  = true;
  protected $visible = false;

}
