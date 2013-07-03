<?php

use Kirby\Form;

/**
 * User Authentication
 * 
 * @package   Kirby Panel
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://getkirby.com/license
 */
class AuthController extends Controller {

  /**
   * Login action
   * 
   * Renders the login form and tries to 
   * login the user on submit
   */
  public function login() {
  
    $this->layout->title = 'Login';
    
    $error = false;

    $fields = array(
      'username' => array(
        'placeholder' => l::get('login.username'),
        'type'        => 'text', 
        'autofocus'   => true
      ),
      'password' => array(
        'placeholder' => l::get('login.password'),
        'type'        => 'password',
      )
    );

    if($this->submitted()) {
      if(User::login()) $this->redirect();
      $error = true;
    }

    $this->form = new Form($fields, array(
      'buttons' => array(
        'submit' => l::get('login.button'), 
        'cancel' => false
      ), 
      'attr' => array('class' => r($error, 'error'))
    ));

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
