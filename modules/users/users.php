<?php

/**
 * Users Module
 * 
 * @package Kirby Panel
 */
class UsersModule extends Module {

  public function routes() {

    route::register(array(
      
      // users and profiles
      'users' => array(
        'action' => 'users > users::index',
        'method' => 'GET'
      ),
      'users/add' => array(
        'action' => 'users > users::add',
        'method' => 'GET|POST'
      ),
      'users/(:any)/edit' => array(
        'action' => 'users > users::edit',
        'method' => 'GET|POST'
      ),
      'users/(:any)/delete' => array(
        'action' => 'users > users::delete',
        'method' => 'GET|DELETE'
      ),

      // user pics
      'users/(:any)/picture' => array(
        'action' => 'users > pictures::show',
        'method' => 'GET'
      ),
      'users/(:any)/picture/upload' => array(
        'action' => 'users > pictures::upload',
        'method' => 'GET|POST'
      ),
      'users/(:any)/picture/delete' => array(
        'action' => 'users > pictures::delete',
        'method' => 'GET|DELETE'
      ),

    ));

  }

  public function sidebar() {

    $groups  = array();
    $baseurl = url('users > users::index');
    $param   = param('group');

    // all groups
    $groups[] = array(
      'id'     => 'all',
      'url'    => $baseurl,
      'name'   => 'All users',
      'active' => !$param
    );

    foreach(c::get('groups') as $id => $group) {
      $groups[] = array(
        'id'     => $id,
        'url'    => $baseurl . '/group:' . $id,
        'name'   => $group['name'],
        'active' => $id == $param
      ); 
    }

    $sidebar = new Snippet('users > sidebar'); 
    $sidebar->groups = $groups;

    return $sidebar;

  }

}