<?php

class Mana_booking_meta_boxes
{
	/**
	 * Array of meta data list for the events
	 * @var array
	 */
	public $meta_box_fields = array();
	public $meta_box_title;
	public $meta_box_post_type;
	public $meta_box_context;
	public $meta_box_priority;
	public $meta_box_prefix;

	function __construct($meta_items, $prefix, $title, $post_type, $context = 'normal', $priority = 'high')
	{
		Mana_booking_main::mana_load_plugin_text_domain();
		$this->meta_box_fields    = $meta_items;
		$this->meta_box_title     = $title;
		$this->meta_box_post_type = $post_type;
		$this->meta_box_context   = $context;
		$this->meta_box_priority  = $priority;
		$this->meta_box_prefix    = $prefix;
		add_action('add_meta_boxes', array($this, 'add_meta_box'));
		add_action('save_post', array($this, 'save_meta_box'));
	}

	// Add the Meta Box
	function add_meta_box()
	{
		add_meta_box(
			$this->meta_box_prefix . $this->meta_box_post_type . '_meta_box', // ID
			$this->meta_box_title, // Title
			array($this, 'show_meta_box'), // Callback
			$this->meta_box_post_type, // Post Type
			$this->meta_box_context, // Context
			$this->meta_box_priority // Priority
		);
	}

