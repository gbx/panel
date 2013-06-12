<?php

class InstallationModule extends Module {

  protected $title  = 'Installation';
  protected $name   = 'installation';
  protected $layout = 'shared > blank';

  public function url() {
    return app()->url();
  }

}
