<?php
/**Class Template
  *for rendering the web pages
**/

class Template
{
    protected $variables = array();
    protected $_view;
    protected $_action;

    /**Contruct of the class
      *The construct set the view and variable that will be used for render
      *the required page. The variables is an array.
    **/

    public function __construct($view, $variables)
    {
        $this->_view = $view;
        $this->variables = $variables;
    }

    /** Set Variables **/
    public function set($name, $value)
    {
        $this->variables[$name] = $value;
    }

    /** Render
     *The render method search the view and if found include that, and the same time
     *set the name for the variables array that can be used in the views.
     **/
    public function render($name)
    {
        if (is_array($this->variables)) {
            print_r($this->variables);
            echo "<br>";
            $this->variables[$name] = $this->variables;
            extract($this->variables);
        }
        if (file_exists(ROOT.DS.'application'.DS.'views'.DS.$this->_view.'.php')) {
            include ROOT.DS.'application'.DS.'views'.DS.$this->_view.'.php';
        } else {
            global $log;
            if (isset($this->_view) && isset($log)) {
                $error = 'Template render error on  "'.$this->_view.'" not found!';
                $log->logError($error);
            } elseif (isset($log)) {
                $error = 'Template render error on view not found!';
                $log->logError($error);
            }
        }
    }

    public static function extendsLayout($_layout)
    {

        if (file_exists(ROOT.DS.'application'.DS.'views'.DS.'layouts'.DS.$_layout.'.php')) {
            include ROOT.DS.'application'.DS.'views'.DS.'layouts'.DS.$_layout.'.php';
        } else {
            global $log;
            if (isset($this->_view) && isset($log)) {
                $error = 'Template render error on  "'.$_layout.'" not found!';
                $log->logError($error);
            } elseif (isset($log)) {
                $error = 'Template render error on view not found!';
                $log->logError($error);
            }
        }
    }
}
