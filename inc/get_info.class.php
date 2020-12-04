<?php

    class Mana_booking_get_info
    {
        public $mana_options;

        public function __construct()
        {
            $this->mana_options = get_option('mana-booking-setting');
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Get the original post ID
         * ------------------------------------------------------------------------------------------
         */
        public static function original_post_id($p_id, $p_type = 'post')
        {
            if (function_exists('icl_object_id'))
            {
                global $sitepress;
                if (!empty($sitepress))
                {
                    $original_id = $sitepress->get_default_language();
                }
                else
                {
                    $original_id = pll_default_language();
                }
                $p_id        = icl_object_id(intval($p_id), $p_type, true, $original_id);
            }

            return $p_id;
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Get Booking Page URL
         * ------------------------------------------------------------------------------------------
         */
        public static function booking_page_url()
        {
            $plugin_option = get_option('mana-booking-setting');

            if (!empty($plugin_option['external_booking']))
            {
                $booking_page_url = (!empty($plugin_option['external_booking_url']) ? $plugin_option['external_booking_url'] : '#');
            }
            else
            {
                $booking_page_url = home_url() . '/?' . (!empty($plugin_option['booking_url']) ? $plugin_option['booking_url'] : 'mana-booking');
            }

            return $booking_page_url;
        }

        /**
         * ------------------------------------------------------------------------------------------
         * Get All Room Information
         * ------------------------------------------------------------------------------------------
         */
        public function room_info($p_id, $check_in = null, $check_out = null, $duration = null, $adult = null, $child = null, $language = null)
        {
            $room_info     = array();
            $p_id          = Mana_booking_get_info::translated_post_id($p_id);

            /**
             * ------------------------------------------------------------------------------------------
             *  Basic Details
             * ------------------------------------------------------------------------------------------
             */
            $room_meta_box_prefix           = 'mana_booking_room_';
            $room_info['id']                = $p_id;
            $room_info['title']             = get_the_title($p_id);
            $room_info['subtitle']          = get_post_meta($p_id, $room_meta_box_prefix . 'subtitle', true);
            $room_info['description']['wp'] = get_extended(get_post_field('post_content', $p_id));
            $room_info['url']               = get_permalink($p_id);
            $room_info['category']          = get_the_terms($p_id, 'room-category');

            /**
             * ------------------------------------------------------------------------------------------
             *  Room extra information
             * ------------------------------------------------------------------------------------------
             */
            $room_info['description']['short'] = get_post_meta($p_id, $room_meta_box_prefix . 'short_desc', true);
            $room_info['count']                = get_post_meta($p_id, $room_meta_box_prefix . 'count', true);
            $room_info['capacity']             = get_post_meta($p_id, $room_meta_box_prefix . 'capacity', true);
            $room_info['max_people']           = intval($room_info['capacity']['main']) + intval($room_info['capacity']['extra']);
            $room_info['min_stay']             = get_post_meta($p_id, $room_meta_box_prefix . 'min_stay', true);
            $room_size                         = get_post_meta($p_id, $room_meta_box_prefix . 'room_size', true);

            if (gettype($room_size) === 'string')
            {
                $room_size = array(
                    'value' => $room_size,
                    'unit'  => 'sqft'
                );
            }

            $room_info['room_size']['qnt']  = $room_size['value'];
            $room_info['room_size']['unit'] = $room_size['unit'] === 'm2' ? 'm<sup>2</sup>' : $room_size['unit'];
            $room_info['room_view']         = get_post_meta($p_id, $room_meta_box_prefix . 'room_view', true);
            $room_info['facilities']        = get_post_meta($p_id, $room_meta_box_prefix . 'facilities', true);
            $room_info['service']           = get_post_meta($p_id, $room_meta_box_prefix . 'service', true);

            /**
             * ------------------------------------------------------------------------------------------
             *  Room Gallery
             * ------------------------------------------------------------------------------------------
             */
            $room_images       = get_post_meta($p_id, $room_meta_box_prefix . 'gallery', true);
            $room_thumb_arr    = array();
            $trimmed_image_val = trim($room_images);
            if (!empty($trimmed_image_val))
            {
                $room_thumb_arr = explode('---', $room_images);
                $i              = 0;
                foreach ($room_thumb_arr as $room_image)
                {
                    $room_image                                             = trim($room_image);
                    $room_info['gallery']['img'][ $i ]['id']                = $room_image;
                    $room_info['gallery']['img'][ $i ]['url']               = wp_get_attachment_url($room_image);
                    $room_info['gallery']['img'][ $i ]['code']['thumbnail'] = wp_get_attachment_image($room_image, 'thumbnail');
                    $room_info['gallery']['img'][ $i ]['code']['medium']    = wp_get_attachment_image($room_image, 'medium');
                    $room_info['gallery']['img'][ $i ]['code']['large']     = wp_get_attachment_image($room_image, 'large');
                    $room_info['gallery']['img'][ $i ]['code']['full']      = wp_get_attachment_image($room_image, 'full');
                    $i++;
                }
            }
            $room_info['gallery']['count'] = (!empty($room_info) ? count($room_thumb_arr) : 0);

            /**
             * ------------------------------------------------------------------------------------------
             *  Room Price
             * ------------------------------------------------------------------------------------------
             */
            $currency_info               = new Mana_booking_currency();
            $room_info['price']['unit']  = $currency_info->get_current_currency();
            $room_price_meta_box_prefix  = 'mana_booking_room_price_';
            $room_info['price_unit']     = $room_info['price']['unit']['symbol'];
            $init_base_price             = get_post_meta($p_id, $room_price_meta_box_prefix . 'base_price', true);
            $init_extra_price            = get_post_meta($p_id, $room_price_meta_box_prefix . 'extra_price', true);
            $room_info['extra_price']    = $init_extra_price;
            $room_info['seasonal_price'] = get_post_meta($p_id, $room_price_meta_box_prefix . 'seasonal_price', true);
            $room_info['discount']       = get_post_meta($p_id, $room_price_meta_box_prefix . 'discount', true);

            $new_room_base_price = $new_room_extra_price = array();
            foreach ($init_base_price as $age_index => $age_value)
            {
                foreach ($age_value as $index => $value)
                {
                    $new_room_base_price[ $age_index ][ $index ] = $currency_info->price_exchanger($value);
                }
            }
            $room_info['generated_price'] = $room_info['base_price'] = $new_room_base_price;

            foreach ($room_info['extra_price'] as $age_index => $age_value)
            {
                foreach ($age_value as $index => $value)
                {
                    $new_room_extra_price[ $age_index ][ $index ] = $currency_info->price_exchanger($value);
                }
            }
            $room_info['generated_price']['extra'] = $new_room_extra_price;
            $room_info['start_price']              = $currency_info->price_generator_no_exchange($room_info['base_price']['adult']['weekday']);

            // Check Seasonal Price for Generating new Price
            // if (!empty($room_info['seasonal_price']))
            // {
            //     foreach ($room_info['seasonal_price'] as $price_item)
            //     {
            //         $season_start = strtotime($price_item['start']);
            //         $season_end   = strtotime($price_item['end']);

            //         if (!empty($check_in) && !empty($check_out))
            //         {
            //             if ((strtotime($check_in) <= $season_start and strtotime($check_out) > $season_start) or (strtotime($check_in) >= $season_start and strtotime($check_in) < $season_end))
            //             {
            //                 foreach ($price_item as $main_index => $main_value)
            //                 {
            //                     switch ($main_index)
            //                     {
            //                         case 'start':
            //                             continue;
            //                             break;
            //                         case 'end':
            //                             continue;
            //                             break;
            //                         case 'extra':
            //                             foreach ($main_value as $age_index => $age_value)
            //                             {
            //                                 foreach ($age_value as $index => $value)
            //                                 {
            //                                     $new_room_extra_price[ $age_index ][ $index ] = $currency_info->price_exchanger($value);
            //                                 }
            //                             }
            //                             break;
            //                         default:
            //                             foreach ($main_value as $index => $value)
            //                             {
            //                                 $new_room_base_price[ $main_index ][ $index ] = $currency_info->price_exchanger($value);
            //                             }
            //                             break;
            //                     }
            //                 }
            //                 $room_info['generated_price']          = $room_info['base_price'] = $new_room_base_price;
            //                 $room_info['generated_price']['extra'] = $room_info['extra_price'] = (!empty($new_room_extra_price) ? $new_room_extra_price : null);
            //                 $room_info['start_price']              = $currency_info->price_generator_no_exchange($room_info['base_price']['adult']['weekday']);
            //             }
            //         }
            //         else
            //         {
            //             $today = date('Y-m-d');
            //             if (strtotime($today) >= $season_start && strtotime($today) <= $season_end)
            //             {
            //                 foreach ($price_item as $main_index => $main_value)
            //                 {
            //                     switch ($main_index)
            //                     {
            //                         case 'start':
            //                             continue;
            //                             break;
            //                         case 'end':
            //                             continue;
            //                             break;
            //                         case 'extra':
            //                             foreach ($main_value as $age_index => $age_value)
            //                             {
            //                                 foreach ($age_value as $index => $value)
            //                                 {
            //                                     $new_room_extra_price[ $age_index ][ $index ] = $currency_info->price_exchanger($value);
            //                                 }
            //                             }
            //                             break;
            //                         default:
            //                             foreach ($main_value as $index => $value)
            //                             {
            //                                 $new_room_base_price[ $main_index ][ $index ] = $currency_info->price_exchanger($value);
            //                             }
            //                             break;
            //                     }
            //                 }
            //                 $room_info['generated_price']          = $room_info['base_price'] = $new_room_base_price;
            //                 $room_info['generated_price']['extra'] = $room_info['extra_price'] = (!empty($new_room_extra_price) ? $new_room_extra_price : null);
            //                 $room_info['start_price']              = $currency_info->price_generator_no_exchange($room_info['base_price']['adult']['weekday']);
            //             }
            //         }
            //     }
            // }

            // Check for duration discount
            if (!empty($room_info['discount']) && !empty($duration))
            {
                $tmp_generated = $room_info['generated_price'];
                foreach ($room_info['discount'] as $discount)
                {
                    if ($duration >= intval($discount['night']))
                    {
                        $room_info['discount_details'] = array(
                            'nights'  => $discount['night'],
                            'percent' => $discount['percent'],
                            'adult'   => array(
                                'weekday' => ($tmp_generated['adult']['weekday']) * intval($discount['percent']) / 100,
                                'weekend' => ($tmp_generated['adult']['weekend']) * intval($discount['percent']) / 100,
                            ),
                            'child'   => array(
                                'weekday' => ($tmp_generated['child']['weekday']) * intval($discount['percent']) / 100,
                                'weekend' => ($tmp_generated['child']['weekend']) * intval($discount['percent']) / 100,
                            ),
                            'extra'   => array(
                                'adult' => array(
                                    'weekday' => ($tmp_generated['extra']['adult']['weekday']) * intval($discount['percent']) / 100,
                                    'weekend' => ($tmp_generated['extra']['adult']['weekend']) * intval($discount['percent']) / 100,
                                ),
                                'child' => array(
                                    'weekday' => ($tmp_generated['extra']['child']['weekday']) * intval($discount['percent']) / 100,
                                    'weekend' => ($tmp_generated['extra']['child']['weekend']) * intval($discount['percent']) / 100,
                                )
                            )
                        );
                    }
                }
            }

            // Generate Daily Prices on Bookings
            $room_info['booking_price'] = array();
            if (!empty($check_in) && !empty($check_out))
            {
                $check_in_time                        = new DateTime($check_in);
                $check_out_time                       = new DateTime($check_out);
                $weekend_count                        = $weekday_count = 0;
                $weekday_total_price['adult']['main'] = $weekday_total_price['adult']['extra'] = $weekday_total_price['child']['main'] = $weekday_total_price['child']['extra'] = 0;
                $weekend_total_price['adult']['main'] = $weekend_total_price['adult']['extra'] = $weekend_total_price['child']['main'] = $weekend_total_price['child']['extra'] = 0;

                if ($adult > $room_info['capacity']['main'])
                {
                    $adult_main  = $room_info['capacity']['main'];
                    $adult_extra = $adult - $room_info['capacity']['main'];
                    $child_main  = 0;
                    $child_extra = $child;
                }
                else
                {
                    $adult_main  = $adult;
                    $adult_extra = 0;
                    if ($child > 0)
                    {
                        $child_main  = $room_info['capacity']['main'] - $adult_main;
                        $child_extra = ($child + $adult) - ($child_main + $adult_main + $adult_extra);
                    }
                    else
                    {
                        $child_main = $child_extra = 0;
                    }
                }

                $start_price = array();
                while ($check_in_time < $check_out_time)
                {
                    $one_day_val                = self::check_dates($check_in_time, $init_base_price, $init_extra_price, $room_info['seasonal_price'], $weekend);
                    $weekend                    = ($check_in_time->format('N') >= 6 ? true : false);
                    $price_details              = array();
                    $start_price[]              = $one_day_val['start_price'];

                    $room_info['booking_price'][ $check_in_time->format('Y-m-d') ] = $one_day_val;

                    if (!empty($this->mana_options['room_base_price']))
                    {
                        if (!empty($weekend))
                        {
                            $price_details['adult']['main']  = $one_day_val['base']['adult']['weekend'];
                            $price_details['adult']['extra'] = $one_day_val['extra']['adult']['weekend'] * $adult_extra;
                            $price_details['child']['main']  = 0;
                            $price_details['child']['extra'] = $one_day_val['extra']['child']['weekend'] * $child_extra;
                        }
                        else
                        {
                            $price_details['adult']['main']  = $one_day_val['base']['adult']['weekday'];
                            $price_details['adult']['extra'] = $one_day_val['extra']['adult']['weekday'] * $adult_extra;
                            $price_details['child']['main']  = 0;
                            $price_details['child']['extra'] = $one_day_val['extra']['child']['weekday'] * $child_extra;
                        }
                    }
                    else
                    {
                        if (!empty($weekend))
                        {
                            $price_details['adult']['main']  = $one_day_val['base']['adult']['weekend'] * $adult_main;
                            $price_details['adult']['extra'] = $one_day_val['extra']['adult']['weekend'] * $adult_extra;
                            $price_details['child']['main']  = ($child_main > 0) ? $one_day_val['base']['child']['weekend'] * $child_main : 0;
                            $price_details['child']['extra'] = $one_day_val['extra']['child']['weekend'] * $child_extra;
                        }
                        else
                        {
                            $price_details['adult']['main']  = $one_day_val['base']['adult']['weekday'] * $adult_main;
                            $price_details['adult']['extra'] = $one_day_val['extra']['adult']['weekday'] * $adult_extra;
                            $price_details['child']['main']  = ($child_main > 0) ? $one_day_val['base']['child']['weekday'] * $child_main : 0;
                            $price_details['child']['extra'] = $one_day_val['extra']['child']['weekday'] * $child_extra;
                        }
                    }

                    $room_info['booking_price'][ $check_in_time->format('Y-m-d') ]['price_details'] = $price_details;

                    if (!empty($weekend))
                    {
                        $weekend_count++;
                        $weekend_total_price['adult']['main'] += $price_details['adult']['main'];
                        $weekend_total_price['adult']['extra'] += $price_details['adult']['extra'];
                        $weekend_total_price['child']['main'] += $price_details['child']['main'];
                        $weekend_total_price['child']['extra'] += $price_details['child']['extra'];
                    }
                    else
                    {
                        $weekday_count++;
                        $weekday_total_price['adult']['main'] += $price_details['adult']['main'];
                        $weekday_total_price['adult']['extra'] += $price_details['adult']['extra'];
                        $weekday_total_price['child']['main'] += $price_details['child']['main'];
                        $weekday_total_price['child']['extra'] += $price_details['child']['extra'];
                    };

                    $check_in_time->modify('+1 day');
                }

                $room_info['start_price'] = $currency_info->price_generator_no_exchange(min($start_price));


                if ($weekday_count > 0)
                {
                    $room_info['booking_price']['total']['weekday']['adult']['main']  = !empty($weekday_total_price['adult']['main']) ? $currency_info->price_full_generator($weekday_total_price['adult']['main']) : 0;
                    $room_info['booking_price']['total']['weekday']['adult']['extra'] = !empty($weekday_total_price['adult']['extra']) ? $currency_info->price_full_generator($weekday_total_price['adult']['extra']) : 0;
                    $room_info['booking_price']['total']['weekday']['child']['main']  = !empty($weekday_total_price['child']['main']) ? $currency_info->price_full_generator($weekday_total_price['child']['main']) : 0;
                    $room_info['booking_price']['total']['weekday']['child']['extra'] = !empty($weekday_total_price['child']['extra']) ? $currency_info->price_full_generator($weekday_total_price['child']['extra']) : 0;
                    $room_info['booking_price']['total']['weekday']['count']          = $weekday_count;
                }
                if ($weekend_count > 0)
                {
                    $room_info['booking_price']['total']['weekend']['adult']['main']  = !empty($weekend_total_price['adult']['main']) ? $currency_info->price_full_generator($weekend_total_price['adult']['main']) : 0;
                    $room_info['booking_price']['total']['weekend']['adult']['extra'] = !empty($weekend_total_price['adult']['extra']) ? $currency_info->price_full_generator($weekend_total_price['adult']['extra']) : 0;
                    $room_info['booking_price']['total']['weekend']['child']['main']  = !empty($weekend_total_price['child']['main']) ? $currency_info->price_full_generator($weekend_total_price['child']['main']) : 0;
                    $room_info['booking_price']['total']['weekend']['child']['extra'] = !empty($weekend_total_price['child']['extra']) ? $currency_info->price_full_generator($weekend_total_price['child']['extra']) : 0;

                    $room_info['booking_price']['total']['weekend']['count'] = $weekend_count;
                }

                $booking_total_price                                   = $weekday_total_price['adult']['main'] + $weekday_total_price['adult']['extra'] + $weekday_total_price['child']['main'] + $weekday_total_price['child']['extra'] + $weekend_total_price['adult']['main'] + $weekend_total_price['adult']['extra'] + $weekend_total_price['child']['main'] + $weekend_total_price['child']['extra'];
                $room_info['booking_price']['total']['total_price']    = $currency_info->price_full_generator($booking_total_price);
                $room_info['booking_price']['guest']['adult']['main']  = $adult_main;
                $room_info['booking_price']['guest']['adult']['extra'] = $adult_extra;
                $room_info['booking_price']['guest']['child']['main']  = $child_main;
                $room_info['booking_price']['guest']['child']['extra'] = $child_extra;

                if (!empty($room_info['discount_details']))
                {
                    $booking_discount                                   = ($booking_total_price * $room_info['discount_details']['percent']) / 100;
                    $room_info['booking_price']['total']['discount']    = $currency_info->price_full_generator($booking_discount);
                    $room_info['booking_price']['total']['payable']     = $currency_info->price_full_generator($booking_total_price - $booking_discount);
                    $room_info['booking_price']['total']['payable_raw'] = $currency_info->price_exchanger($booking_total_price - $booking_discount);
                }
                else
                {
                    $room_info['booking_price']['total']['discount']    = 0;
                    $room_info['booking_price']['total']['payable']     = $currency_info->price_full_generator($booking_total_price);
                    $room_info['booking_price']['total']['payable_raw'] = $currency_info->price_exchanger($booking_total_price);
                }
            }

            /**
             * ------------------------------------------------------------------------------------------
             *  Rating info
             * ------------------------------------------------------------------------------------------
             */
            $room_rating_info = get_post_meta($p_id, 'mana_booking_room_rating', true);
            $rating_items     = !empty($this->mana_options['rating_item']) ? $this->mana_options['rating_item'] : '';
            $room_total_rate  = array();
            if (!empty($rating_items))
            {
                foreach ($rating_items as $rate_index => $rating_item)
                {
                    $room_total_rate[ $rate_index ] = array(
                        'value' => 0,
                        'count' => 0,
                    );
                }
            }
            if (!empty($room_rating_info))
            {
                foreach ($room_rating_info as $user_rate)
                {
                    if (!empty($user_rate[ $p_id ]))
                    {
                        foreach ($user_rate[ $p_id ] as $user_rate_index => $user_rate_item)
                        {
                            $room_total_rate[ $user_rate_index ]['value'] += $user_rate_item;
                            $room_total_rate[ $user_rate_index ]['count']++;
                        }
                    }
                }
            }
            $room_info['rate'] = $room_total_rate;

            return $room_info;
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Get the translated post ID
         * ------------------------------------------------------------------------------------------
         */
        public static function translated_post_id($p_id, $p_type = 'post')
        {
            if (function_exists('icl_object_id'))
            {
                $p_id = icl_object_id(intval($p_id), $p_type, true);
            }

            return $p_id;
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Check the Price
         * ------------------------------------------------------------------------------------------
         */
        public function check_dates($check_in, $base_price, $extra_price, $seasonal_price, $weekend)
        {
            $return_value['weekend'] = $weekend;
            $return_value['base']    = $base_price;
            $return_value['extra']   = $extra_price;

            // Check Room Seasonal Price
            if (!empty($seasonal_price))
            {
                foreach ($seasonal_price as $season_item)
                {
                    $season_start = new DateTime($season_item['start']);
                    $season_end   = new DateTime($season_item['end']);

                    if ($check_in >= $season_start && $check_in <= $season_end)
                    {
                        $return_value['base']['adult'] = $season_item['adult'];
                        $return_value['base']['child'] = $season_item['child'];
                        $return_value['extra']         = $season_item['extra'];
                    }
                }
            }

            // Check General Seasonal Price
            if (!empty($this->mana_options['seasonal_price']))
            {
                foreach ($this->mana_options['seasonal_price'] as $g_season_item)
                {
                    $g_season_start = new DateTime($g_season_item['from']);
                    $g_season_end   = new DateTime($g_season_item['to']);

                    if ($check_in >= $g_season_start && $check_in <= $g_season_end)
                    {
                        $return_value['base']['adult']['weekday'] = self::general_seasonal_price_generator($g_season_item['type'], $g_season_item['percent'], $base_price['adult']['weekday']);
                        $return_value['base']['adult']['weekend'] = self::general_seasonal_price_generator($g_season_item['type'], $g_season_item['percent'], $base_price['adult']['weekend']);
                        $return_value['base']['child']['weekday'] = self::general_seasonal_price_generator($g_season_item['type'], $g_season_item['percent'], $base_price['child']['weekday']);
                        $return_value['base']['child']['weekend'] = self::general_seasonal_price_generator($g_season_item['type'], $g_season_item['percent'], $base_price['child']['weekend']);

                        $return_value['extra']['adult']['weekday'] = self::general_seasonal_price_generator($g_season_item['type'], $g_season_item['percent'], $extra_price['adult']['weekday']);
                        $return_value['extra']['adult']['weekend'] = self::general_seasonal_price_generator($g_season_item['type'], $g_season_item['percent'], $extra_price['adult']['weekend']);
                        $return_value['extra']['child']['weekday'] = self::general_seasonal_price_generator($g_season_item['type'], $g_season_item['percent'], $extra_price['child']['weekday']);
                        $return_value['extra']['child']['weekend'] = self::general_seasonal_price_generator($g_season_item['type'], $g_season_item['percent'], $extra_price['child']['weekend']);
                    }
                }
            }
            $return_value['start_price'] = $return_value['base']['adult']['weekday'];

            return $return_value;
        }

        public static function general_seasonal_price_generator($type, $percent, $price)
        {
            $percent_val = ($price * $percent) / 100;
            switch ($type) {
                case '2':
                    return $price - $percent_val;
                    break;

                default:
                    return $price + $percent_val;
                    break;
            }
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Get All the Service Information
         * ------------------------------------------------------------------------------------------
         */
        public function service_info($s_id, $duration = null, $room_count = null, $total_guest = null)
        {
            $service_info                = array();
            $service_info['id']          = $s_id;
            $service_info['title']       = get_the_title($s_id);
            $service_info['url']         = get_permalink($s_id);
            $service_info['description'] = get_extended(get_post_field('post_content', $s_id));

            $service_info['has_image'] = has_post_thumbnail($s_id);
            if ($service_info['has_image'])
            {
                $service_info['img']['thumbnail'] = get_the_post_thumbnail($s_id, 'thumbnail', 'class=post-img');
                $service_info['img']['medium']    = get_the_post_thumbnail($s_id, 'medium', 'class=post-img');
                $service_info['img']['large']     = get_the_post_thumbnail($s_id, 'large', 'class=post-img');
                $service_info['img']['full']      = get_the_post_thumbnail($s_id, 'full', 'class=post-img');
            }
            $staff_meta_box_prefix      = 'mana_booking_service_';
            $service_info['shortcode']  = get_post_meta($s_id, $staff_meta_box_prefix . 'shortcode', true);
            $service_info['in_booking'] = get_post_meta($s_id, $staff_meta_box_prefix . 'booking', true);
            if (!empty($service_info['in_booking']))
            {
                $currency_info_obj          = new Mana_booking_currency();
                $currency_info              = $currency_info_obj->get_current_currency();
                $service_info['price_type'] = get_post_meta($s_id, $staff_meta_box_prefix . 'price_type', true);
                if ($service_info['price_type'] !== '1')
                {
                    $service_info['price']         = get_post_meta($s_id, $staff_meta_box_prefix . 'price', true);
                    $service_info['price']['unit'] = $currency_info['symbol'];
                    $total_price                   = $currency_info_obj->price_exchanger($service_info['price']['price']);

                    switch ($service_info['price']['guest'])
                    {
                        case ('1'):
                            $price_guest = esc_html__('Guest', 'mana-booking');
                            $total_price = ($total_guest * $total_price);
                            break;
                        case ('2'):
                            $price_guest = esc_html__('Booking', 'mana-booking');
                            break;
                        case ('3'):
                            $price_guest = esc_html__('Room', 'mana-booking');
                            $total_price = ($room_count * $total_price);
                            break;
                    }
                    if ($service_info['price']['night'] === '2')
                    {
                        $price_night = esc_html__('Booking', 'mana-booking');
                    }
                    else
                    {
                        $price_night = esc_html__('Night', 'mana-booking');
                        $total_price = ($duration * $total_price);
                    }
                    $service_info['price']['generated']       = '<span>' . $currency_info_obj->price_full_generator($service_info['price']['price']) . '</span> / ' . $price_guest . ' / ' . $price_night;
                    $service_info['total_price']['value']     = $total_price;
                    $formatted_total_price                    = $currency_info_obj->price_formatter($total_price);
                    $service_info['total_price']['generated'] = $currency_info_obj->price_symbol_generator($formatted_total_price);
                }
                else
                {
                    $service_info['price']['generated']       = esc_html__('Free', 'mana-booking');
                    $service_info['total_price']['value']     = 0;
                    $service_info['total_price']['generated'] = esc_html__('Free', 'mana-booking');
                }
                $service_info['mandatory'] = get_post_meta($s_id, $staff_meta_box_prefix . 'mandatory', true);
            }

            return $service_info;
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Get All the Block Date Information
         * ------------------------------------------------------------------------------------------
         */
        public function block_date_info($p_id)
        {
            $block_date_info          = array();
            $block_date_info['id']    = $p_id;
            $block_date_info['title'] = get_the_title($p_id);
            $block_date_info['url']   = get_permalink($p_id);

            $block_date_meta_box_prefix           = 'mana_booking_block_dates_';
            $block_date_info['from']['full_date'] = get_post_meta($p_id, $block_date_meta_box_prefix . 'from', true);
            $block_date_info['from']['timestamp'] = strtotime($block_date_info['from']['full_date']);
            $block_date_info['to']['full_date']   = get_post_meta($p_id, $block_date_meta_box_prefix . 'to', true);
            $block_date_info['to']['timestamp']   = strtotime($block_date_info['to']['full_date']);
            $block_date_info['duration']          = ($block_date_info['to']['timestamp'] - $block_date_info['from']['timestamp']) / (24 * 60 * 60);
            $block_rooms                          = get_post_meta($p_id, $block_date_meta_box_prefix . 'blocked_rooms', true);

            if (!empty($block_rooms))
            {
                $room_info['title'] = get_the_title($p_id);
                foreach ($block_rooms as $index => $room)
                {
                    $block_date_info['blocked_rooms'][ $index ]['id']    = $room;
                    $block_date_info['blocked_rooms'][ $index ]['title'] = get_the_title($room);
                }
            }

            return $block_date_info;
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Get All Booking Information
         * ------------------------------------------------------------------------------------------
         */
        public function booking_info($b_id)
        {
            global $wpdb;
            $table_name       = $wpdb->prefix . 'mana_booking';
            $booking_raw_info = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $table_name . ' WHERE id = %d', $b_id));
            $booking_info     = array();
            if (!empty($booking_raw_info))
            {
                $booking_info['f_name']         = $booking_raw_info->f_name;
                $booking_info['l_name']         = $booking_raw_info->l_name;
                $booking_info['phone']          = $booking_raw_info->phone;
                $booking_info['email']          = $booking_raw_info->email;
                $booking_info['address']        = $booking_raw_info->address;
                $booking_info['requirements']   = $booking_raw_info->requirements;
                $booking_info['check_in']       = $booking_raw_info->check_in;
                $booking_info['check_out']      = $booking_raw_info->check_out;
                $booking_info['booking_date']   = $booking_raw_info->booking_date;
                $booking_info['total_price']    = $booking_raw_info->total_price;
                $booking_info['vat']            = $booking_raw_info->vat;
                $booking_info['duration']       = $booking_raw_info->duration;
                $booking_info['weekends']       = $booking_raw_info->weekends;
                $booking_info['vat']            = $booking_raw_info->vat;
                $booking_info['status']         = $booking_raw_info->status;
                $booking_info['confirmed']      = $booking_raw_info->confirmed;
                $booking_info['invoice_id']     = $booking_raw_info->invoice_id;
                $booking_info['booking_info']   = unserialize($booking_raw_info->booking_info);
                $booking_info['payment_status'] = $booking_raw_info->payment_status;
                $booking_info['currency']       = unserialize($booking_raw_info->booking_currency);
            }

            return $booking_info;
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Get All Invoice Information
         * ------------------------------------------------------------------------------------------
         */
        public function invoice_info($in_id)
        {
            global $wpdb;
            $table_name       = $wpdb->prefix . 'mana_invoice';
            $invoice_raw_info = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $table_name . ' WHERE id = %d', $in_id));
            $invoice_info     = array();
            $currency_obj     = new Mana_booking_currency();

            $invoice_info['id']                 = $in_id;
            $invoice_info['booking_id']         = $invoice_raw_info->booking_id;
            $invoice_info['booking_date']       = $invoice_raw_info->booking_date;
            $invoice_info['currency']           = $invoice_raw_info->booking_currency;
            $invoice_info['price']['value']     = $invoice_raw_info->price;
            $invoice_info['price']['generated'] = $currency_obj->price_generator_no_exchange($invoice_raw_info->price);
            $invoice_info['status']['value']    = $invoice_raw_info->status;
            switch ($invoice_raw_info->status)
            {
                case '0':
                    $invoice_info['status']['generated'] = esc_html__('Unpaid', 'mana-booking');
                    break;
                case '1':
                    $invoice_info['status']['generated'] = esc_html__('Paid', 'mana-booking');
                    break;
                case '2':
                    $invoice_info['status']['generated'] = esc_html__('Canceled', 'mana-booking');
                    break;
            }
            $invoice_info['user'] = $invoice_raw_info->user_id;

            return $invoice_info;
        }

        /**
        * ------------------------------------------------------------------------------------------
        *  Get All Coupon Information
        * ------------------------------------------------------------------------------------------
        */
        public static function coupon_info($id)
        {
            $coupon_info['id']                 = $id;
            $coupon_info['title']              = get_the_title($id);
            $coupon_info['description']        = get_post_meta($id, 'mana_booking_coupon_desc', true);
            $coupon_info['type']               = get_post_meta($id, 'mana_booking_coupon_type', true);
            $coupon_info['percent']            = get_post_meta($id, 'mana_booking_coupon_percent', true);
            $coupon_info['price']              = get_post_meta($id, 'mana_booking_coupon_price', true);
            $coupon_info['amount']             = get_post_meta($id, 'mana_booking_coupon_amount', true);
            $used_coupon                       = get_post_meta($id, 'mana_booking_coupon_used', true);
            $coupon_info['used_coupon']        = intval($used_coupon);
            $coupon_info['expire_date']        = get_post_meta($id, 'mana_booking_coupon_expire', true);

            return $coupon_info;
        }
    }

    $mana_booking_get_info_obj = new Mana_booking_get_info();
