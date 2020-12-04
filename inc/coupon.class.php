<?php

    class Mana_booking_coupon
    {
        public function __construct()
        {
            add_action('wp_ajax_nopriv_mana_booking_check_coupon', array($this, 'check_coupon'));
            add_action('wp_ajax_mana_booking_check_coupon', array($this, 'check_coupon'));
        }

        /**
        * ------------------------------------------------------------------------------------------
        *  Check Coupon
        * ------------------------------------------------------------------------------------------
        */
        public function check_coupon()
        {
            $return_value = array(
                'status'  => false,
                'message' => ''
             );
            $coupon_title = !empty($_POST['coupon']) ? filter_var($_POST['coupon'], FILTER_SANITIZE_STRING) : '';
            $security     = !empty($_POST['security']) ? filter_var($_POST['security'], FILTER_SANITIZE_STRING) : '';

            if (!empty($security) && wp_verify_nonce($security, 'coupon-security-item'))
            {
                if (!empty($coupon_title))
                {
                    $post_info   = get_page_by_title($coupon_title, OBJECT, 'coupon');

                    if (!empty($post_info))
                    {
                        $coupon_info = Mana_booking_get_info::coupon_info($post_info->ID);
                        $today       = date('Y-m-d');

                        if ($today > $coupon_info['expire_date'])
                        {
                            $return_value['message'] = esc_html__('Coupon is expired.', 'mana-booking');
                        }
                        elseif ($coupon_info['used_coupon'] >= intval($coupon_info['amount']))
                        {
                            $return_value['message'] = esc_html__('Coupon is finished.', 'mana-booking');
                        }
                        else
                        {
                            self::update_count($post_info->ID);
                            $return_value['info']    = $coupon_info;
                            $return_value['status']  = true;
                            $return_value['message'] = esc_html__('Coupon is applied.', 'mana-booking');
                        }
                    }
                    else
                    {
                        $return_value['message'] = esc_html__('Invalid Coupon.', 'mana-booking');
                    }
                }
                else
                {
                    $return_value['message']= esc_html__('Please fill the coupon field.', 'mana-booking');
                }
            }
            else
            {
                $return_value['message'] = esc_html__('Are you cheating?', 'mana-booking');
            }

            echo json_encode($return_value);
            die();
        }

        /**
        * ------------------------------------------------------------------------------------------
        *  Update Coupon Count
        * ------------------------------------------------------------------------------------------
        */
        public function update_count($id)
        {
            $field_id    = 'mana_booking_coupon_used';
            $old         = (int) get_post_meta($id, $field_id, true);
            update_post_meta($id, $field_id, $old + 1);
        }
    }
    $mana_booking_coupon_obj = new Mana_booking_coupon();
