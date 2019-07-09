<?php

    class Ravis_booking_ajax
    {
        public function __construct()
        {
            add_action('wp_ajax_nopriv_ravis_booking_insert_testimonials', array($this, 'insert_testimonials'));
            add_action('wp_ajax_ravis_booking_insert_testimonials', array($this, 'insert_testimonials'));

            add_action('wp_ajax_nopriv_ravis_booking_event_booking_status', array($this, 'event_booking_status'));
            add_action('wp_ajax_ravis_booking_event_booking_status', array($this, 'event_booking_status'));

            add_action('wp_ajax_nopriv_ravis_booking_event_booking_delete', array($this, 'event_booking_delete'));
            add_action('wp_ajax_ravis_booking_event_booking_delete', array($this, 'event_booking_delete'));

            add_action('wp_ajax_nopriv_ravis_booking_event_booking_submit', array($this, 'event_booking_submit'));
            add_action('wp_ajax_ravis_booking_event_booking_submit', array($this, 'event_booking_submit'));

            add_action('wp_ajax_nopriv_ravis_booking_services', array($this, 'booking_services'));
            add_action('wp_ajax_ravis_booking_services', array($this, 'booking_services'));

            add_action('wp_ajax_nopriv_ravis_booking_get_package', array($this, 'get_package_info'));
            add_action('wp_ajax_ravis_booking_get_package', array($this, 'get_package_info'));

            add_action('wp_ajax_nopriv_ravis_booking_rating', array($this, 'update_rating'));
            add_action('wp_ajax_ravis_booking_rating', array($this, 'update_rating'));

            add_action('wp_ajax_nopriv_ravis_booking_delete_invoice', array($this, 'delete_invoice'));
            add_action('wp_ajax_ravis_booking_delete_invoice', array($this, 'delete_invoice'));
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Add Testimonial
         * ------------------------------------------------------------------------------------------
         */
        public function insert_testimonials()
        {
            $name         = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
            $job          = isset($_POST['job']) ? sanitize_text_field($_POST['job']) : '';
            $email        = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
            $tel          = isset($_POST['tel']) ? sanitize_text_field($_POST['tel']) : '';
            $title        = isset($_POST['title']) ? sanitize_text_field($_POST['title']) : '';
            $testimonials = isset($_POST['testimonials']) ? sanitize_text_field($_POST['testimonials']) : '';
            $nonce        = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';

            if (wp_verify_nonce($nonce, 'testimonial_form_nonce'))
            {
                if (!empty($name) && !empty($title) && !empty($testimonials))
                {
                    // Create post options
                    $testimonial = array(
                        'post_type'    => 'testimonials',
                        'post_title'   => esc_html($title),
                        'post_content' => esc_html($testimonials),
                        'post_status'  => 'pending'
                    );

                    // Insert the post into the database
                    $post_id = wp_insert_post($testimonial);
                    if ($post_id !== 0)
                    {
                        if (!empty($name))
                        {
                            add_post_meta($post_id, 'ravis_booking_testimonials_guest_name', $name);
                        }
                        if (!empty($job))
                        {
                            add_post_meta($post_id, 'ravis_booking_testimonials_guest_job', $job);
                        }
                        if (!empty($email))
                        {
                            add_post_meta($post_id, 'ravis_booking_testimonials_guest_email', $email);
                        }
                        if (!empty($tel))
                        {
                            add_post_meta($post_id, 'ravis_booking_testimonials_guest_phone', $tel);
                        }

                        $result['status']  = true;
                        $result['message'] = esc_html__('Your feedback will be listed after confirmation.', 'ravis-booking');
                        echo json_encode($result);
                    }
                }
                else
                {
                    $result['status']  = false;
                    $result['message'] = esc_html__('Please fill all the required fields.', 'ravis-booking');
                    echo json_encode($result);
                }
            }
            else
            {
                $result['status']  = false;
                $result['message'] = esc_html__('Something wrong about your request happens.', 'ravis-booking');
                echo json_encode($result);
            }

            die();
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Confirm event booking list
         * ------------------------------------------------------------------------------------------
         */
        public function event_booking_status()
        {
            global $wpdb;
            $event_booking_id = isset($_POST['eventBookingID']) ? intval($_POST['eventBookingID']) : '';
            $nonce            = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';

            if (wp_verify_nonce($nonce, 'event_metabox_list'))
            {
                $table_name    = $wpdb->prefix . 'ravis_event_booking';
                $update_return = $wpdb->update($table_name, array('status' => 1, ), array('id' => $event_booking_id), array('%d'), array('%d'));

                if (false === $update_return)
                {
                    $result['status']  = false;
                    $result['message'] = esc_html__("Because of some Database issues, event's booking is not updated now.", 'ravis-booking');
                    echo json_encode($result);
                }
                else
                {
                    $result['status']  = true;
                    $result['message'] = esc_html__("Event's booking is updated now.", 'ravis-booking');
                    echo json_encode($result);
                }
            }
            else
            {
                $result['status']  = false;
                $result['message'] = esc_html__('Something wrong about your request happens.', 'ravis-booking');
                echo json_encode($result);
            }
            die();
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Delete event booking list
         * ------------------------------------------------------------------------------------------
         */
        public function event_booking_delete()
        {
            global $wpdb;
            $event_booking_id = isset($_POST['eventBookingID']) ? intval($_POST['eventBookingID']) : '';
            $nonce            = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';

            if (wp_verify_nonce($nonce, 'event_metabox_list'))
            {
                $table_name    = $wpdb->prefix . 'ravis_event_booking';
                $delete_return = $wpdb->delete($table_name, array('id' => $event_booking_id), array('%d'));

                if (false === $delete_return)
                {
                    $result['status']  = false;
                    $result['message'] = esc_html__("Because of some Database issues, event's booking is not updated now.", 'ravis-booking');
                    echo json_encode($result);
                }
                else
                {
                    $result['status']  = true;
                    $result['message'] = esc_html__("Event's booking is updated now.", 'ravis-booking');
                    echo json_encode($result);
                }
            }
            else
            {
                $result['status']  = false;
                $result['message'] = esc_html__('Something wrong about your request happens.', 'ravis-booking');
                echo json_encode($result);
            }
            die();
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Event Booking
         * ------------------------------------------------------------------------------------------
         */
        public function event_booking_submit()
        {
            global $wpdb;
            $event_id    = isset($_POST['eventID']) ? intval($_POST['eventID']) : '';
            $name        = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
            $email       = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
            $tel         = isset($_POST['tel']) ? sanitize_text_field($_POST['tel']) : '';
            $guest_count = isset($_POST['guestCount']) ? intval($_POST['guestCount']) : '';
            $nonce       = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';

            if (wp_verify_nonce($nonce, 'event_booking_form_nonce'))
            {
                if (!empty($event_id) && !empty($name) && !empty($email) && !empty($tel) && !empty($guest_count))
                {
                    $table_name   = $wpdb->prefix . 'ravis_event_booking';
                    $insert_query = $wpdb->insert($table_name, array(
                        'event_id'   => $event_id,
                        'guest'      => $guest_count,
                        'guest_name' => $name,
                        'phone'      => $tel,
                        'email'      => $email,
                    ), array(
                        '%d',
                        '%d',
                        '%s',
                        '%s',
                        '%s'
                    ));

                    if (false === $insert_query)
                    {
                        $result['status']  = false;
                        $result['message'] = esc_html__('Because of some Database issues, your booking was not proceed. Please try again.', 'ravis-booking');
                        echo json_encode($result);
                    }
                    else
                    {
                        $result['status']  = true;
                        $result['message'] = esc_html__('Your booking was proceed, it must be confirmed by administration of website.', 'ravis-booking');
                        echo json_encode($result);
                    }
                }
                else
                {
                    $result['status']  = false;
                    $result['message'] = esc_html__('Please fill all fields.', 'ravis-booking');
                    echo json_encode($result);
                }
            }
            else
            {
                $result['status']  = false;
                $result['message'] = esc_html__('Something wrong about your request happens.', 'ravis-booking');
                echo json_encode($result);
            }
            die();
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  List All Booking Services
         * ------------------------------------------------------------------------------------------
         */
        public function booking_services()
        {
            global $wp_query;
            $get_info_obj = new Ravis_booking_get_info();
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
                        'key'   => 'ravis_booking_service_booking',
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
         *  Get Package Information
         * ------------------------------------------------------------------------------------------
         */
        public function get_package_info()
        {
            $get_info_obj = new Ravis_booking_get_info();
            $package_id   = isset($_REQUEST['packageID']) ? intval($_REQUEST['packageID']) : '';
            $duration     = isset($_REQUEST['duration']) ? intval($_REQUEST['duration']) : '';
            $room_count   = isset($_REQUEST['roomCount']) ? intval($_REQUEST['roomCount']) : '';
            $total_guest  = isset($_REQUEST['totalGuest']) ? intval($_REQUEST['totalGuest']) : '';

            $package_info = $get_info_obj->package_info($package_id, $duration, $room_count, $total_guest);
            if ($package_info)
            {
                $return_value['status'] = true;
                $return_value['info']   = $package_info;
            }
            else
            {
                $return_value['status'] = false;
            }

            echo json_encode($return_value);
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

            if (check_ajax_referer('ravis-rating-item', 'security'))
            {
                $rating_post_meta_txt = 'ravis_booking_room_rating';
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
                $return_value['message'] = esc_html__('Thanks for rating.', 'ravis-booking');
            }
            else
            {
                $return_value['status']  = false;
                $return_value['message'] = esc_html__('You are cheating!', 'ravis-booking');
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
            $table_name = $wpdb->prefix . 'ravis_invoice';
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

    $ravis_booking_ajax_obj = new Ravis_booking_ajax();