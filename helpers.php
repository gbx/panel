<?php

// direct access protection
if(!defined('KIRBY')) die('Direct access is not allowed');

/**
 * Parses yaml structured text
 * 
 * @param string $text
 * @return string parsed text
 */
if(!function_exists('yaml')) {

  require_once(KIRBY_PANEL_ROOT_VENDORS . DS . 'yaml' . DS . 'yaml.php');

  function yaml($string) {
    return spyc_load(trim($string));
  }

}