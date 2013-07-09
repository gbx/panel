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
class ContentController extends Controller {

  public function index() {

    $this->layout->css = array(
      'site > assets/css/site.css'
    );

    $this->layout->navbar = $this->module()->navbar('content');

    $page      = $this->module()->page();
    $blueprint = $this->module()->blueprint();
    $content   = $page->content();
    $data      = ($content) ? $content->data() : array();

    $this->alert        = '';
    $this->page         = $page;
    $this->hasContent   = ($data) ? true : false;
    $this->hasBlueprint = $blueprint->exists();
    $this->form         = new Form($blueprint->fields(), array(
      'data' => $data,
    ));

    if($this->submitted()) {

      $pageModel = new PageModel($page);
      $pageModel->save($this->params());

      if($pageModel->valid()) {
        $this->redirect($this->module()->pageURL($page, 'content'));
      } else {
        $this->alert = $this->snippet('shared > alert', array(
          'message' => $pageModel->error()
        ));
      }

    }

  }

  public function editor() {
    
    site();

    if(r::ajax()) {
      die(kirbytext(get('text')));
    }

    $this->layout('shared > blank');



  }

}
