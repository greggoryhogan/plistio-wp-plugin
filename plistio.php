<?php
/*
Plugin Name:  Plistio
Plugin URI:	  https://plistio.com
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
define( 'PLISTIO_PLUGIN_DIR', dirname(__FILE__).'/' );
if(!defined('PLISTIO_JSON_URL')) {
	define( 'PLISTIO_JSON_URL', get_bloginfo('url').'/wp-json/plistio/v1'); //wp-json endpoint we use for all plugins
}

//Juicy Stuff
require PLISTIO_PLUGIN_DIR .'/vendor/autoload.php';
require_once( PLISTIO_PLUGIN_DIR . '/includes/core.php' );
require_once( PLISTIO_PLUGIN_DIR . '/includes/json.php' );