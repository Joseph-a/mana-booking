<?php
global $wpdb;
$table_name = $wpdb->prefix . 'mana_invoice';
$paged = (!empty($_GET['paged']) ? intval($_GET['paged']) : 1);
$mana_booking_option = get_option('mana-payment-setting');
$per_page = (!empty($mana_booking_option['payment_archive_per_page']) ? intval($mana_booking_option['payment_archive_per_page']) : 10);
$offset_item = ($paged - 1) * $per_page;
$total_payments = $wpdb->get_var('SELECT COUNT(*) FROM ' . $table_name);
$payment_result = $wpdb->get_results('SELECT * FROM ' . $table_name . ' ORDER BY `booking_date` DESC LIMIT ' . $offset_item . ',' . $per_page);
$page_item_records = count($payment_result);
$current_page_url = "//" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?page=mana-payment-archive';
$currency_obj = new Mana_booking_currency();
?>
<div id="mana-payment-archive">
	<div class="wrap">
		<h1><?php esc_html_e('Payment Archive', 'mana-booking') ?></h1>
		<table class="wp-list-table widefat fixed">
			<thead>
				<tr>
					<th class="row-number">#</th>
					<th class="payment-booking-id"><?php esc_html_e('Booking ID', 'mana-booking') ?></th>
					<th class="payment-booking-date"><?php esc_html_e('Date', 'mana-booking') ?></th>
					<th class="payment-price"><?php esc_html_e('Price', 'mana-booking') ?></th>
					<th class="payment-user"><?php esc_html_e('User ID', 'mana-booking') ?></th>
					<th class="payment-status"><?php esc_html_e('Status', 'mana-booking') ?></th>
					<th class="payment-action"><?php esc_html_e('Actions', 'mana-booking') ?></th>
				</tr>
			</thead>
			<tbody id="the-list">
				<?php
				if (!empty($payment_result)) {
					$payment_i = (1 + (($paged - 1) * $per_page));
					foreach ($payment_result as $payment_item) {
						$booking_currency_info = unserialize($payment_item->booking_currency);
						$payment_price = $currency_obj->price_generator_no_exchange($payment_item->price, $booking_currency_info);
						$user_txt = '';
						switch ($payment_item->user_id) {
							case '1';
								$user_txt = esc_html__('Admin', 'mana-booking');
								break;
							case '0';
								$user_txt = esc_html__('Guest', 'mana-booking');
								break;
							default:
								$user_info = get_user_by('id', $payment_item->user_id);
								$user_txt = '<a href="' . admin_url() . '/user-edit.php?user_id=' . esc_attr($payment_item->user_id) . '" target="_blank">' . esc_html($user_info->data->user_login) . '</a>';
								break;
						}
						switch ($payment_item->status) {
							case '0':
								$confirm_txt = '<span class="status-box unpaid">' . esc_html__('Unpaid', 'mana-booking') . '</span>';
								break;
							case '1':
								$confirm_txt = '<span class="status-box paid">' . esc_html__('Paid', 'mana-booking') . '</span>';
								break;
							case '2':
								$confirm_txt = '<span class="status-box canceled">' . esc_html__('Canceled', 'mana-booking') . '</span>';
								break;
						}
						echo '
							<tr>
								<td class="row-number">' . esc_html($payment_i) . '</td>
								<td class="payment-booking-id">' . esc_html($payment_item->booking_id) . '</td>
								<td class="payment-booking-date">' . esc_html($payment_item->booking_date) . '</td>
								<td class="payment-price">' . esc_html($payment_price) . '</td>
								<td class="payment-user">' . wp_kses_post($user_txt) . '</td>
								<td class="payment-status">' . wp_kses_post($confirm_txt) . '</td>
								<td class="payment-action"><a data-nonce="' . wp_create_nonce('payment-invoice-delete') . '" data-id="' . esc_attr($payment_item->id) . '" class="delete-item" href="#"><i class="dashicons dashicons-no"></i></a></td>
							</tr>';
						$payment_i++;
					}
				}
				?>
			</tbody>
		</table>
		<div class="mana-pagination-box">
			<?php
			$pages = ceil($total_payments / $per_page);
			if ($pages > 1) {
				echo '<ul>';
				for ($i = 1; $i <= $pages; $i++) {
					echo '<li><a href="' . $current_page_url . ($i > 1 ? '&amp;paged=' . $i : '') . '" ' . ($paged === $i ? 'class="current"' : '') . '>' . esc_html($i) . '</a></li>';
				}
				echo '</ul>';
			}
			?>
		</div>
	</div>
</div>