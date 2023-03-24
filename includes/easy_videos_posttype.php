<?php

/**
 * Plugin custom posts management
 */

 if ( !class_exists('easy_videos_posttype' ) ):
class easy_videos_posttype {

    public function __construct() {
		$this->eavid_setup_custom_posts();
	}

    function eavid_setup_custom_posts() {
        $args = array(
            'labels' => array(
            'name' => __( 'Easy Videos' , 'hmdseceasyvideos' ),
            'singular_name' => __( 'Easy Video' , 'hmdseceasyvideos' )
            ),
            'public' => false,
            'has_archive' => false,
            'rewrite' => array('slug' => 'eavid'),
            'menu_position' => (int)EASY_VIDEOS_MENU_POSITION + 1,
        );
        register_post_type( 'eavid', $args );    
    } 

}
endif;

$CPT = new easy_videos_posttype(); 
 