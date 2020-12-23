<?php
get_header();
global $wpdb;
$get_info_obj = new Mana_booking_get_info();
$currency_info_obj = new Mana_booking_currency();
$currency_info = $currency_info_obj->get_current_currency();
$mana_options = get_option('mana-booking-setting');
$booking_id = !empty($_GET['booking']) ? intval($_GET['booking']) : '';
$invoice_id = !empty($_GET['invoice']) ? intval($_GET['invoice']) : '';
$status = !empty($_GET['status']) ? sanitize_text_field($_GET['status']) : '';
$invoice_table = $wpdb->prefix . 'mana_invoice';
?>
<div class="booking-app-container">
	<section id="booking-section">
		<div class="inner-container container">
			<?php
			if (!empty($booking_id) && !empty($invoice_id) && $status === 'confirmed') {
				$booking_info = $get_info_obj->booking_info($booking_id);
				if (!empty($booking_info['invoice_id']) && $booking_info['invoice_id'] == $invoice_id) {
					$invoice_status = $wpdb->get_var($wpdb->prepare('SELECT `status` FROM ' . $invoice_table . ' WHERE id=%d AND booking_id=%d', $invoice_id, $booking_id));
					if ($invoice_status === '2') {
						echo '<div class="l-sec">';
						esc_html_e('You have already canceled this invoice.', 'mana-booking');
						echo '</div>';
					} else {
						$wpdb->update($invoice_table, array('status' => 1), array('id' => $invoice_id), array('%d'), array('%d'));
			?>
						<div class="col-md-4 l-sec">
							<div class="mana-title-t-2">
								<div class="title">
									<span><?php esc_html_e('Reservation Information', 'mana-booking') ?></span>
								</div>
							</div>
							<div class="check-in-out-container">
								<div class="check-in-out-box">
									<div class="title"><?php esc_html_e('Check in :', 'mana-booking') ?></div>
									<div class="value"><?php echo esc_html($booking_info['check_in']) ?></div>
								</div>
								<div class="check-in-out-box">
									<div class="title"><?php esc_html_e('Check out :', 'mana-booking') ?></div>
									<div class="value"><?php echo esc_html($booking_info['check_out']) ?></div>
								</div>
							</div>
							<?php
							if (!empty($booking_info['booking_info']->room)) {
							?>
								<div class="selected-room-container">
									<?php
									$room_i = 1;
									foreach ($booking_info['booking_info']->room as $room_item) {
										$room_price = $currency_info_obj->price_generator_no_exchange($room_item->priceDetails->total);
									?>
										<div class="selected-room-box has-price">
											<div class="room-title">
												<div class="title"><?php esc_html_e('Room', 'mana-booking') ?> <?php echo esc_html($room_i) ?> :</div>
												<div class="value"><?php echo esc_html($room_item->roomTitle) ?></div>
											</div>
											<div class="adult-count">
												<div class="title"><?php esc_html_e('Adult', 'mana-booking') ?> :</div>
												<div class="value"><?php echo esc_html($room_item->adult) ?></div>
											</div>
											<div class="child-count">
												<div class="title"><?php esc_html_e('Children', 'mana-booking') ?> :</div>
												<div class="value"><?php echo esc_html($room_item->child) ?></div>
											</div>
											<div class="price">
												<div class="title"><?php esc_html_e('Price', 'mana-booking') ?> :</div>
												<div class="value"><?php echo esc_html($room_price) ?></div>
											</div>
										</div>
									<?php
										$room_i++;
									}
									?>
								</div>
							<?php
							}
							if (!empty($booking_info['booking_info']->services)) {
							?>
								<div class="services-container">
									<div class="title-box"><?php esc_html_e('Services', 'mana-booking') ?></div>
									<?php
									foreach ($booking_info['booking_info']->services as $service_item) {
										if (!empty($service_item->total_price->value)) {
											$service_price = $currency_info_obj->price_generator_no_exchange($service_item->total_price->value);
										} else {
											$service_price = $service_item->total_price->generated;
										}
									?>
										<div class="selected-services clearfix">
											<div class="title"><?php echo esc_html($service_item->title) ?></div>
											<div class="price"><?php echo esc_html($service_price) ?></div>
										</div>
									<?php
									}
									?>
								</div>
							<?php
							}
							if (!empty($booking_info['booking_info']->package)) {
								$package_price = $currency_info_obj->price_generator_no_exchange($booking_info['booking_info']->package->total_price->value);
							?>
								<div class="services-container">
									<div class="title-box"><?php esc_html_e('Package', 'mana-booking') ?></div>
									<div class="selected-services clearfix">
										<div class="title"><?php echo esc_html($booking_info['booking_info']->package->title) ?></div>
										<div class="price"><?php echo esc_html($package_price) ?></div>
									</div>
								</div>
							<?php
							}
							?>
							<div class="price-details-container">
								<div class="price-detail-box">
									<div class="title"><?php esc_html_e('Rooms & Services', 'mana-booking') ?> :</div>
									<div class="value">
										<?php
										$total_booking_price = $booking_info['booking_info']->totalPrice + $booking_info['booking_info']->totalServicesPrice;
										if (!empty($booking_info['booking_info']->package->total_price->value)) {
											$total_booking_price += $booking_info['booking_info']->package->total_price->value;
										}
										$total_booking_price_str = $currency_info_obj->price_generator_no_exchange($total_booking_price);
										echo esc_html($total_booking_price_str);
										?>
									</div>
								</div>
								<?php
								if (!empty($booking_info['booking_info']->user_membership)) {
									$membership_discount = $currency_info_obj->price_generator_no_exchange($booking_info['booking_info']->membershipDiscount);
								?>
									<div class="price-detail-box">
										<div class="title"><?php esc_html_e('Membership Discount', 'mana-booking') ?> :</div>
										<div class="value"> - <?php echo esc_html($membership_discount) ?>
											<span>(%<?php echo esc_html($booking_info['booking_info']->user_membership->discount) ?>)</span>
										</div>
									</div>
								<?php
								}
								?>
								<div class="price-detail-box">
									<div class="title"><?php echo esc_html__('Vat', 'mana-booking') . ' ' . esc_html($mana_options['vat']) ?>% :</div>
									<div class="value">
										<?php
										$total_vat = $currency_info_obj->price_generator_no_exchange($booking_info['booking_info']->vat);
										echo esc_html($total_vat);
										?>
									</div>
								</div>
								<div class="price-detail-box total">
									<div class="title"><?php esc_html_e('Total Price', 'mana-booking') ?> :</div>
									<div class="value">
										<?php
										$main_total_price = $currency_info_obj->price_generator_no_exchange($booking_info['booking_info']->totalBookingPrice);
										echo esc_html($main_total_price);
										?>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-8 r-sec">
							<div class="inner-box">
								<div class="steps">
									<ul class="list-inline">
										<li><?php esc_html_e('Choose Date', 'mana-booking') ?></li>
										<li><?php esc_html_e('Choose Room', 'mana-booking') ?></li>
										<li><?php esc_html_e('Make a Reservation', 'mana-booking') ?></li>
										<li class="active"><?php esc_html_e('Confirmation', 'mana-booking') ?></li>
									</ul>
								</div>
								<div id="confirmation-message">
									<div class="mana-title-t-2">
										<div class="title">
											<span><?php echo (!empty($mana_booking_options['final_booking_title']) ? esc_html($mana_booking_options['final_booking_title']) : esc_html__('Reservation Complete', 'mana-booking')); ?></span>
										</div>
										<div class="sub-title"><?php echo (!empty($mana_booking_options['final_booking_subtitle']) ? esc_html($mana_booking_options['final_booking_subtitle']) : esc_html__('Details of your reservation request was sent to your email', 'mana-booking')); ?></div>
									</div>
									<div class="desc"><?php echo (!empty($mana_booking_options['final_booking_desc']) ? esc_html($mana_booking_options['final_booking_desc']) : sprintf(__('For more information you can contact us via <a href="%s">contact form</a> of website', 'mana-booking'), !empty($mana_booking_options['contact_url']) ? esc_url($mana_booking_options['contact_url']) : '#')); ?></div>
								</div>
							</div>
						</div>
			<?php
					}
				} else {
					echo '<div class="l-sec">';
					esc_html_e('There is not any booking information available with this criteria.', 'mana-booking');
					echo '</div>';
				}
			} elseif ($status === 'cancel') {

				$invoice_status = $wpdb->get_var($wpdb->prepare('SELECT `status` FROM ' . $invoice_table . ' WHERE id=%d AND booking_id=%d', $invoice_id, $booking_id));
				if ($invoice_status === '1') {
					echo '<div class="l-sec">';
					esc_html_e('You have already paid this invoice.', 'mana-booking');
					echo '</div>';
				} else {
					$wpdb->update($invoice_table, array('status' => 2), array('id' => $invoice_id), array('%d'), array('%d'));
					echo '<div class="l-sec">';
					esc_html_e('Thanks for your try, you canceled your booking', 'mana-booking');
					echo '</div>';
				}
			} else {
				echo '<div class="l-sec">';
				esc_html_e('There is not any booking information available with this criteria.', 'mana-booking');
				echo '</div>';
			}
			?>
		</div>
	</section>
</div>
<?php

get_footer();
