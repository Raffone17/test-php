<?php
/**
 *  ROUTE.
 */
/**
 * Route class
 * The principal function of this class is elaborate the routing of the appication.
 *
 * @version v0.1.0
 *
 * @author Raffone
 */
class Route
{
    private $url;
    private $routes;
    public static $counturl;

    public function __construct($url, $routes)
    {
        $this->url = $url;
        //$this->url=$_SERVER['REQUEST_URI'];
        $this->routes = $routes;
    }
    /** Routing method, used for check the url and set the controller and there methods from the routes array.**/
    public function urlRouting()
    {
        $requested_variabiles = 0;
        $counturl = 0;


        //****$result = routingAction($this->routes,$this->url,$counturl);*****cpp
        // ------- start routing --------
        // check if there is a '?' simbol in the url, and delete everything come after.
        if (strstr($this->url, '?')) {
            $this->url = substr($this->url, 0, strpos($this->url, '?'));
        }

        // initialize routes array and variable array
        $routes = $this->routes;
        $variable_array = array();


        $url_array = urldecode($this->url);
        //$url_array = clean($url_array);


        // check if there is public in the url, and delete everything before. For development enviroment
        $url_array = explode('/', $url_array);
        if (in_array('public', $url_array)) {
            while ($url_array[0] !== 'public') {
                array_shift($url_array);
            }

        }
        array_shift($url_array);
        // check if there is the SERVER_NAME in the begin of the url, and delete that.


        foreach ($url_array as $route) {
            $route = trim($route);
        }
        $counturl = count($url_array);

        foreach ($routes as $uri => $route) {
            //echo $uri.' <br> ';
          foreach ($route as $control => $funct) {
              //echo $uri.' '.$control.' '.$funct.' '.$url_array[0].' array_intersect:<br> ';
              //print_r($url_array);
            $uri_route = explode('/', $uri);

          //echo count($uri_array);

              $method = array_shift($uri_route);

              $url_variables = 0;
              $same = true;
              if (count($url_array) != count($uri_route) || $method != $_SERVER['REQUEST_METHOD'].':') {
                  $same = false;
              } else {
                  for ($i = 0; $i < count($uri_route) && $same == true; $i++) {
                      //echo "analizziamo: ".$uri_array[$i]."  ".$url_array[$i]."<br>";
                    //if (isset($uri_route[$i]) && isset($url_array[$i])) {
                        if (substr($uri_route[$i], 0, 1) == '{' && substr($uri_route[$i], -1) == '}') {
                            ++$url_variables;
                            array_push($variable_array, $url_array[$i]);
                        } elseif ($uri_route[$i] !== $url_array[$i]) {
                            $same = false;
                          //echo "diverso ".$uri_array[$i]."  ".$url_array[$i]."<br>";
                        }

                  }

              }
              if ($same == true) {
                  $controller_action = $funct;

                  $controller = $control;

                  break 2;
              }else{
                $variable_array = array();
              }
          }
        }
        if ($same == false) {
            $method = 'GET:';

        }

        if (empty($controller_action)) {
            $controller_action = 'error';
            $controller = 'Controller';
        }
        if ($controller == 'SetView') {
            $controller_action = 'SetView:'.$controller_action;
            $controller = 'Controller';
        }
        // ---- end routing ------
        /******$method = array_shift($result);
        $controller = array_shift($result);
        $controller_action = array_shift($result);***cpp***/

        //****$dispatch = new $controller($result, $controller_action, $method);*****cpp
        $dispatch = new $controller($variable_array, $controller_action, $method);

        self::$counturl = $counturl;

        return $counturl;
    }
    /** Secure assets, fuction for prevent error of loading css and public files in views.**/
    public static function secure_assest($text)
    {
        $counturl = self::$counturl;

        echo '"';
        for ($i = 1; $i < $counturl; ++$i) {
            echo '..'.DS;
        }
        echo $text;
        echo '"';
    }
    public static function secure_route($route)
    {
        echo '"';
        echo APP_NAME.DS.'public'.$route;
        echo '"';
    }
}
