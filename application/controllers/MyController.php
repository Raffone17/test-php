<?php
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

      $result = $this->_model->selectAll();
      $this->_view = "home";
      print_r($_REQUEST);
      return $result;

    }
    protected function homePage2()
    {

      $this->_model = new User;
      $array = array('email'=>'ornorinco@email.com','password'=>'Carlo Rossi','username' => 'Ciccio');
      $result = 'prova';
      $result = $this->_model->addRow($array);
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
      return $result;

    }
    protected function cerca()
    {
      $this->_view = "prova";
      return $this->_variables;
    }

}
