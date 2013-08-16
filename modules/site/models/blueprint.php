<?php

class Blueprint {

  protected $template = null;
  protected $root = null;
  protected $data = null;

  public function __construct($template) {

    if(is_a($template, 'Kirby\\CMS\\Page')) {
      $this->template = ($template->isSite()) ? 'site' : $template->template();      
    } else {
      $this->template = $template;
    }

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

  public function subpages() {
    return $this->data('subpages', true);
  }

  public function fields() {
    
    // get all fields
    $fields = $this->data('fields', array());

    // convert the title field 
    $fields['title']['type'] = 'title';

    return $fields;

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