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

  public function link() {

    $this->layout = new Layout('shared > iframe');
    $this->layout->content = new View($this);
    $this->layout->content->form = new Form(array(
      'url' => array(
        'label'       => 'Link',
        'placeholder' => 'http://',
        'autofocus'   => true,
        'type'        => 'text'
      ),
      'text' => array(
        'label' => 'Text (optional)',
        'type'  => 'text'
      )
    ), array(
      'buttons' => array(
        'cancel' => l::get('cancel', 'Cancel'), 
        'submit' => 'Insert'
      )
    ));

  }

  public function email() {

    $this->layout = new Layout('shared > iframe');
    $this->layout->content = new View($this);
    $this->layout->content->form = new Form(array(
      'url' => array(
        'label'       => 'Email',
        'autofocus'   => true,
        'type'        => 'text'
      ),
      'text' => array(
        'label' => 'Text (optional)',
        'type'  => 'text'
      )
    ), array(
      'buttons' => array(
        'cancel' => l::get('cancel', 'Cancel'), 
        'submit' => 'Insert'
      )
    ));

  }

}
