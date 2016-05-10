<?php
  /**
   *  MYCONTROLLER
   */
  /**
  * Example of a controller.
  * It's possible to use a model with $this->model = new "Model name" ,
  * the best way, if you want to use variables from the query in your view.
  * Or simply create a new class, $model = new "Model name" .
  * With the return of funcions in your controller you can return an array or variable
  * to the view used. To set the view use $this->_view = "view name" .
  *
  */
class MyController extends Controller
{
    protected function homePage()
    {

      $this->_model = new User;

      debug($this->request);
      $get = $this->request;
      //$result = $this->_model->selectAll();
      $users = $this->_model->select()->execute();
      //$this->_view = "home";
      $this->setView("home");
      $this->set("ciao","prova");
      //$view = "prova";
      //debug($result);
      //debug(compact("users","get"));
      //print_r($_REQUEST);
      return compact("users","get");

    }
    protected function homePage2()
    {

      $this->_model = new User;
      $array = array('email'=>'ornorindas@email.com','citta'=>'Napoli','nome' => '<script>alert("CiaoMondo!");</script>');
      $result = 'prova';
      //$result = $this->_model->addRow($array);
      $this->_view = "home2";
      echo $result;
      return $result;

    }

    protected function homePage3()
    {
      $this->_view = "prova";
      $result=array('uno'=>'ciao','due'=>'mondo','tre'=>'bello');
      /*$result2 = json_encode($result);
      echo "<br>json_encode:".$result2;
      echo "<br>json_dencode:".print_r(json_decode($result2));*/
      //return $result;

    }
    protected function homePage4($first,$second)
    {
      echo "Mi hai dato: ".$first." e: ".$second;
      $this->_model = new User;

      //$result = $this->_model->selectAll();
      $result = $this->_model->select(['nome','forte'=>'citta','numero'=>'SUM(id)-1'])->where(['nome LIKE'=>'%uzzo%'])->group('id')->having(['numero'=>'4'])->execute();
      $this->_view = "home";
      print_r($_REQUEST);
      return $result;

    }
    protected function cerca()
    {
      $this->_view = "prova";

      return $this->request;
    }

}
