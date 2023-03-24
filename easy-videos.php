<?php
/** 
 *
 * @package   Easy videos Heimdal™ Security
 * @author    Hatem Ben Hamza <hatembenhamzacrk09@gmail.com>
 *
 * @wordpress-plugin
 * Plugin Name:           Easy videos
 * Description:           Bulk import videos from any youtube channel
 * Version:               1.0.0
 * Author:                Hatem Ben Hamza
 * Text Domain:           hmdseceasyvideos
 */

if( ! defined( 'EASY_VIDEOS_ACCESS_DENIED_ALERT' ) ) define( 'EASY_VIDEOS_ACCESS_DENIED_ALERT', __( 'Sorry, you are not allowed to access this page.', 'hmdseceasyvideos' ) );

/**
 * Protect direct access
 */
if ( ! defined( 'ABSPATH' ) ) die( EASY_VIDEOS_ACCESS_DENIED_ALERT );

/**
 * Defining constants
*/
if( ! defined( 'EASY_VIDEOS_VERSION' ) ) define( 'EASY_VIDEOS_VERSION', '1.0.0' );
if( ! defined( 'EASY_VIDEOS_MENU_POSITION' ) ) define( 'EASY_VIDEOS_MENU_POSITION', '2' );
if( ! defined( 'EASY_VIDEOS_PLUGIN_DIR' ) ) define( 'EASY_VIDEOS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
if( ! defined( 'EASY_VIDEOS_PLUGIN_URI' ) ) define( 'EASY_VIDEOS_PLUGIN_URI', plugin_dir_url( __FILE__ ) );
if( ! defined( 'EASY_VIDEOS_API_URL' ) ) define( 'EASY_VIDEOS_API_URL', 'https://www.googleapis.com/youtube/v3/search' );

add_action( 'init', function() {
    require_once EASY_VIDEOS_PLUGIN_DIR . '/includes/easy_videos_posttype.php';
});

add_action( 'plugins_loaded', function() {
    require_once EASY_VIDEOS_PLUGIN_DIR . '/includes/easy_videos_scripts.php';
    require_once EASY_VIDEOS_PLUGIN_DIR . '/includes/easy_videos_settings.php';
    require_once EASY_VIDEOS_PLUGIN_DIR . '/includes/easy_videos_shortcode.php';
}, -999999 );
