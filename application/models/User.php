<?php
 /**
  * Example of a model.
  * The name of the model should be the singolar and with first capital letter name
  * of the table that will be used. Remember to extends the principal Model calss.
  * If need to change table name, use construct method with parent::__contruct();
  *
  */
Class User extends Model{

  /*function __construct(){
    parent::__construct();
      //$this->foreign(array('id_user'=>array('table','id')));

  }*/
  public function init()
  {
    $this->hasOne('users_details');
    $this->belongsTo('logins');
    //debug($this->_joins);
  }

}

 /**
  * Example if need to change the table name.
  *
  *
  *  Class User extends Model{
  *        function init(){
  *
  *        $this->table("users");
  *      }
  *   }
  */
