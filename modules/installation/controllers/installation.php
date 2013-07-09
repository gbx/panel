<?php

use Kirby\Form;

// load the user model
app::load(array(
  'users > models/user',
  'users > models/group'
));

class InstallationController extends Controller {

  public function index() {

    $this->layout->css = array(
      'shared > assets/css/app.css'
    );

    $fields = array(
      'username' => array(
        'label' => 'Username',
        'type'  => 'text',
        'focus' => true
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
    );    

    $this->form  = new Form($fields, array(
      'buttons' => array('cancel' => false, 'submit' => 'Create')
    ));
    
    $this->alert = false;

    if($this->submitted()) {

      // create all needed dirs
      dir::make(KIRBY_SITE_ROOT_PANEL_ACCOUNTS);
      dir::make(KIRBY_SITE_ROOT_PANEL_GROUPS);
      dir::make(KIRBY_SITE_ROOT_PANEL_BLUEPRINTS);
      dir::make(KIRBY_SITE_ROOT_PANEL_CONFIG);

      $group = new Group(array(
        'name' => 'Admin'
      ));

      $group->save();

      if($group->valid()) {

        // make sure the new group is loaded
        app()->groups()->reload();

        // create the new user
        $user = new User(array(
          'username' => get('username'),
          'email'    => get('email'),
          'password' => get('password'),
          'group'    => 'admin', 
        ));

        // store the new user
        $user->save();

        if($user->valid()) {
          $this->redirect();
        } else {
          $this->alert = $this->snippet('shared > alert', array(
            'message' => $user->error()
          ));
        }

      } else {
        $this->alert = $this->snippet('shared > alert', array(
          'message' => $group->error()
        ));        
      }

    }

  }

}
