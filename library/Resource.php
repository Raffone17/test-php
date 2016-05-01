<?php
/** Require the file with the array of routes.**/
require_once (ROOT . DS . 'application' . DS . 'routes.php');
/**  Create a new LogMake, class used for write logs of the application**/
$log = new LogMake(ROOT. DS . 'tmp' . DS . 'logs' . DS . 'applogs.log');
$text_all;
$count_debug=0;

/** Check if environment is development and display errors **/
function setReporting()
{
    if (DEVELOPMENT_ENVIRONMENT == true) {
        error_reporting(E_ALL);
        ini_set('display_errors', 'On');
    } else {
        error_reporting(E_ALL);
        ini_set('display_errors', 'Off');
        ini_set('log_errors', 'On');
        ini_set('error_log', ROOT.DS.'tmp'.DS.'logs'.DS.'php_error.log');
    }
}
/** The autoload function, will load all essential class or files for the application**/
function __autoload($className)
{
  global $text_all;
    if (file_exists(ROOT.DS.'library'.DS.$className.'.php')) {
        require_once ROOT.DS.'library'.DS.$className.'.php';
        $text_all .= '::Autoload: '.$className.'<br>';

    } elseif (file_exists(ROOT.DS.'application'.DS.'controllers'.DS.$className.'.php')) {
        require_once ROOT.DS.'application'.DS.'controllers'.DS.$className.'.php';
          $text_all .= '::Autoload: '.$className.'<br>';

    } elseif (file_exists(ROOT.DS.'application'.DS.'models'.DS.$className.'.php')) {
        require_once ROOT.DS.'application'.DS.'models'.DS.$className.'.php';
          $text_all .= '::Autoload: '.$className.'<br>';

    } else {
        /* Error Generation Code */
        global $log;
        $error = 'Autoload error, Class "'.$className.'" not found!';
        $log->logError($error);
    }
}
/** Clean function, for clean strings from undesired characters or simbols. **/
function clean($string)
{
    $string = str_replace('<', '', $string);
    $string = str_replace('>', '', $string);
    $string = str_replace(';', '', $string);
    $string = str_replace(',', '', $string);
    $string = str_replace('[', '', $string);
    $string = str_replace(']', '', $string);
    $string = str_replace(' ', '_', $string);
    $string = str_replace('%', '', $string);

    return $string;
}

function memoryUsage()
{
  echo "<br>Peak usage: " . memory_get_peak_usage() . " bytes<br>";
  echo "Actualy usage: " . memory_get_usage() . " bytes<br>";
}
function debug($obj,$type = 0)
{
  switch ($type) {

    case 1:
      echo '<pre>';
      var_dump($obj);
      echo '</pre>';
      break;
    case 2:
      print("<pre>".var_export($obj,true)."</pre>");
      break;
    default:
      print("<pre>".print_r($obj,true)."</pre>");
      break;
  }

}

/** Set the php error reporting**/
setReporting();
$text_all .= ++$count_debug.'::setReporting used <br>';
/** Start the routing class and call the urlRoting method **/
$routing = new Route($url,$routes);
$text_all .= ++$count_debug.'::Route class created <br>';
$count_url = $routing->urlRouting();
$text_all .= ++$count_debug.'::Route class funct urlRouting done <br>';
