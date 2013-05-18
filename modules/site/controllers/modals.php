<?php

/**
 * Form Button Modals
 * 
 * @package   Kirby Panel
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://getkirby.com/license
 */
class ModalsController extends Controller {

  public function image() {
    
    $this->layout('shared > iframe');

    $this->page   = $this->module()->page();
    $this->images = $this->page->images();
    $this->form   = new PanelForm(array(), null, array(
      'buttons' => array('cancel' => l::get('cancel'), 'submit' => false)
    ));

  }

}
