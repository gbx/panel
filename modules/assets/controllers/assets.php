<?php

/**
 * Assets Controller
 * 
 * @package Kirby Panel
 */
class AssetsController extends Controller {

  public function css($module, $path) {
    $asset = $this->asset($module, $path, 'css');
    return new Response($asset, 'css');
  }

  public function js($module, $path) {
    $asset = $this->asset($module, $path, 'js');
    return new Response($asset, 'js');
  }

  public function images($module, $path) {
    $asset = $this->asset($module, $path, 'images');  
    return new Response($asset, f::extension($path));
  }

  protected function asset($module, $path, $type) {

    $module = app::module($module);

    if(!$module) raise('Module not found', 404);

    $file  = $module->root() . DS . 'assets' . DS . $type . DS . $path;
    $cache = KIRBY_PANEL_ROOT . DS . 'assets' . DS . $type . DS . $module->name() . DS . $path;

    // check for a combination
    if($content = $this->combine($type)) {
      // content var is already set
    } else {

      $asset = new Asset($file, url::current());
      if(!$asset->exists()) raise('Asset not found', 404);
      $content = $asset->read();

    }

    /*
    dir::make(dirname($cache), true);
    f::write($cache, $content);
    */

    return $content;

  }

  protected function combine($type) {

    $setup = $this->module()->combinations();
    $path  = (string)app::uri()->path();
    $setup = a::get($setup, $type . ' > ' . $path);  

    if(!$setup) return false;

    $content = array();

    foreach($setup as $component) {

      preg_match('!assets\/(js|css|images)\/(.*?)\/(.*)!', $component, $match);

      if(empty($match) or count($match) != 4) continue;

      $type   = @$match[1];
      $module = app::module(@$match[2]);
      $path   = @$match[3];

      if(empty($type) or !$module or empty($path)) continue;

      // build the full root to the file
      $root = $module->root() . DS . 'assets' . DS . $type . DS . $path;

      if(!file_exists($root)) continue;

      // get the content
      $content[] = f::read($root);

    }

    return implode(PHP_EOL . PHP_EOL, $content);

  }

}