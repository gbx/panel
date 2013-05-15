<?php

class ModalsController extends Controller {

  public function link() {

    $this->layout('shared > iframe');
    $this->layout->js = array(
      'shared > assets/js/modals/link.js'
    );

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
    $this->layout->js = array(
      'shared > assets/js/modals/email.js'
    );

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


}
