<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* 
 * Reddit
 */
function frgmnt_plugin_details_reddit() {
    $version = '1.0.2'; //Update this for each update duder
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
?>