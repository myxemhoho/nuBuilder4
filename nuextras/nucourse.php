<?php

class nucourse extends nuextras {

	var $tables		= array('course_auto_number', 'cource_organization', 'cource_contact'); 

	function run() {

		$this->dropTables();
		$this->createTableOne();
		$this->createTableTwo();
		$this->createTableThree();

	}

	function dropTables() {
		
		for ( $x=0; $x<count($this->tables); $x++ ) {

			$table = $this->tables[$x];	
			$sql = "DROP TABLE IF EXISTS $table";
			$this->runQuery($sql);
		}
	}

	function createTableOne() {

		$sql = "
			CREATE TABLE `course_auto_number` (
			`next_number_id` int(11) NOT NULL,
			`nxn_key` varchar(25) NOT NULL DEFAULT ''
			) ENGINE=MyISAM DEFAULT CHARSET=utf8
		";
		$this->runQuery($sql);	

		$this->runFile("cource_auto_number.sql");

		$sql = "ALTER TABLE `course_auto_number` ADD PRIMARY KEY (`next_number_id`)";
		$this->runQuery($sql);		

		$sql = "ALTER TABLE `course_auto_number` MODIFY `next_number_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100104";
		$this->runQuery($sql);

	}

	function createTableTwo() {

                $sql = "
			CREATE TABLE `course_organization` (
 			`organization_id` varchar(25) NOT NULL,
			`org_code` varchar(10) NOT NULL,
			`org_name` varchar(500) NOT NULL,
			`org_address1` varchar(500) NOT NULL,
 			`org_address2` varchar(500) NOT NULL,
 			`org_suburb` varchar(500) NOT NULL,
 			`org_state` varchar(300) NOT NULL,
 			`org_postcode` varchar(300) NOT NULL,
 			`org_abn` varchar(30) NOT NULL,
 			`org_office_number` varchar(30) NOT NULL,
 			`org_office_email` varchar(150) NOT NULL,
 			`org_notes` text NOT NULL
			) ENGINE=MyISAM DEFAULT CHARSET=utf8
                ";
                $this->runQuery($sql);

                $this->runFile("cource_organization.sql");

                $sql = "ALTER TABLE `course_organization` ADD PRIMARY KEY (`organization_id`)";
                $this->runQuery($sql);

        }

	function createTableThree() {

		$sql = "
			CREATE TABLE `course_contact` (
			`contact_id` varchar(25) NOT NULL,
			`con_organization_id` varchar(25) NOT NULL,
			`con_firstname` varchar(150) NOT NULL,
			`con_lastname` varchar(150) NOT NULL,
			`con_email` varchar(150) NOT NULL,			
			`con_direct_line` varchar(150) NOT NULL,
			`con_mobile` varchar(150) NOT NULL
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;
                ";
                $this->runQuery($sql);

                $this->runFile("cource_contact.sql");

                $sql = "ALTER TABLE `course_contact` ADD PRIMARY KEY (`contact_id`)";
                $this->runQuery($sql);

	}	

	function runFile($file) {

		$contents = file_get_contents($file);
		$this->runQuery($contents);
	}
}
?>
