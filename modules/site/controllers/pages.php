<?php

/**
 * Pages
 * 
 * @package   Kirby Panel
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://getkirby.com/license
 */
class PagesController extends Controller {

  public function index() {

    $this->layout->header = $this->module()->header('pages', false);

    $this->page     = $this->module()->page();
    $this->children = $this->page->children();
    $this->hasPages = $this->module()->blueprint()->data('pages');

  }

  public function add() {
    
    $this->layout('shared > iframe');

    $this->page = $this->module()->page();

    $templates = array();

    foreach($this->module()->blueprint()->templates() as $template) {
      $templates[ $template->uid() ] = $template->title();
    }

    $fields = array(
      'title' => array(
        'label' => l::get('pages.add.label.title'),
        'type'  => 'text',
        'focus' => true,
      ),
      'template' => array(
        'label'    => l::get('pages.add.label.template'),
        'type'     => 'select',
        'options'  => $templates, 
        'selected' => ''
      ), 
    );

    $this->form = $this->form($fields, null, 'Add');

    if($this->submitted()) {

      try {
        PageModel::create($this->page, get('title'), get('template'));
        $this->success('The page has been created');
      } catch(Exception $e) {
        $this->error($e->getMessage());        
      } 
      
    }

  }

  public function delete() {

    $this->layout('shared > iframe');

    $this->page = $this->module()->page();

    // switch off the submit button on home and error pages
    $submit = r($this->page->isHomePage() or $this->page->isErrorPage(), false, 'Delete');

    $this->form = $this->form(array(), null, $submit, 'DELETE');

    if($this->submitted('DELETE')) {

      $p = new PageModel($this->page);
      if($p->delete()) {
        $this->success('The page has been deleted');
      } else {
        $this->error('The page could not be deleted');
      }

    }


  }

  public function move() {

    $this->layout('shared > iframe');
    $this->page = $this->module()->page();

    if($this->page->isHomePage() or $this->page->isErrorPage()) {

      $fields = array();
      $submit = false;

    } else {

      // options for the select box
      $options = array();

      foreach($this->module()->site()->children()->index() as $item) {
        $options[ $item->uri() ] = str_repeat('-', ($item->depth() - 1)) . ' ' . $item->title();
      }

      $fields = array(
        'parent' => array(
          'label'   => 'New parent',
          'options' => $options,
          'type'    => 'select',
          'focus'   => true
        )
      );

      $submit = 'Move';

    }

    $this->form = $this->form($fields, null, $submit);

  }

  public function url() {

    $this->layout('shared > iframe');

    $this->page = $this->module()->page();

    if($this->page->isHomePage() or $this->page->isErrorPage()) {

      $fields = array();
      $submit = false;

    } else {

      $fields = array(
        'url' => array(
          'label' => 'URL',
          'type'  => 'text', 
          'focus' => true
        )
      );

      $submit = 'Move';

    }

    $this->form = $this->form($fields, array('url' => $this->page->uid()), $submit);

    if($this->submitted()) {

      $p = new PageModel($this->page);
      $p->changeURL(get('url'));

      $this->respond($p, 'The page has been moved');

    }


  }

  public function template() {

    $this->layout('shared > iframe');

    $this->set('page', $this->module()->page());

    if($this->page->isHomePage() or $this->page->isErrorPage()) {

      $fields = array();
      $submit = false;

    } else {

      // options for the select box
      $options = array();

      $fields = array(
        'template' => array(
          'label'   => 'New Template',
          'options' => $options,
          'type'    => 'select', 
          'focus'   => true
        )
      );

      $submit = 'Change';

    }
    
    $this->form = $this->form($fields, null, $submit);

  }

  public function stats() {

    $this->layout('shared > iframe');
    $this->form = $this->form(array(), array(), $submit = false);
  
  }

  protected function form($fields, $data, $submit = 'Save', $method = 'POST') {
    return new PanelForm($fields, $data, array(
      'method' => $method,
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

}
