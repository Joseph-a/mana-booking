<?php

    class Mana_booking_currency
    {
        public $mana_booking_option;

        public function __construct()
        {
            $this->mana_booking_option = get_option('mana-booking-setting');
            add_action('wp_ajax_nopriv_mana_booking_update_currency', array($this, 'update_currency'));
            add_action('wp_ajax_mana_booking_update_currency', array($this, 'update_currency'));

            add_action('wp_ajax_nopriv_mana_booking_currency_cookie', array($this, 'set_currency_cookie_ajax'));
            add_action('wp_ajax_mana_booking_currency_cookie', array($this, 'set_currency_cookie_ajax'));

            add_action('init', array($this, 'set_currency_cookie'));
        }

        public function update_currency()
        {
            $currency_count   = count($this->mana_booking_option['currency']);
            $default_currency = $this->mana_booking_option['default_currency'];
            if ($currency_count > 1)
            {
                $default_currency_info = $this->mana_booking_option['currency'][ $default_currency ];
                foreach ($this->mana_booking_option['currency'] as $index => $currency_item)
                {
                    if ($default_currency_info['title'] === $currency_item['title'])
                    {
                        $currency_array[ $index ] = 1;
                    }
                    else
                    {
                        $currency_index           = $default_currency_info['title'] . '_' . $currency_item['title'];
                        $get                      = file_get_contents('http://free.currencyconverterapi.com/api/v5/convert?q=' . $currency_index . '&compact=y');
                        $return_val               = json_decode($get);
                        $converted_currency       = $return_val->$currency_index->val;
                        $currency_array[ $index ] = !empty($converted_currency) ? $converted_currency : 0;
                    }
                }

                echo json_encode($currency_array);
                die();
            }
        }

        public function set_currency_cookie()
        {
            if (!empty($this->mana_booking_option['currency']))
            {
                $current_currency  = !empty($_COOKIE['currencyTitle']) ? $_COOKIE['currencyTitle'] : '';
                $currency_is_valid = false;

                if (!empty($this->mana_booking_option['currency']))
                {
                    foreach ($this->mana_booking_option['currency'] as $currency_item)
                    {
                        if (in_array($current_currency, $currency_item))
                        {
                            $currency_is_valid = true;
                        }
                    }
                }

                if ($currency_is_valid == false)
                {
                    foreach ($this->mana_booking_option['currency'] as $index => $currency_item)
                    {
                        if ($index == $this->mana_booking_option['default_currency'])
                        {
                            setcookie('currencyTitle', $currency_item['title'], time() + (86400 * 30), '/');
                            setcookie('currencySymbol', $currency_item['symbol'], time() + (86400 * 30), '/');
                            setcookie('currencyPosition', (!empty($currency_item['position']) ? $currency_item['position'] : 0), time() + (86400 * 30), '/');
                            setcookie('currencyRate', 1, time() + (86400 * 30), '/');
                        }
                    }
                }
            }
        }

        public function set_currency_cookie_ajax()
        {
            $currency_obj     = new Mana_booking_currency();
            $currency         = is_string($_POST['currency']) ? $_POST['currency'] : '';
            $currentCurreny   = $currency_obj->get_current_currency();
            $result           = array();
            $result['status'] = false;

            if (!empty($currency))
            {
                foreach ($this->mana_booking_option['currency'] as $currency_item)
                {
                    if ($currency_item['title'] == $currency)
                    {
                        $currency_symbol   = $currency_item['symbol'];
                        $currency_position = empty($currency_item['position']) ? 0 : $currency_item['position'];
                        $currency_rate     = empty($currency_item['rate']) ? 0 : $currency_item['rate'];

                        setcookie('currencyTitle', $currency, time() + (86400 * 30), '/');
                        setcookie('currencySymbol', $currency_symbol, time() + (86400 * 30), '/');
                        setcookie('currencyPosition', $currency_position, time() + (86400 * 30), '/');
                        setcookie('currencyRate', $currency_rate, time() + (86400 * 30), '/');

                        $result['status'] = true;
                    }
                }
            }
            echo json_encode($result);
            die();
        }

        public function get_current_currency()
        {
            $i = 0;
            if (is_array($this->mana_booking_option['currency']))
            {
                foreach ($this->mana_booking_option['currency'] as $index => $currency_item)
                {
                    if (empty($this->mana_booking_option['default_currency']))
                    {
                        if ($i === 0)
                        {
                            $default_currency_item = array(
                                'title'    => $currency_item['title'],
                                'symbol'   => $currency_item['symbol'],
                                'position' => !empty($currency_item['position']) ? $currency_item['position'] : 0,
                                'rate'     => 1,
                            );
                        }
                    }
                    else
                    {
                        if ($index == $this->mana_booking_option['default_currency'])
                        {
                            $default_currency_item = array(
                                'title'    => $currency_item['title'],
                                'symbol'   => $currency_item['symbol'],
                                'position' => !empty($currency_item['position']) ? $currency_item['position'] : 0,
                                'rate'     => 1,
                            );
                        }
                    }
                    $currency_title_array[]  = $currency_item['title'];
                    $currency_symbol_array[] = $currency_item['symbol'];

                    $i++;
                }

                if (!empty($_COOKIE['currencyTitle']) && !empty($_COOKIE['currencySymbol']) && !empty($_COOKIE['currencyRate']) && (!empty($_COOKIE['currencyPosition']) || $_COOKIE['currencyPosition'] === '0'))
                {
                    if (in_array($_COOKIE['currencyTitle'], $currency_title_array) && in_array($_COOKIE['currencySymbol'], $currency_symbol_array))
                    {
                        $currency['title']    = $_COOKIE['currencyTitle'];
                        $currency['symbol']   = $_COOKIE['currencySymbol'];
                        $currency['position'] = $_COOKIE['currencyPosition'];
                        $currency['rate']     = $_COOKIE['currencyRate'];
                    }
                    else
                    {
                        $currency = $default_currency_item;
                    }
                }
                else
                {
                    $currency = $default_currency_item;
                }
            }
            else
            {
                $currency = null;
            }

            return $currency;
        }

        public function price_full_generator($price, $currency_info = null)
        {
            $exchanged_price = $this->price_exchanger($price, $currency_info);
            $formatted_price = $this->price_formatter($exchanged_price);
            $new_price       = $this->price_symbol_generator($formatted_price, $currency_info);

            return $new_price;
        }

        public function get_currency_info($title)
        {
            $currency_info = $this->mana_booking_option['currency'];
            foreach ($currency_info as $item_info)
            {
                if ($item_info['title'] === $title)
                {
                    return $item_info;
                    break;
                }
            }
        }

        public function price_exchanger($price, $currency_info = null)
        {
            $new_price = 0;
            if ($currency_info === null)
            {
                $current_currency = $this->get_current_currency();
            }
            else
            {
                $current_currency = $currency_info;
            }
            if (!empty($price) && !empty($current_currency['rate']))
            {
                $new_price = $price * $current_currency['rate'];
            }

            return $new_price;
        }

        public function price_formatter($price)
        {
            $currency_separator_val         = !empty($this->mana_booking_option['currency_separator']) ? intval($this->mana_booking_option['currency_separator']) : 1;
            $currency_decimal               = !empty($this->mana_booking_option['currency_decimal']) ? intval($this->mana_booking_option['currency_decimal']) : 0;
            $currency_decimal_separator_val = !empty($this->mana_booking_option['currency_decimal_separator']) ? intval($this->mana_booking_option['currency_decimal_separator']) : 1;

            switch ($currency_separator_val)
            {
                case 1:
                    $currency_separator = ',';
                    break;
                case 2:
                    $currency_separator = '.';
                    break;
                case 3:
                    $currency_separator = ' ';
                    break;
            }
            switch ($currency_decimal_separator_val)
            {
                case 1:
                    $currency_decimal_separator = '.';
                    break;
                case 2:
                    $currency_decimal_separator = ',';
                    break;
            }

            $price     = is_object($price) ? $price->payable_raw : $price;
            $new_price = number_format($price, $currency_decimal, $currency_decimal_separator, $currency_separator);

            return $new_price;
        }

        public function price_symbol_generator($price, $currency_info = null)
        {
            if ($currency_info === null)
            {
                $current_currency = $this->get_current_currency();
            }
            else
            {
                $current_currency = $currency_info;
            }
            if (!empty($current_currency['position']) && $current_currency['position'] == '1')
            {
                $new_price = $current_currency['symbol'] . $price;
            }
            else
            {
                $new_price = $price . $current_currency['symbol'];
            }

            return $new_price;
        }

        public function price_generator_no_exchange($price, $currency_info = null)
        {
            $formatted_price = $this->price_formatter($price);
            $new_price       = $this->price_symbol_generator($formatted_price, $currency_info);

            return $new_price;
        }

        public static function convert_to_default($price, $currency)
        {
            $converted_price = $price;
            $price_value     = floatval($currency['rate']);
            if ($price_value >= 1)
            {
                $converted_price = $price * $price_value;
            }
            else
            {
                $converted_price = $price / $price_value;
            }


            return $converted_price;
        }
    }

    $mana_booking_currency_obj = new Mana_booking_currency();
