<?php

class nubuilder_session_data {

	var $PLUGIN		= false;
	var $GLOBEADMIN         = false;
	var $GLOBEADMIN_NAME	= '';
	var $GLOBEADMIN_PASS    = '';
	var $USER_LOGIN         = '';
	var $USER_PASS          = '';
	var $USER_EMAIL         = '';
	var $USER_DISPLAY_NAME 	= '';
	var $USER_ROLES         = '';
	var $DB_NAME            = '';
	var $DB_USER            = '';
	var $DB_PASSWORD        = '';
	var $DB_HOST            = '';
	var $DB_CHARSET         = '';
	var $NU_SITE_URL        = '';
	var $WP_ADMIN_URL       = '';
	var $IS_DEMO		= false;
	var $WP_ROLES		= '';

	function __construct() {
        }

        function construct_wordpress($wpdata) {
		
		$this->PLUGIN           	= true;
                $this->DB_NAME          	= $wpdata->DB_NAME;
                $this->DB_USER          	= $wpdata->DB_USER;
                $this->DB_PASSWORD      	= $wpdata->DB_PASSWORD;
                $this->DB_HOST          	= $wpdata->DB_HOST;
                $this->DB_CHARSET       	= $wpdata->DB_CHARSET;
		if ( $wpdata->GLOBEADMIN === true ) {
                	$this->GLOBEADMIN_NAME  = $wpdata->USER_LOGIN;
                	$this->GLOBEADMIN_PASS  = $wpdata->USER_PASS;
			$this->GLOBEADMIN	= true;
		}
		$this->USER_LOGIN		= $wpdata->USER_LOGIN;
		$this->USER_PASS		= $wpdata->USER_PASS;
		$this->USER_EMAIL		= $wpdata->USER_EMAIL;
		$this->USER_DISPLAY_NAME 	= $wpdata->USER_DISPLAY_NAME;
		$this->USER_ROLES		= $wpdata->USER_ROLES;
		$this->NU_SITE_URL		= $wpdata->NU_SITE_URL;
		$this->WP_ADMIN_URL		= $wpdata->WP_ADMIN_URL;
		$this->IS_DEMO			= false;
		$this->WP_ROLES			= $wpdata->WP_ROLES;
        }

        function construct_standalone($nuConfigDBHost, $nuConfigDBName, $nuConfigDBUser, $nuConfigDBPassword, $nuConfigDBGlobeadminUsername, $nuConfigDBGlobeadminPassword, $nuConfigIsDemo = false) {

		$this->PLUGIN		= false;
		$this->DB_NAME		= $nuConfigDBName;
		$this->DB_USER		= $nuConfigDBUser;
		$this->DB_PASSWORD	= $nuConfigDBPassword;
		$this->DB_HOST		= $nuConfigDBHost;
		$this->DB_CHARSET	= 'utf8';
		$this->GLOBEADMIN_NAME	= $nuConfigDBGlobeadminUsername;
		$this->GLOBEADMIN_PASS	= $nuConfigDBGlobeadminPassword;
		$this->IS_DEMO         	= $nuConfigIsDemo;
        }
}

?>
