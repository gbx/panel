<?php

class SharedModule extends Module {
  
  protected $name = 'shared';
  protected $visible = false;

  public function routes() {
    
    router::get('insert/link',  'shared > modals::link');
    router::get('insert/email', 'shared > modals::email');

  }

}
