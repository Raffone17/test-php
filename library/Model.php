<?php
/**
 *  MODEL
 */
 /**
  * Model class
  * This class extends the SQLQuery, so basically the main function is comunicate
  * with the database. All models need to extend this class for use the methods for
  * comunicate with the database. For a proper use the model must be named with the
  * singolar and CamelCased name of the table.
  *
  * @version v0.1.0
  *
  * @author Raffone
  */
class Model extends SQLQuery {
    protected $_model;
    protected $_table;

    /**
    * Construct
    * Set the connection with the database using SQLQuery class methods, and Set
    * the table name.
    */
    function __construct() {

        $this->connect(DB_HOST,DB_NAME,DB_USER,DB_PASSWORD);
        $this->_model = get_class($this);
        $this->_table = strtolower($this->_model)."s";
        $this->init();
    }
    public function table($tab){
        $this->_table = $tab;
    }
    /**
    * Descturct
    * Disconnect from the database.
    */
    function __destruct() {
      $this->disconnect();
    }
}
