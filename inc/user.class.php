<?php

//	User Action Class

class Mana_booking_user
{
    public $mana_booking_option;

    public function __construct()
    {
        $this->mana_booking_option = json_decode(get_option('mana-booking-setting')['main_setting'], true);

        add_action('init', array($this, 'user_panel'));
        add_action('parse_request', array($this, 'user_panel_request'));
        add_filter('query_vars', array($this, 'user_panel_var'));

        add_action('wp_ajax_nopriv_mana_booking_login', array($this, 'login_user'));
        add_action('wp_ajax_mana_booking_login', array($this, 'login_user'));

        add_action('wp_ajax_nopriv_mana_booking_register', array($this, 'register_user'));
        add_action('wp_ajax_mana_booking_register', array($this, 'register_user'));

        add_action('wp_ajax_nopriv_mana_booking_update_profile', array($this, 'update_profile'));
        add_action('wp_ajax_mana_booking_update_profile', array($this, 'update_profile'));

        add_action('init', array($this, 'admin_restrict'));
        add_action('user_register', array($this, 'add_meta_data'), 10, 1);

        if (!empty($this->mana_booking_option['wp_email_sender'])) {
            add_filter('wp_mail_from', array($this, 'change_wp_default_sender_email'));
        }
        if (!empty($this->mana_booking_option['wp_email_sender_name'])) {
            add_filter('wp_mail_from_name', array($this, 'change_wp_default_sender_name'));
        }
    }

    public function add_meta_data($user_id)
    {
        $meta_data_fields = array(
            'phone',
            'address',
            'total_booking_item',
            'total_booking_price',
            'membership',
        );
        foreach ($meta_data_fields as $meta_data_field) {
            add_user_meta($user_id, $meta_data_field, '', true);
        }
    }

    public function login_user()
    {
        if (!empty($_POST['security']) && wp_verify_nonce($_POST['security'], 'ajax-login-nonce')) {
            // Nonce is checked, get the POST data and sign user on
            $info = array();
            $info['user_login'] = sanitize_text_field($_POST['username']);
            $info['user_password'] = sanitize_text_field($_POST['password']);
            $info['remember'] = true;

            $user_signon = wp_signon($info, false);
            if (is_wp_error($user_signon)) {
                $return_value = array(
                    'loggedin' => false,
                    'message' => esc_html__('Wrong username or password.', 'mana-booking')
                );
            } else {
                $return_value = array(
                    'loggedin' => true,
                    'message' => esc_html__('You are logged in.', 'mana-booking')
                );
            }
        } else {
            $return_value = array(
                'loggedin' => false,
                'message' => esc_html__('Are your cheating?', 'mana-booking')
            );
        }

        echo json_encode($return_value);
        die();
    }

    public function register_user()
    {
        if (!empty($_POST['security']) && wp_verify_nonce($_POST['security'], 'ajax-register-nonce')) {
            $info = array();
            $info['user_nickname'] = $info['nickname'] = $info['display_name'] = $info['first_name'] = $info['user_login'] = sanitize_user($_POST['username']);
            $info['user_email'] = sanitize_email($_POST['email']);
            $info['password'] = wp_generate_password();
            $info['role'] = 'subscriber';

            // Register the user
            $user_register = wp_insert_user($info);

            if (is_wp_error($user_register)) {
                $error = $user_register->get_error_codes();

                if (in_array('empty_user_login', $error)) {
                    $return_value = array(
                        'loggedin' => false,
                        'message' => esc_html__($user_register->get_error_message('empty_user_login'))
                    );
                } elseif (in_array('existing_user_login', $error)) {
                    $return_value = array(
                        'loggedin' => false,
                        'message' => esc_html__($user_register->get_error_message('existing_user_login'))
                    );
                } elseif (in_array('existing_user_login', $error)) {
                    $return_value = array(
                        'loggedin' => false,
                        'message' => esc_html__('This username is already registered.', 'mana-booking')
                    );
                } elseif (in_array('existing_user_email', $error)) {
                    $return_value = array(
                        'loggedin' => false,
                        'message' => esc_html__('This email address is already registered.', 'mana-booking')
                    );
                }
            } else {
                wp_new_user_notification($user_register, $info['password']);
                $return_value = array(
                    'loggedin' => true,
                    'message' => esc_html__('Thanks for your registration, please check your email.', 'mana-booking')
                );
            }
        } else {
            $return_value = array(
                'loggedin' => false,
                'message' => esc_html__('Are your cheating?', 'mana-booking')
            );
        }

        echo json_encode($return_value);
        die();
    }

