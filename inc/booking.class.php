<?php

class Mana_booking_booking_process
{
    public $mana_booking_option;
    public $mana_booking_param;

    public function __construct()
    {
        $this->mana_booking_option = get_option('mana-booking-setting');
        $booking_param = (!empty($this->mana_booking_option['booking_url']) ? $this->mana_booking_option['booking_url'] : 'mana-booking');
        $this->mana_booking_param = $booking_param;

        add_filter('body_class', array($this, 'add_body_class'));
        add_action('init', array($this, 'booking_page'));
        add_action('parse_request', array($this, 'booking_page_request'));
        add_filter('query_vars', array($this, 'booking_page_var'));

        add_action('wp_ajax_nopriv_mana_booking_check_availability', array($this, 'check_availability'));
        add_action('wp_ajax_mana_booking_check_availability', array($this, 'check_availability'));

        add_action('wp_ajax_nopriv_mana_booking_insert_booking', array($this, 'insert_booking'));
        add_action('wp_ajax_mana_booking_insert_booking', array($this, 'insert_booking'));

        add_action('wp_ajax_nopriv_mana_booking_update_booking_status', array($this, 'update_status'));
        add_action('wp_ajax_mana_booking_update_booking_status', array($this, 'update_status'));

        add_action('wp_ajax_nopriv_mana_booking_delete_booking', array($this, 'delete_booking'));
        add_action('wp_ajax_mana_booking_delete_booking', array($this, 'delete_booking'));

        add_action('wp_ajax_nopriv_mana_booking_booking_overview', array($this, 'booking_overview'));
        add_action('wp_ajax_mana_booking_booking_overview', array($this, 'booking_overview'));

        add_action('wp_ajax_nopriv_mana_booking_room_overview', array($this, 'room_overview'));
        add_action('wp_ajax_mana_booking_room_overview', array($this, 'room_overview'));

        add_action('wp_ajax_nopriv_mana_booking_update_invoice', array($this, 'update_invoice'));
        add_action('wp_ajax_mana_booking_update_invoice', array($this, 'update_invoice'));

        add_action('wp_ajax_nopriv_mana_booking_stripe_invoice', array($this, 'stripe_invoice'));
        add_action('wp_ajax_mana_booking_stripe_invoice', array($this, 'stripe_invoice'));
    }

    public function is_booking()
    {
        if (isset($_GET[$this->mana_booking_param]) || isset($_GET['booking-notification'])) {
            return true;
        } else {
            return false;
        }
    }

    public function booking_page()
    {
        add_rewrite_rule('booking.php$', 'index.php?' . esc_url($this->mana_booking_param) . '=1', 'top');
        add_rewrite_rule('booking-notification.php$', 'index.php?booking-notification=1', 'top');
    }

    public function booking_page_var($query_vars)
    {
        $query_vars[] = $this->mana_booking_param;
        $query_vars[] = 'booking-notification';

        return $query_vars;
    }

    public function booking_page_request(&$wp)
    {
        if (array_key_exists($this->mana_booking_param, $wp->query_vars)) {
            include MANA_BOOKING_TPL . 'booking.php';
            exit();
        }
        if (array_key_exists('booking-notification', $wp->query_vars)) {
            include MANA_BOOKING_TPL . 'booking-notification.php';
            exit();
        }

        return;
    }

    public function add_body_class($classes)
    {
        $classes[] = 'mana-booking';

        return $classes;
    }

