<?php
	/**
	 * Plugin Name: Ravis Booking
	 * Plugin URI: http://ravistheme.com
	 * Description: Advanced Hotel Booking Plugin
	 * Version: 1.0.0
	 * Author: RavisTheme
	 * Author URI: http://ravistheme.com
	 * Text Domain: ravis-booking
	 * Domain Path:  /languages
	 */

	if ( ! defined( 'ABSPATH' ) )
	{
		exit;
	}

	require_once ABSPATH . 'wp-admin/includes/plugin.php';

	if ( ! defined( 'RAVIS_BOOKING_THEMEROOT' ) )
	{
		define( 'RAVIS_BOOKING_THEMEROOT', get_template_directory() );
	}

	if ( ! defined( 'THEME_BASE_URL' ) )
	{
		if ( get_template_directory_uri() === get_stylesheet_directory_uri() )
		{
			define( 'THEME_BASE_URL', get_stylesheet_directory_uri() );
		}
		else
		{
			define( 'THEME_BASE_URL', get_template_directory_uri() );
		}
	}

	register_activation_hook( __FILE__, array ( 'Ravis_booking_main', 'ravis_booking_activate' ) );
	register_deactivation_hook( __FILE__, array ( 'Ravis_booking_main', 'ravis_booking_deactivate' ) );
	// register_uninstall_hook( __FILE__, array( 'Ravis_booking_main', 'uninstall' ) );

	/**
	 * ------------------------------------------------------------------------------------------
	 * Define Constants and Variables
	 * ------------------------------------------------------------------------------------------
	 */
	$ravis_booking_base = __FILE__;

	if ( ! defined( 'RAVIS_BOOKING_BASE_URL' ) )
	{
		define( 'RAVIS_BOOKING_BASE_URL', esc_url( plugin_dir_url( __FILE__ ) ) );
	}

	if ( ! defined( 'RAVIS_BOOKING_IMG_PATH' ) )
	{
		define( 'RAVIS_BOOKING_IMG_PATH', RAVIS_BOOKING_BASE_URL . 'assets/img/' );
	}

	if ( ! defined( 'RAVIS_BOOKING_JS_PATH' ) )
	{
		define( 'RAVIS_BOOKING_JS_PATH', RAVIS_BOOKING_BASE_URL . 'assets/js/' );
	}

	if ( ! defined( 'RAVIS_BOOKING_CSS_PATH' ) )
	{
		define( 'RAVIS_BOOKING_CSS_PATH', RAVIS_BOOKING_BASE_URL . 'assets/css/' );
	}

	if ( ! defined( 'RAVIS_BOOKING_BASE' ) )
	{
		define( 'RAVIS_BOOKING_BASE', $ravis_booking_base );
	}

	if ( ! defined( 'RAVIS_BOOKING_PATH' ) )
	{
		define( 'RAVIS_BOOKING_PATH', plugin_dir_path( $ravis_booking_base ) );
	}

	if ( ! defined( 'RAVIS_BOOKING_URL' ) )
	{
		define( 'RAVIS_BOOKING_URL', plugins_url( '/', $ravis_booking_base ) );
	}

	if ( ! defined( 'RAVIS_BOOKING_MAIN_FILE' ) )
	{
		define( 'RAVIS_BOOKING_MAIN_FILE', $ravis_booking_base );
	}

	if ( ! defined( 'RAVIS_BOOKING_CONFIG' ) )
	{
		define( 'RAVIS_BOOKING_CONFIG', RAVIS_BOOKING_PATH . 'conf/' );
	}

	if ( ! defined( 'RAVIS_BOOKING_WIDGETS' ) )
	{
		define( 'RAVIS_BOOKING_WIDGETS', RAVIS_BOOKING_PATH . 'widgets/' );
	}

	if ( ! defined( 'RAVIS_BOOKING_SHORTCODES' ) )
	{
		define( 'RAVIS_BOOKING_SHORTCODES', RAVIS_BOOKING_PATH . 'shortcodes/' );
	}

	if ( ! defined( 'RAVIS_BOOKING_INCLUDES' ) )
	{
		define( 'RAVIS_BOOKING_INCLUDES', RAVIS_BOOKING_PATH . 'inc/' );
	}

	if ( ! defined( 'RAVIS_BOOKING_TPL' ) )
	{
		define( 'RAVIS_BOOKING_TPL', RAVIS_BOOKING_PATH . 'tpl/' );
	}

	$ravis_plg_data = get_plugin_data( RAVIS_BOOKING_PATH . 'ravis-booking.php' );
	define( 'RAVIS_BOOKING_VERSION', $ravis_plg_data['Version'] );

	/**
	 * ------------------------------------------------------------------------------------------
	 * Add ajax class
	 * ------------------------------------------------------------------------------------------
	 */
	require_once RAVIS_BOOKING_INCLUDES . 'ajax.class.php';

	/**
	 * ------------------------------------------------------------------------------------------
	 * Add shortcode class
	 * ------------------------------------------------------------------------------------------
	 */
	require_once RAVIS_BOOKING_INCLUDES . 'shortcode.class.php';

	/**
	 * ------------------------------------------------------------------------------------------
	 *  Add DataBase Class
	 * ------------------------------------------------------------------------------------------
	 */
	require_once RAVIS_BOOKING_INCLUDES . 'db.class.php';

	/**
	 * ------------------------------------------------------------------------------------------
	 *  Add Page Templater Class
	 * ------------------------------------------------------------------------------------------
	 */
	require_once RAVIS_BOOKING_INCLUDES . 'templater.class.php';

	/**
	 * ------------------------------------------------------------------------------------------
	 *  Add Get information Class
	 * ------------------------------------------------------------------------------------------
	 */
	require_once RAVIS_BOOKING_INCLUDES . 'get_info.class.php';

	/**
	 * ------------------------------------------------------------------------------------------
	 *  Get Pages URL
	 * ------------------------------------------------------------------------------------------
	 */
	require_once RAVIS_BOOKING_INCLUDES . 'get_pages.class.php';

	/**
	 * ------------------------------------------------------------------------------------------
	 *  Add Posts Class ( Properties, Agents and etc )
	 * ------------------------------------------------------------------------------------------
	 */
	require_once RAVIS_BOOKING_INCLUDES . 'insert_posts.class.php';

	/**
	 * ------------------------------------------------------------------------------------------
	 *  Currency Class
	 * ------------------------------------------------------------------------------------------
	 */
	require_once RAVIS_BOOKING_INCLUDES . 'currency.class.php';

	/**
	 * ------------------------------------------------------------------------------------------
	 *  Meta Box Creator Class
	 * ------------------------------------------------------------------------------------------
	 */
	require_once RAVIS_BOOKING_INCLUDES . 'meta_box.class.php';

	/**
	 * ------------------------------------------------------------------------------------------
	 *  Booking Process Class
	 * ------------------------------------------------------------------------------------------
	 */
	require_once RAVIS_BOOKING_INCLUDES . 'booking.class.php';

	/**
	 * ------------------------------------------------------------------------------------------
	 *  User Class
	 * ------------------------------------------------------------------------------------------
	 */
	require_once RAVIS_BOOKING_INCLUDES . 'user.class.php';

	/**
	 * ------------------------------------------------------------------------------------------
	 *  Import Demo Content Class
	 * ------------------------------------------------------------------------------------------
	 */
	require_once RAVIS_BOOKING_INCLUDES . 'import.class.php';

	/**
	 * ------------------------------------------------------------------------------------------
	 * Coupon class
	 * ------------------------------------------------------------------------------------------
	 */
	require_once RAVIS_BOOKING_INCLUDES . 'coupon.class.php';

	/**
	 * ------------------------------------------------------------------------------------------
	 * Main Class of Ravis Booking
	 * ------------------------------------------------------------------------------------------
	 */
	class Ravis_booking_main
	{
		public function __construct()
		{
			add_action( 'init', array ( $this, 'ravis_load_plugin_text_domain' ) );
			add_action( 'init', array ( $this, 'ravis_booking_register_custom_post_type' ) );
			add_action( 'init', array ( $this, 'ravis_booking_init_meta_boxes' ) );
			// Add Required CSS / JS files
			add_action( 'admin_enqueue_scripts', array ( $this, 'ravis_booking_register_scripts' ), 10, 1 );

			// Add Required CSS / JS files - FrontEnd
			add_action( 'wp_enqueue_scripts', array ( $this, 'ravis_booking_register_scripts_front' ), 10, 1 );

			// Add Button to TinyMCE Functions
			add_filter( 'mce_external_plugins', array ( $this, 'ravis_booking_add_buttons' ) );
			add_filter( 'mce_buttons', array ( $this, 'ravis_booking_register_buttons' ) );
			add_action( 'wp_ajax_ravis_tinymce', array ( $this, 'ravis_booking_ajax_tinymce' ) );

			add_action( 'plugins_loaded', array ( 'Ravis_booking_page_templater', 'get_instance' ) );

			add_action( 'admin_menu', array ( $this, 'ravis_booking_menu_items' ) );
			add_action( 'admin_init', array ( $this, 'ravis_booking_init_setting_page' ) );

			$user_update_obj = new Ravis_booking_user();
			add_action( 'automatic_user_update', array ( $user_update_obj, 'automatic_profile_updater' ) );

			add_action( 'wp_ajax_nopriv_ravis_booking_import_options', array (
				$this,
				'ravis_booking_import_options',
			) );
			add_action( 'wp_ajax_ravis_booking_import_options', array ( $this, 'ravis_booking_import_options' ) );
			add_filter( 'body_class', array ( $this, 'ravis_booking_add_body_class' ) );
		}

		public static function ravis_booking_activate()
		{
			if ( ! wp_next_scheduled( 'automatic_user_update' ) )
			{
				wp_schedule_event( time(), 'hourly', 'automatic_user_update' );
			}

			$required_template_creation = new Ravis_booking_db_class();
			$required_template_creation->required_tables();
		}

		public static function ravis_booking_deactivate()
		{
			wp_clear_scheduled_hook( 'automatic_user_update' );
		}

		public static function ravis_load_plugin_text_domain()
		{
			load_plugin_textdomain( 'ravis-booking', false, 'ravis-booking/languages/' );
		}

		public static function ravis_booking_register_custom_post_type()
		{
			/**
			 * ------------------------------------------------------------------------------------------
			 * Hotel Section post_type
			 * ------------------------------------------------------------------------------------------
			 */
			register_post_type( 'hotel_section', array (
				'label'               => esc_html__( 'Hotel Section', 'ravis-booking' ),
				'description'         => esc_html__( 'Manage the hotel sections in this section.', 'ravis-booking' ),
				'exclude_from_search' => true,
				'public'              => true,
				'has_archive'         => true,
				'rewrite'             => array ( 'slug' => 'hotel_section' ),
				'supports'            => array ( 'title', 'editor', 'thumbnail' ),
				'menu_icon'           => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/PjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHg9IjBweCIgeT0iMHB4IiB3aWR0aD0iNTEycHgiIGhlaWdodD0iNTEycHgiIHZpZXdCb3g9IjAgMCA1NjQuNzYgNTY0Ljc2IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1NjQuNzYgNTY0Ljc2OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+PGc+PGc+PHBhdGggZD0iTTQ1OC4xNDksNzIuNjAyaC04My40MTV2MzUuMTUzdjEyLjQ5N2MwLDEyLjQ4NS00LjY3NiwyMy43NTEtMTMuNTIsMzIuNTg5Yy04Ljg0NCw4Ljg0My0yMC4xMTYsMTMuNTE5LTMyLjU4OSwxMy41MTkgICAgaC05Mi40OThjLTEyLjQ3MiwwLTIzLjczOS00LjY3Ni0zMi41ODMtMTMuNTEzYy04Ljg1LTguODQ0LTEzLjUyNS0yMC4xMS0xMy41MjUtMzIuNTk1di0xMi40OTdWNzIuNjAyaC04My40MTYgICAgYy00Ljc2MSwwLTguODg2LDEuNzM4LTEyLjM2Miw1LjIxNGMtMy40NzcsMy40ODgtNS4yMjEsNy42MDctNS4yMjEsMTIuMzU2djQ1Ny4wMTFjMCw0Ljc1NCwxLjczOCw4Ljg3OSw1LjIyMSwxMi4zNTUgICAgYzMuNDc2LDMuNDc3LDcuNTk1LDUuMjIxLDEyLjM2Miw1LjIyMWgxMTcuNDM3Yy0wLjQyOC0yLjAyLTAuNjkxLTQuMS0wLjY5MS02LjI4NVY1MjkuNnYtNTEuMTYyICAgIGMwLTcuOTgsMi45MDctMTQuODk2LDguNzU4LTIwLjc1NGM1LjgzOC01LjgyLDEyLjc1NC04Ljc1MiwyMC43NTMtOC43NTJoNTkuMDI3YzcuOTg2LDAsMTQuOTAyLDIuOTM5LDIwLjc1Myw4Ljc1MiAgICBjNS44MzgsNS44NTcsOC43NjQsMTIuNzczLDguNzY0LDIwLjc1NFY1MjkuNnYyOC44NzVjMCwyLjE4Ni0wLjI1Nyw0LjI2Ni0wLjY5MSw2LjI4NWgxMTcuNDQyYzQuNzU2LDAsOC44ODEtMS43NDQsMTIuMzYyLTUuMjIxICAgIGMzLjQ3Ny0zLjQ4Miw1LjIyMS03LjYwMiw1LjIyMS0xMi4zNTVWOTAuMTcyYzAtNC43NTUtMS43NDQtOC44NzQtNS4yMjEtMTIuMzU2QzQ2Ny4wMjksNzQuMzQsNDYyLjkxMSw3Mi42MDIsNDU4LjE0OSw3Mi42MDJ6ICAgICBNNDI4LjUxMSw0MDQuNThjLTIuMTEyLDIuMTEzLTQuNjA4LDMuMTY0LTcuNDk3LDMuMTY0aC0yMS4zMjhjLTIuODg5LDAtNS4zOTMtMS4wNTEtNy41MDQtMy4xNjQgICAgYy0yLjExMS0yLjExMS0zLjE2NC00LjYwNy0zLjE2NC03LjQ5NnYtMjEuMzI4YzAtMi44ODMsMS4wNTMtNS4zODUsMy4xNjQtNy40OTZjMi4xMTEtMi4xMDUsNC42MDgtMy4xNzIsNy41MDQtMy4xNzJoMjEuMzI4ICAgIGMyLjg4OSwwLDUuMzg1LDEuMDY2LDcuNDk3LDMuMTcyYzIuMTExLDIuMTE3LDMuMTcsNC42MTMsMy4xNyw3LjQ5NnYyMS4zMjhDNDMxLjY4MSwzOTkuOTczLDQzMC42MjIsNDAyLjQ3Nyw0MjguNTExLDQwNC41OHogICAgIE00MzEuNjgxLDQ2MS4wNjh2MjEuMzI4YzAsMi44OTUtMS4wNTksNS4zOTgtMy4xNyw3LjQ5OGMtMi4xMTIsMi4xMTctNC42MDgsMy4xNjQtNy40OTcsMy4xNjRoLTIxLjMyOCAgICBjLTIuODg5LDAtNS4zOTMtMS4wNDctNy41MDQtMy4xNjRjLTIuMTExLTIuMTA1LTMuMTY0LTQuNjA0LTMuMTY0LTcuNDk4di0yMS4zMjhjMC0yLjg4MywxLjA1My01LjM4NSwzLjE2NC03LjQ5NiAgICBjMi4xMTEtMi4xMDUsNC42MDgtMy4xNjQsNy41MDQtMy4xNjRoMjEuMzI4YzIuODg5LDAsNS4zODUsMS4wNTksNy40OTcsMy4xNjRDNDMwLjYyMiw0NTUuNjg5LDQzMS42ODEsNDU4LjE4Niw0MzEuNjgxLDQ2MS4wNjh6ICAgICBNNDI4LjUxMSwzMTkuMjYyYy0yLjExMiwyLjExNy00LjYwOCwzLjE3LTcuNDk3LDMuMTdoLTIxLjMyOGMtMi44ODksMC01LjM5My0xLjA1My03LjUwNC0zLjE3ICAgIGMtMi4xMTEtMi4xMDUtMy4xNjQtNC42MDItMy4xNjQtNy40OTZ2LTIxLjMyMmMwLTIuODg5LDEuMDUzLTUuMzkzLDMuMTY0LTcuNDk4YzIuMTExLTIuMTExLDQuNjA4LTMuMTY5LDcuNTA0LTMuMTY5aDIxLjMyOCAgICBjMi44ODksMCw1LjM4NSwxLjA1OSw3LjQ5NywzLjE2OWMyLjExMSwyLjExMSwzLjE3LDQuNjA5LDMuMTcsNy40OTh2MjEuMzIyQzQzMS42ODEsMzE0LjY2LDQzMC42MjIsMzE3LjE2Miw0MjguNTExLDMxOS4yNjJ6ICAgICBNNDI4LjUxMSwyMzMuOTQ5Yy0yLjExMiwyLjExOC00LjYwOCwzLjE3LTcuNDk3LDMuMTdoLTIxLjMyOGMtMi44ODksMC01LjM5My0xLjA1My03LjUwNC0zLjE3ICAgIGMtMi4xMTEtMi4xMDUtMy4xNjQtNC42MDItMy4xNjQtNy40OTd2LTIxLjMyOGMwLTIuODgyLDEuMDUzLTUuMzg2LDMuMTY0LTcuNDk3YzIuMTExLTIuMTA1LDQuNjA4LTMuMTY0LDcuNTA0LTMuMTY0aDIxLjMyOCAgICBjMi44ODksMCw1LjM4NSwxLjA1OSw3LjQ5NywzLjE2NGMyLjExMSwyLjExOCwzLjE3LDQuNjE1LDMuMTcsNy40OTd2MjEuMzI4QzQzMS42ODEsMjI5LjM0Nyw0MzAuNjIyLDIzMS44NSw0MjguNTExLDIzMy45NDl6ICAgICBNNDI4LjUxMSwxNDguNjM2Yy0yLjExMiwyLjExOC00LjYwOCwzLjE2NC03LjQ5NywzLjE2NGgtMjEuMzI4Yy0yLjg4OSwwLTUuMzkzLTEuMDQ2LTcuNTA0LTMuMTY0ICAgIGMtMi4xMTEtMi4xMDUtMy4xNjQtNC42MDItMy4xNjQtNy40OTd2LTIxLjMyOWMwLTIuODgyLDEuMDUzLTUuMzg1LDMuMTY0LTcuNDk3YzIuMTExLTIuMTA1LDQuNjA4LTMuMTY0LDcuNTA0LTMuMTY0aDIxLjMyOCAgICBjMi44ODksMCw1LjM4NSwxLjA1OSw3LjQ5NywzLjE2NGMyLjExMSwyLjExNywzLjE3LDQuNjE0LDMuMTcsNy40OTd2MjEuMzI5QzQzMS42ODEsMTQ0LjAzNCw0MzAuNjIyLDE0Ni41MzcsNDI4LjUxMSwxNDguNjM2eiAgICAgTTMwMy43MDUsMjA1LjEyNGMwLTIuODgyLDEuMDUzLTUuMzg2LDMuMTY0LTcuNDk3YzIuMTExLTIuMTA1LDQuNjA4LTMuMTY0LDcuNDk3LTMuMTY0aDIxLjMyOGMyLjg4MywwLDUuMzgsMS4wNTksNy40OTcsMy4xNjQgICAgYzIuMTExLDIuMTE4LDMuMTY0LDQuNjE1LDMuMTY0LDcuNDk3djIxLjMyOGMwLDIuODk1LTEuMDUzLDUuMzk4LTMuMTY0LDcuNDk3Yy0yLjExNywyLjExOC00LjYxNCwzLjE3LTcuNDk3LDMuMTdoLTIxLjMyOCAgICBjLTIuODg5LDAtNS4zODYtMS4wNTMtNy40OTctMy4xN2MtMi4xMTEtMi4xMDUtMy4xNjQtNC42MDItMy4xNjQtNy40OTdWMjA1LjEyNHogTTMwMy43MDUsMjkwLjQ0MyAgICBjMC0yLjg4OSwxLjA1My01LjM5MywzLjE2NC03LjQ5OGMyLjExMS0yLjExMSw0LjYwOC0zLjE2OSw3LjQ5Ny0zLjE2OWgyMS4zMjhjMi44ODMsMCw1LjM4LDEuMDU5LDcuNDk3LDMuMTY5ICAgIGMyLjExMSwyLjExMSwzLjE2NCw0LjYwOSwzLjE2NCw3LjQ5OHYyMS4zMjJjMCwyLjg5NS0xLjA1Myw1LjM5Ni0zLjE2NCw3LjQ5NmMtMi4xMTcsMi4xMTctNC42MTQsMy4xNy03LjQ5NywzLjE3aC0yMS4zMjggICAgYy0yLjg4OSwwLTUuMzg2LTEuMDUzLTcuNDk3LTMuMTdjLTIuMTExLTIuMTA1LTMuMTY0LTQuNjAyLTMuMTY0LTcuNDk2VjI5MC40NDN6IE0xNzIuNTcyLDQwNC41OCAgICBjLTIuMTE3LDIuMTEzLTQuNjE0LDMuMTY0LTcuNTAzLDMuMTY0aC0yMS4zMjhjLTIuODg5LDAtNS4zOTItMS4wNTEtNy40OTctMy4xNjRjLTIuMTE4LTIuMTExLTMuMTctNC42MDctMy4xNy03LjQ5NnYtMjEuMzI4ICAgIGMwLTIuODgzLDEuMDUzLTUuMzg1LDMuMTctNy40OTZjMi4xMDUtMi4xMDUsNC42MDgtMy4xNzIsNy40OTctMy4xNzJoMjEuMzI4YzIuODg5LDAsNS4zODYsMS4wNjYsNy41MDMsMy4xNzIgICAgYzIuMTA1LDIuMTE3LDMuMTY0LDQuNjEzLDMuMTY0LDcuNDk2djIxLjMyOEMxNzUuNzM2LDM5OS45NzMsMTc0LjY3Nyw0MDIuNDc3LDE3Mi41NzIsNDA0LjU4eiBNMTc1LjczNiw0NjEuMDY4djIxLjMyOCAgICBjMCwyLjg5NS0xLjA1OSw1LjM5OC0zLjE2NCw3LjQ5OGMtMi4xMTcsMi4xMTctNC42MTQsMy4xNjQtNy41MDMsMy4xNjRoLTIxLjMyOGMtMi44ODksMC01LjM5Mi0xLjA0Ny03LjQ5Ny0zLjE2NCAgICBjLTIuMTE4LTIuMTA1LTMuMTctNC42MDQtMy4xNy03LjQ5OHYtMjEuMzI4YzAtMi44ODMsMS4wNTMtNS4zODUsMy4xNy03LjQ5NmMyLjEwNS0yLjEwNSw0LjYwOC0zLjE2NCw3LjQ5Ny0zLjE2NGgyMS4zMjggICAgYzIuODg5LDAsNS4zODYsMS4wNTksNy41MDMsMy4xNjRDMTc0LjY3Nyw0NTUuNjg5LDE3NS43MzYsNDU4LjE4NiwxNzUuNzM2LDQ2MS4wNjh6IE0xNzIuNTcyLDMxOS4yNjIgICAgYy0yLjExNywyLjExNy00LjYxNCwzLjE3LTcuNTAzLDMuMTdoLTIxLjMyOGMtMi44ODksMC01LjM5Mi0xLjA1My03LjQ5Ny0zLjE3Yy0yLjExOC0yLjEwNS0zLjE3LTQuNjAyLTMuMTctNy40OTZ2LTIxLjMyMiAgICBjMC0yLjg4OSwxLjA1My01LjM5MywzLjE3LTcuNDk4YzIuMTA1LTIuMTExLDQuNjA4LTMuMTY5LDcuNDk3LTMuMTY5aDIxLjMyOGMyLjg4OSwwLDUuMzg2LDEuMDU5LDcuNTAzLDMuMTY5ICAgIGMyLjEwNSwyLjExMSwzLjE2NCw0LjYwOSwzLjE2NCw3LjQ5OHYyMS4zMjJDMTc1LjczNiwzMTQuNjYsMTc0LjY3NywzMTcuMTYyLDE3Mi41NzIsMzE5LjI2MnogTTE3Mi41NzIsMjMzLjk0OSAgICBjLTIuMTE3LDIuMTE4LTQuNjE0LDMuMTctNy41MDMsMy4xN2gtMjEuMzI4Yy0yLjg4OSwwLTUuMzkyLTEuMDUzLTcuNDk3LTMuMTdjLTIuMTE4LTIuMTA1LTMuMTctNC42MDItMy4xNy03LjQ5N3YtMjEuMzI4ICAgIGMwLTIuODgyLDEuMDUzLTUuMzg2LDMuMTctNy40OTdjMi4xMDUtMi4xMDUsNC42MDgtMy4xNjQsNy40OTctMy4xNjRoMjEuMzI4YzIuODg5LDAsNS4zODYsMS4wNTksNy41MDMsMy4xNjQgICAgYzIuMTA1LDIuMTE4LDMuMTY0LDQuNjE1LDMuMTY0LDcuNDk3djIxLjMyOEMxNzUuNzM2LDIyOS4zNDcsMTc0LjY3NywyMzEuODUsMTcyLjU3MiwyMzMuOTQ5eiBNMTcyLjU3MiwxNDguNjM2ICAgIGMtMi4xMTcsMi4xMTgtNC42MTQsMy4xNjQtNy41MDMsMy4xNjRoLTIxLjMyOGMtMi44ODksMC01LjM5Mi0xLjA0Ni03LjQ5Ny0zLjE2NGMtMi4xMTgtMi4xMDUtMy4xNy00LjYwMi0zLjE3LTcuNDk3di0yMS4zMjkgICAgYzAtMi44ODIsMS4wNTMtNS4zODUsMy4xNy03LjQ5N2MyLjEwNS0yLjEwNSw0LjYwOC0zLjE2NCw3LjQ5Ny0zLjE2NGgyMS4zMjhjMi44ODksMCw1LjM4NiwxLjA1OSw3LjUwMywzLjE2NCAgICBjMi4xMDUsMi4xMTcsMy4xNjQsNC42MTQsMy4xNjQsNy40OTd2MjEuMzI5QzE3NS43MzYsMTQ0LjAzNCwxNzQuNjc3LDE0Ni41MzcsMTcyLjU3MiwxNDguNjM2eiBNMjYxLjA0OSwzOTcuMDg0ICAgIGMwLDIuODg5LTEuMDU5LDUuMzkzLTMuMTY0LDcuNDk2Yy0yLjExOCwyLjExMS00LjYxNSwzLjE2NC03LjUwMywzLjE2NGgtMjEuMzI5Yy0yLjg4OSwwLTUuMzg1LTEuMDUzLTcuNDk3LTMuMTY0ICAgIGMtMi4xMTItMi4xMTEtMy4xNjQtNC42MDctMy4xNjQtNy40OTZ2LTIxLjMyOGMwLTIuODgzLDEuMDUyLTUuMzg1LDMuMTY0LTcuNDk4YzIuMTExLTIuMTA0LDQuNjA4LTMuMTcsNy40OTctMy4xN2gyMS4zMjkgICAgYzIuODgyLDAsNS4zODUsMS4wNjYsNy41MDMsMy4xN2MyLjEwNSwyLjExOSwzLjE2NCw0LjYxNSwzLjE2NCw3LjQ5OFYzOTcuMDg0eiBNMjYxLjA0OSwzMTEuNzY2YzAsMi44OTUtMS4wNTksNS4zOTYtMy4xNjQsNy40OTYgICAgYy0yLjExOCwyLjExNy00LjYxNSwzLjE3LTcuNTAzLDMuMTdoLTIxLjMyOWMtMi44ODksMC01LjM4NS0xLjA1My03LjQ5Ny0zLjE3Yy0yLjExMi0yLjEwNS0zLjE2NC00LjYwMi0zLjE2NC03LjQ5NnYtMjEuMzIyICAgIGMwLTIuODg5LDEuMDUyLTUuMzkzLDMuMTY0LTcuNDk4YzIuMTExLTIuMTExLDQuNjA4LTMuMTY5LDcuNDk3LTMuMTY5aDIxLjMyOWMyLjg4MiwwLDUuMzg1LDEuMDU5LDcuNTAzLDMuMTY5ICAgIGMyLjEwNSwyLjExMSwzLjE2NCw0LjYwOSwzLjE2NCw3LjQ5OFYzMTEuNzY2eiBNMjYxLjA0OSwyMjYuNDUyYzAsMi44OTUtMS4wNTksNS4zOTgtMy4xNjQsNy40OTcgICAgYy0yLjExOCwyLjExOC00LjYxNSwzLjE3LTcuNTAzLDMuMTdoLTIxLjMyOWMtMi44ODksMC01LjM4NS0xLjA1My03LjQ5Ny0zLjE3Yy0yLjExMi0yLjEwNS0zLjE2NC00LjYwMi0zLjE2NC03LjQ5N3YtMjEuMzI4ICAgIGMwLTIuODgyLDEuMDUyLTUuMzg2LDMuMTY0LTcuNDk3YzIuMTExLTIuMTA1LDQuNjA4LTMuMTY0LDcuNDk3LTMuMTY0aDIxLjMyOWMyLjg4MiwwLDUuMzg1LDEuMDU5LDcuNTAzLDMuMTY0ICAgIGMyLjEwNSwyLjExOCwzLjE2NCw0LjYxNSwzLjE2NCw3LjQ5N1YyMjYuNDUyeiBNMzM1LjcsNDA3Ljc0NGgtMjEuMzI4Yy0yLjg4OSwwLTUuMzg2LTEuMDUxLTcuNDk3LTMuMTY0ICAgIGMtMi4xMTEtMi4xMTEtMy4xNjQtNC42MDctMy4xNjQtNy40OTZ2LTIxLjMyOGMwLTIuODgzLDEuMDUzLTUuMzg1LDMuMTY0LTcuNDk2YzIuMTExLTIuMTA1LDQuNjA4LTMuMTcyLDcuNDk3LTMuMTcySDMzNS43ICAgIGMyLjg4MywwLDUuMzgsMS4wNjYsNy40OTcsMy4xNzJjMi4xMTEsMi4xMTcsMy4xNjQsNC42MTMsMy4xNjQsNy40OTZ2MjEuMzI4YzAsMi44ODktMS4wNTMsNS4zOTMtMy4xNjQsNy40OTYgICAgQzM0MS4wOCw0MDYuNjkxLDMzOC41ODMsNDA3Ljc0NCwzMzUuNyw0MDcuNzQ0eiIgZmlsbD0iI2EwYTVhYSIvPjxwYXRoIGQ9Ik0yMTguNDE3LDE0MS40MzljNS4wNDMsNC4yOSwxMC45MTIsNi41NjEsMTcuNzExLDYuNTYxaDIyLjI5NWg0Ny45MTloMjIuMjg5YzYuNzkzLDAsMTIuNjYyLTIuMjcxLDE3LjcxMS02LjU2MSAgICBjMC42MzEtMC41MzMsMS4yOTItMC45NzksMS44OTctMS41NzljNS40MjktNS40MjgsOC4xNDYtMTEuOTY0LDguMTQ2LTE5LjYwOHYtMTIuNDk3VjcyLjYwMlYyNy43NTQgICAgYzAtNy42NDQtMi43MTEtMTQuMTgtOC4xNDYtMTkuNjA4QzM0Mi44MTIsMi43MTcsMzM2LjI3NSwwLDMyOC42MzIsMGgtOTIuNTA0Yy03LjY0NCwwLTE0LjE4LDIuNzE3LTE5LjYwOCw4LjE0NiAgICBjLTUuNDI4LDUuNDI4LTguMTQ2LDExLjk2NC04LjE0NiwxOS42MDh2NDQuODQ3djM1LjE1M3YxMi40OTdjMCw3LjY0NCwyLjcxMSwxNC4xOCw4LjE0NiwxOS42MDggICAgQzIxNy4xMjUsMTQwLjQ2LDIxNy43OTIsMTQwLjkwMSwyMTguNDE3LDE0MS40Mzl6IE0yMzMuMDQzLDcyLjYwMlYzMC44MzNjMC0xLjY2NSwwLjYxMi0zLjExNSwxLjgzLTQuMzMzczIuNjY4LTEuODMsNC4zMzMtMS44MyAgICBoMTIuMzMyYzEuNjcxLDAsMy4xMTUsMC42MTIsNC4zMzMsMS44M2MxLjIxOCwxLjIyNCwxLjgzLDIuNjY4LDEuODMsNC4zMzN2MzAuODMzaDQ5LjMzM1YzMC44MzNjMC0xLjY2NSwwLjYxMi0zLjExNSwxLjgzLTQuMzMzICAgIHMyLjY2OC0xLjgzLDQuMzMzLTEuODNoMTIuMzMyYzEuNjcxLDAsMy4xMTUsMC42MTIsNC4zMzMsMS44M2MxLjIxOCwxLjIyNCwxLjgyOSwyLjY2OCwxLjgyOSw0LjMzM3Y0MS43Njl2MzUuMTUzdjEuMzk2djguMDE3ICAgIGMwLDEuNjcxLTAuNjExLDMuMTE1LTEuODI5LDQuMzMzYy0xLjIyNSwxLjIyNC0yLjY2OSwxLjgzLTQuMzMzLDEuODNoLTEyLjMzMmMtMS42NzEsMC0zLjExNS0wLjYwNi00LjMzMy0xLjgzICAgIGMtMS4yMjQtMS4yMTgtMS44My0yLjY2Mi0xLjgzLTQuMzMzdi01di00LjQxM3YtMjEuNDJoLTQ5LjMyMXYyMS40MnY0LjQxM3Y1YzAsMS42NzEtMC42MTIsMy4xMTUtMS44Myw0LjMzMyAgICBjLTEuMjI0LDEuMjI0LTIuNjY4LDEuODMtNC4zMzMsMS44M2gtMTIuMzMyYy0xLjY3MSwwLTMuMTE1LTAuNjA2LTQuMzMzLTEuODNjLTEuMjI0LTEuMjE4LTEuODMtMi42NjItMS44My00LjMzM3YtOC4wMTd2LTEuMzk2ICAgIFY3Mi42MDJIMjMzLjA0M3oiIGZpbGw9IiNhMGE1YWEiLz48L2c+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjwvc3ZnPg==',
			) );

			/**
			 * ------------------------------------------------------------------------------------------
			 * Rooms post_type
			 * ------------------------------------------------------------------------------------------
			 */
			register_post_type( 'rooms', array (
				'label'               => esc_html__( 'Rooms', 'ravis-booking' ),
				'description'         => esc_html__( 'Manage the rooms of hotel.', 'ravis-booking' ),
				'public'              => true,
				'exclude_from_search' => true,
				'has_archive'         => true,
				'rewrite'             => array ( 'slug' => 'rooms' ),
				'supports'            => array ( 'title', 'editor', 'comments' ),
				'menu_icon'           => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/PjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHg9IjBweCIgeT0iMHB4IiB2aWV3Qm94PSIwIDAgMzkwLjU1NyAzOTAuNTU3IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCAzOTAuNTU3IDM5MC41NTc7IiB4bWw6c3BhY2U9InByZXNlcnZlIiB3aWR0aD0iNTEycHgiIGhlaWdodD0iNTEycHgiPjxnPjxwYXRoIGQ9Ik0zODkuNzcyLDI0OC4yOTZsLTQyLjk5MS02OC4wNjNWNTUuMDI4bC0xNy41LTE3LjVINjEuMjc1bC0xNy41LDE3LjV2MTI1LjIwNEwwLjc4NCwyNDguMjk2ICAgSDM4OS43NzJ6IE0zMTEuNzgxLDcyLjUyOHY4Ny4zNjJjLTIyLjU1My01LjgzNC02MS41MTQtMTMuMDI4LTExNi41MDMtMTMuMDI4cy05My45NSw3LjE5NC0xMTYuNTAzLDEzLjAyOFY3Mi41MjhIMzExLjc4MXoiIGZpbGw9IiNhMGE1YWEiLz48cG9seWdvbiBwb2ludHM9IjAsMjY5LjgzMSAwLDMwNC44MzEgNDAuNzc4LDMwNC44MzEgNDAuNzc4LDM1My4wMjggNzUuNzc4LDM1My4wMjggNzUuNzc4LDMwNC44MzEgICAgMzE0Ljc3OCwzMDQuODMxIDMxNC43NzgsMzUzLjAyOCAzNDkuNzc4LDM1My4wMjggMzQ5Ljc3OCwzMDQuODMxIDM5MC41NTcsMzA0LjgzMSAzOTAuNTU3LDI2OS44MzEgICIgZmlsbD0iI2EwYTVhYSIvPjxwYXRoIGQ9Ik0xODEuMDc1LDEyOC42NTN2LTIwLjM4OWMwLTEyLjEwMi0xNy41NjQtMjEuOTE2LTM5LjIzLTIxLjkxNnMtMzkuMjI5LDkuODE0LTM5LjIyOSwyMS45MTZ2MzAuNjA0ICAgYzAsMCwyMy4xNC01LjgyNiwzOS4wNDUtNy4zMzJDMTU1Ljk4LDEzMC4xNzksMTgxLjA3NSwxMjguNjUzLDE4MS4wNzUsMTI4LjY1M3oiIGZpbGw9IiNhMGE1YWEiLz48cGF0aCBkPSJNMjg3Ljk0MSwxMzguODY4di0zMC42MDRjMC0xMi4xMDItMTcuNTY0LTIxLjkxNi0zOS4yMy0yMS45MTZzLTM5LjIzLDkuODE0LTM5LjIzLDIxLjkxNnYyMC4zODkgICBjMCwwLDI1LjA5NiwxLjUyNSwzOS40MTUsMi44ODNDMjY0LjgwMiwxMzMuMDQyLDI4Ny45NDEsMTM4Ljg2OCwyODcuOTQxLDEzOC44Njh6IiBmaWxsPSIjYTBhNWFhIi8+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjwvc3ZnPg==',
			) );

			$labels = array (
				'name'          => _x( 'Room Categories', 'Taxonomy plural name', 'ravis-booking' ),
				'singular_name' => _x( 'Room Category', 'Taxonomy singular name', 'ravis-booking' ),
			);

			$args = array (
				'labels'            => $labels,
				'public'            => true,
				'show_admin_column' => true,
				'hierarchical'      => true,
				'query_var'         => true,
				'rewrite'           => array ( 'slug' => 'room-category' ),
			);

			register_taxonomy( 'room-category', array ( 'rooms' ), $args );

			/**
			 * ------------------------------------------------------------------------------------------
			 * Block dates post_type
			 * ------------------------------------------------------------------------------------------
			 */
			register_post_type( 'block_dates', array (
				'label'               => esc_html__( 'Block Dates', 'ravis-booking' ),
				'description'         => esc_html__( 'Manage the Block Dates.', 'ravis-booking' ),
				'public'              => true,
				'has_archive'         => true,
				'exclude_from_search' => true,
				'rewrite'             => array ( 'slug' => 'block-dates' ),
				'supports'            => array ( 'title' ),
				'menu_icon'           => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/PjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHg9IjBweCIgeT0iMHB4IiB3aWR0aD0iNTEycHgiIGhlaWdodD0iNTEycHgiIHZpZXdCb3g9IjAgMCA0MTYuMjA4IDQxNi4yMDkiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDQxNi4yMDggNDE2LjIwOTsiIHhtbDpzcGFjZT0icHJlc2VydmUiPjxnPjxwYXRoIGQ9Ik0zNDQuNzU3LDE2Ni45aC0yMC41NDN2LTUwLjc5MkMzMjQuMjE0LDUyLjA4NiwyNzIuMTI4LDAsMjA4LjEwNywwQzE0NC4wODQsMCw5MS45OTYsNTIuMDg2LDkxLjk5NiwxMTYuMTA4VjE2Ni45SDcxLjQ1MyAgIGMtNi42MzUsMC0xMi4wMTIsNS4zNzctMTIuMDEyLDEyLjAxMXYyMjUuMjg2YzAsNi42MzUsNS4zNzcsMTIuMDEyLDEyLjAxMiwxMi4wMTJoMjczLjMwNWM2LjYzMywwLDEyLjAxLTUuMzc3LDEyLjAxLTEyLjAxMiAgIFYxNzguOTExQzM1Ni43NjcsMTcyLjI3NywzNTEuMzksMTY2LjksMzQ0Ljc1NywxNjYuOXogTTIyNi44MzMsMzA0LjAxMnY0Ny45NjFjMCw0LjE4OS0zLjM5Niw3LjU4Ni03LjU4Niw3LjU4NmgtMjIuMjg2ICAgYy00LjE4OSwwLTcuNTg2LTMuMzk2LTcuNTg2LTcuNTg2di00Ny45NjFjLTguMjg3LTUuODc1LTEzLjY5OS0xNS41MzUtMTMuNjk5LTI2LjQ2NmMwLTE3LjkwNywxNC41MTgtMzIuNDI3LDMyLjQyOC0zMi40MjcgICBjMTcuOTA4LDAsMzIuNDI2LDE0LjUyLDMyLjQyNiwzMi40MjdDMjQwLjUzMSwyODguNDc3LDIzNS4xMTksMjk4LjEzNywyMjYuODMzLDMwNC4wMTJ6IE0yNjguNzc5LDE2Ni45SDE0Ny40MzF2LTUwLjc5MiAgIGMwLTMzLjQ1NiwyNy4yMTktNjAuNjczLDYwLjY3Ni02MC42NzNjMzMuNDU1LDAsNjAuNjcyLDI3LjIxNyw2MC42NzIsNjAuNjczVjE2Ni45eiIgZmlsbD0iI2EwYTVhYSIvPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48L3N2Zz4=',
			) );

			/**
			 * ------------------------------------------------------------------------------------------
			 * Services post_type
			 * ------------------------------------------------------------------------------------------
			 */
			register_post_type( 'service', array (
				'label'               => esc_html__( 'Service', 'ravis-booking' ),
				'description'         => esc_html__( 'Manage the services that your hotel provide.', 'ravis-booking' ),
				'public'              => true,
				'has_archive'         => false,
				'exclude_from_search' => true,
				'rewrite'             => array ( 'slug' => 'service' ),
				'supports'            => array ( 'title', 'editor', 'thumbnail' ),
				'menu_icon'           => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/PjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHg9IjBweCIgeT0iMHB4IiB3aWR0aD0iNTEycHgiIGhlaWdodD0iNTEycHgiIHZpZXdCb3g9IjAgMCAzODAuNzIxIDM4MC43MjIiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDM4MC43MjEgMzgwLjcyMjsiIHhtbDpzcGFjZT0icHJlc2VydmUiPjxnPjxnPjxwYXRoIGQ9Ik0xMjkuMTk0LDE5NS4yNDZjMC4yNS00LjA3MiwwLjUtOC4xNSwxLjAzNC0xMi4yNjljMC45ODctOS43NjYsMy4xMDgtMTkuNTcyLDUuMjc1LTI5LjExMSAgICBjMS4zMTktNC43NTgsMi43NDgtOS40NTgsNC4yNDctMTQuMDUzYzEuOTE3LTQuNDg1LDMuNzkzLTguOTQ2LDUuNjY0LTEzLjMwM2M0LjIzNS04LjUwNSw4Ljk3LTE2LjQ1MiwxNC42MjItMjMuMTA0ICAgIGMxLjM0Mi0xLjcxNCwyLjY3Mi0zLjM3NSwzLjk3NC01LjA0MmMxLjQ4Ny0xLjQ4NywyLjk3NS0yLjkyOCw0LjQwOS00LjM2OWMzLjAyNy0yLjczNiw1LjY1Mi01LjY5OSw4LjY3NC03Ljg3MiAgICBjNi4wMjMtNC40NjEsMTEuMzUyLTguNzAyLDE2Ljc3Ny0xMS4zMjhjNS4yMjktMi45MTcsOS43MTMtNS40NDksMTMuNzU2LTYuODc4YzcuOTI0LTMuMTg5LDEyLjQyMS00Ljc5MiwxMi40MjEtNC43OTIgICAgcy0zLjgzNSwzLjA0NC0xMC41MzgsNy45ODJjLTMuNDYzLDIuMjYtNy4xMzQsNS44MjctMTEuNTAzLDkuNDgxYy00LjU1NSwzLjQ4NS04LjY3OSw4LjQ4MS0xMy41ODIsMTMuMjY5ICAgIGMtMi40NTIsMi40NDYtNC4zNTYsNS41MTktNi42NzUsOC4zNDhjLTEuMTI3LDEuNDQxLTIuMjgzLDIuODkzLTMuNDc1LDQuMzY5Yy0wLjk2NCwxLjYyNy0xLjk2MywzLjI1OS0yLjk3NCw0LjkyNiAgICBjLTQuMzI4LDYuNDE0LTcuNTYzLDEzLjk0My0xMC45MzQsMjEuNTgyYy0xLjM4MywzLjk5Ny0yLjc4Miw4LjA1Mi00LjIxMiwxMi4xNDdjLTAuOTc2LDQuMjU4LTIuMDU2LDguNTYyLTMuMjM1LDEyLjg1ICAgIGMtMS43NzIsOC44MTItMy41MDksMTcuOC00LjI1OSwyNy4wNDJjLTAuNTIyLDMuMzUyLTAuNzcyLDYuNzMzLTEuMDg2LDEwLjEzN2M3My40MzYsMC4wMTIsMTMwLjI3NCwwLjA1OCwyMDkuODA1LDAuMDU4ICAgIGMwLjI2Ny0zLjQ4NiwwLjQxOC03LjAxOCwwLjQxOC0xMC41NjdjMC02Ni45ODEtNDguODExLTEyMi4xNDctMTExLjYyMS0xMjkuNDU1YzQuMDU1LTMuNzkzLDYuNjIzLTkuMTczLDYuNjIzLTE1LjE1NyAgICBjMC4wMjMtMTEuNTAyLTkuMjk1LTIwLjgwOS0yMC43NzQtMjAuODA5Yy0xMS40OTEsMC0yMC44Miw5LjMwNy0yMC44MiwyMC44MDljMCw1Ljk5NiwyLjU1NiwxMS4zNjMsNi42MjIsMTUuMTU3ICAgIGMtNjIuODA1LDcuMzA4LTExMS42MDMsNjIuNDc0LTExMS42MDMsMTI5LjQ1NWMwLDMuNTM4LDAuMTI3LDcuMDIzLDAuMzg5LDEwLjQ5OCAgICBDMTE0LjM2OSwxOTUuMjQ2LDEyMS44NTcsMTk1LjI0NiwxMjkuMTk0LDE5NS4yNDZ6IiBmaWxsPSIjYTBhNWFhIi8+PHJlY3QgeD0iODMuMzI5IiB5PSIyMDIuOTk1IiB3aWR0aD0iMjk3LjM5MiIgaGVpZ2h0PSIyNi4yMzYiIGZpbGw9IiNhMGE1YWEiLz48cGF0aCBkPSJNMjU4LjYzMSwyNDcuODU1Yy0xNS4xMTUsNy4zNDMtNjcuODE4LDI2LjM1MS02Ny44MTgsMjYuMzUxbC02Mi4yOTktMy45MDNjMCwwLDM1LjYzNS05LjkxMSw0OS40NDktMTMuMDEzICAgIGMxMy44MzgtMy4wOTEsNy44MTktMTguNjk0LDAuMTY4LTE4LjY5NGMtNy42NSwwLTc0LjMyNCwyLjc1My03NC4zMjQsMi43NTNMNTkuNTM0LDI1Ny4yOWwxMS43MTcsNzQuMTYyICAgIGMwLDAsOS4xMTUtMTUuNjA0LDE4LjIwNy0xNS42MDRjOS4xMjYsMCw4OC4xNzQsMi4xMDMsOTguOTA0LDBjMTAuNzM2LTIuMTI3LDc2LjEyNi00Ni44NTksODMuOTU3LTUyLjA3NiAgICBDMjgwLjExNSwyNTguNTc5LDI3My44MDUsMjQwLjUwMSwyNTguNjMxLDI0Ny44NTV6IiBmaWxsPSIjYTBhNWFhIi8+PHBvbHlnb24gcG9pbnRzPSIwLDI2NS4yNjEgMCwzNjEuMzk0IDY3LjgzLDM0OC42OTQgNTAuODYxLDI1Ni4zMTMgICAiIGZpbGw9IiNhMGE1YWEiLz48L2c+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjwvc3ZnPg==',
			) );

			/**
			 * ------------------------------------------------------------------------------------------
			 * Package post_type
			 * ------------------------------------------------------------------------------------------
			 */
			register_post_type( 'packages', array (
				'label'               => esc_html__( 'Packages', 'ravis-booking' ),
				'description'         => esc_html__( 'Manage Special offer packages.', 'ravis-booking' ),
				'public'              => true,
				'has_archive'         => true,
				'exclude_from_search' => true,
				'rewrite'             => array ( 'slug' => 'packages' ),
				'supports'            => array ( 'title', 'thumbnail' ),
				'menu_icon'           => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCA1MTIgNTEyIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1MTIgNTEyOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjUxMnB4IiBoZWlnaHQ9IjUxMnB4Ij48Zz48Zz48cGF0aCBkPSJNNDc4LjYwOSw5OS43MjZINDQxLjM0YzQuOTE2LTcuNzgsOC4xNi0xNi41MTMsOS4wODUtMjUuNzQ5QzQ1My4zOCw0NC40Niw0MzcuODM1LDE4LDQxMS4zNyw2LjI2OSAgICBjLTI0LjMyNi0xMC43ODMtNTEuNjYzLTYuMzc1LTcxLjM0OCwxMS40NzlsLTQ3LjA2LDQyLjY1Yy05LjE2NS0xMC4wMjQtMjIuMzQtMTYuMzI0LTM2Ljk2Mi0xNi4zMjQgICAgYy0xNC42NDgsMC0yNy44NDQsNi4zMi0zNy4wMTEsMTYuMzc1bC00Ny4xMi00Mi43MDZDMTUyLjE1Mi0wLjExMSwxMjQuODI2LTQuNTAyLDEwMC41MTEsNi4yNzUgICAgQzc0LjA1MywxOC4wMDcsNTguNTA1LDQ0LjQ3Niw2MS40NjksNzMuOTkyYzAuOTI3LDkuMjI5LDQuMTY5LDE3Ljk1OCw5LjA4NCwyNS43MzRIMzMuMzkxQzE0Ljk0OSw5OS43MjYsMCwxMTQuNjc2LDAsMTMzLjExNyAgICB2NTAuMDg3YzAsOS4yMiw3LjQ3NSwxNi42OTYsMTYuNjk2LDE2LjY5Nmg0NzguNjA5YzkuMjIsMCwxNi42OTYtNy40NzUsMTYuNjk2LTE2LjY5NnYtNTAuMDg3ICAgIEM1MTIsMTE0LjY3Niw0OTcuMDUxLDk5LjcyNiw0NzguNjA5LDk5LjcyNnogTTIwNS45MTMsOTQuMTYxdjUuNTY1SDEyNy4zN2MtMjAuNzUyLDAtMzcuMDg0LTE5LjM0Ni0zMS45MDEtNDAuOTUyICAgIGMyLjI4My05LjUxNSw5LjE1MS0xNy42MjYsMTguMDM0LTIxLjczMmMxMi4xOTgtNS42MzgsMjUuNzEtMy44MjgsMzUuOTU1LDUuNDQ1bDU2LjQ2OSw1MS4xODIgICAgQzIwNS45MjQsOTMuODM0LDIwNS45MTMsOTMuOTk2LDIwNS45MTMsOTQuMTYxeiBNNDE3LjI5NCw2OS41NDRjLTEuMjQ0LDE3LjM1My0xNi45MTksMzAuMTg0LTM0LjMxNiwzMC4xODRoLTc2Ljg5MXYtNS41NjUgICAgYzAtMC4xOTctMC4wMTItMC4zOTItMC4wMTQtMC41ODljMTIuNzkyLTExLjU5Niw0MC41NDMtMzYuNzQ4LDU1LjU5NC01MC4zOTFjOC41NTQtNy43NTMsMjAuNTIzLTExLjM3MiwzMS41ODctOC4wNzIgICAgQzQwOS4xMzEsMzkuODQ3LDQxOC40NTUsNTMuMzQ5LDQxNy4yOTQsNjkuNTQ0eiIgZmlsbD0iI2EwYTVhYSIvPjwvZz48L2c+PGc+PGc+PHBhdGggZD0iTTMzLjM5MSwyMzMuMjkxdjI0NC44N2MwLDE4LjQ0MiwxNC45NDksMzMuMzkxLDMzLjM5MSwzMy4zOTFoMTU1LjgyNlYyMzMuMjkxSDMzLjM5MXoiIGZpbGw9IiNhMGE1YWEiLz48L2c+PC9nPjxnPjxnPjxwYXRoIGQ9Ik0yODkuMzkxLDIzMy4yOTF2Mjc4LjI2MWgxNTUuODI2YzE4LjQ0MiwwLDMzLjM5MS0xNC45NDksMzMuMzkxLTMzLjM5MXYtMjQ0Ljg3SDI4OS4zOTF6IiBmaWxsPSIjYTBhNWFhIi8+PC9nPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48L3N2Zz4=',
			) );

			/**
			 * ------------------------------------------------------------------------------------------
			 * Event post_type
			 * ------------------------------------------------------------------------------------------
			 */
			register_post_type( 'events', array (
				'label'               => esc_html__( 'Events', 'ravis-booking' ),
				'description'         => esc_html__( 'Manage the events which are happening in the Hotel.', 'ravis-booking' ),
				'exclude_from_search' => true,
				'public'              => true,
				'has_archive'         => true,
				'rewrite'             => array ( 'slug' => 'events' ),
				'supports'            => array ( 'title', 'editor' ),
				'menu_icon'           => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/PjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHg9IjBweCIgeT0iMHB4IiB3aWR0aD0iNTEycHgiIGhlaWdodD0iNTEycHgiIHZpZXdCb3g9IjAgMCAyOTguMzE0IDI5OC4zMTMiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDI5OC4zMTQgMjk4LjMxMzsiIHhtbDpzcGFjZT0icHJlc2VydmUiPjxnPjxnIGlkPSJfeDMyXzIyLl9DYWxlbmRlciI+PGc+PHBhdGggZD0iTTE3Mi43MDgsMTU2Ljk5OUwxNzIuNzA4LDE1Ni45OTljLTguNjgxLDAtMTUuNzAxLDcuMDI5LTE1LjcwMSwxNS43MDljMCw4LjY2NCw3LjAzNywxNS43MDEsMTUuNzAxLDE1LjcwMWwwLDAgICAgIGM4LjY2NCwwLDE1LjcwMS03LjAzNywxNS43MDEtMTUuNzAxQzE4OC40MSwxNjQuMDI4LDE4MS4zODgsMTU2Ljk5OSwxNzIuNzA4LDE1Ni45OTl6IE0xMjUuNjA1LDE0MS4zMDYgICAgIGM4LjY2OCwwLDE1LjcwMS03LjAzMywxNS43MDEtMTUuNzAxYzAtOC42NzQtNy4wMzMtMTUuNjk5LTE1LjcwMS0xNS42OTljLTguNjY2LDAtMTUuNjk5LDcuMDI1LTE1LjY5OSwxNS42OTkgICAgIEMxMDkuOTA2LDEzNC4yNzMsMTE2LjkzOSwxNDEuMzA2LDEyNS42MDUsMTQxLjMwNnogTTE3Mi43MDgsMTA5LjkwNkwxNzIuNzA4LDEwOS45MDZjLTguNjgxLDAtMTUuNzAxLDcuMDI1LTE1LjcwMSwxNS42OTkgICAgIGMwLDguNjY4LDcuMDIxLDE1LjcwMSwxNS43MDEsMTUuNzAxbDAsMGM4LjY2NCwwLDE1LjcwMS03LjAzMywxNS43MDEtMTUuNzAxQzE4OC40MSwxMTYuOTMxLDE4MS4zODgsMTA5LjkwNiwxNzIuNzA4LDEwOS45MDZ6ICAgICAgTTE4OC40MSwzMS40aC03OC41MDR2MzEuNDAyaDc4LjUwNFYzMS40eiBNMjE5LjgxMiwxNDEuMzA2YzguNjYsMCwxNS43MDEtNy4wMzMsMTUuNzAxLTE1LjcwMSAgICAgYzAtOC42NzQtNy4wMjUtMTUuNjk5LTE1LjcwMS0xNS42OTljLTguNjgxLDAtMTUuNzAxLDcuMDI1LTE1LjcwMSwxNS42OTlDMjA0LjExMSwxMzQuMjczLDIxMS4xNDgsMTQxLjMwNiwyMTkuODEyLDE0MS4zMDZ6ICAgICAgTTIxOS44MTIsMTg4LjQwOWM4LjY2LDAsMTUuNzAxLTcuMDM3LDE1LjcwMS0xNS43MDFjMC04LjY4LTcuMDI1LTE1LjcwMS0xNS43MDEtMTUuNzAxYy04LjY4MSwwLTE1LjcwMSw3LjAyMS0xNS43MDEsMTUuNzAxICAgICBDMjA0LjExMSwxODEuMzcyLDIxMS4xNDgsMTg4LjQwOSwyMTkuODEyLDE4OC40MDl6IE0xMjUuNjA1LDE4OC40MDljOC42NjgsMCwxNS43MDEtNy4wMzcsMTUuNzAxLTE1LjcwMSAgICAgYzAtOC42OC03LjAyNS0xNS43MDktMTUuNzAxLTE1LjcwOWMtOC42NzQsMC0xNS42OTksNy4wMjktMTUuNjk5LDE1LjcwOUMxMDkuOTA2LDE4MS4zNzIsMTE2LjkzOSwxODguNDA5LDEyNS42MDUsMTg4LjQwOXogICAgICBNNzguNTA0LDIzNS41MTNjOC42NjYsMCwxNS43MDEtNy4wNDEsMTUuNzAxLTE1LjcwMWMwLTguNjgtNy4wMzUtMTUuNzAxLTE1LjcwMS0xNS43MDFjLTguNjc0LDAtMTUuNzAxLDcuMDIxLTE1LjcwMSwxNS43MDEgICAgIEM2Mi44MDMsMjI4LjQ3Miw2OS44MzcsMjM1LjUxMyw3OC41MDQsMjM1LjUxM3ogTTI2Ni45MTEsMzEuNGgtMTUuNjk2djMxLjQwMmgxNS42OTZ2MjA0LjEwOEgzMS40MDJWNjIuODAzaDE1LjY5OVYzMS40SDMxLjQwMiAgICAgQzE0LjA2LDMxLjQsMCw0NS40NTUsMCw2Mi44MDN2MjA0LjEwMWMwLDE3LjM1MiwxNC4wNiwzMS40MSwzMS40MDIsMzEuNDFoMjM1LjUwOGMxNy4zNDUsMCwzMS40MDItMTQuMDU5LDMxLjQwMi0zMS40MVY2Mi44MDMgICAgIEMyOTguMzEzLDQ1LjQ1NSwyODQuMjU1LDMxLjQsMjY2LjkxMSwzMS40eiBNNzguNTA0LDE4OC40MDljOC42NjYsMCwxNS43MDEtNy4wMzcsMTUuNzAxLTE1LjcwMSAgICAgYzAtOC42OC03LjAzNS0xNS43MDktMTUuNzAxLTE1LjcwOWMtOC42NzQsMC0xNS43MDEsNy4wMjktMTUuNzAxLDE1LjcwOUM2Mi44MDMsMTgxLjM3Miw2OS44MzcsMTg4LjQwOSw3OC41MDQsMTg4LjQwOXogICAgICBNNzguNTA0LDE0MS4zMDZjOC42NjYsMCwxNS43MDEtNy4wMzMsMTUuNzAxLTE1LjcwMWMwLTguNjc0LTcuMDM1LTE1LjY5OS0xNS43MDEtMTUuNjk5Yy04LjY3NCwwLTE1LjcwMSw3LjAyNS0xNS43MDEsMTUuNjk5ICAgICBDNjIuODAzLDEzNC4yNzMsNjkuODM3LDE0MS4zMDYsNzguNTA0LDE0MS4zMDZ6IE0xMjUuNjA1LDIzNS41MTNjOC42NjgsMCwxNS43MDEtNy4wNDEsMTUuNzAxLTE1LjcwMSAgICAgYzAtOC42OC03LjAzMy0xNS43MDEtMTUuNzAxLTE1LjcwMWMtOC42NjYsMC0xNS42OTksNy4wMjEtMTUuNjk5LDE1LjcwMUMxMDkuOTA2LDIyOC40NzIsMTE2LjkzOSwyMzUuNTEzLDEyNS42MDUsMjM1LjUxM3ogICAgICBNNzguNTA0LDYyLjgwM2M4LjY2NiwwLDE1LjcwMS03LjAzMywxNS43MDEtMTUuNzAxdi0zMS40Qzk0LjIwNSw3LjAyNSw4Ny4xNzgsMCw3OC41MDQsMGMtOC42NjcsMC0xNS43MDEsNy4wMjUtMTUuNzAxLDE1LjcwMSAgICAgdjMxLjRDNjIuODAzLDU1Ljc3LDY5LjgzNyw2Mi44MDMsNzguNTA0LDYyLjgwM3ogTTIxOS44MTIsNjIuODAzYzguNjYsMCwxNS43MDEtNy4wMzMsMTUuNzAxLTE1LjcwMXYtMzEuNCAgICAgQzIzNS41MTMsNy4wMjUsMjI4LjQ3MiwwLDIxOS44MTIsMGMtOC42ODEsMC0xNS43MDEsNy4wMjUtMTUuNzAxLDE1LjcwMXYzMS40QzIwNC4xMTEsNTUuNzcsMjExLjE0OCw2Mi44MDMsMjE5LjgxMiw2Mi44MDN6IiBmaWxsPSIjYTBhNWFhIi8+PC9nPjwvZz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PC9zdmc+',
			) );

			/**
			 * ------------------------------------------------------------------------------------------
			 * Staff post_type
			 * ------------------------------------------------------------------------------------------
			 */
			register_post_type( 'staff', array (
				'label'               => esc_html__( 'Staff', 'ravis-booking' ),
				'description'         => esc_html__( 'Manage the staff of hotel.', 'ravis-booking' ),
				'public'              => true,
				'has_archive'         => true,
				'exclude_from_search' => true,
				'rewrite'             => array ( 'slug' => 'staff' ),
				'supports'            => array ( 'title', 'editor', 'thumbnail' ),
				'menu_icon'           => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/PjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHg9IjBweCIgeT0iMHB4IiB3aWR0aD0iNTEycHgiIGhlaWdodD0iNTEycHgiIHZpZXdCb3g9IjAgMCA4MC4xMyA4MC4xMyIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgODAuMTMgODAuMTM7IiB4bWw6c3BhY2U9InByZXNlcnZlIj48Zz48cGF0aCBkPSJNNDguMzU1LDE3LjkyMmMzLjcwNSwyLjMyMyw2LjMwMyw2LjI1NCw2Ljc3NiwxMC44MTdjMS41MTEsMC43MDYsMy4xODgsMS4xMTIsNC45NjYsMS4xMTIgICBjNi40OTEsMCwxMS43NTItNS4yNjEsMTEuNzUyLTExLjc1MWMwLTYuNDkxLTUuMjYxLTExLjc1Mi0xMS43NTItMTEuNzUyQzUzLjY2OCw2LjM1LDQ4LjQ1MywxMS41MTcsNDguMzU1LDE3LjkyMnogTTQwLjY1Niw0MS45ODQgICBjNi40OTEsMCwxMS43NTItNS4yNjIsMTEuNzUyLTExLjc1MnMtNS4yNjItMTEuNzUxLTExLjc1Mi0xMS43NTFjLTYuNDksMC0xMS43NTQsNS4yNjItMTEuNzU0LDExLjc1MlMzNC4xNjYsNDEuOTg0LDQwLjY1Niw0MS45ODQgICB6IE00NS42NDEsNDIuNzg1aC05Ljk3MmMtOC4yOTcsMC0xNS4wNDcsNi43NTEtMTUuMDQ3LDE1LjA0OHYxMi4xOTVsMC4wMzEsMC4xOTFsMC44NCwwLjI2MyAgIGM3LjkxOCwyLjQ3NCwxNC43OTcsMy4yOTksMjAuNDU5LDMuMjk5YzExLjA1OSwwLDE3LjQ2OS0zLjE1MywxNy44NjQtMy4zNTRsMC43ODUtMC4zOTdoMC4wODRWNTcuODMzICAgQzYwLjY4OCw0OS41MzYsNTMuOTM4LDQyLjc4NSw0NS42NDEsNDIuNzg1eiBNNjUuMDg0LDMwLjY1M2gtOS44OTVjLTAuMTA3LDMuOTU5LTEuNzk3LDcuNTI0LTQuNDcsMTAuMDg4ICAgYzcuMzc1LDIuMTkzLDEyLjc3MSw5LjAzMiwxMi43NzEsMTcuMTF2My43NThjOS43Ny0wLjM1OCwxNS40LTMuMTI3LDE1Ljc3MS0zLjMxM2wwLjc4NS0wLjM5OGgwLjA4NFY0NS42OTkgICBDODAuMTMsMzcuNDAzLDczLjM4LDMwLjY1Myw2NS4wODQsMzAuNjUzeiBNMjAuMDM1LDI5Ljg1M2MyLjI5OSwwLDQuNDM4LTAuNjcxLDYuMjUtMS44MTRjMC41NzYtMy43NTcsMi41OS03LjA0LDUuNDY3LTkuMjc2ICAgYzAuMDEyLTAuMjIsMC4wMzMtMC40MzgsMC4wMzMtMC42NmMwLTYuNDkxLTUuMjYyLTExLjc1Mi0xMS43NS0xMS43NTJjLTYuNDkyLDAtMTEuNzUyLDUuMjYxLTExLjc1MiwxMS43NTIgICBDOC4yODMsMjQuNTkxLDEzLjU0MywyOS44NTMsMjAuMDM1LDI5Ljg1M3ogTTMwLjU4OSw0MC43NDFjLTIuNjYtMi41NTEtNC4zNDQtNi4wOTctNC40NjctMTAuMDMyICAgYy0wLjM2Ny0wLjAyNy0wLjczLTAuMDU2LTEuMTA0LTAuMDU2aC05Ljk3MUM2Ljc1LDMwLjY1MywwLDM3LjQwMywwLDQ1LjY5OXYxMi4xOTdsMC4wMzEsMC4xODhsMC44NCwwLjI2NSAgIGM2LjM1MiwxLjk4MywxMi4wMjEsMi44OTcsMTYuOTQ1LDMuMTg1di0zLjY4M0MxNy44MTgsNDkuNzczLDIzLjIxMiw0Mi45MzYsMzAuNTg5LDQwLjc0MXoiIGZpbGw9IiNhMGE1YWEiLz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PC9zdmc+',
			) );

			/**
			 * ------------------------------------------------------------------------------------------
			 * Testimonials post_type
			 * ------------------------------------------------------------------------------------------
			 */
			register_post_type( 'testimonials', array (
				'label'               => esc_html__( 'Testimonials', 'ravis-booking' ),
				'description'         => esc_html__( 'Manage the testimonials which is given by hotel\'s guests.', 'ravis-booking' ),
				'exclude_from_search' => true,
				'public'              => true,
				'has_archive'         => true,
				'rewrite'             => array ( 'slug' => 'testimonials' ),
				'supports'            => array ( 'title', 'editor' ),
				'menu_icon'           => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDI1LjYyNSAyNS42MjUiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDI1LjYyNSAyNS42MjU7IiB4bWw6c3BhY2U9InByZXNlcnZlIiB3aWR0aD0iNTEycHgiIGhlaWdodD0iNTEycHgiPjxnPjxwYXRoIGQ9Ik0xMi44MTIsMC40MzVDNS43MzYsMC40MzUsMCw1LjQ5OSwwLDExLjc0N2MwLDMuMTY4LDEuNDc5LDYuMDI4LDMuODU1LDguMDgyICAgYy0wLjUyMSwzLjAxLTMuODgzLDQuMjMtMy42NTIsNS4wNTljMi44NCwxLjE3NSw4LjUyOS0xLjQxMiw5LjkxOC0yLjA4M2MwLjg2OSwwLjE2NCwxLjc2OCwwLjI1NSwyLjY5MSwwLjI1NSAgIGM3LjA3NiwwLDEyLjgxMy01LjA2NCwxMi44MTMtMTEuMzEzUzE5Ljg4OCwwLjQzNSwxMi44MTIsMC40MzV6IE0xMS45MDQsMTIuMjE4YzAsMy4wNzYtMS4zNjEsNC44MDItNC4wNDMsNS4xMjkgICBjLTAuMDA2LDAuMDAxLTAuMDEsMC4wMDEtMC4wMTYsMC4wMDFjLTAuMDI5LDAtMC4wNjEtMC4wMTEtMC4wODItMC4wMzFjLTAuMDI3LTAuMDIzLTAuMDQzLTAuMDU4LTAuMDQzLTAuMDk0VjE1LjY2ICAgYzAtMC4wNDYsMC4wMjUtMC4wODgsMC4wNjQtMC4xMDljMS4yMjMtMC42NjcsMS44MzQtMS43MTcsMS44NjUtMy4yMDdINy44NDVjLTAuMDY4LDAtMC4xMjUtMC4wNTYtMC4xMjUtMC4xMjVWOC4yODYgICBjMC0wLjA2OSwwLjA1Ny0wLjEyNSwwLjEyNS0wLjEyNWgzLjkzNGMwLjA2OCwwLDAuMTI1LDAuMDU2LDAuMTI1LDAuMTI1VjEyLjIxOHogTTE4Ljg2OSwxMi4yMThjMCwzLjAyOS0xLjIwNSw0LjU2My00LjAzMyw1LjEyOCAgIGMtMC4wMDgsMC4wMDEtMC4wMTYsMC4wMDItMC4wMjQsMC4wMDJjLTAuMDI5LDAtMC4wNTctMC4wMS0wLjA4LTAuMDI4Yy0wLjAyOS0wLjAyMy0wLjA0NS0wLjA2LTAuMDQ1LTAuMDk3VjE1LjY2ICAgYzAtMC4wNDYsMC4wMjUtMC4wODgsMC4wNjQtMC4xMDljMS4yMjMtMC42NjcsMS44MzQtMS43MTcsMS44NjUtMy4yMDdoLTEuODA0Yy0wLjA2OCwwLTAuMTI1LTAuMDU2LTAuMTI1LTAuMTI1VjguMjg2ICAgYzAtMC4wNjksMC4wNTctMC4xMjUsMC4xMjUtMC4xMjVoMy45MzJjMC4wNywwLDAuMTI1LDAuMDU2LDAuMTI1LDAuMTI1VjEyLjIxOHoiIGZpbGw9IiNhMGE1YWEiLz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PC9zdmc+',
			) );

			/**
			 * ------------------------------------------------------------------------------------------
			 * TimeLine post_type
			 * ------------------------------------------------------------------------------------------
			 */
			register_post_type( 'timeline', array (
				'label'               => esc_html__( 'History Time Line', 'ravis-booking' ),
				'description'         => esc_html__( 'These events will be added to "[ravis-booking-timeline]" shortcodes that you can add it to any pages you want.', 'ravis-booking' ),
				'exclude_from_search' => true,
				'public'              => true,
				'has_archive'         => true,
				'rewrite'             => array ( 'slug' => 'timeline' ),
				'menu_icon'           => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDI0LjA3NyAyNC4wNzciIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDI0LjA3NyAyNC4wNzc7IiB4bWw6c3BhY2U9InByZXNlcnZlIiB3aWR0aD0iNTEycHgiIGhlaWdodD0iNTEycHgiPjxnPjxwYXRoIGQ9Ik0yLDYuNTc3djQuNDYxaDE2LjE4OWwxLjM5Ni0xLjM5NWMwLjQ0LTAuNDM5LDEuMTU4LTAuNDM5LDEuNTk3LDBsMS4zOTYsMS4zOTVoMS40OTl2MmgtMS41ICAgbC0xLjM5NCwxLjM5NGMtMC40NCwwLjQ0LTEuMTU4LDAuNDQtMS41OTcsMGwtMS4zOTUtMS4zOTRIMlYxNy41aDEuNDJsMS4zOTctMS4zOTZjMC40NC0wLjQzOSwxLjE1OC0wLjQzOSwxLjU5NywwTDcuODExLDE3LjUgICBoMTYuMjY2djJINy44MDhsLTEuMzk1LDEuMzk0Yy0wLjQzOSwwLjQ0LTEuMTU3LDAuNDQtMS41OTYsMEwzLjQyMiwxOS41SDJ2NC41MzhIMC4wNzdIMHYtMjRoMC4wNzdIMnY0LjUzOWg2Ljk1OGwxLjM5Ni0xLjM5NiAgIGMwLjQ0LTAuNDM5LDEuMTU4LTAuNDM5LDEuNTk3LDBsMS4zOTcsMS4zOTZoMTAuNzI5djJoLTEwLjczbC0xLjM5NSwxLjM5NGMtMC40MzksMC40NC0xLjE1NywwLjQ0LTEuNTk2LDBMOC45Niw2LjU3N0gyeiIgZmlsbD0iI2EwYTVhYSIvPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48L3N2Zz4=',
			) );

			/**
			 * ------------------------------------------------------------------------------------------
			 * Dishes post_type
			 * ------------------------------------------------------------------------------------------
			 */
			register_post_type( 'dish', array (
				'label'               => esc_html__( 'Dishes', 'ravis-booking' ),
				'description'         => esc_html__( 'You can manage the dishes of your restaurant in this section.', 'ravis-booking' ),
				'exclude_from_search' => true,
				'public'              => true,
				'has_archive'         => true,
				'rewrite'             => array ( 'slug' => 'dish' ),
				'supports'            => array ( 'title', 'editor', 'thumbnail' ),
				'menu_icon'           => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCA1MTIgNTEyIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1MTIgNTEyOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjUxMnB4IiBoZWlnaHQ9IjUxMnB4Ij48Zz48Zz48cGF0aCBkPSJNMzI0LjgsMTg0LjA1MWMtMzkuNjczLDAtNzEuOTQ5LDMyLjI3Ni03MS45NDksNzEuOTQ5YzAsMzkuNjczLDMyLjI3Nyw3MS45NDksNzEuOTQ5LDcxLjk0OSAgICBjMzkuNjcyLDAsNzEuOTQ5LTMyLjI3Niw3MS45NDktNzEuOTQ5UzM2NC40NzMsMTg0LjA1MSwzMjQuOCwxODQuMDUxeiIgZmlsbD0iI2EwYTVhYSIvPjwvZz48L2c+PGc+PGc+PHBhdGggZD0iTTMyNC44LDY4LjhjLTEwMy4yMjIsMC0xODcuMiw4My45NzgtMTg3LjIsMTg3LjJzODMuOTc4LDE4Ny4yLDE4Ny4yLDE4Ny4yUzUxMiwzNTkuMjIzLDUxMiwyNTZTNDI4LjAyMiw2OC44LDMyNC44LDY4Ljh6ICAgICBNMzI0LjgsMzYzLjk4MmMtNTkuNTQxLDAtMTA3Ljk4MS00OC40NC0xMDcuOTgxLTEwNy45ODFTMjY1LjI2LDE0OC4wMiwzMjQuOCwxNDguMDJjNTkuNTQsMCwxMDcuOTgxLDQ4LjQ0LDEwNy45ODEsMTA3Ljk4MSAgICBTMzg0LjM0MSwzNjMuOTgyLDMyNC44LDM2My45ODJ6IiBmaWxsPSIjYTBhNWFhIi8+PC9nPjwvZz48Zz48Zz48cGF0aCBkPSJNMTEwLjQ5MSw2OC44Yy05Ljk1LDAtMTguMDE2LDguMDY2LTE4LjAxNiwxOC4wMTZ2OTYuMTYxSDgxLjk1OFY4Ni44MTVjMC05Ljk1LTguMDY2LTE4LjAxNi0xOC4wMTYtMTguMDE2ICAgIGMtOS45NSwwLTE4LjAxNiw4LjA2Ni0xOC4wMTYsMTguMDE2djk2LjE2MWgtOS44OTRWODYuODE1YzAtOS45NS04LjA2Ni0xOC4wMTYtMTguMDE2LTE4LjAxNlMwLDc2Ljg2NiwwLDg2LjgxNXY5OS43NjUgICAgYzAsMTcuODgxLDE0LjU0NywzMi40MjksMzIuNDI5LDMyLjQyOWgxMi4yOTZ2MjA2LjE3NmMwLDkuOTUsOC4wNjYsMTguMDE2LDE4LjAxNiwxOC4wMTZzMTguMDE2LTguMDY2LDE4LjAxNi0xOC4wMTZWMjE5LjAxICAgIGgxNS4zMjJjMTcuODgxLDAsMzIuNDI5LTE0LjU0NywzMi40MjktMzIuNDI5Vjg2LjgxNUMxMjguNTA3LDc2Ljg2NiwxMjAuNDQxLDY4LjgsMTEwLjQ5MSw2OC44eiIgZmlsbD0iI2EwYTVhYSIvPjwvZz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PC9zdmc+',
			) );

			/**
			 * ------------------------------------------------------------------------------------------
			 * Menu post_type
			 * ------------------------------------------------------------------------------------------
			 */
			register_post_type( 'menu', array (
				'label'               => esc_html__( 'Menu', 'ravis-booking' ),
				'description'         => esc_html__( 'You can manage menu of your restaurant in this section.', 'ravis-booking' ),
				'exclude_from_search' => true,
				'public'              => true,
				'has_archive'         => true,
				'rewrite'             => array ( 'slug' => 'menu' ),
				'supports'            => array ( 'title', 'thumbnail' ),
				'menu_icon'           => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDQ4OS41IDQ4OS41IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA0ODkuNSA0ODkuNTsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI1MTJweCIgaGVpZ2h0PSI1MTJweCI+PGc+PGc+PHBhdGggZD0iTTY0LjMsMHY0ODkuNWgzNjAuOVYwSDY0LjN6IE0zMzQsNTEuNmMzLjUsMCw2LjQsMi45LDYuNCw2LjR2MjYuNmMwLDkuNiw0LjgsMTUuNSwxMi40LDE1LjVjNywwLDEyLjQtNC42LDEyLjQtMTUuNVY1OCAgICBjMC0zLjUsMi45LTYuNCw2LjQtNi40aDAuNGMzLjUsMCw2LjQsMi45LDYuNCw2LjR2MjdjMCwxNy45LTEyLjksMjYuOC0yNS4zLDI2LjhjLTEyLjYsMC0yNS42LTUuNy0yNS42LTI2LjhWNTggICAgQzMyNy42LDU0LjUsMzMwLjUsNTEuNiwzMzQsNTEuNkwzMzQsNTEuNnogTTI2NS4xLDUxLjZjMCwwLDQuMy0wLjksNy44LDIuNkwzMDAuMSw5MFY1OC4yYzAtMy42LDMtNi42LDYuNi02LjZsMCwwICAgIGMzLjYsMCw2LjYsMyw2LjYsNi42djQ2LjZjMCwzLjYtMyw2LjYtNi42LDYuNmMwLDAtNSwxLTguNi0yLjZsLTI2LjQtMzV2MzAuN2MwLDMuNi0zLDYuNi02LjYsNi42bDAsMGMtMy42LDAtNi42LTMtNi42LTYuNlY1OC4yICAgIEMyNTguNSw1NC42LDI2MS40LDUxLjYsMjY1LjEsNTEuNnogTTE3Myw0MzguOWgtNTUuMnYtNTUuMkgxNzNWNDM4Ljl6IE0xNzMsMzMxLjNoLTU1LjJ2LTU1LjJIMTczVjMzMS4zeiBNMTczLDIyMy43aC01NS4ydi01NS4yICAgIEgxNzNWMjIzLjd6IE0xODEuMiwxMTEuNUwxODEuMiwxMTEuNWMtMy42LDAtNi42LTMtNi42LTYuNlY3My44TDE2MCwxMDNjLTEuMSwyLjEtMy4yLDMuNS01LjYsMy41bDAsMGMtMi40LDAtNC42LTEuMy01LjYtMy41ICAgIGwtMTQuNi0yOS4ydjMxLjFjMCwzLjYtMyw2LjYtNi42LDYuNmwwLDBjLTMuNiwwLTYuNi0zLTYuNi02LjZWNjIuNmMwLTYsNC45LTExLDExLTExbDAsMGM0LjIsMCw4LjEsMi40LDkuOSw2LjJsMTIuNiwyNi40ICAgIGwxMi42LTI2LjRjMS44LTMuOCw1LjctNi4yLDkuOS02LjJsMCwwYzYsMCwxMSw0LjksMTEsMTF2NDIuM0MxODcuOCwxMDguNSwxODQuOCwxMTEuNSwxODEuMiwxMTEuNXogTTIwOS4yLDUxLjZoMzAuNSAgICBjMy4zLDAsNiwyLjcsNiw2bDAsMGMwLDMuMy0yLjcsNi02LDZoLTIzLjlWNzZIMjM3YzMuMSwwLDUuNiwyLjUsNS42LDUuNmwwLDBjMCwzLjEtMi41LDUuNi01LjYsNS42aC0yMS4ydjEyLjRoMjQuOSAgICBjMy4yLDAsNS44LDIuNiw1LjgsNS44bDAsMGMwLDMuMi0yLjYsNS44LTUuOCw1LjhoLTMxLjVjLTMuNiwwLTYuNi0zLTYuNi02LjZWNTguMkMyMDIuNiw1NC42LDIwNS41LDUxLjYsMjA5LjIsNTEuNnogICAgIE0zNzEuOSw0MTkuMWgtMTUwYy00LjMsMC03LjgtMy41LTcuOC03LjhzMy41LTcuOCw3LjgtNy44aDE1MGM0LjMsMCw3LjgsMy41LDcuOCw3LjhTMzc2LjIsNDE5LjEsMzcxLjksNDE5LjF6IE0zNzEuOSwzMTEuNSAgICBoLTE1MGMtNC4zLDAtNy44LTMuNS03LjgtNy44czMuNS03LjgsNy44LTcuOGgxNTBjNC4zLDAsNy44LDMuNSw3LjgsNy44UzM3Ni4yLDMxMS41LDM3MS45LDMxMS41eiBNMzcxLjksMjA0LjNoLTE1MCAgICBjLTQuMywwLTcuOC0zLjUtNy44LTcuOHMzLjUtNy44LDcuOC03LjhoMTUwYzQuMywwLDcuOCwzLjUsNy44LDcuOFMzNzYuMiwyMDQuMywzNzEuOSwyMDQuM3oiIGZpbGw9IiNhMGE1YWEiLz48L2c+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjwvc3ZnPg==',
			) );

			/**
			 * ------------------------------------------------------------------------------------------
			 * Coupon post_type
			 * ------------------------------------------------------------------------------------------
			 */
			register_post_type( 'coupon', array (
				'label'               => esc_html__( 'Coupon', 'ravis-booking' ),
				'description'         => esc_html__( 'You can manage coupon in this section.', 'ravis-booking' ),
				'exclude_from_search' => true,
				'public'              => true,
				'has_archive'         => true,
				'rewrite'             => array ( 'slug' => 'coupon' ),
				'supports'            => array ( 'title', 'thumbnail' ),
				'menu_icon'           => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDUxMiA1MTIiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDUxMiA1MTI7IiB4bWw6c3BhY2U9InByZXNlcnZlIiB3aWR0aD0iMjU2cHgiIGhlaWdodD0iMjU2cHgiPgo8Zz4KCTxnPgoJCTxwYXRoIGQ9Ik00OTcuMjMxLDIxMS42OTJjOC4xNTcsMCwxNC43NjktNi42MTMsMTQuNzY5LTE0Ljc2OXYtNzguNzY5YzAtOC4xNTctNi42MTMtMTQuNzY5LTE0Ljc2OS0xNC43NjlIMTcyLjMwOHY3My44NDYgICAgYzAsOC4xNTctNi42MTMsMTQuNzY5LTE0Ljc2OSwxNC43NjlzLTE0Ljc2OS02LjYxMy0xNC43NjktMTQuNzY5di03My44NDZoLTEyOEM2LjYxMywxMDMuMzg1LDAsMTA5Ljk5NywwLDExOC4xNTR2NzguNzY5ICAgIGMwLDguMTU3LDYuNjEzLDE0Ljc2OSwxNC43NjksMTQuNzY5YzI0LjQzMSwwLDQ0LjMwOCwxOS44NzYsNDQuMzA4LDQ0LjMwOHMtMTkuODc2LDQ0LjMwOC00NC4zMDgsNDQuMzA4ICAgIEM2LjYxMywzMDAuMzA4LDAsMzA2LjkyLDAsMzE1LjA3N3Y3OC43NjljMCw4LjE1Nyw2LjYxMywxNC43NjksMTQuNzY5LDE0Ljc2OWgxMjh2LTczLjg0NmMwLTguMTU3LDYuNjEzLTE0Ljc2OSwxNC43NjktMTQuNzY5ICAgIHMxNC43NjksNi42MTMsMTQuNzY5LDE0Ljc2OXY3My44NDZoMzI0LjkyM2M4LjE1NywwLDE0Ljc2OS02LjYxMywxNC43NjktMTQuNzY5di03OC43NjljMC04LjE1Ny02LjYxMy0xNC43NjktMTQuNzY5LTE0Ljc2OSAgICBjLTI0LjQzMSwwLTQ0LjMwOC0xOS44NzYtNDQuMzA4LTQ0LjMwOFM0NzIuNzk5LDIxMS42OTIsNDk3LjIzMSwyMTEuNjkyeiBNMTcyLjMwOCwyNzUuNjkyYzAsOC4xNTctNi42MTMsMTQuNzY5LTE0Ljc2OSwxNC43NjkgICAgcy0xNC43NjktNi42MTMtMTQuNzY5LTE0Ljc2OXYtMzkuMzg1YzAtOC4xNTcsNi42MTMtMTQuNzY5LDE0Ljc2OS0xNC43NjlzMTQuNzY5LDYuNjEzLDE0Ljc2OSwxNC43NjlWMjc1LjY5MnoiIGZpbGw9IiNmMGY1ZmEiLz4KCTwvZz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K',
			) );
		}

		public static function ravis_booking_pagination( $input_query_variable = '' )
		{
			if ( ! empty( $input_query_variable ) )
			{
				$wp_query = $input_query_variable;
			}
			else
			{
				global $wp_query;
			}

			$wp_query->query_vars['paged'] > 1 ? $current = esc_html( $wp_query->query_vars['paged'] ) : $current = 1;

			if ( get_option( 'permalink_structure' ) != '' )
			{
				$format = 'page/%#%';
				$base   = get_pagenum_link( 1 ) . '%_%';
				$args   = false;
			}
			else
			{
				$format = ( ( ! empty( $_SERVER['QUERY_STRING'] ) && ! array_key_exists( 'paged', $_GET ) ) ? '&paged=%#%' : '?paged=%#%' );
				$base   = get_pagenum_link( 1 ) . '%_%';
				$args   = false;
			}

			$pagination = array (
				'base'               => $base,
				'format'             => $format,
				'total'              => $wp_query->max_num_pages,
				'current'            => $current,
				'prev_text'          => '<i class="fa fa-angle-left"></i>',
				'next_text'          => '<i class="fa fa-angle-right"></i>',
				'show_all'           => true,
				'type'               => 'list',
				'add_args'           => $args,
				'before_page_number' => '<span>',
				'after_page_number'  => '</span>',
			);

			$pagination_links = paginate_links( $pagination );

			if ( $pagination_links != null )
			{
				echo '<div class="pagination-box clearfix">';
				echo balancetags( $pagination_links );
				echo '</div>';
			}
		}

		public function ravis_booking_ajax_tinymce()
		{
			if ( current_user_can( 'edit_posts' ) or current_user_can( 'edit_pages' ) )
			{
				include_once RAVIS_BOOKING_INCLUDES . 'ravisButtons.php';
				die();
			}
			else
			{
				die( esc_html__( 'You are not allowed to be here', 'ravis-booking' ) );
			}
		}

		public function ravis_booking_add_buttons( $plugin_array )
		{
			$plugin_array['ravisButtons'] = RAVIS_BOOKING_JS_PATH . 'ravisButtons.min.js';

			return $plugin_array;
		}

		public function ravis_booking_register_buttons( $buttons )
		{
			array_push( $buttons, 'ravisShortcodes' );

			return $buttons;
		}

		public function ravis_booking_register_scripts( $hook )
		{
			wp_enqueue_style( 'custom-admin-style', RAVIS_BOOKING_CSS_PATH . 'admin.css' );
			wp_enqueue_style( 'jquery-ui-custom', RAVIS_BOOKING_CSS_PATH . 'jquery-ui.min.css' );

			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_enqueue_script( 'jquery-ui-tabs' );

			wp_enqueue_script( 'ravis-booking-admin-js', RAVIS_BOOKING_JS_PATH . 'admin.min.js', array ( 'jquery' ), RAVIS_BOOKING_VERSION, true );
			$admin_js_var_array = array (
				'ajaxurl'      => esc_url( admin_url( 'admin-ajax.php' ) ),
				'plg_base'     => RAVIS_BOOKING_BASE_URL,
				'delete_alert' => esc_html__( 'Are you sure you want to delete this item?', 'ravis-booking' ),
			);

			if ( defined( 'ICL_LANGUAGE_CODE' ) )
			{
				$admin_js_var_array['lang'] = ICL_LANGUAGE_CODE;
			}
			wp_localize_script( 'ravis-booking-admin-js', 'ravis_booking', $admin_js_var_array );
		}

		public function ravis_booking_register_scripts_front()
		{
			global $wp;
			$booking_process       = new Ravis_booking_booking_process();
			$currency_info_obj     = new Ravis_booking_currency();
			$currency_info         = $currency_info_obj->get_current_currency();
			$ravis_booking_options = get_option( 'ravis-booking-setting' );

			if ( $booking_process->is_booking() )
			{
				wp_enqueue_script( 'angularjs', RAVIS_BOOKING_JS_PATH . 'angular.min.js', array ( 'jquery' ), RAVIS_BOOKING_VERSION, true );
				wp_enqueue_script( 'angularjs-sanitize', RAVIS_BOOKING_JS_PATH . 'angular-sanitize.min.js', array ( 'angularjs' ), RAVIS_BOOKING_VERSION, true );
				wp_enqueue_script( 'angularjs-route', RAVIS_BOOKING_JS_PATH . 'angular-route.min.js', array ( 'angularjs' ), RAVIS_BOOKING_VERSION, true );

				require_once 'tpl/booking-steps/booking_variables.php';

				$ravis_booking_variables['asset_url'] = RAVIS_BOOKING_IMG_PATH;

				if ( defined( 'ICL_LANGUAGE_CODE' ) )
				{
					$ravis_booking_variables['lang'] = ICL_LANGUAGE_CODE;
					$condition_page_url              = ! empty( $ravis_booking_options['condition_url'][ ICL_LANGUAGE_CODE ] ) ? esc_url( $ravis_booking_options['condition_url'][ ICL_LANGUAGE_CODE ] ) : '#';
				}
				else
				{
					$condition_page_url = ! empty( $ravis_booking_options['condition_url'] ) ? esc_url( $ravis_booking_options['condition_url'] ) : '#';
				}

				if ( ! empty( $ravis_booking_options['room_base_price'] ) )
				{
					$ravis_booking_variables['room_base'] = true;
				}

				$theme_current_locale = 'en';

				if ( get_locale() !== 'en_US' )
				{
					if ( file_exists( COLOSSEUM_THEMEROOT . '/assets/js/locales/locales.php' ) )
					{
						require COLOSSEUM_THEMEROOT . '/assets/js/locales/locales.php';
					}

					isset( $theme_locales[ get_locale() ] ) ? $theme_current_locale = $theme_locales[ get_locale() ] : '';

					wp_enqueue_script( 'bootstrap-datepicker-locale-js', COLOSSEUM_JS_PATH . 'locales/' . $theme_current_locale . '.min.js', array (
						'jquery',
						'colosseum-helper-js',
					), get_bloginfo( 'version' ), true );
				}

				$ravis_booking_variables['datePickerLang'] = $theme_current_locale;

				/**
				 * ------------------------------------------------------------------------------------------
				 *  Paymill Codes
				 * ------------------------------------------------------------------------------------------
				 */

				if ( ! empty( $ravis_booking_options['paymill_booking'] ) )
				{
					wp_enqueue_script( 'paymill-js-code', '//bridge.paymill.com', '', RAVIS_BOOKING_VERSION, true );
				}

				/**
				 * ------------------------------------------------------------------------------------------
				 *  Stripe Codes
				 * ------------------------------------------------------------------------------------------
				 */

				if ( ! empty( $ravis_booking_options['stripe_booking'] ) )
				{
					wp_enqueue_script( 'stripe-js-code', '//js.stripe.com/v3/', '', RAVIS_BOOKING_VERSION, true );
				}

				wp_enqueue_script( 'ravis-booking-angular-app', RAVIS_BOOKING_JS_PATH . 'app.min.js', array ( 'angularjs' ), RAVIS_BOOKING_VERSION, true );

				if ( $_POST )
				{
					$package_id = ! empty( $_POST['package-id'] ) ? intval( $_POST['package-id'] ) : '';

					if ( ! empty( $package_id ) )
					{
						$ravis_booking_variables['package_id'] = $package_id;
					}
					else
					{
						$check_in        = ! empty( $_POST['start'] ) ? sanitize_text_field( $_POST['start'] ) : '';
						$check_out       = ! empty( $_POST['end'] ) ? sanitize_text_field( $_POST['end'] ) : '';
						$room_count      = ! empty( $_POST['room-count'] ) ? intval( $_POST['room-count'] ) : '';
						$rooms           = ! empty( $_POST['room'] ) ? $_POST['room'] : '';
						$date_diff       = strtotime( $check_out ) - strtotime( $check_in );
						$duration        = ( $date_diff / 86400 );
						$weekend_counter = 0;

						for ( $i = 0; $i < $duration; $i ++ )
						{
							$current_day = strtotime( $check_in ) + ( 86400 * $i );

							if ( date( 'N', $current_day ) >= 6 )
							{
								$weekend_counter ++;
							}
						}

						$ravis_booking_variables['booking_check_in']   = $check_in;
						$ravis_booking_variables['booking_check_out']  = $check_out;
						$ravis_booking_variables['booking_room_count'] = $room_count;
						$ravis_booking_variables['booking_rooms']      = $rooms;
						$ravis_booking_variables['booking_duration']   = $duration;
						$ravis_booking_variables['booking_weekends']   = $weekend_counter;
					}
				}

				$current_user_info                  = wp_get_current_user();
				$current_user_meta_info             = get_user_meta( $current_user_info->ID );
				$ravis_booking_variables['user_id'] = $current_user_info->ID;

				if ( ! empty( $current_user_meta_info['membership'] ) )
				{
					$ravis_booking_variables['user_membership'] = unserialize( $current_user_meta_info['membership'][0] );
				}

				$ravis_booking_variables['security']         = wp_create_nonce( 'ravis-booking-security-str' );
				$ravis_booking_variables['coupon_security']  = wp_create_nonce( 'coupon-security-item' );
				$ravis_booking_variables['currency_info']    = $currency_info;
				$currency_separator_val                      = ! empty( $ravis_booking_options['currency_separator'] ) ? intval( $ravis_booking_options['currency_separator'] ) : 1;
				$ravis_booking_variables['currency_decimal'] = ! empty( $ravis_booking_options['currency_decimal'] ) ? intval( $ravis_booking_options['currency_decimal'] ) : 2;
				$currency_decimal_separator_val              = ! empty( $ravis_booking_options['currency_decimal_separator'] ) ? intval( $ravis_booking_options['currency_decimal_separator'] ) : 1;

				switch ( $currency_separator_val )
				{
					case 1:
						$ravis_booking_variables['currency_separator'] = ',';
						break;
					case 2:
						$ravis_booking_variables['currency_separator'] = '.';
						break;
					case 3:
						$ravis_booking_variables['currency_separator'] = ' ';
						break;
				}

				switch ( $currency_decimal_separator_val )
				{
					case 1:
						$ravis_booking_variables['currency_decimal_separator'] = '.';
						break;
					case 2:
						$ravis_booking_variables['currency_decimal_separator'] = ',';
						break;
				}

				if ( is_user_logged_in() )
				{
					$ravis_booking_variables['current_user_info']['id']           = $current_user_info->ID;
					$ravis_booking_variables['current_user_info']['display_name'] = $current_user_info->display_name;
					$ravis_booking_variables['current_user_info']['user_login']   = $current_user_info->user_login;
					$ravis_booking_variables['current_user_info']['user_email']   = $current_user_info->user_email;
					$ravis_booking_variables['current_user_info']['nickname']     = $current_user_meta_info['nickname'][0];
					$ravis_booking_variables['current_user_info']['first_name']   = $current_user_meta_info['first_name'][0];
					$ravis_booking_variables['current_user_info']['last_name']    = $current_user_meta_info['last_name'][0];
					$ravis_booking_variables['current_user_info']['phone']        = $current_user_meta_info['phone'][0];
					$ravis_booking_variables['current_user_info']['address']      = $current_user_meta_info['address'][0];
				}

				$ravis_booking_variables['user_vat']               = ! empty( $ravis_booking_options['vat'] ) ? esc_html( $ravis_booking_options['vat'] ) : 0;
				$ravis_booking_variables['deposit_status']         = ! empty( $ravis_booking_options['deposit_status'] ) ? esc_html( $ravis_booking_options['deposit_status'] ) : '';
				$ravis_booking_variables['user_deposit']           = ! empty( $ravis_booking_options['deposit'] ) ? esc_html( $ravis_booking_options['deposit'] ) : 20;
				$ravis_booking_variables['email_booking']          = ! empty( $ravis_booking_options['email_booking'] ) ? esc_html( $ravis_booking_options['email_booking'] ) : '';
				$ravis_booking_variables['condition_text']         = sprintf( __( 'I have read and accept the <a href="%s">terms and conditions</a>', 'ravis-booking' ), esc_url( $condition_page_url ) );
				$ravis_booking_variables['paypal_booking']         = ! empty( $ravis_booking_options['paypal_booking'] ) ? esc_html( $ravis_booking_options['paypal_booking'] ) : '';
				$ravis_booking_variables['paymill_booking']        = ! empty( $ravis_booking_options['paymill_booking'] ) ? esc_html( $ravis_booking_options['paymill_booking'] ) : '';
				$ravis_booking_variables['stripe_booking']         = ! empty( $ravis_booking_options['stripe_booking'] ) ? esc_html( $ravis_booking_options['stripe_booking'] ) : '';
				$ravis_booking_variables['final_booking_title']    = ! empty( $ravis_booking_options['final_booking_title'] ) ? esc_html( $ravis_booking_options['final_booking_title'] ) : esc_html__( 'Reservation Complete', 'ravis-booking' );
				$ravis_booking_variables['final_booking_subtitle'] = ! empty( $ravis_booking_options['final_booking_subtitle'] ) ? esc_html( $ravis_booking_options['final_booking_subtitle'] ) : esc_html__( 'Details of your reservation request was sent to your email', 'ravis-booking' );
				$ravis_booking_variables['final_booking_desc']     = ! empty( $ravis_booking_options['final_booking_desc'] ) ? esc_html( $ravis_booking_options['final_booking_desc'] ) : sprintf( __( 'For more information you can contact us via <a href="%s">contact form</a> of website', 'ravis-booking' ), ! empty( $ravis_booking_options['contact_url'] ) ? esc_url( $ravis_booking_options['contact_url'] ) : '#' );

				// Enable Services in Booking Process
				$services_args  = array (
					'post_type'      => 'service',
					'post_status'    => 'publish',
					'order'          => 'DESC',
					'orderby'        => 'date',
					'posts_per_page' => - 1,
					'meta_query'     => array (
						array (
							'key'   => 'ravis_booking_service_booking',
							'value' => 'on',
						),
					),
				);
				$services_query = new WP_Query( $services_args );

				if ( $services_query->have_posts() )
				{
					$ravis_booking_variables['booking_service'] = true;
				}

				wp_localize_script( 'ravis-booking-angular-app', 'booking_app', $ravis_booking_variables );
				wp_reset_postdata();
			}

			wp_enqueue_script( 'ravis-booking-front-js', RAVIS_BOOKING_JS_PATH . 'front.min.js', array ( 'jquery' ), RAVIS_BOOKING_VERSION, true );
			wp_localize_script( 'ravis-booking-front-js', 'ravis_booking_front', array (
				'ajaxurl'     => esc_url( admin_url( 'admin-ajax.php' ) ),
				'redirecturl' => esc_url( home_url( $wp->request ) ),
				'plg_base'    => RAVIS_BOOKING_BASE_URL,
			) );

			if ( defined( 'RAVIS_BOOKING_SHORTCODE_WIZARD' ) )
			{
				wp_enqueue_script( 'ravis-booking-shortcode-tinyMCE-popup-js', site_url() . '/wp-includes/js/tinymce/tiny_mce_popup.js', array ( 'jquery' ), true );
				wp_enqueue_script( 'ravis-booking-shortcode-wizard-js', RAVIS_BOOKING_JS_PATH . 'shortcode-wizard.min.js', array ( 'jquery' ), true );
				wp_enqueue_style( 'custom-admin-style', RAVIS_BOOKING_CSS_PATH . 'admin.css' );
			}
			else
			{
				wp_enqueue_style( 'ravis-booking-front-style', RAVIS_BOOKING_CSS_PATH . 'styles.css' );
			}
		}

		public function ravis_booking_init_meta_boxes()
		{
			/**
			 * ------------------------------------------------------------------------------------------
			 *  Post Meta Boxes
			 * ------------------------------------------------------------------------------------------
			 */
			$post_meta_box_prefix = 'ravis_booking_post_';
			$post_meta_box_title  = esc_html__( 'Post Setting', 'ravis-booking' );
			$post_meta_box_items  = array (
				array (
					'label' => esc_html__( 'Subtitle', 'ravis-booking' ),
					'desc'  => esc_html__( 'Add subtitle of the post in this field.', 'ravis-booking' ),
					'id'    => $post_meta_box_prefix . 'subtitle',
					'type'  => 'text',
				),
			);
			$posts_meta_box_obj   = new Ravis_booking_meta_boxes( $post_meta_box_items, $post_meta_box_prefix, $post_meta_box_title, 'post' );

			/**
			 * ------------------------------------------------------------------------------------------
			 *  Pages Meta Boxes
			 * ------------------------------------------------------------------------------------------
			 */
			$page_meta_box_prefix = 'ravis_booking_page_';
			$page_meta_box_title  = esc_html__( 'Page Setting', 'ravis-booking' );
			$page_meta_box_items  = array (
				array (
					'label' => esc_html__( 'Subtitle', 'ravis-booking' ),
					'desc'  => esc_html__( 'Add subtitle of the page in this field.', 'ravis-booking' ),
					'id'    => $page_meta_box_prefix . 'subtitle',
					'type'  => 'text',
				),
				array (
					'label' => esc_html__( 'Page ID', 'ravis-booking' ),
					'desc'  => __( 'Add your custom ID for using it to change the default style. List of the default page IDs are <a href="#" target="_blank">here</a>', 'ravis-booking' ),
					'id'    => $page_meta_box_prefix . 'id',
					'type'  => 'text',
				),
				array (
					'label' => esc_html__( 'Page Class', 'ravis-booking' ),
					'desc'  => __( 'Add your custom class for using it to change the default style. List of the default page classes are <a href="#" target="_blank">here</a>', 'ravis-booking' ),
					'id'    => $page_meta_box_prefix . 'class',
					'type'  => 'text',
				),
				array (
					'label' => esc_html__( 'Wide View', 'ravis-booking' ),
					'desc'  => esc_html__( 'If you want to have wide view in this page, please turn this switch on.', 'ravis-booking' ),
					'id'    => $page_meta_box_prefix . 'page_layout',
					'type'  => 'switch',
				),
				array (
					'label'   => esc_html__( 'Breadcrumb Section', 'ravis-booking' ),
					'desc'    => esc_html__( 'If you want to have breadcrumb in this page, please turn this switch on.', 'ravis-booking' ),
					'id'      => $page_meta_box_prefix . 'breadcrumb_section',
					'type'    => 'switch',
					'default' => 'on',
				),
				array (
					'label' => esc_html__( 'Page Breadcrumb Background', 'ravis-booking' ),
					'desc'  => esc_html__( 'Upload your desired image as page\'s breadcrumb. Please note that your image will be shown if you have turned on the "Breadcrumb Section" option.', 'ravis-booking' ),
					'id'    => $page_meta_box_prefix . 'bread_crumb',
					'type'  => 'image',
				),
				array (
					'label' => esc_html__( 'Page Breadcrumb Height', 'ravis-booking' ),
					'desc'  => esc_html__( 'Set the height of breadcrumb in this field. Default value of it is 520px, leave it blank if you want to use default value.', 'ravis-booking' ),
					'id'    => $page_meta_box_prefix . 'bread_crumb_height',
					'type'  => 'number',
				),
				array (
					'label' => esc_html__( 'Page Breadcrumb Text', 'ravis-booking' ),
					'desc'  => esc_html__( 'If you want to have text below the title box, add it here.', 'ravis-booking' ),
					'id'    => $page_meta_box_prefix . 'bread_crumb_text',
					'type'  => 'textarea',
				),
			);
			$pages_meta_box_obj   = new Ravis_booking_meta_boxes( $page_meta_box_items, $page_meta_box_prefix, $page_meta_box_title, 'page' );

			/**
			 * ------------------------------------------------------------------------------------------
			 *  Block Dates Meta Boxes
			 * ------------------------------------------------------------------------------------------
			 */
			$get_rooms_args           = array (
				'post_type'   => 'rooms',
				'post_status' => 'publish',
				'order'       => 'DESC',
				'orderby'     => 'date',
				'nopaging'    => true,
			);
			$ravis_booking_rooms_list = new WP_Query( $get_rooms_args );

			/**
			 * List all rooms
			 */

			if ( $ravis_booking_rooms_list->have_posts() )
			{
				while ( $ravis_booking_rooms_list->have_posts() )
				{
					$ravis_booking_rooms_list->the_post();
					$ravis_booking_blocked_rooms[] = array (
						'label' => get_the_title(),
						'value' => Ravis_booking_get_info::original_post_id( get_the_id() ),
					);
				}

				wp_reset_postdata();
			}

			$block_dates_meta_box_prefix = 'ravis_booking_block_dates_';
			$block_dates_meta_box_title  = esc_html__( 'Block Dates Information', 'ravis-booking' );
			$block_dates_meta_box_items  = array (
				array (
					'label' => esc_html__( 'From', 'ravis-booking' ),
					'desc'  => esc_html__( 'Select the block date starting date', 'ravis-booking' ),
					'id'    => $block_dates_meta_box_prefix . 'from',
					'type'  => 'date',
					'class' => 'from',
				),
				array (
					'label' => esc_html__( 'To', 'ravis-booking' ),
					'desc'  => esc_html__( 'Select the block date ending date', 'ravis-booking' ),
					'id'    => $block_dates_meta_box_prefix . 'to',
					'type'  => 'date',
					'class' => 'to',
				),
				array (
					'label'   => esc_html__( 'Select Rooms', 'ravis-booking' ),
					'desc'    => esc_html__( 'Select rooms which is blocked', 'ravis-booking' ),
					'id'      => $block_dates_meta_box_prefix . 'blocked_rooms',
					'type'    => 'checkbox_group',
					'options' => ( isset( $ravis_booking_blocked_rooms ) ? $ravis_booking_blocked_rooms : '' ),
				),
			);
			$block_dates_meta_box_obj    = new Ravis_booking_meta_boxes( $block_dates_meta_box_items, $block_dates_meta_box_prefix, $block_dates_meta_box_title, 'block_dates' );

			/**
			 * ------------------------------------------------------------------------------------------
			 *  Staff Meta Boxes
			 * ------------------------------------------------------------------------------------------
			 */
			$staff_meta_box_prefix = 'ravis_booking_staff_';
			$staff_meta_box_title  = esc_html__( 'Additional information', 'ravis-booking' );
			$staff_meta_box_items  = array (
				array (
					'label' => esc_html__( 'Staff ID', 'ravis-booking' ),
					'id'    => $staff_meta_box_prefix . 'id',
					'type'  => 'id',
				),
				array (
					'label' => esc_html__( 'Position', 'ravis-booking' ),
					'desc'  => esc_html__( 'Add the position of the employee like : "Manager", "Executive Director" and etc.', 'ravis-booking' ),
					'id'    => $staff_meta_box_prefix . 'position',
					'type'  => 'text',
				),
				array (
					'label' => esc_html__( 'Email', 'ravis-booking' ),
					'desc'  => esc_html__( 'Add the email of the employee', 'ravis-booking' ),
					'id'    => $staff_meta_box_prefix . 'email',
					'type'  => 'email',
				),
				array (
					'label' => esc_html__( 'Skype', 'ravis-booking' ),
					'desc'  => esc_html__( 'Add the Skype ID of the employee', 'ravis-booking' ),
					'id'    => $staff_meta_box_prefix . 'skype',
					'type'  => 'text',
				),
				array (
					'label' => esc_html__( 'Facebook', 'ravis-booking' ),
					'desc'  => esc_html__( 'Add the facebook ID of the employee', 'ravis-booking' ),
					'id'    => $staff_meta_box_prefix . 'facebook',
					'type'  => 'text',
				),
				array (
					'label' => esc_html__( 'Twitter', 'ravis-booking' ),
					'desc'  => esc_html__( 'Add the twitter ID of the employee', 'ravis-booking' ),
					'id'    => $staff_meta_box_prefix . 'twitter',
					'type'  => 'text',
				),
				array (
					'label' => esc_html__( 'Google Plus', 'ravis-booking' ),
					'desc'  => esc_html__( 'Add the google plus of the employee', 'ravis-booking' ),
					'id'    => $staff_meta_box_prefix . 'google_plus',
					'type'  => 'text',
				),
			);
			$staff_meta_box_obj    = new Ravis_booking_meta_boxes( $staff_meta_box_items, $staff_meta_box_prefix, $staff_meta_box_title, 'staff' );

			/**
			 * ------------------------------------------------------------------------------------------
			 *  Testimonials Meta Boxes
			 * ------------------------------------------------------------------------------------------
			 */
			$testimonials_meta_box_prefix = 'ravis_booking_testimonials_';
			$testimonials_meta_box_title  = esc_html__( 'Testimonials Extra information', 'ravis-booking' );
			$testimonials_meta_box_items  = array (
				array (
					'label' => esc_html__( 'Guest Name', 'ravis-booking' ),
					'desc'  => esc_html__( 'Put the guest\'s name in this field', 'ravis-booking' ),
					'id'    => $testimonials_meta_box_prefix . 'guest_name',
					'type'  => 'text',
				),
				array (
					'label' => esc_html__( 'Guest Job', 'ravis-booking' ),
					'desc'  => esc_html__( 'Put the guest\'s job in this field', 'ravis-booking' ),
					'id'    => $testimonials_meta_box_prefix . 'guest_job',
					'type'  => 'text',
				),
				array (
					'label' => esc_html__( 'Guest Email', 'ravis-booking' ),
					'desc'  => esc_html__( 'Put the guest\'s email in this field', 'ravis-booking' ),
					'id'    => $testimonials_meta_box_prefix . 'guest_email',
					'type'  => 'email',
				),
				array (
					'label' => esc_html__( 'Guest Phone', 'ravis-booking' ),
					'desc'  => esc_html__( 'Put the guest\'s phone in this field', 'ravis-booking' ),
					'id'    => $testimonials_meta_box_prefix . 'guest_phone',
					'type'  => 'text',
				),
			);
			$testimonials_meta_box_obj    = new Ravis_booking_meta_boxes( $testimonials_meta_box_items, $testimonials_meta_box_prefix, $testimonials_meta_box_title, 'testimonials' );

			/**
			 * ------------------------------------------------------------------------------------------
			 *  Time Line Meta Boxes
			 * ------------------------------------------------------------------------------------------
			 */
			$timeline_meta_box_prefix = 'ravis_booking_timeline_';
			$timeline_meta_box_title  = esc_html__( 'Timeline Extra information', 'ravis-booking' );
			$timeline_meta_box_items  = array (
				array (
					'label' => esc_html__( 'Date', 'ravis-booking' ),
					'desc'  => esc_html__( 'Please add the "Year" of the event in this box like : 1984', 'ravis-booking' ),
					'id'    => $timeline_meta_box_prefix . 'date',
					'type'  => 'text',
				),
			);
			$timelines_meta_box_obj   = new Ravis_booking_meta_boxes( $timeline_meta_box_items, $timeline_meta_box_prefix, $timeline_meta_box_title, 'timeline' );

			/**
			 * ------------------------------------------------------------------------------------------
			 *  Package Meta Boxes
			 * ------------------------------------------------------------------------------------------
			 */
			$package_meta_box_prefix = 'ravis_booking_packages_';
			$package_meta_box_title  = esc_html__( 'Packages Setting', 'ravis-booking' );
			$package_meta_box_items  = array (
				array (
					'label' => esc_html__( 'Subtitle', 'ravis-booking' ),
					'desc'  => esc_html__( 'Add subtitle of the package in this field.', 'ravis-booking' ),
					'id'    => $package_meta_box_prefix . 'subtitle',
					'type'  => 'text',
				),
				array (
					'label' => esc_html__( 'Price', 'ravis-booking' ),
					'desc'  => esc_html__( 'Add price of the package in this field', 'ravis-booking' ),
					'id'    => $package_meta_box_prefix . 'price',
					'type'  => 'service_price',
				),
				array (
					'label' => esc_html__( 'Included Items', 'ravis-booking' ),
					'desc'  => esc_html__( 'Add as much as you need items to this package', 'ravis-booking' ),
					'id'    => $package_meta_box_prefix . 'items',
					'type'  => 'repeatable',
				),
			);
			$packages_meta_box_obj   = new Ravis_booking_meta_boxes( $package_meta_box_items, $package_meta_box_prefix, $package_meta_box_title, 'packages' );

			/**
			 * ------------------------------------------------------------------------------------------
			 *  Event Meta Boxes
			 * ------------------------------------------------------------------------------------------
			 */
			$events_meta_box_prefix = 'ravis_booking_events_';
			$events_meta_box_title  = esc_html__( 'Event Extra information', 'ravis-booking' );
			$events_meta_box_items  = array (
				array (
					'label' => esc_html__( 'Event ID', 'ravis-booking' ),
					'id'    => $events_meta_box_prefix . 'id',
					'type'  => 'id',
				),
				array (
					'label' => esc_html__( 'Subtitle', 'ravis-booking' ),
					'desc'  => esc_html__( 'Add subtitle of about the event in this field.', 'ravis-booking' ),
					'id'    => $events_meta_box_prefix . 'subtitle',
					'type'  => 'text',
				),
				array (
					'label' => esc_html__( 'Short Description', 'ravis-booking' ),
					'desc'  => esc_html__( 'Add some description about the event to be shown in event\'s box in archive page.', 'ravis-booking' ),
					'id'    => $events_meta_box_prefix . 'short_desc',
					'type'  => 'textarea',
				),
				array (
					'label' => esc_html__( 'Date', 'ravis-booking' ),
					'desc'  => esc_html__( 'Select date of the event', 'ravis-booking' ),
					'id'    => $events_meta_box_prefix . 'date',
					'type'  => 'date',
				),
				array (
					'label' => esc_html__( 'Capacity', 'ravis-booking' ),
					'desc'  => esc_html__( 'Select how many guests can book for this event', 'ravis-booking' ),
					'id'    => $events_meta_box_prefix . 'capacity',
					'type'  => 'number',
				),
				array (
					'label' => esc_html__( 'Gallery', 'ravis-booking' ),
					'desc'  => esc_html__( 'Manage event\'s images with this field.', 'ravis-booking' ),
					'id'    => $events_meta_box_prefix . 'gallery',
					'type'  => 'gallery',
				),
				array (
					'label'   => esc_html__( 'Box Column', 'ravis-booking' ),
					'desc'    => esc_html__( 'Select how many columns of archive pages or shortcode must be filled by this item.', 'ravis-booking' ),
					'id'      => $events_meta_box_prefix . 'box_col',
					'type'    => 'select',
					'options' => array (
						1 => 1,
						2 => 2,
						3 => 3,
					),
				),
			);
			$events_meta_box_obj    = new Ravis_booking_meta_boxes( $events_meta_box_items, $events_meta_box_prefix, $events_meta_box_title, 'events' );

			/**
			 * ------------------------------------------------------------------------------------------
			 *  Event Booking Meta Boxes
			 * ------------------------------------------------------------------------------------------
			 */
			$events_booking_meta_box_prefix = 'ravis_booking_events_booking_';
			$events_booking_meta_box_title  = esc_html__( 'Event Guest List', 'ravis-booking' );
			$events_booking_meta_box_items  = array (
				array (
					'id'   => $events_booking_meta_box_prefix . 'guest_list',
					'type' => 'event_guest_list',
				),
			);
			$events_booking_meta_box_obj    = new Ravis_booking_meta_boxes( $events_booking_meta_box_items, $events_booking_meta_box_prefix, $events_booking_meta_box_title, 'events' );

			/**
			 * ------------------------------------------------------------------------------------------
			 *  Hotel Section Meta Boxes
			 * ------------------------------------------------------------------------------------------
			 */
			$hotel_section_meta_box_prefix = 'ravis_booking_hotel_section_';
			$hotel_section_meta_box_title  = esc_html__( 'Hotel Section Extra information', 'ravis-booking' );
			$hotel_section_meta_box_items  = array (
				array (
					'label' => esc_html__( 'Subtitle', 'ravis-booking' ),
					'desc'  => esc_html__( 'Add subtitle of this section in this field.', 'ravis-booking' ),
					'id'    => $hotel_section_meta_box_prefix . 'subtitle',
					'type'  => 'text',
				),
			);
			$hotel_sections_meta_box_obj   = new Ravis_booking_meta_boxes( $hotel_section_meta_box_items, $hotel_section_meta_box_prefix, $hotel_section_meta_box_title, 'hotel_section' );

			/**
			 * ------------------------------------------------------------------------------------------
			 *  Room Meta Boxes
			 * ------------------------------------------------------------------------------------------
			 */
			$room_meta_box_prefix = 'ravis_booking_room_';
			$room_meta_box_title  = esc_html__( 'Room Extra information', 'ravis-booking' );
			$room_meta_box_items  = array (
				array (
					'label' => esc_html__( 'Room ID', 'ravis-booking' ),
					'id'    => $room_meta_box_prefix . 'id',
					'type'  => 'id',
				),
				array (
					'label' => esc_html__( 'Subtitle', 'ravis-booking' ),
					'desc'  => esc_html__( 'Add a subtitle about the room', 'ravis-booking' ),
					'id'    => $room_meta_box_prefix . 'subtitle',
					'type'  => 'text',
				),
				array (
					'label' => esc_html__( 'Short Description', 'ravis-booking' ),
					'desc'  => esc_html__( 'Add a short description about this room to be shown in the room listing pages. Do Not use HTML tags.', 'ravis-booking' ),
					'id'    => $room_meta_box_prefix . 'short_desc',
					'type'  => 'textarea',
				),
				array (
					'label' => esc_html__( 'Room Count', 'ravis-booking' ),
					'desc'  => esc_html__( 'Add the count of this kind of room in the hotel like : 30', 'ravis-booking' ),
					'id'    => $room_meta_box_prefix . 'count',
					'type'  => 'number',
				),
				array (
					'label' => esc_html__( 'Room Capacity', 'ravis-booking' ),
					'desc'  => __( 'Set the capacity of the room here. <br> Main Capacity is the capacity of the room without extra guests. <br> Extra capacity is for rooms in which can be accepted extra guests.', 'ravis-booking' ),
					'id'    => $room_meta_box_prefix . 'capacity',
					'type'  => 'capacity',
				),
				array (
					'label' => esc_html__( 'Minimum Stay', 'ravis-booking' ),
					'desc'  => __( 'Add the minimum stay night for this room like : "2". <br> which means that guests must book this room for 2 or more nights. <br> Leave it blank if the room doesn\'t have minimum stay limitation.', 'ravis-booking' ),
					'id'    => $room_meta_box_prefix . 'min_stay',
					'type'  => 'number',
				),
				array (
					'label' => esc_html__( 'Room Size', 'ravis-booking' ),
					'desc'  => esc_html__( 'Add the area of room', 'ravis-booking' ),
					'id'    => $room_meta_box_prefix . 'room_size',
					'type'  => 'area',
				),
				array (
					'label' => esc_html__( 'View', 'ravis-booking' ),
					'desc'  => esc_html__( 'Add the view of room, for example: Garden, Sea.', 'ravis-booking' ),
					'id'    => $room_meta_box_prefix . 'room_view',
					'type'  => 'text',
				),
				array (
					'label' => esc_html__( 'Gallery', 'ravis-booking' ),
					'desc'  => esc_html__( 'Manage room\'s images with this field.', 'ravis-booking' ),
					'id'    => $room_meta_box_prefix . 'gallery',
					'type'  => 'gallery',
				),
				array (
					'label' => esc_html__( 'Facilities', 'ravis-booking' ),
					'desc'  => esc_html__( 'Add the facilities of this room.', 'ravis-booking' ),
					'id'    => $room_meta_box_prefix . 'facilities',
					'type'  => 'facility',
				),
				array (
					'label' => esc_html__( 'Services', 'ravis-booking' ),
					'desc'  => esc_html__( 'Add the services of this room.', 'ravis-booking' ),
					'id'    => $room_meta_box_prefix . 'service',
					'type'  => 'service',
				),
			);
			$rooms_meta_box_obj   = new Ravis_booking_meta_boxes( $room_meta_box_items, $room_meta_box_prefix, $room_meta_box_title, 'rooms' );

			/**
			 * ------------------------------------------------------------------------------------------
			 *  Room Price Meta Boxes
			 * ------------------------------------------------------------------------------------------
			 */
			$room_price_meta_box_prefix = 'ravis_booking_room_price_';
			$room_price_meta_box_title  = esc_html__( 'Room Price Setting', 'ravis-booking' );
			$room_price_meta_box_items  = array (
				array (
					'label' => esc_html__( 'Base Price', 'ravis-booking' ),
					'desc'  => esc_html__( 'Add base price, the price which is used for main capacity of room, of room in this field.', 'ravis-booking' ),
					'id'    => $room_price_meta_box_prefix . 'base_price',
					'type'  => 'room_price',
				),
				array (
					'label' => esc_html__( 'Extra Guest Price', 'ravis-booking' ),
					'desc'  => esc_html__( 'Add base price, the price which is used for extra capacity of room, of room in this field.', 'ravis-booking' ),
					'id'    => $room_price_meta_box_prefix . 'extra_price',
					'type'  => 'room_price',
				),
				array (
					'label' => esc_html__( 'Seasonal Price', 'ravis-booking' ),
					'desc'  => esc_html__( 'Set the room price based on the date. These prices will override the base price during the period you set.', 'ravis-booking' ),
					'id'    => $room_price_meta_box_prefix . 'seasonal_price',
					'type'  => 'seasonal_room_price',
				),
				array (
					'label' => esc_html__( 'Discount', 'ravis-booking' ),
					'desc'  => esc_html__( 'Set the discount for users who want to book more than specific night, for example a week or 12 nights. ', 'ravis-booking' ),
					'id'    => $room_price_meta_box_prefix . 'discount',
					'type'  => 'price_discount',
				),
			);
			$room_price_meta_box_obj    = new Ravis_booking_meta_boxes( $room_price_meta_box_items, $room_price_meta_box_prefix, $room_price_meta_box_title, 'rooms' );

			/**
			 * ------------------------------------------------------------------------------------------
			 *  Room Settings Meta Boxes
			 * ------------------------------------------------------------------------------------------
			 */
			$room_setting_meta_box_prefix = 'ravis_booking_room_setting_';
			$room_setting_meta_box_title  = esc_html__( 'Room Setting', 'ravis-booking' );
			$room_setting_meta_box_items  = array (
				array (
					'label' => esc_html__( 'Rating System', 'ravis-booking' ),
					'desc'  => esc_html__( 'Enable / Disable Rating for rooms', 'ravis-booking' ),
					'id'    => $room_setting_meta_box_prefix . 'rating',
					'type'  => 'switch',
				),
				array (
					'label' => esc_html__( 'Booking Overview', 'ravis-booking' ),
					'desc'  => esc_html__( 'Enable / Disable Booking Overview Calendar in Rooms', 'ravis-booking' ),
					'id'    => $room_setting_meta_box_prefix . 'booking_overview',
					'type'  => 'switch',
				),
				array (
					'label' => esc_html__( 'Special Room', 'ravis-booking' ),
					'desc'  => esc_html__( 'Mark this room as a special room to be listed in [ravis-booking-special-rooms] shortcode', 'ravis-booking' ),
					'id'    => $room_setting_meta_box_prefix . 'special_room',
					'type'  => 'switch',
				),
			);
			$room_setting_meta_box_obj    = new Ravis_booking_meta_boxes( $room_setting_meta_box_items, $room_setting_meta_box_prefix, $room_setting_meta_box_title, 'rooms', 'side', 'default' );

			/**
			 * ------------------------------------------------------------------------------------------
			 *  Room Booking Overview Meta Boxes
			 * ------------------------------------------------------------------------------------------
			 */
			$room_booking_overview_meta_box_prefix = 'ravis_booking_room_booking_overview_';
			$room_booking_overview_meta_box_title  = esc_html__( 'Booking Overview', 'ravis-booking' );
			$room_booking_overview_meta_box_items  = array (
				array (
					'id'   => $room_booking_overview_meta_box_prefix . 'rating',
					'type' => 'overview_calendar',
				),
			);
			$room_booking_overview_meta_box_obj    = new Ravis_booking_meta_boxes( $room_booking_overview_meta_box_items, $room_booking_overview_meta_box_prefix, $room_booking_overview_meta_box_title, 'rooms' );

			/**
			 * ------------------------------------------------------------------------------------------
			 *  Dishes Meta Boxes
			 * ------------------------------------------------------------------------------------------
			 */
			$dishes_meta_box_prefix = 'ravis_booking_dishes_';
			$dishes_meta_box_title  = esc_html__( 'Dish Extra Information', 'ravis-booking' );
			$dishes_meta_box_items  = array (
				array (
					'label' => esc_html__( 'Price', 'ravis-booking' ),
					'desc'  => esc_html__( 'Add base price of this dish in this field.', 'ravis-booking' ),
					'id'    => $dishes_meta_box_prefix . 'price',
					'type'  => 'price',
				),
				array (
					'label'   => esc_html__( 'Box Column', 'ravis-booking' ),
					'desc'    => esc_html__( 'Select how many columns of archive pages must be filled by this item.', 'ravis-booking' ),
					'id'      => $dishes_meta_box_prefix . 'box_col',
					'type'    => 'select',
					'options' => array (
						1 => 1,
						2 => 2,
						3 => 3,
					),
				),
			);
			$dishes_meta_box_obj    = new Ravis_booking_meta_boxes( $dishes_meta_box_items, $dishes_meta_box_prefix, $dishes_meta_box_title, 'dish' );

			/**
			 * ------------------------------------------------------------------------------------------
			 *  Menus Meta Boxes
			 * ------------------------------------------------------------------------------------------
			 */
			$menu_meta_box_prefix = 'ravis_booking_menu_';
			$menu_meta_box_title  = esc_html__( 'Menu Extra Information', 'ravis-booking' );
			$menu_meta_box_items  = array (
				array (
					'label' => esc_html__( 'Subtitle', 'ravis-booking' ),
					'desc'  => esc_html__( 'Add a subtitle for this menu to be used in menu shortcode', 'ravis-booking' ),
					'id'    => $menu_meta_box_prefix . 'subtitle',
					'type'  => 'text',
				),
				array (
					'label' => esc_html__( 'Menu Item', 'ravis-booking' ),
					'desc'  => esc_html__( 'Mange menu items by this section', 'ravis-booking' ),
					'id'    => $menu_meta_box_prefix . 'menu_items',
					'type'  => 'menu_items',
				),
			);
			$menu_meta_box_obj    = new Ravis_booking_meta_boxes( $menu_meta_box_items, $menu_meta_box_prefix, $menu_meta_box_title, 'menu' );

			/**
			 * ------------------------------------------------------------------------------------------
			 *  Services Meta Boxes
			 * ------------------------------------------------------------------------------------------
			 */
			$service_meta_box_prefix = 'ravis_booking_service_';
			$service_meta_box_title  = esc_html__( 'Additional Settings', 'ravis-booking' );
			$service_meta_box_items  = array (
				array (
					'label'   => esc_html__( 'Load in Shortcode', 'ravis-booking' ),
					'desc'    => esc_html__( 'Enable this field if you want this service loads in [ravis-booking-services] shortcode.', 'ravis-booking' ),
					'id'      => $service_meta_box_prefix . 'shortcode',
					'type'    => 'switch',
					'default' => true,
				),
				array (
					'label' => esc_html__( 'Load in Booking Process', 'ravis-booking' ),
					'desc'  => esc_html__( 'Enable this field if you want this service loads in booking process that users can select it as extra services.', 'ravis-booking' ),
					'id'    => $service_meta_box_prefix . 'booking',
					'type'  => 'switch',
				),
				array (
					'label'    => esc_html__( 'Price Type', 'ravis-booking' ),
					'desc'     => esc_html__( 'Select if this service is free or paid.', 'ravis-booking' ),
					'id'       => $service_meta_box_prefix . 'price_type',
					'type'     => 'select',
					'tr_class' => 'price-type',
					'options'  => array (
						1 => esc_html__( 'Free', 'ravis-booking' ),
						2 => esc_html__( 'Paid', 'ravis-booking' ),
					),
				),
				array (
					'label'    => esc_html__( 'Price', 'ravis-booking' ),
					'desc'     => esc_html__( 'Add price details for your service', 'ravis-booking' ),
					'id'       => $service_meta_box_prefix . 'price',
					'type'     => 'service_price',
					'tr_class' => 'paid-service',
				),
				array (
					'label'    => esc_html__( 'Mandatory', 'ravis-booking' ),
					'desc'     => esc_html__( 'Enable this field if you want this service will un-selectable by user during the booking process. It always will be checked.', 'ravis-booking' ),
					'id'       => $service_meta_box_prefix . 'mandatory',
					'type'     => 'switch',
					'tr_class' => 'price-type',
				),
			);
			$service_meta_box_obj    = new Ravis_booking_meta_boxes( $service_meta_box_items, $service_meta_box_prefix, $service_meta_box_title, 'service' );

			/**
			 * ------------------------------------------------------------------------------------------
			 *  Coupon Meta Boxes
			 * ------------------------------------------------------------------------------------------
			 */
			$coupon_meta_box_prefix = 'ravis_booking_coupon_';
			$coupon_meta_box_title  = esc_html__( 'Settings', 'ravis-booking' );
			$coupon_meta_box_items  = array (
				array (
					'label' => esc_html__( 'Description', 'ravis-booking' ),
					'desc'  => esc_html__( 'Add a short description about this coupon.', 'ravis-booking' ),
					'id'    => $coupon_meta_box_prefix . 'desc',
					'type'  => 'textarea'
				),
				array (
					'label'   => esc_html__( 'Discount Type', 'ravis-booking' ),
					'desc'    => esc_html__( 'Select which type of discount you want to set for the total booking price.', 'ravis-booking' ),
					'id'      => $coupon_meta_box_prefix . 'type',
					'type'    => 'select',
					'options' => array (
						'percent' => esc_html__( 'Percent', 'ravis-booking' ),
						'fixed'   => esc_html__( 'Fixed Price', 'ravis-booking' ),
					),
				),
				array (
					'label' => esc_html__( 'Percent', 'ravis-booking' ),
					'desc'  => esc_html__( 'If you have set Percent for your coupon, you can set the discount\'s percent in this field. Please add just a digit', 'ravis-booking' ),
					'id'    => $coupon_meta_box_prefix . 'percent',
					'type'  => 'percent'
				),
				array (
					'label' => esc_html__( 'Price', 'ravis-booking' ),
					'desc'  => esc_html__( 'If you have set fixed price for your coupon, you can set the fixed discount in this field. Please add just a digit', 'ravis-booking' ),
					'id'    => $coupon_meta_box_prefix . 'price',
					'type'  => 'price'
				),
				array (
					'label' => esc_html__( 'Expire Date', 'ravis-booking' ),
					'desc'  => esc_html__( 'Set when this coupon will be expired.', 'ravis-booking' ),
					'id'    => $coupon_meta_box_prefix . 'expire',
					'type'  => 'date'
				),
				array (
					'label' => esc_html__( 'Coupon Amount', 'ravis-booking' ),
					'desc'  => esc_html__( 'Set how many coupon you need to set for this coupon.', 'ravis-booking' ),
					'id'    => $coupon_meta_box_prefix . 'amount',
					'type'  => 'number'
				),
				array (
					'label' => esc_html__( 'Used Coupon', 'ravis-booking' ),
					'desc'  => esc_html__( 'How many coupon have been used until now.', 'ravis-booking' ),
					'id'    => $coupon_meta_box_prefix . 'used',
					'type'  => 'demo',
					'init'  => 0,
				),
			);
			$coupon_meta_box_obj    = new Ravis_booking_meta_boxes( $coupon_meta_box_items, $coupon_meta_box_prefix, $coupon_meta_box_title, 'coupon' );
		}

		public function ravis_booking_menu_items()
		{
			add_menu_page( esc_html__( 'Ravis Booking', 'ravis-booking' ), esc_html__( 'Ravis Booking', 'ravis-booking' ), 'manage_options', 'ravis-booking-setting', array (
				$this,
				'ravis_booking_setting_page',
			), 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDEuMSBUaW55Ly9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLXRpbnkuZHRkIiBbPCFFTlRJVFkgbnNfZmxvd3MgImh0dHA6Ly9ucy5hZG9iZS5jb20vRmxvd3MvMS4wLyI+XT48c3ZnIHZlcnNpb249IjEuMSIgYmFzZVByb2ZpbGU9InRpbnkiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbG5zOmE9Imh0dHA6Ly9ucy5hZG9iZS5jb20vQWRvYmVTVkdWaWV3ZXJFeHRlbnNpb25zLzMuMC8iIHg9IjBweCIgeT0iMHB4IiB3aWR0aD0iMTA3cHgiIGhlaWdodD0iOTNweCIgdmlld0JveD0iLTAuNDgzODg2NyAtMC4xOTMzNTk0IDEwNyA5MyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+PGRlZnM+PC9kZWZzPjxwYXRoIGZpbGw9IiMwMTAxMDEiIGQ9Ik0xMDYuMzMwNTY2NCwwSDB2OTEuOTk3MDcwM2gxMDYuMzMwNTY2NFYweiBNMTAxLjcwMTY2MDIsODcuMjg1MTU2M0g0LjYxOTE0MDZWNC42MjQwMjM0aDk3LjA4MjUxOTVWODcuMjg1MTU2M3oiLz48cGF0aCBmaWxsPSIjMDEwMTAxIiBkPSJNMTcuNzQ5MDIzNCw2OS40Mzg0NzY2bC0wLjA5MDMzMiw3LjIxNjc5NjljNi42NTUyNzM0LTAuMzc1OTc2NiwzMS4zNDUyMTQ4LTAuMzc1OTc2NiwzOC42NTIzNDM4LDBsLTAuMTg1NTQ2OS03LjExOTE0MDZjLTEwLjgxNTQyOTcsMC4yNzM0Mzc1LTkuNzk5ODA0Ny0yLjA0MTAxNTYtOS43OTk4MDQ3LTUuMjczNDM3NVY1MC4wMjQ0MTQxbDEzLjQwMzMyMDMsMTUuNTI3MzQzOGMyLjU4Nzg5MDYsMi45Njg3NSw0LjcyMTY3OTcsNi42NjAxNTYzLDcuMzA0Njg3NSwxMC45MTc5Njg4YzI0LjY4NzUsMCwyNy43MzQzNzUsMC4xODU1NDY5LDI3LjczNDM3NSwwLjE4NTU0Njl2LTYuOTM4NDc2NkM4Ni44MjM3MzA1LDY4Ljk3OTQ5MjIsODUuNTI0OTAyMyw2OC4yMzczMDQ3LDgyLjc1NjM0NzcsNjVsLTE3LjEwOTM3NS0yMC4wNTg1OTM4YzEwLjYzNDc2NTYtMS4yOTg4MjgxLDE3LjI5NDkyMTktNi44NDU3MDMxLDE3LjE5NzI2NTYtMTUuODE1NDI5N0M4Mi43NTYzNDc3LDEzLjQwODIwMzEsNjguNDI1MjkzLDE0LjA1MjczNDQsNTMuMjU5Mjc3MywxMy43NzkyOTY5Yy01LjA4NTQ0OTItMC4wOTc2NTYzLTI5LjEyMzUzNTIsMC4wODc4OTA2LTM1LjYwMDU4NTksMC4wODc4OTA2bDAuMDkwMzMyLDcuMjExOTE0MWM5Ljg5NTAxOTUsMCw5LjA2NDk0MTQsMC45MjI4NTE2LDkuMDY0OTQxNCw0LjgwOTU3MDN2MzguMzc0MDIzNEMyNi44MTM5NjQ4LDY2Ljc1NzgxMjUsMjguMTA1NDY4OCw3MC4xODA2NjQxLDE3Ljc0OTAyMzQsNjkuNDM4NDc2NnogTTQ2LjMyNTY4MzYsMjEuNjQwNjI1YzEuNDc0NjA5NC0wLjA5NzY1NjMsMi43NzM0Mzc1LTAuMjgzMjAzMSw0LjE1NzcxNDgtMC4yODMyMDMxYzcuMzAyMjQ2MSwwLDExLjkyNjI2OTUsMi43NzgzMjAzLDExLjkyNjI2OTUsOC43ODkwNjI1aC0wLjA5Mjc3MzRjMC4wOTI3NzM0LDguMjIyNjU2My02Ljg0NTcwMzEsMTAuNjM0NzY1Ni0xNS45OTEyMTA5LDEwLjkwODIwMzFWMjEuNjQwNjI1eiIvPjwvc3ZnPg==' );
			add_submenu_page( 'ravis-booking-setting', esc_html__( 'Booking Archive', 'ravis-booking' ), esc_html__( 'Booking Archive', 'ravis-booking' ), 'manage_options', 'ravis-booking-archive', array (
				$this,
				'ravis_booking_archive',
			) );
			add_submenu_page( 'ravis-booking-setting', esc_html__( 'Booking Overview', 'ravis-booking' ), esc_html__( 'Booking Overview', 'ravis-booking' ), 'manage_options', 'ravis-booking-overview', array (
				$this,
				'ravis_booking_overview',
			) );
			add_submenu_page( 'ravis-booking-setting', esc_html__( 'Payment Archive', 'ravis-booking' ), esc_html__( 'Payment Archive', 'ravis-booking' ), 'manage_options', 'ravis-payment-archive', array (
				$this,
				'ravis_payment_archive',
			) );
		}

		public function ravis_booking_setting_page()
		{
			require_once RAVIS_BOOKING_TPL . 'admin/admin.php';
		}

		public function ravis_booking_archive()
		{
			require_once RAVIS_BOOKING_TPL . 'admin/booking.php';
		}

		public function ravis_payment_archive()
		{
			require_once RAVIS_BOOKING_TPL . 'admin/payment.php';
		}

		public function ravis_booking_overview()
		{
			wp_enqueue_script( 'moment-js', RAVIS_BOOKING_JS_PATH . 'moment.min.js', array ( 'jquery' ), RAVIS_BOOKING_VERSION, true );
			wp_enqueue_script( 'fullcalendar-js', RAVIS_BOOKING_JS_PATH . 'fullcalendar.min.js', array (
				'jquery',
				'moment-js',
			), RAVIS_BOOKING_VERSION, true );
			$web_current_locale = 'en';

			if ( get_locale() !== 'en_US' )
			{
				if ( file_exists( RAVIS_BOOKING_PATH . '/assets/js/locales.php' ) )
				{
					require RAVIS_BOOKING_PATH . '/assets/js/locales.php';
				}

				$web_current_locale = isset( $plugin_locales[ get_locale() ] ) ? $plugin_locales[ get_locale() ] : 'en';
				wp_enqueue_script( 'fullcalendar-locales-js', RAVIS_BOOKING_JS_PATH . 'locale/' . $web_current_locale . '.js', array ( 'jquery' ), RAVIS_BOOKING_VERSION, true );
			}

			$inline_locale_script = '
                    jQuery(document).ready(function ($) {
                        jQuery(\'#calendar\').fullCalendar({
                            locale:        \'' . esc_js( $web_current_locale ) . '\',
                            eventMouseover: function (event, jsEvent, view) {
                                var eventURL   = event.url,
                                    eventTitle = event.title;

                                jQuery(\'.fc-event\').each(function (index, el) {
                                    var eventHref = jQuery(this).attr(\'href\'),
                                        eventText = jQuery(this).find(\'.fc-title\').text();

                                    if (eventHref == eventURL && eventText == eventTitle) {
                                        jQuery(this).addClass(\'hover-event\');
                                    }
                                });
                            },
                            eventMouseout:  function (event, jsEvent, view) {
                                jQuery(\'.fc-event\').removeClass(\'hover-event\');
                            },
                            eventSources:   [
                                {
                                    events: function (start, end, timezone, callback) {
                                        var startDate = (start._d.getFullYear()) + \'-\' + (start._d.getMonth() + 1) + \'-\' + (start._d.getDate()),
                                            endDate   = (end._d.getFullYear()) + \'-\' + (end._d.getMonth() + 1) + \'-\' + (end._d.getDate());
                                        jQuery.ajax({
                                            url:      ravis_booking.ajaxurl,
                                            dataType: \'json\',
                                            method:   \'post\',
                                            data:     {
                                                action: "ravis_booking_booking_overview",
                                                start:  startDate,
                                                end:    endDate
                                            }
                                        }).done(function (dataBooking) {
                                            var events = [];
                                            jQuery(dataBooking).each(function () {
                                                events.push({
                                                    title: jQuery(this).attr(\'title\'),
                                                    start: jQuery(this).attr(\'start\'),
                                                    end:   jQuery(this).attr(\'end\')
                                                });
                                            });
                                            callback(events);
                                        });
                                    }
                                }
                            ]
                        });
                    });
                ';

			if ( get_locale() !== 'en_US' )
			{
				wp_add_inline_script( 'fullcalendar-locales-js', $inline_locale_script );
			}
			else
			{
				wp_add_inline_script( 'fullcalendar-js', $inline_locale_script );
			}

			require_once RAVIS_BOOKING_TPL . 'admin/overview.php';
		}

		public function ravis_booking_init_setting_page()
		{
			register_setting( 'ravis-booking-setting', 'ravis-booking-setting', array (
				$this,
				'ravis_booking_sanitize_options',
			) );
		}

		public function ravis_booking_sanitize_options( $data )
		{
			$new_data     = array ();
			$int_fields   = array (
				'vat',
				'deposit',
				'email_notification_status',
				'default_currency',
				'archive_page_layout',
				'deposit_status',
				'email_booking',
				'paypal_booking',
				'paymill_booking',
				'stripe_booking',
				'booking_archive_per_age',
				'currency_separator',
				'currency_decimal',
				'currency_decimal_separator',
				'rating_status',
				'external_booking',
				'external_booking_method',
				'guest_receiver',
				'room_base_price',
				'listing_image_slider',
			);
			$text_fields  = array (
				'main_slider',
				'main_gallery',
				'booking_url',
				'paymill_private_key',
				'paymill_public_key',
				'stripe_publish_key',
				'stripe_secret_key',
				'final_booking_title',
				'final_booking_subtitle',
				'final_booking_desc',
				'rating_item',
				'wp_email_sender_name',
				'paypal_default_currency',
			);
			$html_fields  = array ( 'email_admin_tmpl', 'email_user_tmpl' );
			$email_fields = array ( 'email_sender', 'email_receiver', 'paypal_email', 'wp_email_sender' );
			$url_fields   = array ( 'condition_url', 'paypal_action_url', 'contact_url', 'external_booking_url' );

			foreach ( $data as $index => $field )
			{
				if ( in_array( $index, $email_fields ) )
				{
					if ( $index !== 'email_receiver' )
					{
						$new_data[ $index ] = filter_var( $field, FILTER_SANITIZE_EMAIL );
					}
					else
					{
						foreach ( $field as $receiver_index => $receiver_email )
						{
							$new_data[ $index ][ $receiver_index ] = filter_var( $receiver_email, FILTER_SANITIZE_EMAIL );
						}
					}
				}

				if ( in_array( $index, $text_fields ) )
				{
					if ( $index === 'rating_item' )
					{
						foreach ( $field as $item_index => $item_value )
						{
							$new_data[ $index ][ $item_index ] = filter_var( $item_value, FILTER_SANITIZE_STRING );
						}
					}
					else
					{
						$new_data[ $index ] = filter_var( $field, FILTER_SANITIZE_STRING );
					}
				}

				if ( in_array( $index, $html_fields ) )
				{
					$new_data[ $index ] = wp_kses_post( $field );
				}

				if ( in_array( $index, $url_fields ) )
				{
					$new_data[ $index ] = filter_var( $field, FILTER_SANITIZE_URL );
				}

				if ( in_array( $index, $int_fields ) )
				{
					$new_data[ $index ] = filter_var( $field, FILTER_SANITIZE_NUMBER_INT );
				}

				if ( $index === 'currency' )
				{
					foreach ( $field as $curr_index => $curr_val )
					{
						if ( ! empty( $curr_val['title'] ) || ! empty( $curr_val['symbol'] ) || ! empty( $curr_val['position'] ) )
						{
							$new_data[ $index ][ $curr_index ]['title']  = filter_var( $curr_val['title'], FILTER_SANITIZE_STRING );
							$new_data[ $index ][ $curr_index ]['symbol'] = filter_var( $curr_val['symbol'], FILTER_SANITIZE_STRING );
							$new_data[ $index ][ $curr_index ]['rate']   = filter_var( $curr_val['rate'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );

							if ( ! empty( $curr_val['position'] ) )
							{
								$new_data[ $index ][ $curr_index ]['position'] = filter_var( $curr_val['position'], FILTER_SANITIZE_NUMBER_INT );
							}
						}
					}
				}

				if ( $index === 'social_icons' )
				{
					foreach ( $field as $social_index => $social_val )
					{
						$new_data[ $index ][ $social_index ] = filter_var( $social_val, FILTER_SANITIZE_STRING );
					}
				}

				if ( $index === 'client' )
				{
					foreach ( $field as $client_index => $client_val )
					{
						if ( ! empty( $client_val['title'] ) || ! empty( $client_val['url'] ) || ! empty( $client_val['logo'] ) )
						{
							$new_data[ $index ][ $client_index ]['title'] = filter_var( $client_val['title'], FILTER_SANITIZE_STRING );
							$new_data[ $index ][ $client_index ]['url']   = filter_var( $client_val['url'], FILTER_SANITIZE_URL );
							$new_data[ $index ][ $client_index ]['logo']  = filter_var( $client_val['logo'], FILTER_SANITIZE_NUMBER_INT );
						}
					}
				}

				if ( $index === 'membership' )
				{
					foreach ( $field as $membership_index => $membership_val )
					{
						if ( ! empty( $membership_val['title'] ) || ! empty( $membership_val['badge'] ) || ! empty( $membership_val['condition'] ) || ! empty( $membership_val['discount'] ) )
						{
							$new_data[ $index ][ $membership_index ]['title']                  = filter_var( $membership_val['title'], FILTER_SANITIZE_STRING );
							$new_data[ $index ][ $membership_index ]['badge']                  = filter_var( $membership_val['badge'], FILTER_SANITIZE_NUMBER_INT );
							$new_data[ $index ][ $membership_index ]['condition']              = filter_var( $membership_val['condition'], FILTER_SANITIZE_NUMBER_INT );
							$new_data[ $index ][ $membership_index ]['single-condition-price'] = filter_var( $membership_val['single-condition-price'], FILTER_SANITIZE_NUMBER_INT );
							$new_data[ $index ][ $membership_index ]['single-condition-item']  = filter_var( $membership_val['single-condition-item'], FILTER_SANITIZE_NUMBER_INT );
							$new_data[ $index ][ $membership_index ]['condition-price']        = filter_var( $membership_val['condition-price'], FILTER_SANITIZE_NUMBER_INT );
							$new_data[ $index ][ $membership_index ]['condition-item']         = filter_var( $membership_val['condition-item'], FILTER_SANITIZE_NUMBER_INT );
							$new_data[ $index ][ $membership_index ]['condition-type']         = filter_var( $membership_val['condition-type'], FILTER_SANITIZE_NUMBER_INT );
							$new_data[ $index ][ $membership_index ]['discount']               = filter_var( $membership_val['discount'], FILTER_SANITIZE_NUMBER_INT );
						}
					}
				}

				if ( $index === 'seasonal_price' )
				{
					foreach ( $field as $season_index => $season_val )
					{
						if ( ! empty( $season_val['title'] ) || ! empty( $season_val['from'] ) || ! empty( $season_val['to'] ) || ! empty( $season_val['type'] ) || ! empty( $season_val['percent'] ) )
						{
							$new_data[ $index ][ $season_index ]['title']   = filter_var( $season_val['title'], FILTER_SANITIZE_STRING );
							$new_data[ $index ][ $season_index ]['type']    = filter_var( $season_val['type'], FILTER_SANITIZE_NUMBER_INT );
							$new_data[ $index ][ $season_index ]['from']    = filter_var( $season_val['from'], FILTER_SANITIZE_STRING );
							$new_data[ $index ][ $season_index ]['to']      = filter_var( $season_val['to'], FILTER_SANITIZE_STRING );
							$new_data[ $index ][ $season_index ]['percent'] = filter_var( $season_val['percent'], FILTER_SANITIZE_NUMBER_INT );
						}
					}
				}

				if ( function_exists( 'icl_get_languages' ) && $index === 'condition_url' )
				{
					foreach ( $field as $lang => $url )
					{
						$new_data[ $index ][ $lang ] = filter_var( $url, FILTER_SANITIZE_URL );
					}
				}
			}

			return $new_data;
		}

		public function ravis_booking_import_options()
		{
			global $wpdb;
			$imported_raw_obj = json_decode( stripcslashes( $_POST['options'] ) );

			if ( ! empty( $imported_raw_obj ) )
			{
				$imported_raw_array        = array ();
				$imported_raw_array        = self::ravis_booking_objToArray( $imported_raw_obj, $imported_raw_array );
				$imported_serilized_option = serialize( $imported_raw_array );
				$result                    = $wpdb->get_results( "SELECT * FROM  $wpdb->options WHERE option_name = 'ravis-booking-setting'" );

				if ( $result )
				{
					$wpdb->update( $wpdb->options, array (
						'option_value' => $imported_serilized_option,
					), array ( 'option_name' => 'ravis-booking-setting' ), array (
						'%s',
					), array ( '%s' ) );
				}
				else
				{
					$wpdb->insert( $wpdb->options, array (
						'option_value' => $imported_serilized_option,
						'option_name'  => 'ravis-booking-setting',
					), array (
						'%s',
						'%s',
					) );
				}

				$result['status']  = true;
				$result['message'] = esc_html__( 'Your options was imported correctly.', 'ravis-booking' );
			}
			else
			{
				$result['status']  = false;
				$result['message'] = esc_html__( 'Your imported data does not have valid format. It must be JSON code.', 'ravis-booking' );
			}

			echo json_encode( $result );
			die();
		}

		public function ravis_booking_objToArray( $obj, &$arr )
		{
			if ( ! is_object( $obj ) && ! is_array( $obj ) )
			{
				$arr = $obj;

				return $arr;
			}

			foreach ( $obj as $key => $value )
			{
				if ( ! empty( $value ) )
				{
					$arr[ $key ] = array ();
					self::ravis_booking_objToArray( $value, $arr[ $key ] );
				}
				else
				{
					$arr[ $key ] = $value;
				}
			}

			return $arr;
		}

		public function ravis_booking_add_body_class( $classes )
		{
			if ( defined( 'RAVIS_BOOKING_SHORTCODE_WIZARD' ) )
			{
				$classes[] = 'shortcode-wizard-modal-page';
			}

			return $classes;
		}

		/*
    public static function uninstall() {
    if ( __FILE__ != WP_UNINSTALL_PLUGIN )
    return;
    }
     */
	}

	$ravis_booking_obj = new Ravis_booking_main;

	/**
	 * ------------------------------------------------------------------------------------------
	 *  Ravis Booking Widgets
	 * ------------------------------------------------------------------------------------------
	 */
	require_once RAVIS_BOOKING_WIDGETS . 'ravis-newsletter.php';
