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

  public function avatar() {

    $this->user = $this->currentUser();

    // size
    $size = param('size', 50);

    // search for an uploaded image for the user
    $file = a::first(glob(KIRBY_PROJECT_ROOT_PANEL_ACCOUNTS . DS . $this->user->username() . '.{jpg,gif,png}', GLOB_BRACE));

    // go to the gravatar
    if(!$file) {
      $file = KIRBY_PANEL_ROOT_MODULES . DS . 'shared' . DS . 'assets' . DS . 'images' . DS . 'avatar.png';
    }
  
    // read the image file and echo it
    $image = f::read($file);
    $mime  = f::mime($file);

    // display the image
    content::type($mime);
    die($image);

  }

  public function picture() {
  
    $this->layout('shared > iframe');

    $this->user  = $this->currentUser();
    $this->alert = '';
    
    $fields = array(
      'file' => array(        
        'label' => 'Please choose an image from your computer…',
        'type'  => 'file',
        'focus' => true
      ),      
    );

    $this->form = new PanelForm($fields, null, array(
      'upload' => true,
      'buttons' => array(
        'cancel' => l::get('cancel'), 
        'submit' => 'Upload'
      )
    ));
    
    if($this->submitted()) {
  
      // delete the current avatar first
      $this->user->avatar()->delete();

      $upload = new Upload('file', $this->user->avatar()->dir() . DS . $this->user->username() . '.:extension', array(
        'allowed' => array('image/jpeg', 'image/png', 'image/gif')
      ));

      if($upload->failed()) {
        $this->alert = app()->snippet('shared > alert', array('message' => $upload->message()), $return = true);    
      } else {
        
        // hacky!!
        die('

          <script>
            window.parent.location.reload();
            window.parent.$app.iframe.close();          
          </script>

        ');
      
      }

    }    

  }

  public function deletePicture() {

    $this->layout('shared > iframe');

    $this->user = $this->currentUser();
    $this->form = $this->form(array(), null, 'Delete Picture');

    if($this->submitted()) {
      $this->currentUser()->avatar()->delete();
      $this->success('The picture has been added');
    }

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

  public function edit() {

    $this->layout('shared > iframe');

    $this->user = clone $this->currentUser();
    $this->form = $this->userform($this->user->remove('password')->toArray());

    if($this->submitted()) {

      $user = $this->currentUser();

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

  public function delete() {

    $this->layout('shared > iframe');

    $this->user = $this->currentUser();
    $this->form = $this->form(array(), null, 'Delete user');

    if($this->submitted()) {
      $this->currentUser()->delete();
      $this->success('The user has been added');
    }

  }

  protected function currentUser() {
    return app()->users()->find(param('user'));
  }

  protected function form($fields, $data = null, $submit = 'Done') {

    return new PanelForm($fields, $data, array(
      'attr' => array(
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
