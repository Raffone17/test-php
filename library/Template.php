<?php
/**
 *  TEMPLATE
 */
 /**
  * Class Template
  *
  * for rendering the web pages
  * @version v0.1.0
  *
  * @author Raffone
  */

class Template
{
    protected $variables;
    protected $_view;
    protected $_action;
    protected $_render;
    protected $_sections;


    public function __construct()
    {
      $this->_render = true;
      $this->variables = array();
      $_contents = array();
    }
    /**
     * Method for set the view and the variables to the view.
     * The construct set the view and variable that will be used for render
     * the required page. The variables is an array.
     * @param $view Name of the view, in the application/views folder
     * @param $variables array
     */
    public function construct($view, $variables)
    {
        $this->_view = $view;
        if(is_array($variables)){
          stripTagsArray($variables);
        }else{
          $variables=strip_tags($variables);
        }
        foreach($variables as $key => $var){
          $this->variables[$key] = $var;
        }
        //$this->variables = $variables;
    }

    /** Set Variables **/
    public function set($name, $value)
    {
        if(is_array($value)){
          stripTagsArray($value);
        }else{
          $value=strip_tags($value);
        }
        echo "QUI";
        $this->variables[$name] = $value;
    }

    public function get($name)
    {
      return $this->variables[$name];
    }

    /**
     * Render
     * The render method search the view and if found include that, and the same time
     * set the name for the variables array that can be used in the views.
     * @param $name Name of the array will send to the view
     */
    public function render()
    {
        if (is_array($this->variables)) {
            extract($this->variables);
            //debug($this->variables);
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
    /**
    * Static Method that add the functionality of extends Layouts in the view.
    * @param $_layout name of the layout to extend
    */
    public function extendsLayout($_layout)
    {

        if (is_array($this->variables)) {

            extract($this->variables);
        }
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
    public function content($name)
    {
        //debug($this->_sections[$name]);

        //templateRender($this->_sections[$name]);
        //debug($this->_sections[$name]);
        //$this->renderTemplate($this->_sections[$name]);
        //debug($this->_sections[$name]);
        echo $this->_sections[$name];
    }

    public function contentStart($name)
    {
        $this->_sections[$name] = '';
        ob_start();

    }
    public function contentStop()
    {
      end($this->_sections);
      $this->_sections[key($this->_sections)] = ob_get_clean();

    }
    public function renderTemplate(&$content)
    {
        $constrFlag = false;
        $phpFlag = false;
        $i;

       for( $i=0; $i<strlen($content); $i++){
            if($content[$i]=='{' && $content[$i+1] == '{'){
              //$content = substr_replace($content, "<?=", $i,2);
              $content = substr_replace($content, '<?=', $i,2);
              $i++;
            }else if($content[$i]=='}' && $content[$i+1] == '}'){
              $content = substr_replace($content, '?>', $i,2);
              $i++;
            }else if($content[$i]=='{' && $content[$i+1] == '%'){
              $content = substr_replace($content, '<?php', $i,2);
              $phpFlag = true;
              $i++;
            }else if($content[$i]=='%' && $content[$i+1] == '}'){
              if($constrFlag){
                $content = substr_replace($content, ': ?>', $i,2);
                $constrFlag = false;
              }else{
                $content = substr_replace($content, '?>', $i,2);
              }
              $i++;
              $phpFlag = false;
            }else{
                //echo $content[$i];

            }


            if($phpFlag && !$constrFlag){
              if(($content[$i]=='f'&& $content[$i+1] == 'o' && $content[$i+2] == 'r' && $content[$i-1] != 'd') ||
               ($content[$i] == 'i'&& $content[$i+1] == 'f' && $content[$i-1] != 'd')){
                $constrFlag = true;
              }
            }

       }

    }
}
