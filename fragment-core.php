<?php
/*
Plugin Name:  Fragment Core
Plugin URI:	  https://fragmentwebworks.com/plugins/fragment-core/
Description:  All the fancy stuff required to keep fragment and its plugins running
Version:	  1.0.0
Author:		  Fragment Web Works
Author URI:   https://fragmentwebworks.com
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  frgmnt
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'frgmnt_BLOCK_DIR', plugin_dir_url(__FILE__) );
define( 'frgmnt_PLUGIN_DIR', dirname(__FILE__).'/' );
/*
 *
 * Require files for plugin functionality
 * 
 */ 
//rest endpoint
require_once( frgmnt_PLUGIN_DIR . '/includes/rest.php' );
/*
 * OAuth Client
 */
if (!class_exists('OAuth2\Client')) {
    require_once( frgmnt_PLUGIN_DIR . '/includes/PHP-OAuth2-master/src/OAuth2/Client.php' );
    require_once( frgmnt_PLUGIN_DIR . '/includes/PHP-OAuth2-master/src/OAuth2/GrantType/IGrantType.php' );
    require_once( frgmnt_PLUGIN_DIR . '/includes/PHP-OAuth2-master/src/OAuth2/GrantType/AuthorizationCode.php' );
    require_once( frgmnt_PLUGIN_DIR . '/includes/PHP-OAuth2-master/src/OAuth2/GrantType/RefreshToken.php' );
}

/*add_filter('the_content','add_reddit',10,1);
function add_reddit($content) {
    if(is_page('reddit-profiler')) {
        //delete_transient('reddit_code');
          //  delete_transient('reddit-access-token');
            //return;
        $clientId = 'enoXMtUUAn5MNc9cXoLdCg';

        $access_token = get_transient('reddit-access-token-expiration');
        //$access_token = false;
        $access_code = get_option('rp_reddit_access_code');
        //$access_code = false;
        //937142193844-uSfnopeJuLwDTeOxzjP6zOUjfKlaDA 
        if($access_code === '' && !isset($_GET['code'])) {
            $content .= '<a href="https://www.reddit.com/api/v1/authorize?client_id='.$clientId.'&response_type=code&state=RANDOM_STRING&redirect_uri=https://frag.ment:8890/reddit-profiler&duration=permanent&scope=identity%20history">Authorize</a>';
        } 
        if($access_token === false) { //its been over an hour and needs renewal
            $content .= get_access_token();
        } 
        $access_code = get_option('rp_reddit_access_code');
        if($access_code) {
            $content .= reddit_data();
        }
        if(isset($_GET['error'])) {
            $content .= 'ERROR: '.$_GET['error'].'<br>';
        }
        
    }
    return $content;
}

function get_access_token() {
    $return = 'Fetching new token...<br>';
    $redirectUrl = "https://frag.ment:8890/reddit-profiler";
    
    if(isset($_GET['code'])) {
        //first auth
        $access_code = $_GET['code'];
        update_option( 'rp_reddit_access_code', $access_code);
        $params = array(
            "redirect_uri" => $redirectUrl,
            'code' => $access_code,
            'duration' => 'permanent'
        );
       
        $method = 'authorization_code';
    } else {
        //auth expired and we are renewing it
        $access_code = get_option('rp_reddit_access_code');
        if(!$access_code) {
            return;
        }
        $refresh_token = get_option('rp_reddit_refresh_token');
        //$params_defaults = array_merge($params_defaults,array('duration' => 'permanent'));
        $params = array(
            'redirect_uri' => $redirectUrl,
            'refresh_token' => $refresh_token,
            'grant_type' => 'refresh_token',
            'code' => $access_code,
        );
        $method = "refresh_token";
        $return .= 'refreshing token...<br>';
    }
    //echo $access_code;
    $clientId = 'enoXMtUUAn5MNc9cXoLdCg';
    $clientSecret = '6CViJA7MK0wFtfb3e52OnWEJtcWKow';

    $authorizeUrl = 'https://ssl.reddit.com/api/v1/authorize';
    $accessTokenUrl = 'https://ssl.reddit.com/api/v1/access_token';
    $userAgent = 'WPProfileClient/0.1 by fragmentwebworks';

    

    $client = new OAuth2\Client($clientId, $clientSecret, OAuth2\Client::AUTH_TYPE_AUTHORIZATION_BASIC);
    $client->setCurlOption(CURLOPT_USERAGENT,$userAgent);
    //$client->setCurlOption(CURLOPT_HTTPHEADER,array('Content-Type: UTF-8',));
    
    $response = $client->getAccessToken($accessTokenUrl, $method, $params);
    
    $accessTokenResult = $response["result"];
    $access_token = $accessTokenResult["access_token"];
    if($access_token) {
        //echo  $access_token;
        $refresh_token = $accessTokenResult["refresh_token"];
        set_transient('reddit-access-token-expiration', 1, 3600);
        update_option( 'rp_reddit_access_token', $access_token);
        update_option( 'rp_reddit_refresh_token', $refresh_token);
        $return .= 'Token updated!<br><br>';
    } else {
        echo 'error';
        echo print_r($response,true);
    }
    
    return $return;
}

function reddit_data() {
    $access_token = get_option('rp_reddit_access_token');
    if($access_token !== '') {
        $clientId = 'enoXMtUUAn5MNc9cXoLdCg';
        $clientSecret = '6CViJA7MK0wFtfb3e52OnWEJtcWKow';

        $authorizeUrl = 'https://ssl.reddit.com/api/v1/authorize';
        $accessTokenUrl = 'https://ssl.reddit.com/api/v1/access_token';
        $userAgent = 'WPProfileClient/0.1 by fragmentwebworks';

        $redirectUrl = "https://frag.ment:8890/reddit-profiler";

        $client = new OAuth2\Client($clientId, $clientSecret, OAuth2\Client::AUTH_TYPE_AUTHORIZATION_BASIC);
        $client->setCurlOption(CURLOPT_USERAGENT,$userAgent);

        $client->setAccessToken($access_token);
        
        $client->setAccessTokenType(OAuth2\Client::ACCESS_TOKEN_BEARER);

        $response = $client->fetch("https://oauth.reddit.com/api/v1/me.json");

        
        if(json_decode($response['code']) == 401) {
           // delete_transient('reddit_code');
            //delete_transient('reddit-access-token');
            return 'Reload page, error';
        }
        $return = '<pre>';
        $return .= print_r($response,true);
        $return .= '</pre>';
        return $return;
    }
} */
