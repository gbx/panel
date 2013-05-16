<?php

class PageModel extends Model {

  protected $page = null;

  public function __construct($page) {
    $this->page = $page;
    parent::__construct(array());
  }

  public function cover() {

    if($image = $this->page->images()->first()) {
      return $image;
    } else if($child = $this->page->children()->first()) {
      if($image = $child->images()->first()) {
        return $image;
      } else if($child = $child->children()->first()) {
        if($image = $child->images()->first()) return $image;        
      }
    } 

    return false;

  }

  public function file() {
    if($content = $this->page->content()) {
      return $this->page->content()->root();
    } else {
      return false;
    }
  }

  public function data() {
    if($content = $this->page->content()) {
      return $content->data();
    } else {
      return array();
    }
  }

  public function validate() {

    if(!v::min($this->get('title'), 1)) $this->raise('title', 'The title is missing');

    return true;    
  
  }

  public function save($data = array()) {

    if(!$this->file()) return $this->raise('file', 'The content file is missing');

    $blueprint = new Blueprint($this->page->template());
    $keys      = $blueprint->keys();

    foreach($keys as $key) {
      $this->set($key, a::get($data, $key));
    }

    // validate
    $this->validate();

    // only save if everything is ok
    if($this->valid()) return txtstore::write($this->file(), $this->toArray());

  }

  public function delete() {
    return dir::remove($this->page->root());
  }

  public function changeURL($uri) {
    
    // make sure the URL is a valid slug
    $uri = str::slug($uri);

    // validate the URL length
    if(!v::min($uri, 1)) return $this->raise('url', 'The URL is too short');

    // create the new directory path
    $dir = $this->page->parent()->root() . DS . ltrim($this->page->num() . '-' . $uri, '-');

    // nothing changed
    if($dir == $this->page->root()) return true;

    // check for duplicates
    if(is_dir($dir)) return $this->raise('url', 'The URL is already taken');

    // try to move the directory
    if(!dir::move($this->page->root(), $dir)) return $this->raise('url', 'The directory could not be moved');

  }

  static public function create($parent, $title, $template, $dirname = null) {

    // build the directory from the given title    
    $uid = ($dirname) ? $dirname : str::slug($title);
    $dir = $parent->root() . DS . $uid;

    if(!v::min($uid, 2)) throw new Exception('The title is too short');

    // check for duplicates
    if(is_dir($dir)) throw new Exception('The page already exists');

    // get the parent blueprint
    $parentBlueprint  = new Blueprint($parent->template());
    $allowedTemplates = $parentBlueprint->templates(); 

    // check for a valid template
    if(!array_key_exists($template, $allowedTemplates)) throw new Exception('The template is not allowed');

    // create the page first
    if(!dir::make($dir)) throw new Exception('The page could not be created');

    // critical stuff which might need to be rolled back
    try {

      // the text file
      $file = $dir . DS . $template . '.txt';

      // create the file with the title
      if(!f::write($file, 'title: ' . $title)) throw new Exception('The content file could not be created');

      // get the current blueprint to check for the build array
      $blueprint = new Blueprint($template);

      // return the Page object
      $page = new Page($dir);
    
      if(is_array($blueprint->build())) {
        foreach($blueprint->build() as $dirname => $build) {
          self::create($page, $build['title'], $build['template'], $dirname);          
        }
      }

      return $page;

    } catch(Exception $e) {

      // roll back
      dir::remove($dir);
      
      // re throw the exception
      throw $e;

    }

  }

}
