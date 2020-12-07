<?php

/**
 * Mana Short code Class
 */
class Mana_booking_plg_shortcode
{
    public $mana_booking_option;

    public function __construct()
    {
        $this->mana_booking_option = get_option('mana-booking-setting');
        add_action('init', array($this, 'init'));
    }

    /**
     * Add all the Mana Booking Shortcodes to the theme
     */
    public function init()
    {
        add_shortcode('mana-booking-room-listing', array($this, 'mana_booking_room_listing'));
        add_shortcode('mana-booking-room-search-form', array($this, 'mana_booking_room_search_form'));
        add_shortcode('mana-booking-other-rooms', array($this, 'mana_booking_other_rooms'));
        add_shortcode('mana-booking-room-rating', array($this, 'mana_booking_room_rating'));
        add_shortcode('mana-booking-currency-switcher', array($this, 'mana_booking_currency_switcher'));
        add_shortcode('mana-booking-booking-overview', array($this, 'mana_booking_booking_overview'));

        add_filter('widget_text', 'do_shortcode');
    }

    /**
     * ------------------------------------------------------------------------------------------
     *  Generate Room Listings
     * ------------------------------------------------------------------------------------------
     */
    public function mana_booking_room_listing($attr)
    {
        $mana_booking_room_listing_attr = shortcode_atts(array(
            'title'       => '',
            'subtitle'    => '',
            'description' => '',
            // layout attribute can be "list" or "gird"
            'layout'      => 'gird',
            'count'       => -1,
            'title_type'  => '1',
        ), $attr);

        $args = array(
            'post_type'      => 'rooms',
            'post_status'    => 'publish',
            'order'          => 'DESC',
            'orderby'        => 'date',
            'posts_per_page' => $mana_booking_room_listing_attr['count'],
        );

        $mana_booking_room_query = new WP_Query($args);

        $get_info_obj = new mana_booking_get_info();

        $mana_booking_room_listing_code = '
				<section id="rooms-section" ' . ($mana_booking_room_listing_attr['layout'] == 'list' ? wp_kses_post('class="row-view"') : '') . '>
					<div class="inner-container container">';

        if (!empty($mana_booking_room_listing_attr['title']) || !empty($mana_booking_room_listing_attr['subtitle'])) {
            if ($mana_booking_room_listing_attr['title_type'] === '1') {
                $mana_booking_room_listing_code .= '
						<div class="mana-title-t-2">
							<div class="title"><span>' . esc_html($mana_booking_room_listing_attr['title']) . '</span></div>
							<div class="sub-title">' . esc_html($mana_booking_room_listing_attr['subtitle']) . '</div>
						</div>';
            } else {
                $mana_booking_room_listing_code .= '
						<div class="mana-title">
							<div class="inner-box">
								<div class="title">' . esc_html($mana_booking_room_listing_attr['title']) . '</div>
								<div class="sub-title">' . esc_html($mana_booking_room_listing_attr['subtitle']) . '</div>
							</div>
						</div>';
            }
        }

        if (!empty($mana_booking_room_listing_attr['description'])) {
            $mana_booking_room_listing_code .= '<div class="desc">' . esc_html($mana_booking_room_listing_attr['description']) . '</div>';
        }

        if ($mana_booking_room_query->have_posts()) {
            $mana_booking_room_listing_code .= '<div class="room-container clearfix">';

            $room_i = 0;

            while ($mana_booking_room_query->have_posts()) {
                $mana_booking_room_query->the_post();
                $post_id   = get_the_ID();
                $room_info = $get_info_obj->room_info($post_id);

                if ($mana_booking_room_listing_attr['layout'] == 'list') {
                    $mana_booking_room_listing_code .= '
							<div class="room-box row animated-box" data-animation="fadeInUp">
                                <div class="col-md-4 room-img">';
                    if (empty($this->mana_booking_option['listing_image_slider'])) {
                        $mana_booking_room_listing_code .= '<a href="' . esc_url($room_info['url']) . '" class="cover-link"></a>';
                    }
                    $mana_booking_room_listing_code .= '<div class="img-container">';
                    if ($room_info['gallery']['count'] > 0) {
                        $img_gallery_i = 0;
                        foreach ($room_info['gallery']['img'] as $img_item) {
                            if (empty($this->mana_booking_option['listing_image_slider']) && $img_gallery_i > 0) {
                                continue;
                            }
                            $mana_booking_room_listing_code .= '<div class="img-box" data-bg-img="' . esc_url($img_item['url']) . '"></div>';
                            $img_gallery_i++;
                        }
                    } else {
                        $mana_booking_room_listing_code .= '<div class="img-box no-img"></div>';
                    }

                    $mana_booking_room_listing_code .= '
									</div>
								</div>
								<div class="r-sec col-md-8">
									<div class="col-md-6 m-sec">
										<div class="title-box">
											<div class="title">' . esc_html($room_info['title']) . '</div>
											<div class="price">
												<div class="title">' . esc_html__('Starting from :', 'mana-booking') . '</div>
												<div class="value">' . esc_html($room_info['start_price']) . '</div>
											</div>
										</div>
										<div class="amenities">
											<ul class="list-inline clearfix">';

                    if (!empty($room_info['room_view'])) {
                        $mana_booking_room_listing_code .= '
												<li class="col-md-6">
													<div class="title">' . esc_html__('View :', 'mana-booking') . '</div>
													<div class="value">' . esc_html($room_info['room_view']) . '</div>
												</li>';
                    }

                    if (!empty($room_info['room_size']['qnt'])) {
                        $mana_booking_room_listing_code .= '
												<li class="col-md-6">
													<div class="title">' . esc_html__('Room Size :', 'mana-booking') . '</div>
													<div class="value">' . esc_html($room_info['room_size']['qnt']) . ' ' . wp_kses_post($room_info['room_size']['unit']) . '</div>
												</li>';
                    }

                    if (!empty($room_info['max_people'])) {
                        $mana_booking_room_listing_code .= '
												<li class="col-md-6">
													<div class="title">' . esc_html__('Max People :', 'mana-booking') . '</div>
													<div class="value">' . esc_html($room_info['max_people']) . '</div>
												</li>';
                    }

                    if (!empty($room_info['service'])) {
                        foreach ($room_info['service'] as $service) {
                            $mana_booking_room_listing_code .= '
												<li class="col-md-6">
													<div class="title">' . esc_html($service['title']) . ' :</div>
													<div class="value">' . esc_html($service['value']) . '</div>
												</li>';
                        }
                    }

                    if (!empty($room_info['facilities'])) {
                        $facility_str = '';

                        foreach ($room_info['facilities'] as $facility) {
                            $facility_str .= $facility['title'] . ', ';
                        }

                        $facility_str = trim($facility_str, ', ');

                        $mana_booking_room_listing_code .= '
												<li class="col-md-12">
													<div class="title">' . esc_html__('Facilities :', 'mana-booking') . '</div>
													<div class="value">' . esc_html($facility_str) . '</div>
												</li>';
                    }

                    $mana_booking_room_listing_code .= '
											</ul>
										</div>
										<a href="' . esc_url($room_info['url']) . '" class="more-info">' . esc_html__('More Info', 'mana-booking') . '</a>
									</div>
									<div class="col-md-6 desc">' . esc_html($room_info['description']['short']) . '</div>
								</div>
							</div>';
                } else {
                    $mana_booking_room_listing_code .= '
							<div class="room-box col-xs-6 col-md-4 animated-box" data-animation="fadeInUp" data-delay="' . esc_attr(($room_i % 3) * 300) . '">
								<div class="inner-box">
                                    <div class="room-img">';

                    if (empty($this->mana_booking_option['listing_image_slider'])) {
                        $mana_booking_room_listing_code .= '<a href="' . esc_url($room_info['url']) . '" class="cover-link"></a>';
                    }

                    $mana_booking_room_listing_code .= '<div class="img-container">';
                    if ($room_info['gallery']['count'] > 0) {
                        $img_gallery_i = 0;
                        foreach ($room_info['gallery']['img'] as $img_item) {
                            if (empty($this->mana_booking_option['listing_image_slider']) && $img_gallery_i > 0) {
                                continue;
                            }
                            $mana_booking_room_listing_code .= '<div class="img-box" data-bg-img="' . esc_url($img_item['url']) . '"></div>';
                            $img_gallery_i++;
                        }
                    } else {
                        $mana_booking_room_listing_code .= '<div class="img-box no-img"></div>';
                    }
                    $mana_booking_room_listing_code .= '
										</div>
									</div>
									<div class="caption">
										<div class="title"><a href="' . esc_url($room_info['url']) . '">' . esc_html($room_info['title']) . '</a></div>
										<div class="price">
											<div class="title">' . esc_html__('Starting from :', 'mana-booking') . '</div>
											<div class="value">' . esc_html($room_info['start_price']) . '</div>
										</div>
										<div class="desc">
											<div class="inner-box">' . esc_html($room_info['description']['short']) . '</div>
										</div>
									</div>

								</div>
							</div>';
                }

                $room_i++;
            }

            $mana_booking_room_listing_code .= '</div>';
        } else {
            $mana_booking_room_listing_code .= esc_html__('There is not any rooms here.', 'mana-booking');
        }

        $mana_booking_room_listing_code .= '
					</div>
				</section>';
        wp_reset_postdata();

        return balancetags($mana_booking_room_listing_code);
    }

