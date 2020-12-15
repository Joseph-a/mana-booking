<?php
$options = get_option('mana-booking-setting');
$options_str = wp_json_encode($options);
?>
<div id="mana-booking-main-setting-page">
	<div class="wrap">
		<div class="main-h1-box">
			<h1><?php esc_html_e('Mana Booking Settings', 'mana-booking') ?></h1>
			<form action="options.php" method="post" id="mana-options-setting-form">
				<?php settings_fields('mana-booking-setting'); ?>
				<input type="hidden" name="mana-booking-setting[main_setting]" id="mana_booking_main_setting" value="<?php echo !empty($options['main_setting']) ? esc_attr($options['main_setting']) : '0' ?>" />
				<?php submit_button(); ?>
			</form>
		</div>
		<div class="main-container">
			<div id="mana-booking-main-setting-container"></div>
		</div>
	</div>
</div>