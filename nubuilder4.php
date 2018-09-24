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

function nuSetMenu() {
	
	add_menu_page('nuBuilder Forte', 'nuBuilder Forte', 'manage_options', 'nubuilder4-slug', 'admin_login');
	
}

function nuAdJS() {

	wp_register_script('nubuilder4', plugins_url('nubuilder4.js', __FILE__)); 
	wp_enqueue_script('nubuilder4');

}

class nuBuilderForte{
	
	function __construct() {
		add_action('auth_redirect', 'nuSetMenu');
	}

	
	function activate() {
		
		flush_rewrite_rules();
		wp_register_script('nubuilder4', plugins_url('nubuilder4.js', __FILE__)); 
		wp_enqueue_script('nubuilder4');

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

function admin_login() {
	
	add_action('wp_enqueue_scripts', 'nuAdJS');

	$iframe_url		= constructUrl();

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

function constructUrl() {

	$auth_info 	= get_currentuserinfo();
	$json		= json_encode($auth_info);
	$encode		= base64_encode($json);
	$explosion 	= explode('/', $_SERVER['PHP_SELF']);
        array_splice($explosion, 0, 1);
        array_splice($explosion, count($explosion) - 1, 1);
        $server_path = '/';
        for ( $x=0; $x < count($explosion); $x++ ) {
                if ( $explosion[$x] !== 'wp-admin' ) {
                        $server_path .= $explosion[$x];
                }
                if ( $server_path !== '/' ) {
                        $server_path .= '/';
                }
        }
	//$this_server    = '../wp-content/plugins/nuBuilder4/index.php?wp='.$encode;
        $this_server    = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].$server_path.'/wp-content/plugins/nuBuilder4/index.php?wp='.$encode;

	return $this_server;
}

