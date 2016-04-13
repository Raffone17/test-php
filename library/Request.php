<?php

//http://stackoverflow.com/questions/18162686/url-rewrite-get-parameters

class Request{
  
  protected $get;
  protected $post;
  protected $put;

  function __construct()  {
   
    $this->get = $_GET;
    $this->post = $_POST;
    $this->put = json_decode(file_get_contents("php://input"), true);

  }

  public function get(){

  	return $this->get;
  	

  }
  public function post(){
  	return $this->post;
  }

  public function input(){
  	return $_REQUEST;
  }

  public function put(){
  	return $this->put;	
  }



}
