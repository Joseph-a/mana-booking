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
				<input type="text" name="mana-booking-setting" value="<?php echo !empty($options_str) ? esc_attr($options_str) : '' ?>" />
			</form>
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
							<div class="tab-title-box">
								<ul>
									<li>
										<a href="#tabs-1"><?php esc_html_e('General', 'mana-booking') ?></a>
									</li>
									<li>
										<a href="#tabs-8"><?php esc_html_e('Booking', 'mana-booking') ?></a>
									</li>
									<li>
										<a href="#tabs-10"><?php esc_html_e('Payment', 'mana-booking') ?></a>
									</li>
									<li>
										<a href="#tabs-2"><?php esc_html_e('Email Notification', 'mana-booking') ?></a>
									</li>
									<li>
										<a href="#tabs-3"><?php esc_html_e('Currency', 'mana-booking') ?></a>
									</li>
									<li>
										<a href="#tabs-9"><?php esc_html_e('Membership', 'mana-booking') ?></a>
									</li>
									<li>
										<a href="#tabs-11"><?php esc_html_e('Seasonal Price', 'mana-booking') ?></a>
									</li>
									<li>
										<a href="#tabs-7"><?php esc_html_e('Export & Import', 'mana-booking') ?></a>
									</li>
								</ul>
								<div class="version"><?php echo esc_html(__('Version : ', 'mana-booking') . MANA_BOOKING_VERSION) ?></div>
							</div>
							<div class="tab-content" id="tabs-1">
								<div class="l-col mana-col two-third clearfix">
									<div class="mana-box">
										<div class="field-rows fields clearfix">
											<div class="row">
												<label><?php esc_html_e('Room Archive Page Layout : ', 'mana-booking') ?></label>
												<select name="mana-booking-setting[archive_page_layout]">
													<option value="1" <?php !empty($options['archive_page_layout']) ? selected($options['archive_page_layout'], '1') : '' ?>><?php esc_html_e('Grid View', 'mana-booking'); ?></option>
													<option value="2" <?php !empty($options['archive_page_layout']) ? selected($options['archive_page_layout'], '2') : '' ?>><?php esc_html_e('List View', 'mana-booking'); ?></option>
												</select>
											</div>
											<div class="row">
												<label><?php esc_html_e('Booking URL : ', 'mana-booking') ?></label>
												<input type="text" name="mana-booking-setting[booking_url]" value="<?php echo !empty($options['booking_url']) ? esc_attr($options['booking_url']) : 'mana-booking' ?>" />
											</div>
											<div class="row">
												<label><?php esc_html_e('Contact Page URL : ', 'mana-booking') ?></label>
												<input type="text" name="mana-booking-setting[contact_url]" value="<?php echo !empty($options['contact_url']) ? esc_attr($options['contact_url']) : '' ?>" />
											</div>
											<div class="row">
												<label><?php esc_html_e('Booking Archive Items Per Page: ', 'mana-booking') ?></label>
												<input type="text" name="mana-booking-setting[booking_archive_per_page]" value="<?php echo !empty($options['booking_archive_per_page']) ? esc_attr($options['booking_archive_per_page']) : '' ?>" />
											</div>
											<div class="row">
												<label><?php esc_html_e('Payment Archive Items Per Page: ', 'mana-booking') ?></label>
												<input type="text" name="mana-booking-setting[payment_archive_per_page]" value="<?php echo !empty($options['payment_archive_per_page']) ? esc_attr($options['payment_archive_per_page']) : '' ?>" />
											</div>
											<div class="row">
												<label><?php esc_html_e('Room Listing Image Slider: ', 'mana-booking') ?></label>
												<label class="mana-booking-switch">
													<input name="mana-booking-setting[listing_image_slider]" value="1" type="checkbox" <?php !empty($options['listing_image_slider']) ? checked(intval($options['listing_image_slider']), 1) : ''; ?>>
													<span class="switcher"></span>
												</label>
											</div>
											<div class="row">
												<label><?php esc_html_e('Room Rating status: ', 'mana-booking') ?></label>
												<label class="mana-booking-switch">
													<input name="mana-booking-setting[rating_status]" value="1" type="checkbox" <?php !empty($options['rating_status']) ? checked(intval($options['rating_status']), 1) : ''; ?>>
													<span class="switcher"></span>
												</label>
											</div>
											<div class="row">
												<label><?php esc_html_e('Room Rating Item: ', 'mana-booking') ?></label>
												<div class="email-receiver-container">
													<ul>
														<?php
														if (!empty($options['rating_item'])) {
															foreach ($options['rating_item'] as $index => $rating_item_item) {
														?>
																<li>
																	<input type="text" name="mana-booking-setting[rating_item][<?php echo esc_attr($index) ?>]" value="<?php echo esc_attr($rating_item_item) ?>">
																	<div class="remove-box">
																		<i class="dashicons dashicons-no-alt"></i>
																	</div>
																</li>
														<?php
															}
														}
														?>
													</ul>
													<div class="add-email-receiver-box">
														<a class="add-email-receiver button button-primary button-large" href="#"><?php esc_html_e('Add New', 'mana-booking') ?></a>
													</div>
													<ul class="email-receiver-tpl hidden">
														<li>
															<input type="text" data-name="rating_item">
															<div class="remove-box">
																<i class="dashicons dashicons-no-alt"></i>
															</div>
														</li>
													</ul>
												</div>
											</div>
											<div class="row">
												<label><?php esc_html_e('Default Email Sender : ', 'mana-booking') ?></label>
												<input type="email" name="mana-booking-setting[wp_email_sender]" value="<?php echo !empty($options['wp_email_sender']) ? esc_attr($options['wp_email_sender']) : '' ?>" />
											</div>
											<div class="row">
												<label><?php esc_html_e('Default Email Sender\'s Name : ', 'mana-booking') ?></label>
												<input type="text" name="mana-booking-setting[wp_email_sender_name]" value="<?php echo !empty($options['wp_email_sender_name']) ? esc_attr($options['wp_email_sender_name']) : '' ?>" />
											</div>
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
												<li>
													<?php esc_html_e('"Room Archive Page Layout" will be used for "Room Archive" page template.', 'mana-booking') ?>
												</li>
												<li>
													<?php esc_html_e('Booking URL is used for booking page that you can modify it. It will be show in address bar after ? and the default value is "?mana-booking"', 'mana-booking') ?>
												</li>
												<li>
													<?php esc_html_e('If you enable "Room Listing Image Slider", all the rooms\' images will be shown in slider in listing views.', 'mana-booking') ?>
												</li>
												<li>
													<?php esc_html_e('You can enable/disable rating system and handle its items in this section.', 'mana-booking') ?>
												</li>
												<li>
													<?php esc_html_e('The contact page\'s URL will be used in every sections that users need extra information.', 'mana-booking') ?>
												</li>
												<li>
													<?php esc_html_e('You can manage home many Booking Items and Payments will be shown in your panel.', 'mana-booking') ?>
												</li>
												<li>
													<?php esc_html_e('By help of "Default Email Sender" and "Default Email Sender\'s Name" you can change the default WordPress email sender and its name. It is used for sending core feature\'s notification like registration and etc. The default email sender of WordPress is "wordpress@your_domain.com" and its name is "WordPress".', 'mana-booking') ?>
												</li>
											</ol>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-content" id="tabs-8">
								<div class="l-col mana-col two-third clearfix">
									<div class="mana-box">
										<div class="field-rows fields clearfix">
											<div class="row">
												<label><?php esc_html_e('Room Base Price : ', 'mana-booking') ?></label>
												<label class="mana-booking-switch">
													<input name="mana-booking-setting[room_base_price]" value="1" type="checkbox" <?php !empty($options['room_base_price']) ? checked(intval($options['room_base_price']), 1) : ''; ?>>
													<span class="switcher"></span>
												</label>
											</div>
											<div class="row">
												<label><?php esc_html_e('Vat (percent) : ', 'mana-booking') ?></label>
												<input type="number" name="mana-booking-setting[vat]" value="<?php echo !empty($options['vat']) ? esc_attr($options['vat']) : 'mana-booking' ?>" />
											</div>
											<div class="row">
												<label><?php esc_html_e('Deposit in Booking Process : ', 'mana-booking') ?></label>
												<label class="mana-booking-switch">
													<input name="mana-booking-setting[deposit_status]" value="1" type="checkbox" <?php !empty($options['deposit_status']) ? checked(intval($options['deposit_status']), 1) : ''; ?>>
													<span class="switcher"></span>
												</label>
											</div>
											<div class="row">
												<label><?php esc_html_e('Deposit (percent): ', 'mana-booking') ?></label>
												<input type="number" name="mana-booking-setting[deposit]" value="<?php echo !empty($options['deposit']) ? esc_attr($options['deposit']) : 'mana-booking' ?>" />
											</div>
											<div class="row">
												<label><?php esc_html_e('Booking By Email : ', 'mana-booking') ?></label>
												<label class="mana-booking-switch">
													<input name="mana-booking-setting[email_booking]" value="1" type="checkbox" <?php !empty($options['email_booking']) ? checked(intval($options['email_booking']), 1) : ''; ?>>
													<span class="switcher"></span>
												</label>
											</div>
											<div class="row">
												<label><?php esc_html_e('Terms & Condition Page URL : ', 'mana-booking') ?></label>
												<?php
												if (function_exists('icl_get_languages')) {
													$langs = icl_get_languages('skip_missing=N&orderby=KEY&order=DIR&link_empty_to=str');
													foreach ($langs as $lang => $lang_info) {
														echo '
															<div class="field-row clear">
																<label class="lang-label">' . esc_html($lang_info['native_name']) . ' : </label>
																<input type="url" name="mana-booking-setting[condition_url][' . esc_attr($lang) . ']" value="' . (!empty($options['condition_url'][$lang]) ? esc_attr($options['condition_url'][$lang]) : '') . '"/>
															</div>
															';
													}
												} else {
													$condition_url = is_array($options['condition_url']) ? reset($options['condition_url']) : $options['condition_url'];
												?>
													<input type="url" name="mana-booking-setting[condition_url]" value="<?php echo !empty($condition_url) ? esc_attr($condition_url) : '' ?>" />
												<?php
												}
												?>
											</div>
											<div class="row">
												<label><?php esc_html_e('Final Booking Page Title : ', 'mana-booking') ?></label>
												<input type="text" name="mana-booking-setting[final_booking_title]" value="<?php echo !empty($options['final_booking_title']) ? esc_attr($options['final_booking_title']) : '' ?>" />
											</div>
											<div class="row">
												<label><?php esc_html_e('Final Booking Page Subtitle : ', 'mana-booking') ?></label>
												<input type="text" name="mana-booking-setting[final_booking_subtitle]" value="<?php echo !empty($options['final_booking_subtitle']) ? esc_attr($options['final_booking_subtitle']) : '' ?>" />
											</div>
											<div class="row">
												<label><?php esc_html_e('Final Booking Page Description : ', 'mana-booking') ?></label>
												<textarea name="mana-booking-setting[final_booking_desc]"><?php echo !empty($options['final_booking_desc']) ? esc_attr($options['final_booking_desc']) : '' ?></textarea>
											</div>
											<div class="row">
												<label><?php esc_html_e('External Booking System : ', 'mana-booking') ?></label>
												<label class="mana-booking-switch">
													<input name="mana-booking-setting[external_booking]" value="1" type="checkbox" <?php !empty($options['external_booking']) ? checked(intval($options['external_booking']), 1) : ''; ?>>
													<span class="switcher"></span>
												</label>
											</div>
											<div class="row">
												<label><?php esc_html_e('External Booking URL : ', 'mana-booking') ?></label>
												<input type="url" name="mana-booking-setting[external_booking_url]" value="<?php echo !empty($options['external_booking_url']) ? esc_attr($options['external_booking_url']) : '' ?>" />
											</div>
											<div class="row">
												<label><?php esc_html_e('External Booking Send Method : ', 'mana-booking') ?></label>
												<select name="mana-booking-setting[external_booking_method]">
													<option value="1" <?php !empty($options['external_booking_method']) ? selected($options['external_booking_method'], '1') : '' ?>><?php esc_html_e('Post', 'mana-booking'); ?></option>
													<option value="2" <?php !empty($options['external_booking_method']) ? selected($options['external_booking_method'], '2') : '' ?>><?php esc_html_e('Get', 'mana-booking'); ?></option>
												</select>
											</div>
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
												<li class="red">
													<b>
														<?php esc_html_e('If you enable "Room Base Price", all of your room\'s price will be calculated based on the room\'s main capacity. It means that the price will be fixed untill the guest count is more than the main capacity of rooms.', 'mana-booking') ?>
													</b>
												</li>
												<li>
													<?php esc_html_e('Default value for vat is 8%, if you want to use the default value leave it blank.', 'mana-booking') ?>
												</li>
												<li>
													<?php esc_html_e('You can enable/disable deposit in the booking process, if you disable it, all users must pay full price of theri bookings', 'mana-booking') ?>
												</li>
												<li>
													<?php esc_html_e('Default value of deposit us 20%, so if you want to use the default value leave it blank.', 'mana-booking') ?>
												</li>
												<li>
													<?php esc_html_e('You can enable/disable booking by email, in booking by email process, users can book without any payments.', 'mana-booking') ?>
												</li>
												<li>
													<?php esc_html_e('Set your email to all payments will be done in your account.', 'mana-booking') ?>
												</li>
												<li>
													<?php esc_html_e('If you set external booking system for your website, all the booking settings will be ignored and the booking information will send information to your url', 'mana-booking') ?>
												</li>
												<li>
													<?php esc_html_e('If you set external booking system for your website, you can set that booking information will be sent to your URL in Post or Get method.', 'mana-booking') ?>
												</li>
											</ol>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-content" id="tabs-10">
								<div class="l-col mana-col two-third clearfix">
									<div class="mana-box">
										<div class="field-rows fields clearfix">
											<div class="row">
												<label><?php esc_html_e('Booking By PayPal : ', 'mana-booking') ?></label>
												<label class="mana-booking-switch">
													<input name="mana-booking-setting[paypal_booking]" value="1" type="checkbox" <?php !empty($options['paypal_booking']) ? checked(intval($options['paypal_booking']), 1) : ''; ?>>
													<span class="switcher"></span>
												</label>
											</div>
											<div class="row">
												<label><?php esc_html_e('Paypal Email : ', 'mana-booking') ?></label>
												<input type="email" name="mana-booking-setting[paypal_email]" value="<?php echo !empty($options['paypal_email']) ? esc_attr($options['paypal_email']) : '' ?>" />
											</div>
											<div class="row">
												<label><?php esc_html_e('Paypal Action URL : ', 'mana-booking') ?></label>
												<input type="url" name="mana-booking-setting[paypal_action_url]" value="<?php echo !empty($options['paypal_action_url']) ? esc_attr($options['paypal_action_url']) : '' ?>" />
											</div>
											<div class="row">
												<label><?php esc_html_e('Paypal Default Currency : ', 'mana-booking') ?></label>
												<select name="mana-booking-setting[paypal_default_currency]">
													<option value="no_item" <?php !empty($options['paypal_default_currency']) ? selected($options['paypal_default_currency'], 'no_item') : '' ?>><?php esc_html_e('Current Currency', 'mana-booking');  ?></option>
													<?php
													foreach ($options['currency'] as $index => $currency_item) {
														echo '<option value="' . esc_attr($currency_item['title']) . '" ' . (!empty($options['paypal_default_currency']) ? selected($options['paypal_default_currency'], $currency_item['title']) : '') . '>' . esc_html($currency_item['title']) . '</option>';
													}
													?>
												</select>
											</div>
											<div class="row">
												<label><?php esc_html_e('Booking By Paymill : ', 'mana-booking') ?></label>
												<label class="mana-booking-switch">
													<input name="mana-booking-setting[paymill_booking]" value="1" type="checkbox" <?php !empty($options['paymill_booking']) ? checked(intval($options['paymill_booking']), 1) : ''; ?>>
													<span class="switcher"></span>
												</label>
											</div>
											<div class="row">
												<label><?php esc_html_e('Paymill Private Key : ', 'mana-booking') ?></label>
												<input type="text" name="mana-booking-setting[paymill_private_key]" value="<?php echo !empty($options['paymill_private_key']) ? esc_attr($options['paymill_private_key']) : '' ?>" />
											</div>
											<div class="row">
												<label><?php esc_html_e('Paymill Public Key : ', 'mana-booking') ?></label>
												<input type="text" name="mana-booking-setting[paymill_public_key]" value="<?php echo !empty($options['paymill_public_key']) ? esc_attr($options['paymill_public_key']) : '' ?>" />
											</div>
											<div class="row">
												<label><?php esc_html_e('Booking By Stripe : ', 'mana-booking') ?></label>
												<label class="mana-booking-switch">
													<input name="mana-booking-setting[stripe_booking]" value="1" type="checkbox" <?php !empty($options['stripe_booking']) ? checked(intval($options['stripe_booking']), 1) : ''; ?>>
													<span class="switcher"></span>
												</label>
											</div>
											<div class="row">
												<label><?php esc_html_e('Stripe Publishable Key : ', 'mana-booking') ?></label>
												<input type="text" name="mana-booking-setting[stripe_publish_key]" value="<?php echo !empty($options['stripe_publish_key']) ? esc_attr($options['stripe_publish_key']) : '' ?>" />
											</div>
											<div class="row">
												<label><?php esc_html_e('Stripe Secret Key : ', 'mana-booking') ?></label>
												<input type="text" name="mana-booking-setting[stripe_secret_key]" value="<?php echo !empty($options['stripe_secret_key']) ? esc_attr($options['stripe_secret_key']) : '' ?>" />
											</div>
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
												<li>
													<?php esc_html_e('You can change the action url for payment\'s form. For testing paypayl use https://www.sandbox.paypal.com/cgi-bin/webscr and after testing use the real one : https://www.paypal.com/cgi-bin/webscr', 'mana-booking') ?>
												</li>
												<li class="red">
													<?php esc_html_e('Do not forget to change https://www.sandbox.paypal.com/cgi-bin/webscr to https://www.paypal.com/cgi-bin/webscr after your tests.', 'mana-booking') ?>
												</li>
												<li class="red">
													<?php esc_html_e('If you set a default currency for Paypal, total booking price will be exchanged to this currency before sending to Paypal website.', 'mana-booking') ?>
												</li>
												<li>
													<?php esc_html_e('If you set a "Current Currency" default currency for Paypal, total booking price will calculated based on the user-selected or current currency before sending to Paypal website.', 'mana-booking') ?>
												</li>
												<li>
													<?php esc_html_e('If you need to have Paymill payments in your booking process, after enabling its option, you must enter both Private and Public keys in this section. For further information, you can check this URL : https://developers.paymill.com/guides/introduction/your-account#2-api-keys', 'mana-booking') ?>
												</li>
												<li>
													<?php esc_html_e('If you need to have Stripe payments in your booking process, after enabling its option, you must enter both Publishable and Secter keys in this section. For further information, you can check this URL : https://stripe.com/docs/dashboard#api-keys', 'mana-booking') ?>
												</li>
											</ol>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-content" id="tabs-2">
								<div class="l-col mana-col two-third clearfix">
									<div class="mana-box">
										<div class="field-rows fields clearfix">
											<div class="row">
												<label><?php esc_html_e('Email Notification Status : ', 'mana-booking') ?></label>
												<label class="mana-booking-switch">
													<input name="mana-booking-setting[email_notification_status]" value="1" type="checkbox" <?php !empty($options['email_notification_status']) ? checked(intval($options['email_notification_status']), 1) : ''; ?>>
													<span class="switcher"></span>
												</label>
											</div>
											<div class="row">
												<label><?php esc_html_e('Email Sender : ', 'mana-booking') ?></label>
												<input type="email" name="mana-booking-setting[email_sender]" value="<?php echo !empty($options['email_sender']) ? esc_attr($options['email_sender']) : '' ?>" placeholder="<?php esc_html_e('email@yourwebsite.com', 'mana-booking') ?>" />
											</div>
											<div class="row">
												<label><?php esc_html_e('Email Receiver : ', 'mana-booking') ?></label>
												<div class="email-receiver-container">
													<ul>
														<?php
														if (!empty($options['email_receiver'])) {
															foreach ($options['email_receiver'] as $index => $email_receiver_item) {
														?>
																<li>
																	<input type="email" name="mana-booking-setting[email_receiver][<?php echo esc_attr($index) ?>]" value="<?php echo esc_attr($email_receiver_item) ?>">
																	<div class="remove-box">
																		<i class="dashicons dashicons-no-alt"></i>
																	</div>
																</li>
														<?php
															}
														}
														?>
													</ul>
													<div class="add-email-receiver-box">
														<a class="add-email-receiver button button-primary button-large" href="#"><?php esc_html_e('Add New', 'mana-booking') ?></a>
													</div>
													<ul class="email-receiver-tpl hidden">
														<li>
															<input type="email" data-name="email_receiver">
															<div class="remove-box">
																<i class="dashicons dashicons-no-alt"></i>
															</div>
														</li>
													</ul>
												</div>
											</div>
											<div class="row">
												<label><?php esc_html_e('Booking Details For Users : ', 'mana-booking') ?></label>
												<label class="mana-booking-switch">
													<input name="mana-booking-setting[guest_receiver]" value="1" type="checkbox" <?php !empty($options['guest_receiver']) ? checked(intval($options['guest_receiver']), 1) : ''; ?>>
													<span class="switcher"></span>
												</label>
											</div>
											<div class="row">
												<label><?php esc_html_e('Email Template of Admins : ', 'mana-booking') ?></label>
												<?php
												$admin_tmpl_content = !empty($options['email_admin_tmpl']) ? balanceTags($options['email_admin_tmpl']) : '';
												$editor_arg         = array(
													'textarea_name' => 'mana-booking-setting[email_admin_tmpl]',
													'editor_height' => 300
												);
												wp_editor($admin_tmpl_content, 'email_admin_tmpl', $editor_arg);
												?>
											</div>
											<div class="row">
												<label><?php esc_html_e('Email template of users : ', 'mana-booking') ?></label>
												<?php
												$user_tmpl_content = !empty($options['email_user_tmpl']) ? balanceTags($options['email_user_tmpl']) : '';
												$editor_arg        = array(
													'textarea_name' => 'mana-booking-setting[email_user_tmpl]',
													'editor_height' => 300
												);
												wp_editor($user_tmpl_content, 'email_user_tmpl', $editor_arg);
												?>
											</div>
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
												<li>
													<b class="red"><?php esc_html_e('Important Note : ', 'mana-booking') ?></b><br><?php esc_html_e('Use an email from your website for email sender. For example if your website is "your_website.com", your email must be something like "sender@your_website.com"', 'mana-booking') ?>
												</li>
												<li>
													<b><?php esc_html_e('Email Template of Admins : ', 'mana-booking') ?></b><br><?php esc_html_e('For putting extra information in your email, you can use these shortcode to provide more details about the booking. Here is the list of shortcode that you can use in this field :', 'mana-booking') ?>
													<ul>
														<li>[guest-first-name]</li>
														<li>[guest-last-name]</li>
														<li>[guest-email]</li>
														<li>[guest-phone]</li>
														<li>[guest-address]</li>
														<li>[guest-special-requirement]</li>
														<li>[guest-check-in]</li>
														<li>[guest-check-out]</li>
														<li>[guest-room]</li>
														<li>[guest-services]</li>
														<li>[guest-booking-total-price]</li>
													</ul>
												</li>
												<li>
													<b><?php esc_html_e('Email Template of Users : ', 'mana-booking') ?></b><br><?php esc_html_e('For putting extra information in your email, you can use these shortcode to provide more details about the booking. Here is the list of shortcode that you can use in this field :', 'mana-booking') ?>
													<ul>
														<li>[guest-first-name]</li>
														<li>[guest-last-name]</li>
														<li>[guest-email]</li>
														<li>[guest-phone]</li>
														<li>[guest-address]</li>
														<li>[guest-special-requirement]</li>
														<li>[guest-check-in]</li>
														<li>[guest-check-out]</li>
														<li>[guest-room]</li>
														<li>[guest-services]</li>
														<li>[guest-booking-total-price]</li>
													</ul>
												</li>
												<li>
													<b class="red"><?php esc_html_e('Booking Details For Users :', 'mana-booking') ?> </b> <?php esc_html_e('If you want your guests receive their booking information you set for the admins of website, enable this option.', 'mana-booking') ?>
												</li>
											</ol>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-content" id="tabs-3">
								<div class="l-col mana-col two-third clearfix">
									<div class="mana-box">
										<div class="field-rows fields clearfix">
											<div class="row">
												<label><?php esc_html_e('Currency Separator : ', 'mana-booking') ?></label>
												<select name="mana-booking-setting[currency_separator]">
													<option value="1" <?php !empty($options['currency_separator']) ? selected($options['currency_separator'], '1') : '' ?>>,</option>
													<option value="2" <?php !empty($options['currency_separator']) ? selected($options['currency_separator'], '2') : '' ?>>.</option>
													<option value="3" <?php !empty($options['currency_separator']) ? selected($options['currency_separator'], '3') : '' ?>><?php esc_html_e('Space', 'mana-booking'); ?></option>
												</select>
											</div>
											<div class="row">
												<label><?php esc_html_e('Currency Decimal : ', 'mana-booking') ?></label>
												<select name="mana-booking-setting[currency_decimal]">
													<option value="" <?php !empty($options['currency_decimal']) ? selected($options['currency_decimal'], '') : '' ?>>None</option>
													<option value="1" <?php !empty($options['currency_decimal']) ? selected($options['currency_decimal'], '1') : '' ?>>1</option>
													<option value="2" <?php !empty($options['currency_decimal']) ? selected($options['currency_decimal'], '2') : '' ?>>2</option>
													<option value="3" <?php !empty($options['currency_decimal']) ? selected($options['currency_decimal'], '3') : '' ?>>3</option>
													<option value="4" <?php !empty($options['currency_decimal']) ? selected($options['currency_decimal'], '4') : '' ?>>4</option>
													<option value="5" <?php !empty($options['currency_decimal']) ? selected($options['currency_decimal'], '5') : '' ?>>5</option>
												</select>
											</div>
											<div class="row">
												<label><?php esc_html_e('Currency Decimal Separator : ', 'mana-booking') ?></label>
												<select name="mana-booking-setting[currency_decimal_separator]">
													<option value="1" <?php !empty($options['currency_decimal_separator']) ? selected($options['currency_decimal_separator'], '1') : '' ?>>.</option>
													<option value="2" <?php !empty($options['currency_decimal_separator']) ? selected($options['currency_decimal_separator'], '2') : '' ?>>,</option>
												</select>
											</div>
											<div class="currency-boxes-container">
												<?php
												if (!empty($options['currency'])) {
													foreach ($options['currency'] as $index => $currency_item) {
														$rate = 0;
														if (intval($options['default_currency']) === $index) {
															$rate = 1;
														} elseif (!empty($currency_item['rate'])) {
															$rate = $currency_item['rate'];
														}
												?>
														<div class="currency-box currency-box-active <?php echo (intval($options['default_currency']) === $index) ? esc_attr('default') : '' ?>">
															<div class="remove-box">
																<i class="dashicons dashicons-no-alt"></i>
															</div>
															<div class="fields clearfix">
																<div class="row">
																	<label><?php esc_html_e('Title : ', 'mana-booking') ?></label>
																	<input type="text" name="mana-booking-setting[currency][<?php echo esc_attr($index) ?>][title]" value="<?php echo !empty($currency_item['title']) ? esc_attr($currency_item['title']) : '' ?>" placeholder="<?php esc_html_e('Title', 'mana-booking') ?>" />
																</div>
																<div class="row">
																	<label><?php esc_html_e('Symbol : ', 'mana-booking') ?></label>
																	<input type="text" name="mana-booking-setting[currency][<?php echo esc_attr($index) ?>][symbol]" value="<?php echo !empty($currency_item['symbol']) ? esc_attr($currency_item['symbol']) : '' ?>" placeholder="<?php esc_html_e('Symbol', 'mana-booking') ?>" />
																</div>
																<div class="row">
																	<label><?php esc_html_e('Rate : ', 'mana-booking') ?></label>
																	<input type="number" min="0" step="any" class="currency-rate" name="mana-booking-setting[currency][<?php echo esc_attr($index) ?>][rate]" value="<?php echo esc_attr($rate); ?>" placeholder="<?php esc_html_e('Rate', 'mana-booking') ?>" <?php echo (intval($options['default_currency']) === $index) ? 'readonly="readonly"' : ''; ?> />
																</div>
															</div>
															<div class="mana-checkbox currency-position">
																<label>
																	<input type="checkbox" name="mana-booking-setting[currency][<?php echo esc_attr($index) ?>][position]" value="1" <?php !empty($currency_item['position']) && checked($currency_item['position'], '1') ?> />
																	<span></span>
																	<?php esc_html_e('Check this field if you want to show the currency before its value', 'mana-booking') ?>
																</label>
															</div>
															<div class="mana-radiobox currency-default">
																<label>
																	<input type="radio" name="mana-booking-setting[default_currency]" value="<?php echo esc_attr($index) ?>" <?php
																																												if (empty($options['default_currency'])) {
																																													checked(intval($options['default_currency']), 0);
																																												} else {
																																													checked(intval($options['default_currency']), $index);
																																												} ?> />
																	<span></span>
																	<?php esc_html_e('Set this currency as default currency of your website.', 'mana-booking') ?>
																</label>
															</div>
														</div>
												<?php
													}
												}
												?>
											</div>
											<div class="add-currency-box">
												<a class="currency-add button button-primary button-large" href="#"><?php esc_html_e('Add Currency', 'mana-booking') ?></a>
											</div>
											<div class="currency-box-tpl" style="display:none;">
												<div class="currency-box">
													<div class="remove-box"><i class="dashicons dashicons-no-alt"></i>
													</div>
													<div class="fields clearfix">
														<div class="row">
															<label><?php esc_html_e('Title : ', 'mana-booking') ?></label>
															<input type="text" name="" data-name="title" value="" placeholder="<?php esc_html_e('Title', 'mana-booking') ?>" />
														</div>
														<div class="row">
															<label><?php esc_html_e('Symbol : ', 'mana-booking') ?></label>
															<input type="text" name="" data-name="symbol" value="" placeholder="<?php esc_html_e('Symbol', 'mana-booking') ?>" />
														</div>
														<div class="row">
															<label><?php esc_html_e('Rate : ', 'mana-booking') ?></label>
															<input type="number" min="0" step="any" name="" data-name="rate" value="" placeholder="<?php esc_html_e('Rate', 'mana-booking') ?>" />
														</div>
													</div>
													<div class="mana-checkbox currency-position">
														<label>
															<input type="checkbox" name="" data-name="position" value="1" />
															<span></span>
															<?php esc_html_e('Check this field if you want to show the currency before its value', 'mana-booking') ?>
														</label>
													</div>
													<div class="mana-radiobox currency-default">
														<label>
															<input type="radio" name="mana-booking-setting[default_currency]" />
															<span></span>
															<?php esc_html_e('Set this currency as default currency of your website.', 'mana-booking') ?>
														</label>
													</div>

												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="r-col mana-col one-third pl">
									<div class="mana-box">
										<div class="update-currency-container" id="currency-update-now">
											<a class="update-currency button button-primary button-large" href="#">
												<i class="dashicons dashicons-update"></i><?php esc_html_e('Update Currency Rate Now', 'mana-booking') ?>
											</a>
											<span class="message"></span>
										</div>
									</div>
									<div class="mana-info-box">
										<div class="header">
											<i class="dashicons dashicons-info"></i><?php esc_html_e('Instruction', 'mana-booking') ?>
										</div>
										<div class="content">
											<ol>
												<li class="red"><?php esc_html_e('In some cases automatic currency updated might have technical issue, in this circumstances you can set all the currency manually.', 'mana-booking') ?></li>
												<li><?php esc_html_e('Update currency button just works for the saved currency.', 'mana-booking') ?></li>
												<li><?php esc_html_e('After updating the rates page will be refreshed.', 'mana-booking') ?></li>
												<li><?php esc_html_e('If you don\'t set the default currency, the first currency will be considered as the default.', 'mana-booking') ?></li>
												<li><?php esc_html(printf('You can find your currency title from <a target="_blank" href="%s">HERE</a>. "Currency Code" is the column that you must search on.', 'http://www.xe.com/symbols.php'), 'mana-booking'); ?></li>
												<li><?php esc_html(printf('You can find your currency symbol from <a target="_blank" href="%s">HERE</a>. "Arial Unicode MS" is the column that you must search on.', 'http://www.xe.com/symbols.php'), 'mana-booking'); ?></li>
											</ol>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-content" id="tabs-9">
								<div class="l-col mana-col two-third clearfix">
									<div class="membership-package-main-container">
										<?php
										if (!empty($options['membership'])) {
											foreach ($options['membership'] as $index => $membership_item) {
												$img_preview = $img_info = '';
												if (!empty($membership_item['badge'])) {
													$img_info    = wp_get_attachment_thumb_url($membership_item['badge']);
													$img_preview = (!empty($img_info) ? '<div class="image-preview-box"><img src="' . esc_url($img_info) . '"/></div>' : '');
												} ?>
												<div class="membership-package-box">
													<div class="remove-box">
														<i class="dashicons dashicons-no-alt"></i>
													</div>
													<div class="fields clearfix">
														<div class="row">
															<label><?php esc_html_e('Title : ', 'mana-booking') ?></label>
															<input type="text" name="mana-booking-setting[membership][<?php echo esc_attr($index) ?>][title]" value="<?php echo !empty($membership_item['title']) ? esc_attr($membership_item['title']) : '' ?>" placeholder="<?php esc_html_e('Title', 'mana-booking') ?>" />
														</div>
														<div class="row">
															<label><?php esc_html_e('Badge : ', 'mana-booking') ?></label>
															<div class="single-image-uploader">
																<div class="img-container"><?php echo (!empty($img_preview) ? wp_kses_post($img_preview) : ''); ?></div>
																<a class="add-image button button-primary button-large <?php echo (!empty($img_preview) ? esc_attr('hidden') : '') ?>" href="#"><?php esc_html_e('Upload Image', 'mana-booking') ?></a>
																<a class="remove-image button button-primary button-large <?php echo (empty($img_preview) ? esc_attr('hidden') : '') ?>" href="#"><?php esc_html_e('Remove Image', 'mana-booking') ?></a>
																<input type="hidden" name="mana-booking-setting[membership][<?php echo esc_attr($index) ?>][badge]" value="<?php echo !empty($membership_item['badge']) ? esc_attr($membership_item['badge']) : '' ?>" />
															</div>
														</div>
														<div class="row">
															<label><?php esc_html_e('Conditions : ', 'mana-booking') ?></label>
															<select name="mana-booking-setting[membership][<?php echo esc_attr($index) ?>][condition]" class="membership-condition-switcher">
																<option value="1" <?php selected($membership_item['condition'], 1, true) ?>><?php esc_html_e('Total Booking Price', 'mana-booking') ?></option>
																<option value="2" <?php selected($membership_item['condition'], 2, true) ?>><?php esc_html_e('Total Booking Items', 'mana-booking') ?></option>
																<option value="3" <?php selected($membership_item['condition'], 3, true) ?>><?php esc_html_e('Total Booking Price / Total Booking Items', 'mana-booking') ?></option>
															</select>
														</div>
														<div class="row total-booking-price">
															<label></label>
															<input type="number" min="0" name="mana-booking-setting[membership][<?php echo esc_attr($index) ?>][single-condition-price]" value="<?php echo esc_attr($membership_item['single-condition-price']) ?>" placeholder="<?php esc_html_e('Set the total price of bookings', 'mana-booking') ?>" />
														</div>
														<div class="row total-booking-item hidden">
															<label></label>
															<input type="number" min="0" name="mana-booking-setting[membership][<?php echo esc_attr($index) ?>][single-condition-item]" value="<?php echo esc_attr($membership_item['single-condition-item']) ?>" placeholder="<?php esc_html_e('Set the total count of bookings', 'mana-booking') ?>" />
														</div>
														<div class="row total-booking-price-item hidden">
															<label></label>
															<input type="number" min="0" name="mana-booking-setting[membership][<?php echo esc_attr($index) ?>][condition-price]" value="<?php echo esc_attr($membership_item['condition-price']) ?>" placeholder="<?php esc_html_e('Set the total price of bookings', 'mana-booking') ?>" />
															<select name="mana-booking-setting[membership][<?php echo esc_attr($index) ?>][condition-type]" class="auto-width">
																<option value="1" <?php selected($membership_item['condition-type'], 1, true) ?>><?php esc_html_e('AND', 'mana-booking') ?></option>
																<option value="2" <?php selected($membership_item['condition-type'], 2, true) ?>><?php esc_html_e('OR', 'mana-booking') ?></option>
															</select>
															<input type="number" min="0" name="mana-booking-setting[membership][<?php echo esc_attr($index) ?>][condition-item]" value="<?php echo esc_attr($membership_item['condition-item']) ?>" placeholder="<?php esc_html_e('Set the total count of bookings', 'mana-booking') ?>" />
														</div>
														<div class="row">
															<label><?php esc_html_e('Discount : ', 'mana-booking') ?></label>
															<input type="number" min="0" max="100" name="mana-booking-setting[membership][<?php echo esc_attr($index) ?>][discount]" value="<?php echo !empty($membership_item['discount']) ? esc_attr($membership_item['discount']) : '' ?>" placeholder="%" />
														</div>
													</div>
												</div>
										<?php
											}
										}
										?>
									</div>
									<div class="add-client-box">
										<a class="membership-add button button-primary button-large" href="#"><?php esc_html_e('Add New', 'mana-booking') ?></a>
									</div>
									<div class="membership-box-tpl" style="display:none;">
										<div class="membership-package-box">
											<div class="remove-box">
												<i class="dashicons dashicons-no-alt"></i>
											</div>
											<div class="fields clearfix">
												<div class="row">
													<label><?php esc_html_e('Title : ', 'mana-booking') ?></label>
													<input type="text" name="" data-name="title" value="" placeholder="<?php esc_html_e('Title', 'mana-booking') ?>" />
												</div>
												<div class="row">
													<label><?php esc_html_e('Badge : ', 'mana-booking') ?></label>
													<div class="single-image-uploader">
														<div class="img-container"></div>
														<a class="add-image button button-primary button-large" href="#"><?php esc_html_e('Upload Image', 'mana-booking') ?></a>
														<a class="remove-image button button-primary button-large hidden" href="#"><?php esc_html_e('Remove Image', 'mana-booking') ?></a>
														<input type="hidden" name="" data-name="badge" value="" />
													</div>
												</div>
												<div class="row">
													<label><?php esc_html_e('Conditions : ', 'mana-booking') ?></label>
													<select name="" class="membership-condition-switcher" data-name="condition">
														<option value="1"><?php esc_html_e('Total Booking Price', 'mana-booking') ?></option>
														<option value="2"><?php esc_html_e('Total Booking Items', 'mana-booking') ?></option>
														<option value="3"><?php esc_html_e('Total Booking Price / Total Booking Items', 'mana-booking') ?></option>
													</select>
												</div>
												<div class="row total-booking-price">
													<label></label>
													<input type="number" min="0" name="" data-name="single-condition-price" value="" placeholder="<?php esc_html_e('Set the total price of bookings', 'mana-booking') ?>" />
												</div>
												<div class="row total-booking-item hidden">
													<label></label>
													<input type="number" min="0" name="" data-name="single-condition-item" value="" placeholder="<?php esc_html_e('Set the total count of bookings', 'mana-booking') ?>" />
												</div>
												<div class="row total-booking-price-item hidden">
													<label></label>
													<input type="number" min="0" name="" data-name="condition-price" value="" placeholder="<?php esc_html_e('Set the total price of bookings', 'mana-booking') ?>" />
													<select name="" data-name="condition-type" class="auto-width">
														<option value="1"><?php esc_html_e('AND', 'mana-booking') ?></option>
														<option value="2"><?php esc_html_e('OR', 'mana-booking') ?></option>
													</select>
													<input type="number" min="0" name="" data-name="condition-item" value="" placeholder="<?php esc_html_e('Set the total count of bookings', 'mana-booking') ?>" />
												</div>
												<div class="row">
													<label><?php esc_html_e('Discount : ', 'mana-booking') ?></label>
													<input type="number" min="0" max="100" name="" data-name="discount" value="" placeholder="%" />
												</div>
											</div>
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
												<li><?php esc_html_e('You can add as much as membership package you need in this section.', 'mana-booking') ?></li>
												<li><?php esc_html_e('In title field you can set a title for your package', 'mana-booking') ?></li>
												<li><?php esc_html_e('You can set a badge for your package to be shown in the profile section of users', 'mana-booking') ?></li>
												<li><?php esc_html_e('You can set a condition of your package in these 3 ways: based on Total Booking Price, Total Booking items and both of them.', 'mana-booking') ?></li>
												<li><?php esc_html_e('After choosing the condition of package some fields based on your selected item will be shown that you can set your prices or count of booking item or both.', 'mana-booking') ?></li>
												<li><?php esc_html_e('Please note that in all the price and count fields you just need to add numbers.', 'mana-booking') ?></li>
												<li><?php esc_html_e('Every packages must have discount, so you must add discount that you have considered for your package.', 'mana-booking') ?></li>
											</ol>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-content" id="tabs-11">
								<div class="l-col mana-col two-third clearfix">
									<div class="season-package-main-container">
										<?php
										if (!empty($options['seasonal_price'])) {
											foreach ($options['seasonal_price'] as $index => $season_item) {
										?>
												<div class="season-package-box">
													<div class="remove-box">
														<i class="dashicons dashicons-no-alt"></i>
													</div>
													<div class="fields clearfix">
														<div class="row">
															<label><?php esc_html_e('Title : ', 'mana-booking') ?></label>
															<input type="text" name="mana-booking-setting[seasonal_price][<?php echo esc_attr($index) ?>][title]" value="<?php echo !empty($season_item['title']) ? esc_attr($season_item['title']) : '' ?>" placeholder="<?php esc_html_e('Title', 'mana-booking') ?>" />
														</div>
														<div class="row">
															<label><?php esc_html_e('Season Type : ', 'mana-booking') ?></label>
															<select name="mana-booking-setting[seasonal_price][<?php echo esc_attr($index) ?>][type]" class="season-type-switcher">
																<option value="1" <?php selected($season_item['type'], 1, true) ?>><?php esc_html_e('High Season', 'mana-booking') ?></option>
																<option value="2" <?php selected($season_item['type'], 2, true) ?>><?php esc_html_e('Low Season', 'mana-booking') ?></option>
															</select>
														</div>
														<div class="row">
															<label><?php esc_html_e('Start Date : ', 'mana-booking') ?></label>
															<input type="text" name="mana-booking-setting[seasonal_price][<?php echo esc_attr($index) ?>][from]" class="datepicker from" value="<?php echo !empty($season_item['from']) ? esc_attr($season_item['from']) : '' ?>" placeholder="<?php esc_html_e('Select a date', 'mana-booking') ?>" />
														</div>
														<div class="row">
															<label><?php esc_html_e('End Date : ', 'mana-booking') ?></label>
															<input type="text" name="mana-booking-setting[seasonal_price][<?php echo esc_attr($index) ?>][to]" class="datepicker to" value="<?php echo !empty($season_item['to']) ? esc_attr($season_item['to']) : '' ?>" placeholder="<?php esc_html_e('Select a date', 'mana-booking') ?>" />
														</div>
														<div class="row">
															<label><?php esc_html_e('Decrease / Increase Percent : ', 'mana-booking') ?></label>
															<input type="number" step="1" min="0" max="100" name="mana-booking-setting[seasonal_price][<?php echo esc_attr($index) ?>][percent]" value="<?php echo esc_attr($season_item['percent']) ?>" placeholder="<?php esc_html_e('Set the percent of decrease / increase', 'mana-booking') ?>" /> %
														</div>
													</div>
												</div>
										<?php
											}
										}
										?>
									</div>
									<div class="add-client-box">
										<a class="season-add button button-primary button-large" href="#"><?php esc_html_e('Add New', 'mana-booking') ?></a>
									</div>
									<div class="season-box-tpl" style="display:none;">
										<div class="season-package-box">
											<div class="remove-box">
												<i class="dashicons dashicons-no-alt"></i>
											</div>
											<div class="fields clearfix">
												<div class="row">
													<label><?php esc_html_e('Title : ', 'mana-booking') ?></label>
													<input type="text" name="" data-name="title" value="" placeholder="<?php esc_html_e('Title', 'mana-booking') ?>" />
												</div>
												<div class="row">
													<label><?php esc_html_e('Season Type : ', 'mana-booking') ?></label>
													<select name="" class="season-type-switcher" data-name="type">
														<option value="1"><?php esc_html_e('High Season', 'mana-booking') ?></option>
														<option value="2"><?php esc_html_e('Low Season', 'mana-booking') ?></option>
													</select>
												</div>
												<div class="row">
													<label><?php esc_html_e('Start Date : ', 'mana-booking') ?></label>
													<input type="text" name="" data-name="from" class="from" value="" placeholder="<?php esc_html_e('Select a date', 'mana-booking') ?>" />
												</div>
												<div class="row">
													<label><?php esc_html_e('End Date : ', 'mana-booking') ?></label>
													<input type="text" name="" data-name="to" class="to" value="" placeholder="<?php esc_html_e('Select a date', 'mana-booking') ?>" />
												</div>
												<div class="row">
													<label><?php esc_html_e('Decrease / Increase Percent : ', 'mana-booking') ?></label>
													<input type="number" step="1" min="0" max="100" name="" value="" placeholder="<?php esc_html_e('Set the percent of decrease / increase', 'mana-booking') ?>" data-name="percent" /> %
												</div>
											</div>
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
												<li class="red"><?php esc_html_e('Please note that these seasonal prices will override the single room prices. It means that they have higher priority of room\'s seasonal prices.', 'mana-booking') ?></li>
												<li><?php esc_html_e('This prices will be applied on all rooms of website.', 'mana-booking') ?></li>
											</ol>
										</div>
									</div>
								</div>
							</div>
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