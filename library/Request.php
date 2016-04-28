<?php

//http://stackoverflow.com/questions/18162686/url-rewrite-get-parameters
 /**
  * Reqeust class, used for read all get, post and put parameters.
  *
  *
  * @version v0.1.0
  *
  * @author Raffone
  */
class Request{

  protected $get;
  protected $post;
  protected $put;

  /**
  *
  * Construct method that read all get,post and put parameters, and set them
  * in protected variables.
  */
  function __construct()  {

    $this->get = $_GET;
    $this->post = $_POST;
    $this->put = json_decode(file_get_contents("php://input"), true);

  }
  /**
  *
  * @return GET array
  */

  public function get(){

  	return $this->get;


  }
  /**
  *
  * @return POST array
  */
  public function post(){
  	return $this->post;
  }
  /**
  *
  * @todo return GET,POST and PUT array
  */

  public function input(){
  	return $_REQUEST;
  }
  /**
  *
  * @return PUT array
  */
  public function put(){
  	return $this->put;
  }



}
