<?php

class ContentController extends AppController {

  public function index() {

    $this->layout->header = $this->module()->header('content', false);
    $this->layout->js = array(
      'site > assets/js/content.js'
    );

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

}
