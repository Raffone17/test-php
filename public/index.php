<?php
  /**
  * Wellcome to MyFramework
  * This is a really simple framwork wrote in php, with the MVC model.
  *
  * At thte start is defined the Directory separetor and the application Root directory.
  * @var string
  * @author Raffone
  */
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));

  /**
  * Reqeust the actual url
  * and reqire the Bootstrap file, used for start the application.
  * @var string
  *
  */

$url = $_SERVER['REQUEST_URI'];

//echo "URL: ".$url. "<br>";

require_once (ROOT . DS . 'library' . DS . 'Bootstrap.php');

//echo $text_all;
exit();
