<?php
	global $wpdb;
	$currency_obj      = new Mana_booking_currency();
	$get_info_obj      = new Mana_booking_get_info();
	$table_name        = $wpdb->prefix . 'mana_invoice';
	$current_user_info = wp_get_current_user();
	$user_invoice      = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM ' . $table_name . ' WHERE user_id=%d ORDER BY `booking_date` DESC', $current_user_info->ID ) );
	$more_info_modal   = '';
?>
<div class="invoice-archive-page">
	<?php
		if ( ! empty( $user_invoice ) )
		{
			?>
			<table>
				<tr>
					<th>#</th>
					<th><?php esc_html_e( 'Date', 'mana-booking' ) ?></th>
					<th><?php esc_html_e( 'Price', 'mana-booking' ) ?></th>
					<th><?php esc_html_e( 'Status', 'mana-booking' ) ?></th>
					<th><?php esc_html_e( 'Booking Information', 'mana-booking' ) ?></th>
				</tr>
				<?php
					$booking_i = 1;
					foreach ( $user_invoice as $invoice_item )
					{
						$rabdom_id        = rand();
						$booking_item     = $get_info_obj->booking_info( $invoice_item->booking_id );
						$booking_currency = ! empty( $booking_item['currency'] ) ? $booking_item['currency'] : null;
						switch ( $invoice_item->status )
						{
							case '0':
								$confirm_txt = '<span class="status-box unpaid">' . esc_html__( 'Unpaid', 'mana-booking' ) . '</span>';
							break;
							case '1':
								$confirm_txt = '<span class="status-box paid">' . esc_html__( 'Paid', 'mana-booking' ) . '</span>';
							break;
							case '2':
								$confirm_txt = '<span class="status-box canceled">' . esc_html__( 'Canceled', 'mana-booking' ) . '</span>';
							break;
						}
						$booking_total_price         = $currency_obj->price_generator_no_exchange( $booking_item['booking_info']->totalBookingPrice, $booking_currency );
						$booking_total_vat           = $currency_obj->price_generator_no_exchange( $booking_item['booking_info']->vat, $booking_currency );
						$booking_membership_discount = ! empty( $booking_item['booking_info']->membershipDiscount ) ? $currency_obj->price_generator_no_exchange( $booking_item['booking_info']->membershipDiscount, $booking_currency ) : 0;
						$invoice_price               = $currency_obj->price_generator_no_exchange( $invoice_item->price, $booking_currency );
						echo '
						<tr>
							<td>' . esc_html( $booking_i ) . '</td>
							<td>' . esc_html( $invoice_item->booking_date ) . '</td>
							<td>' . esc_html( $invoice_price ) . '</td>
							<td>' . wp_kses_post( $confirm_txt ) . '</td>
							<td><a class="booking-more-info-btn" href="#booking-more-info-' . esc_attr( $rabdom_id ) . '">' . esc_html__( 'Booking Info', 'mana-booking' ) . ' <i class="fa fa-angle-right"></i></a></td>
						</tr>';
						switch ( $booking_item['confirmed'] )
						{
							case '1':
								$booking_confirm_txt = '<span class="status-box confirm">' . esc_html__( 'Confirmed', 'mana-booking' ) . '</span>';
							break;
							default:
								$booking_confirm_txt = '<span class="status-box not-confirm">' . esc_html__( 'Not Confirmed', 'mana-booking' ) . '</span>';
							break;
						}
						$booking_i ++;
						$more_info_modal .= '
						<div id="booking-more-info-' . esc_attr( $rabdom_id ) . '" class="mfp-hide">
							<div class="booking-main-info clearfix">
								<div class="box-title">
									<span>' . esc_html__( 'Main Information', 'mana-booking' ) . '</span>
								</div>
								<div class="info-row row clearfix">
									<div class="col-md-6 total-price">
										<div class="title">' . esc_html__( 'Total Price : ', 'mana-booking' ) . '</div>
										<div class="value">' . esc_html( $booking_total_price ) . '</div>
									</div>
									<div class="col-md-6 total-price">
										<div class="title">' . esc_html__( 'Status : ', 'mana-booking' ) . '</div>
										<div class="value">' . wp_kses_post( $booking_confirm_txt ) . '</div>
									</div>
								</div>
								<div class="info-row row clearfix">
									<div class="col-md-6 total-price">
										<div class="title">' . esc_html__( 'Membership Discount : ', 'mana-booking' ) . '</div>
										<div class="value">' . esc_html( $booking_membership_discount ) . '</div>
									</div>
									<div class="col-md-6 total-price">
										<div class="title">' . esc_html__( 'VAT : ', 'mana-booking' ) . '</div>
										<div class="value">' . esc_html( $booking_total_vat ) . '</div>
									</div>
								</div>
								<div class="info-row row clearfix">
									<div class="col-md-6">
										<div class="title">' . esc_html__( 'First Name : ', 'mana-booking' ) . '</div>
										<div class="value">' . ( ! empty( $booking_item['f_name'] ) ? esc_html( $booking_item['f_name'] ) : '' ) . '</div>
									</div>
									<div class="col-md-6">
										<div class="title">' . esc_html__( 'Last Name : ', 'mana-booking' ) . '</div>
										<div class="value">' . ( ! empty( $booking_item['l_name'] ) ? esc_html( $booking_item['l_name'] ) : '' ) . '</div>
									</div>
								</div>
								<div class="info-row row clearfix">
									<div class="col-md-6">
										<div class="title">' . esc_html__( 'Phone : ', 'mana-booking' ) . '</div>
										<div class="value">' . ( ! empty( $booking_item['phone'] ) ? esc_html( $booking_item['phone'] ) : '' ) . '</div>
									</div>
									<div class="col-md-6">
										<div class="title">' . esc_html__( 'Email : ', 'mana-booking' ) . '</div>
										<div class="value">' . ( ! empty( $booking_item['email'] ) ? esc_html( $booking_item['email'] ) : '' ) . '</div>
									</div>
								</div>
								<div class="info-row row clearfix">
									<div class="col-md-6">
										<div class="title">' . esc_html__( 'Check In : ', 'mana-booking' ) . '</div>
										<div class="value">' . ( ! empty( $booking_item['check_in'] ) ? esc_html( $booking_item['check_in'] ) : '' ) . '</div>
									</div>
									<div class="col-md-6">
										<div class="title">' . esc_html__( 'Check Out : ', 'mana-booking' ) . '</div>
										<div class="value">' . ( ! empty( $booking_item['check_out'] ) ? esc_html( $booking_item['check_out'] ) : '' ) . '</div>
									</div>
								</div>
								<div class="info-row row clearfix">
									<div class="col-md-6">
										<div class="title">' . esc_html__( 'Duration : ', 'mana-booking' ) . '</div>
										<div class="value">' . ( ! empty( $booking_item['duration'] ) ? esc_html( $booking_item['duration'] ) : '' ) . ' ' . ( ( ! empty( $booking_item['duration'] ) && $booking_item['duration'] > 1 ) ? esc_html__( 'Nights', 'mana-booking' ) : esc_html__( 'Night', 'mana-booking' ) ) . '</div>
									</div>
									<div class="col-md-6">
										<div class="title">' . esc_html__( 'Weekends : ', 'mana-booking' ) . '</div>
										<div class="value">' . ( ! empty( $booking_item['weekends'] ) ? esc_html( $booking_item['weekends'] ) : '' ) . '</div>
									</div>
								</div>
								<div class="info-row row clearfix">
									<div class="col-md-6">
										<div class="title">' . esc_html__( 'Payment Method : ', 'mana-booking' ) . '</div>
										<div class="value">' . ( ! empty( $booking_item['booking_info']->paymentMethod ) ? esc_html( $booking_item['booking_info']->paymentMethod ) : '' ) . '</div>
									</div>
									<div class="col-md-6">
										<div class="title">' . esc_html__( 'Booking Date : ', 'mana-booking' ) . '</div>
										<div class="value">' . ( ! empty( $booking_item['booking_date'] ) ? esc_html( $booking_item['booking_date'] ) : '' ) . '</div>
									</div>
								</div>
								<div class="info-row row clearfix">
									<div class="col-md-6">
										<div class="title">' . esc_html__( 'Address : ', 'mana-booking' ) . '</div>
										<div class="value">' . ( ! empty( $booking_item['address'] ) ? esc_html( $booking_item['address'] ) : '' ) . '</div>
									</div>
									<div class="col-md-6">
										<div class="title">' . esc_html__( 'Special Requirements : ', 'mana-booking' ) . '</div>
										<div class="value">' . ( ! empty( $booking_item['requirements'] ) ? esc_html( $booking_item['requirements'] ) : '' ) . '</div>
									</div>
								</div>
							</div>';
						$more_info_modal .= '
							<div class="section-box">
								<div class="box-title">
									<span>' . esc_html__( 'Room Information', 'mana-booking' ) . '</span>
								</div>
								<table>
									<tr>
										<th>#</th>
										<th>' . esc_html__( 'Room Title', 'mana-booking' ) . '</th>
										<th>' . esc_html__( 'Adult', 'mana-booking' ) . '</th>
										<th>' . esc_html__( 'Child', 'mana-booking' ) . '</th>
										<th>' . esc_html__( 'Room Price', 'mana-booking' ) . '</th>
									</tr>';
						$room_i          = 1;
						foreach ( $booking_item['booking_info']->room as $room_item )
						{
							$room_price      = $currency_obj->price_generator_no_exchange( $room_item->priceDetails->total, $booking_currency );
							$more_info_modal .= '
									<tr>
										<td>' . esc_html( $room_i ) . '</td>
										<td>' . esc_html( $room_item->roomTitle ) . '</td>
										<td>' . esc_html( $room_item->adult ) . '</td>
										<td>' . esc_html( $room_item->child ) . '</td>
										<td>' . esc_html( $room_price ) . '</td>
									</tr>';
							
							$room_i ++;
						}
						$more_info_modal .= '
								</table>
							</div>
							<div class="section-box">
								<div class="box-title">
									<span>' . esc_html__( 'Services Information', 'mana-booking' ) . '</span>
								</div>
								<table>
									<tr>
										<th>#</th>
										<th>' . esc_html__( 'Title', 'mana-booking' ) . '</th>
										<th>' . esc_html__( 'Price', 'mana-booking' ) . '</th>
									</tr>';
						$services_i      = 1;
						foreach ( $booking_item['booking_info']->services as $services_item )
						{
							$more_info_modal .= '
									<tr>
										<td>' . esc_html( $services_i ) . '</td>
										<td>' . esc_html( $services_item->title ) . '</td>
										<td>' . esc_html( $services_item->total_price->generated ) . '</td>
									</tr>';
							
							$services_i ++;
						}
						$more_info_modal .= '
								</table>
							</div>';
						if ( ! empty( $booking_item['booking_info']->package ) )
						{
							$more_info_modal .= '
							<div class="section-box">
								<div class="box-title">
									<span>' . esc_html__( 'Package Information', 'mana-booking' ) . '</span>
								</div>
								<table>
									<tr>
										<th>' . esc_html__( 'Title', 'mana-booking' ) . '</th>
										<th>' . esc_html__( 'Price', 'mana-booking' ) . '</th>
									</tr>';
							$more_info_modal .= '
									<tr>
										<td>' . esc_html( $booking_item['booking_info']->package->title ) . '</td>
										<td>' . esc_html( $currency_obj->price_generator_no_exchange( $booking_item['booking_info']->package->total_price->value, $booking_currency ) ) . '</td>
									</tr>';
							$more_info_modal .= '
								</table>
							</div>';
						}
						$more_info_modal .= '</div>';
						
					}
				?>
			</table>
			<?php
			echo wp_kses_post( $more_info_modal );
		}
		else
		{
			esc_html_e( 'You have not booked any rooms in our hotel.', 'mana-booking' );
		}
	?>
</div>