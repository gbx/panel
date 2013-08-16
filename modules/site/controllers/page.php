<?php

use Kirby\Form;

/**
 * Content 
 * 
 * @package   Kirby Panel
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://getkirby.com/license
 */
class PageController extends Controller {

  public function index($uri) {

    // load additional form buttons
    app::load(array(
      'site > form/buttons/buttons'
    ));

    $page      = $this->module()->page($uri);
    $blueprint = $this->module()->blueprint($page);
    $content   = $page->content();
    $data      = ($content) ? $content->data() : array();
    $files     = $page->files()->filterBy('type', '!=', 'content');

    $this->layout = new Layout('shared > application');
    $this->layout->css = array('assets/css/site/site.css');
    $this->layout->sidebar = $this->module()->sidebar();
    $this->layout->metabar = new Snippet('site > metabar.page', array('page' => $page, 'files' => $files));
    $this->layout->content = new View($this);
    $this->layout->content->page = $page;
    
    $this->layout->content->form = new Form($blueprint->fields(), array(
      'data' => $data,
    ));

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

  public function delete($uri) {

    $page = $this->module()->page($uri);

    $this->layout = new Layout('shared > iframe');
    $this->layout->title = 'Delete page';
    $this->layout->content = new View($this);
    $this->layout->content->page = $page;

    // show the right confirmation message
    if($page->isHomePage()) {
      $message = 'Sorry, but the <strong>home page</strong> cannot be deleted.';
      $submit  = false;
    } else if($page->isErrorPage()) {
      $message = 'Sorry, but the <strong>error page</strong> cannot be deleted.';
      $submit  = false;
    } else if($page->hasChildren()) {
      $message = 'Sorry, but this page still has subpages. <br /><em>Please delete them first.</em>';
      $submit  = false;
    } else {
      $message = 'Do you really want to delete <br /><strong>' . html($page->title()) . '</strong> <br /><em>There\'s no undo!</em>';      
      $submit  = 'Delete';
    }

    $fields = array(
      'html' => array(
        'type' => 'html',
        'html' => $message
      )
    );

    $this->layout->content->form = $this->form($fields, null, $submit, 'DELETE');
    $this->layout->content->form->on('submit', function($form) use ($page) {

      try {
        $page->delete();
        $form->notify('The page has been deleted');
      } catch(\Exception $e) {
        $form->alert('The page could not be deleted');
      }

    });

  }

  public function move($uri) {

    $page = $this->module()->page($uri);

    $this->layout = new Layout('shared > iframe');
    $this->layout->title = 'Move page';
    $this->layout->content = new View($this);
    $this->layout->content->page = $page;

    if($page->isHomePage() or $page->isErrorPage()) {

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

    $this->layout->content->form = $this->form($fields, null, $submit);

  }

  public function url($uri) {

    $page = $this->module()->page($uri);

    $this->layout = new Layout('shared > iframe');
    $this->layout->title = 'Change the URL…';
    $this->layout->content = new View($this);
    $this->layout->content->page = $page;

    if($page->isHomePage() or $page->isErrorPage()) {

      $fields = array();
      $submit = false;

    } else {

      $fields = array(
        'url' => array(
          'label'     => 'URL',
          'type'      => 'text', 
          'autofocus' => true,
          'help'      => $page->parent()->url() . '/<strong>' . $page->uid() . '</strong>'
        )
      );

      $submit = 'Move';

    }

    $this->layout->content->form = $this->form($fields, array('url' => $page->uid()), $submit);
    $this->layout->content->form->on('submit', function($form) use ($page) {
      
      /*
      if($p->move($form->data('url'))) {
        return response::success('The URL has been changed');
      } else {
        return response::error($p);      
      }
      */

    });

  }

  public function template($uri) {

    $page = $this->module()->page($uri);

    $this->layout = new Layout('shared > iframe');
    $this->layout->title = 'Change the template…';
    $this->layout->content = new View($this);
    $this->layout->content->page = $page;

    if($page->isHomePage() or $page->isErrorPage()) {

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
          'autofocus' => true, 
        )
      );

      $submit = 'Change';

    }
    
    $this->layout->content->form = $this->form($fields, null, $submit);
    $this->layout->content->form->on('submit', function($form) use ($page) {

      try {
        $page->changeTemplate($form->data('template'));
        return response::success('The template has been changed');
      } catch(\Exception $e) {
        return response::error($e->getMessage());
      }

    });

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
        'cancel' => l::get('cancel', 'Cancel'),
        'submit' => $submit
      )
    ));

  }

}
