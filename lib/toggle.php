<?php 

class toggle {

  static public function primary() {
    return html::a('#primary', '<i>-</i><i>-</i><i>-</i>', array('class' => 'toggle'));
  }

  static public function secondary() {
    return html::a('#secondary', '→', array('class' => 'toggle'));
  }

}