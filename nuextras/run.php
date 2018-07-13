<?php include('head.php'); ?>
<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	require_once("../nuconfig.php");
	require_once("nuextras.php");
	require_once("nuschema.php");
	require_once("nucourse.php");
	require_once("nuupdate.php");	
	
	validateBaseFields();
	validateTypeOfTask();
	validateLogin($nuConfigDBGlobeadminUsername, $nuConfigDBGlobeadminPassword);

	if ( $_POST['task'] == 'schema') {
		doSchemaAction($nuConfigDBHost, $nuConfigDBName, $nuConfigDBUser, $nuConfigDBPassword);
	} 

	if ( $_POST['task'] == 'userguide') {
		doUserGuideAction($nuConfigDBHost, $nuConfigDBName, $nuConfigDBUser, $nuConfigDBPassword);
        }

	if ( $_POST['task'] == 'update') {
                doUpdateAction($nuConfigDBHost, $nuConfigDBName, $nuConfigDBUser, $nuConfigDBPassword);
        }
	
	function validateLogin($nuConfigDBGlobeadminUsername, $nuConfigDBGlobeadminPassword) {

		if ( $nuConfigDBGlobeadminUsername != $_POST['username'] ) {
			echo "invalid login";
			die();
		}

		if ( $nuConfigDBGlobeadminPassword != $_POST['password'] ) {
			echo "invalid login";
			die();
		}
	}

	function validateTypeOfTask() {

		$allow_tasks = array('userguide','schema','update');
		if ( !in_array($_POST['task'], $allow_tasks) ) {	
			echo "invalid request 2";
                        die();
		}
	}	

	function validateBaseFields() { 
		
		$base_fields = array('username','password','task');
        	for ( $x=0; $x<count($base_fields); $x++ ) {
                	dieIfEmptyPostData($base_fields[$x]);
        	}

	}

	function dieIfEmptyPostData($var) {
		
		if ( empty($_POST[$var]) ) {
			echo "invalid request 1";	
			die();
		}
	
	}

	function doSchemaAction($nuConfigDBHost, $nuConfigDBName, $nuConfigDBUser, $nuConfigDBPassword) {

		$ENGINE 			= 'MyISAM';
		$CHARACTER 			= 'utf8';
		$COLLATE 			= 'utf8_general_ci';
		$ROW_FORMAT 			= '';

		$nuschema      		      = new nuschema();
        	$nuschema->DBHost             = $nuConfigDBHost;
        	$nuschema->DBName             = $nuConfigDBName;
        	$nuschema->DBUserID           = $nuConfigDBUser;
        	$nuschema->DBPassWord         = $nuConfigDBPassword;
        	$nuschema->CHARACTER          = $CHARACTER;
        	$nuschema->COLLATE            = $COLLATE;
        	$nuschema->ENGINE             = $ENGINE;
        	$nuschema->ROW_FORMAT         = $ROW_FORMAT;

		echo "Attempting the following Schema Changes: <br> ";
		echo "<b>ENGINE</b> :: $ENGINE <br> ";
		echo "<b>CHARACTER</b> :: $CHARACTER <br> ";
		echo "<b>COLLATE</b> :: $COLLATE  <br>";

		$nuschema->update();

		displayArray($nuschema->tables_updated, "<br><b>Tables updated</b><br>");
		echo "<br>";
		displayArray($nuschema->sqlErrors, "<b>SQL errors</b>");


        }

        function doUserGuideAction($nuConfigDBHost, $nuConfigDBName, $nuConfigDBUser, $nuConfigDBPassword) {
	
		$nucourse 		= new nucourse();
                $nucourse->DBHost      	= $nuConfigDBHost;
                $nucourse->DBName      	= $nuConfigDBName;
                $nucourse->DBUserID    	= $nuConfigDBUser;
                $nucourse->DBPassWord 	= $nuConfigDBPassword;

		$nucourse->run();	

		echo "
		<p>The following tables should now be ready:</p>
		<br>course_auto_number
		<br>course_contact
		<br>course_organization
		";
        }

	function doUpdateAction($nuConfigDBHost, $nuConfigDBName, $nuConfigDBUser, $nuConfigDBPassword) {

		$nuupdate               = new nuupdate();
                $nuupdate->DBHost       = $nuConfigDBHost;
                $nuupdate->DBName       = $nuConfigDBName;
                $nuupdate->DBUserID     = $nuConfigDBUser;
                $nuupdate->DBPassWord   = $nuConfigDBPassword;

                $nuupdate->run();
		echo "<br><br>Update complete<br>";
	}

	function displayArray($ary, $title) {

		if ( count($ary) > 0 ) {
			echo $title;
			echo "<br>";
			for ( $x=0; $x<count($ary); $x++ ) {
				echo $ary[$x];
				echo "<br>";
			}
		}
	}
?>
<br>
<hr>
<a href='index.php'>menu</a> | <a href='../'>login</a>
</p>
<?php include('bottom.php'); ?>
