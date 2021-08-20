<?php
/*
Plugin Name:  Tenor for Gutenberg
Plugin URI:	  https://fragmentwebworks.com/product/tenor-for-gutenberg/
Description:  Add Tenor gifs to your posts and pages using a Gutenberg block
Version:	  1.0.0
Author:		  Fragment Web Works
Author URI:   https://fragmentwebworks.com
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  tfg
Domain Path:  /languages
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//define plugin dir 
define( 'TFG_BLOCK_DIR', plugin_dir_url(__FILE__) );
define( 'TFG_PLUGIN_DIR', dirname(__FILE__).'/' );

/*
 *
 * Require files for plugin functionality
 * 
 */ 
//settings files
require_once( TFG_PLUGIN_DIR . '/includes/settings.php' );
//settings files
require_once( TFG_PLUGIN_DIR . '/includes/rest.php' );

/**
 * callback function for registeing our block style
 * in both Gutemberg editor and frontend
 *
 * @return void
 */
function tfg_block_assets() {
    
    // include css style which will be used on both block preview
    // inside Gutemberg block Editor and on the frontend
    wp_enqueue_style( 'tfg-style-css', TFG_BLOCK_DIR . 'src/style.css', array(), '1.0.0' );
} 
add_action( 'enqueue_block_assets', 'tfg_block_assets' );


/**
 * Callback function for registering our block with Gutemberg
 *
 * @return void
 */
function tfg_editor_assets() {
  
    // Scripts.
    wp_enqueue_script(
        'tfg-block-js',
        TFG_BLOCK_DIR . 'build/index.js',
        array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
        '1.0.0',
        true
    );
    //add localized settings
    wp_localize_script( 'tfg-block-js', 'tfg_settings',
        array( 
            'tenor_api_key' => get_option('tfg_tenor_api_key'),
            'tfg_settings_page' => menu_page_url( 'tenor-for-gutenberg', false ),
        )
    );
}
add_action( 'enqueue_block_editor_assets', 'tfg_editor_assets' );

