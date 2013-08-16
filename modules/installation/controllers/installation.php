<?php

use Kirby\Form;
use Kirby\CMS\User;

class InstallationController extends Controller {

  public function index() {

    $this->layout = new Layout('shared > blank');
    $this->layout->title   = 'Installation';
    $this->layout->css     = array('assets/css/shared/application.css');
    $this->layout->content = new View($this);
    $this->layout->content->form = new Form(array(
      'username' => array(
        'label'     => 'Username',
        'type'      => 'text',
        'autofocus' => true
      ),
      'email' => array(
        'label' => 'Email',
        'type'  => 'text',
      ),
      'password' => array(
        'label' => 'Password',
        'type'  => 'password',        
      ),
      'password_confirmation' => array(
        'label' => 'Confirm the password',
        'type'  => 'password'
      )
    ), array(
      'buttons' => array(
        'cancel' => false, 
        'submit' => 'Create'
      ), 
      'on' => array(
        'submit' => function($form) {

          $user = site()->users()->create(array(
            'username' => $form->data('username'),
            'email'    => $form->data('email'),
            'password' => $form->data('password'),
            'group'    => 'root',         
          ));

          // check if the password has been confirmed
          if($form->data('password') != $form->data('password_confirmation')) {
            $user->raise('The passwords must match', 'password_confirmation');
          }

          // if the user account has been created…
          if($user and $user->valid()) {

            // get the fresh user object 
            $user = user::find($user->username());
            
            // login the user 
            if($user) $user->login($form->data('password'));
            
            // redirect to the home page
            redirect::home();

          } else {
            // mark all errors in the form
            $form->raise($user);            
          }

        }
      )
    ));

  }

}
