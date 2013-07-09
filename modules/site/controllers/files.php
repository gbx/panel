<?php

use Kirby\Form;

/**
 * Files
 * 
 * @package   Kirby Panel
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://getkirby.com/license
 */
class FilesController extends Controller {

  public function index() {

    $this->layout->js = array(
      'shared > assets/js/jquery.magnific.js',    
    );

    $this->layout->css = array(
      'shared > assets/css/vendors/magnific.css',    
      'site > assets/css/site.css'
    );

    $this->layout->navbar = $this->module()->navbar('files');

    $this->page       = $this->module()->page();
    $this->files      = $this->page->files()->filterBy('extension', '!=', 'txt');
    $this->hasFiles   = $this->module()->blueprint()->data('files');
    $this->showThumbs = true;

  }

  public function upload() {

    $this->layout('shared > iframe');

    $fields = array(
      'file' => array(        
        'label' => l::get('files.upload.choose'),
        'type'  => 'file',
        'focus' => true
      ),      
    );

    $this->set('page', $this->module()->page());
    $this->set('alert', '');

    $this->set('form', new Form($fields, array(      
      'upload' => true,
      'buttons' => array(
        'cancel' => l::get('cancel'), 
        'submit' => l::get('files.upload.button')
      )
    )));
    
    if($this->submitted()) {
  
      $root   = $this->page->root() . DS . ':safeFilename';
      $upload = new Upload('file', $root);

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

  public function edit() {

    $this->layout('shared > iframe');
    
    $file = $this->module()->currentFile();

    $fields = array(
      'name' => array(
        'label'     => l::get('files.edit.filename'),
        'type'      => 'text',
        'autofocus' => true
      ),
    );

    $data = array(
      'name' => $file->name()
    );

    $this->set('form', $this->form($fields, $data, l::get('files.edit.button'))); 

    if($this->submitted()) {

      $f = new FileModel($file);
      $f->changeName(get('name'));

      $this->respond($f, 'The filename has been changed');

    }

  }

  public function replace() {

    $this->layout('shared > iframe');
    
    $file = $this->module()->currentFile();

    $fields = array(
      'file' => array(        
        'label' => l::get('files.replace.choose'),
        'type'  => 'file',
        'focus' => true
      ),      
    );

    $this->form = new Form($fields, array(
      'upload' => true,
      'buttons' => array(
        'cancel' => l::get('cancel'), 
        'submit' => l::get('files.replace.button')
      )
    ));
    
    if($this->submitted()) {
  
      $upload = new Upload('file', $file->root(), array(
        'allowed' => $file->mime()
      ));

      if($upload->failed()) {
        // $this->alert = $this->snippet('shared > alert', array('message' => $upload->message()), $return = true);    
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

  public function delete() {

    $this->layout('shared > iframe');
    
    $file = $this->module()->currentFile();

    $fields = array(
      'html' => array(
        'type' => 'html',
        'html' => 'Do you really want to delete <br /><strong>' . html($file->filename()) . '</strong><br /><em>There\'s no undo!</em>'
      ),
    );

    $this->form = $this->form($fields, null, l::get('files.delete.button'), 'DELETE'); 

    if($this->submitted('DELETE')) {

      $f = new FileModel($file);

      if($f->delete()) {
        $this->success('The file has been deleted');
      } else {
        $this->error('The file could not be deleted');
      }

    }
    
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
