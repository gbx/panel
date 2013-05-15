<?php

// direct access protection
if(!defined('KIRBY')) die('Direct access is not allowed');

/**
 * Merges default options with passed parameters and
 * returns a Collection of those options. 
 * This is perfect to be used with classes, which 
 * need fancy option handling
 * 
 * @param array $defaults An array of default options
 * @param array $params An array of params, which should overwrite the defaults
 * @return object Collection
 */
function options($defaults = array(), $params = array()) {
  return new Collection(array_merge($defaults, $params));
}

/**
 * Thumbnail creator
 */
function PanelThumb($obj, $options = array(), $tag = true) {
  $thumb = new PanelThumb($obj, $options);
  return ($tag) ? $thumb->tag() : $thumb->url();
}

/**
 * Parses yaml structured text
 * 
 * @param string $text
 * @return string parsed text
 */
if(!function_exists('yaml')) {

  require_once(ROOT_KIRBY_PANEL_VENDORS . DS . 'yaml.php');

  function yaml($string) {
    return spyc_load(trim($string));
  }

}