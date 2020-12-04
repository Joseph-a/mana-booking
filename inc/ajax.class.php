<?php

    class Mana_booking_ajax
    {
        public function __construct()
        {
            add_action('wp_ajax_nopriv_mana_booking_services', array($this, 'booking_services'));
            add_action('wp_ajax_mana_booking_services', array($this, 'booking_services'));

            add_action('wp_ajax_nopriv_mana_booking_rating', array($this, 'update_rating'));
            add_action('wp_ajax_mana_booking_rating', array($this, 'update_rating'));

            add_action('wp_ajax_nopriv_mana_booking_delete_invoice', array($this, 'delete_invoice'));
            add_action('wp_ajax_mana_booking_delete_invoice', array($this, 'delete_invoice'));
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  List All Booking Services
         * ------------------------------------------------------------------------------------------
         */
        public function booking_services()
        {
            global $wp_query;
            $get_info_obj = new Mana_booking_get_info();
            $duration     = isset($_REQUEST['duration']) ? intval($_REQUEST['duration']) : '';
            $room_count   = isset($_REQUEST['roomCount']) ? intval($_REQUEST['roomCount']) : '';
            $total_guest  = isset($_REQUEST['totalGuest']) ? intval($_REQUEST['totalGuest']) : '';
            $language     = isset($_REQUEST['lang']) ? intval($_REQUEST['lang']) : '';

            // Enable Services in Booking Process
            $services_args  = array(
                'post_type'      => 'service',
                'post_status'    => 'publish',
                'order'          => 'DESC',
                'orderby'        => 'date',
                'posts_per_page' => -1,
                'meta_query'     => array(
                    array(
                        'key'   => 'mana_booking_service_booking',
                        'value' => 'on',
                    ),
                )
            );
            $services_query = new WP_Query($services_args);
            $services_list  = array();
            if ($services_query->have_posts())
            {
                while ($services_query->have_posts())
                {
                    $services_query->the_post();
                    $service_id    = get_the_ID();
                    $services_info = $get_info_obj->service_info($service_id, $duration, $room_count, $total_guest);
                    if (!empty($services_info['mandatory']))
                    {
                        $services_list['mandatory'][] = $services_info;
                    }
                    else
                    {
                        $services_list['optional'][] = $services_info;
                    }
                }
            }
            else
            {
                $services_list = null;
            }
            echo json_encode($services_list);
            die();
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Update rating
         * ------------------------------------------------------------------------------------------
         */
        public function update_rating()
        {
            $room_id           = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : '';
            $rate              = isset($_REQUEST['rateVal']) ? intval($_REQUEST['rateVal']) : '';
            $item_index        = isset($_REQUEST['rateItem']) ? str_replace('rate_', '', $_REQUEST['rateItem']) : '';
            $current_user_info = wp_get_current_user();
            $current_user_id   = $current_user_info->ID;

            if (check_ajax_referer('mana-rating-item', 'security'))
            {
                $rating_post_meta_txt = 'mana_booking_room_rating';
                $rate_meta            = get_post_meta($room_id, $rating_post_meta_txt, true);

                if (!empty($rate_meta))
                {
                    $rate_meta[ $current_user_id ][ $room_id ][ intval($item_index) ] = $rate;
                }
                else
                {
                    $rate_meta                                 = array();
                    $rate_meta[ $current_user_id ][ $room_id ] = array($item_index => $rate);
                }

                update_post_meta($room_id, $rating_post_meta_txt, $rate_meta);
                $return_value['status']  = true;
                $return_value['message'] = esc_html__('Thanks for rating.', 'mana-booking');
            }
            else
            {
                $return_value['status']  = false;
                $return_value['message'] = esc_html__('You are cheating!', 'mana-booking');
            }

            echo json_encode($return_value);
            die();
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Delete Invoice
         * ------------------------------------------------------------------------------------------
         */
        public function delete_invoice()
        {
            global $wpdb;
            $table_name = $wpdb->prefix . 'mana_invoice';
            $invoice_id = (!empty($_REQUEST['id']) ? intval($_REQUEST['id']) : '');
            $security   = (!empty($_REQUEST['security']) ? sanitize_text_field($_REQUEST['security']) : '');

            if (!empty($invoice_id) && wp_verify_nonce($security, 'payment-invoice-delete'))
            {
                $booking_information = $wpdb->get_var($wpdb->prepare('SELECT * FROM ' . $table_name . ' WHERE id=%s', $invoice_id));
                if (!empty($booking_information))
                {
                    $deleted_row = $wpdb->delete($table_name, array('id' => $invoice_id), array('%d'));
                    if ($deleted_row)
                    {
                        $return_value['status'] = true;
                    }
                    else
                    {
                        $return_value['status'] = false;
                    }
                }
                else
                {
                    $return_value['status'] = false;
                }
            }
            else
            {
                $return_value['status'] = false;
            }

            echo json_encode($return_value);
            die();
        }
    }

    $mana_booking_ajax_obj = new Mana_booking_ajax();
