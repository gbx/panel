<?php

class InstallationModule extends Module {

  public function routes() {

    route::register(array(
      'install' => array(
        'action' => 'installation > installation::index', 
        'method' => 'GET|POST'
      )
    ));

  }

}
