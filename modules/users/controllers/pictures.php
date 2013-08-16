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

    // get the user
    $user = $this->user($username);

    // search for an uploaded image for the user
    $file = a::first(glob(KIRBY_SITE_ROOT_PANEL_ACCOUNTS . DS . $user->username() . '.{jpg,gif,png}', GLOB_BRACE));

    // go to the gravatar
    if(!$file) {
      $file = app::root('shared > assets/images/avatar.png');
    }
  
    // read the image file and echo it
    $image = f::read($file);
    $mime  = f::mime($file);

    // display the image
    header::type($mime);
    die($image);

  }

  public function upload($username) {
    
    // find the user
    $user = $this->user($username);

    $this->layout = new layout('shared > iframe');
    $this->layout->title   = 'Upload new picture';
    $this->layout->content = new view($this);
    $this->layout->content->user = $user;
    $this->layout->content->form = new form(array(
      'file' => array(        
        'label'     => 'Please choose an image…',
        'type'      => 'file',
        'autofocus' => true
      ),      
    ), array(
      'upload' => true,
      'buttons' => array(
        'cancel' => l::get('cancel', 'Cancel'), 
        'submit' => 'Upload'
      ), 
      'on' => array(
        'submit' => function($form) use($user) {

          // upload a new avatar
          $upload = $user->avatar()->upload();

          if($upload->failed()) {
            $form->alert($upload->error()->message());
          } else {

            return new Response('
              <script>
                window.parent.location.reload(); 
                window.parent.$app.iframe.close();
              </script>
            ');
          
          }

        }
      )
    ));
    
  }

  public function delete($username) {

    // get the user
    $user = $this->user($username);

    $this->layout = new layout('shared > iframe');
    $this->layout->title   = 'Delete the picture';
    $this->layout->content = new view($this);
    $this->layout->content->user = $user;
    $this->layout->content->form = $this->form(array(), array(), 'Delete Picture', 'DELETE');
    $this->layout->content->form->on('submit', function($form) use($user) {

      if($user->avatar()->delete()) {
        return response::success('The picture has been deleted');
      } else {
        return repsonse::error('The picture could not be deleted');
      }
      
    });

  }

  protected function user($username) {
    if($user = site::instance()->user($username)) return $user;
    raise('User not found', 404);
  }

  protected function form($fields, $data = null, $submit = 'Done', $method = 'POST') {

    return new Form((array)$fields, array(
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

}