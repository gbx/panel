<?php

class UsersModule extends Module {

  protected $name   = 'users';
  protected $layout = 'shared > application';

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

  public function url($path = false) {
    return app()->url('users/' . $path);
  }

}
