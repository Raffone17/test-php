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
          foreach($variables as $key => $var){
            $this->variables[$key] = $var;
          }
        }else{
          $variables=strip_tags($variables);
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
            $tmp = $this->existsTemp(ROOT.DS.'application'.DS.'views'.DS.$this->_view.'.php',$this->_view);
            if($tmp != false){

              include $tmp;
            }else{

              $tmp = $this->renderTemplate(ROOT.DS.'application'.DS.'views'.DS.$this->_view.'.php', $this->_view);

              include $tmp;
            }
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
    public function renderTemplate($content,&$name)
    {
        array_map('unlink', glob(ROOT.DS.'tmp'.DS.'templateCache'.DS.$name."*.php"));
        $size = filesize($content);
        $read = fopen($content, 'r');
        $tmpFile = ROOT.DS.'tmp'.DS.'templateCache'.DS.$name.'%'.$size.'.php';
        $write = fopen($tmpFile,'w');
        $constrFlag = false;
        $phpFlag = false;
        $i;
        $char2 ='';
        $char3 ='';
        $charpre = '';
        $scritto = false;

         while (false !== ($char = fgetc($read))){
           if($char2 == '' ){
             $char2 = fgetc($read);
           }else{
             $tmp = $char;
             $char = $char2;
             $char2 = $char3;
             $char3 = $tmp;
           }
           if(isset($char2) && !empty($char2)){
             if($char2 !== false){
              if($char=='{' && $char2 == '{'){
                //$content = substr_replace($content, "<?=", $i,2);
                //$content = substr_replace($content, '<?=', $i,2);
                fwrite($write, '<?=');
                $scritto = true;

              }else if($char=='}' && $char2 == '}'){
                // $content = substr_replace($content, '>', $i,2);
                fwrite($write, '?>');
                $scritto = true;
              }else if($char=='{' && $char2 == '%'){
                fwrite($write, '<?php');
                $phpFlag = true;
                $scritto = true;

              }else if($char=='%' && $char2 == '}'){
                if($constrFlag){
                  fwrite($write, ': ?>');
                  $constrFlag = false;
                  $scritto = true;
                }else{
                  fwrite($write, '?>');
                  $scritto = true;
                }
                $phpFlag = false;
              }else{
                if(!$scritto){
                  fwrite($write, $char);
                }else{
                  $scritto = false;
                }

              }
              if($char3 == ''){
                $char3 = fgetc($read);
              }

                if($phpFlag && !$constrFlag){
                  if(($char=='f'&& $char2 == 'o' && $char3 == 'r' && $charpre != 'd') ||
                   ($char == 'i'&& $char2 == 'f' && $charpre != 'd')){
                    $constrFlag = true;
                  }
                }


              $charpre = $char;

            }else{
              //fwrite($write,$char);
            }
              /*if(false !== ($char3 = fgetc($read))){
                if($phpFlag && !$constrFlag){
                  if(($char=='f'&& $char2 == 'o' && $char3 == 'r' && $content[$i-1] != 'd') ||
                   ($content[$i] == 'i'&& $content[$i+1] == 'f' && $content[$i-1] != 'd')){
                    $constrFlag = true;
                  }
                }

              }*/

            }else{
              fwrite($write, $char);
            }

          }
          fclose($write);
          fclose($read);

          return $tmpFile;

    }
    public function existsTemp($content,&$name = "ciao"){
      $size = filesize($content);
      $tmpName = ROOT.DS.'tmp'.DS.'templateCache'.DS.$name.'%'.$size.'.php';
      if(file_exists($tmpName)){
        return $tmpName;
      }
        return false;


    }
}
