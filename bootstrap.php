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

// try locating a roots.php in the parent directory 
// and load those roots
if(file_exists(KIRBY_PANEL_ROOT . DS . 'roots.php')) require_once(KIRBY_PANEL_ROOT . DS . 'roots.php');

// location of the site's index.php / document root
if(!defined('KIRBY_INDEX_ROOT')) define('KIRBY_INDEX_ROOT', dirname(KIRBY_PANEL_ROOT));

// location of the kirby cms core
if(!defined('KIRBY_CMS_ROOT')) define('KIRBY_CMS_ROOT', KIRBY_INDEX_ROOT . DS . 'kirby');

// location of the content folder
if(!defined('KIRBY_CONTENT_ROOT')) define('KIRBY_CONTENT_ROOT', KIRBY_INDEX_ROOT . DS . 'content');

// location of the site folder
if(!defined('KIRBY_SITE_ROOT')) define('KIRBY_SITE_ROOT', KIRBY_INDEX_ROOT . DS . 'site');

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
define('KIRBY_PANEL_ROOT_CONFIG',    KIRBY_PANEL_ROOT . DS . 'config');

/**
 * project specific panel setup
 */
define('KIRBY_SITE_ROOT_PANEL',            KIRBY_SITE_ROOT . DS . 'panel');
define('KIRBY_SITE_ROOT_PANEL_CONFIG',     KIRBY_SITE_ROOT_PANEL . DS . 'config');
define('KIRBY_SITE_ROOT_PANEL_BLUEPRINTS', KIRBY_SITE_ROOT_PANEL . DS . 'blueprints');
define('KIRBY_SITE_ROOT_PANEL_ACCOUNTS',   KIRBY_SITE_ROOT_PANEL . DS . 'accounts');
define('KIRBY_SITE_ROOT_PANEL_GROUPS',     KIRBY_SITE_ROOT_PANEL . DS . 'groups');

/**
 * form setup stuff
 */
define('KIRBY_PANEL_ROOT_FORM',              KIRBY_PANEL_ROOT . DS . 'form');
define('KIRBY_PANEL_ROOT_FORM_FIELDS',       KIRBY_PANEL_ROOT_FORM . DS . 'fields');
define('KIRBY_PANEL_ROOT_FORM_BUTTONS',      KIRBY_PANEL_ROOT_FORM . DS . 'buttons');

define('KIRBY_SITE_ROOT_PANEL_FORM',         KIRBY_SITE_ROOT_PANEL . DS . 'form');
define('KIRBY_SITE_ROOT_PANEL_FORM_FIELDS',  KIRBY_SITE_ROOT_PANEL_FORM . DS . 'fields');
define('KIRBY_SITE_ROOT_PANEL_FORM_BUTTONS', KIRBY_SITE_ROOT_PANEL_FORM . DS . 'buttons');

// load the toolkit
require_once(KIRBY_CMS_ROOT . DS . 'toolkit' . DS . 'bootstrap.php');

// load the CMS bootstrapper
require_once(KIRBY_CMS_ROOT . DS . 'bootstrap.php');

// load the app
require_once(KIRBY_PANEL_ROOT_APP . DS . 'bootstrap.php');

// load all defaults
require_once(KIRBY_PANEL_ROOT_CONFIG . DS . 'defaults.php');

// load all events
require_once(KIRBY_PANEL_ROOT_CONFIG . DS . 'events.php');

// load all helpers
require_once(KIRBY_PANEL_ROOT . DS . 'helpers.php');

define('KIRBY_FORM_ROOT_CUSTOM_FIELDS',  KIRBY_PANEL_ROOT_FORM_FIELDS);
define('KIRBY_FORM_ROOT_DEFAULT_BUTTONS', KIRBY_PANEL_ROOT_FORM_BUTTONS);

// load the Kirby form plugin
require_once(KIRBY_PANEL_ROOT_VENDORS . DS . 'form' . DS . 'bootstrap.php');

// install modules
app::modules(KIRBY_PANEL_ROOT_MODULES);

// initiate the site object
site::instance(array(
  'url'       => dirname(app::url()),
  'subfolder' => dirname(app::uri()->subfolder())
));