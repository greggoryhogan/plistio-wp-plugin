<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * Register endpoints
 */ 
//add_action( 'rest_api_init', 'create_plistio_rest_endpoints');
function create_plistio_rest_endpoints() {
    //check for plugin updates
    register_rest_route( 'frgmnt/v1', '/updates/(?P<plugin>([a-zA-Z0-9-]|%20)+)', array(
        'methods' => 'GET',
        'callback' => 'plistio_callback',
        'permission_callback' => '__return_true'
      ) );
} 



/*
 * Callback for plugin update check
 */ 
function plistio_callback($request) {
    $plugin = urldecode($request['plugin']);
    if($plugin == 'my-reddit') {
        $response = new WP_REST_Response(frgmnt_plugin_details_reddit());
        $response->set_status(200);
    } else {
        $response = new WP_REST_Response(array());
        $response->set_status(401);
    }
    return $response;
}
?>