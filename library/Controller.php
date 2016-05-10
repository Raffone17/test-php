<?php
  /**
   *  CONTROLLER
   */
  /**
  * This is the main Controller class.
  * The use of this class is the comunication between the Template class,
  * the routes and the model.
  * Use child class those extende Controller class for create your personal controllers.
  *
  * @version v0.1.0
  *
  * @author Raffone
  */
class Controller
{
    protected $_model;
    protected $_controller_action;
    protected $_variables_to_view;
    //protected $_variables;
    protected $_template;
    protected $_view;
    protected $request;
    protected $Request;

    /**
    * In the costruct method the class set the name of method that will use
    * the child class for return the view. Next set variables, for optional use
    * in the child classes. Then check if the method name passed does really exist
    * in the controller, if not set the view to "error" .
    *
    * @param $variable_array array of variables
    * @param $controller_action name of the method of the controller will use
    * @param $method request method
    */

    public function __construct($variable_array, $controller_action , $method)
    {
        $this->Request = new Request;
        $this->_template = new Template();

        switch ($method){
            case 'POST:':
            $this->request = $this->Request->post();
            break;
            case 'GET:':
            $this->request = $this->Request->get();
            break;
            case 'PUT:':
            $this->request = $this->Request->put();
            break;
            case 'DELETE:':
            $this->request = $this->Request->get();
            break;
        }

        $this->_controller_action = $controller_action;
        $this->variables = $variable_array;
        if (method_exists(get_class($this), $controller_action)) {
            //$this->_variables_to_view = $this->$controller_action();

            $this->_variables_to_view = call_user_func_array(array($this, $controller_action),$variable_array);
        }elseif (substr_count($controller_action, 'SetView:') > 0){
            $this->_view = str_replace("SetView:","",$controller_action);
        } else {
            $this->_view = 'error';
        }
    }

    public function set($name, $value)
    {
        $this->_template->set($name, $value);
    }
    public function setView($name)
    {
        $this->_view = $name;
    }

    /**
    * In the detruct function, start the rendering of the view, with a call to
    * the template class, used for render the pages of the application or website.
    * The method check if we used a model class, or if the _model is not empty ,
    * for select the name of the array that will return to te view.
    * Then, create a new class Template and start the rendering.
    */

    public function __destruct()
    {

        if(array_key_exists('view',$this->_variables_to_view)){
            $this->_view = $this->_variables_to_view['view'];
            unset($this->_variables_to_view['view']);
        }
        //debug($this->_variables_to_view);
        if ($this->_model instanceof Model) {
            $name = strtolower(get_class($this->_model)).'s';
        } elseif (!empty($this->_model)) {
            $name = $this->_model;
        } else {
            $name = 'all';
        }

        $this->_template->construct($this->_view, $this->_variables_to_view);

        $this->_template->render();
    }
}
