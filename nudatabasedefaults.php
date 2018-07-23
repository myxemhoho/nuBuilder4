<?php

class nudatabasedefaults  {

	public $sqlErrors       = array();
        public $DBHost          = '';
        public $DBName          = '';
        public $DBUserID        = '';
        public $DBPassWord      = '';

        function runQuery($sql, $values = array(), $DBName = null) {

                if ( null == $DBName ) {
                        $DBName = $this->DBName;
                }
                $obj = null;

                try {
                        $db = new PDO("mysql:host=".$this->DBHost.";dbname=".$this->DBName.";charset=utf8", $this->DBUserID, $this->DBPassWord, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $db->exec("USE $DBName");
                        $obj = $db->prepare($sql);
                        $obj->execute($values);

                } catch(Exception $e) {
                        array_push($this->sqlErrors, print_r($e, true));
                }
                return $obj;
        }

	var $tables_updated	= array();
	var $CHARACTER		= 'utf8';
	var $COLLATE		= 'utf8_general_ci';
	var $ENGINE		= 'MyISAM';
	var $ROW_FORMAT		= '';

	function getExactCasingForEngine($ENGINE) {
		
		$sql 		= "SELECT * FROM ENGINES WHERE ENGINE LIKE :engine ";
		$values         = array(":engine"=>$ENGINE);
                $rs             = $this->runQuery($sql, $values, 'information_schema');
		$obj 		= $rs->fetch(PDO::FETCH_OBJ);
		return $obj->ENGINE;
	}

	function update() {

		$this->updateDatabase();	

		$db		= $this->DBName;
		$sql 		= "SELECT * FROM TABLES WHERE TABLE_SCHEMA=:table_schema ";
		$values 	= array(":table_schema"=>$db);
		$rs 		= $this->runQuery($sql, $values, 'information_schema');

		while( $obj = $rs->fetch(PDO::FETCH_OBJ) ) {
			$this->updateTable($obj);
		}
	}

	function updateDatabase() {
	
		$db             = $this->DBName;
                $CHARACTER      = $this->CHARACTER;
                $COLLATE        = $this->COLLATE;

		if ( $CHARACTER != '' && $COLLATE != '' ) {
                	$sql            = "ALTER DATABASE $db CHARACTER SET $CHARACTER COLLATE $COLLATE";
                	$this->runQuery($sql);
		}
	}

	function updateTable($obj) {

		if ( $obj->TABLE_TYPE != 'BASE TABLE') {
			return;
		} 

		$table 		= $obj->TABLE_NAME;

		$CHARACTER      = $this->CHARACTER;
                $COLLATE        = $this->COLLATE;
		$ENGINE		= $this->getExactCasingForEngine($this->ENGINE);
		
		if ( $ENGINE != '' ) {

			$sql = " SET storage_engine=$ENGINE";
                        $this->runQuery($sql);

			$sql = "ALTER TABLE $table ENGINE = $ENGINE";
                	$this->runQuery($sql);
		}

		if ( $CHARACTER != '' && $COLLATE != '' ) {
			$sql = "ALTER TABLE $table DEFAULT CHARACTER SET $CHARACTER COLLATE $COLLATE ";
                	$this->runQuery($sql);

                	$sql = "ALTER TABLE $table CONVERT TO CHARACTER SET $CHARACTER COLLATE $COLLATE ";
                	$this->runQuery($sql);
		}
		
                array_push($this->tables_updated, $table);
	}
}
?>
