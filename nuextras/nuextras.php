<?php

class nuextras {

        public $sqlErrors       = array();
	public $DBHost		= '';			
        public $DBName		= '';
        public $DBUserID	= '';
        public $DBPassWord	= '';

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
}
?>