    /**
     * ------------------------------------------------------------------------------------------
     *  Generate Room Search Form
     * ------------------------------------------------------------------------------------------
     */
    public function mana_booking_room_search_form($attr)
    {
        $mana_booking_room_search_form_attr = shortcode_atts(array(
            'title'    => '',
            'subtitle' => '',
            // layout attribute can be "horizontal" or "vertical"
            'layout'   => 'horizontal',
            'class'    => '',
        ), $attr);

        $send_info_method = 'post';

        if (!empty($this->mana_booking_option['external_booking'])) {
            if (!empty($this->mana_booking_option['external_booking_method'])) {
                if ($this->mana_booking_option['external_booking_method'] === '2') {
                    $send_info_method = 'get';
                } else {
                    $send_info_method = 'post';
                }
            }
        }

        $mana_booking_room_search_form_code = '';

        if ($mana_booking_room_search_form_attr['layout'] === 'horizontal') {
            $mana_booking_room_search_form_code = '
					<section class="main-availability-form ' . (!empty($mana_booking_room_search_form_attr['class']) ? esc_attr($mana_booking_room_search_form_attr['class']) : '') . '">
						<div class="inner-container container">';

            if (!empty($mana_booking_room_search_form_attr['title']) || !empty($mana_booking_room_search_form_attr['subtitle'])) {
                $mana_booking_room_search_form_code .= '
							<div class="l-sec col-md-4">
								<div class="mana-title">
									<div class="inner-box">
										<div class="title">' . esc_html($mana_booking_room_search_form_attr['title']) . '</div>
										<div class="sub-title">' . esc_html($mana_booking_room_search_form_attr['subtitle']) . '</div>
									</div>
								</div>
							</div>';
            }

            $mana_booking_room_search_form_code .= '
							<div class="r-sec ' . ((!empty($mana_booking_room_search_form_attr['title']) || !empty($mana_booking_room_search_form_attr['subtitle'])) ? esc_attr('col-md-8') : '') . '">
								<form class="booking-form clearfix" action="' . esc_url(Mana_booking_get_info::booking_page_url()) . '" method="' . esc_attr($send_info_method) . '">
									<div class="col-md-10">
										<div class="row">
											<div class="input-daterange col-md-8">
												<div class="booking-fields col-md-6">
													<input placeholder="' . esc_html__('Check in', 'mana-booking') . '" class="datepicker-fields check-in" type="text" name="start"/>
													<i class="fa fa-calendar"></i>
												</div>
												<div class="booking-fields col-md-6">
													<input placeholder="' . esc_html__('Check out', 'mana-booking') . '" class="datepicker-fields check-out" type="text" name="end"/>
													<i class="fa fa-calendar"></i>
												</div>
											</div>
											<div class="col-md-4">
												<select name="room-count" class="room-count">
													<option value=""></option>
													<option value="1" selected="selected">1 ' . esc_html__('Room', 'mana-booking') . '</option>
													<option value="2">2 ' . esc_html__('Rooms', 'mana-booking') . '</option>
													<option value="3">3 ' . esc_html__('Rooms', 'mana-booking') . '</option>
													<option value="4">4 ' . esc_html__('Rooms', 'mana-booking') . '</option>
													<option value="5">5 ' . esc_html__('Rooms', 'mana-booking') . '</option>
												</select>
											</div>
										</div>
										<div class="room-field-container">
											<div class="row">
												<div class="booking-fields col-md-4">
													<div class="room-title">' . esc_html__('Room 1', 'mana-booking') . ' : </div>
												</div>
												<div class="booking-fields col-md-4">
													<select name="room[0][adult]">
														<option value="1">1 ' . esc_html__('Adult', 'mana-booking') . '</option>
														<option value="2">2 ' . esc_html__('Adults', 'mana-booking') . '</option>
														<option value="3">3 ' . esc_html__('Adults', 'mana-booking') . '</option>
														<option value="4">4 ' . esc_html__('Adults', 'mana-booking') . '</option>
														<option value="5">5 ' . esc_html__('Adults', 'mana-booking') . '</option>
														<option value="6">6 ' . esc_html__('Adults', 'mana-booking') . '</option>
														<option value="7">7 ' . esc_html__('Adults', 'mana-booking') . '</option>
														<option value="8">8 ' . esc_html__('Adults', 'mana-booking') . '</option>
														<option value="9">9 ' . esc_html__('Adults', 'mana-booking') . '</option>
														<option value="10">10 ' . esc_html__('Adults', 'mana-booking') . '</option>
													</select>
												</div>
												<div class="booking-fields col-md-4">
													<select name="room[0][child]">
														<option value="0">' . esc_html__('No Child', 'mana-booking') . '</option>
														<option value="1">1 ' . esc_html__('Children', 'mana-booking') . '</option>
														<option value="2">2 ' . esc_html__('Children', 'mana-booking') . '</option>
														<option value="3">3 ' . esc_html__('Children', 'mana-booking') . '</option>
														<option value="4">4 ' . esc_html__('Children', 'mana-booking') . '</option>
														<option value="5">5 ' . esc_html__('Children', 'mana-booking') . '</option>
														<option value="6">6 ' . esc_html__('Children', 'mana-booking') . '</option>
														<option value="7">7 ' . esc_html__('Children', 'mana-booking') . '</option>
														<option value="8">8 ' . esc_html__('Children', 'mana-booking') . '</option>
														<option value="9">9 ' . esc_html__('Children', 'mana-booking') . '</option>
														<option value="10">10 ' . esc_html__('Children', 'mana-booking') . '</option>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-2">
										<button type="submit" class="mana-btn btn-type-1">
											<span class="inner-box">' . esc_html__('Book Now', 'mana-booking') . '</span>
										</button>
									</div>
								</form>
								<div class="row room-field-tmpl">
									<div class="booking-fields col-md-4">
										<div class="room-title">' . esc_html__('Room', 'mana-booking') . ' {{id_}} : </div>
									</div>
									<div class="booking-fields col-md-4">
										<select name="room[{{id}}][adult]" class="disable-select2">
											<option value="1">1 ' . esc_html__('Adult', 'mana-booking') . '</option>
											<option value="2">2 ' . esc_html__('Adults', 'mana-booking') . '</option>
											<option value="3">3 ' . esc_html__('Adults', 'mana-booking') . '</option>
											<option value="4">4 ' . esc_html__('Adults', 'mana-booking') . '</option>
											<option value="5">5 ' . esc_html__('Adults', 'mana-booking') . '</option>
											<option value="6">6 ' . esc_html__('Adults', 'mana-booking') . '</option>
											<option value="7">7 ' . esc_html__('Adults', 'mana-booking') . '</option>
											<option value="8">8 ' . esc_html__('Adults', 'mana-booking') . '</option>
											<option value="9">9 ' . esc_html__('Adults', 'mana-booking') . '</option>
											<option value="10">10 ' . esc_html__('Adults', 'mana-booking') . '</option>
										</select>
									</div>
									<div class="booking-fields col-md-4">
										<select name="room[{{id}}][child]" class="disable-select2">>
											<option value="0">' . esc_html__('No Child', 'mana-booking') . '</option>
											<option value="1">1 ' . esc_html__('Children', 'mana-booking') . '</option>
											<option value="2">2 ' . esc_html__('Children', 'mana-booking') . '</option>
											<option value="3">3 ' . esc_html__('Children', 'mana-booking') . '</option>
											<option value="4">4 ' . esc_html__('Children', 'mana-booking') . '</option>
											<option value="5">5 ' . esc_html__('Children', 'mana-booking') . '</option>
											<option value="6">6 ' . esc_html__('Children', 'mana-booking') . '</option>
											<option value="7">7 ' . esc_html__('Children', 'mana-booking') . '</option>
											<option value="8">8 ' . esc_html__('Children', 'mana-booking') . '</option>
											<option value="9">9 ' . esc_html__('Children', 'mana-booking') . '</option>
											<option value="10">10 ' . esc_html__('Children', 'mana-booking') . '</option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</section>';
        } elseif ($mana_booking_room_search_form_attr['layout'] === 'vertical') {
            $mana_booking_room_search_form_code = '
					<div class="room-booking-form-container">
						<form class="room-booking-form ' . (!empty($mana_booking_room_search_form_attr['class']) ? esc_attr($mana_booking_room_search_form_attr['class']) : '') . '" action="' . esc_url(Mana_booking_get_info::booking_page_url()) . '" method="' . esc_attr($send_info_method) . '">
							<div class="input-daterange">
								<div class="field-row">
									<input placeholder="' . esc_html__('Check in', 'mana-booking') . '" class="datepicker-fields check-in" type="text" name="start"/>
									<i class="fa fa-calendar"></i>
								</div>
								<div class="field-row">
									<input placeholder="' . esc_html__('Check out', 'mana-booking') . '" class="datepicker-fields check-out" type="text" name="end"/>
									<i class="fa fa-calendar"></i>
								</div>
							</div>
							<div class="field-row">
								<select name="room-count" class="room-count">
									<option value=""></option>
									<option value="1" selected="selected">1 ' . esc_html__('Room', 'mana-booking') . '</option>
									<option value="2">2 ' . esc_html__('Rooms', 'mana-booking') . '</option>
									<option value="3">3 ' . esc_html__('Rooms', 'mana-booking') . '</option>
									<option value="4">4 ' . esc_html__('Rooms', 'mana-booking') . '</option>
									<option value="5">5 ' . esc_html__('Rooms', 'mana-booking') . '</option>
								</select>
							</div>
							<div class="room-field-container">
								<div class="field-row">
									<div class="title">' . esc_html__('Room 1 :', 'mana-booking') . '</div>
									<select name="room[0][adult]">
										<option value="1">1 ' . esc_html__('Adult', 'mana-booking') . '</option>
										<option value="2">2 ' . esc_html__('Adults', 'mana-booking') . '</option>
										<option value="3">3 ' . esc_html__('Adults', 'mana-booking') . '</option>
										<option value="4">4 ' . esc_html__('Adults', 'mana-booking') . '</option>
										<option value="5">5 ' . esc_html__('Adults', 'mana-booking') . '</option>
										<option value="6">6 ' . esc_html__('Adults', 'mana-booking') . '</option>
										<option value="7">7 ' . esc_html__('Adults', 'mana-booking') . '</option>
										<option value="8">8 ' . esc_html__('Adults', 'mana-booking') . '</option>
										<option value="9">9 ' . esc_html__('Adults', 'mana-booking') . '</option>
										<option value="10">10 ' . esc_html__('Adults', 'mana-booking') . '</option>
									</select>
									<select name="room[0][child]">
										<option value="0">' . esc_html__('No Child', 'mana-booking') . '</option>
										<option value="1">1 ' . esc_html__('Children', 'mana-booking') . '</option>
										<option value="2">2 ' . esc_html__('Children', 'mana-booking') . '</option>
										<option value="3">3 ' . esc_html__('Children', 'mana-booking') . '</option>
										<option value="4">4 ' . esc_html__('Children', 'mana-booking') . '</option>
										<option value="5">5 ' . esc_html__('Children', 'mana-booking') . '</option>
										<option value="6">6 ' . esc_html__('Children', 'mana-booking') . '</option>
										<option value="7">7 ' . esc_html__('Children', 'mana-booking') . '</option>
										<option value="8">8 ' . esc_html__('Children', 'mana-booking') . '</option>
										<option value="9">9 ' . esc_html__('Children', 'mana-booking') . '</option>
										<option value="10">10 ' . esc_html__('Children', 'mana-booking') . '</option>
									</select>
								</div>
							</div>
							<div class="field-row">
								<input type="submit" value="' . esc_html__('Book Now', 'mana-booking') . '">
							</div>
						</form>
						<div class="field-row room-field-tmpl">
							<div class="title">' . esc_html__('Room', 'mana-booking') . ' {{id_}} :</div>
							<select name="room[{{id}}][adult]" class="disable-select2">
								<option value="1">' . esc_html__('1 Adult', 'mana-booking') . '</option>
								<option value="2">' . esc_html__('2 Adults', 'mana-booking') . '</option>
								<option value="3">' . esc_html__('3 Adults', 'mana-booking') . '</option>
								<option value="4">' . esc_html__('4 Adults', 'mana-booking') . '</option>
								<option value="5">' . esc_html__('5 Adults', 'mana-booking') . '</option>
							</select>
							<select name="room[{{id}}][child]" class="disable-select2">
								<option value="0">' . esc_html__('No Child', 'mana-booking') . '</option>
								<option value="1">' . esc_html__('1 Children', 'mana-booking') . '</option>
								<option value="2">' . esc_html__('2 Children', 'mana-booking') . '</option>
								<option value="3">' . esc_html__('3 Children', 'mana-booking') . '</option>
								<option value="4">' . esc_html__('4 Children', 'mana-booking') . '</option>
								<option value="5">' . esc_html__('5 Children', 'mana-booking') . '</option>
							</select>
						</div>
					</div>';
        }

        return balancetags($mana_booking_room_search_form_code);
    }

