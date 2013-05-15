<?php

/**
 * User Authentication
 * 
 * @package Kirby Panel
 */
class AuthController extends Controller {

  // hit the login action by default if the url is just panel/auth
  protected $defaultAction = 'login';

  /**
   * Login action
   * 
   * Renders the login form and tries to 
   * login the user on submit
   */
  public function login() {
    
    $error = false;

    if($this->submitted()) {
      if(PanelUser::login()) $this->redirect();
      $error = true;
    }

    $fields = array(
      'username' => array(
        'label'     => l::get('login.username'),
        'type'      => 'text', 
        'autofocus' => true
      ),
      'password' => array(
        'label'     => l::get('login.password'),
        'type'      => 'password',
      )
    );

    $this->set('form', new PanelForm($fields, null, array(
      'buttons' => array('submit' => l::get('login.button')), 
      'attr'    => array('class' => r($error, 'error'))
    )));

  }

  /**
   * Logout action 
   * 
   * Logs out the user and redirects 
   * to the homepage
   */
  public function logout() {
    app()->user()->logout();
    $this->redirect();
  }

}
