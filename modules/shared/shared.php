<?php

/**
 * Shared Module
 * 
 * @package Kirby Panel
 */
class SharedModule extends Module {

  public function routes() {
  
    route::register(
      array(
        '/' => array(
          'action' => 'site > site::dashboard',
          'filter' => 'auth'
        ),
        'insert/link' => array(
          'action' => 'shared > modals::link',
          'filter' => 'auth'
        ),
        'insert/email' => array(
          'action' => 'shared > modals::email',
          'filter' => 'auth'
        )
      )
    );

  }

  public function load() {

    layout::filter('shared > application', function($layout) {

      $layout->title   = 'Kirby Panel'; 
      $layout->user    = site::instance()->user();
      $layout->meta    = snippet::create('shared > meta');
      $layout->css     = array();
      $layout->js      = array();
      $layout->menu    = $this->menu();
      $layout->navbar  = '';
      $layout->content = '';

    });

    layout::filter('shared > iframe', function($layout) {

      $layout->title   = 'Kirby Panel'; 
      $layout->meta    = snippet::create('shared > meta');
      $layout->css     = array();
      $layout->js      = array();
      $layout->content = '';

    });

    layout::filter('shared > blank', function($layout) {

      $layout->title   = 'Kirby Panel'; 
      $layout->meta    = snippet::create('shared > meta');
      $layout->css     = array();
      $layout->js      = array();
      $layout->content = '';

    });


  }

  public function menu() {

    $menu = new collection();

    $menu->site = new object;
    $menu->site->title = 'Site';
    $menu->site->url   = url::to('site > overview::index');

    $menu->users = new object;
    $menu->users->title = 'Users';
    $menu->users->url   = url::to('users > users::index');

    return $menu;

  }

}