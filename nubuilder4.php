<?php
/**
 * @package nubuilder4
 * @version 1.0
*/
 
/*
Plugin Name: nuBuilder Forte
Plugin URI: https://www.nubuilder.com/
Description: nuBuilder Database Application Builder
Author: nuSoftware
Version: 1.0
Text Domain: nubuilder4
*/

defined( 'ABSPATH' ) or die();

function nu_set_menu() {
	add_menu_page('nuBuilder Forte', 'nuBuilder', 'manage_options', 'nubuilder4-slug', 'nu_menu_function');

}

function nu_start_session() {
    if(!session_id()) {
        session_start();
    }

}

function nu_end_session() {
    session_destroy();

}

class nuBuilderForte{
	
	function __construct() {

		add_action('auth_redirect', 'nu_set_menu');
		add_action('init', 'nu_start_session', 1);
		add_action('wp_logout', 'nu_end_session');
		add_action('wp_login', 'nu_end_session');
	}
	
	function activate() {
		
		flush_rewrite_rules();
		//wp_register_script('nubuilder4', plugins_url('nubuilder4.js', __FILE__));
		wp_register_script('nubuilder4'); 
		//wp_enqueue_script('nubuilder4');
	}

	function deactivate() {
		flush_rewrite_rules();
	}
}

if ( class_exists( 'nuBuilderForte' ) ) {
	$nuBuilderForte = new nuBuilderForte();
}

register_activation_hook( __FILE__, array( $nuBuilderForte, 'activate' ) );
register_deactivation_hook( __FILE__, array( $nuBuilderForte, 'deactivate' ) );

function nu_menu_function() {
	
	$iframe_url			= nu_construct_url();
	$_SESSION['nuWPSessionData'] 	= nu_construct_session_data();

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

function nu_construct_url() {

	$this_server    = '../wp-content/plugins/nuBuilder4/index.php';
	return $this_server;
}

function nu_construct_session_data() {

	$auth_info      = get_currentuserinfo();
        $json           = json_encode($auth_info);
        $encode         = base64_encode($json);
	return $encode;
}
