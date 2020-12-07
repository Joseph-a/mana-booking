<?php

/**
 * Plugin Name: Mana Booking
 * Plugin URI: http://manadev.net
 * Description: Advanced Hotel Booking Plugin
 * Version: 1.0.0
 * Author: ManaDev Team
 * Author URI: http://manadev.net
 * Text Domain: mana-booking
 * Domain Path:  /languages
 */

if (!defined('ABSPATH')) {
	exit;
}

require_once ABSPATH . 'wp-admin/includes/plugin.php';

register_activation_hook(__FILE__, array('Mana_booking_main', 'mana_booking_activate'));
register_deactivation_hook(__FILE__, array('Mana_booking_main', 'mana_booking_deactivate'));
// register_uninstall_hook( __FILE__, array( 'Mana_booking_main', 'uninstall' ) );

/**
 * ------------------------------------------------------------------------------------------
 * Define Constants and Variables
 * ------------------------------------------------------------------------------------------
 */
$mana_booking_base = __FILE__;

if (!defined('MANA_BOOKING_BASE_URL')) {
	define('MANA_BOOKING_BASE_URL', esc_url(plugin_dir_url(__FILE__)));
}

if (!defined('MANA_BOOKING_ASSETS_LIBS')) {
	define('MANA_BOOKING_ASSETS_LIBS', MANA_BOOKING_BASE_URL . 'assets/libs/');
}

if (!defined('MANA_BOOKING_IMG_PATH')) {
	define('MANA_BOOKING_IMG_PATH', MANA_BOOKING_ASSETS_LIBS . '/img/');
}

if (!defined('MANA_BOOKING_JS_PATH')) {
	define('MANA_BOOKING_JS_PATH', MANA_BOOKING_BASE_URL . 'assets/dist/js/');
}

if (!defined('MANA_BOOKING_CSS_PATH')) {
	define('MANA_BOOKING_CSS_PATH', MANA_BOOKING_BASE_URL . 'assets/dist/css/');
}

if (!defined('MANA_BOOKING_BASE')) {
	define('MANA_BOOKING_BASE', $mana_booking_base);
}

if (!defined('MANA_BOOKING_PATH')) {
	define('MANA_BOOKING_PATH', plugin_dir_path($mana_booking_base));
}

if (!defined('MANA_BOOKING_URL')) {
	define('MANA_BOOKING_URL', plugins_url('/', $mana_booking_base));
}

if (!defined('MANA_BOOKING_MAIN_FILE')) {
	define('MANA_BOOKING_MAIN_FILE', $mana_booking_base);
}

if (!defined('MANA_BOOKING_CONFIG')) {
	define('MANA_BOOKING_CONFIG', MANA_BOOKING_PATH . 'conf/');
}

if (!defined('MANA_BOOKING_SHORTCODES')) {
	define('MANA_BOOKING_SHORTCODES', MANA_BOOKING_PATH . 'shortcodes/');
}

if (!defined('MANA_BOOKING_INCLUDES')) {
	define('MANA_BOOKING_INCLUDES', MANA_BOOKING_PATH . 'inc/');
}

if (!defined('MANA_BOOKING_TPL')) {
	define('MANA_BOOKING_TPL', MANA_BOOKING_PATH . 'tpl/');
}

$mana_plg_data = get_plugin_data(MANA_BOOKING_PATH . 'mana-booking.php');
define('MANA_BOOKING_VERSION', $mana_plg_data['Version']);

/**
 * ------------------------------------------------------------------------------------------
 * Add ajax class
 * ------------------------------------------------------------------------------------------
 */
require_once MANA_BOOKING_INCLUDES . 'ajax.class.php';

/**
 * ------------------------------------------------------------------------------------------
 * Add shortcode class
 * ------------------------------------------------------------------------------------------
 */
require_once MANA_BOOKING_INCLUDES . 'shortcode.class.php';

/**
 * ------------------------------------------------------------------------------------------
 *  Add DataBase Class
 * ------------------------------------------------------------------------------------------
 */
require_once MANA_BOOKING_INCLUDES . 'db.class.php';

/**
 * ------------------------------------------------------------------------------------------
 *  Add Page Templater Class
 * ------------------------------------------------------------------------------------------
 */
require_once MANA_BOOKING_INCLUDES . 'templater.class.php';

/**
 * ------------------------------------------------------------------------------------------
 *  Add Get information Class
 * ------------------------------------------------------------------------------------------
 */
require_once MANA_BOOKING_INCLUDES . 'get_info.class.php';

/**
 * ------------------------------------------------------------------------------------------
 *  Currency Class
 * ------------------------------------------------------------------------------------------
 */
require_once MANA_BOOKING_INCLUDES . 'currency.class.php';

/**
 * ------------------------------------------------------------------------------------------
 *  Meta Box Creator Class
 * ------------------------------------------------------------------------------------------
 */
require_once MANA_BOOKING_INCLUDES . 'meta_box.class.php';

/**
 * ------------------------------------------------------------------------------------------
 *  Booking Process Class
 * ------------------------------------------------------------------------------------------
 */
require_once MANA_BOOKING_INCLUDES . 'booking.class.php';

/**
 * ------------------------------------------------------------------------------------------
 *  User Class
 * ------------------------------------------------------------------------------------------
 */
require_once MANA_BOOKING_INCLUDES . 'user.class.php';

/**
 * ------------------------------------------------------------------------------------------
 * Coupon class
 * ------------------------------------------------------------------------------------------
 */
require_once MANA_BOOKING_INCLUDES . 'coupon.class.php';

/**
 * ------------------------------------------------------------------------------------------
 * Main Class of Mana Booking
 * ------------------------------------------------------------------------------------------
 */
class Mana_booking_main
{
	public function __construct()
	{
		add_action('init', array($this, 'mana_load_plugin_text_domain'));
		add_action('init', array($this, 'mana_booking_register_custom_post_type'));
		add_action('init', array($this, 'mana_booking_init_meta_boxes'));
		// Add Required CSS / JS files
		add_action('admin_enqueue_scripts', array($this, 'mana_booking_register_scripts'), 10, 1);

		// Add Required CSS / JS files - FrontEnd
		add_action('wp_enqueue_scripts', array($this, 'mana_booking_register_scripts_front'), 10, 1);

		add_action('plugins_loaded', array('Mana_booking_page_templater', 'get_instance'));

		add_action('admin_menu', array($this, 'mana_booking_menu_items'));
		add_action('admin_init', array($this, 'mana_booking_init_setting_page'));

		$user_update_obj = new Mana_booking_user();
		add_action('automatic_user_update', array($user_update_obj, 'automatic_profile_updater'));

		add_action('wp_ajax_nopriv_mana_booking_import_options', array(
			$this,
			'mana_booking_import_options',
		));
		add_action('wp_ajax_mana_booking_import_options', array($this, 'mana_booking_import_options'));
	}

	public static function mana_booking_activate()
	{
		if (!wp_next_scheduled('automatic_user_update')) {
			wp_schedule_event(time(), 'hourly', 'automatic_user_update');
		}

		$required_template_creation = new Mana_booking_db_class();
		$required_template_creation->required_tables();
	}

	public static function mana_booking_deactivate()
	{
		wp_clear_scheduled_hook('automatic_user_update');
	}

	public static function mana_load_plugin_text_domain()
	{
		load_plugin_textdomain('mana-booking', false, 'mana-booking/languages/');
	}

