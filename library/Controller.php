<?php
/**
  *This is the principal Controller class.
  *The principal use of this class is the comunication between the Template class,
  *the routes and the model, using personal child class.
  *
  *
**/
class Controller
{
    protected $_model;
    protected $_controller_action;
    protected $_variables_to_view;
    protected $_variables;
    protected $_template;
    protected $_view;

    /**In the costruct method the class set the name of method that will use
      *the child class for return the view. Next set variables, for optional use
      *in the child classes. Then check if the method name passed does really exist
      *in the controller, if not set the view to "error" .
    **/

    public function __construct($variable_array, $controller_action)
    {
        $this->_controller_action = $controller_action;
        $this->variables = $variable_array;
        if (method_exists(get_class($this), $controller_action)) {
            $this->_variables_to_view = $this->$controller_action();
        } else {
            $this->_view = 'error';
        }
    }

    public function set($name, $value)
    {
        $this->_template->set($name, $value);
    }

    /**In the detruct function, start the rendering of the view, with a call to
      *the template class, used for visualize the pages of the application or website.
      *The method check if we used a model class, or if the _model is not empty ,
      *for select the name of the array that will return to te view.
      *Then, create a new class Template and start the rendering.
    **/

    public function __destruct()
    {
        $view = $this->_view;
        $variables = $this->_variables_to_view;
        if ($this->_model instanceof Model) {
            $name = strtolower(get_class($this->_model)).'s';
        } elseif (!empty($this->_model)) {
            $name = $this->_model;
        } else {
            $name = 'all';
        }

        $this->_template = new Template($view, $variables);

        $this->_template->render($name);
    }
}
/**
  *
**/
