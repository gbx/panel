<?php

/**
 * Users
 * 
 * @package   Kirby Panel
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://getkirby.com/license
 */
class UsersController extends Controller {

  public function index() {    

    // group filter
    $group = null;

    if(param('group') && $group = app()->groups()->find(param('group'))) {
      $users = $group->users();
    } else {
      $users = app()->users();
    }

    // create a user topbar
    $this->layout->header = $this->module()->header();
    
    // pass the entire list of users to the view
    $this->users = $users;

  }

  public function add() {

    $this->layout('shared > iframe');
    $this->form = $this->userform();

    if($this->submitted()) {

      $user = new User(array(
        'username' => get('username'),
        'email'    => get('email'),
        'group'    => get('group'), 
        'password' => get('password')
      ));

      // store the new user
      $user->save();

      // yield some json
      $this->respond($user, 'The user has been added');

    }

  }

  public function edit($username) {

    $this->layout('shared > iframe');

    $this->user = clone $this->currentUser($username);
    $this->form = $this->userform($this->user->remove('password')->toArray());

    if($this->submitted()) {

      $user = $this->currentUser($username);

      $user->set(array(
        'username' => get('username'),
        'email'    => get('email'),
        'group'    => get('group')
      ));

      // only store a new password if one is added
      if(get('password') != '') {
        $user->set('password', get('password'));
      } else {
        // make sure the already stored password will be confirmed
        r::set('password_confirmation', $user->password());
      }

      // save all updated data
      $user->save();

      // yield some json
      $this->respond($user, 'The user has been updated');
   
    }

  }

  public function delete($username) {

    $this->layout('shared > iframe');

    $this->user = $this->currentUser($username);
    $this->form = $this->form(array(), null, 'Delete user', 'DELETE');

    if($this->submitted('DELETE')) {
      $this->user->delete();
      $this->success('The user has been added');
    }

  }

  protected function currentUser($username) {
    return app()->users()->find($username);
  }

  protected function form($fields, $data = null, $submit = 'Done', $method = 'POST') {

    return new PanelForm($fields, $data, array(
      'method' => $method,
      'attr'   => array(
        'data-autosubmit'    => 'true',
        'data-reload-parent' => 'true'
      ),
      'buttons' => array(
        'cancel' => l::get('cancel'), 
        'submit' => $submit
      )
    ));

  }

  protected function userform($data = null) {

    $fields = array(
      'username' => array(
        'label' => 'Username',
        'type'  => 'text',
        'focus' => true
      ),
      'email' => array(
        'label' => 'Email',
        'type'  => 'text'
      ),
      'group' => array(
        'label'   => 'Group',
        'type'    => 'select',
        'options' => app()->groups()->toOptions()
      ),
      'password' => array(
        'label' => 'Password',
        'type'  => 'password'
      ),
      'password_confirmation' => array(
        'label' => 'Confirm password',
        'type'  => 'password'
      ),
    );

    return $this->form($fields, $data);

  }

}
