<?php

use Kirby\Form;

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

    $this->layout->css = array(
      'site > assets/css/site.css'
    );

    // navbar 
    $this->layout->navbar = $this->module()->navbar('pages');

    // the entire subpages view
    $this->subpages = $this->module()->subpages();

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
        'label'     => l::get('pages.add.label.title'),
        'type'      => 'text',
        'autofocus' => true,
      ),
      'template' => array(
        'label'     => l::get('pages.add.label.template'),
        'type'      => 'select',
        'options'   => $templates, 
        'selected'  => ''
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

    $this->page      = $this->module()->page();
    $this->pageModel = new PageModel($this->page);
    $this->deletable = $this->pageModel->isDeletable();

    // show the right confirmation message
    if($this->page->isHomePage()) {
      $this->message = 'Sorry, but the <strong>home page</strong> cannot be deleted.';
      $this->submit  = false;
    } else if($this->page->isErrorPage()) {
      $this->message = 'Sorry, but the <strong>error page</strong> cannot be deleted.';
      $this->submit  = false;
    } else if($this->page->hasChildren()) {
      $this->message = 'Sorry, but this page still has subpages. <br /><em>Please delete them first.</em>';
      $this->submit  = false;
    } else {
      $this->message = 'Do you really want to delete <br /><strong>' . html($this->page->title()) . '</strong> <br /><em>There\'s no undo!</em>';      
      $this->submit  = 'Delete';
    }

    $fields = array(
      'html' => array(
        'type' => 'html',
        'html' => $this->message
      )
    );

    $this->form = $this->form($fields, null, $this->submit, 'DELETE');

    if($this->submitted('DELETE')) {
      if($this->pageModel->delete()) {
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
          'label'     => 'New parent',
          'options'   => $options,
          'type'      => 'select',
          'autofocus' => true
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
          'label'     => 'URL',
          'type'      => 'text', 
          'autofocus' => true
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
          'label'     => 'New Template',
          'options'   => $options,
          'type'      => 'select', 
          'autofocus' => true
        )
      );

      $submit = 'Change';

    }
    
    $this->form = $this->form($fields, null, $submit);

  }

  protected function form($fields, $data, $submit = 'Save', $method = 'POST') {
    return new Form($fields, array(
      'data'   => $data,
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
