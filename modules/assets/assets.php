<?php

/**
 * Assets Pipe Module
 * 
 * @package Kirby Panel
 */
class AssetsModule extends Module {

  public function routes() {
    route::register('assets/css/(:any)/(:all)',    'assets > assets::css');
    route::register('assets/js/(:any)/(:all)',     'assets > assets::js');
    route::register('assets/images/(:any)/(:all)', 'assets > assets::images');
  }

  public function combinations() {

    return array(
      'js' => array(
        'assets/js/shared/jquery.plugins.js' => array(
          'assets/js/shared/moment.js', 
          'assets/js/shared/jquery.ui.js', 
          'assets/js/shared/jquery.magnific.js',
          'assets/js/shared/jquery.pikaday.js',          
          'assets/js/shared/jquery.autosize.js',          
        )
        )
    );

  }

}