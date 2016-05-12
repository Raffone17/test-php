<?php
/**
 *  SQLQUERY
 */
 /**
  * SQLQuery class
  * A simply class for comunicate with the database, using the PDO queries.
  * The uses of prepare improve the securty.
  * @version v0.1.0
  *
  * @author Raffone
  */

class SQLQuery
{
    protected $_dbHandle;
    protected $_joins = array();
    protected $_bindValues = array();
    protected $_result;
    protected $_query = '';

    /** Connects to database **/
    public function connect($address, $dbname, $account, $pwd)
    {
        try {
            $this->_dbHandle = new PDO('mysql:host='.$address.';dbname='.$dbname.';charset=utf8', ''.$account.'', ''.$pwd.'');
            $this->_dbHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return 1;
        } catch (PDOException $ex) {
            global $log;
            $error = 'DbError  '.$ex->getMessage();
            $log->logError($error);

            return 0;
        }
    }

    /** Disconnects from database **/
    public function disconnect()
    {
        try {
            $this->_dbHandle = null;
        } catch (PDOException $ex) {
            global $log;
            $error = 'DbError '.$ex->getMessage();
            $log->logError($error);
            die();

            return 1;
        }

        return 0;
    }
    /** Select all from a table**/
    public function selectAll()
    {
        try {
            $stmt = $this->_dbHandle->prepare('SELECT * FROM '.$this->_table);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            global $log;
            $error = 'DbError '.$ex->getMessage();
            $log->logError($error);

            return 1;
        }
    }
    /** Select a specific row from the table, using the id **/
    public function selectWhere($id)
    {
        try {
            $stmt = $this->_dbHandle->prepare('SELECT * FROM '.$this->_table.' WHERE id = ?');

            $stmt->bindValue(1, $id, PDO::PARAM_INT);

            $stmt->execute();

        //echo print_r($stmt->errorInfo());

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            global $log;
            $error = 'DbError '.$ex->getMessage();
            $log->logError($error);

            return 1;
        }
    }
    public function execute()
    {
      try {
          $stmt = $this->_dbHandle->prepare($this->_query);
          //debug($this->_query);
          if(isset($this->_bindValues) && is_array($this->_bindValues) && !empty($this->_bindValues)){
            $i = 1;
            foreach ($this->_bindValues as $key => $value) {
                $stmt->bindValue($i, $value);
                ++$i;
            }

          }

          $stmt->execute();

      //echo print_r($stmt->errorInfo());

      return $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch (PDOException $ex) {
          global $log;
          $error = 'DbError '.$ex->getMessage();
          $log->logError($error);


      }
    }

    public function select($variables = '*')
    {
      $this->_query .= 'SELECT ';

      if(is_array($variables)){
        $first = true;
        foreach($variables as $key => $variable ){
          if(is_int($key)){
            if(!$first) $this->_query.=', ';
            $this->_query .= $variable.' ';
          }else{
            if(!$first) $this->_query.=', ';
            $this->_query .= $variable.' AS '.$key.' ';
          }
          $first=false;
        }
      }elseif($variables == 'all'){
        $this->_query .= '* ';
      }else{
        $this->_query .= $variables.' ';
      }
      $this->_query .= 'FROM '.$this->_table.' ';

      return $this;
    }

    public function where($variables = '' )
    {
      if(!empty($variables)){
        $first = true;
        $this->_query .= 'WHERE ';

        if(is_array($variables)){
          foreach($variables as $key => $variable ){

            $key = explode(' ',$key);
            if(isset($key[1])){
              if(!$first) $this->_query .= 'AND ';
              $this->_query .= $key[0].' '.$key[1].' ? ';
            }else{
              if(!$first) $this->_query .= 'AND ';
              $this->_query .= $key[0].' = ? ';
            }
            $first = false;

            array_push($this->_bindValues,$variable);
          }
        }
      }
      return $this;
    }

    public function addOr()
    {
      $this->_query .= 'OR ';

      return $this;
    }

    public function having($variables = '')
    {
      if(!empty($variables)){
        $first = true;
        $this->_query .= 'HAVING ';

        if(is_array($variables)){
          foreach($variables as $key => $variable ){

            $key = explode(' ',$key);
            if(isset($key[1])){
              if(!$first) $this->_query .= 'AND ';
              $this->_query .= $key[0].' '.$key[1].' ? ';
            }else{
              if(!$first) $this->_query .= 'AND ';
              $this->_query .= $key[0].' = ? ';
            }
            $first = false;

            array_push($this->_bindValues,$variable);
          }
        }
      }

      return $this;
    }

    public function group($variables='id')
    {
      $this->_query .= 'GROUP BY ';

      if(is_array($variables)){
        $first = true;
        foreach($variables as $variable ){

          if(!$first) $this->_query.=', ';
          $this->_query .= $variable.' ';

          $first=false;
        }
      }elseif($variables == 'id'){
        $this->_query .= 'id ';
      }else{
        $this->_query .= $variables.' ';
      }

      return $this;
    }
    /**  Insert in to the table the specific array variables**/
    public function addRow($variables)
    {
        $i = 0;
        if (is_array($variables)) {
            $query = 'INSERT INTO '.$this->_table.' (';
            foreach ($variables as $key => $value) {
                $query .= $key;
                ++$i;
                if ($i !== count($variables)) {
                    $query .= ', ';
                }
            }
            $query .= ') VALUES (';
            for ($i = 1; $i <= count($variables); ++$i) {
                $query .= '? ';
                if ($i !== count($variables)) {
                    $query .= ', ';
                }
            }
            $query .= ')';

            try {
                $stmt = $this->_dbHandle->prepare($query);

                $i = 1;
                foreach ($variables as $key => $value) {
                    $stmt->bindValue($i, $value, PDO::PARAM_STR);
                    ++$i;
                }
                $stmt->execute();
              //echo print_r($stmt->errorInfo());

              return $stmt->rowCount();
            } catch (PDOException $ex) {
                global $log;
                $error = 'DbError '.$ex->getMessage();
                $log->logError($error);

                return 1;
            }
        } else {
            global $log;
            $error = 'DbError not an array in method addRow ';
            $log->logError($error);
        }
    }

    /** Custom SQL Query **/
    public function query($query, $singleResult = 0)
    {
        try {
            $stmt = $this->_dbHandle->prepare($query);
            $stmt->execute();
            $this->_result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $this->_result;
        } catch (PDOException $ex) {
            global $log;
            $error = 'DbError '.$ex->getMessage();
            $log->logError($error);

            return 1;
        }
    }

    public function foreign($_foreign){

        if(isset($_foreign) && is_array($_foreign)){

          array_push($this->_joins,$_foreign);

        }else{
          global $log;
          $error = 'DbError _foreign is not an array or is not set';
          $log->logError($error);

          return 1;
      }
    }
    /******* ADD JOIN TO QUERY *******/
    public function join($tab)
    {
      if(is_array($tab)){
        foreach($tab as $var){
          foreach($this->_joins as $key => $join){
            if($var == $key){
              $this->_query .= 'JOIN '.$join[0].' ON '.$join[1].'='.$join[2].' ';
            }
          }
        }
      }else{
        foreach($this->_joins as $key => $join){
          if($tab == $key){
            $this->_query .= 'JOIN '.$join[0].' ON '.$join[1].'='.$join[2].' ';
          }
        }
      }
      return $this;
    }

    public function leftJoin($tab)
    {
      if(is_array($tab)){
        foreach($tab as $var){
          foreach($this->_joins as $key => $join){
            if($var == $key){
              $this->_query .= 'LEFT JOIN '.$join[0].' ON '.$join[1].'='.$join[2].' ';
            }
          }
        }
      }else{
        foreach($this->_joins as $key => $join){
          if($tab == $key){
            $this->_query .= 'LEFT JOIN '.$join[0].' ON '.$join[1].'='.$join[2].' ';
          }
        }
      }
      return $this;
    }

    public function rightJoin($tab)
    {
      if(is_array($tab)){
        foreach($tab as $var){
          foreach($this->_joins as $key => $join){
            if($var == $key){
              $this->_query .= 'RIGHT JOIN '.$join[0].' ON '.$join[1].'='.$join[2].' ';
            }
          }
        }
      }else{
        foreach($this->_joins as $key => $join){
          if($tab == $key){
            $this->_query .= 'RIGHT JOIN '.$join[0].' ON '.$join[1].'='.$join[2].' ';
          }
        }
      }
      return $this;
    }

    public function fullJoin($tab)
    {
      if(is_array($tab)){
        foreach($tab as $var){
          foreach($this->_joins as $key => $join){
            if($var == $key){
              $this->_query .= 'FULL OUTER JOIN '.$join[0].' ON '.$join[1].'='.$join[2].' ';
            }
          }
        }
      }else{
        foreach($this->_joins as $key => $join){
          if($tab == $key){
            $this->_query .= 'FULL OUTER JOIN '.$join[0].' ON '.$join[1].'='.$join[2].' ';
          }
        }
      }
      return $this;
    }
    /******  RELATIONSHIP FUNCTIONS **********/
    public function hasOne($tab,$key=null){
      if($key == null){
        $this->_joins[$tab] = array($tab,$this->_table.".id",$tab.".".substr($this->_table, 0, -1)."_id");
      }else {
        $this->_joins[$tab] = array($tab,$this->_table.".id",$tab.".".$key);
      }

    }
    public function hasMany($tab,$key=null){
      if($key == null){
        $this->_joins[] = array($tab,$this->_table.".id",$tab.".".substr($this->_table, 0, -1)."_id");
      }else {
        $this->_joins[] = array($tab,$this->_table.".id",$tab.".".$key);
      }

    }
    public function belongsTo($tab,$key=null){
      if($key == null){
        $this->_joins[$tab] = array($tab,$this->_table.".".substr($tab, 0, -1)."_id",$tab.".id");
      }else {
        $this->_joins[$tab] = array($tab,$this->_table.".".$key,$tab.".id");
      }

    }
    public function belongsToMany($tab,$key=null){
      if($key == null){
        $this->_joins[$tab] = array($tab,$this->_table.".".substr($tab, 0, -1)."_id",$tab.".id");
      }else {
        $this->_joins[$tab] = array($tab,$this->_table.".".$key,$tab.".id");
      }
    }
    /** Get number of rows **/
    public function getNumRows()
    {
        return $this->_result->rowCount();
    }

    /** Free resources allocated by a query **/
    public function freeResult()
    {
        $this->_result->closeCursor();
    }

    /** Get error string **/
    public function getError()
    {
        return $this->_dbHandle->errorInfo();
    }
}
