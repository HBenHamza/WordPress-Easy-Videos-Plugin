<?php

/**
 * Plugin configuration page
 */

if ( !class_exists('easy_videos_settings' ) ):
class easy_videos_settings {
    
    public function __construct() {
		add_action( 'admin_menu', array( $this, 'eavid_create_settings' ) );
		add_action( 'admin_init', array( $this, 'eavid_setup_sections' ) );
		add_action( 'admin_init', array( $this, 'eavid_setup_fields' ) );

		//Define AJAX callbacks
		add_action( 'wp_ajax_save_eavid_settings', array( $this , 'save_eavid_settings' ));
		add_action( 'wp_ajax_nopriv_save_eavid_settings', array( $this , 'save_eavid_settings' ));

		add_action( 'wp_ajax_save_eavid_save_cpt_data', array( $this , 'save_eavid_save_cpt_data' ));
		add_action( 'wp_ajax_nopriv_save_eavid_save_cpt_data', array( $this , 'save_eavid_save_cpt_data' ));

		
	}

	//Plugin Menu Settup
	public function eavid_create_settings() {
		$page_title = __( 'Easy Videos Settings', 'hmdseceasyvideos' ); 
		$menu_title = __( 'Easy Videos', 'hmdseceasyvideos' );
		$capability = 'manage_options';
		$slug = 'EasyVideos';
		$callback = array($this, 'eavid_settings_content');
        $icon = 'dashicons-admin-plugins';
		$position = EASY_VIDEOS_MENU_POSITION;
		
		add_menu_page($page_title, $menu_title, $capability, $slug, $callback, $icon, $position);
		
	}
    
	//Define Plugin Settings Form
	public function eavid_settings_content() { ?>  			
		<div class="wrap">
			<h1><?php echo __( 'Easy Videos Settings', 'hmdseceasyvideos' ); ?></h1>
			<?php settings_errors(); ?>
			<form method="POST" action="options.php" id="easy-videos-form">
				<?php
					settings_fields( 'EasyVideos' );
					do_settings_sections( 'EasyVideos' );
					submit_button();
				?>
			</form>
			<div class="preview-data"></div>
		</div>
		<?php
	}

	public function eavid_setup_sections() {
		add_settings_section( 'EasyVideos_section', '', array(), 'EasyVideos' );
	}

	public function eavid_setup_fields() {
		$fields = array(
            array(
                'section' => 'EasyVideos_section',
				'label' => __( 'Youtube API KEY', 'hmdseceasyvideos' ),
                'id' => 'eavid_api_key',
                'desc' => '<a href="https://developers.google.com/youtube/v3/docs">(https://developers.google.com/youtube/v3/docs)</a>',
                'type' => 'text',
            ),
            array(
                'section' => 'EasyVideos_section',
				'label' => __( 'Channel ID', 'hmdseceasyvideos' ),
                'id' => 'eavid_channel_id',
                'type' => 'text',
            ),
			array(
				'section' => 'EasyVideos_section',
				'id'  => 'eavid_videos_count',
				'label' => __( 'Pagination', 'hmdseceasyvideos' ),
				'desc'  => __( 'Set 1-50 number of videos to display ', 'hmdseceasyvideos' ),
				'type'  => 'number',
				'min'   => 1,
				'max'   => 50,
			),
		);  
		
        foreach( $fields as $field ){
			add_settings_field( $field['id'], $field['label'], array( $this, 'eavid_field_callback' ), 'EasyVideos', $field['section'], $field );
			register_setting( 'EasyVideos', $field['id'] );
		}

	}
	public function eavid_field_callback( $field ) {
		$value = get_option( $field['id'] );
		$placeholder = '';
		if ( isset($field['placeholder']) ) {
			$placeholder = $field['placeholder'];
		}
		switch ( $field['type'] ) {
			default:
				printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />',
					$field['id'],
					$field['type'],
					$placeholder,
					$value
				);
		}
		if( isset($field['desc']) ) {
			if( $desc = $field['desc'] ) {
				printf( '<p class="description">%s </p>', $desc );
			}
		}
	}
    
	public function save_eavid_settings() {
		foreach($_POST['params'] as $key => $value) {
			update_option($key,$value);
		}  

		$endpoint_url = 'https://www.googleapis.com/youtube/v3/search';
		$endpoint_url .= '?part=snippet';
		$endpoint_url .= '&channelId='.get_option('eavid_channel_id').'';
		$endpoint_url .= '&maxResults='.get_option('eavid_videos_count').'';
		$endpoint_url .= '&type=video';
		$endpoint_url .= '&key='.get_option('eavid_api_key').'';

		$api_response = wp_remote_get( $endpoint_url, array( 'sslverify' => false ) );
		$api_response_xml      = wp_remote_retrieve_body( $api_response );
		$api_response_json   = json_decode( $api_response_xml ,true );

		include EASY_VIDEOS_PLUGIN_DIR . 'includes/templates/eavid_admin.php';

		wp_die();
	}

	//save CPT data
	public function save_eavid_save_cpt_data() {
		foreach($_POST['videos'] as $video) {
			$new_post = array(
				'post_type' => 'eavid',
				'post_title' => $video['title'],
				'post_status' => 'publish'
			);
			   
			$post_id = wp_insert_post( $new_post );
			
			//add custom post meta
			add_post_meta($post_id, 'videoId', $video['videoId']);
			add_post_meta($post_id, 'description', $video['description']);
			add_post_meta($post_id, 'published_time', $video['published_time']);
			add_post_meta($post_id, 'medium_thumbnail_url', $video['medium_thumbnail_url']);
		}
		wp_die();
	}


}
endif;

$settings = new easy_videos_settings();
