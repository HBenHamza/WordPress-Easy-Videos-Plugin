<?php

/**
 * Plugin shortcodes management
 */

 if ( !class_exists('easy_videos_shortcode' ) ):
class easy_videos_shortcode {

    public function __construct() {
        //Define custom shortcode to be called in FO
        add_shortcode( 'eavid-gallery', array( $this, 'eavid_generate_shortcode' ) );
	}

    //shortcode Callback
    public function eavid_generate_shortcode() {
        $args = array(
            'post_type' => 'eavid',
            'post_status' => 'publish',
            'posts_per_page' => -1
        );
        $posts = new WP_Query( $args );
        include EASY_VIDEOS_PLUGIN_DIR . 'includes/templates/eavid_front.php';
    }

}
endif;

$shortcode = new easy_videos_shortcode(); 
 