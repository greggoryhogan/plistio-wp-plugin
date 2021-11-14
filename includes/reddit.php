<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * Reddit API, Get access key
 */ 
function frgmnt_get_reddit_access_token_for_client() {
    $redirectUrl = "https://fragmentwebworks.com/wp-json/frgmnt/v1/reddit/auth";
    $clientId = 'enoXMtUUAn5MNc9cXoLdCg';
    if(!isset($_GET['state'])) { 
        $response = new WP_REST_Response(array());
        $response->set_status(401);
        return $response;
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
        $refresh_token = $_GET['frgmnt_reddit_refresh_token'];
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
        $return = $url.'/wp-admin/admin.php?page=reddit-profiler&rdtauth=1&frgmnt_reddit_access_token='.$access_token.'&frgmnt_reddit_refresh_token='.$refresh_token;
    } else {
        $return = $url.'/wp-admin/admin.php?page=reddit-profiler&rdterror='.print_r($response,true);
    }
    if(isset($_GET['renew'])) {
        $return_array = array(
            'frgmnt_reddit_access_token' => $access_token,
            'frgmnt_reddit_refresh_token' => $refresh_token,
        );
        $response = new WP_REST_Response($return_array);
        $response->set_status(200);
        return $response;
    } else {
        wp_redirect( $return );
        exit;
    }
    
}

/*
 * Reddit API, Get profile data
 */ 
function frgmnt_reddit_api_me() {
    $redirectUrl = "https://fragmentwebworks.com/wp-json/frgmnt/v1/reddit/auth";
    $clientId = 'enoXMtUUAn5MNc9cXoLdCg';
    if(!isset($_GET['access-token'])) { 
        $response = new WP_REST_Response(array());
        $response->set_status(401);
        return $response;
    }
    $access_token = $_GET['access-token'];
    $clientSecret = '6CViJA7MK0wFtfb3e52OnWEJtcWKow';
    $userAgent = 'WPProfileClient/0.1 by fragmentwebworks';
    $redirectUrl = FRGMNT_JSON_URL . '/reddit/auth'; 

    $client = new OAuth2\Client(REDDIT_CLIENT_ID, $clientSecret, OAuth2\Client::AUTH_TYPE_AUTHORIZATION_BASIC);
    $client->setCurlOption(CURLOPT_USERAGENT,$userAgent);

    $client->setAccessToken($access_token);
    
    $client->setAccessTokenType(OAuth2\Client::ACCESS_TOKEN_BEARER);

    $response = $client->fetch("https://oauth.reddit.com/api/v1/me.json");

    if(json_decode($response['code']) == 401) {
        $response = new WP_REST_Response(array());
        $response->set_status(401);
        return $response;
    }
    $return_array = array(
        'response' => $response
    );
    $response = new WP_REST_Response($return_array);
    $response->set_status(200);
    return $response;
    
}
?>