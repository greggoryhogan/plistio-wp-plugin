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

define( 'FRGMNT_PLUGIN_DIR', dirname(__FILE__).'/' );
if(!defined('FRGMNT_URL')) {
    define('FRGMNT_URL','https://fragmentwebworks.com');
}
if(!defined('REDDIT_CLIENT_ID')) {
    define( 'REDDIT_CLIENT_ID', 'enoXMtUUAn5MNc9cXoLdCg'); //for reddit api requests
}
if(!defined('FRGMNT_JSON_URL')) {
	define( 'FRGMNT_JSON_URL', FRGMNT_URL.'/wp-json/frgmnt/v1'); //wp-json endpoint we use for all plugins
}
/*
 *
 * Require files for plugin functionality
 * 
 */ 

/*
 * OAuth Client
 */
if (!class_exists('OAuth2\Client')) {
    require_once( FRGMNT_PLUGIN_DIR . '/includes/PHP-OAuth2-master/src/OAuth2/Client.php' );
    require_once( FRGMNT_PLUGIN_DIR . '/includes/PHP-OAuth2-master/src/OAuth2/GrantType/IGrantType.php' );
    require_once( FRGMNT_PLUGIN_DIR . '/includes/PHP-OAuth2-master/src/OAuth2/GrantType/AuthorizationCode.php' );
    require_once( FRGMNT_PLUGIN_DIR . '/includes/PHP-OAuth2-master/src/OAuth2/GrantType/RefreshToken.php' );
}

//Juicy Stuff
require_once( FRGMNT_PLUGIN_DIR . '/includes/json.php' );
require_once( FRGMNT_PLUGIN_DIR . '/includes/plugin-data.php' );
require_once( FRGMNT_PLUGIN_DIR . '/includes/reddit.php' );