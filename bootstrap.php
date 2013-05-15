<?php

/**
 * Kirby App Bootstrapper
 */

// direct access protection
if(!defined('KIRBY')) define('KIRBY', true);

// store the directory separator in something simpler to use
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

// store the main panel root
if(!defined('ROOT_KIRBY_PANEL')) define('ROOT_KIRBY_PANEL', dirname(__FILE__));
if(!defined('ROOT_KIRBY_APP'))   define('ROOT_KIRBY_APP',   ROOT_KIRBY_PANEL . DS . 'app');

// relative app stuff
if(!defined('ROOT_KIRBY_APP_MODULES')) define('ROOT_KIRBY_APP_MODULES', ROOT_KIRBY_PANEL . DS . 'modules');

// define the main app class
define('KIRBY_APP_CLASS', 'Panel');

// define related roots
define('ROOT_KIRBY_PANEL_LIB',       ROOT_KIRBY_PANEL . DS . 'lib');
define('ROOT_KIRBY_PANEL_LANGUAGES', ROOT_KIRBY_PANEL . DS . 'languages');
define('ROOT_KIRBY_PANEL_FIELDS',    ROOT_KIRBY_PANEL . DS . 'fields');
define('ROOT_KIRBY_PANEL_MODALS',    ROOT_KIRBY_PANEL . DS . 'modals');
define('ROOT_KIRBY_PANEL_VENDORS',   ROOT_KIRBY_PANEL . DS . 'vendors');

// TODO: replace this with a proper setup of roots
define('ROOT', dirname(ROOT_KIRBY_PANEL));
define('ROOT_KIRBY',   ROOT . DS . 'kirby');
define('ROOT_CONTENT', ROOT . DS . 'content');
define('ROOT_SITE',    ROOT . DS . 'site');

// Use the Site Toolkit 
define('ROOT_KIRBY_TOOLKIT', ROOT_KIRBY . DS . 'toolkit');

// load the blueprints
define('ROOT_SITE_PANEL',            ROOT_SITE . DS . 'panel');
define('ROOT_SITE_PANEL_CONFIG',     ROOT_SITE_PANEL . DS . 'config');
define('ROOT_SITE_PANEL_BLUEPRINTS', ROOT_SITE_PANEL . DS . 'blueprints');
define('ROOT_SITE_PANEL_ACCOUNTS',   ROOT_SITE_PANEL . DS . 'accounts');
define('ROOT_SITE_PANEL_GROUPS',     ROOT_SITE_PANEL . DS . 'groups');


// load the app
require_once(ROOT_KIRBY_APP . DS . 'bootstrap.php');


/**
 * Loads all missing panel classes on demand
 * 
 * @param string $class The name of the missing class
 * @return void
 */
function panelLoader($class) {

  $file = ROOT_KIRBY_PANEL_LIB . DS . r($class == 'Panel', 'panel', strtolower(str_replace('Panel', '', $class))) . '.php';

  if(file_exists($file)) {
    require_once($file);
    return;
  } 

}

// register the autoloader function
spl_autoload_register('panelLoader');

// load the default config values
require_once(ROOT_KIRBY_PANEL . DS . 'defaults.php');

// load the helper functions
require_once(ROOT_KIRBY_PANEL . DS . 'helpers.php');
