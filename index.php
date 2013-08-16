<?php

/**
 * Kirby Panel index file
 * This file is located in the main directory of the Kirby panel
 * and loads the panel bootstrapper
 *
 * @package Kirby Panel
 */

// load the bootstrapper
include(__DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php');

// run the app
app::run();