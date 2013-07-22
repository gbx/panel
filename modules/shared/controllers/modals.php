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

    $fields = array(
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
    );

    $this->form = new Form($fields, array(
      'buttons' => array('cancel' => l::get('cancel'), 'submit' => 'Insert')
    ));

  }

  public function email() {

    $fields = array(
      'url' => array(
        'label'       => 'Email',
        'autofocus'   => true,
        'type'        => 'text'
      ),
      'text' => array(
        'label' => 'Text (optional)',
        'type'  => 'text'
      )
    );

    $this->form = new Form($fields, array(
      'buttons' => array('cancel' => l::get('cancel'), 'submit' => 'Insert')
    ));

  }

  public function image() {
    
    $this->layout->js = array(
      'shared > assets/js/modals/image.js'
    );
    $this->layout->css = array(
      'shared > assets/js/modals/image.css'
    );

    $this->form = new Form(array(), array(
      'buttons' => array('cancel' => l::get('cancel'), 'submit' => 'Insert')
    ));

  }

}
