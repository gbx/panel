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

  public function link() {

    $this->layout('shared > iframe');

    $fields = array(
      'url' => array(
        'label'       => 'Link',
        'placeholder' => 'http://',
        'focus'       => true,
        'type'        => 'text'
      ),
      'text' => array(
        'label' => 'Text (optional)',
        'type'  => 'text'
      )
    );

    $this->form = new PanelForm($fields, null, array(
      'buttons' => array('cancel' => l::get('cancel'), 'submit' => 'Insert')
    ));

  }

  public function email() {

    $this->layout('shared > iframe');

    $fields = array(
      'url' => array(
        'label'       => 'Email',
        'focus'       => true,
        'type'        => 'text'
      ),
      'text' => array(
        'label' => 'Text (optional)',
        'type'  => 'text'
      )
    );

    $this->form = new PanelForm($fields, null, array(
      'buttons' => array('cancel' => l::get('cancel'), 'submit' => 'Insert')
    ));

  }

  public function image() {
    
    $this->layout('shared > iframe');
    $this->layout->js = array(
      'shared > assets/js/modals/image.js'
    );
    $this->layout->css = array(
      'shared > assets/js/modals/image.css'
    );

    $this->form = new PanelForm(array(), null, array(
      'buttons' => array('cancel' => l::get('cancel'), 'submit' => 'Insert')
    ));

  }

}
