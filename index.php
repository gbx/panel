<?php

/**
 * Kirby Panel index file
 * This file is located in the main directory of the Kirby panel
 * and loads the roots.php if available as well as the panel/system.php
 *
 * @package Kirby Panel
 */

// define the directory separator for later
define('DS', DIRECTORY_SEPARATOR);

// location of the bootstrap file
$bootstrap = dirname(__FILE__) . DS . 'bootstrap.php';

// check if the bootstrapper exists
if(!file_exists($bootstrap)) die('The panel could not be loaded');  

// load the bootstrapper
include($bootstrap);

// create a exception handler old school style to be compatible with PHP 5.2
$exceptionHandler = create_function('$exception', 'require(KIRBY_PANEL_ROOT_MODALS . DS . "exception.php"); exit();');

// handle thrown exceptions and display a nice error page
set_exception_handler($exceptionHandler);

// initialize the panel
app()->show();

