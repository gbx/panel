<?php

class SharedModule extends Module {
  
  protected $name   = 'shared';
  protected $layout = 'shared > iframe';

  public function routes() {
    
    router::get('insert/link',  'shared > modals::link');
    router::get('insert/email', 'shared > modals::email');
    router::get('insert/image', 'shared > modals::image');

  }

}
