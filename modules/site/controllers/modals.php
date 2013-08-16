<?php

use Kirby\Form;

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

  public function image($uri) {

    $this->layout = new Layout('shared > iframe');
    $this->layout->content = new View($this);
    $this->layout->content->page = $this->module()->page($uri);
    $this->layout->content->form = new Form(array(), array(
      'buttons' => array(
        'cancel' => l::get('cancel', 'Cancel'), 
        'submit' => false
      )
    ));
        
  }

}
