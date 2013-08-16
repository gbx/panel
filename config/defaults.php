<?php

// all routes with the auth filter redirect to the login 
// page if the user is not logged in yet
router::filter('auth', function() {
  if(!site::instance()->user()) redirect::to('login');
});