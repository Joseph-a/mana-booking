<?php
	$options = get_option( 'ravis-booking-setting' );
?>
<div id="ravis-booking-setting-page">
	<div class="wrap">
		<h1><?php esc_html_e( 'Ravis Booking Settings', 'ravis-booking' ) ?></h1>
		<div class="main-container">
			<form action="options.php" method="post">
				<?php settings_fields( 'ravis-booking-setting' ); ?>
				<div class="col-wrap">
					<div class="content">
						<div id="tabs">
							<div class="tab-title-box">
								<ul>
									<li>
										<a href="#tabs-1"><?php esc_html_e( 'General', 'ravis-booking' ) ?></a>
									</li>
									<li>
										<a href="#tabs-8"><?php esc_html_e( 'Booking', 'ravis-booking' ) ?></a>
									</li>
									<li>
										<a href="#tabs-10"><?php esc_html_e( 'Payment', 'ravis-booking' ) ?></a>
									</li>
									<li>
										<a href="#tabs-2"><?php esc_html_e( 'Email Notification', 'ravis-booking' ) ?></a>
									</li>
									<li>
										<a href="#tabs-3"><?php esc_html_e( 'Currency', 'ravis-booking' ) ?></a>
									</li>
									<li>
										<a href="#tabs-4"><?php esc_html_e( 'Social Icons', 'ravis-booking' ) ?></a>
									</li>
									<li>
										<a href="#tabs-5"><?php esc_html_e( 'Slider & Gallery', 'ravis-booking' ) ?></a>
									</li>
									<li>
										<a href="#tabs-6"><?php esc_html_e( 'Clients', 'ravis-booking' ) ?></a>
									</li>
									<li>
										<a href="#tabs-9"><?php esc_html_e( 'Membership', 'ravis-booking' ) ?></a>
									</li>
									<li>
										<a href="#tabs-11"><?php esc_html_e( 'Seasonal Price', 'ravis-booking' ) ?></a>
									</li>
									<li>
										<a href="#tabs-7"><?php esc_html_e( 'Export & Import', 'ravis-booking' ) ?></a>
									</li>
								</ul>
								<div class="version"><?php echo esc_html( __( 'Version : ', 'ravis-booking' ) . RAVIS_BOOKING_VERSION ) ?></div>
							</div>
							<div class="tab-content" id="tabs-1">
								<div class="l-col ravis-col two-third clearfix">
									<div class="ravis-box">
										<div class="field-rows fields clearfix">
											<div class="row">
												<label><?php esc_html_e( 'Room Archive Page Layout : ', 'ravis-booking' ) ?></label>
												<select name="ravis-booking-setting[archive_page_layout]">
													<option value="1" <?php ! empty( $options['archive_page_layout'] ) ? selected( $options['archive_page_layout'], '1' ) : '' ?>><?php esc_html_e( 'Grid View', 'ravis-booking' ); ?></option>
													<option value="2" <?php ! empty( $options['archive_page_layout'] ) ? selected( $options['archive_page_layout'], '2' ) : '' ?>><?php esc_html_e( 'List View', 'ravis-booking' ); ?></option>
												</select>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Booking URL : ', 'ravis-booking' ) ?></label>
												<input type="text" name="ravis-booking-setting[booking_url]" value="<?php echo ! empty( $options['booking_url'] ) ? esc_attr( $options['booking_url'] ) : 'ravis-booking' ?>"/>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Contact Page URL : ', 'ravis-booking' ) ?></label>
												<input type="text" name="ravis-booking-setting[contact_url]" value="<?php echo ! empty( $options['contact_url'] ) ? esc_attr( $options['contact_url'] ) : '' ?>"/>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Booking Archive Items Per Page: ', 'ravis-booking' ) ?></label>
												<input type="text" name="ravis-booking-setting[booking_archive_per_page]" value="<?php echo ! empty( $options['booking_archive_per_page'] ) ? esc_attr( $options['booking_archive_per_page'] ) : '' ?>"/>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Payment Archive Items Per Page: ', 'ravis-booking' ) ?></label>
												<input type="text" name="ravis-booking-setting[payment_archive_per_page]" value="<?php echo ! empty( $options['payment_archive_per_page'] ) ? esc_attr( $options['payment_archive_per_page'] ) : '' ?>"/>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Room Listing Image Slider: ', 'ravis-booking' ) ?></label>
												<label class="ravis-booking-switch">
													<input name="ravis-booking-setting[listing_image_slider]" value="1" type="checkbox" <?php ! empty( $options['listing_image_slider'] ) ? checked( intval( $options['listing_image_slider'] ), 1 ) : ''; ?>>
													<span class="switcher"></span>
												</label>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Room Rating status: ', 'ravis-booking' ) ?></label>
												<label class="ravis-booking-switch">
													<input name="ravis-booking-setting[rating_status]" value="1" type="checkbox" <?php ! empty( $options['rating_status'] ) ? checked( intval( $options['rating_status'] ), 1 ) : ''; ?>>
													<span class="switcher"></span>
												</label>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Room Rating Item: ', 'ravis-booking' ) ?></label>
												<div class="email-receiver-container">
													<ul>
														<?php
															if ( ! empty( $options['rating_item'] ) )
															{
																foreach ( $options['rating_item'] as $index => $rating_item_item )
																{
																	?>
																	<li>
																		<input type="text" name="ravis-booking-setting[rating_item][<?php echo esc_attr( $index ) ?>]" value="<?php echo esc_attr( $rating_item_item ) ?>">
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
														<a class="add-email-receiver button button-primary button-large" href="#"><?php esc_html_e( 'Add New', 'ravis-booking' ) ?></a>
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
												<label><?php esc_html_e( 'Default Email Sender : ', 'ravis-booking' ) ?></label>
												<input type="email" name="ravis-booking-setting[wp_email_sender]" value="<?php echo ! empty( $options['wp_email_sender'] ) ? esc_attr( $options['wp_email_sender'] ) : '' ?>"/>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Default Email Sender\'s Name : ', 'ravis-booking' ) ?></label>
												<input type="text" name="ravis-booking-setting[wp_email_sender_name]" value="<?php echo ! empty( $options['wp_email_sender_name'] ) ? esc_attr( $options['wp_email_sender_name'] ) : '' ?>"/>
											</div>
										</div>
									</div>
								</div>
								<div class="r-col ravis-col one-third pl">
									<div class="ravis-info-box">
										<div class="header">
											<i class="dashicons dashicons-info"></i><?php esc_html_e( 'Instruction', 'ravis-booking' ) ?>
										</div>
										<div class="content">
											<ol>
												<li>
													<?php esc_html_e( '"Room Archive Page Layout" will be used for "Room Archive" page template.', 'ravis-booking' ) ?>
												</li>
												<li>
													<?php esc_html_e( 'Booking URL is used for booking page that you can modify it. It will be show in address bar after ? and the default value is "?ravis-booking"', 'ravis-booking' ) ?>
												</li>
												<li>
													<?php esc_html_e( 'If you enable "Room Listing Image Slider", all the rooms\' images will be shown in slider in listing views.', 'ravis-booking' ) ?>
												</li>
												<li>
													<?php esc_html_e( 'You can enable/disable rating system and handle its items in this section.', 'ravis-booking' ) ?>
												</li>
												<li>
													<?php esc_html_e( 'The contact page\'s URL will be used in every sections that users need extra information.', 'ravis-booking' ) ?>
												</li>
												<li>
													<?php esc_html_e( 'You can manage home many Booking Items and Payments will be shown in your panel.', 'ravis-booking' ) ?>
												</li>
												<li>
													<?php esc_html_e( 'By help of "Default Email Sender" and "Default Email Sender\'s Name" you can change the default WordPress email sender and its name. It is used for sending core feature\'s notification like registration and etc. The default email sender of WordPress is "wordpress@your_domain.com" and its name is "WordPress".', 'ravis-booking' ) ?>
												</li>
											</ol>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-content" id="tabs-8">
								<div class="l-col ravis-col two-third clearfix">
									<div class="ravis-box">
										<div class="field-rows fields clearfix">
											<div class="row">
												<label><?php esc_html_e( 'Room Base Price : ', 'ravis-booking' ) ?></label>
												<label class="ravis-booking-switch">
													<input name="ravis-booking-setting[room_base_price]" value="1" type="checkbox" <?php ! empty( $options['room_base_price'] ) ? checked( intval( $options['room_base_price'] ), 1 ) : ''; ?>>
													<span class="switcher"></span>
												</label>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Vat (percent) : ', 'ravis-booking' ) ?></label>
												<input type="number" name="ravis-booking-setting[vat]" value="<?php echo ! empty( $options['vat'] ) ? esc_attr( $options['vat'] ) : 'ravis-booking' ?>"/>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Deposit in Booking Process : ', 'ravis-booking' ) ?></label>
												<label class="ravis-booking-switch">
													<input name="ravis-booking-setting[deposit_status]" value="1" type="checkbox" <?php ! empty( $options['deposit_status'] ) ? checked( intval( $options['deposit_status'] ), 1 ) : ''; ?>>
													<span class="switcher"></span>
												</label>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Deposit (percent): ', 'ravis-booking' ) ?></label>
												<input type="number" name="ravis-booking-setting[deposit]" value="<?php echo ! empty( $options['deposit'] ) ? esc_attr( $options['deposit'] ) : 'ravis-booking' ?>"/>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Booking By Email : ', 'ravis-booking' ) ?></label>
												<label class="ravis-booking-switch">
													<input name="ravis-booking-setting[email_booking]" value="1" type="checkbox" <?php ! empty( $options['email_booking'] ) ? checked( intval( $options['email_booking'] ), 1 ) : ''; ?>>
													<span class="switcher"></span>
												</label>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Terms & Condition Page URL : ', 'ravis-booking' ) ?></label>
												<?php
													if ( function_exists( 'icl_get_languages' ) )
													{
														$langs = icl_get_languages( 'skip_missing=N&orderby=KEY&order=DIR&link_empty_to=str' );
														foreach ( $langs as $lang => $lang_info )
														{
															echo '
															<div class="field-row clear">
																<label class="lang-label">' . esc_html( $lang_info['native_name'] ) . ' : </label>
																<input type="url" name="ravis-booking-setting[condition_url][' . esc_attr( $lang ) . ']" value="' . ( ! empty( $options['condition_url'][ $lang ] ) ? esc_attr( $options['condition_url'][ $lang ] ) : '' ) . '"/>
															</div>
															';
														}
													}
													else
													{
														$condition_url = is_array( $options['condition_url'] ) ? reset( $options['condition_url'] ) : $options['condition_url'];
														?>
														<input type="url" name="ravis-booking-setting[condition_url]" value="<?php echo ! empty( $condition_url ) ? esc_attr( $condition_url ) : '' ?>"/>
														<?php
													}
												?>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Final Booking Page Title : ', 'ravis-booking' ) ?></label>
												<input type="text" name="ravis-booking-setting[final_booking_title]" value="<?php echo ! empty( $options['final_booking_title'] ) ? esc_attr( $options['final_booking_title'] ) : '' ?>"/>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Final Booking Page Subtitle : ', 'ravis-booking' ) ?></label>
												<input type="text" name="ravis-booking-setting[final_booking_subtitle]" value="<?php echo ! empty( $options['final_booking_subtitle'] ) ? esc_attr( $options['final_booking_subtitle'] ) : '' ?>"/>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Final Booking Page Description : ', 'ravis-booking' ) ?></label>
												<textarea name="ravis-booking-setting[final_booking_desc]"><?php echo ! empty( $options['final_booking_desc'] ) ? esc_attr( $options['final_booking_desc'] ) : '' ?></textarea>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'External Booking System : ', 'ravis-booking' ) ?></label>
												<label class="ravis-booking-switch">
													<input name="ravis-booking-setting[external_booking]" value="1" type="checkbox" <?php ! empty( $options['external_booking'] ) ? checked( intval( $options['external_booking'] ), 1 ) : ''; ?>>
													<span class="switcher"></span>
												</label>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'External Booking URL : ', 'ravis-booking' ) ?></label>
												<input type="url" name="ravis-booking-setting[external_booking_url]" value="<?php echo ! empty( $options['external_booking_url'] ) ? esc_attr( $options['external_booking_url'] ) : '' ?>"/>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'External Booking Send Method : ', 'ravis-booking' ) ?></label>
												<select name="ravis-booking-setting[external_booking_method]">
													<option value="1" <?php ! empty( $options['external_booking_method'] ) ? selected( $options['external_booking_method'], '1' ) : '' ?>><?php esc_html_e( 'Post', 'ravis-booking' ); ?></option>
													<option value="2" <?php ! empty( $options['external_booking_method'] ) ? selected( $options['external_booking_method'], '2' ) : '' ?>><?php esc_html_e( 'Get', 'ravis-booking' ); ?></option>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="r-col ravis-col one-third pl">
									<div class="ravis-info-box">
										<div class="header">
											<i class="dashicons dashicons-info"></i><?php esc_html_e( 'Instruction', 'ravis-booking' ) ?>
										</div>
										<div class="content">
											<ol>
												<li class="red">
													<b>
														<?php esc_html_e( 'If you enable "Room Base Price", all of your room\'s price will be calculated based on the room\'s main capacity. It means that the price will be fixed untill the guest count is more than the main capacity of rooms.', 'ravis-booking' ) ?>
													</b>
												</li>
												<li>
													<?php esc_html_e( 'Default value for vat is 8%, if you want to use the default value leave it blank.', 'ravis-booking' ) ?>
												</li>
												<li>
													<?php esc_html_e( 'You can enable/disable deposit in the booking process, if you disable it, all users must pay full price of theri bookings', 'ravis-booking' ) ?>
												</li>
												<li>
													<?php esc_html_e( 'Default value of deposit us 20%, so if you want to use the default value leave it blank.', 'ravis-booking' ) ?>
												</li>
												<li>
													<?php esc_html_e( 'You can enable/disable booking by email, in booking by email process, users can book without any payments.', 'ravis-booking' ) ?>
												</li>
												<li>
													<?php esc_html_e( 'Set your email to all payments will be done in your account.', 'ravis-booking' ) ?>
												</li>
												<li>
													<?php esc_html_e( 'If you set external booking system for your website, all the booking settings will be ignored and the booking information will send information to your url', 'ravis-booking' ) ?>
												</li>
												<li>
													<?php esc_html_e( 'If you set external booking system for your website, you can set that booking information will be sent to your URL in Post or Get method.', 'ravis-booking' ) ?>
												</li>
											</ol>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-content" id="tabs-10">
								<div class="l-col ravis-col two-third clearfix">
									<div class="ravis-box">
										<div class="field-rows fields clearfix">
											<div class="row">
												<label><?php esc_html_e( 'Booking By PayPal : ', 'ravis-booking' ) ?></label>
												<label class="ravis-booking-switch">
													<input name="ravis-booking-setting[paypal_booking]" value="1" type="checkbox" <?php ! empty( $options['paypal_booking'] ) ? checked( intval( $options['paypal_booking'] ), 1 ) : ''; ?>>
													<span class="switcher"></span>
												</label>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Paypal Email : ', 'ravis-booking' ) ?></label>
												<input type="email" name="ravis-booking-setting[paypal_email]" value="<?php echo ! empty( $options['paypal_email'] ) ? esc_attr( $options['paypal_email'] ) : '' ?>"/>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Paypal Action URL : ', 'ravis-booking' ) ?></label>
												<input type="url" name="ravis-booking-setting[paypal_action_url]" value="<?php echo ! empty( $options['paypal_action_url'] ) ? esc_attr( $options['paypal_action_url'] ) : '' ?>"/>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Paypal Default Currency : ', 'ravis-booking' ) ?></label>
												<select name="ravis-booking-setting[paypal_default_currency]">
													<option value="no_item" <?php ! empty( $options['paypal_default_currency'] ) ? selected( $options['paypal_default_currency'], 'no_item' ) : '' ?>><?php esc_html_e('Current Currency','ravis-booking');  ?></option>
													<?php
														foreach ( $options['currency'] as $index => $currency_item )
														{
															echo '<option value="'. esc_attr($currency_item['title']) .'" '. (! empty( $options['paypal_default_currency'] ) ? selected( $options['paypal_default_currency'], $currency_item['title'] ) : '') .'>'. esc_html($currency_item['title']) .'</option>';
														}
													?>
												</select>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Booking By Paymill : ', 'ravis-booking' ) ?></label>
												<label class="ravis-booking-switch">
													<input name="ravis-booking-setting[paymill_booking]" value="1" type="checkbox" <?php ! empty( $options['paymill_booking'] ) ? checked( intval( $options['paymill_booking'] ), 1 ) : ''; ?>>
													<span class="switcher"></span>
												</label>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Paymill Private Key : ', 'ravis-booking' ) ?></label>
												<input type="text" name="ravis-booking-setting[paymill_private_key]" value="<?php echo ! empty( $options['paymill_private_key'] ) ? esc_attr( $options['paymill_private_key'] ) : '' ?>"/>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Paymill Public Key : ', 'ravis-booking' ) ?></label>
												<input type="text" name="ravis-booking-setting[paymill_public_key]" value="<?php echo ! empty( $options['paymill_public_key'] ) ? esc_attr( $options['paymill_public_key'] ) : '' ?>"/>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Booking By Stripe : ', 'ravis-booking' ) ?></label>
												<label class="ravis-booking-switch">
													<input name="ravis-booking-setting[stripe_booking]" value="1" type="checkbox" <?php ! empty( $options['stripe_booking'] ) ? checked( intval( $options['stripe_booking'] ), 1 ) : ''; ?>>
													<span class="switcher"></span>
												</label>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Stripe Publishable Key : ', 'ravis-booking' ) ?></label>
												<input type="text" name="ravis-booking-setting[stripe_publish_key]" value="<?php echo ! empty( $options['stripe_publish_key'] ) ? esc_attr( $options['stripe_publish_key'] ) : '' ?>"/>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Stripe Secret Key : ', 'ravis-booking' ) ?></label>
												<input type="text" name="ravis-booking-setting[stripe_secret_key]" value="<?php echo ! empty( $options['stripe_secret_key'] ) ? esc_attr( $options['stripe_secret_key'] ) : '' ?>"/>
											</div>
										</div>
									</div>
								</div>
								<div class="r-col ravis-col one-third pl">
									<div class="ravis-info-box">
										<div class="header">
											<i class="dashicons dashicons-info"></i><?php esc_html_e( 'Instruction', 'ravis-booking' ) ?>
										</div>
										<div class="content">
											<ol>
												<li>
													<?php esc_html_e( 'You can change the action url for payment\'s form. For testing paypayl use https://www.sandbox.paypal.com/cgi-bin/webscr and after testing use the real one : https://www.paypal.com/cgi-bin/webscr', 'ravis-booking' ) ?>
												</li>
												<li class="red">
													<?php esc_html_e( 'Do not forget to change https://www.sandbox.paypal.com/cgi-bin/webscr to https://www.paypal.com/cgi-bin/webscr after your tests.', 'ravis-booking' ) ?>
												</li>
												<li class="red">
													<?php esc_html_e( 'If you set a default currency for Paypal, total booking price will be exchanged to this currency before sending to Paypal website.', 'ravis-booking' ) ?>
												</li>
												<li>
													<?php esc_html_e( 'If you set a "Current Currency" default currency for Paypal, total booking price will calculated based on the user-selected or current currency before sending to Paypal website.', 'ravis-booking' ) ?>
												</li>
												<li>
													<?php esc_html_e( 'If you need to have Paymill payments in your booking process, after enabling its option, you must enter both Private and Public keys in this section. For further information, you can check this URL : https://developers.paymill.com/guides/introduction/your-account#2-api-keys', 'ravis-booking' ) ?>
												</li>
												<li>
													<?php esc_html_e( 'If you need to have Stripe payments in your booking process, after enabling its option, you must enter both Publishable and Secter keys in this section. For further information, you can check this URL : https://stripe.com/docs/dashboard#api-keys', 'ravis-booking' ) ?>
												</li>
											</ol>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-content" id="tabs-2">
								<div class="l-col ravis-col two-third clearfix">
									<div class="ravis-box">
										<div class="field-rows fields clearfix">
											<div class="row">
												<label><?php esc_html_e( 'Email Notification Status : ', 'ravis-booking' ) ?></label>
												<label class="ravis-booking-switch">
													<input name="ravis-booking-setting[email_notification_status]" value="1" type="checkbox" <?php ! empty( $options['email_notification_status'] ) ? checked( intval( $options['email_notification_status'] ), 1 ) : ''; ?>>
													<span class="switcher"></span>
												</label>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Email Sender : ', 'ravis-booking' ) ?></label>
												<input type="email" name="ravis-booking-setting[email_sender]" value="<?php echo ! empty( $options['email_sender'] ) ? esc_attr( $options['email_sender'] ) : '' ?>" placeholder="<?php esc_html_e( 'email@yourwebsite.com', 'ravis-booking' ) ?>"/>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Email Receiver : ', 'ravis-booking' ) ?></label>
												<div class="email-receiver-container">
													<ul>
														<?php
															if ( ! empty( $options['email_receiver'] ) )
															{
																foreach ( $options['email_receiver'] as $index => $email_receiver_item )
																{
																	?>
																	<li>
																		<input type="email" name="ravis-booking-setting[email_receiver][<?php echo esc_attr( $index ) ?>]" value="<?php echo esc_attr( $email_receiver_item ) ?>">
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
														<a class="add-email-receiver button button-primary button-large" href="#"><?php esc_html_e( 'Add New', 'ravis-booking' ) ?></a>
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
												<label><?php esc_html_e( 'Booking Details For Users : ', 'ravis-booking' ) ?></label>
												<label class="ravis-booking-switch">
													<input name="ravis-booking-setting[guest_receiver]" value="1" type="checkbox" <?php ! empty( $options['guest_receiver'] ) ? checked( intval( $options['guest_receiver'] ), 1 ) : ''; ?>>
													<span class="switcher"></span>
												</label>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Email Template of Admins : ', 'ravis-booking' ) ?></label>
												<?php
													$admin_tmpl_content = ! empty( $options['email_admin_tmpl'] ) ? balanceTags( $options['email_admin_tmpl'] ) : '';
													$editor_arg         = array (
														'textarea_name' => 'ravis-booking-setting[email_admin_tmpl]',
														'editor_height' => 300
													);
													wp_editor( $admin_tmpl_content, 'email_admin_tmpl', $editor_arg );
												?>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Email template of users : ', 'ravis-booking' ) ?></label>
												<?php
													$user_tmpl_content = ! empty( $options['email_user_tmpl'] ) ? balanceTags( $options['email_user_tmpl'] ) : '';
													$editor_arg        = array (
														'textarea_name' => 'ravis-booking-setting[email_user_tmpl]',
														'editor_height' => 300
													);
													wp_editor( $user_tmpl_content, 'email_user_tmpl', $editor_arg );
												?>
											</div>
										</div>
									</div>
								</div>
								<div class="r-col ravis-col one-third pl">
									<div class="ravis-info-box">
										<div class="header">
											<i class="dashicons dashicons-info"></i><?php esc_html_e( 'Instruction', 'ravis-booking' ) ?>
										</div>
										<div class="content">
											<ol>
												<li>
													<b class="red"><?php esc_html_e( 'Important Note : ', 'ravis-booking' ) ?></b><br><?php esc_html_e( 'Use an email from your website for email sender. For example if your website is "your_website.com", your email must be something like "sender@your_website.com"', 'ravis-booking' ) ?>
												</li>
												<li>
													<b><?php esc_html_e( 'Email Template of Admins : ', 'ravis-booking' ) ?></b><br><?php esc_html_e( 'For putting extra information in your email, you can use these shortcode to provide more details about the booking. Here is the list of shortcode that you can use in this field :', 'ravis-booking' ) ?>
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
													<b><?php esc_html_e( 'Email Template of Users : ', 'ravis-booking' ) ?></b><br><?php esc_html_e( 'For putting extra information in your email, you can use these shortcode to provide more details about the booking. Here is the list of shortcode that you can use in this field :', 'ravis-booking' ) ?>
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
													<b class="red"><?php esc_html_e( 'Booking Details For Users :', 'ravis-booking' ) ?> </b> <?php esc_html_e( 'If you want your guests receive their booking information you set for the admins of website, enable this option.', 'ravis-booking' ) ?>
												</li>
											</ol>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-content" id="tabs-3">
								<div class="l-col ravis-col two-third clearfix">
									<div class="ravis-box">
										<div class="field-rows fields clearfix">
											<div class="row">
												<label><?php esc_html_e( 'Currency Separator : ', 'ravis-booking' ) ?></label>
												<select name="ravis-booking-setting[currency_separator]">
													<option value="1" <?php ! empty( $options['currency_separator'] ) ? selected( $options['currency_separator'], '1' ) : '' ?>>,</option>
													<option value="2" <?php ! empty( $options['currency_separator'] ) ? selected( $options['currency_separator'], '2' ) : '' ?>>.</option>
													<option value="3" <?php ! empty( $options['currency_separator'] ) ? selected( $options['currency_separator'], '3' ) : '' ?>><?php esc_html_e( 'Space', 'ravis-booking' ); ?></option>
												</select>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Currency Decimal : ', 'ravis-booking' ) ?></label>
												<select name="ravis-booking-setting[currency_decimal]">
													<option value="" <?php ! empty( $options['currency_decimal'] ) ? selected( $options['currency_decimal'], '' ) : '' ?>>None</option>
													<option value="1" <?php ! empty( $options['currency_decimal'] ) ? selected( $options['currency_decimal'], '1' ) : '' ?>>1</option>
													<option value="2" <?php ! empty( $options['currency_decimal'] ) ? selected( $options['currency_decimal'], '2' ) : '' ?>>2</option>
													<option value="3" <?php ! empty( $options['currency_decimal'] ) ? selected( $options['currency_decimal'], '3' ) : '' ?>>3</option>
													<option value="4" <?php ! empty( $options['currency_decimal'] ) ? selected( $options['currency_decimal'], '4' ) : '' ?>>4</option>
													<option value="5" <?php ! empty( $options['currency_decimal'] ) ? selected( $options['currency_decimal'], '5' ) : '' ?>>5</option>
												</select>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Currency Decimal Separator : ', 'ravis-booking' ) ?></label>
												<select name="ravis-booking-setting[currency_decimal_separator]">
													<option value="1" <?php ! empty( $options['currency_decimal_separator'] ) ? selected( $options['currency_decimal_separator'], '1' ) : '' ?>>.</option>
													<option value="2" <?php ! empty( $options['currency_decimal_separator'] ) ? selected( $options['currency_decimal_separator'], '2' ) : '' ?>>,</option>
												</select>
											</div>
											<div class="currency-boxes-container">
												<?php
													if ( ! empty( $options['currency'] ) )
													{
														foreach ( $options['currency'] as $index => $currency_item )
														{
															$rate = 0;
															if ( intval( $options['default_currency'] ) === $index )
															{
																$rate = 1;
															}
															elseif ( ! empty( $currency_item['rate'] ) )
															{
																$rate = $currency_item['rate'];
															}
															?>
															<div class="currency-box currency-box-active <?php echo ( intval( $options['default_currency'] ) === $index ) ? esc_attr( 'default' ) : '' ?>">
																<div class="remove-box">
																	<i class="dashicons dashicons-no-alt"></i>
																</div>
																<div class="fields clearfix">
																	<div class="row">
																		<label><?php esc_html_e( 'Title : ', 'ravis-booking' ) ?></label>
																		<input type="text" name="ravis-booking-setting[currency][<?php echo esc_attr( $index ) ?>][title]" value="<?php echo ! empty( $currency_item['title'] ) ? esc_attr( $currency_item['title'] ) : '' ?>" placeholder="<?php esc_html_e( 'Title', 'ravis-booking' ) ?>"/>
																	</div>
																	<div class="row">
																		<label><?php esc_html_e( 'Symbol : ', 'ravis-booking' ) ?></label>
																		<input type="text" name="ravis-booking-setting[currency][<?php echo esc_attr( $index ) ?>][symbol]" value="<?php echo ! empty( $currency_item['symbol'] ) ? esc_attr( $currency_item['symbol'] ) : '' ?>" placeholder="<?php esc_html_e( 'Symbol', 'ravis-booking' ) ?>"/>
																	</div>
																	<div class="row">
																		<label><?php esc_html_e( 'Rate : ', 'ravis-booking' ) ?></label>
																		<input type="number" min="0" step="any" class="currency-rate" name="ravis-booking-setting[currency][<?php echo esc_attr( $index ) ?>][rate]" value="<?php echo esc_attr( $rate ); ?>" placeholder="<?php esc_html_e( 'Rate', 'ravis-booking' ) ?>" <?php echo ( intval( $options['default_currency'] ) === $index ) ? 'readonly="readonly"' : ''; ?> />
																	</div>
																</div>
																<div class="ravis-checkbox currency-position">
																	<label>
																		<input type="checkbox" name="ravis-booking-setting[currency][<?php echo esc_attr( $index ) ?>][position]" value="1" <?php ! empty( $currency_item['position'] ) && checked( $currency_item['position'], '1' ) ?>/>
																		<span></span>
																		<?php esc_html_e( 'Check this field if you want to show the currency before its value', 'ravis-booking' ) ?>
																	</label>
																</div>
																<div class="ravis-radiobox currency-default">
																	<label>
																		<input type="radio" name="ravis-booking-setting[default_currency]" value="<?php echo esc_attr( $index ) ?>"
																			<?php
																				if ( empty( $options['default_currency'] ) )
																				{
																					checked( intval( $options['default_currency'] ), 0 );
																				}
																				else
																				{
																					checked( intval( $options['default_currency'] ), $index );
																				} ?>/>
																		<span></span>
																		<?php esc_html_e( 'Set this currency as default currency of your website.', 'ravis-booking' ) ?>
																	</label>
																</div>
															</div>
															<?php
														}
													}
												?>
											</div>
											<div class="add-currency-box">
												<a class="currency-add button button-primary button-large" href="#"><?php esc_html_e( 'Add Currency', 'ravis-booking' ) ?></a>
											</div>
											<div class="currency-box-tpl" style="display:none;">
												<div class="currency-box">
													<div class="remove-box"><i class="dashicons dashicons-no-alt"></i>
													</div>
													<div class="fields clearfix">
														<div class="row">
															<label><?php esc_html_e( 'Title : ', 'ravis-booking' ) ?></label>
															<input type="text" name="" data-name="title" value="" placeholder="<?php esc_html_e( 'Title', 'ravis-booking' ) ?>"/>
														</div>
														<div class="row">
															<label><?php esc_html_e( 'Symbol : ', 'ravis-booking' ) ?></label>
															<input type="text" name="" data-name="symbol" value="" placeholder="<?php esc_html_e( 'Symbol', 'ravis-booking' ) ?>"/>
														</div>
														<div class="row">
															<label><?php esc_html_e( 'Rate : ', 'ravis-booking' ) ?></label>
															<input type="number" min="0" step="any" name="" data-name="rate" value="" placeholder="<?php esc_html_e( 'Rate', 'ravis-booking' ) ?>"/>
														</div>
													</div>
													<div class="ravis-checkbox currency-position">
														<label>
															<input type="checkbox" name="" data-name="position" value="1"/>
															<span></span>
															<?php esc_html_e( 'Check this field if you want to show the currency before its value', 'ravis-booking' ) ?>
														</label>
													</div>
													<div class="ravis-radiobox currency-default">
														<label>
															<input type="radio" name="ravis-booking-setting[default_currency]"/>
															<span></span>
															<?php esc_html_e( 'Set this currency as default currency of your website.', 'ravis-booking' ) ?>
														</label>
													</div>

												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="r-col ravis-col one-third pl">
									<div class="ravis-box">
										<div class="update-currency-container" id="currency-update-now">
											<a class="update-currency button button-primary button-large" href="#">
												<i class="dashicons dashicons-update"></i><?php esc_html_e( 'Update Currency Rate Now', 'ravis-booking' ) ?>
											</a>
											<span class="message"></span>
										</div>
									</div>
									<div class="ravis-info-box">
										<div class="header">
											<i class="dashicons dashicons-info"></i><?php esc_html_e( 'Instruction', 'ravis-booking' ) ?>
										</div>
										<div class="content">
											<ol>
												<li class="red"><?php esc_html_e( 'In some cases automatic currency updated might have technical issue, in this circumstances you can set all the currency manually.', 'ravis-booking' ) ?></li>
												<li><?php esc_html_e( 'Update currency button just works for the saved currency.', 'ravis-booking' ) ?></li>
												<li><?php esc_html_e( 'After updating the rates page will be refreshed.', 'ravis-booking' ) ?></li>
												<li><?php esc_html_e( 'If you don\'t set the default currency, the first currency will be considered as the default.', 'ravis-booking' ) ?></li>
												<li><?php esc_html( printf( 'You can find your currency title from <a target="_blank" href="%s">HERE</a>. "Currency Code" is the column that you must search on.', 'http://www.xe.com/symbols.php' ), 'ravis-booking' ); ?></li>
												<li><?php esc_html( printf( 'You can find your currency symbol from <a target="_blank" href="%s">HERE</a>. "Arial Unicode MS" is the column that you must search on.', 'http://www.xe.com/symbols.php' ), 'ravis-booking' ); ?></li>
											</ol>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-content" id="tabs-4">
								<div class="l-col ravis-col two-third clearfix">
									<div class="ravis-box">
										<div class="field-rows fields clearfix">
											<div class="row">
												<label><?php esc_html_e( 'Twitter : ', 'ravis-booking' ) ?></label>
												<input type="text" name="ravis-booking-setting[social_icons][twitter]" value="<?php echo ! empty( $options['social_icons']['twitter'] ) ? esc_attr( $options['social_icons']['twitter'] ) : '' ?>"/>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Facebook : ', 'ravis-booking' ) ?></label>
												<input type="text" name="ravis-booking-setting[social_icons][facebook]" value="<?php echo ! empty( $options['social_icons']['facebook'] ) ? esc_attr( $options['social_icons']['facebook'] ) : '' ?>"/>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Google Plus : ', 'ravis-booking' ) ?></label>
												<input type="text" name="ravis-booking-setting[social_icons][gplus]" value="<?php echo ! empty( $options['social_icons']['gplus'] ) ? esc_attr( $options['social_icons']['gplus'] ) : '' ?>"/>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Flickr : ', 'ravis-booking' ) ?></label>
												<input type="text" name="ravis-booking-setting[social_icons][flickr]" value="<?php echo ! empty( $options['social_icons']['flickr'] ) ? esc_attr( $options['social_icons']['flickr'] ) : '' ?>"/>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Vimeo : ', 'ravis-booking' ) ?></label>
												<input type="text" name="ravis-booking-setting[social_icons][vimeo]" value="<?php echo ! empty( $options['social_icons']['vimeo'] ) ? esc_attr( $options['social_icons']['vimeo'] ) : '' ?>"/>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Youtube : ', 'ravis-booking' ) ?></label>
												<input type="text" name="ravis-booking-setting[social_icons][youtube]" value="<?php echo ! empty( $options['social_icons']['youtube'] ) ? esc_attr( $options['social_icons']['youtube'] ) : '' ?>"/>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Pinterest : ', 'ravis-booking' ) ?></label>
												<input type="text" name="ravis-booking-setting[social_icons][pinterest]" value="<?php echo ! empty( $options['social_icons']['pinterest'] ) ? esc_attr( $options['social_icons']['pinterest'] ) : '' ?>"/>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Tumblr : ', 'ravis-booking' ) ?></label>
												<input type="text" name="ravis-booking-setting[social_icons][tumblr]" value="<?php echo ! empty( $options['social_icons']['tumblr'] ) ? esc_attr( $options['social_icons']['tumblr'] ) : '' ?>"/>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Dribbble : ', 'ravis-booking' ) ?></label>
												<input type="text" name="ravis-booking-setting[social_icons][dribbble]" value="<?php echo ! empty( $options['social_icons']['dribbble'] ) ? esc_attr( $options['social_icons']['dribbble'] ) : '' ?>"/>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Digg : ', 'ravis-booking' ) ?></label>
												<input type="text" name="ravis-booking-setting[social_icons][digg]" value="<?php echo ! empty( $options['social_icons']['digg'] ) ? esc_attr( $options['social_icons']['digg'] ) : '' ?>"/>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Linkedin : ', 'ravis-booking' ) ?></label>
												<input type="text" name="ravis-booking-setting[social_icons][linkedin]" value="<?php echo ! empty( $options['social_icons']['linkedin'] ) ? esc_attr( $options['social_icons']['linkedin'] ) : '' ?>"/>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Blogger : ', 'ravis-booking' ) ?></label>
												<input type="text" name="ravis-booking-setting[social_icons][blogger]" value="<?php echo ! empty( $options['social_icons']['blogger'] ) ? esc_attr( $options['social_icons']['blogger'] ) : '' ?>"/>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Skype : ', 'ravis-booking' ) ?></label>
												<input type="text" name="ravis-booking-setting[social_icons][skype]" value="<?php echo ! empty( $options['social_icons']['skype'] ) ? esc_attr( $options['social_icons']['skype'] ) : '' ?>"/>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Forrst : ', 'ravis-booking' ) ?></label>
												<input type="text" name="ravis-booking-setting[social_icons][forrst]" value="<?php echo ! empty( $options['social_icons']['forrst'] ) ? esc_attr( $options['social_icons']['forrst'] ) : '' ?>"/>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Deviantart : ', 'ravis-booking' ) ?></label>
												<input type="text" name="ravis-booking-setting[social_icons][deviantart]" value="<?php echo ! empty( $options['social_icons']['deviantart'] ) ? esc_attr( $options['social_icons']['deviantart'] ) : '' ?>"/>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Yahoo : ', 'ravis-booking' ) ?></label>
												<input type="text" name="ravis-booking-setting[social_icons][yahoo]" value="<?php echo ! empty( $options['social_icons']['yahoo'] ) ? esc_attr( $options['social_icons']['yahoo'] ) : '' ?>"/>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Reddit : ', 'ravis-booking' ) ?></label>
												<input type="text" name="ravis-booking-setting[social_icons][reddit]" value="<?php echo ! empty( $options['social_icons']['reddit'] ) ? esc_attr( $options['social_icons']['reddit'] ) : '' ?>"/>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Instagram : ', 'ravis-booking' ) ?></label>
												<input type="text" name="ravis-booking-setting[social_icons][instagram]" value="<?php echo ! empty( $options['social_icons']['instagram'] ) ? esc_attr( $options['social_icons']['instagram'] ) : '' ?>"/>
											</div>
										</div>
									</div>
								</div>
								<div class="r-col ravis-col one-third pl clearfix">
									<div class="ravis-info-box">
										<div class="header">
											<i class="dashicons dashicons-info"></i><?php esc_html_e( 'Instruction', 'ravis-booking' ) ?>
										</div>
										<div class="content">
											<ol>
												<li><?php esc_html_e( 'You can add your social network addresses in these fields to be used in [ravis-booking-social-icons] shortcode.', 'ravis-booking' ) ?></li>
												<li><?php esc_html_e( 'If you do not want to show any icons, leave the field blank.', 'ravis-booking' ) ?></li>
											</ol>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-content" id="tabs-5">
								<div class="l-col ravis-col two-third clearfix">
									<div class="ravis-box">
										<div class="field-rows fields clearfix">
											<div class="row">
												<label><?php esc_html_e( 'Main Slider : ', 'ravis-booking' ) ?></label>
												<div class="img-uploader-box">
													<div class="img-uploader clearfix">
														<?php
															if ( ! empty( $options['main_slider'] ) )
															{
																$img_gallery_ids_array = explode( ',', $options['main_slider'] );
																$img_gallery_ids       = '';
																foreach ( $img_gallery_ids_array as $img_id )
																{
																	$img_gallery_ids .= $img_id . ',';
																	$img_info        = wp_get_attachment_thumb_url( $img_id );
																	echo '<div class="image-preview-box"><img src="' . esc_url( $img_info ) . '"/></div>';
																}
															}
														?>
													</div>
													<a href="#" class="button button-primary admin-img-uploader"><?php esc_html_e( 'Add / Update Images', 'ravis-booking' ) ?></a>
													<a href="#" class="button button-primary admin-img-uploader clear-btn"><?php esc_html_e( 'Clear Images', 'ravis-booking' ) ?></a>
													<input type="hidden" name="ravis-booking-setting[main_slider]" class="img-field" value="<?php echo ! empty( $img_gallery_ids ) ? esc_attr( trim( $img_gallery_ids, ',' ) ) : ''; ?>">
												</div>
											</div>
											<div class="row">
												<label><?php esc_html_e( 'Gallery : ', 'ravis-booking' ) ?></label>
												<div class="img-uploader-box">
													<div class="img-uploader clearfix">
														<?php
															if ( ! empty( $options['main_gallery'] ) )
															{
																$img_gallery_ids_array = explode( ',', $options['main_gallery'] );
																$img_gallery_ids       = '';
																foreach ( $img_gallery_ids_array as $img_id )
																{
																	$img_gallery_ids .= $img_id . ',';
																	$img_info        = wp_get_attachment_thumb_url( $img_id );
																	echo '<div class="image-preview-box"><img src="' . esc_url( $img_info ) . '"/></div>';
																}
															}
														?>
													</div>
													<a href="#" class="button button-primary admin-img-uploader"><?php esc_html_e( 'Add / Update Images', 'ravis-booking' ) ?></a>
													<a href="#" class="button button-primary admin-img-uploader clear-btn"><?php esc_html_e( 'Clear Images', 'ravis-booking' ) ?></a>
													<input type="hidden" name="ravis-booking-setting[main_gallery]" class="img-field" value="<?php echo ! empty( $img_gallery_ids ) ? esc_attr( trim( $img_gallery_ids, ',' ) ) : ''; ?>">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="r-col ravis-col one-third pl clearfix">
									<div class="ravis-info-box">
										<div class="header">
											<i class="dashicons dashicons-info"></i><?php esc_html_e( 'Instruction', 'ravis-booking' ) ?>
										</div>
										<div class="content">
											<ol>
												<li><?php esc_html_e( 'You can manage the images of [ravis-booking-main-slider] shortcode in this section.', 'ravis-booking' ) ?></li>
												<li><?php esc_html_e( 'In the second item of this page, you can manage the images of [ravis-booking-gallery] shortcode in this section.', 'ravis-booking' ) ?></li>
											</ol>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-content" id="tabs-6">
								<div class="l-col ravis-col two-third clearfix">
									<div class="client-boxes-container">
										<?php
											if ( ! empty( $options['client'] ) )
											{
												foreach ( $options['client'] as $index => $client_item )
												{
													$img_preview = $img_info = '';
													if ( ! empty( $client_item['logo'] ) )
													{
														$img_info    = wp_get_attachment_thumb_url( $client_item['logo'] );
														$img_preview = ( ! empty( $img_info ) ? '<div class="image-preview-box"><img src="' . esc_url( $img_info ) . '"/></div>' : '' );
													} ?>
													<div class="client-box">
														<div class="remove-box">
															<i class="dashicons dashicons-no-alt"></i>
														</div>
														<div class="fields clearfix">
															<div class="row">
																<label><?php esc_html_e( 'Title : ', 'ravis-booking' ) ?></label>
																<input type="text" name="ravis-booking-setting[client][<?php echo esc_attr( $index ) ?>][title]" value="<?php echo ! empty( $client_item['title'] ) ? esc_attr( $client_item['title'] ) : '' ?>" placeholder="<?php esc_html_e( 'Title', 'ravis-booking' ) ?>"/>
															</div>
															<div class="row">
																<label><?php esc_html_e( 'URL : ', 'ravis-booking' ) ?></label>
																<input type="text" name="ravis-booking-setting[client][<?php echo esc_attr( $index ) ?>][url]" value="<?php echo ! empty( $client_item['url'] ) ? esc_attr( $client_item['url'] ) : '' ?>" placeholder="<?php esc_html_e( 'http://', 'ravis-booking' ) ?>"/>
															</div>
															<div class="row">
																<label><?php esc_html_e( 'Logo : ', 'ravis-booking' ) ?></label>
																<div class="single-image-uploader">
																	<div class="img-container"><?php echo( ! empty( $img_preview ) ? wp_kses_post( $img_preview ) : '' ); ?></div>
																	<a class="add-image button button-primary button-large <?php echo( ! empty( $img_preview ) ? esc_attr( 'hidden' ) : '' ) ?>" href="#"><?php esc_html_e( 'Upload Image', 'ravis-booking' ) ?></a>
																	<a class="remove-image button button-primary button-large <?php echo( empty( $img_preview ) ? esc_attr( 'hidden' ) : '' ) ?>" href="#"><?php esc_html_e( 'Remove Image', 'ravis-booking' ) ?></a>
																	<input type="hidden" name="ravis-booking-setting[client][<?php echo esc_attr( $index ) ?>][logo]" value="<?php echo ! empty( $client_item['logo'] ) ? esc_attr( $client_item['logo'] ) : '' ?>"/>
																</div>
															</div>
														</div>
													</div>
													<?php
												}
											}
										?>
									</div>
									<div class="add-client-box">
										<a class="client-add button button-primary button-large" href="#"><?php esc_html_e( 'Add New', 'ravis-booking' ) ?></a>
									</div>
									<div class="client-box-tpl" style="display:none;">
										<div class="client-box">
											<div class="remove-box">
												<i class="dashicons dashicons-no-alt"></i>
											</div>
											<div class="fields clearfix">
												<div class="row">
													<label><?php esc_html_e( 'Title : ', 'ravis-booking' ) ?></label>
													<input type="text" name="" data-name="title" value="" placeholder="<?php esc_html_e( 'Title', 'ravis-booking' ) ?>"/>
												</div>
												<div class="row">
													<label><?php esc_html_e( 'URL : ', 'ravis-booking' ) ?></label>
													<input type="text" name="" data-name="url" value="" placeholder="<?php esc_html_e( 'http://', 'ravis-booking' ) ?>"/>
												</div>
												<div class="row">
													<label><?php esc_html_e( 'Logo : ', 'ravis-booking' ) ?></label>
													<div class="single-image-uploader">
														<div class="img-container"></div>
														<a class="add-image button button-primary button-large" href="#"><?php esc_html_e( 'Upload Image', 'ravis-booking' ) ?></a>
														<a class="remove-image button button-primary button-large hidden" href="#"><?php esc_html_e( 'Remove Image', 'ravis-booking' ) ?></a>
														<input type="hidden" name="" data-name="logo" value=""/>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="r-col ravis-col one-third pl">
									<div class="ravis-info-box">
										<div class="header">
											<i class="dashicons dashicons-info"></i><?php esc_html_e( 'Instruction', 'ravis-booking' ) ?>
										</div>
										<div class="content">
											<ol>
												<li><?php esc_html_e( 'You can add as much as client you need in this section.', 'ravis-booking' ) ?></li>
												<li><?php esc_html_e( 'Clients you add here, will be generated by [ravis-booking-client] shortcode.', 'ravis-booking' ) ?></li>
												<li><?php esc_html_e( 'Please note that you must enter the url of clients with http://', 'ravis-booking' ) ?></li>
											</ol>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-content" id="tabs-9">
								<div class="l-col ravis-col two-third clearfix">
									<div class="membership-package-main-container">
										<?php
											if ( ! empty( $options['membership'] ) )
											{
												foreach ( $options['membership'] as $index => $membership_item )
												{
													$img_preview = $img_info = '';
													if ( ! empty( $membership_item['badge'] ) )
													{
														$img_info    = wp_get_attachment_thumb_url( $membership_item['badge'] );
														$img_preview = ( ! empty( $img_info ) ? '<div class="image-preview-box"><img src="' . esc_url( $img_info ) . '"/></div>' : '' );
													} ?>
													<div class="membership-package-box">
														<div class="remove-box">
															<i class="dashicons dashicons-no-alt"></i>
														</div>
														<div class="fields clearfix">
															<div class="row">
																<label><?php esc_html_e( 'Title : ', 'ravis-booking' ) ?></label>
																<input type="text" name="ravis-booking-setting[membership][<?php echo esc_attr( $index ) ?>][title]" value="<?php echo ! empty( $membership_item['title'] ) ? esc_attr( $membership_item['title'] ) : '' ?>" placeholder="<?php esc_html_e( 'Title', 'ravis-booking' ) ?>"/>
															</div>
															<div class="row">
																<label><?php esc_html_e( 'Badge : ', 'ravis-booking' ) ?></label>
																<div class="single-image-uploader">
																	<div class="img-container"><?php echo( ! empty( $img_preview ) ? wp_kses_post( $img_preview ) : '' ); ?></div>
																	<a class="add-image button button-primary button-large <?php echo( ! empty( $img_preview ) ? esc_attr( 'hidden' ) : '' ) ?>" href="#"><?php esc_html_e( 'Upload Image', 'ravis-booking' ) ?></a>
																	<a class="remove-image button button-primary button-large <?php echo( empty( $img_preview ) ? esc_attr( 'hidden' ) : '' ) ?>" href="#"><?php esc_html_e( 'Remove Image', 'ravis-booking' ) ?></a>
																	<input type="hidden" name="ravis-booking-setting[membership][<?php echo esc_attr( $index ) ?>][badge]" value="<?php echo ! empty( $membership_item['badge'] ) ? esc_attr( $membership_item['badge'] ) : '' ?>"/>
																</div>
															</div>
															<div class="row">
																<label><?php esc_html_e( 'Conditions : ', 'ravis-booking' ) ?></label>
																<select name="ravis-booking-setting[membership][<?php echo esc_attr( $index ) ?>][condition]" class="membership-condition-switcher">
																	<option value="1" <?php selected( $membership_item['condition'], 1, true ) ?>><?php esc_html_e( 'Total Booking Price', 'ravis-booking' ) ?></option>
																	<option value="2" <?php selected( $membership_item['condition'], 2, true ) ?>><?php esc_html_e( 'Total Booking Items', 'ravis-booking' ) ?></option>
																	<option value="3" <?php selected( $membership_item['condition'], 3, true ) ?>><?php esc_html_e( 'Total Booking Price / Total Booking Items', 'ravis-booking' ) ?></option>
																</select>
															</div>
															<div class="row total-booking-price">
																<label></label>
																<input type="number" min="0" name="ravis-booking-setting[membership][<?php echo esc_attr( $index ) ?>][single-condition-price]" value="<?php echo esc_attr( $membership_item['single-condition-price'] ) ?>" placeholder="<?php esc_html_e( 'Set the total price of bookings', 'ravis-booking' ) ?>"/>
															</div>
															<div class="row total-booking-item hidden">
																<label></label>
																<input type="number" min="0" name="ravis-booking-setting[membership][<?php echo esc_attr( $index ) ?>][single-condition-item]" value="<?php echo esc_attr( $membership_item['single-condition-item'] ) ?>" placeholder="<?php esc_html_e( 'Set the total count of bookings', 'ravis-booking' ) ?>"/>
															</div>
															<div class="row total-booking-price-item hidden">
																<label></label>
																<input type="number" min="0" name="ravis-booking-setting[membership][<?php echo esc_attr( $index ) ?>][condition-price]" value="<?php echo esc_attr( $membership_item['condition-price'] ) ?>" placeholder="<?php esc_html_e( 'Set the total price of bookings', 'ravis-booking' ) ?>"/>
																<select name="ravis-booking-setting[membership][<?php echo esc_attr( $index ) ?>][condition-type]" class="auto-width">
																	<option value="1"<?php selected( $membership_item['condition-type'], 1, true ) ?>><?php esc_html_e( 'AND', 'ravis-booking' ) ?></option>
																	<option value="2"<?php selected( $membership_item['condition-type'], 2, true ) ?>><?php esc_html_e( 'OR', 'ravis-booking' ) ?></option>
																</select>
																<input type="number" min="0" name="ravis-booking-setting[membership][<?php echo esc_attr( $index ) ?>][condition-item]" value="<?php echo esc_attr( $membership_item['condition-item'] ) ?>" placeholder="<?php esc_html_e( 'Set the total count of bookings', 'ravis-booking' ) ?>"/>
															</div>
															<div class="row">
																<label><?php esc_html_e( 'Discount : ', 'ravis-booking' ) ?></label>
																<input type="number" min="0" max="100" name="ravis-booking-setting[membership][<?php echo esc_attr( $index ) ?>][discount]" value="<?php echo ! empty( $membership_item['discount'] ) ? esc_attr( $membership_item['discount'] ) : '' ?>" placeholder="%"/>
															</div>
														</div>
													</div>
													<?php
												}
											}
										?>
									</div>
									<div class="add-client-box">
										<a class="membership-add button button-primary button-large" href="#"><?php esc_html_e( 'Add New', 'ravis-booking' ) ?></a>
									</div>
									<div class="membership-box-tpl" style="display:none;">
										<div class="membership-package-box">
											<div class="remove-box">
												<i class="dashicons dashicons-no-alt"></i>
											</div>
											<div class="fields clearfix">
												<div class="row">
													<label><?php esc_html_e( 'Title : ', 'ravis-booking' ) ?></label>
													<input type="text" name="" data-name="title" value="" placeholder="<?php esc_html_e( 'Title', 'ravis-booking' ) ?>"/>
												</div>
												<div class="row">
													<label><?php esc_html_e( 'Badge : ', 'ravis-booking' ) ?></label>
													<div class="single-image-uploader">
														<div class="img-container"></div>
														<a class="add-image button button-primary button-large" href="#"><?php esc_html_e( 'Upload Image', 'ravis-booking' ) ?></a>
														<a class="remove-image button button-primary button-large hidden" href="#"><?php esc_html_e( 'Remove Image', 'ravis-booking' ) ?></a>
														<input type="hidden" name="" data-name="badge" value=""/>
													</div>
												</div>
												<div class="row">
													<label><?php esc_html_e( 'Conditions : ', 'ravis-booking' ) ?></label>
													<select name="" class="membership-condition-switcher" data-name="condition">
														<option value="1"><?php esc_html_e( 'Total Booking Price', 'ravis-booking' ) ?></option>
														<option value="2"><?php esc_html_e( 'Total Booking Items', 'ravis-booking' ) ?></option>
														<option value="3"><?php esc_html_e( 'Total Booking Price / Total Booking Items', 'ravis-booking' ) ?></option>
													</select>
												</div>
												<div class="row total-booking-price">
													<label></label>
													<input type="number" min="0" name="" data-name="single-condition-price" value="" placeholder="<?php esc_html_e( 'Set the total price of bookings', 'ravis-booking' ) ?>"/>
												</div>
												<div class="row total-booking-item hidden">
													<label></label>
													<input type="number" min="0" name="" data-name="single-condition-item" value="" placeholder="<?php esc_html_e( 'Set the total count of bookings', 'ravis-booking' ) ?>"/>
												</div>
												<div class="row total-booking-price-item hidden">
													<label></label>
													<input type="number" min="0" name="" data-name="condition-price" value="" placeholder="<?php esc_html_e( 'Set the total price of bookings', 'ravis-booking' ) ?>"/>
													<select name="" data-name="condition-type" class="auto-width">
														<option value="1"><?php esc_html_e( 'AND', 'ravis-booking' ) ?></option>
														<option value="2"><?php esc_html_e( 'OR', 'ravis-booking' ) ?></option>
													</select>
													<input type="number" min="0" name="" data-name="condition-item" value="" placeholder="<?php esc_html_e( 'Set the total count of bookings', 'ravis-booking' ) ?>"/>
												</div>
												<div class="row">
													<label><?php esc_html_e( 'Discount : ', 'ravis-booking' ) ?></label>
													<input type="number" min="0" max="100" name="" data-name="discount" value="" placeholder="%"/>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="r-col ravis-col one-third pl">
									<div class="ravis-info-box">
										<div class="header">
											<i class="dashicons dashicons-info"></i><?php esc_html_e( 'Instruction', 'ravis-booking' ) ?>
										</div>
										<div class="content">
											<ol>
												<li><?php esc_html_e( 'You can add as much as membership package you need in this section.', 'ravis-booking' ) ?></li>
												<li><?php esc_html_e( 'In title field you can set a title for your package', 'ravis-booking' ) ?></li>
												<li><?php esc_html_e( 'You can set a badge for your package to be shown in the profile section of users', 'ravis-booking' ) ?></li>
												<li><?php esc_html_e( 'You can set a condition of your package in these 3 ways: based on Total Booking Price, Total Booking items and both of them.', 'ravis-booking' ) ?></li>
												<li><?php esc_html_e( 'After choosing the condition of package some fields based on your selected item will be shown that you can set your prices or count of booking item or both.', 'ravis-booking' ) ?></li>
												<li><?php esc_html_e( 'Please note that in all the price and count fields you just need to add numbers.', 'ravis-booking' ) ?></li>
												<li><?php esc_html_e( 'Every packages must have discount, so you must add discount that you have considered for your package.', 'ravis-booking' ) ?></li>
											</ol>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-content" id="tabs-11">
								<div class="l-col ravis-col two-third clearfix">
									<div class="season-package-main-container">
										<?php
											if ( ! empty( $options['seasonal_price'] ) )
											{
												foreach ( $options['seasonal_price'] as $index => $season_item )
												{
													?>
													<div class="season-package-box">
														<div class="remove-box">
															<i class="dashicons dashicons-no-alt"></i>
														</div>
														<div class="fields clearfix">
															<div class="row">
																<label><?php esc_html_e( 'Title : ', 'ravis-booking' ) ?></label>
																<input type="text" name="ravis-booking-setting[seasonal_price][<?php echo esc_attr( $index ) ?>][title]" value="<?php echo ! empty( $season_item['title'] ) ? esc_attr( $season_item['title'] ) : '' ?>" placeholder="<?php esc_html_e( 'Title', 'ravis-booking' ) ?>"/>
															</div>
															<div class="row">
																<label><?php esc_html_e( 'Season Type : ', 'ravis-booking' ) ?></label>
																<select name="ravis-booking-setting[seasonal_price][<?php echo esc_attr( $index ) ?>][type]" class="season-type-switcher">
																	<option value="1" <?php selected( $season_item['type'], 1, true ) ?>><?php esc_html_e( 'High Season', 'ravis-booking' ) ?></option>
																	<option value="2" <?php selected( $season_item['type'], 2, true ) ?>><?php esc_html_e( 'Low Season', 'ravis-booking' ) ?></option>
																</select>
															</div>
															<div class="row">
																<label><?php esc_html_e( 'Start Date : ', 'ravis-booking' ) ?></label>
																<input type="text" name="ravis-booking-setting[seasonal_price][<?php echo esc_attr( $index ) ?>][from]" class="datepicker from" value="<?php echo ! empty( $season_item['from'] ) ? esc_attr( $season_item['from'] ) : '' ?>" placeholder="<?php esc_html_e( 'Select a date', 'ravis-booking' ) ?>"/>
															</div>
															<div class="row">
																<label><?php esc_html_e( 'End Date : ', 'ravis-booking' ) ?></label>
																<input type="text" name="ravis-booking-setting[seasonal_price][<?php echo esc_attr( $index ) ?>][to]" class="datepicker to" value="<?php echo ! empty( $season_item['to'] ) ? esc_attr( $season_item['to'] ) : '' ?>" placeholder="<?php esc_html_e( 'Select a date', 'ravis-booking' ) ?>"/>
															</div>
															<div class="row">
																<label><?php esc_html_e( 'Decrease / Increase Percent : ', 'ravis-booking' ) ?></label>
																<input type="number" step="1" min="0" max="100" name="ravis-booking-setting[seasonal_price][<?php echo esc_attr( $index ) ?>][percent]" value="<?php echo esc_attr( $season_item['percent'] ) ?>" placeholder="<?php esc_html_e( 'Set the percent of decrease / increase', 'ravis-booking' ) ?>"/> %
															</div>
														</div>
													</div>
													<?php
												}
											}
										?>
									</div>
									<div class="add-client-box">
										<a class="season-add button button-primary button-large" href="#"><?php esc_html_e( 'Add New', 'ravis-booking' ) ?></a>
									</div>
									<div class="season-box-tpl" style="display:none;">
										<div class="season-package-box">
											<div class="remove-box">
												<i class="dashicons dashicons-no-alt"></i>
											</div>
											<div class="fields clearfix">
												<div class="row">
													<label><?php esc_html_e( 'Title : ', 'ravis-booking' ) ?></label>
													<input type="text" name="" data-name="title" value="" placeholder="<?php esc_html_e( 'Title', 'ravis-booking' ) ?>"/>
												</div>
												<div class="row">
													<label><?php esc_html_e( 'Season Type : ', 'ravis-booking' ) ?></label>
													<select name="" class="season-type-switcher" data-name="type">
														<option value="1"><?php esc_html_e( 'High Season', 'ravis-booking' ) ?></option>
														<option value="2"><?php esc_html_e( 'Low Season', 'ravis-booking' ) ?></option>
													</select>
												</div>
												<div class="row">
													<label><?php esc_html_e( 'Start Date : ', 'ravis-booking' ) ?></label>
													<input type="text" name="" data-name="from" class="from" value="" placeholder="<?php esc_html_e( 'Select a date', 'ravis-booking' ) ?>"/>
												</div>
												<div class="row">
													<label><?php esc_html_e( 'End Date : ', 'ravis-booking' ) ?></label>
													<input type="text" name="" data-name="to" class="to" value="" placeholder="<?php esc_html_e( 'Select a date', 'ravis-booking' ) ?>"/>
												</div>
												<div class="row">
													<label><?php esc_html_e( 'Decrease / Increase Percent : ', 'ravis-booking' ) ?></label>
													<input type="number" step="1" min="0" max="100" name="" value="" placeholder="<?php esc_html_e( 'Set the percent of decrease / increase', 'ravis-booking' ) ?>" data-name="percent"/> %
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="r-col ravis-col one-third pl">
									<div class="ravis-info-box">
										<div class="header">
											<i class="dashicons dashicons-info"></i><?php esc_html_e( 'Instruction', 'ravis-booking' ) ?>
										</div>
										<div class="content">
											<ol>
												<li class="red"><?php esc_html_e( 'Please note that these seasonal prices will override the single room prices. It means that they have higher priority of room\'s seasonal prices.', 'ravis-booking' ) ?></li>
												<li><?php esc_html_e( 'This prices will be applied on all rooms of website.', 'ravis-booking' ) ?></li>
											</ol>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-content" id="tabs-7">
								<div class="l-col ravis-col one-third clearfix">
									<div class="ravis-info-box">
										<div class="header">
											<i class="dashicons dashicons-download"></i><?php esc_html_e( 'Export', 'ravis-booking' ) ?>
										</div>
										<div class="content">
											<textarea id="ravis-booking-export-data" disabled><?php echo ! empty( $options ) ? json_encode( $options ) : ''; ?></textarea>
											<a href="#" class="button button-primary button-large" id="export-ravis-booking-setting"><?php esc_html_e( 'Export as JSON file', 'ravis-booking' ) ?></a>
											<a href="#" class="button button-primary button-large" onclick="copyToClipboard('#ravis-booking-export-data')"><?php esc_html_e( 'Copy to Clipboard', 'ravis-booking' ) ?></a>
										</div>
									</div>
								</div>
								<div class="r-col ravis-col one-third pl">
									<div class="ravis-info-box">
										<div class="header">
											<i class="dashicons dashicons-upload"></i><?php esc_html_e( 'Import', 'ravis-booking' ) ?>
										</div>
										<div class="content">
											<textarea id="import-ravis-booking-setting-field" placeholder="<?php esc_html_e( 'Paste the content here.', 'ravis-booking' ) ?>"></textarea>
											<a href="#" class="button button-primary button-large" id="import-ravis-booking-setting">
												<i class="dashicons dashicons-update"></i><?php esc_html_e( 'Import', 'ravis-booking' ) ?>
											</a>
											<span class="message-box red"><?php esc_html_e( 'WARNING : by importing your data, the current settings will be overwritten.', 'ravis-booking' ) ?></span>
										</div>
									</div>
								</div>
								<div class="r-col ravis-col one-third pl">
									<div class="ravis-info-box">
										<div class="header">
											<i class="dashicons dashicons-info"></i><?php esc_html_e( 'Instruction', 'ravis-booking' ) ?>
										</div>
										<div class="content">
											<ol>
												<li class="red"><?php esc_html_e( 'Please note that after importing your data, the current settings will be overwritten.', 'ravis-booking' ) ?></li>
												<li class="red"><?php esc_html_e( 'The import section accepts JSON content, so please be sure that your content has correct format.', 'ravis-booking' ) ?></li>
												<li><?php esc_html_e( 'After downloading the content, you can open the downloaded file with a simple text editor.', 'ravis-booking' ) ?></li>
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
