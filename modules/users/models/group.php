<?php

// direct access protection
if(!defined('KIRBY')) die('Direct access is not allowed');

/**
 * Group
 * 
 * @package   Kirby Panel
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://getkirby.com/license
 */
class Group extends Model {

  protected $primaryKeyName = 'name';

  /**
   * Returns all users in this group
   * 
   * @return object PanelUsers
   */
  public function users() {
    return app()->users()->filterBy('group', $this->name());
  }

  /**
   * Returns the group file 
   * 
   * @return string
   */
  protected function file() {
    return KIRBY_PROJECT_ROOT_PANEL_GROUPS . DS . strtolower($this->name()) . '.php';
  }

  /**
   * Load the group by name
   * 
   * @param string $name
   * @return array
   */
  static public function load($name) {

    // check for an existing user account file
    $file = KIRBY_PROJECT_ROOT_PANEL_GROUPS . DS . strtolower($name) . '.php';
    
    if(!file_exists($file)) return false;
    
    // load the account credentials    
    content::start();
    require($file);
    $group = content::stop();
    $group = yaml($group);

    if(!is_array($group)) return false;

    // check for required fields
    $missing = a::missing($group, array('name'));
    
    if(!empty($missing)) return false;

    // add the id
    $group['name'] = $name;
    
    return new self($group);
  
  }

  protected function store() {
  
    if(!@touch($this->file())) {
      $this->raise('store', 'The group file is not writable');
      return false;
    }

    $content = array();

    $content[] = '<?php if(!defined(\'KIRBY\')) exit ?>';
    $content[] = '';
    
    foreach($this->toArray() as $key => $value) {
      $content[] = strtolower($key) . ': ' . $value;
    }

    if(f::write($this->file(), implode(PHP_EOL, $content))) {
      if(!$this->isNew() && $this->name != $this->old('name')) {
        // delete the old group account file
        f::remove(KIRBY_PROJECT_ROOT_PANEL_GROUPS . DS . strtolower($this->old('name')) . '.php');
      }
      return true;
    } else {
      return false;
    }   
  
  }

  public function isNew() {
    return !$this->old('name');
  }

  protected function validate() {

    // on new groups or groups with a new name, make sure that 
    // this won't overwrite an existing group
    if($this->old('name') != $this->name() and app()->groups()->get($this->name)) {
      $this->raise('name', 'The group name is already taken');
    }

    $this->v(array(
      'name' => array('required', 'min' => 3),
    ));

  }

  protected function insert() {
    return $this->store();
  }

  protected function update() {
    return $this->store();
  }

  public function delete() {    
    // delete the user account file next
    return f::remove($this->file());    
  }

}