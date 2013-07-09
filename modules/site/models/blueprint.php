<?php

class Blueprint {

  protected $template = null;
  protected $root = null;
  protected $data = null;

  public function __construct($template) {
    $this->template = $template;
  }

  public function template() {
    return $this->template;
  }

  public function uid() {
    return $this->template;
  }

  public function title() {
    return a::get($this->data(), 'title', $this->template);
  }

  public function root() {
    if(!is_null($this->root)) return $this->root;

    $root = KIRBY_SITE_ROOT_PANEL_BLUEPRINTS . DS . $this->template . '.php';

    if(!file_exists($root)) {
      $root = KIRBY_SITE_ROOT_PANEL_BLUEPRINTS . DS . c::get('tpl.default', 'default') . '.php';
    }

    return $this->root = $root;
  
  }

  public function exists() {
    return file_exists($this->root());
  }

  public function data($key = null, $default = null) {

    if(!is_null($key)) {
      return a::get($this->data(), $key, $default);
    }

    if(!is_null($this->data)) return $this->data;

    if(!file_exists($this->root())) return array();

    try {

      content::start();
      $data = require($this->root());
      content::stop();

      if(!is_array($data)) throw new Exception('not an array');

    } catch(Exception $e) {

      $data = f::read($this->root());
      $data = yaml($data);
      
      array_shift($data);

    }

    return $this->data = $data;

  }

  public function fields() {
    return a::get($this->data(), 'fields', array());
  }

  public function files() {
    return a::get($this->data(), 'files');  
  }

  public function pages() {
    return a::get($this->data(), 'pages');  
  }

  public function build() {
    return a::get($this->data(), 'build');
  }

  public function keys() {
    return array_keys($this->fields());
  }

  public function isHidden() {
    return a::get($this->data(), 'hidden') or $this->template == 'site';
  }

  public function sort() {
    $pages = $this->pages();
    return a::get($pages, 'sort');
  }

  public function limit() {
    $pages = $this->pages();
    return a::get($pages, 'limit', 10);
  }

  public function templates() {

    $pages     = $this->pages();
    $templates = array();

    if(@$pages['template']) {

      if(is_array($pages['template'])) {
        $templates = $pages['template'];   
      } else {
        $templates[] = $pages['template'];
      }

    } else {

      $files = dir::read(KIRBY_SITE_ROOT_PANEL_BLUEPRINTS);
      
      foreach($files as $file) {

        $name = f::name($file);

        // check if it is valid or already there.
        if(empty($name) || in_array($name, $templates)) continue;

        // add it to the list of templates
        $templates[] = $name;            

      }
      
    }

    $result = array();

    foreach($templates as $template) {      
      $blueprint = new Blueprint($template);
      if(!$blueprint->isHidden()) $result[$template] = $blueprint;
    }
            
    return $result;  
  
  }

}