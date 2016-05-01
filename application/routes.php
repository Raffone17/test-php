<?php
 /**
  * Routes array
  * Here it's possible to set personal routes in an array.
  * for example "route url" => array ( "controller name" => "controller function or view") .
  * For set directly the view, write "url" => ("SetView" => "view name") .
  *
  * @example 'GET:/home' => array( 'Controller' => 'index' )
  */
$routes = array(
  'GET:/index.php' => array(
    'MyController' => 'homePage'
  ),
  'GET:/' => array(
    'MyController' => 'homePage3'
  ),
  'GET:/home' => array(
    'MyController' => 'homePage'
  ),
  'POST:/users/{id}/ciao/{ancora}' => array(
    'MyController' => 'homePage4'
  ),
  'GET:/add' => array(
    'MyController' => 'homePage2'
  ),
  'GET:/cerca' => array('MyController' => 'cerca'),
  'GET:/home/prova' => array('SetView' => 'home'),
);
