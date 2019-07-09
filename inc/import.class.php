<?php
	
	class ravis_booking_import_demo_content
	{
		public function __construct()
		{
			add_filter( 'pt-ocdi/import_files', array ( $this, 'import_files' ) );
			add_action( 'pt-ocdi/after_import', array ( $this, 'after_import' ) );
		}
		
		public function import_files()
		{
			return array (
				array (
					'import_file_name'             => esc_html__( 'Demo Content Import', 'ravis-booking' ),
					'local_import_file'            => RAVIS_BOOKING_PATH . 'demo-data/posts.xml',
					'local_import_widget_file'     => RAVIS_BOOKING_PATH . 'demo-data/widgets.wie',
					'local_import_customizer_file' => RAVIS_BOOKING_PATH . 'demo-data/customizer.dat',
					'local_import_redux'           => array ()
				)
			);
		}
		
		public function after_import()
		{
			$top_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
			set_theme_mod( 'nav_menu_locations', array (
				'primary' => $top_menu->term_id
			) );
			
			$page = get_page_by_title( 'Home Page - Version 1' );
			if ( isset( $page->ID ) )
			{
				update_option( 'page_on_front', $page->ID );
				update_option( 'show_on_front', 'page' );
			}
			
			self::import_plugin_data();
			
		}
		
		public function import_plugin_data()
		{
			global $wpdb;
			$ravis_booking_obj = new Ravis_booking_main;
			$plugin_content    = file_get_contents( RAVIS_BOOKING_PATH . 'demo-data/plugin.json' );
			$imported_raw_obj  = json_decode( $plugin_content );
			
			if ( ! empty( $imported_raw_obj ) )
			{
				$imported_raw_array        = array ();
				$imported_raw_array        = $ravis_booking_obj->ravis_booking_objToArray( $imported_raw_obj, $imported_raw_array );
				$imported_serilized_option = serialize( $imported_raw_array );
				$result                    = $wpdb->get_results( "SELECT * FROM  $wpdb->options WHERE option_name = 'ravis-booking-setting'" );
				
				if ( $result )
				{
					$wpdb->update( $wpdb->options, array (
						'option_value' => $imported_serilized_option
					), array ( 'option_name' => 'ravis-booking-setting' ), array (
						'%s'
					), array ( '%s' ) );
				}
				else
				{
					$wpdb->insert( $wpdb->options, array (
						'option_value' => $imported_serilized_option,
						'option_name'  => 'ravis-booking-setting',
					), array (
						'%s',
						'%s'
					) );
				}
			}
		}
	}
	
	new ravis_booking_import_demo_content();