    /**
     * ------------------------------------------------------------------------------------------
     *  Generate Room Listings
     * ------------------------------------------------------------------------------------------
     */
    public function mana_booking_other_rooms($attr)
    {
        $mana_booking_room_listing_attr = shortcode_atts(array(
            'title'    => '',
            'subtitle' => '',
            'post_id'  => '',
            'order'    => '',
            'count'    => -1,
        ), $attr);

        if (!empty($mana_booking_room_listing_attr['order'])) {
            switch ($mana_booking_room_listing_attr['order']) {
                case '2':
                    $room_order = 'rand';
                    break;
                default:
                    $room_order = 'date';
                    break;
            }
        }

        $args = array(
            'post_type'      => 'rooms',
            'post_status'    => 'publish',
            'order'          => 'DESC',
            'orderby'        => $room_order,
            'posts_per_page' => $mana_booking_room_listing_attr['count'],
            'post__not_in'   => array((!empty($mana_booking_room_listing_attr['post_id']) ? $mana_booking_room_listing_attr['post_id'] : '')),
        );

        $mana_booking_room_query = new WP_Query($args);

        $get_info_obj = new mana_booking_get_info();

        $mana_booking_room_listing_code = '
				<section id="rooms-section">
					<div class="inner-container container">';

        if (!empty($mana_booking_room_listing_attr['title']) || !empty($mana_booking_room_listing_attr['subtitle'])) {
            $mana_booking_room_listing_code .= '
						<div class="mana-title">
							<div class="inner-box">
								<div class="title">' . esc_html($mana_booking_room_listing_attr['title']) . '</div>
								<div class="sub-title">' . esc_html($mana_booking_room_listing_attr['subtitle']) . '</div>
							</div>
						</div>';
        }

        if ($mana_booking_room_query->have_posts()) {
            $mana_booking_room_listing_code .= '<div class="room-container clearfix">';

            $room_i = 0;

            while ($mana_booking_room_query->have_posts()) {
                $mana_booking_room_query->the_post();
                $post_id   = get_the_ID();
                $room_info = $get_info_obj->room_info($post_id);

                $mana_booking_room_listing_code .= '
						<div class="room-box col-xs-6 col-md-4 animated-box" data-animation="fadeInUp" data-delay="' . esc_attr(($room_i % 3) * 300) . '">
							<div class="inner-box">
                                <div class="room-img">';
                if (empty($this->mana_booking_option['listing_image_slider'])) {
                    $mana_booking_room_listing_code .= '<a href="' . esc_url($room_info['url']) . '" class="cover-link"></a>';
                }
                $mana_booking_room_listing_code .= '<div class="img-container">';
                if ($room_info['gallery']['count'] > 0) {
                    $img_gallery_i = 0;
                    foreach ($room_info['gallery']['img'] as $img_item) {
                        if (empty($this->mana_booking_option['listing_image_slider']) && $img_gallery_i > 0) {
                            continue;
                        }
                        $mana_booking_room_listing_code .= '<div class="img-box" data-bg-img="' . esc_url($img_item['url']) . '"></div>';
                        $img_gallery_i++;
                    }
                } else {
                    $mana_booking_room_listing_code .= '<div class="img-box no-img"></div>';
                }

                $mana_booking_room_listing_code .= '
									</div>
								</div>
								<div class="caption">
									<div class="title"><a href="' . esc_url($room_info['url']) . '">' . esc_html($room_info['title']) . '</a></div>
									<div class="price">
										<div class="title">' . esc_html__('Starting from :', 'mana-booking') . '</div>
										<div class="value">' . esc_html($room_info['start_price']) . '</div>
									</div>
									<div class="desc">
										<div class="inner-box">' . esc_html($room_info['description']['short']) . '</div>
									</div>
								</div>

							</div>
						</div>';
                $room_i++;
            }

            $mana_booking_room_listing_code .= '</div>';
        } else {
            $mana_booking_room_listing_code .= esc_html__('There is not any rooms here.', 'mana-booking');
        }

        $mana_booking_room_listing_code .= '
					</div>
				</section>';
        wp_reset_postdata();

        return balancetags($mana_booking_room_listing_code);
    }

