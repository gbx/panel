<?php

/**
 * Site Module
 * 
 * @package Kirby Panel
 */
class SiteModule extends Module {

  protected $_site;
  protected $_page;

  public function routes() {

    route::register(array(

      '/site/metatags' => array(
        'action' => 'site > site::metatags',
        'method' => 'GET', 
        'filter' => 'auth',
      ),

      '/page/update/(:all)' => array(
        'action' => 'site > page::index',
        'method' => 'GET|POST',
        'filter' => 'auth',
      ),

      '/page/move/(:all)' => array(
        'action' => 'site > page::move',
        'method' => 'GET|POST',
        'filter' => 'auth',
      ),

      '/page/template/(:all)' => array(
        'action' => 'site > page::template',
        'method' => 'GET|POST',
        'filter' => 'auth',
      ),

      '/page/url/(:all)' => array(
        'action' => 'site > page::url',
        'method' => 'GET|POST',
        'filter' => 'auth',
      ),

      '/page/delete/(:all)' => array(
        'action' => 'site > page::delete',
        'method' => 'GET|DELETE',
        'filter' => 'auth',
      ),

      // form buttons modals
      '/page/image/(:all)' => array(
        'action' => 'site > modals::image',
        'method' => 'GET',
        'filter' => 'auth',
      ),

    ));
  
  }

  public function autoloader() {

    parent::autoloader();

    $autoloader = new Autoloader();
    $autoloader->namespace = 'Kirby\\Panel\\Site';
    $autoloader->root = $this->root() . DS . 'components';
    $autoloader->start();

  }

  public function site() {    

    if(!is_null($this->_site)) return $this->_site;

    return $this->_site = site(array(
      'url'        => dirname(url::home()),
      'subfolder'  => dirname(app::uri()->subfolder()), 
      'currentURL' => $this->pageuri()
    ));

  }

  public function pageuri() {  
    $route = app::route();
    if($route->action() == 'site > page::index') {
      return a::first($route->arguments());
    } else {
      return false;
    }

  }

  public function page($uri = null) {
    if(empty($uri)) $uri = $this->pageuri();
    return $this->site()->children()->find($uri);
  }

  public function sidebar($active = null) {

    $sidebar         = new Snippet('site > sidebar');
    $sidebar->tree   = new Snippet('site > tree', array('subpages' => $this->site()->children(), 'active' => $active)); 
    $sidebar->active = $active;

    return $sidebar;

  }

  public function blueprint($page) {
    return new Blueprint($page);
  }
  
}