<?php

class UsersModule extends Module {

  protected $name = 'users';
  protected $defaultController = 'users';
  protected $singleController = true;

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
  
    // header
    return $this->snippet('shared > header', array(
      'headline' => $headline,
      'tabs'     => $tabs
    ));

  }
}
