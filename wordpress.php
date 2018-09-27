<?php
	if(!session_id()) {
                session_start();
        }
        if ( isset($_SESSION['nuWPSessionData']) ) {
                $decode                 = base64_decode($_SESSION['nuWPSessionData']);
                $_SESSION['wp']         = json_decode($decode);
        }
?>
