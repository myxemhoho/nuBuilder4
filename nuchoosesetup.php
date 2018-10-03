<?php
	if ( !session_id() ) {
                session_start();
        }
	
	require_once('nuconfig.php');  // nuconfig must be loaded before using nubuilder_session_data
	require_once('nubuilder_session_data.php');

        $nubuilder_session_data = new nubuilder_session_data();

        if ( isset($_SESSION['nuWPSessionData']) ) {

                $decode = base64_decode($_SESSION['nuWPSessionData']);
                $wpdata = json_decode($decode);
                $nubuilder_session_data->construct_wordpress($wpdata);

        } else {
		nuDieIfWeAreInsideWordpress();	
                $nubuilder_session_data->construct_standalone($nuConfigDBHost,$nuConfigDBName,$nuConfigDBUser,$nuConfigDBPassword,$nuConfigDBGlobeadminUsername,$nuConfigDBGlobeadminPassword,$nuConfigIsDemo);
        }

        $_SESSION['nuconfig'] = $nubuilder_session_data;

	// nudatabase will not work without $_SESSION['nuconfig'] loaded
	require_once('nudatabase.php');


function nuDieIfWeAreInsideWordpress() {

        // at various points there is no other reliable way to check if nuBuilder is installed in the wordpress eco system
	// other than checking for the file path
	// this extra check is to prevent nubuilder working from the outside of wordpress if it is inside wordpress folder structure
        $needle         = '/wp-content/plugins/';
        $haystack       = $_SERVER['PHP_SELF'];

        if ( strpos($haystack, $needle) !== false ) {
		echo "It appears that you have placed nuBuilder inside of Wordpress as a plugin.<br>";
		echo "To login to nuBuilder, you need to login through your Wordress admin.<br>";
		die();
        }
}

?>
