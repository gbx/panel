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

    // get all users
    $users = site::instance()->users();    

    // if there are no users yet, go to the installation page
    if(!$users->count()) redirect::to('install');

    $this->layout = new layout($this->module() . ' > login');  
    $this->layout->title   = l::get('login.title', 'Login');
    $this->layout->content = new view($this);
    $this->layout->content->form = new form(array(
      'username' => array(
        'placeholder' => l::get('login.username', 'Username'),
        'type'        => 'text', 
        'autofocus'   => true
      ),
      'password' => array(
        'placeholder' => l::get('login.password', 'Password'),
        'type'        => 'password',
      )
    ), array(

      'buttons' => array(
        'submit' => l::get('login.button', 'Login'), 
        'cancel' => false      
      ),

      'on' => array(
        'submit' => function($form) use ($users) {

          $user = $users->find($form->data('username'));
          
          if($user and $user->login($form->data('password'))) {
            redirect::home();
          }
        
          $form->options['attr']['class'] = 'error';

        }
      ), 

    ));

  }

  /**
   * Logout action 
   * 
   * Logs out the user and redirects 
   * to the homepage
   */
  public function logout() {    
    if($user = site()->user()) $user->logout();
    redirect::home();
  }

}
