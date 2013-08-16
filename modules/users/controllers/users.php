<?php

use Kirby\Form;

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

    $users = site::instance()->users();

    if($param = param('group')) $users = $users->filterByGroup($param);

    $this->layout = new Layout('shared > application');
    $this->layout->title   = 'Users';
    $this->layout->sidebar = $this->module()->sidebar();
    $this->layout->content = new View($this);
    $this->layout->content->users = $users;

  }

  public function add() {

    $this->layout = new Layout('shared > application');
    $this->layout->sidebar = $this->module()->sidebar();
    $this->layout->content = new View($this);
    $this->layout->content->form = $this->userform();
    $this->layout->content->form->on('submit', function($form) {

      $user = site()->users()->create($form->data(array(
        'username', 
        'email', 
        'group',
        'password'
      )));

      // store the new user
      if($user and $user->valid()) {
        return response::success('The user has been added');
      } else {
        return response::error($user);
      }

    });

  }

  public function edit($username) {

    // get the user
    $user = clone $this->user($username);

    $this->layout = new layout('shared > application');
    $this->layout->title   = 'Edit user: ' . html($user->username());
    $this->layout->sidebar = $this->module()->sidebar();
    $this->layout->content = new view($this);
    $this->layout->content->form = $this->userform($user->remove('password')->toArray());
    $this->layout->content->form->on('submit', function($form) use ($username) {

      // get the user again
      $user = $this->user($username);

      // set all data
      $user->set($form->data(array(
        'username', 
        'email',
      )));

      // only overwrite the group if necessary
      if($form->data('group') != '') $user->group = $form->data('group');

      // only store a new password if one is added
      if($form->data('password') != '') {
        $user->set('password', $form->data('password'));
      } 

      // save all updated data
      if($user->save()) {
        return response::success('The user has been updated');
      } else {
        return response::error($user);
      }

    });

  }

  public function delete($username) {

    // get the user
    $user = $this->user($username);

    $this->layout = new layout('shared > iframe');
    $this->layout->content = new view($this);
    $this->layout->content->user = $user;
    $this->layout->content->form = $this->form(array(), null, 'Delete user', 'DELETE');
    $this->layout->content->form->on('submit', function() use ($user) {
      
      if($user->delete()) {
        return response::success('The user has been deleted');  
      } else {
        return response::error($user);
      }
      
    });

  }

  protected function user($username) {
    $user = site::instance()->user($username);
    if(!$user) raise('The user could not be found', 404);
    return $user;
  }

  protected function form($fields, $data = null, $submit = 'Done', $method = 'POST') {

    return new form($fields, array(
      'data'   => $data,
      'method' => $method,
      'attr'   => array(
        'data-autosubmit'    => 'true',
        'data-reload-parent' => 'true'
      ),
      'buttons' => array(
        'cancel' => l::get('cancel', 'Cancel'), 
        'submit' => $submit
      )
    ));

  }

  protected function userform($data = array()) {

    $groups = array();

    foreach(c::get('groups') as $id => $group) {
      if($id == 'root') continue;
      $groups[$id] = $group['name'];
    }

    $fields = array(
      'username' => array(
        'label'     => 'Username',
        'type'      => 'text',
        'autofocus' => true
      ),
      'email' => array(
        'label'     => 'Email',
        'type'      => 'text'
      ),
      'group' => array(
        'label'     => 'Group',
        'type'      => 'select',
        'options'   => $groups
      ),
      'password' => array(
        'label'     => 'Password',
        'type'      => 'password'
      ),
      'password_confirmation' => array(
        'label'     => 'Confirm password',
        'type'      => 'password'
      ),
    );

    if($data and $data['group'] == 'root') {
      unset($fields['group']);
    }

    return $this->form($fields, $data);

  }

}