	// Show the Fields in the Post Type section
	function show_meta_box($post)
	{
		global $post, $wpdb;

		// Use nonce for verification
		echo '<input type="hidden" name="' . $this->meta_box_post_type . '_meta_box_nonce" value="' . esc_attr(wp_create_nonce(basename(__FILE__))) . '" />';


		// Begin the field table and loop
		echo '<table class="form-table">';

		// Post types with JS meta box generator
		$new_setting_types = array('room_settings', 'block_date_settings', 'coupon_settings', 'service_settings');
		foreach ($this->meta_box_fields as $field) {
			if (in_array($field['type'], $new_setting_types)) {
				$meta = get_post_meta($post->ID, $field['id'], true);
				echo '
						<input type="hidden" name="' . esc_attr($field['id']) . '" id="' . esc_attr($field['id']) . '" value="' . esc_attr($meta) . '" size="40" />
						<div id="mana-' . str_replace('_', '-', $field['type']) . '-info-box"></div>
					';
			} else {
				// get value of this field if it exists for this post
				$meta = get_post_meta($post->ID, $field['id'], true);
				// begin a table row with
				echo '<tr ' . (!empty($field['tr_class']) ? 'class="' . esc_attr($field['tr_class']) . '"' : '') . '>';
				if (!empty($field['label'])) {
					echo '<th>' . esc_html($field['label']) . '</th>';
				}
				echo '<td>';
				switch ($field['type']) {
						// Text
					case 'text':
						echo '<input type="text" name="' . esc_attr($field['id']) . '" id="' . esc_attr($field['id']) . '" value="' . esc_attr($meta) . '" size="40" />
										<br /><span class="description">' . balancetags($field['desc']) . '</span>';
						break;

					case 'hidden':
						echo '<input type="hidden" name="' . esc_attr($field['id']) . '" id="' . esc_attr($field['id']) . '" value="' . esc_attr($meta) . '" size="40" />';
						break;

						// Demo
					case 'demo':
						echo '<input type="text" readonly class="highlighted" name="' . esc_attr($field['id']) . '" id="' . esc_attr($field['id']) . '" value="' . esc_attr($meta) . '" size="40" />
								<br /><span class="description">' . balancetags($field['desc']) . '</span>';
						break;

						// Number
					case 'number':
						echo '<input type="number" min="0" step="any" name="' . esc_attr($field['id']) . '" id="' . esc_attr($field['id']) . '" value="' . esc_attr($meta) . '" size="40" />
										<br /><span class="description">' . balancetags($field['desc']) . '</span>';
						break;

						// Percent
					case 'percent':
						echo '<input type="number" min="0" max="100" step="any" name="' . esc_attr($field['id']) . '" id="' . esc_attr($field['id']) . '" value="' . esc_attr($meta) . '" size="40" />
										<br /><span class="description">' . balancetags($field['desc']) . '</span>';
						break;

						// Email
					case 'email':
						echo '<input type="email" name="' . esc_attr($field['id']) . '" id="' . esc_attr($field['id']) . '" value="' . esc_attr($meta) . '" size="40" />
										<br /><span class="description">' . balancetags($field['desc']) . '</span>';
						break;

						// TextArea
					case 'textarea':
						echo '
							<textarea name="' . esc_attr($field['id']) . '" id="' . esc_attr($field['id']) . '">' . esc_attr($meta) . '</textarea>
										<br /><span class="description">' . balancetags($field['desc']) . '</span>';
						break;

						// Select
					case 'select':
						echo '<select name="' . esc_attr($field['id']) . '" id="' . esc_attr($field['id']) . '">';
						foreach ($field['options'] as $value => $title) {
							echo '<option value="' . esc_attr($value) . '" ' . selected($meta, $value) . '>' . esc_html($title) . '</option>';
						}
						echo '</select>
								<br /><span class="description">' . balancetags($field['desc']) . '</span>';
						break;

						// Price
					case 'id':
						echo '<div class="room-id-box">' . esc_html($post->ID) . '</div>';
						break;
					case 'switch':
						$post_status = get_post_status($post->ID);
						$default     = null;

						if ($post_status === 'auto-draft' && !empty($field['default'])) {
							$default = true;
						} elseif ($meta === 'on') {
							$default = true;
						}
						echo '
								<label class="mana-booking-switch">
									<input name="' . esc_attr($field['id']) . '" id="' . esc_attr($field['id']) . '" ' . checked($default, true, false) . ' type="checkbox">
									<span class="switcher"></span>
								</label>
								<span class="description">' . balancetags($field['desc']) . '</span>';
						break;
					case 'overview_calendar':
						wp_enqueue_script('moment-js', MANA_BOOKING_ASSETS_LIBS . '/js/moment.min.js', array('jquery'), MANA_BOOKING_VERSION, true);
						wp_enqueue_script('fullcalendar-js', MANA_BOOKING_ASSETS_LIBS . '/js/fullcalendar.min.js', array(
							'jquery',
							'moment-js'
						), MANA_BOOKING_VERSION, true);

						$web_current_locale = 'en';
						if (get_locale() !== 'en_US') {
							if (file_exists(MANA_BOOKING_PATH . '/assets/js/locales.php')) {
								require(MANA_BOOKING_PATH . '/assets/js/locales.php');
							}
							$web_current_locale = isset($plugin_locales[get_locale()]) ? $plugin_locales[get_locale()] : 'en';
							wp_enqueue_script('fullcalendar-locales-js', MANA_BOOKING_ASSETS_LIBS . '/js/locale/' . $web_current_locale . '.js', array('jquery'), MANA_BOOKING_VERSION, true);
						}
						$inline_locale_script = '
									jQuery(document).ready(function ($) {
										var roomCalendarContainer = jQuery(\'#room-calendar\');
										roomCalendarContainer.fullCalendar({
											locale:        \'' . esc_js($web_current_locale) . '\',
											eventMouseover: function (event, jsEvent, view) {
												var eventURL = event.url,
													eventTitle = event.title;

												jQuery(\'.fc-event\').each(function (index, el) {
													var eventHref = jQuery(this).attr(\'href\'),
														eventText = jQuery(this).find(\'.fc-title\').text();

													if (eventHref == eventURL && eventText == eventTitle) {
														jQuery(this).addClass(\'hover-event\');
													}
												});
											},
											viewRender:     function (currentView) {
												var minDate = moment();
												if (minDate >= currentView.start && minDate <= currentView.end) {
													jQuery(".fc-prev-button").prop("disabled", true);
													jQuery(".fc-prev-button").addClass("fc-state-disabled");
												}
												else {
													jQuery(".fc-prev-button").removeClass("fc-state-disabled");
													jQuery(".fc-prev-button").prop("disabled", false);
												}
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
															url: mana_booking.ajaxurl,
															dataType: \'json\',
															method:   \'post\',
															data:     {
																action: "mana_booking_room_overview",
																start:  startDate,
																end:    endDate,
																roomID: roomCalendarContainer.data(\'room-id\')
															}
														}).done(function (dataBooking) {
															var events = [];
															jQuery(dataBooking).each(function () {
																events.push({
																	title: jQuery(this).attr(\'title\'),
																	start: jQuery(this).attr(\'start\'),
																	end: jQuery(this).attr(\'end\'),
																	rendering: jQuery(this).attr(\'rendering\'),
																	color: jQuery(this).attr(\'color\')
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

						echo '
								<div id="room-calendar" data-room-id="' . esc_attr($post->ID) . '"></div>
								<div class="room-calendar-day-status-guide">
									<div class="status-box">
										<div class="box not-available"></div>
										<div class="title">' . esc_html__('Not Available', 'mana-booking') . '</div>
									</div>
									<div class="status-box">
										<div class="box available"></div>
										<div class="title">' . esc_html__('Available', 'mana-booking') . '</div>
									</div>
									<div class="status-box">
										<div class="box today">1</div>
										<div class="title">' . esc_html__('Today', 'mana-booking') . '</div>
									</div>
								</div>';
						break;
				} //end switch
				echo '</td></tr>';
			}
		}

		echo '</table>'; // end table
	}

	// Save the Data
	function save_meta_box($post_id)
	{
		$security_code = '';

		if (isset($_POST[$this->meta_box_post_type . '_meta_box_nonce']) && $_POST[$this->meta_box_post_type . '_meta_box_nonce'] != '') {
			$security_code = sanitize_text_field($_POST[$this->meta_box_post_type . '_meta_box_nonce']);
		}

		// verify nonce
		if (!wp_verify_nonce($security_code, basename(__FILE__))) {
			return $post_id;
		}
		// check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}
		if (!current_user_can('edit_post', $post_id)) {
			return $post_id;
		}

		// loop through fields and save the data
		foreach ($this->meta_box_fields as $field) {
			$old = get_post_meta($post_id, $field['id'], true);
			$new = $_POST[$field['id']];
			if ($new && $new != $old) {
				update_post_meta($post_id, $field['id'], $new);
			} elseif ('' == $new && $old) {
				delete_post_meta($post_id, $field['id'], $old);
			}
		} // end foreach
	}
}
