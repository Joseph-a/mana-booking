<?php
global $wpdb;
$table_name = $wpdb->prefix . 'mana_booking';
$paged = (!empty($_GET['paged']) ? intval($_GET['paged']) : 1);
$mana_booking_option = get_option('mana-booking-setting');
$per_page = (!empty($mana_booking_option['booking_archive_per_page']) ? intval($mana_booking_option['booking_archive_per_page']) : 10);
$offset_item = ($paged - 1) * $per_page;
$total_bookings = $wpdb->get_var('SELECT COUNT(*) FROM ' . $table_name);
$user_bookings = $wpdb->get_results('SELECT * FROM ' . $table_name . ' ORDER BY `booking_date` DESC LIMIT ' . $offset_item . ',' . $per_page);
$page_item_records = count($user_bookings);
$current_page_url = '//' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?page=mana-booking-archive';
$currency_obj = new Mana_booking_currency();
?>
<div id="mana-booking-booking-archive">
	<div class="wrap">
		<h1><?php esc_html_e('Booking Archive', 'mana-booking') ?></h1>
		<table class="wp-list-table widefat fixed" id="booking-archive-tbl">
			<thead>
				<tr>
					<th class="row-number">#</th>
					<th class="booking-id"><?php esc_html_e('ID', 'mana-booking') ?></th>
					<th class="booking-name"><?php esc_html_e('Name', 'mana-booking') ?></th>
					<th class="booking-phone"><?php esc_html_e('Phone', 'mana-booking') ?></th>
					<th class="booking-email"><?php esc_html_e('Email', 'mana-booking') ?></th>
					<th class="booking-checkin"><?php esc_html_e('Check In', 'mana-booking') ?></th>
					<th class="booking-checkout"><?php esc_html_e('Check Out', 'mana-booking') ?></th>
					<th class="booking-more"><?php esc_html_e('More Info', 'mana-booking') ?></th>
					<th class="booking-status"><?php esc_html_e('Status', 'mana-booking') ?></th>
					<th class="booking-actions"><?php esc_html_e('Actions', 'mana-booking') ?></th>
				</tr>
			</thead>
			<tbody id="the-list">
				<?php
				if (!empty($user_bookings)) {
					$booking_i = (1 + (($paged - 1) * $per_page));
					foreach ($user_bookings as $booking_item) {
						$booking_info_obj = unserialize($booking_item->booking_info);
						$booking_currency_info = unserialize($booking_item->booking_currency);
						$booking_lang = null;
						// echo '<pre>';
						// var_dump($booking_info_obj->couponInfo);
						// echo '</pre>';

						if (!empty($booking_info_obj->lang)) {
							$booking_lang = $booking_info_obj->lang;
						} elseif (defined('ICL_LANGUAGE_CODE')) {
							$booking_lang = ICL_LANGUAGE_CODE;
						}

						switch ($booking_item->confirmed) {
							case '1':
								$confirm_txt = '<span class="status-box confirm">' . esc_html__('Confirmed', 'mana-booking') . '</span>';
								break;
							default:
								$confirm_txt = '<span class="status-box not-confirm">' . esc_html__('Not Confirmed', 'mana-booking') . '</span>';
								break;
						}
						$booking_total_price = $currency_obj->price_generator_no_exchange($booking_info_obj->totalBookingPrice, $booking_currency_info);
						$booking_total_vat = $currency_obj->price_generator_no_exchange($booking_info_obj->vat, $booking_currency_info);
						$booking_membership_discount = !empty($booking_info_obj->membershipDiscount) ? $currency_obj->price_generator_no_exchange($booking_info_obj->membershipDiscount, $booking_currency_info) : 0;
						$booking_coupon_discount = !empty($booking_info_obj->couponPrice) ? $currency_obj->price_generator_no_exchange($booking_info_obj->couponPrice, $booking_currency_info) : 0;
						if ($booking_item->confirmed === '1') {
							$status_row_class = 'confirmed';
						} else {
							$status_row_class = 'not-confirmed';
						}
						echo '
							<tr class="booking-' . esc_attr($booking_item->id) . '">
								<td class="row-number">' . esc_html($booking_i) . '</td>
								<td class="booking-id">' . esc_html($booking_item->id) . '</td>
								<td class="booking-name">' . esc_html($booking_item->f_name . ' ' . $booking_item->l_name) . '</td>
								<td class="booking-phone">' . esc_html($booking_item->phone) . '</td>
								<td class="booking-email">' . esc_html($booking_item->email) . '</td>
								<td class="booking-checkin">' . esc_html($booking_item->check_in) . '</td>
								<td class="booking-checkout">' . esc_html($booking_item->check_out) . '</td>
								<td class="booking-more">' . esc_html__('More Details', 'mana-booking') . '<i class="dashicons dashicons-arrow-down-alt2"></i></td>
								<td class="booking-status update-status-item ' . esc_attr($status_row_class) . '" data-id="' . esc_attr($booking_item->id) . '" data-lang="' . (!empty($booking_lang) ? esc_attr($booking_lang) : '') . '" data-nonce="' . wp_create_nonce('booking-update-status') . '">
									<i class="dashicons dashicons-yes" title="' . esc_html__('Confirmed', 'mana-booking') . '"></i>
									<i class="dashicons dashicons-marker" title="' . esc_html__('Not Confirmed', 'mana-booking') . '"></i>
								</td>
								<td class="booking-actions">
									<a data-id="' . esc_attr($booking_item->id) . '" class="print-item" href="#"><img src="' . esc_url(MANA_BOOKING_IMG_PATH) . 'print.png" alt="' . esc_html__('Print', 'mana-booking') . '"></i></a>
									<a data-id="' . esc_attr($booking_item->id) . '" data-nonce="' . wp_create_nonce('booking-delete-item') . '" class="delete-item" href="#"><i class="dashicons dashicons-no"></i></a>
								</td>
							</tr>
							<tr class="more-details hidden">
								<td colspan="10">
									<div class="more-detail-content">
										<div class="booking-main-info clearfix">
											<div class="box-title">
												<span>' . esc_html__('Main Information', 'mana-booking') . '</span>
											</div>
											<div class="info-row row clearfix">
												<div class="info-item total-price">
													<div class="title">' . esc_html__('Total Price : ', 'mana-booking') . '</div>
													<div class="value">' . esc_html($booking_total_price) . '</div>
												</div>
												<div class="info-item total-price">
													<div class="title">' . esc_html__('Coupon Discount : ', 'mana-booking') . '</div>
													<div class="value">' . esc_html($booking_coupon_discount) . '</div>
												</div>
											</div>
											<div class="info-row row clearfix">
												<div class="info-item total-price">
													<div class="title">' . esc_html__('Membership Discount : ', 'mana-booking') . '</div>
													<div class="value">' . esc_html($booking_membership_discount) . '</div>
												</div>
												<div class="info-item total-price">
													<div class="title">' . esc_html__('VAT : ', 'mana-booking') . '</div>
													<div class="value">' . esc_html($booking_total_vat) . '</div>
												</div>
											</div>
											<div class="info-row row clearfix">
												<div class="info-item">
													<div class="title">' . esc_html__('Check In : ', 'mana-booking') . '</div>
													<div class="value">' . (!empty($booking_item->check_in) ? esc_html($booking_item->check_in) : '') . '</div>
												</div>
												<div class="info-item">
													<div class="title">' . esc_html__('Check Out : ', 'mana-booking') . '</div>
													<div class="value">' . (!empty($booking_item->check_out) ? esc_html($booking_item->check_out) : '') . '</div>
												</div>
											</div>
											<div class="info-row row clearfix">
												<div class="info-item">
													<div class="title">' . esc_html__('Duration : ', 'mana-booking') . '</div>
													<div class="value">' . (!empty($booking_info_obj->duration) ? esc_html($booking_info_obj->duration) : '') . ' ' . ((!empty($booking_info_obj->duration) && $booking_info_obj->duration > 1) ? esc_html__('Nights', 'mana-booking') : esc_html__('Night', 'mana-booking')) . '</div>
												</div>
												<div class="info-item">
													<div class="title">' . esc_html__('Weekends : ', 'mana-booking') . '</div>
													<div class="value">' . (!empty($booking_info_obj->weekends) ? esc_html($booking_info_obj->weekends) : '') . '</div>
												</div>
											</div>
											<div class="info-row row clearfix">
												<div class="info-item">
													<div class="title">' . esc_html__('Payment Method : ', 'mana-booking') . '</div>
													<div class="value">' . (!empty($booking_info_obj->paymentMethod) ? esc_html($booking_info_obj->paymentMethod) : '') . '</div>
												</div>
												<div class="info-item">
													<div class="title">' . esc_html__('Booking Date : ', 'mana-booking') . '</div>
													<div class="value">' . (!empty($booking_item->booking_date) ? esc_html($booking_item->booking_date) : '') . '</div>
												</div>
											</div>
											<div class="info-row row clearfix">
												<div class="info-item">
													<div class="title">' . esc_html__('Address : ', 'mana-booking') . '</div>
													<div class="value">' . (!empty($booking_info_obj->address) ? esc_html($booking_info_obj->address) : '') . '</div>
												</div>
												<div class="info-item">
													<div class="title">' . esc_html__('Special Requirements : ', 'mana-booking') . '</div>
													<div class="value">' . (!empty($booking_info_obj->requirements) ? esc_html($booking_info_obj->requirements) : '') . '</div>
												</div>
											</div>
										</div>';
						if ($booking_item->payment_method == '1') {
							$get_info_obj = new Mana_booking_get_info();
							$invoice_info = $get_info_obj->invoice_info($booking_item->invoice_id);
							$invoice_price = $currency_obj->price_generator_no_exchange($invoice_info['price']['value'], $booking_currency_info);
							switch ($invoice_info['status']['value']) {
								case '0':
									$invoice_status_class = 'unpaid';
									break;
								case '1':
									$invoice_status_class = 'paid';
									break;
								case '2':
									$invoice_status_class = 'canceled';
									break;
							}
							echo '
							<div class="section-box">
								<div class="box-title">
									<span>' . esc_html__('Payment Information', 'mana-booking') . '</span>
								</div>
								<table>
									<tr>
										<th>' . esc_html__('Price', 'mana-booking') . '</th>
										<th>' . esc_html__('Status', 'mana-booking') . '</th>
										<th>' . esc_html__('Date', 'mana-booking') . '</th>
									</tr>
									<tr>
										<td>' . esc_html($invoice_price) . '</td>
										<td><span class="status-box ' . esc_attr($invoice_status_class) . '">' . esc_html($invoice_info['status']['generated']) . '</span></td>
										<td>' . esc_html($invoice_info['booking_date']) . '</td>
									</tr>
								</table>
							</div>';
						}

						echo '
										<div class="section-box">
											<div class="box-title">
												<span>' . esc_html__('Room Information', 'mana-booking') . '</span>
											</div>
											<table>
												<tr>
													<th>#</th>
													<th>' . esc_html__('Room Title', 'mana-booking') . '</th>
													<th>' . esc_html__('Adult', 'mana-booking') . '</th>
													<th>' . esc_html__('Child', 'mana-booking') . '</th>
													<th>' . esc_html__('Room Price', 'mana-booking') . '</th>
												</tr>';
						$room_i = 1;
						foreach ($booking_info_obj->room as $room_item) {
							if (empty($room_item->priceDetails->total->payable)) {
								$room_price = $currency_obj->price_formatter($room_item->priceDetails->total);
								$room_price = $currency_obj->price_symbol_generator($room_price);
							} else {
								$room_price = $room_item->priceDetails->total->payable;
							}
							echo '
												<tr>
													<td>' . esc_html($room_i) . '</td>
													<td>' . esc_html($room_item->roomTitle) . '</td>
													<td>' . esc_html($room_item->adult) . '</td>
													<td>' . esc_html($room_item->child) . '</td>
													<td class="price-td">' . esc_html($room_price) . '</td>
												</tr>';

							$room_i++;
						}
						echo '
											</table>
										</div>';

						if (!empty($booking_info_obj->couponInfo)) {
							echo '
										<div class="section-box">
											<div class="box-title">
												<span>' . esc_html__('Coupon Information', 'mana-booking') . '</span>
											</div>
											<table>
												<tr>
													<th>' . esc_html__('Title', 'mana-booking') . '</th>
													<th>' . esc_html__('Type', 'mana-booking') . '</th>
													<th>' . esc_html__('Price', 'mana-booking') . '</th>
												</tr>
												<tr>
													<td>' . esc_html($booking_info_obj->couponInfo->title) . '</td>
													<td>' . esc_html($booking_info_obj->couponInfo->type) . '</td>
													<td>' . esc_html($booking_coupon_discount) . '</td>
												</tr>
											</table>
										</div>';
						}

						if (!empty($booking_info_obj->services)) {
							echo '
										<div class="section-box">
											<div class="box-title">
												<span>' . esc_html__('Services Information', 'mana-booking') . '</span>
											</div>
											<table>
												<tr>
													<th>#</th>
													<th>' . esc_html__('Title', 'mana-booking') . '</th>
													<th>' . esc_html__('Price', 'mana-booking') . '</th>
												</tr>';
							$services_i = 1;
							foreach ($booking_info_obj->services as $services_item) {
								echo '
												<tr>
													<td>' . esc_html($services_i) . '</td>
													<td>' . esc_html($services_item->title) . '</td>
													<td class="price-td">' . esc_html($services_item->total_price->generated) . '</td>
												</tr>';

								$services_i++;
							}
							echo '
											</table>
										</div>';
						}
						if (!empty($booking_info_obj->package)) {
							echo '
						<div class="section-box">
											<div class="box-title">
												<span>' . esc_html__('Package Information', 'mana-booking') . '</span>
											</div>
											<table>
												<tr>
													<th>' . esc_html__('Title', 'mana-booking') . '</th>
													<th>' . esc_html__('Price', 'mana-booking') . '</th>
												</tr>';
							$package_price = $currency_obj->price_formatter($booking_info_obj->package->total_price->value);
							$package_price = $currency_obj->price_symbol_generator($package_price);
							echo '
												<tr>
													<td>' . esc_html($booking_info_obj->package->title) . '</td>
													<td class="price-td">' . esc_html($package_price) . '</td>
												</tr>';

							echo '
											</table>
										</div>';
						}

						echo '
									</div>
								</td>
							</tr>
						';
						$booking_i++;
					}
				}
				?>
			</tbody>
		</table>
		<div class="mana-pagination-box">
			<?php
			$pages = ceil($total_bookings / $per_page);
			if ($pages > 1) {
				echo '<ul>';
				for ($i = 1; $i <= $pages; $i++) {
					echo '<li><a href="' . $current_page_url . ($i > 1 ? '&amp;paged=' . $i : '') . '" ' . ($paged === $i ? 'class="current"' : '') . '>' . esc_html($i) . '</a></li>';
				}
				echo '</ul>';
			}
			?>
		</div>
		<table class="wp-list-table widefat fixed" id="booking-archive-tbl-virtual">
			<thead>
				<tr>
					<th class="row-number">#</th>
					<th class="booking-id"><?php esc_html_e('ID', 'mana-booking') ?></th>
					<th class="booking-name"><?php esc_html_e('Name', 'mana-booking') ?></th>
					<th class="booking-phone"><?php esc_html_e('Phone', 'mana-booking') ?></th>
					<th class="booking-email"><?php esc_html_e('Email', 'mana-booking') ?></th>
					<th class="booking-checkin"><?php esc_html_e('Check In', 'mana-booking') ?></th>
					<th class="booking-checkout"><?php esc_html_e('Check Out', 'mana-booking') ?></th>
				</tr>
			</thead>
			<tbody id="the-list">

			</tbody>
		</table>

	</div>
</div>