<?php
/*
 * Add default plugin options
 */
function ytpp_install() {
    add_option( 'ytpp_rel', 0 );
    add_option( 'ytpp_info', 0 );
    add_option( 'ytpp_controls', 1 );
    add_option( 'ytpp_privacy', 0 );
    add_option( 'ytpp_iframe_fix', 1 );

    add_option( 'ytppYouTubeApi', '' );
}

/*
 * Remove default plugin options on uninstall
 */
function ytpp_uninstall() {
    delete_option( 'ytpp_rel' );
    delete_option( 'ytpp_info' );
    delete_option( 'ytpp_controls' );
    delete_option( 'ytpp_privacy' );
    delete_option( 'ytpp_iframe_fix' );

    delete_option( 'ytppYouTubeApi' );
}

/*
 * Add plugin options page
 */
function ytpp_admin() {
    add_options_page( __( 'YouTube Playlist Player', 'youtube-playlist-player' ), __( 'YouTube Playlist Player', 'youtube-playlist-player' ), 'manage_options', 'ytpp', 'ytpp_settings' );
}

/*
 * Show static player/playlist
 *
 * @return string
 */
function ytpp_player_show( $atts ) {
    wp_enqueue_style( 'ytpp' );

    wp_enqueue_script( 'ytpp' );

    if ( (int) get_option( 'ytpp_iframe_fix' ) === 1 ) {
        wp_enqueue_script( 'ytpp-fluid-vids' );
    }

    $atts = shortcode_atts(
        [
            'mainid' => '',
            'vdid'   => '',
        ],
        $atts
    );

    $ytpp_height = (int) get_option( 'ytpp_height' );
    $main_id     = sanitize_text_field( $atts['mainid'] );
    $vd_id       = sanitize_text_field( $atts['vdid'] );

    $ytpp_rel         = (int) get_option( 'ytpp_rel' );
    $ytpp_info        = (int) get_option( 'ytpp_info' );
    $ytpp_controls    = (int) get_option( 'ytpp_controls' );
    $ytpp_privacy     = (int) get_option( 'ytpp_privacy' );
    $ytpp_youtube_uri = 'https://www.youtube.com';

    if ( (int) $ytpp_privacy === 1 ) {
        $ytpp_youtube_uri = 'https://www.youtube-nocookie.com';
    }

    $out = '<div id="yt-container" class="ytpp-main">
        <a name="ytplayer" class="f"><iframe name="ytpl-frame" id="ytpl-frame" type="text/html" rel="' . $main_id . '" src="' . $ytpp_youtube_uri . '/embed/' . $main_id . '?rel=' . $ytpp_rel . '&hd=1&version=3&iv_load_policy=3&showinfo=' . $ytpp_info . '&controls=' . $ytpp_controls . '&origin=' . home_url() . '" width="560" height="315" loading="lazy"></iframe></a>
        <div id="ytpp-playlist-container" class="ytpp-playlist-container" data-playlist="' . $vd_id . '"><div id="ytplayer_div2"></div></div>
    </div>';

    // There are no filters to be applied for this shortcode
    // Also fixes an issue with the "Rate my post" plugin
    // $out = apply_filters( 'the_content', $out );

    return $out;
}

/*
 * Show dynamic player/playlist
 *
 * Uses YouTube Data API v3.
 *
 * @return string
 */
function ytpp_apiplayer_show( $atts ) {
    wp_enqueue_style( 'ytpp' );

    $atts = shortcode_atts(
        [
            'mainid' => '',
            'vdid'   => '',
        ],
        $atts
    );

    $ytpp_youtube_api = sanitize_text_field( get_option( 'ytppYouTubeApi' ) );
    $main_id          = str_replace( ' ', '', sanitize_text_field( $atts['mainid'] ) );
    $vd_id            = str_replace( ' ', '', sanitize_text_field( $atts['vdid'] ) );

    $ytpp_rel         = (int) get_option( 'ytpp_rel' );
    $ytpp_info        = (int) get_option( 'ytpp_info' );
    $ytpp_controls    = (int) get_option( 'ytpp_controls' );
    $ytpp_privacy     = (int) get_option( 'ytpp_privacy' );
    $ytpp_youtube_uri = 'https://www.youtube.com';

    if ( (int) $ytpp_privacy === 1 ) {
        $ytpp_youtube_uri = 'https://www.youtube-nocookie.com';
    }

    return '<div class="yt-api-container ytpp-main" data-mainid="' . $main_id . '" data-vdid="' . $vd_id . '" data-apikey="' . $ytpp_youtube_api . '">
        <iframe id="vid_frame" src="' . $ytpp_youtube_uri . '/embed/' . $main_id . '?rel=' . $ytpp_rel . '&showinfo=' . $ytpp_info . '&autohide=1&controls=' . $ytpp_controls . '" width="560" height="315" loading="lazy"></iframe>

        <div class="yt-api-video-list"></div>
    </div>';
}