    public function check_availability()
    {
        global $wpdb;
        if (check_ajax_referer('mana-booking-security-str', 'security')) {
            $check_in = !empty($_REQUEST['data']['checkIn']) ? sanitize_text_field($_REQUEST['data']['checkIn']) : '';
            $check_out = !empty($_REQUEST['data']['checkOut']) ? sanitize_text_field($_REQUEST['data']['checkOut']) : '';
            $adult = !empty($_REQUEST['data']['adult']) ? intval($_REQUEST['data']['adult']) : '';
            $child = !empty($_REQUEST['data']['child']) ? intval($_REQUEST['data']['child']) : '';
            $total_guests = $adult + $child;
            $duration = (strtotime($check_out) - strtotime($check_in)) / 86400;
            $lang = !empty($_REQUEST['data']['lang']) ? sanitize_text_field($_REQUEST['data']['lang']) : '';
            $selected_rooms = !empty($_REQUEST['data']['rooms']) ? sanitize_text_field($_REQUEST['data']['rooms']) : '';

            if (!empty($check_in) && !empty($check_out) && $total_guests !== 0) {
                $available_room_info = array();
                $get_info_obj = new Mana_booking_get_info();
                $table_name = $wpdb->prefix . 'mana_booking';

                /**
                 * Check the block dates
                 */
                $block_date_args = array(
                    'post_type' => 'block_dates',
                    'post_status' => 'publish',
                    'order' => 'DESC',
                    'orderby' => 'date',
                    'nopaging' => true,
                    'meta_query' => array(
                        'relation' => 'OR',
                        array(
                            'relation' => 'AND',
                            array(
                                'key' => 'mana_booking_block_dates_from',
                                'value' => $check_in,
                                'compare' => '<='
                            ),
                            array(
                                'key' => 'mana_booking_block_dates_to',
                                'value' => $check_in,
                                'compare' => '>='
                            )
                        ),
                        array(
                            'relation' => 'AND',
                            array(
                                'key' => 'mana_booking_block_dates_from',
                                'value' => $check_in,
                                'compare' => '>='
                            ),
                            array(
                                'key' => 'mana_booking_block_dates_from',
                                'value' => $check_out,
                                'compare' => '<='
                            )
                        )
                    )
                );
                $block_dates_list = new WP_Query($block_date_args);

                if ($block_dates_list->have_posts()) {
                    $block_rooms_info = array();
                    while ($block_dates_list->have_posts()) {
                        $block_dates_list->the_post();
                        $block_date_id = get_the_ID();
                        $block_date_info = $get_info_obj->block_date_info($block_date_id);
                        if (!empty($block_date_info['blocked_rooms'])) {
                            foreach ($block_date_info['blocked_rooms'] as $blocked_room) {
                                $block_rooms_info[$block_date_id][] = $blocked_room['id'];
                            }
                        }
                    }
                    wp_reset_postdata();
                }


                $room_args = array(
                    'post_type' => 'rooms',
                    'post_status' => 'publish',
                    'order' => 'DESC',
                    'orderby' => 'date',
                    'nopaging' => true,
                );
                $room_list_query = new WP_Query($room_args);
                if ($room_list_query->have_posts()) {
                    while ($room_list_query->have_posts()) {
                        $room_list_query->the_post();
                        $room_id = Mana_booking_get_info::original_post_id(get_the_ID());
                        $room_info = $get_info_obj->room_info($room_id, $check_in, $check_out, $duration, $adult, $child, $lang);

                        $room_capacity = $room_info['capacity']['main'] + $room_info['capacity']['extra'];
                        $room_min_stay = !empty($room_info['min_stay']) ? $room_info['min_stay'] : 0;

                        // Check Room Capacity
                        if ($total_guests > $room_capacity) {
                            $return_value['message'] = true;
                            continue;
                        }

                        // Check Min Stay of Room
                        if ($room_min_stay > $duration) {
                            continue;
                        }

                        // Check room for Block Dates
                        if (!empty($block_rooms_info)) {
                            foreach ($block_rooms_info as $block_room_info) {
                                if (in_array($room_id, $block_room_info)) {
                                    continue;
                                }
                            }
                        }

                        // Check for Previous Booking
                        $prev_bookings = $wpdb->get_col($wpdb->prepare("
        				SELECT rooms FROM  $table_name
        				WHERE
        				    (
        				        (check_in <= %s AND check_out > %s)
        					    OR
        					    (check_in >= %s AND check_in < %s)
        					)
        				    AND rooms = %d
        				    AND confirmed = %d
        				", array(
                            $check_in,
                            $check_in,
                            $check_in,
                            $check_out,
                            $room_id,
                            1
                        )));

                        $prev_booked_room = 0;
                        foreach ($prev_bookings as $prev_booking) {
                            $prev_room_count = substr_count($prev_booking, $room_id);
                            $prev_booked_room += $prev_room_count;
                        }
                        $prev_selected_room = !empty($selected_rooms) ? substr_count(get_the_ID() . ',', $selected_rooms) : 0;

                        if (($prev_booked_room + $prev_selected_room) >= $room_info['count']) {
                            continue;
                        }

                        $available_room_info[] = $room_info;
                    }
                    wp_reset_postdata();
                }

                if (!empty($available_room_info)) {
                    $return_value['status'] = true;
                    $return_value['rooms'] = $available_room_info;
                } else {
                    $return_value['status'] = false;
                    $return_value['message'] = esc_html__('No Room Available', 'mana-booking');
                }

                echo json_encode($return_value);
                die();
            } else {
                $return_value['status'] = false;
                $return_value['message'] = esc_html__('Please choose the correct information.', 'mana-booking');

                echo json_encode($return_value);
                die();
            }
        } else {
            $return_value['status'] = false;
            $return_value['message'] = esc_html__('Your are cheating!', 'mana-booking');

            echo json_encode($return_value);
            die();
        }
    }

    public function insert_booking()
    {
        global $wpdb;
        $currency_obj = new Mana_booking_currency();
        $current_currency = $currency_obj->get_current_currency();
        $table_name = $wpdb->prefix . 'mana_booking';
        $booking_info_obj = json_decode(json_encode($_POST['bookingInfo']));;

        $room_id_str = '';
        foreach ($booking_info_obj->room as $room_obj) {
            $room_id_str .= Mana_booking_get_info::original_post_id($room_obj->roomID) . ',';
        }

        if (check_ajax_referer('mana-booking-security-str', 'security')) {
            if (!empty($booking_info_obj->fname) && !empty($booking_info_obj->lname) && !empty($booking_info_obj->email) && !empty($booking_info_obj->phone) && !empty($booking_info_obj->terms) && !empty($booking_info_obj->checkIn) && !empty($booking_info_obj->checkOut)) {
                $wpdb->get_row($wpdb->prepare("
							SELECT * FROM  $table_name
							WHERE
							    f_name = %s
								AND l_name = %s
								AND phone = %s
								AND email = %s
								AND address = %s
								AND requirements = %s
								AND rooms = %s
								AND check_in = %s
								AND check_out = %s
								AND total_price = %d
								AND vat = %d
								AND duration = %d
								AND weekends = %d
								AND booking_info = %s
								AND user_id = %d
							", array(
                    sanitize_text_field($booking_info_obj->fname),
                    sanitize_text_field($booking_info_obj->lname),
                    sanitize_text_field($booking_info_obj->phone),
                    sanitize_email($booking_info_obj->email),
                    sanitize_text_field($booking_info_obj->address),
                    sanitize_text_field($booking_info_obj->requirements),
                    serialize($booking_info_obj->room),
                    date('Y-m-d', strtotime($booking_info_obj->checkIn)),
                    date('Y-m-d', strtotime($booking_info_obj->checkOut)),
                    filter_var($booking_info_obj->totalBookingPrice, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                    filter_var($booking_info_obj->vat, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                    intval($booking_info_obj->duration),
                    intval($booking_info_obj->weekends),
                    serialize($booking_info_obj),
                    intval($booking_info_obj->userID),
                )));

                if ($wpdb->num_rows > 0) {
                    $return_value['status'] = false;
                    $return_value['message'] = esc_html__('You have already booked, after checking your information, your booking will be finalized.', 'mana-booking');

                    echo json_encode($return_value);
                    die();
                } else {
                    if ($booking_info_obj->paymentMethod === 'paypal') {
                        $payment_method = 1;
                    } else {
                        $payment_method = 2;
                    }
                    $inserted_booking = $wpdb->insert($table_name, array(
                        'f_name' => sanitize_text_field($booking_info_obj->fname),
                        'l_name' => sanitize_text_field($booking_info_obj->lname),
                        'phone' => sanitize_text_field($booking_info_obj->phone),
                        'email' => sanitize_email($booking_info_obj->email),
                        'address' => sanitize_text_field($booking_info_obj->address),
                        'requirements' => sanitize_text_field($booking_info_obj->requirements),
                        'rooms' => trim($room_id_str, ','),
                        'check_in' => date('Y-m-d', strtotime($booking_info_obj->checkIn)),
                        'check_out' => date('Y-m-d', strtotime($booking_info_obj->checkOut)),
                        'payment_method' => intval($payment_method),
                        'total_price' => filter_var($booking_info_obj->totalBookingPrice, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                        'vat' => filter_var($booking_info_obj->vat, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                        'duration' => intval($booking_info_obj->duration),
                        'weekends' => intval($booking_info_obj->weekends),
                        'booking_info' => serialize($booking_info_obj),
                        'user_id' => intval($booking_info_obj->userID),
                        'booking_currency' => serialize($current_currency),
                    ), array(
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%d',
                        '%s',
                        '%s',
                        '%d',
                        '%d',
                        '%s',
                        '%d',
                        '%s',
                    ));

                    if ($inserted_booking) {
                        $this->email_notification($booking_info_obj, 'admin');
                        $booking_id = $wpdb->insert_id;

                        switch ($booking_info_obj->paymentMethod) {
                            case 'paypal':
                                if (!empty($this->mana_booking_option['paypal_booking'])) {
                                    $payable_price = $booking_info_obj->totalBookingPrice;
                                    if ($booking_info_obj->paymentPriceMethod === '2' && !empty($this->mana_booking_option['deposit_status'])) {
                                        $user_deposit = !empty($this->mana_booking_option['deposit']) ? esc_html($this->mana_booking_option['deposit']) : 20;
                                        $payable_price = ($payable_price * $user_deposit) / 100;
                                    }

                                    $invoice_table = $wpdb->prefix . 'mana_invoice';
                                    $inserted_invoice = $wpdb->insert($invoice_table, array(
                                        'booking_id' => intval($booking_id),
                                        'price' => filter_var($payable_price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                                        'user_id' => intval($booking_info_obj->userID),
                                        'booking_currency' => serialize($current_currency),
                                    ), array(
                                        '%d',
                                        '%s',
                                        '%d',
                                        '%s',
                                    ));

                                    if ($inserted_invoice) {
                                        $invoice_id = $wpdb->insert_id;
                                        $wpdb->update($table_name, array('invoice_id' => $invoice_id), array('id' => $booking_id), array('%d'), array('%d'));

                                        $paypal_default_currency = $this->mana_booking_option['paypal_default_currency'];
                                        if ($paypal_default_currency !== 'no_item') {
                                            $paypal_default_currency_info = $currency_obj->get_currency_info($paypal_default_currency);
                                            $payable_price = $currency_obj->price_exchanger($payable_price, $paypal_default_currency_info);
                                        }

                                        $return_value['status'] = true;
                                        $return_value['paymentForm'] = '
												<form id="paypal-form" method="post" action="' . (!empty($this->mana_booking_option['paypal_action_url']) ? esc_html($this->mana_booking_option['paypal_action_url']) : '') . '">
													<input type="hidden" name="business" value="' . (!empty($this->mana_booking_option['paypal_email']) ? esc_html($this->mana_booking_option['paypal_email']) : '') . '">
													<input type="hidden" name="cmd" value="_xclick">
													<input type="hidden" name="item_name" value="' . esc_html__('Room Booking Invoice', 'mana-booking') . '">
													<input type="hidden" name="amount" value="' . esc_html($payable_price) . '">
													<input type="hidden" name="currency_code" value="' . esc_attr(!empty($paypal_default_currency_info) ? $paypal_default_currency_info['title'] : $current_currency['title']) . '">
													<input type="hidden" name="cancel_return" value="' . home_url() . '?booking-notification&booking=' . esc_attr($booking_id) . '&invoice=' . esc_attr($invoice_id) . '&status=cancel">
													<input type="hidden" name="return" value="' . home_url() . '?booking-notification&booking=' . esc_attr($booking_id) . '&invoice=' . esc_attr($invoice_id) . '&status=confirmed">
												</form>';
                                    } else {
                                        $return_value['status'] = false;
                                        $return_value['message'] = esc_html__('Because of some technical issues, your booking was not proceed. Please try again.', 'mana-booking');
                                    }
                                    echo json_encode($return_value);
                                    die();
                                } else {
                                    $return_value['status'] = false;
                                    $return_value['message'] = esc_html__('Paypal payment is disabled on your website.', 'mana-booking');

                                    echo json_encode($return_value);
                                    die();
                                }
                                break;
                            case 'paymill':
                                if (!empty($this->mana_booking_option['paymill_booking'])) {
                                    $payable_price = $booking_info_obj->totalBookingPrice;
                                    if ($booking_info_obj->paymentPriceMethod === '2' && !empty($this->mana_booking_option['deposit_status'])) {
                                        $user_deposit = !empty($this->mana_booking_option['deposit']) ? esc_html($this->mana_booking_option['deposit']) : 20;
                                        $payable_price = ($payable_price * $user_deposit) / 100;
                                    }

                                    $invoice_table = $wpdb->prefix . 'mana_invoice';
                                    $inserted_invoice = $wpdb->insert($invoice_table, array(
                                        'booking_id' => intval($booking_id),
                                        'price' => filter_var($payable_price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                                        'user_id' => intval($booking_info_obj->userID),
                                        'booking_currency' => serialize($current_currency),
                                    ), array(
                                        '%d',
                                        '%s',
                                        '%d',
                                        '%s',
                                    ));

                                    if ($inserted_invoice) {
                                        $invoice_id = $wpdb->insert_id;
                                        $wpdb->update($table_name, array('invoice_id' => $invoice_id), array('id' => $booking_id), array('%d'), array('%d'));

                                        $return_value['status'] = true;
                                        $return_value['paymentForm'] = '
												<form id="paymill-form" action="#" method="POST" data-invoice="' . esc_attr($invoice_id) . '" data-ajax-url="' . esc_url(admin_url('admin-ajax.php')) . '">
													<input class="security-code" type="hidden" value="' . wp_create_nonce('paymill_form_security') . '" />
													<input class="card-amount-int" type="hidden" value="' . esc_html($payable_price * 100) . '" />
													<input class="card-currency" type="hidden" value="' . esc_attr($current_currency['title']) . '" />
													<div class="field-row clearfix">
														<div class="col-md-12">
															<input class="card-number" type="text" size="20" placeholder="' . esc_html__('Card number', 'mana-booking') . '"/>
														</div>
													</div>
													<div class="field-row clearfix">
														<div class="col-md-12">
															<input class="card-cvc" type="text" size="4" placeholder="' . esc_html__('CVC', 'mana-booking') . '"/>
														</div>
													</div>
													<div class="field-row clearfix">
													    <div class="col-md-6">
															<input class="card-expiry-month" type="text" size="2" placeholder="' . esc_html__('Expiry date (MM)', 'mana-booking') . '"/>
														</div>
														<div class="col-md-6">
															<input class="card-expiry-year" type="text" size="4" placeholder="' . esc_html__('Expiry date (YYYY)', 'mana-booking') . '"/>
														</div>
													</div>
													<div class="payment-errors"></div>
													<div class="field-row btn-container clearfix">
														<button class="submit-button" type="submit">' . esc_html__('Submit Payment', 'mana-booking') . '</button>
													</div>
												</form>
												<script type="text/javascript">
													var PAYMILL_PUBLIC_KEY = "' . (!empty($this->mana_booking_option['paymill_public_key']) ? esc_js($this->mana_booking_option['paymill_public_key']) : '') . '";
													jQuery(function($){
														$("#paymill-form").on("submit", function(e){
															e.preventDefault();
															var $scope = angular.element("#booking-section").scope();
															$scope.payMillFormSubmit($(this));
														})
													})
												</script>';
                                    } else {
                                        $return_value['status'] = false;
                                        $return_value['message'] = esc_html__('Because of some technical issues, your booking was not proceed. Please try again.', 'mana-booking');
                                    }
                                    echo json_encode($return_value);
                                    die();
                                } else {
                                    $return_value['status'] = false;
                                    $return_value['message'] = esc_html__('Paypal payment is disabled on your website.', 'mana-booking');

                                    echo json_encode($return_value);
                                    die();
                                }
                                break;
                            case 'stripe':
                                if (!empty($this->mana_booking_option['stripe_booking'])) {
                                    $payable_price = $booking_info_obj->totalBookingPrice;
                                    if ($booking_info_obj->paymentPriceMethod === '2' && !empty($this->mana_booking_option['deposit_status'])) {
                                        $user_deposit = !empty($this->mana_booking_option['deposit']) ? esc_html($this->mana_booking_option['deposit']) : 20;
                                        $payable_price = ($payable_price * $user_deposit) / 100;
                                    }

                                    $invoice_table = $wpdb->prefix . 'mana_invoice';
                                    $inserted_invoice = $wpdb->insert($invoice_table, array(
                                        'booking_id' => intval($booking_id),
                                        'price' => filter_var($payable_price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                                        'user_id' => intval($booking_info_obj->userID),
                                        'booking_currency' => serialize($current_currency),
                                    ), array(
                                        '%d',
                                        '%s',
                                        '%d',
                                        '%s',
                                    ));

                                    if ($inserted_invoice) {
                                        $invoice_id = $wpdb->insert_id;
                                        $wpdb->update($table_name, array('invoice_id' => $invoice_id), array('id' => $booking_id), array('%d'), array('%d'));

                                        $return_value['status'] = true;
                                        $return_value['paymentForm'] = '
												<form id="stripe-form" action="#" method="POST" data-invoice="' . esc_attr($invoice_id) . '" data-ajax-url="' . esc_url(admin_url('admin-ajax.php')) . '">
													<input class="security-code" type="hidden" value="' . wp_create_nonce('stripe_form_security') . '" />
													<input class="card-amount-int" type="hidden" value="' . esc_html($payable_price * 100) . '" />
													<input class="card-currency" type="hidden" value="' . esc_attr($current_currency['title']) . '" />
													<div class="field-row clearfix">
														<label for="card-element">' . esc_html__('Credit or Debit Card', 'mana-booking') . '</label>
													    <div id="card-element"></div>
													</div>
													<div id="card-errors" class="payment-errors"></div>
													<div class="field-row btn-container clearfix">
														<button class="submit-button" type="submit">' . esc_html__('Submit Payment', 'mana-booking') . '</button>
													</div>
												</form>
												<script type="text/javascript">
													var stripe = Stripe("' . (!empty($this->mana_booking_option['stripe_publish_key']) ? esc_js($this->mana_booking_option['stripe_publish_key']) : '') . '");
													var elements = stripe.elements();

													var style = {
														base: {
															color: "#FFFFFF",
															lineHeight: "18px",
															fontFamily: "Open Sans",
															fontSmoothing: "antialiased",
															fontSize: "14px",
															"::placeholder": {
																color: "#FFFFFF"
																}
														},
														invalid: {
															color: "#ff0000",
															iconColor: "#fa755a"
														}
													};
													var card = elements.create("card", {style: style});
													card.mount("#card-element");
													card.addEventListener("change", function(event) {
														var displayError = document.getElementById("card-errors");
														if (event.error) {
															displayError.textContent = event.error.message;
														} else {
															displayError.textContent = "";
														}
													});
													jQuery(function($){
														$("#stripe-form").on("submit", function(e){
															e.preventDefault();
															var $scope = angular.element("#booking-section").scope();
															$scope.stripeFormSubmit($(this), card);
														})
													})
												</script>';
                                    } else {
                                        $return_value['status'] = false;
                                        $return_value['message'] = esc_html__('Because of some technical issues, your booking was not proceed. Please try again.', 'mana-booking');
                                    }
                                    echo json_encode($return_value);
                                    die();
                                } else {
                                    $return_value['status'] = false;
                                    $return_value['message'] = esc_html__('Paypal payment is disabled on your website.', 'mana-booking');

                                    echo json_encode($return_value);
                                    die();
                                }
                                break;
                            default:
                                $return_value['status'] = true;
                                $return_value['message'] = esc_html__('Thanks for your booking, after checking your information, your booking will be finalized.', 'mana-booking');
                                break;
                        }

                        echo json_encode($return_value);
                        die();
                    } else {
                        $return_value['status'] = false;
                        $return_value['message'] = esc_html__('Because of some technical issues, your booking was not successful, please try again.', 'mana-booking');

                        echo json_encode($return_value);
                        die();
                    }
                }
            } else {
                $return_value['status'] = false;
                $return_value['message'] = esc_html__('Please provide all the required information.', 'mana-booking');

                echo json_encode($return_value);
                die();
            }
        } else {
            $return_value['status'] = false;
            $return_value['message'] = esc_html__('Your are cheating!', 'mana-booking');

            echo json_encode($return_value);
            die();
        }
    }

    public function email_notification($booking_info_obj, $receiver = 'admin', $currency = null, $language = null)
    {
        $status = false;
        if (!empty($this->mana_booking_option['email_notification_status'])) {
            $currency_obj = new Mana_booking_currency();
            $get_info_obj = new Mana_booking_get_info();
            $user_deposit = $this->mana_booking_option['deposit'];
            $user_deposit_val = ($booking_info_obj->totalBookingPrice * $user_deposit) / 100;

            if (defined('ICL_LANGUAGE_CODE') && !empty($language)) {
                $room_tbl_title = apply_filters('wpml_translate_single_string', 'Room Title', 'mana-booking', 'room_tbl_title', $language);
                $room_tbl_adult = apply_filters('wpml_translate_single_string', 'Adult', 'mana-booking', 'room_tbl_adult', $language);
                $room_tbl_child = apply_filters('wpml_translate_single_string', 'Child', 'mana-booking', 'room_tbl_child', $language);
                $room_tbl_price = apply_filters('wpml_translate_single_string', 'Price', 'mana-booking', 'room_tbl_price', $language);
                $room_tbl_serv_title = apply_filters('wpml_translate_single_string', 'Title', 'mana-booking', 'room_tbl_serv_title', $language);
            } else {
                $room_tbl_title = esc_html__('Room Title', 'mana-booking');
                $room_tbl_adult = esc_html__('Adult', 'mana-booking');
                $room_tbl_child = esc_html__('Child', 'mana-booking');
                $room_tbl_price = esc_html__('Price', 'mana-booking');
                $room_tbl_serv_title = esc_html__('Title', 'mana-booking');
            }
            $room_tmpl = '
					<table>
						<tr>
							<th>#</th>
							<th>' . esc_html($room_tbl_title) . '</th>
							<th>' . esc_html($room_tbl_adult) . '</th>
							<th>' . esc_html($room_tbl_child) . '</th>
							<th>' . esc_html($room_tbl_price) . '</th>
						</tr>';
            $room_i = 1;
            foreach ($booking_info_obj->room as $room_item) {
                $room_price = $room_item->priceDetails->total->payable;
                $room_tmpl .= '
						<tr>
							<td>' . esc_html($room_i) . '</td>
							<td>' . esc_html($room_item->roomTitle) . '</td>
							<td>' . esc_html($room_item->adult) . '</td>
							<td>' . esc_html($room_item->child) . '</td>
							<td>' . esc_html($room_price) . '</td>
						</tr>
					';
                $room_i++;
            }
            $room_tmpl .= '
                    </table>';

            $service_tmpl = '
					<table>
						<tr>
							<th>#</th>
							<th>' . esc_html($room_tbl_serv_title) . '</th>
							<th>' . esc_html($room_tbl_price) . '</th>
						</tr>';

            $room_i = 1;
            foreach ($booking_info_obj->services as $services_item) {
                $service_tmpl .= '
						<tr>
							<td>' . esc_html($room_i) . '</td>
							<td>' . esc_html($services_item->title) . '</td>
							<td>' . esc_html($services_item->total_price->generated) . '</td>
						</tr>
					';
                $room_i++;
            }
            $service_tmpl .= '
					</table>';

            $email_sender = (!empty($this->mana_booking_option['email_sender']) ? $this->mana_booking_option['email_sender'] : get_option('admin_email'));
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type:text/html;charset=UTF-8' . "\r\n";
            $headers .= 'From: "' . get_bloginfo('name') . '" <' . $email_sender . '>';

            $link_shortcodes = array(
                '[guest-first-name]',
                '[guest-last-name]',
                '[guest-email]',
                '[guest-phone]',
                '[guest-address]',
                '[guest-special-requirement]',
                '[guest-check-in]',
                '[guest-check-out]',
                '[guest-room]',
                '[guest-services]',
                '[guest-booking-total-price]',
                '[guest-booking-deposit]'
            );
            $link_replace_text = array(
                $booking_info_obj->fname,
                $booking_info_obj->lname,
                $booking_info_obj->email,
                $booking_info_obj->phone,
                !empty($booking_info_obj->address) ? $booking_info_obj->address : '',
                !empty($booking_info_obj->requirements) ? $booking_info_obj->requirements : '',
                date('Y-m-d', strtotime($booking_info_obj->checkIn)),
                date('Y-m-d', strtotime($booking_info_obj->checkOut)),
                $room_tmpl,
                $service_tmpl,
                $currency_obj->price_generator_no_exchange($booking_info_obj->totalBookingPrice, $currency),
                $currency_obj->price_generator_no_exchange($user_deposit_val, $currency)
            );

            switch ($receiver) {
                case ('guest'):
                    $body = str_replace($link_shortcodes, $link_replace_text, $this->mana_booking_option['email_user_tmpl']);
                    $subj = esc_html__('Your Booking has been confirmed.', 'mana-booking');
                    $status = wp_mail($booking_info_obj->email, $subj, $body, $headers);
                    break;
                case ('admin'):
                    $body = str_replace($link_shortcodes, $link_replace_text, $this->mana_booking_option['email_admin_tmpl']);
                    $multiple_recipients = (!empty($this->mana_booking_option['email_receiver']) ? $this->mana_booking_option['email_receiver'] : '');
                    $subj = esc_html__('New Booking Information was in your website', 'mana-booking');

                    if (!empty($this->mana_booking_option['guest_receiver']) && !empty($booking_info_obj->email)) {
                        $multiple_recipients[] = $booking_info_obj->email;
                    }

                    if (!empty($multiple_recipients)) {
                        foreach ($multiple_recipients as $receiver_email) {
                            $status = wp_mail($receiver_email, $subj, $body, $headers);
                        }
                    }
                    break;
            }
        }

        return $status;
    }

    public function update_status()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'mana_booking';
        $booking_id = (!empty($_REQUEST['id']) ? intval($_REQUEST['id']) : '');
        $security = (!empty($_REQUEST['security']) ? sanitize_text_field($_REQUEST['security']) : '');
        $language = isset($_REQUEST['lang']) ? sanitize_text_field($_REQUEST['lang']) : '';

        if (!empty($booking_id) && wp_verify_nonce($security, 'booking-update-status')) {
            $get_info_obj = new Mana_booking_get_info();
            $booking_info = $get_info_obj->booking_info($booking_id);
            $booking_information = $wpdb->get_var($wpdb->prepare('SELECT `confirmed` FROM ' . $table_name . ' WHERE id=%s', $booking_id));
            if ($booking_information === '1') {
                $updated_row = $wpdb->update($table_name, array('confirmed' => '0'), array('id' => $booking_id), array('%d'), array('%d'));
                $return_value['class'] = 'not-confirmed';
            } else {
                $this->email_notification($booking_info['booking_info'], 'guest', $booking_info['currency'], $language);
                $updated_row = $wpdb->update($table_name, array('confirmed' => '1'), array('id' => $booking_id), array('%d'), array('%d'));
                $return_value['class'] = 'confirmed';
            }
            if (!empty($updated_row)) {
                $return_value['status'] = true;
            } else {
                $return_value['status'] = false;
            }
        } else {
            $return_value['status'] = false;
        }

        echo json_encode($return_value);
        die();
    }

    public function delete_booking()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'mana_booking';
        $booking_id = (!empty($_REQUEST['id']) ? intval($_REQUEST['id']) : '');
        $security = (!empty($_REQUEST['security']) ? sanitize_text_field($_REQUEST['security']) : '');
        if (!empty($booking_id) && wp_verify_nonce($security, 'booking-delete-item')) {
            $booking_information = $wpdb->get_var($wpdb->prepare('SELECT * FROM ' . $table_name . ' WHERE id=%s', $booking_id));
            if (!empty($booking_information)) {
                $deleted_row = $wpdb->delete($table_name, array('id' => $booking_id), array('%d'));
                if ($deleted_row) {
                    $return_value['status'] = true;
                } else {
                    $return_value['status'] = false;
                }
            } else {
                $return_value['status'] = false;
            }
        } else {
            $return_value['status'] = false;
        }

        echo json_encode($return_value);
        die();
    }

    public function booking_overview()
    {
        global $wpdb;

        $start_date = sanitize_text_field($_POST['start']);
        $end_date = sanitize_text_field($_POST['end']);
        $front_end = !empty($_POST['frontEnd']) ? true : false;
        $currency_obj = new Mana_booking_currency();

        // Get the Booking items
        $table_name = $wpdb->prefix . 'mana_booking';
        $booking_result = $wpdb->get_results($wpdb->prepare("
									SELECT * FROM  $table_name
									WHERE check_in >= %s
									AND check_in <= %s
									AND confirmed = %d
									", array(
            $start_date,
            $end_date,
            1
        )));

        if (!empty($booking_result)) {
            $result = array();
            foreach ($booking_result as $booking_item) {
                $booking_info = unserialize($booking_item->booking_info);
                $currency_info = unserialize($booking_item->booking_currency);
                $room_info = $booking_info->room;
                $total_guest = $booking_info->totalGuest;
                $total_price = $currency_obj->price_generator_no_exchange($booking_info->totalBookingPrice, $currency_info);
                $user_id = $booking_item->user_id;
                $room_str = '';
                foreach ($room_info as $room_item) {
                    $room_str .= $room_item->roomTitle . ',';
                }
                if ($total_guest > 1) {
                    $guest_txt = $total_guest . ' ' . esc_html__('guests', 'mana-booking');
                } else {
                    $guest_txt = $total_guest . ' ' . esc_html__('guest', 'mana-booking');
                }
                $box_title = esc_html__('Rooms :', 'mana-booking') . trim($room_str, ',');
                if ($front_end === false) {
                    $box_title .= ' - ' . $total_price . ' - ' . $guest_txt;
                }

                $result[] = array(
                    'title' => $box_title,
                    'start' => $booking_item->check_in,
                    'end' => $booking_item->check_out
                );
            }
        }

        // Return the result
        echo json_encode($result);
        die();
    }

    public function room_overview()
    {
        global $wpdb;
        $get_info_obj = new Mana_booking_get_info();
        $start_date = sanitize_text_field($_POST['start']);
        $end_date = sanitize_text_field($_POST['end']);
        $room_id = intval($_POST['roomID']);
        $room_count = get_post_meta($room_id, 'mana_booking_room_count', true);
        $table_name = $wpdb->prefix . 'mana_booking';
        $start_date_time = strtotime($start_date);
        $end_date_time = strtotime($end_date);
        $i = 1;
        $today = gettimeofday();

        while ($start_date_time < $end_date_time) {
            $block_date_args = array(
                'post_type' => 'block_dates',
                'post_status' => 'publish',
                'order' => 'DESC',
                'orderby' => 'date',
                'nopaging' => true,
                'meta_query' => array(
                    'relation' => 'OR',
                    array(
                        'relation' => 'AND',
                        array(
                            'key' => 'mana_booking_block_dates_from',
                            'value' => $start_date,
                            'compare' => '<='
                        ),
                        array(
                            'key' => 'mana_booking_block_dates_to',
                            'value' => $start_date,
                            'compare' => '>='
                        )
                    ),
                    array(
                        'relation' => 'AND',
                        array(
                            'key' => 'mana_booking_block_dates_from',
                            'value' => $start_date,
                            'compare' => '>='
                        ),
                        array(
                            'key' => 'mana_booking_block_dates_from',
                            'value' => $end_date,
                            'compare' => '<='
                        )
                    )
                )
            );
            $block_dates_list = new WP_Query($block_date_args);
            $block_data_array = array();

            if ($block_dates_list->have_posts()) {
                while ($block_dates_list->have_posts()) {
                    $block_dates_list->the_post();
                    $block_date_id = get_the_ID();
                    $block_date_info = $get_info_obj->block_date_info($block_date_id);
                    if (!empty($block_date_info['blocked_rooms'])) {
                        if ($block_date_info['from']['timestamp'] <= $start_date_time && $block_date_info['to']['timestamp'] >= $start_date_time) {
                            foreach ($block_date_info['blocked_rooms'] as $blocked_room) {
                                if ($room_id == $blocked_room['id']) {
                                    $block_data_array[] = $start_date_time;
                                }
                            }
                        }
                    }
                }
                wp_reset_postdata();
            }

            $booking_result = $wpdb->get_var($wpdb->prepare("
									SELECT COUNT( * ) FROM  $table_name
									WHERE check_in <= %s
									AND check_out > %s
									AND rooms LIKE '%%%s%%'
									AND confirmed = %d
									", array(
                date('Y-m-d', $start_date_time),
                date('Y-m-d', ($start_date_time)),
                $room_id,
                1
            )));
            if ($booking_result >= $room_count || in_array($start_date_time, $block_data_array)) {
                $result[] = array(
                    'id' => $i,
                    'title' => esc_html__('Not Available', 'mana-booking'),
                    'start' => date('Y-m-d', $start_date_time),
                    'end' => date('Y-m-d', ($start_date_time + 86400)),
                    'rendering' => 'background'
                );
            } else {
                if ($start_date_time > $today['sec']) {
                    $room_info = $get_info_obj->room_info($room_id, date('Y-m-d', $start_date_time), date('Y-m-d', ($start_date_time + 86400)), 1, 1, 0);

                    if (!empty($room_info['booking_price']['total']['weekend'])) {
                        $price_title = esc_html__('From', 'mana-booking') . ' : ' . $room_info['booking_price']['total']['weekend']['adult']['main'];
                    } else {
                        $price_title = esc_html__('From', 'mana-booking') . ' : ' . $room_info['booking_price']['total']['weekday']['adult']['main'];
                    }

                    $result[] = array(
                        'id' => $i,
                        'title' => $price_title,
                        'start' => date('Y-m-d', $start_date_time),
                        'end' => date('Y-m-d', ($start_date_time + 86400)),
                    );
                }
            }

            $start_date_time += 86400;
            $i++;
        }
        // Return the result
        echo json_encode($result);
        die();
    }

    public function update_invoice()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'mana_invoice';
        $invoice_id = (!empty($_REQUEST['invoice']) ? intval($_REQUEST['invoice']) : '');
        $token = (!empty($_REQUEST['token']) ? sanitize_text_field($_REQUEST['token']) : '');
        $security = (!empty($_REQUEST['security']) ? sanitize_text_field($_REQUEST['security']) : '');

        if (!empty($invoice_id) && wp_verify_nonce($security, 'paymill_form_security')) {
            $invoice_info = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $table_name . ' WHERE id=%s', $invoice_id));
            if (!empty($invoice_info)) {
                $updated_row = $wpdb->update($table_name, array(
                    'status' => '1',
                    'token' => $token
                ), array('id' => $invoice_id), array('%d', '%s'), array('%d'));

                if (!empty($updated_row)) {
                    $return_value['status'] = true;
                } else {
                    $return_value['status'] = false;
                }
            } else {
                $return_value['status'] = false;
            }
        }

        echo json_encode($return_value);
        die();
    }

    public function stripe_invoice()
    {
        global $wpdb;
        $return_value = null;
        $table_name = $wpdb->prefix . 'mana_invoice';
        $invoice_id = (!empty($_REQUEST['invoice']) ? intval($_REQUEST['invoice']) : '');
        $token = (!empty($_REQUEST['token']) ? sanitize_text_field($_REQUEST['token']) : '');
        $security = (!empty($_REQUEST['security']) ? sanitize_text_field($_REQUEST['security']) : '');
        $amount = (!empty($_REQUEST['amount']) ? sanitize_text_field($_REQUEST['amount']) : '');
        $currency = (!empty($_REQUEST['currency']) ? sanitize_text_field($_REQUEST['currency']) : '');

        if (!empty($token) && !empty($invoice_id) && wp_verify_nonce($security, 'stripe_form_security')) {
            require_once 'stripe/init.php';

            \Stripe\Stripe::setApiKey($this->mana_booking_option['stripe_secret_key']);
            try {
                \Stripe\Charge::create(array(
                    'amount' => $amount,
                    'currency' => $currency,
                    'source' => $token
                ));

                $invoice_info = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $table_name . ' WHERE id=%s', $invoice_id));
                if (!empty($invoice_info)) {
                    $updated_row = $wpdb->update($table_name, array(
                        'status' => '1',
                        'token' => $token
                    ), array('id' => $invoice_id), array('%d', '%s'), array('%d'));

                    if (!empty($updated_row)) {
                        $return_value['status'] = true;
                    } else {
                        $return_value['status'] = false;
                    }
                } else {
                    $return_value['status'] = false;
                }
            } catch (\Stripe\Error\Api $e) {
                $return_value['status'] = false;
                $return_value['message'] = $e->getMessage();
            } catch (\Stripe\Error\Card $e) {
                $return_value['status'] = false;
                $return_value['message'] = $e->getMessage();
            }
        }

        echo json_encode($return_value);
        die();
    }
}

$mana_bookingBooking_process = new Mana_booking_booking_process();
