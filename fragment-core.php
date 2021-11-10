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
require_once( frgmnt_PLUGIN_DIR . '/includes/auth.php' );
/*
 * OAuth Client
 */
if (!class_exists('OAuth2\Client')) {
    require_once( frgmnt_PLUGIN_DIR . '/includes/PHP-OAuth2-master/src/OAuth2/Client.php' );
    require_once( frgmnt_PLUGIN_DIR . '/includes/PHP-OAuth2-master/src/OAuth2/GrantType/IGrantType.php' );
    require_once( frgmnt_PLUGIN_DIR . '/includes/PHP-OAuth2-master/src/OAuth2/GrantType/AuthorizationCode.php' );
    require_once( frgmnt_PLUGIN_DIR . '/includes/PHP-OAuth2-master/src/OAuth2/GrantType/RefreshToken.php' );
}