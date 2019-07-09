<?php
	global $wpdb;
	$currency_obj      = new Ravis_booking_currency();
	$table_name        = $wpdb->prefix . 'ravis_booking';
	$current_user_info = wp_get_current_user();
	$user_bookings     = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM ' . $table_name . ' WHERE user_id=%d ORDER BY `booking_date` DESC', $current_user_info->ID ) );
	$more_info_modal   = '';
?>
<div class="booking-archive-page">
	<?php
		if ( ! empty( $user_bookings ) )
		{
			?>
			<table>
				<tr>
					<th>#</th>
					<th><?php esc_html_e( 'First Name', 'ravis-booking' ) ?></th>
					<th><?php esc_html_e( 'Last Name', 'ravis-booking' ) ?></th>
					<th><?php esc_html_e( 'Phone', 'ravis-booking' ) ?></th>
					<th><?php esc_html_e( 'Email', 'ravis-booking' ) ?></th>
					<th><?php esc_html_e( 'Check-in', 'ravis-booking' ) ?></th>
					<th><?php esc_html_e( 'Check-out', 'ravis-booking' ) ?></th>
					<th><?php esc_html_e( 'Status', 'ravis-booking' ) ?></th>
					<th><?php esc_html_e( 'More Details', 'ravis-booking' ) ?></th>
				</tr>
				<?php
					$booking_i = 1;
					foreach ( $user_bookings as $booking_item )
					{
						$rabdom_id        = rand();
						$booking_info_obj = unserialize( $booking_item->booking_info );
						$booking_currency = ! empty( $booking_item->booking_currency ) ? unserialize( $booking_item->booking_currency ) : null;
						switch ( $booking_item->confirmed )
						{
							case '1':
								$confirm_txt = '<span class="status-box confirm">' . esc_html__( 'Confirmed', 'ravis-booking' ) . '</span>';
								break;
							default:
								$confirm_txt = '<span class="status-box not-confirm">' . esc_html__( 'Not Confirmed', 'ravis-booking' ) . '</span>';
								break;
						}
						$booking_total_price         = $currency_obj->price_generator_no_exchange( $booking_info_obj->totalBookingPrice, $booking_currency );
						$booking_total_vat           = $currency_obj->price_generator_no_exchange( $booking_info_obj->vat, $booking_currency );
						$booking_membership_discount = ! empty( $booking_info_obj->membershipDiscount ) ? $currency_obj->price_generator_no_exchange( $booking_info_obj->membershipDiscount, $booking_currency ) : 0;
						echo '
						<tr>
							<td>' . esc_html( $booking_i ) . '</td>
							<td>' . esc_html( $booking_item->f_name ) . '</td>
							<td>' . esc_html( $booking_item->l_name ) . '</td>
							<td>' . esc_html( $booking_item->phone ) . '</td>
							<td>' . esc_html( $booking_item->email ) . '</td>
							<td>' . esc_html( $booking_item->check_in ) . '</td>
							<td>' . esc_html( $booking_item->check_out ) . '</td>
							<td>' . wp_kses_post( $confirm_txt ) . '</td>
							<td><a class="booking-more-info-btn" href="#booking-more-info-' . esc_attr( $rabdom_id ) . '">' . esc_html__( 'More', 'ravis-booking' ) . ' <i class="fa fa-angle-right"></i></a></td>
						</tr>';
						$booking_i ++;
						$more_info_modal .= '
						<div id="booking-more-info-' . esc_attr( $rabdom_id ) . '" class="mfp-hide">
							<div class="booking-main-info clearfix">
								<div class="box-title">
									<span>' . esc_html__( 'Main Information', 'ravis-booking' ) . '</span>
								</div>
								<div class="info-row row clearfix">
									<div class="col-md-6 total-price">
										<div class="title">' . esc_html__( 'Total Price : ', 'ravis-booking' ) . '</div>
										<div class="value">' . esc_html( $booking_total_price ) . '</div>
									</div>
								</div>
								<div class="info-row row clearfix">
									<div class="col-md-6 total-price">
										<div class="title">' . esc_html__( 'Membership Discount : ', 'ravis-booking' ) . '</div>
										<div class="value">' . esc_html( $booking_membership_discount ) . '</div>
									</div>
									<div class="col-md-6 total-price">
										<div class="title">' . esc_html__( 'VAT : ', 'ravis-booking' ) . '</div>
										<div class="value">' . esc_html( $booking_total_vat ) . '</div>
									</div>
								</div>
								<div class="info-row row clearfix">
									<div class="col-md-6">
										<div class="title">' . esc_html__( 'Check In : ', 'ravis-booking' ) . '</div>
										<div class="value">' . ( ! empty( $booking_item->check_in ) ? esc_html( $booking_item->check_in ) : '' ) . '</div>
									</div>
									<div class="col-md-6">
										<div class="title">' . esc_html__( 'Check Out : ', 'ravis-booking' ) . '</div>
										<div class="value">' . ( ! empty( $booking_item->check_out ) ? esc_html( $booking_item->check_out ) : '' ) . '</div>
									</div>
								</div>
								<div class="info-row row clearfix">
									<div class="col-md-6">
										<div class="title">' . esc_html__( 'Duration : ', 'ravis-booking' ) . '</div>
										<div class="value">' . ( ! empty( $booking_info_obj->duration ) ? esc_html( $booking_info_obj->duration ) : '' ) . ' ' . ( ( ! empty( $booking_info_obj->duration ) && $booking_info_obj->duration > 1 ) ? esc_html__( 'Nights', 'ravis-booking' ) : esc_html__( 'Night', 'ravis-booking' ) ) . '</div>
									</div>
									<div class="col-md-6">
										<div class="title">' . esc_html__( 'Weekends : ', 'ravis-booking' ) . '</div>
										<div class="value">' . ( ! empty( $booking_info_obj->weekends ) ? esc_html( $booking_info_obj->weekends ) : '' ) . '</div>
									</div>
								</div>
								<div class="info-row row clearfix">
									<div class="col-md-6">
										<div class="title">' . esc_html__( 'Payment Method : ', 'ravis-booking' ) . '</div>
										<div class="value">' . ( ! empty( $booking_info_obj->paymentMethod ) ? esc_html( $booking_info_obj->paymentMethod ) : '' ) . '</div>
									</div>
									<div class="col-md-6">
										<div class="title">' . esc_html__( 'Booking Date : ', 'ravis-booking' ) . '</div>
										<div class="value">' . ( ! empty( $booking_item->booking_date ) ? esc_html( $booking_item->booking_date ) : '' ) . '</div>
									</div>
								</div>
								<div class="info-row row clearfix">
									<div class="col-md-6">
										<div class="title">' . esc_html__( 'Address : ', 'ravis-booking' ) . '</div>
										<div class="value">' . ( ! empty( $booking_info_obj->address ) ? esc_html( $booking_info_obj->address ) : '' ) . '</div>
									</div>
									<div class="col-md-6">
										<div class="title">' . esc_html__( 'Special Requirements : ', 'ravis-booking' ) . '</div>
										<div class="value">' . ( ! empty( $booking_info_obj->requirements ) ? esc_html( $booking_info_obj->requirements ) : '' ) . '</div>
									</div>
								</div>
							</div>';

						if ( $booking_item->payment_method == '1' )
						{
							$get_info_obj          = new Ravis_booking_get_info();
							$invoice_info          = $get_info_obj->invoice_info( $booking_item->invoice_id );
							$invoice_currency_info = unserialize( $invoice_info['currency'] );
							$invoice_price         = $currency_obj->price_generator_no_exchange( $invoice_info['price']['value'], $invoice_currency_info );
							switch ( $invoice_info['status']['value'] )
							{
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
							$more_info_modal .= '
							<div class="section-box">
								<div class="box-title">
									<span>' . esc_html__( 'Payment Information', 'ravis-booking' ) . '</span>
								</div>
								<table>
									<tr>
										<th>' . esc_html__( 'Price', 'ravis-booking' ) . '</th>
										<th>' . esc_html__( 'Status', 'ravis-booking' ) . '</th>
										<th>' . esc_html__( 'Date', 'ravis-booking' ) . '</th>
									</tr>
									<tr>
										<td>' . esc_html( $invoice_price ) . '</td>
										<td><span class="' . esc_attr( $invoice_status_class ) . '">' . esc_html( $invoice_info['status']['generated'] ) . '</span></td>
										<td>' . esc_html( $invoice_info['booking_date'] ) . '</td>
									</tr>
								</table>
							</div>';
						}
						$more_info_modal .= '
							<div class="section-box">
								<div class="box-title">
									<span>' . esc_html__( 'Room Information', 'ravis-booking' ) . '</span>
								</div>
								<table>
									<tr>
										<th>#</th>
										<th>' . esc_html__( 'Room Title', 'ravis-booking' ) . '</th>
										<th>' . esc_html__( 'Adult', 'ravis-booking' ) . '</th>
										<th>' . esc_html__( 'Child', 'ravis-booking' ) . '</th>
										<th>' . esc_html__( 'Room Price', 'ravis-booking' ) . '</th>
									</tr>';
						$room_i          = 1;
						foreach ( $booking_info_obj->room as $room_item )
						{
							if ( empty($room_item->priceDetails->total->payable) )
							{
								$room_price = $currency_obj->price_generator_no_exchange( $room_item->priceDetails->total, $booking_currency );
							}
							else
							{
								$room_price = $room_item->priceDetails->total->payable;
							}
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
									<span>' . esc_html__( 'Services Information', 'ravis-booking' ) . '</span>
								</div>
								<table>
									<tr>
										<th>#</th>
										<th>' . esc_html__( 'Title', 'ravis-booking' ) . '</th>
										<th>' . esc_html__( 'Price', 'ravis-booking' ) . '</th>
									</tr>';
						$services_i      = 1;
                        if (!empty($booking_info_obj->services))
                        {
                            foreach ($booking_info_obj->services as $services_item)
                            {
                                $more_info_modal .= '
									<tr>
										<td>' . esc_html($services_i) . '</td>
										<td>' . esc_html($services_item->title) . '</td>
										<td>' . esc_html($services_item->total_price->generated) . '</td>
									</tr>';

                                $services_i++;
                            }
                        }
						$more_info_modal .= '
								</table>
							</div>';
						if ( ! empty( $booking_info_obj->package ) )
						{
							$more_info_modal .= '
							<div class="section-box">
								<div class="box-title">
									<span>' . esc_html__( 'Package Information', 'ravis-booking' ) . '</span>
								</div>
								<table>
									<tr>
										<th>' . esc_html__( 'Title', 'ravis-booking' ) . '</th>
										<th>' . esc_html__( 'Price', 'ravis-booking' ) . '</th>
									</tr>';
							$more_info_modal .= '
									<tr>
										<td>' . esc_html( $booking_info_obj->package->title ) . '</td>
										<td>' . esc_html( $currency_obj->price_generator_no_exchange( $booking_info_obj->package->total_price->value, $booking_currency ) ) . '</td>
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
			esc_html_e( 'You have not booked any rooms in our hotel.', 'ravis-booking' );
		}
	?>
</div>