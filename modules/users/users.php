<?php

class UsersModule extends Module {

  protected $name   = 'users';
  protected $layout = 'shared > default';

  public function routes() {
    
    router::register(array('GET'),           'users',               'users > users::index');
    router::register(array('GET', 'POST'),   'users/add',           'users > users::add');
    router::register(array('GET', 'POST'),   'users/(:any)/edit',   'users > users::edit');
    router::register(array('GET', 'DELETE'), 'users/(:any)/delete', 'users > users::delete');

    // user pics
    router::register(array('GET'),           'users/(:any)/picture',        'users > pictures::show');
    router::register(array('GET', 'POST'),   'users/(:any)/picture/upload', 'users > pictures::upload');
    router::register(array('GET', 'DELETE'), 'users/(:any)/picture/delete', 'users > pictures::delete');

  }

  public function header() {

    // get the current tab
    $tab = param('group', 'all');

    // get all groups
    $groups = app()->groups();

    // headline 
    $headline = $this->snippet('shared > headline', array(
      'text' => 'Users', 
      'url'  => $this->url()
    ));

    /*
    // tabs
    $tabs = $this->snippet('shared > tabs', array(
      'tabs' => array(
        'all' => array(
          'title'  => 'All users', 
          'url'    => $this->url(),
          'active' => r($tab == 'all', true),
          'count'  => app()->users()->count(),
        ),
        'clients' => array(
          'title'  => 'Clients', 
          'url'    => $this->url('group:client'),
          'active' => r($tab == 'client', true),
          'count'  => $groups->client()->users()->count(),
        ),
        'admins' => array(
          'title'  => 'Admins', 
          'url'    => $this->url('group:admin'),
          'active' => r($tab == 'admin', true),
          'count'  => $groups->admin()->users()->count(),
        ),
      ),
    ));
    */
  
    $tabs = false;

    // header
    return $this->snippet('shared > header', array(
      'headline' => $headline,
      'tabs'     => $tabs
    ));

  }

  public function url() {
    return app()->url('users');
  }

}
