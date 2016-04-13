<?php
/**Route class
  *The principal function of this class is elaborate the routing of the appication.
  *
**/

class Route
{
    private $url;
    private $routes;
    public static $counturl;

    public function __construct($url,$routes)
    {


        $this->url = $url;
        //$this->url=$_SERVER['REQUEST_URI'];
        $this->routes = $routes;
    }
    /** Routing method, used for check the url and set the controller and there methods from the routes array.**/
    public function urlRouting()
    {
        $requested_variabiles=0;
        $url = $this->url;

        // check if there is a '?' simbol in the url, and delete everything come after.
        if (strstr($this->url, '?')) $this->url = substr($this->url, 0, strpos($this->url, '?'));

        // initialize routes array and variable array
        $routes = $this->routes;
        $variable_array = array();


        $url_array = $this->url;
        $url_array = urldecode($url_array);
        //echo $url_array . "<br>";

        $url_array = clean($url_array);
        //echo $url_array;

      //  $url_array= substr($url_array, 0, strpos($url_array, "?"));

        // check if there is public in the url, and delete everything before. For development enviroment
        $url_array = explode('/', $url_array);
        if (in_array('public', $url_array)) {
            while ($url_array[0] !== 'public') {
                array_shift($url_array);
            }
            array_shift($url_array);
        }
        foreach ($url_array as $route) {
            if (trim($route) != '') {
            }
        }
        $counturl = count($url_array);


      /*$controller = array_shift($url_array);
      $action = array_shift($url_array);
      $query_string = array_shift($url_array);
      $model = rtrim($controller, 's'); */

      /* foreach ($routes as $pattern => $view) {
          if($pattern === $controller ){
            $controller_name = $view;

          }
      }*/

      foreach ($routes as $uri => $route) {
          //echo $uri.' <br> ';
        foreach ($route as $control => $funct) {
            //echo $uri.' '.$control.' '.$funct.' '.$url_array[0].' array_intersect:<br> ';
            //print_r($url_array);
            $uri_route = explode('/', $uri);

        //echo count($uri_array);

        $method=array_shift($uri_route);
        /*$requested_variabiles=0;
        foreach ($uri_route as $url_part){
          echo $url_part."<br>";
          echo substr($url_part,1)."<br>";

          if(substr($url_part,1)==='{' && substr($url_part,-1)==='}')
          echo $url_part;
          $requested_variabiles++;
        }
        for($i=0; $i<$requested_variabiles; $i++){
           array_pop($uri_route);
        }*/

        //print_r(array_intersect($uri_array,$url_array));

        //echo '<br>';
            $same = 1;
            if(count($url_array)<count($uri_route)){
              $same = 0;
            }else{
              for ($i = 0; $i < count($uri_route); ++$i) {
                //echo "analizziamo: ".$uri_array[$i]."  ".$url_array[$i]."<br>";
                if(isset($uri_route[$i]) && isset($url_array[$i])){
                  if ($uri_route[$i] !== $url_array[$i]) {
                      $same = 0;
                      //echo "diverso ".$uri_array[$i]."  ".$url_array[$i]."<br>";
                  }
                }
              }
          }
            if ($same === 1) {
                $controller_action= $funct;
                //echo $funct;
                $controller = $control;
                //echo $control;
                for ($i = 0; $i < count($uri_route); ++$i) {
                    array_shift($url_array);
                }
                foreach ($url_array as $key) {
                    $variable_array = array_shift($url_array);
                }

                break 2;
            }
        }
      }
        if ($same == 0){
          $method = 'GET:';
        }

        if (empty($controller_action)) {
            $controller_action = 'error';
            $controller = 'Controller';
        }
      /*if($controller==='indexphp'||$controller===''){
        $controller_name='home';
        $model = 'User';
      }*/

      $request = new Request;
      switch ($method){
          case 'POST:':
          $variable_array = $request->post();
          break;
          case 'GET:':
          $variable_array = $request->get();
          break;
          case 'PUT:':
          $variable_array = $request->put();
          break;
          case 'DELETE:':
          echo "Non ne ho idea";
          break;
      }

      /*
      if ($method == 'POST:'){
        $variable_array = $_POST;
        print_r($variable_array);
      }elseif ($method == 'GET:') {
        $variable_array = $_GET;
        //print_r($variable_array);
      }
      */
      print_r($variable_array);
      $dispatch = new $controller($variable_array, $controller_action);

        self::$counturl = $counturl;
        return $counturl;
    }
    /** Securu assets, fuction for prevent error of loading css and public files in views.**/
    public static function secure_assest($text)
    {
      $counturl = self::$counturl;

      echo '"';
      for($i=1; $i<$counturl; $i++){
        echo "..".DS;
      }
      echo $text;
      echo '"';
    }
    public static function secure_route($route)
    {
      echo '"';
      echo APP_NAME.DS."public".$route;
      echo '"';
    }
}
