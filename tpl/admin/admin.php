<?php
$options = get_option('mana-booking-setting');
$options_str = wp_json_encode($options);
?>
<div id="mana-booking-main-setting-page">
	<div class="wrap">
		<h1><?php esc_html_e('Mana Booking Settings', 'mana-booking') ?></h1>
		<div class="main-container">
			<form action="options.php" method="post">
				<?php settings_fields('mana-booking-setting'); ?>
				<input type="hidden" name="mana-booking-setting" id="mana_booking_main_setting" value="<?php echo !empty($options_str) ? esc_attr($options_str) : '' ?>" />
			</form>
			<div id="mana-booking-main-setting-container"></div>
		</div>
	</div>
</div>
<div id="mana-booking-setting-page">
	<div class="wrap">
		<h1><?php esc_html_e('Mana Booking Settings', 'mana-booking') ?></h1>
		<div class="main-container">
			<form action="options.php" method="post">
				<?php settings_fields('mana-booking-setting'); ?>
				<div class="col-wrap">
					<div class="content">
						<div id="tabs">
							<div class="tab-content" id="tabs-7">
								<div class="l-col mana-col one-third clearfix">
									<div class="mana-info-box">
										<div class="header">
											<i class="dashicons dashicons-download"></i><?php esc_html_e('Export', 'mana-booking') ?>
										</div>
										<div class="content">
											<textarea id="mana-booking-export-data" disabled><?php echo !empty($options) ? json_encode($options) : ''; ?></textarea>
											<a href="#" class="button button-primary button-large" id="export-mana-booking-setting"><?php esc_html_e('Export as JSON file', 'mana-booking') ?></a>
											<a href="#" class="button button-primary button-large" onclick="copyToClipboard('#mana-booking-export-data')"><?php esc_html_e('Copy to Clipboard', 'mana-booking') ?></a>
										</div>
									</div>
								</div>
								<div class="r-col mana-col one-third pl">
									<div class="mana-info-box">
										<div class="header">
											<i class="dashicons dashicons-upload"></i><?php esc_html_e('Import', 'mana-booking') ?>
										</div>
										<div class="content">
											<textarea id="import-mana-booking-setting-field" placeholder="<?php esc_html_e('Paste the content here.', 'mana-booking') ?>"></textarea>
											<a href="#" class="button button-primary button-large" id="import-mana-booking-setting">
												<i class="dashicons dashicons-update"></i><?php esc_html_e('Import', 'mana-booking') ?>
											</a>
											<span class="message-box red"><?php esc_html_e('WARNING : by importing your data, the current settings will be overwritten.', 'mana-booking') ?></span>
										</div>
									</div>
								</div>
								<div class="r-col mana-col one-third pl">
									<div class="mana-info-box">
										<div class="header">
											<i class="dashicons dashicons-info"></i><?php esc_html_e('Instruction', 'mana-booking') ?>
										</div>
										<div class="content">
											<ol>
												<li class="red"><?php esc_html_e('Please note that after importing your data, the current settings will be overwritten.', 'mana-booking') ?></li>
												<li class="red"><?php esc_html_e('The import section accepts JSON content, so please be sure that your content has correct format.', 'mana-booking') ?></li>
												<li><?php esc_html_e('After downloading the content, you can open the downloaded file with a simple text editor.', 'mana-booking') ?></li>
											</ol>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php submit_button(); ?>
			</form>
		</div>
	</div>
</div>