    /**
     * ------------------------------------------------------------------------------------------
     *  Generate Room Rating Section
     * ------------------------------------------------------------------------------------------
     */
    public function mana_booking_room_rating($attr)
    {
        $mana_booking_room_rating_attr = shortcode_atts(array(
            'title'    => '',
            'subtitle' => '',
            'room_id'  => '',
        ), $attr);
        $get_inf_obj                    = new Mana_booking_get_info();
        $room_id                        = !empty($mana_booking_room_rating_attr['room_id']) ? Mana_booking_get_info::original_post_id($mana_booking_room_rating_attr['room_id']) : '';
        $room_info                      = $get_inf_obj->room_info($room_id);

        $plugin_options = get_option('mana-booking-setting');

        if (empty($this->mana_booking_option['rating_status'])) {
            $mana_booking_room_rating_code = esc_html__('Rating system is not enabled. Please check your settings.', 'mana-booking');
        } else {
            $mana_booking_room_rating_code = '<div class="room-rating">';

            if (!empty($mana_booking_room_rating_attr['title'])) {
                $mana_booking_room_rating_code .= '
						<div class="mana-title-t-2">
							<div class="title"><span>' . esc_html($mana_booking_room_rating_attr['title']) . '</span></div>';

                if (!empty($mana_booking_room_rating_attr['subtitle'])) {
                    $mana_booking_room_rating_code .= '<div class="sub-title">' . esc_html($mana_booking_room_rating_attr['subtitle']) . '</div>';
                }

                $mana_booking_room_rating_code .= '</div>';
            }

            if (is_user_logged_in()) {
                wp_enqueue_script('barrating-js', MANA_BOOKING_JS_PATH . 'jquery.barrating.min.js', array('jquery'), MANA_BOOKING_VERSION, true);
                $rating_post_meta_txt = 'mana_booking_room_rating';
                $rate_meta            = get_post_meta($room_id, $rating_post_meta_txt, true);
                $current_user_info    = wp_get_current_user();
                $current_user_id      = $current_user_info->ID;

                $mana_booking_room_rating_code .= '<div class="rate-box-container">';

                foreach ($plugin_options['rating_item'] as $rate_index => $rating_item) {
                    $mana_booking_room_rating_code .= '
						<div class="rate-box">
							<div class="title">' . esc_html($rating_item) . '</div>
							<div class="progress">
							<select class="rate-items disable-select2" data-security="' . wp_create_nonce('mana-rating-item') . '" name="rate_' . esc_attr($rate_index) . '" data-room-id="' . esc_attr($room_id) . '">';

                    for ($i = 0; $i < 11; $i++) {
                        $i_counter                      = $i * 10;
                        $mana_booking_room_rating_code .= '<option value="' . esc_attr($i_counter) . '"';

                        if (!empty($rate_meta[$current_user_id][$room_id][$rate_index])) {
                            $mana_booking_room_rating_code .= selected($i_counter, $rate_meta[$current_user_id][$room_id][$rate_index], false);
                        }

                        $mana_booking_room_rating_code .= '>' . esc_html($i_counter . '%') . '</option>';
                    }

                    $mana_booking_room_rating_code .= '</select>
								</div>
							<div class="message-box"></div>
						</div>';
                }

                $mana_booking_room_rating_code .= '</div>';
            } else {
                $mana_booking_room_rating_code .= '
						<div class="rate-box-container">';

                if (!empty($room_info['rate'])) {
                    foreach ($plugin_options['rating_item'] as $rate_index => $rate_title) {
                        $current_rate_val = 0;

                        if (!empty($room_info['rate'][$rate_index]) && !empty($room_info['rate'][$rate_index]['count'])) {
                            $current_rate_val = ($room_info['rate'][$rate_index]['value'] / $room_info['rate'][$rate_index]['count']);
                        }

                        $mana_booking_room_rating_code .= '
							<div class="rate-box">
								<div class="title">' . esc_html($rate_title) . '</div>
								<div class="progress">
									<div class="progress-bar" role="progressbar" aria-valuenow="' . esc_attr($current_rate_val) . '" aria-valuemin="0"
										 aria-valuemax="100" style="width: ' . esc_attr($current_rate_val) . '%"><span>' . esc_html($current_rate_val) . '%</span></div>
								</div>
							</div>';
                    }
                }

                $mana_booking_room_rating_code .= '
						</div>
					</div>';
            }
        }

        return balancetags($mana_booking_room_rating_code);
    }