    public function admin_restrict()
    {
        // Disable Admin bar
        if (!current_user_can('administrator') && !is_admin()) {
            show_admin_bar(false);
        }

        // Redirect users to home page
        if (is_admin() && !defined('DOING_AJAX') && (current_user_can('subscriber') || current_user_can('contributor'))) {
            wp_redirect(home_url());
            exit;
        }
    }

    public function user_panel()
    {
        add_rewrite_rule('booking.php$', 'index.php?user-panel', 'top');
    }

    public function user_panel_var($query_vars)
    {
        $query_vars[] = 'user-panel';

        return $query_vars;
    }

    public function user_panel_request(&$wp)
    {
        if (array_key_exists('user-panel', $wp->query_vars)) {
            include MANA_BOOKING_TPL . 'user-panel.php';
            exit();
        }

        return;
    }

    public function update_profile()
    {
        if (!empty($_POST['security']) && wp_verify_nonce($_POST['security'], 'profile-update')) {
            $current_user_info = wp_get_current_user();
            $first_name = !empty($_POST['fName']) ? sanitize_text_field($_POST['fName']) : '';
            $last_name = !empty($_POST['lName']) ? sanitize_text_field($_POST['lName']) : '';
            $phone = !empty($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
            $email = !empty($_POST['email']) ? sanitize_email($_POST['email']) : '';
            $address = !empty($_POST['address']) ? sanitize_text_field($_POST['address']) : '';

            if (!empty($first_name) || !empty($last_name) || !empty($email)) {
                $primary_user_info = array(
                    'ID' => $current_user_info->ID,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'user_email' => $email
                );
                $update_primary = wp_update_user($primary_user_info);
                if (is_wp_error($update_primary)) {
                    $return_value = array(
                        'status' => false,
                        'message' => esc_html__('Your information was not updated, please try again.', 'mana-booking')
                    );
                } else {
                    if (!empty($phone)) {
                        update_user_meta($current_user_info->ID, 'phone', $phone);
                    }
                    if (!empty($address)) {
                        update_user_meta($current_user_info->ID, 'address', $address);
                    }
                    $return_value = array(
                        'status' => true,
                        'message' => esc_html__('Your information is updated.', 'mana-booking')
                    );
                }
            } else {
                $return_value = array(
                    'status' => false,
                    'message' => esc_html__('Please fill all required fields.', 'mana-booking')
                );
            }
        } else {
            $return_value = array(
                'status' => false,
                'message' => esc_html__('Are your cheating?', 'mana-booking')
            );
        }

        echo json_encode($return_value);
        die();
    }

    public function automatic_profile_updater()
    {
        global $wpdb;
        $user_param = array(
            'exclude' => array('1')
        );
        $all_users = get_users($user_param);
        $table_name = $wpdb->prefix . 'mana_booking';
        foreach ($all_users as $user_item) {
            $user_id = $user_item->ID;
            $user_bookings = $wpdb->get_results($wpdb->prepare('SELECT * FROM ' . $table_name . ' WHERE `user_id`="%d" AND `confirmed`="1" ', $user_id));
            $user_total_price = 0;
            if (!empty($user_bookings)) {
                $user_total_booking = count($user_bookings);
                foreach ($user_bookings as $user_booking) {
                    $booking_info = unserialize($user_booking->booking_info);
                    $booking_currency = unserialize($user_booking->booking_currency);
                    $default_currency_price = Mana_booking_currency::convert_to_default($booking_info->totalBookingPrice, $booking_currency);
                    $user_total_price += floatval($default_currency_price);
                }
            }

            if (!empty($user_total_booking)) {
                update_user_meta($user_id, 'total_booking_item', $user_total_booking);
            }
            if (!empty($user_total_price)) {
                update_user_meta($user_id, 'total_booking_price', $user_total_price);
            }

            if (!empty($user_total_booking) && !empty($user_total_price)) {
                $membership_id = self::check_membership($user_total_booking, $user_total_price);
                if (!empty($membership_id)) {
                    update_user_meta($user_id, 'membership', $membership_id);
                } else {
                    update_user_meta($user_id, 'membership', '');
                }
            }
        }
    }

    public function check_membership($booking_count, $booking_price)
    {
        $mana_booking_options = json_decode(get_option('mana-booking-setting')['main_setting'], true);
        $package_info = null;
        if ($mana_booking_options['membership']) {
            $highest_count = 0;
            $highest_total_price = 0;
            $highest_discount = 0;
            foreach ($mana_booking_options['membership'] as $index => $membership_item) {
                switch ($membership_item['condition']) {
                    case '1':
                        if ($booking_price >= intval($membership_item['single-condition-price'])) {
                            if (intval($membership_item['single-condition-price']) >= $highest_total_price && $membership_item['discount'] >= $highest_discount) {
                                $highest_total_price = intval($membership_item['single-condition-item']);
                                $highest_discount = $membership_item['discount'];
                                $package_info = array(
                                    'title' => $membership_item['title'],
                                    'badge' => $membership_item['badge'],
                                    'discount' => $membership_item['discount'],
                                );
                            }
                        }
                        break;
                    case '2':

                        if ($booking_count >= intval($membership_item['single-condition-item'])) {
                            if (intval($membership_item['single-condition-item']) >= $highest_count && $membership_item['discount'] >= $highest_discount) {
                                $highest_count = intval($membership_item['single-condition-item']);
                                $highest_discount = $membership_item['discount'];
                                $package_info = array(
                                    'title' => $membership_item['title'],
                                    'badge' => $membership_item['badge'],
                                    'discount' => $membership_item['discount'],
                                );
                            }
                        }
                        break;
                    case '3':
                        if ($membership_item['single-condition-item'] == '1') {
                            if (($booking_price >= intval($membership_item['condition-price']) && $booking_count >= intval($membership_item['condition-item'])) && $membership_item['discount'] >= $highest_discount) {
                                if ($highest_total_price >= intval($membership_item['single-condition-item']) && $highest_count >= intval($membership_item['single-condition-item'])) {
                                    $highest_total_price = intval($membership_item['single-condition-item']);
                                    $highest_count = intval($membership_item['single-condition-item']);
                                    $highest_discount = $membership_item['discount'];
                                    $package_info = array(
                                        'title' => $membership_item['title'],
                                        'badge' => $membership_item['badge'],
                                        'discount' => $membership_item['discount'],
                                    );
                                }
                            }
                        } else {
                            if (($booking_price >= intval($membership_item['condition-price']) || $booking_count >= intval($membership_item['condition-item'])) && $membership_item['discount'] >= $highest_discount) {
                                if ($highest_total_price >= intval($membership_item['single-condition-item']) && $highest_count >= intval($membership_item['single-condition-item'])) {
                                    $highest_total_price = intval($membership_item['single-condition-item']);
                                    $highest_count = intval($membership_item['single-condition-item']);
                                    $highest_discount = $membership_item['discount'];
                                    $package_info = array(
                                        'title' => $membership_item['title'],
                                        'badge' => $membership_item['badge'],
                                        'discount' => $membership_item['discount'],
                                    );
                                }
                            }
                        }
                        break;
                }
            }
        }

        return $package_info;
    }

    public function change_wp_default_sender_email()
    {
        $email_sender = !empty($this->mana_booking_option['wp_email_sender']) ? $this->mana_booking_option['wp_email_sender'] : '';

        return $email_sender;
    }

    public function change_wp_default_sender_name()
    {
        $email_sender_name = !empty($this->mana_booking_option['wp_email_sender_name']) ? $this->mana_booking_option['wp_email_sender_name'] : '';

        return $email_sender_name;
    }
}

$mana_booking_user_obj = new Mana_booking_user();
