<?php

/**
 * Plugin assets management
 */

 if ( !class_exists('easy_videos_scripts' ) ):
class easy_videos_scripts {

    public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'eavid_enqueue_scripts' ) );
	}
 
    
    function eavid_enqueue_scripts() {
        //load Admin JS & CSS
        wp_enqueue_script('eavid_admin_js', EASY_VIDEOS_PLUGIN_URI . 'assets/js/admin.js', array('jquery'), EASY_VIDEOS_VERSION );
        wp_enqueue_style('eavid_admin_css', EASY_VIDEOS_PLUGIN_URI . 'assets/css/admin.css' );
        
        //Defining AJAX URL to be handled in JS
        $ajaxurl_arr = array('ajax_url' => admin_url('admin-ajax.php'));
        wp_localize_script('eavid_admin_js', 'ajaxurl_arr', $ajaxurl_arr);
    }
 
}
endif;

$assets = new easy_videos_scripts(); 
 