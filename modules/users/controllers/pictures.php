<?php

use Kirby\Form;

/**
 * User Pictures
 * 
 * @package   Kirby Panel
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://getkirby.com/license
 */
class PicturesController extends Controller {

  public function show($username) {

    $this->user = $this->currentUser($username);

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

  public function upload($username) {
  
    $this->layout('shared > iframe');

    $this->user  = $this->currentUser($username);
    $this->alert = '';
    
    $fields = array(
      'file' => array(        
        'label' => 'Please choose an image…',
        'type'  => 'file',
        'focus' => true
      ),      
    );

    $this->form = new Form($fields, array(
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
        $this->alert = $this->snippet('shared > alert', array('message' => $upload->message()));    
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

  public function delete($username) {

    $this->layout('shared > iframe');

    $this->user = $this->currentUser($username);
    $this->form = $this->form(array(), null, 'Delete Picture', 'DELETE');

    if($this->submitted('DELETE')) {
      $this->user->avatar()->delete();
      $this->success('The picture has been deleted');
    }

  }

  protected function currentUser($username) {
    return app()->users()->find($username);
  }

  protected function form($fields, $data = null, $submit = 'Done', $method = 'POST') {

    return new Form($fields, array(
      'data'   => $data,
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

}