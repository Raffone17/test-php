<?php
/**Model class
  *This class extends the SQLQuery, so basically the principal function is comunicate
  *with the database. This is the parent class, for use this functionality simply created
  *a new model in models folder, with the singolar name of the table.
**/
class Model extends SQLQuery {
    protected $_model;
    protected $_table;

    /**Construct
      *Set the connection with the database using SQLQuery class methods, and Set
      *the table name.
    **/
    function __construct() {

        $this->connect(DB_HOST,DB_NAME,DB_USER,DB_PASSWORD);
        $this->_model = get_class($this);
        $this->_table = strtolower($this->_model)."s";
    }
    /**Descturct
      *Disconnect from the database.
    **/
    function __destruct() {
      $this->disconnect();
    }
}
