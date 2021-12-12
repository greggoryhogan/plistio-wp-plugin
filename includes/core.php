<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

 /*
 *
 * Make sure table for plistio users exists
 * 
 */
add_action('admin_init', 'plistio_custom_db_tables');
function plistio_custom_db_tables() {
	global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE {$wpdb->base_prefix}plistio_auth (
		id mediumint(8) unsigned NOT NULL auto_increment,
		username varchar(250),
        spotify_code varchar(500),
        spotify_expiration varchar(100),
		spotify_access_token varchar(500),
        spotify_refresh_token varchar(500),
		PRIMARY KEY  (id)
		) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	$tablename = 'plistio_auth';
	maybe_create_table( $wpdb->prefix . $tablename,  $sql );
}

/* temproary shortcode for debugging */
add_shortcode('plistio_tmp',function() {
    $user_id = get_current_user_ID();
    if($user_id > 0) {
        if(user_has_authorized_spotify($user_id)) {
            $return = '';
            $refreshToken = get_spotify_refresh_token( $user_id );
            $session = new SpotifyWebAPI\Session(
                SPOTIFY_CLIENT_ID,
                SPOTIFY_CLIENT_SECRET,
                SPOTIFY_REDIRECT_URI
            );
            $options = [
                'auto_refresh' => true,
            ];
            
            $session->refreshAccessToken($refreshToken);
            $accessToken = $session->getAccessToken();
            $refreshToken = $session->getRefreshToken();

            $api = new SpotifyWebAPI\SpotifyWebAPI($options, $session);
            // Set our new access token on the API wrapper and continue to use the API as usual
            $api->setAccessToken($accessToken);
            
            // Call the API as usual
            $me = $api->me();
            $return .= 'Welcome '.$me->display_name.', thanks for authorizing!<br>Here are some playlists you have<br>';
            $spotify_id = $me->id;
            
            $playlists = $api->getUserPlaylists($spotify_id);
            
            foreach ($playlists->items as $playlist) {
                $return .= '<a href="' . $playlist->external_urls->spotify . '">' . $playlist->name . '</a> <br>';
            }
            //$newlist = $api->createPlaylist(array('name'=>'Plistio Test','public'=>false));
            //$newlistid = $newlist->id;
            //$return .= $newlistid .' ID!';
            //$api->unfollowPlaylist('5ied7LVuEgl1FkL4RXqzxl');
            //print_r($newlist);

            return $return; 
           

        } else {
            $session = new SpotifyWebAPI\Session(
                SPOTIFY_CLIENT_ID,
                SPOTIFY_CLIENT_SECRET,
                SPOTIFY_REDIRECT_URI
            );
            $options = [
                'scope' => [
                    'user-read-playback-state',
                    'user-modify-playback-state',
                    'user-read-currently-playing',
                    'user-read-email',
                    'playlist-modify-private',
                    'playlist-read-collaborative',
                    'playlist-read-private',
                    'playlist-modify-public'
                ],

            ];
            return '<a href="'.$session->getAuthorizeUrl($options).'" class="btn btn-primary">Authorize Spotify</a>';
        }
    } else {
        return 'No one is logged in';
    }
});

function user_has_authorized_spotify($user_id) {
    global $wpdb;
    $table = $wpdb->prefix.'plistio_auth';
    $result = $wpdb->query("SELECT * FROM ".$table." WHERE id = $user_id;");
    $rows =  $wpdb->get_results("SELECT * FROM ".$table." WHERE id = $user_id;" , OBJECT);
    if(empty($result)) {
        $data = array('id' => $user_id);
        $format = array('%s');
        $wpdb->insert($table,$data,$format);
        return false;
    } else {
        foreach($rows as $row) {  
            if($row->spotify_access_token === null) {
                return false;
            }
        }
    }
    return true;

}

function get_spotify_refresh_token( $user_id ) {
    global $wpdb;
    $table = $wpdb->prefix.'plistio_auth';
    $result = $wpdb->query("SELECT * FROM ".$table." WHERE id = $user_id;");
    $rows =  $wpdb->get_results("SELECT * FROM ".$table." WHERE id = $user_id;" , OBJECT);
    if(!empty($result)) {
        foreach($rows as $row) {  
            return $row->spotify_refresh_token;
        }
    }
}

function get_spotify_auth_endpoint() {
    $redirect = PLISTIO_JSON_URL . '/action/auth';
    $state = 'efjeiroapu4';
    $auth_link = 'https://www.reddit.com/api/v1/authorize?client_id='.REDDIT_CLIENT_ID.'&response_type=code&state='.$state.'&redirect_uri='.$redirect.'&duration=permanent&scope=identity%20history';
    return $auth_link;
}
?>