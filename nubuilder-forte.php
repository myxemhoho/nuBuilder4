<?php
/**
 * @package nubuilder-forte
 * @version 1.0
*/
 
/*
Plugin Name: nuBuilder Forte
Plugin URI: https://www.nubuilder.com/
Description: nuBuilder Database Application Builder. Build reports and forms using Wordpress tables and any other table created in the Wordpress database.
Author: nuSoftware
Version: 1.0
Text Domain: nubuilder-forte
*/

defined( 'ABSPATH' ) or die();

require_once('nuwordpresssetuplibs.php');

function nu_set_menu() {

	add_menu_page('nuBuilder Forte', 'nuBuilder', 'read', 'nubuilder-forte-slug', 'nu_menu_function', 'dashicons-chart-bar');
}

function nu_start_session() {

	//if(!session_id()) {
		// start a session if there is no session
        //	session_start();
	//} else {
		// if there is a session the destroy and start a new one
		session_destroy();
		session_start();
		//session_reset();
	//}		
}

class nuBuilderForte{
	
	function __construct() {

		add_action('auth_redirect', 'nu_set_menu');
		add_action('init', 'nu_start_session', 1);
	}
	
	function activate() {

		nuWPImportNewDB();
		nuWPSetWPFlagDB();
		nuWPSetDeniedFlagDB();
		nuWPSetNewHeaderAndButtonsDB();
		nu_construct_access_levels_WPcoupled();
		
		flush_rewrite_rules();
		wp_register_script('nubuilder-forte', plugins_url('nubuilder-forte.php', __FILE__));
		wp_enqueue_script('nubuilder-forte');
	}

	function deactivate() {
		flush_rewrite_rules();
	}
}

if ( class_exists( 'nuBuilderForte' ) ) {

	$nuBuilderForte = new nuBuilderForte();
}

register_activation_hook(   __FILE__, array( $nuBuilderForte, 'activate' ) );
register_deactivation_hook( __FILE__, array( $nuBuilderForte, 'deactivate' ) );

function nu_menu_function() {

	nu_start_session();

	$iframe_url			= plugin_dir_url( __FILE__ ).'index.php';

	nu_construct_session_data_WPcoupled();
	nu_construct_access_levels_WPcoupled();

	$j	= "
	<iframe id='nubuilder4_iframe' style='margin:20px;border-style:solid;border-width:2px;border-color:lightgrey;width:1300px;height:1000px' src='$iframe_url'></iframe>
	<script>
	jQuery(window).resize(function(){
		nuResize();
	});
	function nuResize(){

		document.getElementById('nubuilder4_iframe').style.width     = String(Number(window.innerWidth)  - 255)	+ 'px';
		document.getElementById('nubuilder4_iframe').style.height    = String(Number(window.innerHeight) - 95) 	+ 'px';
		
	}
	nuResize();
	document.body.addEventListener('onresize', nuResize);
	</script>
	";
	
	echo $j;
}

?>
