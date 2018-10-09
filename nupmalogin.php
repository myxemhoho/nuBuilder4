<?php
	require_once('nuchoosesetup.php');

	$session_id     = $_REQUEST['sessid'];
	$values         = array($session_id);
	$sql            = "SELECT * FROM zzzzsys_session WHERE zzzzsys_session_id = ?";
	$obj            = nuRunQuery($sql, $values);
	$result         = db_num_rows($obj);
	
	if ( $result == 1 ) {

		$recordObj      = db_fetch_object($obj);
		$logon_info     = json_decode($recordObj->sss_access);
		$_user          = $logon_info->session->zzzzsys_user_id;
		$_extra_check   = $logon_info->session->global_access;

		if ( $_user == $_SESSION['nuconfig']->GLOBEADMIN_NAME AND $_extra_check == '1' ) {
			$page	= pmaGood();		
		} else {
			$page	= pmaBad();
		}
		
	} else {
			$page   = pmaBad();
	}

	header("Location: $page");

	//echo "<a href='$page'>$page</a>";
	//echo "<pre>";
	//print_r($_REQUEST);
	//print_r($_SESSION);
	//echo "</pre>";	


function pmaGood() {

	$time = time();
	$page = "nudb/db_structure.php?server=1&db=".$_SESSION['nuconfig']->DB_NAME."&$time=$time";
	setcookie("nupmalogin",         "good");
	setcookie("nuConfigDBHost",     $_SESSION['nuconfig']->DB_HOST);
	setcookie("nuConfigDBUser",     $_SESSION['nuconfig']->DB_USER);
	setcookie("nuConfigDBPassword", $_SESSION['nuconfig']->DB_PASSWORD);

	if ( $_SESSION['nuconfig']->DB_PASSWORD == '' ) {
		setcookie("nuConfigDBPasswordBlank", 'BLANK');
	}
	return $page;
}

function pmaBad() {

	$time = time();
	$page                           = "nupmalogout.php?$time=$time";
	setcookie("nupmalogin",         "bad");
	setcookie("nuConfigDBHost",     null);
	setcookie("nuConfigDBUser",     null);
	setcookie("nuConfigDBPassword", null);
	return $page;
}	

?>
