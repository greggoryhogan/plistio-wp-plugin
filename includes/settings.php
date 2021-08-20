<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
Functions related to overall plugin functionality
*/

/*
 *
 * Plugin Options for Admin Pages
 * 
 */
function gg_settings() {

    //Tenor API Key
    add_option( 'gg_tenor_api_key', '');
    register_setting( 'gg_settings', 'gg_tenor_api_key' );

    add_option( 'gg_content_filter', 'off');
    register_setting( 'gg_settings', 'gg_content_filter' );

    add_option( 'gg_gifs_per_page', '20');
    register_setting( 'gg_settings', 'gg_gifs_per_page' );
    
}
add_action( 'admin_init', 'gg_settings' );

/*
 *
 * Create admin page
 * 
 */
function gg_admin_settings_page() {
    add_submenu_page( 'options-general.php', 'Gutenberg Gifs', 'Gutenberg Gifs', 'administrator', 'gutenberg-gifs', 'gg_settings_content' );
}
add_action( 'admin_menu', 'gg_admin_settings_page' );    
 
/*
 *
 * Add link to settings page from plugins page
 * 
 */
add_filter('plugin_action_links', 'gg_add_plugin_settings_link', 10, 2);
function gg_add_plugin_settings_link( $plugin_actions, $plugin_file ) {
	$added_actions = array();
    if ( 'gutenberg-gifs.php' == basename($plugin_file) ) {
        $added_actions['cl_settings'] = sprintf( __( '<a href="%s" title="Settings">Settings</a>', 'gg' ), esc_url( menu_page_url( 'gutenberg-gifs', false )  ) );
    }
    return array_merge( $added_actions, $plugin_actions );
}

/*
 *
 * Admin page formatting
 * 
 */
function gg_settings_content() { ?>
    <style type="text/css">
        .gg-options {
            display: flex;
        }
        .gg-options label,
        .gg-options select {
            display: block;
        }
        .gg-options label {
            margin-right: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }
    </style>
    <div class="wrap">
        <h1 class="wp-heading-inline">Gutenberg Gifs</h1>
        <div class="metabox-holder wrap" id="dashboard-widgets">
            <form method="post" action="options.php">
                <?php settings_fields( 'gg_settings' ); ?>
                
                <section id="defaults" class="babel-tab-panel">
                    <div class="babel-settings-panel">
                        <!--API Key-->
                        <div class="postbox">
                            <div class="postbox-header"><h2 class="hndle">Tenor API Key</h2></div>
                            <div class="inside">
                                <div class="input-text-wrap">
                                    <p>Gutenberg Gifs uses <a href="https://tenor.com/" title="Open Tenor in a new window" target="_blank">Tenor</a> to deliver you these awesome gifs. Tenor requires a (free) API key in order to use their service. If you have an API key, enter it below. Don&rsquo;t have an API key? Follow the instructions below.</p>
                                    <input type="text" name="gg_tenor_api_key" value="<?php echo get_option('gg_tenor_api_key'); ?>" />
                                    <p><strong>Don&rsquo;t have an API key?</strong>
                                    <ol>
                                        <li>Visit <a href="https://tenor.com/developer/keyregistration" target="_blank" title="Tenor API Key Registration">https://tenor.com/developer/keyregistration</a>
                                        <li>If you don't have an account, it will prompt you to log in using your Google account.</li>
                                        <li>Enter app name and description. These can be whatever you&rsquo;d you like, such as your website name.</li>
                                        <li>Copy the generated key and paste it above.</li>
                                        <li>You&rsquo;re done! Start adding gifs to your website!</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <!--Search Settings-->
                        <div class="postbox">
                            <div class="postbox-header"><h2 class="hndle">Tenor Search Results</h2></div>
                            <div class="inside">
                                <div class="input-text-wrap">
                                    <p>If you want to change the way results are returned when searching, update the options below.</p>
                                        <div class="gg-options">
                                        <?php 
                                        $gg_content_filter = get_option('gg_content_filter');
                                        $options = array ('off','low','medium','high');
                                        echo '<div>';
                                            echo '<label for="gg_content_filter">Content Filter:</label>';
                                            echo '<select name="gg_content_filter" id="gg_content_filter" autocomplete="off">';
                                            foreach($options as $option) {
                                                echo '<option value="'.$option.'"';
                                                    if($option == $gg_content_filter) {
                                                        echo ' selected';
                                                    }
                                                echo '>'.ucwords($option).'</option>';
                                            }
                                            echo '</select>'; 
                                        echo '</div><div>';
                                            echo '<label for="gg_gifs_per_page">Gifs per Page:</label>';
                                            $gg_gifs_per_page = get_option('gg_gifs_per_page'); 
                                            $options = array (5,10,20,30,40,50);
                                            echo '<select name="gg_gifs_per_page" id="gg_gifs_per_page" autocomplete="off">';
                                            foreach($options as $option) {
                                                echo '<option value="'.$option.'"';
                                                    if($option == $gg_gifs_per_page) {
                                                        echo ' selected';
                                                    }
                                                echo '>'.$option.'</option>';
                                            }
                                            echo '</select>';
                                        echo '</div>'; ?>
                                    </div>
                                </div>
                            </div>
                            
                            
                        </div>
                    </div>
                    <div class="clear"></div>
                </section>
                    
                <?php submit_button(); ?>
            </form>    
        </div>
    </div>
<?php
}
?>