<?php
/*
Plugin Name:  Reddit Profiler
Plugin URI:	  https://fragmentwebworks.com/plugins/gif-search-and-embed/
Description:  Search and embed gifs from Tenor to Gutenberg enabled posts, pages and widgets
Version:	  1.0.0
Author:		  Fragment Web Works
Author URI:   https://fragmentwebworks.com
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  rp
Domain Path:  /languages
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//definitions for plugin
define( 'rp_BLOCK_DIR', plugin_dir_url(__FILE__) );
define( 'rp_PLUGIN_DIR', dirname(__FILE__).'/' );

/*
 *
 * Require files for plugin functionality
 * 
 */ 
//settings files
//require_once( rp_PLUGIN_DIR . '/includes/settings.php' );
//rest endpoint
//require_once( rp_PLUGIN_DIR . '/includes/rest.php' );

require_once( rp_PLUGIN_DIR . '/includes/PHP-OAuth2-master/src/OAuth2/Client.php' );
require_once( rp_PLUGIN_DIR . '/includes/PHP-OAuth2-master/src/OAuth2/GrantType/IGrantType.php' );
require_once( rp_PLUGIN_DIR . '/includes/PHP-OAuth2-master/src/OAuth2/GrantType/AuthorizationCode.php' );
require_once( rp_PLUGIN_DIR . '/includes/PHP-OAuth2-master/src/OAuth2/GrantType/RefreshToken.php' );

add_filter('the_content','add_reddit',10,1);
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

        /*if (isset($_GET["error"]))
        {
            echo("<pre>OAuth Error: " . $_GET["error"]."\n");
            echo('<a href="index.php">Retry</a></pre>');
            die;
        }*/

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
}
/*
 *
 * Create default options on activation
 * 
 */ 
register_activation_hook( __FILE__, 'rp_activate' );
function rp_activate() {
    //Tenor API Key
    add_option( 'rp_reddit_access_code', '');
    //Content Filter
    add_option( 'rp_reddit_access_token', '');
    add_option( 'rp_reddit_refresh_token', '');
}

/*
 *
 * Delete plugin options on uninstall
 * 
 */
//register_uninstall_hook( __FILE__, 'rp_uninstall' );
function rp_uninstall() {
    delete_option( 'rp_tenor_api_key');
    delete_option( 'rp_content_filter');
    delete_option( 'rp_gifs_per_page');
}

/*
 *
 * Register styles for block
 * 
 */
function rp_block_assets() {
    // include css style which will be used on both block preview
    // inside Gutemberg block Editor and on the frontend
    wp_enqueue_style( 'rp-style-css', rp_BLOCK_DIR . 'src/style.css', array(), '1.0.0' );
} 
//add_action( 'enqueue_block_assets', 'rp_block_assets' );

/*
 *
 * Register js for block
 *
 */
function rp_editor_assets() {
    // Scripts
    wp_enqueue_script(
        'rp-block-js',
        rp_BLOCK_DIR . 'build/index.js',
        array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
        '1.0.0',
        true
    );
    //add localized settings
    wp_localize_script( 'rp-block-js', 'rp_settings',
        array( 
            'tenor_api_key' => get_option('rp_tenor_api_key'),
            'rp_settings_page' => menu_page_url( 'gif-search-and-embed', false ),
        )
    );
}
//add_action( 'enqueue_block_editor_assets', 'rp_editor_assets' );