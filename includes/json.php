<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * Register endpoints
 */ 
add_action( 'rest_api_init', 'create_plistio_rest_endpoints');
function create_plistio_rest_endpoints() {
    $GLOBALS['user_id'] = get_current_user_id(); //<- add this
    //check for plugin updates
    register_rest_route( 'plistio/v1', '/action/(?P<action_item>([a-zA-Z0-9-]|%20)+)', array(
        'methods' => 'GET',
        'callback' => 'plistio_callback',
        'permission_callback' => '__return_true'
      ) );
} 



/*
 * Callback for plugin update check
 */ 
function plistio_callback($request) {
    $action_item = $request['action_item'];
    if($action_item == 'auth') {
        //they came from authorizing spotify
        $response = new WP_REST_Response(plistio_interpret_spotify_callback());
        $response->set_status(200);
    } else {
        $response = new WP_REST_Response(array());
        $response->set_status(401);
    }
    return $response;
}

function plistio_interpret_spotify_callback() {
    global $wpdb;
    $session = new SpotifyWebAPI\Session(
        SPOTIFY_CLIENT_ID,
        SPOTIFY_CLIENT_SECRET,
        SPOTIFY_REDIRECT_URI
    );
    
    if (isset($_GET['code'])) {
        /*$state = $_GET['state'];
        // Fetch the stored state value from somewhere. A session for example
        if ($state !== SPOTIFY_STATE) {
            // The state returned isn't the same as the one we've stored, we shouldn't continue
            //die('State mismatch');
        }*/

        // Request a access token using the code from Spotify
        $session->requestAccessToken($_GET['code']);
        $accessToken = $session->getAccessToken();
        $refreshToken = $session->getRefreshToken();

        // Store the access and refresh tokens somewhere. In a session for example
        $table = $wpdb->prefix.'plistio_auth';
        $data = array( 
            'spotify_code' => $_GET['code'], 
            'spotify_access_token' => $accessToken, 
            'spotify_refresh_token' => $refreshToken, 
        ); 
        $where = array('id' => $GLOBALS['user_id']);
        $wpdb->update($table, $data, $where);
        wp_redirect(get_bloginfo('url').'?connected=1');
        exit;
    } else {
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
        wp_redirect($session->getAuthorizeUrl($options));
        exit;
    }
}
?>