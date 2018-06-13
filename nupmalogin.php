<?php

        require_once('nuconfig.php');
        $session_id     = $_REQUEST['sessid'];
        $db             = new PDO("mysql:host=$nuConfigDBHost;dbname=$nuConfigDBName;charset=utf8", $nuConfigDBUser, $nuConfigDBPassword, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $values         = array($session_id);
        $sql            = "SELECT * FROM zzzzsys_session WHERE zzzzsys_session_id = ?";
        $obj            = $db->prepare($sql);
        $obj->execute($values);
        $recordObj      = $obj->fetch(PDO::FETCH_OBJ);
        $result         = $obj->rowCount();
        $page           = 'index.php';

        if ( $result == 1 ) {

                $logon_info     = json_decode($recordObj->sss_access);
                $_user          = $logon_info->session->zzzzsys_user_id;
                $_extra_check   = $logon_info->session->global_access;

                if ( $_user == $nuConfigDBGlobeadminUsername AND $_extra_check == '1' ) {

                        session_name('PHPSESSIDNUBUILDER4');
                        session_start();

			setcookie("DBName", $nuConfigDBName, time()+1800);
                        setcookie("DBHost", $nuConfigDBHost, time()+1800);

                        $_SESSION['PMA_single_signon_user']             = $nuConfigDBUser;
                        $_SESSION['PMA_single_signon_password']         = $nuConfigDBPassword;
                        $_SESSION['PMA_single_signon_host']             = $nuConfigDBHost;
                        $_SESSION['PMA_single_signon_port']             = "3306";

                        $page = 'nudbadmin/index.php?server=1';
                        setcookie("DBName", $nuConfigDBName);
                        setcookie("DBHost", $nuConfigDBHost);
		}
        }

        header("Location: $page")
?>
