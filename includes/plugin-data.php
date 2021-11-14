<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* 
 * Reddit
 */
function frgmnt_plugin_details_reddit() {
    
    $version = '1.1.2'; //Update this for each update duder

    return array(
        'name' => 'Reddit Profiler',
        'slug' => 'reddit-profiler',
        'author' => '<a href="https://fragmentwebworks.com">Fragment Web Works</a>',
        'author_profile' => "https://profiles.wordpress.org/fragmentwebworks/",
        'version' => $version,
        'download_url' => FRGMNT_URL .'/plugin-updates/reddit-profiler/reddit-profiler.zip',
        "requires" => '5.3',
        'tested' => '5.8',
        'requires_php' => '7.0',
        'last_updated' => '2021-11-09 02:10:00',
        'sections' => array(
            'description' => 'Use data from your reddit profile in your WordPress install',
            'installation' => 'After clicking activate, head to the settings page to connect your reddit account.',
            'changelog' => '<h4>1.0 –  November 9, 2021</h4><ul><li>Initial Release.</li></ul>',
        ),
        "banners" => array(
            'low' => 'https://fragmentwebworks.com/updates/reddit-profiler/banner-772x250.jpg',
            'high' => 'https://fragmentwebworks.com/updates/reddit-profiler/banner-1544x500.jpg'
        )
    );
} 

/*
 * Check keys
 */
function frgmnt_license_key_check($key) {
    if(!isset($_GET['plugin'])) {
        return array(
            'success' => 0,
            'message' => 'invalid request..'
        );
    }
    $orders = wc_get_orders( array(
        'limit'        => -1, // Query all orders
        'orderby'      => 'date',
        'order'        => 'DESC',
        'meta_key'     => 'license-key', // The postmeta key field
        'meta_compare' => '=', // The comparison argument
        'meta_value' => $key
    ));    
    if($orders) {
        $updating = false;
        if(isset($_GET['update-plugin'])) {
            $updating = true;
        }
        foreach($orders as $order) {
            $order_id = $order->get_id();
            if(isset($_GET['deactivate'])) { //deactivate
                delete_post_meta($order_id,'active-license-key-'.$key); //make key inactive
                return array(
                    'success' => 0,
                    'message' => 'Your license key has been deactivated.'
                );
            } else if(get_post_meta($order_id,'active-license-key-'.$key,true) && !$updating) { //in use
                return array(
                    'success' => 0,
                    'message' => 'This license key has already been activated. Please disconnect it before using it in this installation.'
                );
            } else { //active!
                if(!$updating) {
                    add_post_meta($order_id,'active-license-key-'.$key,1); //make key active
                }
                $name = get_post_meta($order_id,'license-key-'.$key.'-name',true);
                $plugin = ucwords(str_replace('-',' ',$_GET['plugin']));
                if($name != $plugin) {
                    return array(
                        'success' => 0,
                        'message' => 'This key is associated with a different product.'
                    );
                } else {
                    return array(
                        'success' => 1,
                        'message' => 'Thank you for activating your license.'
                    );
                }
            }
        }
    } else {
        return array(
            'success' => 0,
            'message' => 'Please enter a valid license key.'
        );
    }
} 
?>