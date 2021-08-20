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
function tfp_settings() {

    //Tenor API Key
    add_option( 'tfg_tenor_api_key', '');
    register_setting( 'tfg_settings', 'tfg_tenor_api_key' );

    add_option( 'tfg_content_filter', 'off');
    register_setting( 'tfg_settings', 'tfg_content_filter' );

    add_option( 'tfg_gifs_per_page', '20');
    register_setting( 'tfg_settings', 'tfg_gifs_per_page' );
    
}
add_action( 'admin_init', 'tfp_settings' );

/*
 *
 * Create admin page
 * 
 */
function tfp_admin_settings_page() {
    add_submenu_page( 'options-general.php', 'Tenor for Gutenberg', 'Tenor for Gutenberg', 'administrator', 'tenor-for-gutenberg', 'tfg_settings_content' );
}
add_action( 'admin_menu', 'tfp_admin_settings_page' );    
    
/*
 *
 * Admin page formatting
 * 
 */
function tfg_settings_content() { ?>
    <style type="text/css">
        .tfg-options {
            display: flex;
        }
        .tfg-options label,
        .tfg-options select {
            display: block;
        }
        .tfg-options label {
            margin-right: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }
    </style>
    <div class="wrap">
        <h1 class="wp-heading-inline">Tenor for Gutenberg</h1>
        <div class="metabox-holder wrap" id="dashboard-widgets">
            <form method="post" action="options.php">
                <?php settings_fields( 'tfg_settings' ); ?>
                
                <section id="defaults" class="babel-tab-panel">
                    <div class="babel-settings-panel">
                        <!--API Key-->
                        <div class="postbox">
                            <div class="postbox-header"><h2 class="hndle">Tenor API Key</h2></div>
                            <div class="inside">
                                <div class="input-text-wrap">
                                    <p>Tenor requires a (free) API key in order to use their service. If you have an API key, enter it below. Don&rsquo;t have an API key? Follow the instructions below.</p>
                                    <input type="text" name="tfg_tenor_api_key" value="<?php echo get_option('tfg_tenor_api_key'); ?>" />
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
                                        <div class="tfg-options">
                                        <?php 
                                        $tfg_content_filter = get_option('tfg_content_filter');
                                        $options = array ('off','low','medium','high');
                                        echo '<div>';
                                            echo '<label for="tfg_content_filter">Content Filter:</label>';
                                            echo '<select name="tfg_content_filter" id="tfg_content_filter" autocomplete="off">';
                                            foreach($options as $option) {
                                                echo '<option value="'.$option.'"';
                                                    if($option == $tfg_content_filter) {
                                                        echo ' selected';
                                                    }
                                                echo '>'.ucwords($option).'</option>';
                                            }
                                            echo '</select>'; 
                                        echo '</div><div>';
                                            echo '<label for="tfg_gifs_per_page">Gifs per Page:</label>';
                                            $tfg_gifs_per_page = get_option('tfg_gifs_per_page'); 
                                            $options = array (5,10,20,30,40,50);
                                            echo '<select name="tfg_gifs_per_page" id="tfg_gifs_per_page" autocomplete="off">';
                                            foreach($options as $option) {
                                                echo '<option value="'.$option.'"';
                                                    if($option == $tfg_gifs_per_page) {
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