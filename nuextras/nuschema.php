<?php

class nuschema extends nuextras {

	var $tables_updated	= array();
	var $CHARACTER		= '';
	var $COLLATE		= '';
	var $ENGINE		= '';
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
		$ROW_FORMAT	= $this->ROW_FORMAT;
		
		if ( $ENGINE != '' ) {

			$sql = " SET storage_engine=$ENGINE";
                        $this->runQuery($sql);

			$sql = "ALTER TABLE $table ENGINE = $ENGINE";
                	$this->runQuery($sql);
		}

		if ( $ROW_FORMAT != '' ) {
			$sql = "ALTER TABLE $table ROW_FORMAT=$ROW_FORMAT";
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
