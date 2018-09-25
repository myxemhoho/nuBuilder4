<?php

	require_once('nudatabase.php');
	
	
	$nuConfigDBName	= nuRunQuery('')[1];
	$session_id     = $_REQUEST['sessid'];
	$values         = array($session_id);
	$sql            = "SELECT * FROM zzzzsys_session WHERE zzzzsys_session_id = ?";
	$obj            = nuRunQuery($sql, $values);
	$recordObj      = db_fetch_object($obj);
	$result         = db_num_rows($obj);
	$page			= "nupmalogout.php";	

	if ( $result == 1 ) {

		$logon_info     = json_decode($recordObj->sss_access);
		$_user          = $logon_info->session->zzzzsys_user_id;
		$_extra_check   = $logon_info->session->global_access;

		if ( $_user == $nuConfigDBGlobeadminUsername AND $_extra_check == '1' ) {

			$page 		= "nudb/db_structure.php?server=1&db=$nuConfigDBName";
			
			setcookie("nupmalogin", "good");
			
		} else {
			setcookie("nupmalogin", "bad");
		}
		
	} else {
		setcookie("nupmalogin", "bad");
	}

	header("Location: $page");