    /**
     * ------------------------------------------------------------------------------------------
     *  Generate Currency Switcher
     * ------------------------------------------------------------------------------------------
     */
    public function mana_booking_currency_switcher($attr)
    {
        $mana_booking_currency_switcher_attr = shortcode_atts(array(
            'class' => '',
        ), $attr);

        $currency_currency = !empty($_COOKIE['currencyTitle']) && is_string($_COOKIE['currencyTitle']) ? $_COOKIE['currencyTitle'] : '';

        $random_id = 'currency-switcher-select-' . random_int(10000, 100000);

        $options_code = '';

        if (is_array($this->mana_booking_option['currency'])) {
            foreach ($this->mana_booking_option['currency'] as $index => $currency) {
                if ($index == $this->mana_booking_option['default_currency']) {
                    $first_options = '<option value="' . esc_attr($currency['title']) . '" ' . selected($currency['title'], $currency_currency, false) . '>' . esc_attr($currency['title']) . '</option>';
                } else {
                    $options_code .= '<option value="' . esc_attr($currency['title']) . '" ' . selected($currency['title'], $currency_currency, false) . '>' . esc_attr($currency['title']) . '</option>';
                }
            }
        }

        $mana_booking_currency_switcher = '<select id="' . esc_attr($random_id) . '" ' . (!empty($mana_booking_currency_switcher_attr['class']) ? wp_kses_post('class="' . $mana_booking_currency_switcher_attr['class'] . '"') : '') . '>' . balanceTags($first_options . $options_code) . '</select>';

        return balancetags($mana_booking_currency_switcher);
    }