	public static function mana_booking_register_custom_post_type()
	{

		/**
		 * ------------------------------------------------------------------------------------------
		 * Rooms post_type
		 * ------------------------------------------------------------------------------------------
		 */
		register_post_type('rooms', array(
			'label'               => esc_html__('Rooms', 'mana-booking'),
			'description'         => esc_html__('Manage the rooms of hotel.', 'mana-booking'),
			'public'              => true,
			'exclude_from_search' => true,
			'has_archive'         => true,
			'show_in_rest'        => true,
			'rewrite'             => array('slug' => 'rooms'),
			'supports'            => array('title', 'editor', 'comments'),
			'menu_icon'           => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/PjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHg9IjBweCIgeT0iMHB4IiB2aWV3Qm94PSIwIDAgMzkwLjU1NyAzOTAuNTU3IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCAzOTAuNTU3IDM5MC41NTc7IiB4bWw6c3BhY2U9InByZXNlcnZlIiB3aWR0aD0iNTEycHgiIGhlaWdodD0iNTEycHgiPjxnPjxwYXRoIGQ9Ik0zODkuNzcyLDI0OC4yOTZsLTQyLjk5MS02OC4wNjNWNTUuMDI4bC0xNy41LTE3LjVINjEuMjc1bC0xNy41LDE3LjV2MTI1LjIwNEwwLjc4NCwyNDguMjk2ICAgSDM4OS43NzJ6IE0zMTEuNzgxLDcyLjUyOHY4Ny4zNjJjLTIyLjU1My01LjgzNC02MS41MTQtMTMuMDI4LTExNi41MDMtMTMuMDI4cy05My45NSw3LjE5NC0xMTYuNTAzLDEzLjAyOFY3Mi41MjhIMzExLjc4MXoiIGZpbGw9IiNhMGE1YWEiLz48cG9seWdvbiBwb2ludHM9IjAsMjY5LjgzMSAwLDMwNC44MzEgNDAuNzc4LDMwNC44MzEgNDAuNzc4LDM1My4wMjggNzUuNzc4LDM1My4wMjggNzUuNzc4LDMwNC44MzEgICAgMzE0Ljc3OCwzMDQuODMxIDMxNC43NzgsMzUzLjAyOCAzNDkuNzc4LDM1My4wMjggMzQ5Ljc3OCwzMDQuODMxIDM5MC41NTcsMzA0LjgzMSAzOTAuNTU3LDI2OS44MzEgICIgZmlsbD0iI2EwYTVhYSIvPjxwYXRoIGQ9Ik0xODEuMDc1LDEyOC42NTN2LTIwLjM4OWMwLTEyLjEwMi0xNy41NjQtMjEuOTE2LTM5LjIzLTIxLjkxNnMtMzkuMjI5LDkuODE0LTM5LjIyOSwyMS45MTZ2MzAuNjA0ICAgYzAsMCwyMy4xNC01LjgyNiwzOS4wNDUtNy4zMzJDMTU1Ljk4LDEzMC4xNzksMTgxLjA3NSwxMjguNjUzLDE4MS4wNzUsMTI4LjY1M3oiIGZpbGw9IiNhMGE1YWEiLz48cGF0aCBkPSJNMjg3Ljk0MSwxMzguODY4di0zMC42MDRjMC0xMi4xMDItMTcuNTY0LTIxLjkxNi0zOS4yMy0yMS45MTZzLTM5LjIzLDkuODE0LTM5LjIzLDIxLjkxNnYyMC4zODkgICBjMCwwLDI1LjA5NiwxLjUyNSwzOS40MTUsMi44ODNDMjY0LjgwMiwxMzMuMDQyLDI4Ny45NDEsMTM4Ljg2OCwyODcuOTQxLDEzOC44Njh6IiBmaWxsPSIjYTBhNWFhIi8+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjwvc3ZnPg==',
		));

		$labels = array(
			'name'          => _x('Room Categories', 'Taxonomy plural name', 'mana-booking'),
			'singular_name' => _x('Room Category', 'Taxonomy singular name', 'mana-booking'),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_admin_column' => true,
			'hierarchical'      => true,
			'query_var'         => true,
			'rewrite'           => array('slug' => 'room-category'),
		);

		register_taxonomy('room-category', array('rooms'), $args);

		/**
		 * ------------------------------------------------------------------------------------------
		 * Block dates post_type
		 * ------------------------------------------------------------------------------------------
		 */
		register_post_type('block_dates', array(
			'label'               => esc_html__('Block Dates', 'mana-booking'),
			'description'         => esc_html__('Manage the Block Dates.', 'mana-booking'),
			'public'              => true,
			'has_archive'         => true,
			'exclude_from_search' => true,
			'show_in_rest' 		  => true,
			'rewrite'             => array('slug' => 'block-dates'),
			'supports'            => array('title'),
			'menu_icon'           => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/PjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHg9IjBweCIgeT0iMHB4IiB3aWR0aD0iNTEycHgiIGhlaWdodD0iNTEycHgiIHZpZXdCb3g9IjAgMCA0MTYuMjA4IDQxNi4yMDkiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDQxNi4yMDggNDE2LjIwOTsiIHhtbDpzcGFjZT0icHJlc2VydmUiPjxnPjxwYXRoIGQ9Ik0zNDQuNzU3LDE2Ni45aC0yMC41NDN2LTUwLjc5MkMzMjQuMjE0LDUyLjA4NiwyNzIuMTI4LDAsMjA4LjEwNywwQzE0NC4wODQsMCw5MS45OTYsNTIuMDg2LDkxLjk5NiwxMTYuMTA4VjE2Ni45SDcxLjQ1MyAgIGMtNi42MzUsMC0xMi4wMTIsNS4zNzctMTIuMDEyLDEyLjAxMXYyMjUuMjg2YzAsNi42MzUsNS4zNzcsMTIuMDEyLDEyLjAxMiwxMi4wMTJoMjczLjMwNWM2LjYzMywwLDEyLjAxLTUuMzc3LDEyLjAxLTEyLjAxMiAgIFYxNzguOTExQzM1Ni43NjcsMTcyLjI3NywzNTEuMzksMTY2LjksMzQ0Ljc1NywxNjYuOXogTTIyNi44MzMsMzA0LjAxMnY0Ny45NjFjMCw0LjE4OS0zLjM5Niw3LjU4Ni03LjU4Niw3LjU4NmgtMjIuMjg2ICAgYy00LjE4OSwwLTcuNTg2LTMuMzk2LTcuNTg2LTcuNTg2di00Ny45NjFjLTguMjg3LTUuODc1LTEzLjY5OS0xNS41MzUtMTMuNjk5LTI2LjQ2NmMwLTE3LjkwNywxNC41MTgtMzIuNDI3LDMyLjQyOC0zMi40MjcgICBjMTcuOTA4LDAsMzIuNDI2LDE0LjUyLDMyLjQyNiwzMi40MjdDMjQwLjUzMSwyODguNDc3LDIzNS4xMTksMjk4LjEzNywyMjYuODMzLDMwNC4wMTJ6IE0yNjguNzc5LDE2Ni45SDE0Ny40MzF2LTUwLjc5MiAgIGMwLTMzLjQ1NiwyNy4yMTktNjAuNjczLDYwLjY3Ni02MC42NzNjMzMuNDU1LDAsNjAuNjcyLDI3LjIxNyw2MC42NzIsNjAuNjczVjE2Ni45eiIgZmlsbD0iI2EwYTVhYSIvPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48L3N2Zz4=',
		));

		/**
		 * ------------------------------------------------------------------------------------------
		 * Services post_type
		 * ------------------------------------------------------------------------------------------
		 */
		register_post_type('service', array(
			'label'               => esc_html__('Service', 'mana-booking'),
			'description'         => esc_html__('Manage the services that your hotel provide.', 'mana-booking'),
			'public'              => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'show_in_rest' 		  => true,
			'rewrite'             => array('slug' => 'service'),
			'supports'            => array('title', 'editor', 'thumbnail'),
			'menu_icon'           => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/PjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHg9IjBweCIgeT0iMHB4IiB3aWR0aD0iNTEycHgiIGhlaWdodD0iNTEycHgiIHZpZXdCb3g9IjAgMCAzODAuNzIxIDM4MC43MjIiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDM4MC43MjEgMzgwLjcyMjsiIHhtbDpzcGFjZT0icHJlc2VydmUiPjxnPjxnPjxwYXRoIGQ9Ik0xMjkuMTk0LDE5NS4yNDZjMC4yNS00LjA3MiwwLjUtOC4xNSwxLjAzNC0xMi4yNjljMC45ODctOS43NjYsMy4xMDgtMTkuNTcyLDUuMjc1LTI5LjExMSAgICBjMS4zMTktNC43NTgsMi43NDgtOS40NTgsNC4yNDctMTQuMDUzYzEuOTE3LTQuNDg1LDMuNzkzLTguOTQ2LDUuNjY0LTEzLjMwM2M0LjIzNS04LjUwNSw4Ljk3LTE2LjQ1MiwxNC42MjItMjMuMTA0ICAgIGMxLjM0Mi0xLjcxNCwyLjY3Mi0zLjM3NSwzLjk3NC01LjA0MmMxLjQ4Ny0xLjQ4NywyLjk3NS0yLjkyOCw0LjQwOS00LjM2OWMzLjAyNy0yLjczNiw1LjY1Mi01LjY5OSw4LjY3NC03Ljg3MiAgICBjNi4wMjMtNC40NjEsMTEuMzUyLTguNzAyLDE2Ljc3Ny0xMS4zMjhjNS4yMjktMi45MTcsOS43MTMtNS40NDksMTMuNzU2LTYuODc4YzcuOTI0LTMuMTg5LDEyLjQyMS00Ljc5MiwxMi40MjEtNC43OTIgICAgcy0zLjgzNSwzLjA0NC0xMC41MzgsNy45ODJjLTMuNDYzLDIuMjYtNy4xMzQsNS44MjctMTEuNTAzLDkuNDgxYy00LjU1NSwzLjQ4NS04LjY3OSw4LjQ4MS0xMy41ODIsMTMuMjY5ICAgIGMtMi40NTIsMi40NDYtNC4zNTYsNS41MTktNi42NzUsOC4zNDhjLTEuMTI3LDEuNDQxLTIuMjgzLDIuODkzLTMuNDc1LDQuMzY5Yy0wLjk2NCwxLjYyNy0xLjk2MywzLjI1OS0yLjk3NCw0LjkyNiAgICBjLTQuMzI4LDYuNDE0LTcuNTYzLDEzLjk0My0xMC45MzQsMjEuNTgyYy0xLjM4MywzLjk5Ny0yLjc4Miw4LjA1Mi00LjIxMiwxMi4xNDdjLTAuOTc2LDQuMjU4LTIuMDU2LDguNTYyLTMuMjM1LDEyLjg1ICAgIGMtMS43NzIsOC44MTItMy41MDksMTcuOC00LjI1OSwyNy4wNDJjLTAuNTIyLDMuMzUyLTAuNzcyLDYuNzMzLTEuMDg2LDEwLjEzN2M3My40MzYsMC4wMTIsMTMwLjI3NCwwLjA1OCwyMDkuODA1LDAuMDU4ICAgIGMwLjI2Ny0zLjQ4NiwwLjQxOC03LjAxOCwwLjQxOC0xMC41NjdjMC02Ni45ODEtNDguODExLTEyMi4xNDctMTExLjYyMS0xMjkuNDU1YzQuMDU1LTMuNzkzLDYuNjIzLTkuMTczLDYuNjIzLTE1LjE1NyAgICBjMC4wMjMtMTEuNTAyLTkuMjk1LTIwLjgwOS0yMC43NzQtMjAuODA5Yy0xMS40OTEsMC0yMC44Miw5LjMwNy0yMC44MiwyMC44MDljMCw1Ljk5NiwyLjU1NiwxMS4zNjMsNi42MjIsMTUuMTU3ICAgIGMtNjIuODA1LDcuMzA4LTExMS42MDMsNjIuNDc0LTExMS42MDMsMTI5LjQ1NWMwLDMuNTM4LDAuMTI3LDcuMDIzLDAuMzg5LDEwLjQ5OCAgICBDMTE0LjM2OSwxOTUuMjQ2LDEyMS44NTcsMTk1LjI0NiwxMjkuMTk0LDE5NS4yNDZ6IiBmaWxsPSIjYTBhNWFhIi8+PHJlY3QgeD0iODMuMzI5IiB5PSIyMDIuOTk1IiB3aWR0aD0iMjk3LjM5MiIgaGVpZ2h0PSIyNi4yMzYiIGZpbGw9IiNhMGE1YWEiLz48cGF0aCBkPSJNMjU4LjYzMSwyNDcuODU1Yy0xNS4xMTUsNy4zNDMtNjcuODE4LDI2LjM1MS02Ny44MTgsMjYuMzUxbC02Mi4yOTktMy45MDNjMCwwLDM1LjYzNS05LjkxMSw0OS40NDktMTMuMDEzICAgIGMxMy44MzgtMy4wOTEsNy44MTktMTguNjk0LDAuMTY4LTE4LjY5NGMtNy42NSwwLTc0LjMyNCwyLjc1My03NC4zMjQsMi43NTNMNTkuNTM0LDI1Ny4yOWwxMS43MTcsNzQuMTYyICAgIGMwLDAsOS4xMTUtMTUuNjA0LDE4LjIwNy0xNS42MDRjOS4xMjYsMCw4OC4xNzQsMi4xMDMsOTguOTA0LDBjMTAuNzM2LTIuMTI3LDc2LjEyNi00Ni44NTksODMuOTU3LTUyLjA3NiAgICBDMjgwLjExNSwyNTguNTc5LDI3My44MDUsMjQwLjUwMSwyNTguNjMxLDI0Ny44NTV6IiBmaWxsPSIjYTBhNWFhIi8+PHBvbHlnb24gcG9pbnRzPSIwLDI2NS4yNjEgMCwzNjEuMzk0IDY3LjgzLDM0OC42OTQgNTAuODYxLDI1Ni4zMTMgICAiIGZpbGw9IiNhMGE1YWEiLz48L2c+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjxnPjwvZz48Zz48L2c+PGc+PC9nPjwvc3ZnPg==',
		));

		/**
		 * ------------------------------------------------------------------------------------------
		 * Coupon post_type
		 * ------------------------------------------------------------------------------------------
		 */
		register_post_type('coupon', array(
			'label'               => esc_html__('Coupon', 'mana-booking'),
			'description'         => esc_html__('You can manage coupon in this section.', 'mana-booking'),
			'exclude_from_search' => true,
			'public'              => true,
			'has_archive'         => true,
			'show_in_rest'        => true,
			'rewrite'             => array('slug' => 'coupon'),
			'supports'            => array('title', 'thumbnail'),
			'menu_icon'           => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDUxMiA1MTIiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDUxMiA1MTI7IiB4bWw6c3BhY2U9InByZXNlcnZlIiB3aWR0aD0iMjU2cHgiIGhlaWdodD0iMjU2cHgiPgo8Zz4KCTxnPgoJCTxwYXRoIGQ9Ik00OTcuMjMxLDIxMS42OTJjOC4xNTcsMCwxNC43NjktNi42MTMsMTQuNzY5LTE0Ljc2OXYtNzguNzY5YzAtOC4xNTctNi42MTMtMTQuNzY5LTE0Ljc2OS0xNC43NjlIMTcyLjMwOHY3My44NDYgICAgYzAsOC4xNTctNi42MTMsMTQuNzY5LTE0Ljc2OSwxNC43NjlzLTE0Ljc2OS02LjYxMy0xNC43NjktMTQuNzY5di03My44NDZoLTEyOEM2LjYxMywxMDMuMzg1LDAsMTA5Ljk5NywwLDExOC4xNTR2NzguNzY5ICAgIGMwLDguMTU3LDYuNjEzLDE0Ljc2OSwxNC43NjksMTQuNzY5YzI0LjQzMSwwLDQ0LjMwOCwxOS44NzYsNDQuMzA4LDQ0LjMwOHMtMTkuODc2LDQ0LjMwOC00NC4zMDgsNDQuMzA4ICAgIEM2LjYxMywzMDAuMzA4LDAsMzA2LjkyLDAsMzE1LjA3N3Y3OC43NjljMCw4LjE1Nyw2LjYxMywxNC43NjksMTQuNzY5LDE0Ljc2OWgxMjh2LTczLjg0NmMwLTguMTU3LDYuNjEzLTE0Ljc2OSwxNC43NjktMTQuNzY5ICAgIHMxNC43NjksNi42MTMsMTQuNzY5LDE0Ljc2OXY3My44NDZoMzI0LjkyM2M4LjE1NywwLDE0Ljc2OS02LjYxMywxNC43NjktMTQuNzY5di03OC43NjljMC04LjE1Ny02LjYxMy0xNC43NjktMTQuNzY5LTE0Ljc2OSAgICBjLTI0LjQzMSwwLTQ0LjMwOC0xOS44NzYtNDQuMzA4LTQ0LjMwOFM0NzIuNzk5LDIxMS42OTIsNDk3LjIzMSwyMTEuNjkyeiBNMTcyLjMwOCwyNzUuNjkyYzAsOC4xNTctNi42MTMsMTQuNzY5LTE0Ljc2OSwxNC43NjkgICAgcy0xNC43NjktNi42MTMtMTQuNzY5LTE0Ljc2OXYtMzkuMzg1YzAtOC4xNTcsNi42MTMtMTQuNzY5LDE0Ljc2OS0xNC43NjlzMTQuNzY5LDYuNjEzLDE0Ljc2OSwxNC43NjlWMjc1LjY5MnoiIGZpbGw9IiNmMGY1ZmEiLz4KCTwvZz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K',
		));
	}

