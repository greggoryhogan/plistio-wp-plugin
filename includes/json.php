<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * Register endpoints
 */ 
add_action( 'rest_api_init', 'create_fragment_rest_endpoints');
function create_fragment_rest_endpoints() {
    //check for plugin updates
    register_rest_route( 'frgmnt/v1', '/updates/(?P<plugin>([a-zA-Z0-9-]|%20)+)', array(
        'methods' => 'GET',
        'callback' => 'frgmnt_check_for_update',
        'permission_callback' => '__return_true'
      ) );
    //reddit auth
    register_rest_route( 'frgmnt/v1', '/reddit/(?P<action>([a-zA-Z0-9-]|%20)+)', array(
      'methods' => 'GET',
      'callback' => 'frgmnt_reddit_request',
      'permission_callback' => '__return_true'
    ) );
    //check license key
    register_rest_route( 'frgmnt/v1', '/license-key/(?P<key>([a-zA-Z0-9-]|%20)+)', array(
        'methods' => 'GET',
        'callback' => 'frgmnt_check_license_key',
        'permission_callback' => '__return_true'
      ) );
} 



/*
 * Callback for plugin update check
 */ 
function frgmnt_check_for_update($request) {
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

/*
 * Callback for license check
 */ 
function frgmnt_check_license_key($request) {
    $key = urldecode($request['key']);
    if($key) {
        $response = new WP_REST_Response(frgmnt_license_key_check($key));
        $response->set_status(200);
    } else {
        $response = new WP_REST_Response(array());
        $response->set_status(401);
    }
    return $response;
}

/*
 * Callback for reddit profiler
 */ 
function frgmnt_reddit_request($request) {
    $action = urldecode($request['action']);
    
    switch ($action) {
        case 'auth':
            return frgmnt_get_reddit_access_token_for_client();
            break;
        case 'me':
            return frgmnt_reddit_api_me();
            break;
    }
}

/*
 * Encrypt / Decrypt urls for passing between json requests
 */ 
function frgmnt_core_encrypt_decrypt($string, $action = 'encrypt') {
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'JKLJSGBJK7657987GHJKHDFK75675'; // user define private key
    $secret_iv = 'hj6987GHfspg'; // user define secret key
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16); // sha256 is hash_hmac_algo
    if ($action == 'encrypt') {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if ($action == 'decrypt') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}
?>