    /**
     * ------------------------------------------------------------------------------------------
     *  Generate Booking Overview Section
     * ------------------------------------------------------------------------------------------
     */
    public function mana_booking_booking_overview($attr)
    {
        /**
         * Mana Booking Overview Attribute
         */
        $mana_booking_overview_attr = shortcode_atts(array(
            'room_id' => '',
            'class'   => '',
        ), $attr);

        $rand_digit = rand(1, 10000);
        $room_id    = !empty($mana_booking_overview_attr['room_id']) ? Mana_booking_get_info::original_post_id($mana_booking_overview_attr['room_id']) : '';

        $mana_booking_overview_content = '
				<div id="booking-overview-section">
					<div class="inner-container ' . (!empty($mana_booking_overview_attr['class']) ? esc_attr($mana_booking_overview_attr['class']) : '') . '">
						<div id="overview-calendar-' . esc_attr($rand_digit) . '" ' . (!empty($$room_id) ? ' class="single-room-calendar"' : '') . '>';

        if (!empty($room_id)) {
            $mana_booking_overview_content .= '
									<div class="day-status-guide">
										<div class="status-box">
											<div class="box not-available"></div>
											<div class="title">' . esc_html__('Not Available', 'mana-booking') . '</div>
										</div>
										<div class="status-box">
											<div class="box available"></div>
											<div class="title">' . esc_html__('Available', 'mana-booking') . '</div>
										</div>
										<div class="status-box">
											<div class="box today">1</div>
											<div class="title">' . esc_html__('Today', 'mana-booking') . '</div>
										</div>
									</div>
								';
        }

        $mana_booking_overview_content .= '
						</div>
					</div>
				</div>
			';

        wp_enqueue_script('moment-js', MANA_BOOKING_ASSETS_LIBS . '/js/moment.min.js', array('jquery'), get_bloginfo('version'), true);
        wp_enqueue_script('fullcalendar-js', MANA_BOOKING_ASSETS_LIBS . '/js/fullcalendar.min.js', array(
            'jquery',
            'moment-js',
        ), get_bloginfo('version'), true);

        $web_current_locale = 'en';

        if (get_locale() !== 'en_US') {
            if (file_exists(MANA_BOOKING_PATH . 'assets/js/locales.php')) {
                require MANA_BOOKING_PATH . 'assets/js/locales.php';
            }

            $web_current_locale = isset($plugin_locales[get_locale()]) ? $plugin_locales[get_locale()] : 'en';
            wp_enqueue_script('fullcalendar-locales-js', MANA_BOOKING_ASSETS_LIBS . '/js/locale/' . $web_current_locale . '.js', array('jquery'), MANA_BOOKING_VERSION, true);
        }

        $full_calendar_js_codes = '
				jQuery(document).ready(function () {
					"use strict";
					jQuery("#overview-calendar-' . esc_attr($rand_digit) . '").fullCalendar({
						locale:        \'' . esc_js($web_current_locale) . '\',
						eventMouseover: function( event, jsEvent, view ) {
							var eventURL   = event.url,
								eventTitle = event.title;

							jQuery(".fc-event").each(function (index, el) {
								var eventHref = jQuery(this).attr("href"),
									eventText = jQuery(this).find(".fc-title").text();

								if (eventHref == eventURL && eventText == eventTitle) {
									jQuery(this).addClass("hover-event");
								}
							});
						},
						eventMouseout: function( event, jsEvent, view ) {
							jQuery(".fc-event").removeClass("hover-event");
						},
						viewRender: function(currentView){
							var minDate = moment();
							if (minDate >= currentView.start && minDate <= currentView.end) {
								jQuery(".fc-prev-button").prop("disabled", true);
								jQuery(".fc-prev-button").addClass("fc-state-disabled");
							}
							else {
								jQuery(".fc-prev-button").removeClass("fc-state-disabled");
								jQuery(".fc-prev-button").prop("disabled", false);
							}
						},
						eventSources:   [
							{
								events: function (start, end, timezone, callback) {
									var startDateMonth  = start._d.getMonth() + 1,
										endDateMonth    = end._d.getMonth() + 1,
										startDate       = (start._d.getFullYear()) + "-" + (startDateMonth < 10 ? "0"+startDateMonth : startDateMonth) + "-" + (start._d.getDate()),
										endDate         = (end._d.getFullYear()) + "-" + (endDateMonth < 10 ? "0"+endDateMonth : endDateMonth) + "-" + (end._d.getDate());
									jQuery.ajax({
										url:      "' . esc_url(admin_url()) . 'admin-ajax.php",
										dataType: "json",
										method:   "post",
										data:     {
											action:     "' . (!empty($room_id) ? esc_html('mana_booking_room_overview') : esc_html('mana_booking_booking_overview')) . '",
											start:      startDate,
											end:        endDate,
											' . (empty($room_id) ? 'frontEnd:   true' : '') . '
											' . (!empty($room_id) ? 'roomID: ' . esc_js($room_id) : '') . '
										}
									}).done(function (dataBooking) {
										var events = [];
										jQuery(dataBooking).each(function () {
											events.push({
												title:     jQuery(this).attr("title"),
												start:     jQuery(this).attr("start"),
												end:       jQuery(this).attr("end"),
												className: jQuery(this).attr("className"),
												rendering: jQuery(this).attr("rendering")
											});
										});
										callback(events);
									});
								}
							}
						]
					});
				});
					';

        if (get_locale() !== 'en_US') {
            wp_add_inline_script('fullcalendar-locales-js', $full_calendar_js_codes);
        } else {
            wp_add_inline_script('fullcalendar-js', $full_calendar_js_codes);
        }

        return balancetags($mana_booking_overview_content);
    }

    public function mana_booking_get_image_id($image_url)
    {
        global $wpdb;
        $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url));

        return $attachment[0];
    }
}

$mana_shortcode_obj = new Mana_booking_plg_shortcode;
