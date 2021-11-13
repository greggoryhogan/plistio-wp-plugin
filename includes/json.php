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
      ) );
    //reddit auth
    register_rest_route( 'frgmnt/v1', '/reddit/(?P<action>([a-zA-Z0-9-]|%20)+)', array(
      'methods' => 'GET',
      'callback' => 'frgmnt_reddit_request',
    ) );
} 



/*
 * Callback for plugin update check
 */ 
function frgmnt_check_for_update($request) {
    $plugin = urldecode($request['plugin']);
    if($plugin == 'reddit-profiler') {
        $response = new WP_REST_Response(frgmnt_plugin_details_reddit());
        $response->set_status(200);
    } else {
        $response = new WP_REST_Response(array());
        $response->set_status(401);
    }
    return $response;
}

/*
 * Process reddit requests
 */ 
function frgmnt_reddit_request($request) {
    $action = urldecode($request['action']);
    $access_token = $request['access_token'];

    if($action == 'auth') {
        return get_reddit_access_token_for_client();
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

/*
 * Reddit API, Get access key
 */ 
function get_reddit_access_token_for_client() {
    $redirectUrl = "https://fragmentwebworks.com/wp-json/frgmnt/v1/reddit/auth";
    $clientId = 'enoXMtUUAn5MNc9cXoLdCg';
    if(!isset($_GET['state'])) { 
        return 'ERROR';
    }
    //echo $_GET['state'].'-reddit_access_code';
    if(isset($_GET['code'])) {
        //first auth
        
        update_option( $_GET['state'].'-reddit_access_code', $_GET['code']);
        $params = array(
            "redirect_uri" => $redirectUrl,
            'code' => $_GET['code'],
            'duration' => 'permanent'
        );
        $method = 'authorization_code';
    } else {
        //auth expired and we are renewing it
        $access_code = get_option($_GET['state'].'-reddit_access_code');
        if(!$access_code) {
            return 'noaccess';
        }
        $refresh_token = $_GET['rp_reddit_refresh_token'];
        //$params_defaults = array_merge($params_defaults,array('duration' => 'permanent'));
        $params = array(
            'redirect_uri' => $redirectUrl,
            'refresh_token' => $refresh_token,
            'grant_type' => 'refresh_token',
            'code' => $access_code,
        );
        $method = "refresh_token";
        //$return .= 'refreshing token...<br>';
    }
    $clientId = 'enoXMtUUAn5MNc9cXoLdCg';
    $clientSecret = '6CViJA7MK0wFtfb3e52OnWEJtcWKow';

    $authorizeUrl = 'https://ssl.reddit.com/api/v1/authorize';
    $accessTokenUrl = 'https://ssl.reddit.com/api/v1/access_token';
    $userAgent = 'WPProfileClient/0.1 by fragmentwebworks';

    $client = new OAuth2\Client($clientId, $clientSecret, OAuth2\Client::AUTH_TYPE_AUTHORIZATION_BASIC);
    $client->setCurlOption(CURLOPT_USERAGENT,$userAgent);
    
    $response = $client->getAccessToken($accessTokenUrl, $method, $params);
    
    $accessTokenResult = $response["result"];
    $access_token = $accessTokenResult["access_token"];

    //$_GET['state'] is from our admin page so always has a ? already included
    $url = frgmnt_core_encrypt_decrypt($_GET['state'], 'decrypt');
    if($access_token) {
        //echo  $access_token;
        $refresh_token = $accessTokenResult["refresh_token"];
        $return = $url.'/wp-admin/admin.php?page=reddit-profiler&rdtauth=1&rp_reddit_access_token='.$access_token.'&rp_reddit_refresh_token='.$refresh_token;
    } else {
        $return = $url.'/wp-admin/admin.php?page=reddit-profiler&refrsh='.$refresh_token.'&rdterror='.print_r($response,true);
    }
    if(isset($_GET['renew'])) {
        $return_array = array(
            'rp_reddit_access_token' => $access_token,
            'rp_reddit_refresh_token' => $refresh_token,
        );
        $response = new WP_REST_Response($return_array);
        $response->set_status(200);
        return $response;
    } else {
        wp_redirect( $return );
        exit;
    }
    
}
?>