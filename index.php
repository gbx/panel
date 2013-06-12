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
$bootstrap = __DIR__ . DS . 'bootstrap.php';

// check if the bootstrapper exists
if(!file_exists($bootstrap)) die('The panel could not be loaded');  

// load the bootstrapper
include($bootstrap);

// handle thrown exceptions and display a nice error page
set_exception_handler(function($exception) {
  require(KIRBY_PANEL_ROOT_MODALS . DS . "exception.php"); 
  exit();  
});

// initialize the panel
app()->show();