	public static function mana_booking_pagination($input_query_variable = '')
	{
		if (!empty($input_query_variable)) {
			$wp_query = $input_query_variable;
		} else {
			global $wp_query;
		}

		$wp_query->query_vars['paged'] > 1 ? $current = esc_html($wp_query->query_vars['paged']) : $current = 1;

		if (get_option('permalink_structure') != '') {
			$format = 'page/%#%';
			$base   = get_pagenum_link(1) . '%_%';
			$args   = false;
		} else {
			$format = ((!empty($_SERVER['QUERY_STRING']) && !array_key_exists('paged', $_GET)) ? '&paged=%#%' : '?paged=%#%');
			$base   = get_pagenum_link(1) . '%_%';
			$args   = false;
		}

		$pagination = array(
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

		$pagination_links = paginate_links($pagination);

		if ($pagination_links != null) {
			echo '<div class="pagination-box clearfix">';
			echo balancetags($pagination_links);
			echo '</div>';
		}
	}

	public function mana_booking_register_scripts($hook)
	{
		wp_enqueue_style('mana-booking-admin-css', MANA_BOOKING_CSS_PATH . 'admin.build.css');
		wp_enqueue_style('jquery-ui-custom', MANA_BOOKING_CSS_PATH . 'jquery-ui.min.css');

		wp_enqueue_style('tinymce_stylesheet');
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_script('jquery-ui-tabs');

		wp_enqueue_script('mana-booking-admin-js', MANA_BOOKING_JS_PATH . 'admin.build.js', array('jquery'), MANA_BOOKING_VERSION, true);
		$admin_js_var_array = array(
			'ajaxurl'      => esc_url(admin_url('admin-ajax.php')),
			'rest_url'      => esc_url(get_rest_url(null, 'wp/v2/')),
			'plg_base'     => MANA_BOOKING_BASE_URL,
			'delete_alert' => esc_html__('Are you sure you want to delete this item?', 'mana-booking'),
		);

		if (defined('ICL_LANGUAGE_CODE')) {
			$admin_js_var_array['lang'] = ICL_LANGUAGE_CODE;
		}
		wp_localize_script('mana-booking-admin-js', 'mana_booking', $admin_js_var_array);
	}

	public function mana_booking_register_scripts_front()
	{
		global $wp;
		$booking_process       = new Mana_booking_booking_process();
		$currency_info_obj     = new Mana_booking_currency();
		$currency_info         = $currency_info_obj->get_current_currency();
		$mana_booking_options = get_option('mana-booking-setting');

		if ($booking_process->is_booking()) {
			wp_enqueue_script('angularjs', MANA_BOOKING_JS_PATH . 'angular.min.js', array('jquery'), MANA_BOOKING_VERSION, true);
			wp_enqueue_script('angularjs-sanitize', MANA_BOOKING_JS_PATH . 'angular-sanitize.min.js', array('angularjs'), MANA_BOOKING_VERSION, true);
			wp_enqueue_script('angularjs-route', MANA_BOOKING_JS_PATH . 'angular-route.min.js', array('angularjs'), MANA_BOOKING_VERSION, true);

			require_once 'tpl/booking-steps/booking_variables.php';

			$mana_booking_variables['asset_url'] = MANA_BOOKING_IMG_PATH;

			if (defined('ICL_LANGUAGE_CODE')) {
				$mana_booking_variables['lang'] = ICL_LANGUAGE_CODE;
				$condition_page_url              = !empty($mana_booking_options['condition_url'][ICL_LANGUAGE_CODE]) ? esc_url($mana_booking_options['condition_url'][ICL_LANGUAGE_CODE]) : '#';
			} else {
				$condition_page_url = !empty($mana_booking_options['condition_url']) ? esc_url($mana_booking_options['condition_url']) : '#';
			}

			if (!empty($mana_booking_options['room_base_price'])) {
				$mana_booking_variables['room_base'] = true;
			}

			// $theme_current_locale = 'en';

			// if (get_locale() !== 'en_US') {
			// 	if (file_exists(COLOSSEUM_THEMEROOT . '/assets/js/locales/locales.php')) {
			// 		require COLOSSEUM_THEMEROOT . '/assets/js/locales/locales.php';
			// 	}

			// 	isset($theme_locales[get_locale()]) ? $theme_current_locale = $theme_locales[get_locale()] : '';

			// 	wp_enqueue_script('bootstrap-datepicker-locale-js', COLOSSEUM_JS_PATH . 'locales/' . $theme_current_locale . '.min.js', array(
			// 		'jquery',
			// 		'colosseum-helper-js',
			// 	), get_bloginfo('version'), true);
			// }

			// $mana_booking_variables['datePickerLang'] = $theme_current_locale;

			/**
			 * ------------------------------------------------------------------------------------------
			 *  Paymill Codes
			 * ------------------------------------------------------------------------------------------
			 */

			if (!empty($mana_booking_options['paymill_booking'])) {
				wp_enqueue_script('paymill-js-code', '//bridge.paymill.com', '', MANA_BOOKING_VERSION, true);
			}

			/**
			 * ------------------------------------------------------------------------------------------
			 *  Stripe Codes
			 * ------------------------------------------------------------------------------------------
			 */

			if (!empty($mana_booking_options['stripe_booking'])) {
				wp_enqueue_script('stripe-js-code', '//js.stripe.com/v3/', '', MANA_BOOKING_VERSION, true);
			}

			wp_enqueue_script('mana-booking-angular-app', MANA_BOOKING_JS_PATH . 'app.min.js', array('angularjs'), MANA_BOOKING_VERSION, true);

			if ($_POST) {
				$package_id = !empty($_POST['package-id']) ? intval($_POST['package-id']) : '';

				if (!empty($package_id)) {
					$mana_booking_variables['package_id'] = $package_id;
				} else {
					$check_in        = !empty($_POST['start']) ? sanitize_text_field($_POST['start']) : '';
					$check_out       = !empty($_POST['end']) ? sanitize_text_field($_POST['end']) : '';
					$room_count      = !empty($_POST['room-count']) ? intval($_POST['room-count']) : '';
					$rooms           = !empty($_POST['room']) ? $_POST['room'] : '';
					$date_diff       = strtotime($check_out) - strtotime($check_in);
					$duration        = ($date_diff / 86400);
					$weekend_counter = 0;

					for ($i = 0; $i < $duration; $i++) {
						$current_day = strtotime($check_in) + (86400 * $i);

						if (date('N', $current_day) >= 6) {
							$weekend_counter++;
						}
					}

					$mana_booking_variables['booking_check_in']   = $check_in;
					$mana_booking_variables['booking_check_out']  = $check_out;
					$mana_booking_variables['booking_room_count'] = $room_count;
					$mana_booking_variables['booking_rooms']      = $rooms;
					$mana_booking_variables['booking_duration']   = $duration;
					$mana_booking_variables['booking_weekends']   = $weekend_counter;
				}
			}

			$current_user_info                  = wp_get_current_user();
			$current_user_meta_info             = get_user_meta($current_user_info->ID);
			$mana_booking_variables['user_id'] = $current_user_info->ID;

			if (!empty($current_user_meta_info['membership'])) {
				$mana_booking_variables['user_membership'] = unserialize($current_user_meta_info['membership'][0]);
			}

			$mana_booking_variables['security']         = wp_create_nonce('mana-booking-security-str');
			$mana_booking_variables['coupon_security']  = wp_create_nonce('coupon-security-item');
			$mana_booking_variables['currency_info']    = $currency_info;
			$currency_separator_val                      = !empty($mana_booking_options['currency_separator']) ? intval($mana_booking_options['currency_separator']) : 1;
			$mana_booking_variables['currency_decimal'] = !empty($mana_booking_options['currency_decimal']) ? intval($mana_booking_options['currency_decimal']) : 2;
			$currency_decimal_separator_val              = !empty($mana_booking_options['currency_decimal_separator']) ? intval($mana_booking_options['currency_decimal_separator']) : 1;

			switch ($currency_separator_val) {
				case 1:
					$mana_booking_variables['currency_separator'] = ',';
					break;
				case 2:
					$mana_booking_variables['currency_separator'] = '.';
					break;
				case 3:
					$mana_booking_variables['currency_separator'] = ' ';
					break;
			}

			switch ($currency_decimal_separator_val) {
				case 1:
					$mana_booking_variables['currency_decimal_separator'] = '.';
					break;
				case 2:
					$mana_booking_variables['currency_decimal_separator'] = ',';
					break;
			}

			if (is_user_logged_in()) {
				$mana_booking_variables['current_user_info']['id']           = $current_user_info->ID;
				$mana_booking_variables['current_user_info']['display_name'] = $current_user_info->display_name;
				$mana_booking_variables['current_user_info']['user_login']   = $current_user_info->user_login;
				$mana_booking_variables['current_user_info']['user_email']   = $current_user_info->user_email;
				$mana_booking_variables['current_user_info']['nickname']     = $current_user_meta_info['nickname'][0];
				$mana_booking_variables['current_user_info']['first_name']   = $current_user_meta_info['first_name'][0];
				$mana_booking_variables['current_user_info']['last_name']    = $current_user_meta_info['last_name'][0];
				$mana_booking_variables['current_user_info']['phone']        = $current_user_meta_info['phone'][0];
				$mana_booking_variables['current_user_info']['address']      = $current_user_meta_info['address'][0];
			}

			$mana_booking_variables['user_vat']               = !empty($mana_booking_options['vat']) ? esc_html($mana_booking_options['vat']) : 0;
			$mana_booking_variables['deposit_status']         = !empty($mana_booking_options['deposit_status']) ? esc_html($mana_booking_options['deposit_status']) : '';
			$mana_booking_variables['user_deposit']           = !empty($mana_booking_options['deposit']) ? esc_html($mana_booking_options['deposit']) : 20;
			$mana_booking_variables['email_booking']          = !empty($mana_booking_options['email_booking']) ? esc_html($mana_booking_options['email_booking']) : '';
			$mana_booking_variables['condition_text']         = sprintf(__('I have read and accept the <a href="%s">terms and conditions</a>', 'mana-booking'), esc_url($condition_page_url));
			$mana_booking_variables['paypal_booking']         = !empty($mana_booking_options['paypal_booking']) ? esc_html($mana_booking_options['paypal_booking']) : '';
			$mana_booking_variables['paymill_booking']        = !empty($mana_booking_options['paymill_booking']) ? esc_html($mana_booking_options['paymill_booking']) : '';
			$mana_booking_variables['stripe_booking']         = !empty($mana_booking_options['stripe_booking']) ? esc_html($mana_booking_options['stripe_booking']) : '';
			$mana_booking_variables['final_booking_title']    = !empty($mana_booking_options['final_booking_title']) ? esc_html($mana_booking_options['final_booking_title']) : esc_html__('Reservation Complete', 'mana-booking');
			$mana_booking_variables['final_booking_subtitle'] = !empty($mana_booking_options['final_booking_subtitle']) ? esc_html($mana_booking_options['final_booking_subtitle']) : esc_html__('Details of your reservation request was sent to your email', 'mana-booking');
			$mana_booking_variables['final_booking_desc']     = !empty($mana_booking_options['final_booking_desc']) ? esc_html($mana_booking_options['final_booking_desc']) : sprintf(__('For more information you can contact us via <a href="%s">contact form</a> of website', 'mana-booking'), !empty($mana_booking_options['contact_url']) ? esc_url($mana_booking_options['contact_url']) : '#');

			// Enable Services in Booking Process
			$services_args  = array(
				'post_type'      => 'service',
				'post_status'    => 'publish',
				'order'          => 'DESC',
				'orderby'        => 'date',
				'posts_per_page' => -1,
				'meta_query'     => array(
					array(
						'key'   => 'mana_booking_service_booking',
						'value' => 'on',
					),
				),
			);
			$services_query = new WP_Query($services_args);

			if ($services_query->have_posts()) {
				$mana_booking_variables['booking_service'] = true;
			}

			wp_localize_script('mana-booking-angular-app', 'booking_app', $mana_booking_variables);
			wp_reset_postdata();
		}

		wp_enqueue_script('mana-booking-front-js', MANA_BOOKING_JS_PATH . 'front.min.js', array('jquery'), MANA_BOOKING_VERSION, true);
		wp_localize_script('mana-booking-front-js', 'mana_booking_front', array(
			'ajaxurl'     => esc_url(admin_url('admin-ajax.php')),
			'redirecturl' => esc_url(home_url($wp->request)),
			'plg_base'    => MANA_BOOKING_BASE_URL,
		));

		wp_enqueue_style('mana-booking-front-style', MANA_BOOKING_CSS_PATH . 'styles.css');
	}

	public function mana_booking_init_meta_boxes()
	{
		/**
		 * ------------------------------------------------------------------------------------------
		 *  Post Meta Boxes
		 * ------------------------------------------------------------------------------------------
		 */
		$post_meta_box_prefix = 'mana_booking_post_';
		$post_meta_box_title  = esc_html__('Post Setting', 'mana-booking');
		$post_meta_box_items  = array(
			array(
				'label' => esc_html__('Subtitle', 'mana-booking'),
				'desc'  => esc_html__('Add subtitle of the post in this field.', 'mana-booking'),
				'id'    => $post_meta_box_prefix . 'subtitle',
				'type'  => 'text',
			),
		);
		$posts_meta_box_obj   = new Mana_booking_meta_boxes($post_meta_box_items, $post_meta_box_prefix, $post_meta_box_title, 'post');

		/**
		 * ------------------------------------------------------------------------------------------
		 *  Pages Meta Boxes
		 * ------------------------------------------------------------------------------------------
		 */
		$page_meta_box_prefix = 'mana_booking_page_';
		$page_meta_box_title  = esc_html__('Page Setting', 'mana-booking');
		$page_meta_box_items  = array(
			array(
				'label' => esc_html__('Subtitle', 'mana-booking'),
				'desc'  => esc_html__('Add subtitle of the page in this field.', 'mana-booking'),
				'id'    => $page_meta_box_prefix . 'subtitle',
				'type'  => 'text',
			),
			array(
				'label' => esc_html__('Page ID', 'mana-booking'),
				'desc'  => __('Add your custom ID for using it to change the default style. List of the default page IDs are <a href="#" target="_blank">here</a>', 'mana-booking'),
				'id'    => $page_meta_box_prefix . 'id',
				'type'  => 'text',
			),
			array(
				'label' => esc_html__('Page Class', 'mana-booking'),
				'desc'  => __('Add your custom class for using it to change the default style. List of the default page classes are <a href="#" target="_blank">here</a>', 'mana-booking'),
				'id'    => $page_meta_box_prefix . 'class',
				'type'  => 'text',
			),
			array(
				'label' => esc_html__('Wide View', 'mana-booking'),
				'desc'  => esc_html__('If you want to have wide view in this page, please turn this switch on.', 'mana-booking'),
				'id'    => $page_meta_box_prefix . 'page_layout',
				'type'  => 'switch',
			),
			array(
				'label'   => esc_html__('Breadcrumb Section', 'mana-booking'),
				'desc'    => esc_html__('If you want to have breadcrumb in this page, please turn this switch on.', 'mana-booking'),
				'id'      => $page_meta_box_prefix . 'breadcrumb_section',
				'type'    => 'switch',
				'default' => 'on',
			),
			array(
				'label' => esc_html__('Page Breadcrumb Background', 'mana-booking'),
				'desc'  => esc_html__('Upload your desired image as page\'s breadcrumb. Please note that your image will be shown if you have turned on the "Breadcrumb Section" option.', 'mana-booking'),
				'id'    => $page_meta_box_prefix . 'bread_crumb',
				'type'  => 'image',
			),
			array(
				'label' => esc_html__('Page Breadcrumb Height', 'mana-booking'),
				'desc'  => esc_html__('Set the height of breadcrumb in this field. Default value of it is 520px, leave it blank if you want to use default value.', 'mana-booking'),
				'id'    => $page_meta_box_prefix . 'bread_crumb_height',
				'type'  => 'number',
			),
			array(
				'label' => esc_html__('Page Breadcrumb Text', 'mana-booking'),
				'desc'  => esc_html__('If you want to have text below the title box, add it here.', 'mana-booking'),
				'id'    => $page_meta_box_prefix . 'bread_crumb_text',
				'type'  => 'textarea',
			),
		);
		$pages_meta_box_obj   = new Mana_booking_meta_boxes($page_meta_box_items, $page_meta_box_prefix, $page_meta_box_title, 'page');

		/**
		 * ------------------------------------------------------------------------------------------
		 *  Block Dates Meta Boxes
		 * ------------------------------------------------------------------------------------------
		 */
		$block_dates_meta_box_prefix = 'mana_booking_block_dates_';
		$block_dates_meta_box_title  = esc_html__('Block Dates Information', 'mana-booking');
		$block_dates_meta_box_items  = array(
			array(
				'id'    => $block_dates_meta_box_prefix . 'meta_info',
				'type'  => 'block_date_settings',
			)
		);
		$block_dates_meta_box_obj    = new Mana_booking_meta_boxes($block_dates_meta_box_items, $block_dates_meta_box_prefix, $block_dates_meta_box_title, 'block_dates');

		/**
		 * ------------------------------------------------------------------------------------------
		 *  Room Meta Boxes
		 * ------------------------------------------------------------------------------------------
		 */
		$room_meta_box_prefix = 'mana_booking_room_';
		$room_meta_box_title  = esc_html__('Room Extra information', 'mana-booking');
		$room_meta_box_items  = array(
			array(
				'id'    => $room_meta_box_prefix . 'meta_info',
				'type'  => 'room_settings',
			)
		);
		$rooms_meta_box_obj   = new Mana_booking_meta_boxes($room_meta_box_items, $room_meta_box_prefix, $room_meta_box_title, 'rooms');

		/**
		 * ------------------------------------------------------------------------------------------
		 *  Room Booking Overview Meta Boxes
		 * ------------------------------------------------------------------------------------------
		 */
		$room_booking_overview_meta_box_prefix = 'mana_booking_room_booking_overview_';
		$room_booking_overview_meta_box_title  = esc_html__('Booking Overview', 'mana-booking');
		$room_booking_overview_meta_box_items  = array(
			array(
				'id'   => $room_booking_overview_meta_box_prefix . 'rating',
				'type' => 'overview_calendar',
			),
		);
		$room_booking_overview_meta_box_obj    = new Mana_booking_meta_boxes($room_booking_overview_meta_box_items, $room_booking_overview_meta_box_prefix, $room_booking_overview_meta_box_title, 'rooms');

		/**
		 * ------------------------------------------------------------------------------------------
		 *  Services Meta Boxes
		 * ------------------------------------------------------------------------------------------
		 */
		$service_meta_box_prefix = 'mana_booking_service_';
		$service_meta_box_title  = esc_html__('Additional Settings', 'mana-booking');
		$service_meta_box_items  = array(
			array(
				'label'   => esc_html__('Load in Shortcode', 'mana-booking'),
				'desc'    => esc_html__('Enable this field if you want this service loads in [mana-booking-services] shortcode.', 'mana-booking'),
				'id'      => $service_meta_box_prefix . 'shortcode',
				'type'    => 'switch',
				'default' => true,
			),
			array(
				'label' => esc_html__('Load in Booking Process', 'mana-booking'),
				'desc'  => esc_html__('Enable this field if you want this service loads in booking process that users can select it as extra services.', 'mana-booking'),
				'id'    => $service_meta_box_prefix . 'booking',
				'type'  => 'switch',
			),
			array(
				'label'    => esc_html__('Price Type', 'mana-booking'),
				'desc'     => esc_html__('Select if this service is free or paid.', 'mana-booking'),
				'id'       => $service_meta_box_prefix . 'price_type',
				'type'     => 'select',
				'tr_class' => 'price-type',
				'options'  => array(
					1 => esc_html__('Free', 'mana-booking'),
					2 => esc_html__('Paid', 'mana-booking'),
				),
			),
			array(
				'label'    => esc_html__('Price', 'mana-booking'),
				'desc'     => esc_html__('Add price details for your service', 'mana-booking'),
				'id'       => $service_meta_box_prefix . 'price',
				'type'     => 'service_price',
				'tr_class' => 'paid-service',
			),
			array(
				'label'    => esc_html__('Mandatory', 'mana-booking'),
				'desc'     => esc_html__('Enable this field if you want this service will un-selectable by user during the booking process. It always will be checked.', 'mana-booking'),
				'id'       => $service_meta_box_prefix . 'mandatory',
				'type'     => 'switch',
				'tr_class' => 'price-type',
			),
		);
		$service_meta_box_obj    = new Mana_booking_meta_boxes($service_meta_box_items, $service_meta_box_prefix, $service_meta_box_title, 'service');

		/**
		 * ------------------------------------------------------------------------------------------
		 *  Coupon Meta Boxes
		 * ------------------------------------------------------------------------------------------
		 */
		$coupon_meta_box_prefix = 'mana_booking_coupon_';
		$coupon_meta_box_title  = esc_html__('Additional Settings', 'mana-booking');
		$coupon_meta_box_items  = array(
			array(
				'id'   => $coupon_meta_box_prefix . 'meta_info',
				'type' => 'coupon_settings',
			),
		);
		$coupon_meta_box_obj    = new Mana_booking_meta_boxes($coupon_meta_box_items, $coupon_meta_box_prefix, $coupon_meta_box_title, 'coupon');
	}

	public function mana_booking_menu_items()
	{
		add_menu_page(esc_html__('Mana Booking', 'mana-booking'), esc_html__('Mana Booking', 'mana-booking'), 'manage_options', 'mana-booking-setting', array(
			$this,
			'mana_booking_setting_page',
		), 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDEuMSBUaW55Ly9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLXRpbnkuZHRkIiBbPCFFTlRJVFkgbnNfZmxvd3MgImh0dHA6Ly9ucy5hZG9iZS5jb20vRmxvd3MvMS4wLyI+XT48c3ZnIHZlcnNpb249IjEuMSIgYmFzZVByb2ZpbGU9InRpbnkiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbG5zOmE9Imh0dHA6Ly9ucy5hZG9iZS5jb20vQWRvYmVTVkdWaWV3ZXJFeHRlbnNpb25zLzMuMC8iIHg9IjBweCIgeT0iMHB4IiB3aWR0aD0iMTA3cHgiIGhlaWdodD0iOTNweCIgdmlld0JveD0iLTAuNDgzODg2NyAtMC4xOTMzNTk0IDEwNyA5MyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+PGRlZnM+PC9kZWZzPjxwYXRoIGZpbGw9IiMwMTAxMDEiIGQ9Ik0xMDYuMzMwNTY2NCwwSDB2OTEuOTk3MDcwM2gxMDYuMzMwNTY2NFYweiBNMTAxLjcwMTY2MDIsODcuMjg1MTU2M0g0LjYxOTE0MDZWNC42MjQwMjM0aDk3LjA4MjUxOTVWODcuMjg1MTU2M3oiLz48cGF0aCBmaWxsPSIjMDEwMTAxIiBkPSJNMTcuNzQ5MDIzNCw2OS40Mzg0NzY2bC0wLjA5MDMzMiw3LjIxNjc5NjljNi42NTUyNzM0LTAuMzc1OTc2NiwzMS4zNDUyMTQ4LTAuMzc1OTc2NiwzOC42NTIzNDM4LDBsLTAuMTg1NTQ2OS03LjExOTE0MDZjLTEwLjgxNTQyOTcsMC4yNzM0Mzc1LTkuNzk5ODA0Ny0yLjA0MTAxNTYtOS43OTk4MDQ3LTUuMjczNDM3NVY1MC4wMjQ0MTQxbDEzLjQwMzMyMDMsMTUuNTI3MzQzOGMyLjU4Nzg5MDYsMi45Njg3NSw0LjcyMTY3OTcsNi42NjAxNTYzLDcuMzA0Njg3NSwxMC45MTc5Njg4YzI0LjY4NzUsMCwyNy43MzQzNzUsMC4xODU1NDY5LDI3LjczNDM3NSwwLjE4NTU0Njl2LTYuOTM4NDc2NkM4Ni44MjM3MzA1LDY4Ljk3OTQ5MjIsODUuNTI0OTAyMyw2OC4yMzczMDQ3LDgyLjc1NjM0NzcsNjVsLTE3LjEwOTM3NS0yMC4wNTg1OTM4YzEwLjYzNDc2NTYtMS4yOTg4MjgxLDE3LjI5NDkyMTktNi44NDU3MDMxLDE3LjE5NzI2NTYtMTUuODE1NDI5N0M4Mi43NTYzNDc3LDEzLjQwODIwMzEsNjguNDI1MjkzLDE0LjA1MjczNDQsNTMuMjU5Mjc3MywxMy43NzkyOTY5Yy01LjA4NTQ0OTItMC4wOTc2NTYzLTI5LjEyMzUzNTIsMC4wODc4OTA2LTM1LjYwMDU4NTksMC4wODc4OTA2bDAuMDkwMzMyLDcuMjExOTE0MWM5Ljg5NTAxOTUsMCw5LjA2NDk0MTQsMC45MjI4NTE2LDkuMDY0OTQxNCw0LjgwOTU3MDN2MzguMzc0MDIzNEMyNi44MTM5NjQ4LDY2Ljc1NzgxMjUsMjguMTA1NDY4OCw3MC4xODA2NjQxLDE3Ljc0OTAyMzQsNjkuNDM4NDc2NnogTTQ2LjMyNTY4MzYsMjEuNjQwNjI1YzEuNDc0NjA5NC0wLjA5NzY1NjMsMi43NzM0Mzc1LTAuMjgzMjAzMSw0LjE1NzcxNDgtMC4yODMyMDMxYzcuMzAyMjQ2MSwwLDExLjkyNjI2OTUsMi43NzgzMjAzLDExLjkyNjI2OTUsOC43ODkwNjI1aC0wLjA5Mjc3MzRjMC4wOTI3NzM0LDguMjIyNjU2My02Ljg0NTcwMzEsMTAuNjM0NzY1Ni0xNS45OTEyMTA5LDEwLjkwODIwMzFWMjEuNjQwNjI1eiIvPjwvc3ZnPg==');
		add_submenu_page('mana-booking-setting', esc_html__('Booking Archive', 'mana-booking'), esc_html__('Booking Archive', 'mana-booking'), 'manage_options', 'mana-booking-archive', array(
			$this,
			'mana_booking_archive',
		));
		add_submenu_page('mana-booking-setting', esc_html__('Booking Overview', 'mana-booking'), esc_html__('Booking Overview', 'mana-booking'), 'manage_options', 'mana-booking-overview', array(
			$this,
			'mana_booking_overview',
		));
		add_submenu_page('mana-booking-setting', esc_html__('Payment Archive', 'mana-booking'), esc_html__('Payment Archive', 'mana-booking'), 'manage_options', 'mana-payment-archive', array(
			$this,
			'mana_payment_archive',
		));
	}

	public function mana_booking_setting_page()
	{
		require_once MANA_BOOKING_TPL . 'admin/admin.php';
	}

	public function mana_booking_archive()
	{
		require_once MANA_BOOKING_TPL . 'admin/booking.php';
	}

	public function mana_payment_archive()
	{
		require_once MANA_BOOKING_TPL . 'admin/payment.php';
	}

	public function mana_booking_overview()
	{
		wp_enqueue_script('moment-js', MANA_BOOKING_ASSETS_LIBS . '/js/moment.min.js', array('jquery'), MANA_BOOKING_VERSION, true);
		wp_enqueue_script('fullcalendar-js', MANA_BOOKING_ASSETS_LIBS . '/js/fullcalendar.min.js', array(
			'jquery',
			'moment-js',
		), MANA_BOOKING_VERSION, true);
		$web_current_locale = 'en';

		if (get_locale() !== 'en_US') {
			if (file_exists(MANA_BOOKING_PATH . '/assets/js/locales.php')) {
				require MANA_BOOKING_PATH . '/assets/js/locales.php';
			}

			$web_current_locale = isset($plugin_locales[get_locale()]) ? $plugin_locales[get_locale()] : 'en';
			wp_enqueue_script('fullcalendar-locales-js', MANA_BOOKING_ASSETS_LIBS . '/js/locale/' . $web_current_locale . '.js', array('jquery'), MANA_BOOKING_VERSION, true);
		}

		$inline_locale_script = '
                    jQuery(document).ready(function ($) {
                        jQuery(\'#calendar\').fullCalendar({
                            locale:        \'' . esc_js($web_current_locale) . '\',
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
                                            url:      mana_booking.ajaxurl,
                                            dataType: \'json\',
                                            method:   \'post\',
                                            data:     {
                                                action: "mana_booking_booking_overview",
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

		if (get_locale() !== 'en_US') {
			wp_add_inline_script('fullcalendar-locales-js', $inline_locale_script);
		} else {
			wp_add_inline_script('fullcalendar-js', $inline_locale_script);
		}

		require_once MANA_BOOKING_TPL . 'admin/overview.php';
	}

	public function mana_booking_init_setting_page()
	{
		register_setting('mana-booking-setting', 'mana-booking-setting', array(
			$this,
			'mana_booking_sanitize_options',
		));
	}

	public function mana_booking_sanitize_options($data)
	{
		$new_data     = array();
		$int_fields   = array(
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
		$text_fields  = array(
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
		$html_fields  = array('email_admin_tmpl', 'email_user_tmpl');
		$email_fields = array('email_sender', 'email_receiver', 'paypal_email', 'wp_email_sender');
		$url_fields   = array('condition_url', 'paypal_action_url', 'contact_url', 'external_booking_url');

		foreach ($data as $index => $field) {
			if (in_array($index, $email_fields)) {
				if ($index !== 'email_receiver') {
					$new_data[$index] = filter_var($field, FILTER_SANITIZE_EMAIL);
				} else {
					foreach ($field as $receiver_index => $receiver_email) {
						$new_data[$index][$receiver_index] = filter_var($receiver_email, FILTER_SANITIZE_EMAIL);
					}
				}
			}

			if (in_array($index, $text_fields)) {
				if ($index === 'rating_item') {
					foreach ($field as $item_index => $item_value) {
						$new_data[$index][$item_index] = filter_var($item_value, FILTER_SANITIZE_STRING);
					}
				} else {
					$new_data[$index] = filter_var($field, FILTER_SANITIZE_STRING);
				}
			}

			if (in_array($index, $html_fields)) {
				$new_data[$index] = wp_kses_post($field);
			}

			if (in_array($index, $url_fields)) {
				$new_data[$index] = filter_var($field, FILTER_SANITIZE_URL);
			}

			if (in_array($index, $int_fields)) {
				$new_data[$index] = filter_var($field, FILTER_SANITIZE_NUMBER_INT);
			}

			if ($index === 'currency') {
				foreach ($field as $curr_index => $curr_val) {
					if (!empty($curr_val['title']) || !empty($curr_val['symbol']) || !empty($curr_val['position'])) {
						$new_data[$index][$curr_index]['title']  = filter_var($curr_val['title'], FILTER_SANITIZE_STRING);
						$new_data[$index][$curr_index]['symbol'] = filter_var($curr_val['symbol'], FILTER_SANITIZE_STRING);
						$new_data[$index][$curr_index]['rate']   = filter_var($curr_val['rate'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

						if (!empty($curr_val['position'])) {
							$new_data[$index][$curr_index]['position'] = filter_var($curr_val['position'], FILTER_SANITIZE_NUMBER_INT);
						}
					}
				}
			}

			if ($index === 'social_icons') {
				foreach ($field as $social_index => $social_val) {
					$new_data[$index][$social_index] = filter_var($social_val, FILTER_SANITIZE_STRING);
				}
			}

			if ($index === 'client') {
				foreach ($field as $client_index => $client_val) {
					if (!empty($client_val['title']) || !empty($client_val['url']) || !empty($client_val['logo'])) {
						$new_data[$index][$client_index]['title'] = filter_var($client_val['title'], FILTER_SANITIZE_STRING);
						$new_data[$index][$client_index]['url']   = filter_var($client_val['url'], FILTER_SANITIZE_URL);
						$new_data[$index][$client_index]['logo']  = filter_var($client_val['logo'], FILTER_SANITIZE_NUMBER_INT);
					}
				}
			}

			if ($index === 'membership') {
				foreach ($field as $membership_index => $membership_val) {
					if (!empty($membership_val['title']) || !empty($membership_val['badge']) || !empty($membership_val['condition']) || !empty($membership_val['discount'])) {
						$new_data[$index][$membership_index]['title']                  = filter_var($membership_val['title'], FILTER_SANITIZE_STRING);
						$new_data[$index][$membership_index]['badge']                  = filter_var($membership_val['badge'], FILTER_SANITIZE_NUMBER_INT);
						$new_data[$index][$membership_index]['condition']              = filter_var($membership_val['condition'], FILTER_SANITIZE_NUMBER_INT);
						$new_data[$index][$membership_index]['single-condition-price'] = filter_var($membership_val['single-condition-price'], FILTER_SANITIZE_NUMBER_INT);
						$new_data[$index][$membership_index]['single-condition-item']  = filter_var($membership_val['single-condition-item'], FILTER_SANITIZE_NUMBER_INT);
						$new_data[$index][$membership_index]['condition-price']        = filter_var($membership_val['condition-price'], FILTER_SANITIZE_NUMBER_INT);
						$new_data[$index][$membership_index]['condition-item']         = filter_var($membership_val['condition-item'], FILTER_SANITIZE_NUMBER_INT);
						$new_data[$index][$membership_index]['condition-type']         = filter_var($membership_val['condition-type'], FILTER_SANITIZE_NUMBER_INT);
						$new_data[$index][$membership_index]['discount']               = filter_var($membership_val['discount'], FILTER_SANITIZE_NUMBER_INT);
					}
				}
			}

			if ($index === 'seasonal_price') {
				foreach ($field as $season_index => $season_val) {
					if (!empty($season_val['title']) || !empty($season_val['from']) || !empty($season_val['to']) || !empty($season_val['type']) || !empty($season_val['percent'])) {
						$new_data[$index][$season_index]['title']   = filter_var($season_val['title'], FILTER_SANITIZE_STRING);
						$new_data[$index][$season_index]['type']    = filter_var($season_val['type'], FILTER_SANITIZE_NUMBER_INT);
						$new_data[$index][$season_index]['from']    = filter_var($season_val['from'], FILTER_SANITIZE_STRING);
						$new_data[$index][$season_index]['to']      = filter_var($season_val['to'], FILTER_SANITIZE_STRING);
						$new_data[$index][$season_index]['percent'] = filter_var($season_val['percent'], FILTER_SANITIZE_NUMBER_INT);
					}
				}
			}

			if (function_exists('icl_get_languages') && $index === 'condition_url') {
				foreach ($field as $lang => $url) {
					$new_data[$index][$lang] = filter_var($url, FILTER_SANITIZE_URL);
				}
			}
		}

		return $new_data;
	}

	public function mana_booking_import_options()
	{
		global $wpdb;
		$imported_raw_obj = json_decode(stripcslashes($_POST['options']));

		if (!empty($imported_raw_obj)) {
			$imported_raw_array        = array();
			$imported_raw_array        = self::mana_booking_objToArray($imported_raw_obj, $imported_raw_array);
			$imported_serilized_option = serialize($imported_raw_array);
			$result                    = $wpdb->get_results("SELECT * FROM  $wpdb->options WHERE option_name = 'mana-booking-setting'");

			if ($result) {
				$wpdb->update($wpdb->options, array(
					'option_value' => $imported_serilized_option,
				), array('option_name' => 'mana-booking-setting'), array(
					'%s',
				), array('%s'));
			} else {
				$wpdb->insert($wpdb->options, array(
					'option_value' => $imported_serilized_option,
					'option_name'  => 'mana-booking-setting',
				), array(
					'%s',
					'%s',
				));
			}

			$result['status']  = true;
			$result['message'] = esc_html__('Your options was imported correctly.', 'mana-booking');
		} else {
			$result['status']  = false;
			$result['message'] = esc_html__('Your imported data does not have valid format. It must be JSON code.', 'mana-booking');
		}

		echo json_encode($result);
		die();
	}

	public function mana_booking_objToArray($obj, &$arr)
	{
		if (!is_object($obj) && !is_array($obj)) {
			$arr = $obj;

			return $arr;
		}

		foreach ($obj as $key => $value) {
			if (!empty($value)) {
				$arr[$key] = array();
				self::mana_booking_objToArray($value, $arr[$key]);
			} else {
				$arr[$key] = $value;
			}
		}

		return $arr;
	}
}

$mana_booking_obj = new Mana_booking_main;
