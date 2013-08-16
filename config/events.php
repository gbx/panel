<?php 

// register an error handler for all major app errors
event::on('kirby.app.error', function($exception) {
  dump($exception);
}, $overwrite = true);
