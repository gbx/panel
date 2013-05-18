<?php

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

    $this->layout->header = $this->module()->header('content', false);

    $page      = $this->module()->page();
    $blueprint = $this->module()->blueprint();
    $content   = $page->content();
    $data      = ($content) ? $content->data() : array();

    $this->alert      = '';
    $this->hasContent = ($data) ? true : false;
    $this->form       = new PanelForm($blueprint->fields(), $data, array(
      'buttons' => array(
        'cancel' => l::get('cancel'), 
        'submit' => 'Save'
      ),
    ));

    if($this->submitted()) {

      $pageModel = new PageModel($page);
      $pageModel->save($this->params());

      if($pageModel->valid()) {
        $this->redirect($this->module()->pageURL($page, 'content'));
      } else {
        $this->alert = app()->snippet('shared > alert', array(
          'message' => $pageModel->error()
        ), $return = true);
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
