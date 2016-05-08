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
  'GET:/users/{id}/ciao/{ancora}' => array(
    'MyController' => 'homePage4'
  ),
  'GET:/add' => array(
    'MyController' => 'homePage2'
  ),
  'GET:/cerca' => array('MyController' => 'cerca'),
  'GET:/home/prova' => array('SetView' => 'home'),
);
/*
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
  'GET:/users' => array(  'MyController' => 'homePage3'),
  'GET:/users/{id}' => array(  'MyController' => 'homePage3'),
  'POST:/users' => array(  'MyController' => 'homePage3'),
  'PUT:/users/{id}' => array(  'MyController' => 'homePage3'),
  'DELETE:/users/{id}' => array(  'MyController' => 'homePage3'),
  'GET:/coktails' => array(  'MyController' => 'homePage3'),
  'GET:/coktails/{id}' => array(  'MyController' => 'cocktails'),
  'POST:/coktails' => array(  'MyController' => 'homePage3'),
  'PUT:/coktails/{id}' => array(  'MyController' => 'cocktails'),
  'DELETE:/coktails/{id}' => array(  'MyController' => 'cocktails'),
  'GET:/locals' => array(  'MyController' => 'homePage3'),
  'GET:/locals/{id}' => array(  'MyController' => 'cocktails'),
  'POST:/locals' => array(  'MyController' => 'homePage3'),
  'PUT:/locals/{id}' => array(  'MyController' => 'cocktails'),
  'DELETE:/locals/{id}' => array(  'MyController' => 'cocktails'),
  'GET:/cerca' => array('MyController' => 'cerca'),
  'GET:/home/prova' => array('SetView' => 'home'),
);*/
