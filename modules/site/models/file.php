<?php

class FileModel extends Model {

  protected $file = null;

  public function __construct($file) {
    $this->file = $file;
    parent::__construct(array());
  }

  public function delete() {
    return f::remove($this->file->root());
  }

  public function changeName($name) {

    // slugify the name to be sure it's not broken
    $name = str::slug($name);  

    // check for a valid name
    if(!v::min($name, 1)) return $this->raise('name', 'The name is too short');

    // create the full path
    $path = $this->file->dir() . DS . $name . '.' . $this->file->extension();

    // try to move the file
    if(!f::move($this->file->root(), $path)) return $this->raise('name', 'The file could not be moved');

    return true;

  }


}
