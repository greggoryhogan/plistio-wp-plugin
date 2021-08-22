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
function gsae_settings() {
    //Tenor API Key
    register_setting( 'gsae_settings', 'gsae_tenor_api_key' );
    //Content Filter
    register_setting( 'gsae_settings', 'gsae_content_filter' );
    //Gifs Per Page
    register_setting( 'gsae_settings', 'gsae_gifs_per_page' );
    
}
add_action( 'admin_init', 'gsae_settings' );

/*
 *
 * Create admin page
 * 
 */
function gsae_admin_settings_page() {
    add_submenu_page( 'options-general.php', 'Gif Search & Embed', 'Gif Search & Embed', 'administrator', 'gif-search-and-embed', 'gsae_settings_content' );
}
add_action( 'admin_menu', 'gsae_admin_settings_page' );    
 
/*
 *
 * Add link to settings page from plugins page
 * 
 */
add_filter('plugin_action_links', 'gsae_add_plugin_settings_link', 10, 2);
function gsae_add_plugin_settings_link( $plugin_actions, $plugin_file ) {
	$added_actions = array();
    if ( 'gif-search-and-embed.php' == basename($plugin_file) ) {
        $added_actions['cl_settings'] = sprintf( __( '<a href="%s" title="Settings">Settings</a>', 'gsae' ), esc_url( menu_page_url( 'gif-search-and-embed', false )  ) );
    }
    return array_merge( $added_actions, $plugin_actions );
}

/*
 *
 * Admin page formatting
 * 
 */
function gsae_settings_content() { ?>
    <style type="text/css">
        .gsae-options {
            display: flex;
        }
        .gsae-options label,
        .gsae-options select {
            display: block;
        }
        .gsae-options label {
            margin-right: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }
    </style>
    <div class="wrap">
        <h1 class="wp-heading-inline">Gif Search and Embed</h1>
        <div class="metabox-holder wrap" id="dashboard-widgets">
            <form method="post" action="options.php">
                <?php settings_fields( 'gsae_settings' ); ?>
                
                <section id="defaults" class="babel-tab-panel">
                    <div class="babel-settings-panel">
                        <!--API Key-->
                        <div class="postbox">
                            <div class="postbox-header"><h2 class="hndle">Tenor API Key</h2></div>
                            <div class="inside">
                                <div class="input-text-wrap">
                                    <p>Gif Search and Embed uses <a href="https://tenor.com/" title="Open Tenor in a new window" target="_blank">Tenor</a> to deliver you these awesome gifs. Tenor requires a (free) API key in order to use their service. If you already have an API key, enter it below.</p>
                                    <input type="text" name="gsae_tenor_api_key" value="<?php echo get_option('gsae_tenor_api_key'); ?>" />
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
                                        <div class="gsae-options">
                                        <?php 
                                        $gsae_content_filter = get_option('gsae_content_filter');
                                        $options = array ('high','medium','low','off');
                                        echo '<div>';
                                            echo '<label for="gsae_content_filter">Content Filter:</label>';
                                            echo '<select name="gsae_content_filter" id="gsae_content_filter" autocomplete="off">';
                                            foreach($options as $option) {
                                                echo '<option value="'.$option.'"';
                                                    if($option == $gsae_content_filter) {
                                                        echo ' selected';
                                                    }
                                                echo '>'.ucwords($option).'</option>';
                                            }
                                            echo '</select>'; 
                                        echo '</div><div>';
                                            echo '<label for="gsae_gifs_per_page">Gifs Per Page:</label>';
                                            $gsae_gifs_per_page = get_option('gsae_gifs_per_page'); 
                                            $options = array (5,10,20,30,40,50);
                                            echo '<select name="gsae_gifs_per_page" id="gsae_gifs_per_page" autocomplete="off">';
                                            foreach($options as $option) {
                                                echo '<option value="'.$option.'"';
                                                    if($option == $gsae_gifs_per_page) {
                                                        echo ' selected';
                                                    }
                                                echo '>'.$option.'</option>';
                                            }
                                            echo '</select>';
                                        echo '</div>';  ?>
                                    </div>
                                    <ul>
                                        <li><strong>Content Filtering Options:</strong></li>
                                        <li>High - G</li>
                                        <li>Medium - G and PG</li>
                                        <li>Low - G, PG, and PG-13</li>
                                        <li>Off - G, PG, PG-13, and R (no nudity)</li>
                                    </ul>
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

/*
 *
 * Admin notices
 * 
 */ 
function gsae_admin_notice() {
    global $current_user;
	$tenor_api_key = get_option('gsae_tenor_api_key');
    if(!$tenor_api_key) {
        $ignore = get_transient('gsae_admin_notice_api_key_ignore');
        if ($ignore === false) {
            $screen = get_current_screen();
            if($screen) {
                $show_on = array('dashboard','plugins');
                if(in_array($screen->base,$show_on)) {
                    echo '<div class="updated notice"><p>'. __('Gif Search &amp; Embed requires a (free) Tenor API key to get started.') .' <a href="'.menu_page_url( 'gif-search-and-embed', false ).'">Enter API Key</a> | <a href="?gsae-ignore-notice">Dismiss</a></p></div>';
                }
            }
        }
    }
}
add_action('admin_notices', 'gsae_admin_notice');

/*
 *
 * Add transient to ignore the notice for 7 days
 * 
 */ 
function gsae_admin_notice_ignore() {
	if (isset($_GET['gsae-ignore-notice'])) {	
        set_transient('gsae_admin_notice_api_key_ignore', 7 * DAY_IN_SECONDS);	
	}
}
add_action('admin_init', 'gsae_admin_notice_ignore');
?>