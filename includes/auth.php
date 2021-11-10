<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function custom_redirects() {
 
    if ( is_page('authendpt') ) {
        get_reddit_access_token_for_client();
        exit;
    }
 
}

function frgmnt_core_encrypt_decrypt($string, $action = 'encrypt')
{
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'AA74CDCC2BBRT935136HH7B63C27'; // user define private key
    $secret_iv = '5fgf5HJ5g27'; // user define secret key
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
add_action( 'template_redirect', 'custom_redirects' );

function get_reddit_access_token_for_client() {
    $redirectUrl = "https://fragmentwebworks.com/authendpt";
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
        $return = $url.'/wp-admin/admin.php?page=reddit-profiler&rdterror='.print_r($response,true);
    }
    if(isset($_GET['renew'])) {
        echo $return;
    } else {
        wp_redirect( $return );
        exit;
    }
    
}
?>