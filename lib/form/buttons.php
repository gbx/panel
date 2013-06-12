<?php

namespace Kirby\Panel\Form;

use Kirby\Toolkit\A;

// direct access protection
if(!defined('KIRBY')) die('Direct access is not allowed');

/**
 * The Buttons class generates a list of formatting
 * buttons to simplify entering Markdown in textareas
 * 
 * @package   Kirby Panel
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://getkirby.com/license
 */
class Buttons {

  // a list of all installed buttons
  static protected $installed = array();

  // the final array of html lines
  protected $html = array();

  /**
   * Constructor
   * 
   * @param array $active A list of keys of active buttons, which should be rendered
   */
  public function __construct($active = array()) {

    // load all available buttons
    $available = $this->load();
     
    if(is_array($active)) {
      foreach($active as $b) {
        $buttons[] = a::get($available, $b);
      }
    } else {
      $buttons = $available;
    }
                
    $this->html[] = '<nav role="navigation" class="form-buttons">';
    $this->html[] = '<h1 class="is-hidden">Text buttons</h1>';
    $this->html[] = '<ul>';    

    foreach($buttons as $button) $this->html[] = '<li>' . $button . '</li>';    

    $this->html[] = '</ul>';    
    $this->html[] = '</nav>';    
    
    $this->html = implode(PHP_EOL, $this->html);

  }

  /**
   * Add new buttons
   * 
   * @param mixed $key Either a single key or an array of keys and buttons
   * @param string $value The button html
   * @return array Return all installed buttons
   */
  static public function add($key, $value = null) {
    if(is_array($key)) {
      foreach($key as $k => $v) self::add($k, $v);
      return true;
    }
    self::$installed[$key] = $value;
  }

  /**
   * Remove buttons by key
   * 
   * @param mixed Either a single key or an array of keys
   * @return array   
   */
  static public function remove($key) {
    if(is_array($key)) {
      foreach($key as $k) self::remove($k);
      return;
    }
    unset(self::$installed[$key]);
    return self::$installed;
  }

  /**
   * Resort all installed buttons by key
   * 
   * @param array $keys   
   * @return array
   */
  static public function sort($keys) {

    $original = self::$installed;
    $result   = array();

    foreach($keys as $key) {
      if(isset($original[$key])) {
        $result[$key] = $original[$key];
      }
    }

    return self::$installed = $result;

  }

  /**
   * Load all available buttons
   * 
   * @return array
   */
  protected function load() {

    // load the default buttons
    f::load(KIRBY_PANEL_ROOT_FORM_BUTTONS . DS . 'buttons.php');

    // load custom buttons from users
    f::load(KIRBY_PROJECT_ROOT_PANEL_FORM_BUTTONS . DS . 'buttons.php');

    // load custom module buttons
    f::load(app()->module()->root() . DS . 'form' . DS . 'buttons' . DS . 'buttons.php');

    return self::$installed;

  }

  /**
   * Makes it possible to simply echo the class to get the button html
   * 
   * @return string
   */
  public function __toString() {
    return $this->html;
  }

}