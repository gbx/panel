<?php

/**
 * Kirby Panel Bootstrapper
 * 
 * Include this file to load all essential 
 * files to initiate a new Kirby Panel App
 * 
 * @package   Kirby Panel
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://getkirby.com/license
 */

/**
 * Helper constants
 */

if(!defined('KIRBY'))     define('KIRBY',     true);
if(!defined('DS'))        define('DS',        DIRECTORY_SEPARATOR);
if(!defined('MB_STRING')) define('MB_STRING', (int)function_exists('mb_get_info'));

/**
 * Overwritable constants
 * Define them before including the bootstrapper
 * to change essential roots
 */

// location of the panel
if(!defined('KIRBY_PANEL_ROOT')) define('KIRBY_PANEL_ROOT', __DIR__);

// location of the app framework
if(!defined('KIRBY_PANEL_ROOT_APP')) define('KIRBY_PANEL_ROOT_APP', KIRBY_PANEL_ROOT . DS . 'app');

// location of the site's index.php / document root
if(!defined('KIRBY_INDEX_ROOT')) define('KIRBY_INDEX_ROOT', dirname(KIRBY_PANEL_ROOT));

// location of the kirby cms core
if(!defined('KIRBY_CMS_ROOT')) define('KIRBY_CMS_ROOT', KIRBY_INDEX_ROOT . DS . 'kirby');

// location of the content folder
if(!defined('KIRBY_CONTENT_ROOT')) define('KIRBY_CONTENT_ROOT', KIRBY_INDEX_ROOT . DS . 'content');

// location of the site folder
if(!defined('KIRBY_PROJECT_ROOT')) define('KIRBY_PROJECT_ROOT', KIRBY_INDEX_ROOT . DS . 'site');

/**
 * Fixed constants
 * Those cannot and should not be overwritten
 * 
 * Panel Internals
 */
define('KIRBY_PANEL_ROOT_LIB',       KIRBY_PANEL_ROOT . DS . 'lib');
define('KIRBY_PANEL_ROOT_LANGUAGES', KIRBY_PANEL_ROOT . DS . 'languages');
define('KIRBY_PANEL_ROOT_MODALS',    KIRBY_PANEL_ROOT . DS . 'modals');
define('KIRBY_PANEL_ROOT_VENDORS',   KIRBY_PANEL_ROOT . DS . 'vendors');
define('KIRBY_PANEL_ROOT_MODULES',   KIRBY_PANEL_ROOT . DS . 'modules');

/**
 * project specific panel setup
 */
define('KIRBY_PROJECT_ROOT_PANEL',            KIRBY_PROJECT_ROOT . DS . 'panel');
define('KIRBY_PROJECT_ROOT_PANEL_CONFIG',     KIRBY_PROJECT_ROOT_PANEL . DS . 'config');
define('KIRBY_PROJECT_ROOT_PANEL_BLUEPRINTS', KIRBY_PROJECT_ROOT_PANEL . DS . 'blueprints');
define('KIRBY_PROJECT_ROOT_PANEL_ACCOUNTS',   KIRBY_PROJECT_ROOT_PANEL . DS . 'accounts');
define('KIRBY_PROJECT_ROOT_PANEL_GROUPS',     KIRBY_PROJECT_ROOT_PANEL . DS . 'groups');

/**
 * form setup stuff
 */

define('KIRBY_PANEL_ROOT_FORM',                 KIRBY_PANEL_ROOT . DS . 'form');
define('KIRBY_PANEL_ROOT_FORM_FIELDS',          KIRBY_PANEL_ROOT_FORM . DS . 'fields');
define('KIRBY_PANEL_ROOT_FORM_BUTTONS',         KIRBY_PANEL_ROOT_FORM . DS . 'buttons');

define('KIRBY_PROJECT_ROOT_PANEL_FORM',         KIRBY_PROJECT_ROOT_PANEL . DS . 'form');
define('KIRBY_PROJECT_ROOT_PANEL_FORM_FIELDS',  KIRBY_PROJECT_ROOT_PANEL_FORM . DS . 'fields');
define('KIRBY_PROJECT_ROOT_PANEL_FORM_BUTTONS', KIRBY_PROJECT_ROOT_PANEL_FORM . DS . 'buttons');

/**
 * app setup
 */

// location of modules
define('KIRBY_APP_ROOT_MODULES', KIRBY_PANEL_ROOT . DS . 'modules');

// define the main app class
define('KIRBY_APP_CLASS', 'Panel');

// load the toolkit
require_once(KIRBY_CMS_ROOT . DS . 'toolkit' . DS . 'bootstrap.php');

// load the app
require_once(KIRBY_PANEL_ROOT_APP . DS . 'bootstrap.php');

// initialize the autoloader
$autoloader = new Kirby\Toolkit\Autoloader();

// set the base root where all classes are located
$autoloader->root = KIRBY_PANEL_ROOT_LIB;

// set the global namespace for all classes
$autoloader->namespace = 'Kirby\\Panel';

// add all needed aliases
$autoloader->aliases = array(
);

// start autoloading
$autoloader->start();

// load the main panel class
require_once(KIRBY_PANEL_ROOT . DS . 'panel.php');

// load the default config values
require_once(KIRBY_PANEL_ROOT . DS . 'defaults.php');

// load the helper functions
require_once(KIRBY_PANEL_ROOT . DS . 'helpers.php');

// load the Kirby form plugin
require_once(KIRBY_PANEL_ROOT_VENDORS . DS . 'form' . DS . 'bootstrap.php');
