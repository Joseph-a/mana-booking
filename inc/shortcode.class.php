<?php

    /**
     * Ravis Short code Class
     */
    class Ravis_booking_plg_shortcode
    {
        public $ravis_booking_option;

        public function __construct()
        {
            $this->ravis_booking_option = get_option('ravis-booking-setting');
            add_action('init', array($this, 'init'));
        }

        /**
         * Add all the Ravis Booking Shortcodes to the theme
         */
        public function init()
        {
            add_shortcode('ravis-booking-main-slider', array($this, 'ravis_booking_main_slider'));
            add_shortcode('ravis-booking-text-section', array($this, 'ravis_booking_text_section'));
            add_shortcode('ravis-booking-gallery', array($this, 'ravis_booking_gallery'));
            add_shortcode('ravis-booking-gallery-slideshow', array($this, 'ravis_booking_gallery_slideshow'));
            add_shortcode('ravis-booking-special-rooms', array($this, 'ravis_booking_special_rooms'));
            add_shortcode('ravis-booking-testimonials', array($this, 'ravis_booking_testimonials'));
            add_shortcode('ravis-booking-hotel-section', array($this, 'ravis_booking_hotel_section'));
            add_shortcode('ravis-booking-package', array($this, 'ravis_booking_package'));
            add_shortcode('ravis-booking-video-tour', array($this, 'ravis_booking_video_tour'));
            add_shortcode('ravis-booking-timeline', array($this, 'ravis_booking_timeline'));
            add_shortcode('ravis-booking-services', array($this, 'ravis_booking_services'));
            add_shortcode('ravis-booking-clients', array($this, 'ravis_booking_clients'));
            add_shortcode('ravis-booking-staff', array($this, 'ravis_booking_staff'));
            add_shortcode('ravis-booking-promo', array($this, 'ravis_booking_promo'));
            add_shortcode('ravis-booking-social-icons', array($this, 'ravis_booking_social_icon'));
            add_shortcode('ravis-booking-dishes', array($this, 'ravis_booking_dishes'));
            add_shortcode('ravis-booking-menu', array($this, 'ravis_booking_menu'));
            add_shortcode('ravis-booking-testimonial-form', array($this, 'ravis_booking_testimonial_form'));
            add_shortcode('ravis-booking-upcoming-events', array($this, 'ravis_booking_upcoming_events'));
            add_shortcode('ravis-booking-past-events', array($this, 'ravis_booking_past_events'));
            add_shortcode('ravis-booking-other-events', array($this, 'ravis_booking_other_events'));
            add_shortcode('ravis-booking-event-booking', array($this, 'ravis_booking_event_booking'));
            add_shortcode('ravis-booking-room-listing', array($this, 'ravis_booking_room_listing'));
            add_shortcode('ravis-booking-room-search-form', array($this, 'ravis_booking_room_search_form'));
            add_shortcode('ravis-booking-other-rooms', array($this, 'ravis_booking_other_rooms'));
            add_shortcode('ravis-booking-room-rating', array($this, 'ravis_booking_room_rating'));
            add_shortcode('ravis-booking-currency-switcher', array($this, 'ravis_booking_currency_switcher'));
            add_shortcode('ravis-booking-contact', array($this, 'ravis_booking_contact'));
            add_shortcode('ravis-booking-booking-overview', array($this, 'ravis_booking_booking_overview'));

            add_filter('widget_text', 'do_shortcode');
        }

        /**
         * ------------------------------------------------------------------------------------------
         * Generate the main image slider
         * ------------------------------------------------------------------------------------------
         */
        public function ravis_booking_main_slider()
        {
            if (!empty($this->ravis_booking_option['main_slider']))
            {
                $main_slider_img_array = explode(',', $this->ravis_booking_option['main_slider']);

                $ravis_booking_main_slider_code = '<section class="colosseum-main-slider">';

                foreach ($main_slider_img_array as $slider_item_id)
                {
                    $slider_item_id = Ravis_booking_get_info::translated_post_id(intval($slider_item_id), 'attachment');
                    $slide_img      = wp_get_attachment_image_src(intval($slider_item_id), 'full');
                    $slide_title    = get_the_title($slider_item_id);
                    $slide_subtitle = get_the_excerpt($slider_item_id);

                    $ravis_booking_main_slider_code .= '
						<div class="items">
							<div class="img-container" data-bg-img="' . esc_url($slide_img[0]) . '"></div>';

                    if (!empty($slide_title) || !empty($slide_subtitle))
                    {
                        $ravis_booking_main_slider_code .= '
							<div class="slide-caption">
								<div class="inner-container clearfix">
									<div class="up-sec">' . esc_html($slide_subtitle) . '</div>
									<div class="down-sec">' . esc_html($slide_title) . '</div>
								</div>
							</div>';
                    }

                    $ravis_booking_main_slider_code .= '</div>';
                }

                $ravis_booking_main_slider_code .= '</section>';
            }
            else
            {
                $ravis_booking_main_slider_code = esc_html__('There is not any slides here.', 'ravis-booking');
            }

            /**
             * Restore original Post Data
             */
            wp_reset_postdata();

            return balancetags($ravis_booking_main_slider_code);
        }

        /**
         * ------------------------------------------------------------------------------------------
         * Generate the Text Section
         * ------------------------------------------------------------------------------------------
         */
        public function ravis_booking_text_section($attr)
        {
            $ravis_booking_text_section_attr = shortcode_atts(array(
                'title'      => '',
                'subtitle'   => '',
                'text'       => '',
                'img_url'    => '',
                'person_img' => '',
                'cite'       => '',
                'btn_txt'    => '',
                'btn_url'    => '#',
            ), $attr);
            $ravis_booking_text_section_code = '
				<section id="welcome-section" class="' . (empty($ravis_booking_text_section_attr['img_url']) ? 'simple' : '') . ' ' . (!empty($ravis_booking_text_section_attr['person_img']) ? 'has-user' : '') . '">
					<div class="inner-container container">
						<div class="l-sec ' . (!empty($ravis_booking_text_section_attr['img_url']) ? 'col-md-7' : '') . '">
							<div class="ravis-title-t-1">
								<div class="title"><span>' . esc_html($ravis_booking_text_section_attr['title']) . '</span></div>
								<div class="sub-title">' . esc_html($ravis_booking_text_section_attr['subtitle']) . '</div>
							</div>
							<div class="content">' . wp_kses_post($ravis_booking_text_section_attr['text']) . '</div>';

            if (!empty($ravis_booking_text_section_attr['cite']))
            {
                $ravis_booking_text_section_code .= '<cite>' . esc_html($ravis_booking_text_section_attr['cite']) . '</cite>';
            }

            if (!empty($ravis_booking_text_section_attr['btn_txt']))
            {
                $ravis_booking_text_section_code .= '<a href="' . esc_url($ravis_booking_text_section_attr['btn_url']) . '" class="ravis-btn btn-type-2">' . esc_html($ravis_booking_text_section_attr['btn_txt']) . '</a>';
            }

            $ravis_booking_text_section_code .= '</div>';

            if (!empty($ravis_booking_text_section_attr['img_url']))
            {
                $ravis_booking_text_section_code .= '<div class="r-sec col-md-5">';

                if (!empty($ravis_booking_text_section_attr['person_img']))
                {
                    $ravis_booking_text_section_code .= '<div class="user-img-box"><div class="inner-box">';
                }

                $ravis_booking_text_section_code .= '<img src="' . esc_url($ravis_booking_text_section_attr['img_url']) . '" alt="' . esc_html($ravis_booking_text_section_attr['title']) . '">';

                if (!empty($ravis_booking_text_section_attr['person_img']))
                {
                    $ravis_booking_text_section_code .= '</div>';
                }

                $ravis_booking_text_section_code .= '</div>';
            }

            $ravis_booking_text_section_code .= '
					</div>
				</section>';

            return balancetags($ravis_booking_text_section_code);
        }

        /**
         * ------------------------------------------------------------------------------------------
         * Generate the main Gallery
         * ------------------------------------------------------------------------------------------
         */
        public function ravis_booking_gallery($attr)
        {
            $ravis_booking_gallery_attr = shortcode_atts(array(
                'title'     => '',
                'subtitle'  => '',
                // type attribute can be "grid", "list"
                'type'      => 'grid',
                'img_count' => -1,
                'more_url'  => '',
            ), $attr);
            $ravis_booking_gallery_code = '';

            if (!empty($this->ravis_booking_option['main_gallery']))
            {
                $gallery_array = explode(',', $this->ravis_booking_option['main_gallery']);
                $gallery_list  = $gallery_sort = '';
                $gallery_i     = 0;
                $sort_array    = array();

                foreach ($gallery_array as $img_id)
                {
                    if ($gallery_i >= $ravis_booking_gallery_attr['img_count'] && $ravis_booking_gallery_attr['img_count'] != -1)
                    {
                        continue;
                    }

                    $img_id        = Ravis_booking_get_info::translated_post_id(intval($img_id), 'attachment');
                    $img_info      = get_post($img_id);
                    $img_cat       = get_post_meta($img_id, '_wp_attachment_image_alt', true);
                    $img_cat_class = str_replace(' ', '-', $img_cat);

                    if (!in_array(strtolower($img_cat), $sort_array))
                    {
                        $sort_array[] = strtolower($img_cat);
                        $gallery_sort .= '<li><a href="#" data-filter=".' . esc_attr(strtolower($img_cat_class)) . '">' . esc_html($img_cat) . '</a></li>';
                    }

                    switch ($ravis_booking_gallery_attr['type'])
                    {
                        case ('list'):
                            $gallery_list .= '
								<li class="item row ' . esc_attr(strtolower($img_cat_class)) . '">
									<div class="img-container col-md-5" data-bg-img="' . esc_url($img_info->guid) . '">
										<a href="' . esc_url($img_info->guid) . '" class="more-details" data-title="' . esc_attr($img_info->post_title) . '">' . esc_html__('Enlarge', 'ravis-booking') . '</a>
									</div>
									<div class="desc col-md-7">
										<div class="ravis-title-t-1">
											<div class="title"><span>' . esc_html($img_info->post_title) . '</span></div>
											<div class="sub-title">' . esc_html($img_info->post_excerpt) . '</div>
										</div>
										<div class="content">' . esc_html($img_info->post_content) . '</div>
									</div>
								</li>';
                            break;
                        default:
                            $gallery_list .= '
								<li class="item col-xs-6 col-md-4 ' . esc_attr(strtolower($img_cat_class)) . '">
									<figure>
										<img src="' . esc_url($img_info->guid) . '" alt="' . esc_attr($img_info->post_title) . '"/>
										<a href="' . esc_url($img_info->guid) . '" class="more-details" data-title="' . esc_attr($img_info->post_title) . '">' . esc_html__('Enlarge', 'ravis-booking') . '</a>
										<figcaption>
											<h4>' . esc_html($img_info->post_title) . '</h4>
										</figcaption>
									</figure>
								</li>';
                            break;
                    }

                    $gallery_i++;
                }

                $ravis_booking_gallery_code .= '
				<section id="gallery">
					<div class="inner-container container">';

                if (!empty($ravis_booking_gallery_attr['title']) || !empty($ravis_booking_gallery_attr['subtitle']))
                {
                    $ravis_booking_gallery_code .= '
						<div class="ravis-title">
							<div class="inner-box">
								<div class="title">' . esc_html($ravis_booking_gallery_attr['title']) . '</div>
								<div class="sub-title">' . esc_html($ravis_booking_gallery_attr['subtitle']) . '</div>
							</div>
						</div>';
                }

                $ravis_booking_gallery_code .= '
						<div class="gallery-container ' . ((empty($ravis_booking_gallery_attr['title']) && empty($ravis_booking_gallery_attr['subtitle'])) ? esc_attr('no-title') : '') . ' ' . ($ravis_booking_gallery_attr['type'] === 'list' ? esc_attr('row') : '') . '">
							<div class="sort-section">
								<div class="sort-section-container">
									<div class="sort-handle">' . esc_html__('Filters', 'ravis-booking') . '</div>
									<ul class="list-inline">
										<li><a href="#" data-filter="*" class="active">' . esc_html__('All', 'ravis-booking') . '</a></li>
										' . balanceTags($gallery_sort) . '
									</ul>
								</div>
							</div>
							<ul class="image-main-box clearfix">
								' . balanceTags($gallery_list) . '
							</ul>';

                if (!empty($ravis_booking_gallery_attr['more_url']))
                {
                    $ravis_booking_gallery_code .= '<a href="' . esc_url($ravis_booking_gallery_attr['more_url']) . '" class="gallery-more-btn ravis-btn btn-type-2">' . esc_html__('More ...', 'ravis-booking') . '</a>';
                }

                $ravis_booking_gallery_code .= '
						</div>
					</div>
				</section>';
            }

            return balancetags($ravis_booking_gallery_code);
        }

        /**
         * ------------------------------------------------------------------------------------------
         * Generate the main Gallery
         * ------------------------------------------------------------------------------------------
         */
        public function ravis_booking_gallery_slideshow($attr)
        {
            $ravis_booking_gallery_slideshow_attr = shortcode_atts(array(
                'pre_text'  => '',
                'post_text' => '',
                'img_count' => -1,
            ), $attr);
            $ravis_booking_gallery_slideshow_code = '';

            if (!empty($this->ravis_booking_option['main_gallery']))
            {
                $gallery_array  = explode(',', $this->ravis_booking_option['main_gallery']);
                $gallery_slides = $gallery_thumb = '';
                $gallery_i      = 0;

                foreach ($gallery_array as $img_id)
                {
                    if ($gallery_i >= $ravis_booking_gallery_slideshow_attr['img_count'] && $ravis_booking_gallery_slideshow_attr['img_count'] != -1)
                    {
                        continue;
                    }

                    $img_id   = Ravis_booking_get_info::translated_post_id(intval($img_id), 'attachment');
                    $img_info = get_post($img_id);

                    $gallery_slides .= '
						<div class="items">
							<img src="' . esc_url($img_info->guid) . '" alt="' . esc_html($img_info->post_title) . '">
							<div class="slide-caption">
								<div class="title">' . esc_html($img_info->post_title) . '</div>
							</div>
						</div>';

                    $gallery_thumb .= '
						<div class="items">
							<img src="' . esc_url($img_info->guid) . '" alt="' . esc_html($img_info->post_title) . '">
						</div>';
                    $gallery_i++;
                }

                $ravis_booking_gallery_slideshow_code .= '
					<div id="slide-show-section" class="container">
						<div class="desc pre">' . $ravis_booking_gallery_slideshow_attr['pre_text'] . '</div>
						<div id="slide-show">
							<div id="main-image-slider">' . balanceTags($gallery_slides) . '</div>
							<div id="thumbnail-slider">' . balanceTags($gallery_thumb) . '</div>
						</div>
						<div class="desc">' . $ravis_booking_gallery_slideshow_attr['post_text'] . '</div>
					</div>';
            }

            return balancetags($ravis_booking_gallery_slideshow_code);
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Generate Special Rooms
         * ------------------------------------------------------------------------------------------
         */
        public function ravis_booking_special_rooms($attr)
        {
            $ravis_booking_special_rooms_attr = shortcode_atts(array(
                'room_count' => 4,
            ), $attr);

            $room_count = $ravis_booking_special_rooms_attr['room_count'];

            $args              = array(
                'post_type'      => 'rooms',
                'meta_key'       => 'ravis_booking_room_setting_special_room',
                'meta_value'     => 'on',
                'posts_per_page' => $room_count,
            );
            $special_room_list = new WP_Query($args);

            $ravis_booking_special_rooms_code = '<section id="luxury-rooms" class="clearfix">';

            if ($special_room_list->have_posts())
            {
                $room_info_init = new Ravis_booking_get_info();
                $room_i         = 0;

                switch ($room_count){
                    case('1'):
                        $box_class = 'col-sm-12 col-md-12';
                    break;
                    case('2'):
                        $box_class = 'col-sm-6 col-md-6';
                    break;
                    case('3'):
                        $box_class = 'col-sm-6 col-md-4';
                    break;
                    default:
                        $box_class = intval($room_count) % 3 === 0 ? 'col-sm-6 col-md-4' : 'col-sm-6 col-md-3';
                    break;
                }

                while ($special_room_list->have_posts())
                {
                    $special_room_list->the_post();
                    $room_id   = get_the_id();
                    $room_info = $room_info_init->room_info($room_id);

                    $ravis_booking_special_rooms_code .= '
						<div class="room-boxes ' . esc_attr($box_class) . '">
							<a href="' . esc_url($room_info['url']) . '" class="inner-container" data-bg="' . (!empty($room_info['gallery']['img'][0]) && !empty($room_info['gallery']['img'][0]['url']) ? esc_url($room_info['gallery']['img'][0]['url']) : '#') . '">
								<span class="ravis-title">
									<span class="inner-box">
										<span class="title">' . esc_html($room_info['title']) . '</span>
										<span class="sub-title">' . esc_html($room_info['subtitle']) . '</span>
									</span>
								</span>
							</a>
						</div>';
                    $room_i++;
                }
            }
            else
            {
                $ravis_booking_special_rooms_code .= esc_html__('There is not any special rooms here.', 'ravis-booking');
            }

            wp_reset_query();

            $ravis_booking_special_rooms_code .= '</section>';

            return balancetags($ravis_booking_special_rooms_code);
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Generate Testimonials slider
         * ------------------------------------------------------------------------------------------
         */
        public function ravis_booking_testimonials($attr)
        {
            $ravis_booking_testimonials_attr = shortcode_atts(array(
                'bg_img' => '',
                'count'  => 3,
            ), $attr);

            $args                             = array(
                'post_type'      => 'testimonials',
                'post_status'    => 'publish',
                'order'          => 'DESC',
                'orderby'        => 'date',
                'posts_per_page' => $ravis_booking_testimonials_attr['count'],
            );
            $ravis_booking_testimonials_query = new WP_Query($args);

            $get_info_obj = new ravis_booking_get_info();

            if ($ravis_booking_testimonials_query->have_posts())
            {
                $ravis_booking_testimonials_code = '
				<section id="testimonials-section" data-bg-img="' . (!empty($ravis_booking_testimonials_attr['bg_img']) ? esc_url($ravis_booking_testimonials_attr['bg_img']) : '#') . '">
					<div class="inner-container container">
						<div class="owl-carousel owl-theme">';

                $testimonials_i = 0;

                while ($ravis_booking_testimonials_query->have_posts())
                {
                    $ravis_booking_testimonials_query->the_post();
                    $post_id           = get_the_ID();
                    $testimonials_info = $get_info_obj->testimonials_info($post_id);

                    $ravis_booking_testimonials_code .= '
						<div class="item">
							<div class="guest">
								<div class="ravis-title">
									<div class="inner-box">
										<div class="title">' . esc_html($testimonials_info['guest_name']) . '</div>
										<div class="sub-title">' . esc_html($testimonials_info['guest_job']) . '</div>
									</div>
								</div>
							</div>
							<div class="text">' . esc_html($testimonials_info['description']['main']) . '</div>
						</div>';
                    $testimonials_i++;
                }

                $ravis_booking_testimonials_code .= '
						</div>
					</div>
				</section>';
            }
            else
            {
                $ravis_booking_testimonials_code = esc_html__('There is not any Testimonials here.', 'ravis-booking');
            }

            wp_reset_query();

            return balancetags($ravis_booking_testimonials_code);
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Generate Hotel Sections
         * ------------------------------------------------------------------------------------------
         */
        public function ravis_booking_hotel_section($attr)
        {
            $ravis_booking_hotel_section_attr = shortcode_atts(array(
                'count' => 3,
            ), $attr);

            $args                              = array(
                'post_type'      => 'hotel_section',
                'post_status'    => 'publish',
                'order'          => 'DESC',
                'orderby'        => 'date',
                'posts_per_page' => $ravis_booking_hotel_section_attr['count'],
            );
            $ravis_booking_hotel_section_query = new WP_Query($args);

            $get_info_obj = new ravis_booking_get_info();

            if ($ravis_booking_hotel_section_query->have_posts())
            {
                $ravis_booking_hotel_section_code = '<section id="hotel-sections">';
                $hotel_section_i                  = 0;

                while ($ravis_booking_hotel_section_query->have_posts())
                {
                    $ravis_booking_hotel_section_query->the_post();
                    $post_id            = get_the_ID();
                    $hotel_section_info = $get_info_obj->hotel_section_info($post_id);

                    $ravis_booking_hotel_section_code .= '<div class="section-row clearfix">';

                    if ($hotel_section_info['has_image'] && $hotel_section_i % 2 == 1)
                    {
                        $ravis_booking_hotel_section_code .= '<div class="img-container animated-box" data-animation="fadeInUp" data-bg-img="' . esc_url($hotel_section_info['img']['full']['url']) . '"></div>';
                    }

                    $ravis_booking_hotel_section_code .= '
							<div class="desc animated-box" data-animation="fadeInUp" data-delay="400">
								<div class="ravis-title-t-1">
									<div class="title"><span>' . esc_html($hotel_section_info['title']) . '</span></div>
									<div class="sub-title">' . esc_html($hotel_section_info['subtitle']) . '</div>
								</div>
								<div class="content">' . wp_kses_post($hotel_section_info['description']['main']) . '</div>
							</div>';

                    if ($hotel_section_info['has_image'] && $hotel_section_i % 2 == 0)
                    {
                        $ravis_booking_hotel_section_code .= '<div class="img-container animated-box" data-animation="fadeInUp" data-bg-img="' . esc_url($hotel_section_info['img']['full']['url']) . '"></div>';
                    }

                    $ravis_booking_hotel_section_code .= '</div>';
                    $hotel_section_i++;
                }

                $ravis_booking_hotel_section_code .= '</section>';
            }
            else
            {
                $ravis_booking_hotel_section_code = esc_html__('You have not set any sections for your hotel.', 'ravis-booking');
            }

            wp_reset_query();

            return balancetags($ravis_booking_hotel_section_code);
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Generate Package Section
         * ------------------------------------------------------------------------------------------
         */
        public function ravis_booking_package($attr)
        {
            $ravis_booking_package_attr = shortcode_atts(array(
                // can be switched between "simple" and "box"
                'title_type'  => 'simple',
                'title'       => '',
                'subtitle'    => '',
                'description' => '',
                'count'       => 3,
            ), $attr);

            $args                        = array(
                'post_type'      => 'packages',
                'post_status'    => 'publish',
                'order'          => 'DESC',
                'orderby'        => 'date',
                'posts_per_page' => $ravis_booking_package_attr['count'],
            );
            $ravis_booking_package_query = new WP_Query($args);
            $get_info_obj                = new ravis_booking_get_info();
            $ravis_booking_package_code  = '
					<section id="special-offers">
						<div class="inner-container container">';

            if (!empty($ravis_booking_package_attr['title']) || !empty($ravis_booking_package_attr['subtitle']))
            {
                if ($ravis_booking_package_attr['title_type'] === 'box')
                {
                    $ravis_booking_package_code .= '
						<div class="ravis-title">
							<div class="inner-box">
								<div class="title"><span>' . esc_html($ravis_booking_package_attr['title']) . '</span></div>
								<div class="sub-title">' . esc_html($ravis_booking_package_attr['subtitle']) . '</div>
							</div>
						</div>';
                }
                else
                {
                    $ravis_booking_package_code .= '
						<div class="ravis-title-t-2">
							<div class="title"><span>' . esc_html($ravis_booking_package_attr['title']) . '</span></div>
							<div class="sub-title">' . esc_html($ravis_booking_package_attr['subtitle']) . '</div>
						</div>';
                }
            }

            $ravis_booking_package_code .= '
							<div class="main-desc">' . esc_html($ravis_booking_package_attr['description']) . '</div>
							<div class="packages-container clearfix">';

            if ($ravis_booking_package_query->have_posts())
            {
                $package_i = 0;

                while ($ravis_booking_package_query->have_posts())
                {
                    $ravis_booking_package_query->the_post();
                    $post_id                    = get_the_ID();
                    $package_info               = $get_info_obj->package_info($post_id);
                    $package_img                = !empty($package_info['img']) ? $package_info['img']['full']['url'] : '';
                    $ravis_booking_package_code .= '
								<div class="package-box col-sm-6 col-md-4">
									<div class="main-inner-box" data-bg-img="' . esc_url($package_img) . '">
										<div class="title-box">
											<div class="title">' . esc_html($package_info['title']) . '</div>
											<div class="sub-title">' . esc_html($package_info['subtitle']) . '</div>
										</div>
										<div class="price-box">' . wp_kses_post($package_info['price']['generated']) . '</div>
										<div class="detail-box">';

                    if (!empty($package_info['items']))
                    {
                        $ravis_booking_package_code .= '<ul>';

                        foreach ($package_info['items'] as $item)
                        {
                            if (!empty($item['title']))
                            {
                                $ravis_booking_package_code .= '<li><div class="inner-box">' . esc_html($item['title']) . '</div></li>';
                            }
                        }

                        $ravis_booking_package_code .= '</ul>';
                    }

                    $ravis_booking_package_code .= '
										</div>
										<form action="' . (Ravis_booking_get_info::booking_page_url()) . '" method="post">
											<input type="hidden" name="package-id" value="' . esc_attr($package_info['id']) . '">
											<button type="submit" class="ravis-btn btn-type-2">' . esc_html__('Select', 'ravis-booking') . '</button>
										</form>
									</div>
							</div>';

                    $package_i++;
                }

                $ravis_booking_package_code .= '</section>';
            }
            else
            {
                $ravis_booking_package_code .= esc_html__('There is not any packages here.', 'ravis-booking');
            }

            $ravis_booking_package_code .= '
						</div>
					</div>
				</section>';

            wp_reset_query();

            return balancetags($ravis_booking_package_code);
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Generate Video Tour
         * ------------------------------------------------------------------------------------------
         */
        public function ravis_booking_video_tour($attr)
        {
            $ravis_booking_video_attr = shortcode_atts(array(
                // There is 2 types for this shortocde "simple", "two-cols"
                'type'        => 'two-cols',
                'title'       => '',
                'subtitle'    => '',
                'description' => '',
                'bg_img'      => '',
                'video'       => '',
            ), $attr);

            if ($ravis_booking_video_attr['type'] === 'simple')
            {
                $ravis_booking_video_code = '
					<section id="video-section">
						<div class="inner-container container">
							<div class="ravis-title-t-2">
								<div class="title"><span>' . $ravis_booking_video_attr['title'] . '</span></div>
								<div class="sub-title">' . $ravis_booking_video_attr['subtitle'] . '</div>
							</div>

							<div class="content clearfix">
								<iframe src="' . (!empty($ravis_booking_video_attr['video']) ? esc_url($ravis_booking_video_attr['video']) : '#') . '" frameborder="0" allowfullscreen></iframe>
								<div class="desc">' . $ravis_booking_video_attr['description'] . '</div>
							</div>
						</div>
					</section>';
            }
            else
            {
                $ravis_booking_video_code = '
				<section id="video-tour" data-bg-img="' . (!empty($ravis_booking_video_attr['bg_img']) ? esc_url($ravis_booking_video_attr['bg_img']) : '#') . '">
					<div class="inner-container container">
						<div class="row">
							<div class="l-sec col-md-6">
								<div class="ravis-title">
									<div class="inner-box">
										<div class="title">' . $ravis_booking_video_attr['title'] . '</div>
										<div class="sub-title">' . $ravis_booking_video_attr['subtitle'] . '</div>
									</div>
								</div>

							</div>
							<div class="r-sec col-md-6">' . $ravis_booking_video_attr['description'] . '</div>
						</div>
						<div class="row btn-box">
							<a href="' . (!empty($ravis_booking_video_attr['video']) ? esc_url($ravis_booking_video_attr['video']) : '#') . '" class="play-btn video-url">
								<i class="fa fa-play"></i>
							</a>
						</div>
					</div>
				</section>';
            }

            return balancetags($ravis_booking_video_code);
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Generate Time line
         * ------------------------------------------------------------------------------------------
         */
        public function ravis_booking_timeline($attr)
        {
            $ravis_booking_timeline_attr = shortcode_atts(array(
                'title'       => '',
                'subtitle'    => '',
                'description' => '',
                'count'       => -1,
            ), $attr);

            $args                         = array(
                'post_type'      => 'timeline',
                'post_status'    => 'publish',
                'order'          => 'DESC',
                'orderby'        => 'date',
                'posts_per_page' => $ravis_booking_timeline_attr['count'],
            );
            $ravis_booking_timeline_query = new WP_Query($args);

            $get_info_obj = new ravis_booking_get_info();

            $ravis_booking_timeline_code = '
				<section id="history-section">
					<div class="inner-container container">';

            if (!empty($ravis_booking_timeline_attr['title']) || !empty($ravis_booking_timeline_attr['subtitle']))
            {
                $ravis_booking_timeline_code .= '
						<div class="ravis-title-t-2">
							<div class="title"><span>' . esc_html($ravis_booking_timeline_attr['title']) . '</span></div>
							<div class="sub-title">' . esc_html($ravis_booking_timeline_attr['subtitle']) . '</div>
						</div>';
            }

            $ravis_booking_timeline_code .= '
						<div class="desc">' . wp_kses_post($ravis_booking_timeline_attr['description']) . '</div>
						<div class="history-timeline clearfix">';

            if ($ravis_booking_timeline_query->have_posts())
            {
                $timeline_i = 0;

                while ($ravis_booking_timeline_query->have_posts())
                {
                    $ravis_booking_timeline_query->the_post();
                    $post_id       = get_the_ID();
                    $timeline_info = $get_info_obj->timeline_info($post_id);

                    $ravis_booking_timeline_code .= '
							<div class="history-boxes col-md-6 col-xs-6 animated-box" data-animation="' . ($timeline_i % 2 == 0 ? esc_attr('fadeInLeft') : esc_attr('fadeInRight')) . '">
								<div class="history-boxes-inner">
									<i>' . esc_html($timeline_info['date']) . '</i>
									<h5>' . esc_html($timeline_info['title']) . '</h5>
									<div class="history-content">' . wp_kses_post($timeline_info['description']['main']) . '</div>
								</div>
							</div>';
                    $timeline_i++;
                }
            }
            else
            {
                $ravis_booking_timeline_code .= esc_html__('There is not any events here.', 'ravis-booking');
            }

            $ravis_booking_timeline_code .= '
						</div>
					</div>
				</section>';

            return balancetags($ravis_booking_timeline_code);
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Generate Service Slider
         * ------------------------------------------------------------------------------------------
         */
        public function ravis_booking_services($attr)
        {
            $ravis_booking_services_attr = shortcode_atts(array(
                'title'       => '',
                'subtitle'    => '',
                'description' => '',
                'count'       => -1,
            ), $attr);

            $args                         = array(
                'post_type'      => 'service',
                'post_status'    => 'publish',
                'order'          => 'DESC',
                'orderby'        => 'date',
                'posts_per_page' => $ravis_booking_services_attr['count'],
                'meta_query'     => array(
                    array(
                        'key'   => 'ravis_booking_service_shortcode',
                        'value' => 'on',
                    ),
                ),
            );
            $ravis_booking_services_query = new WP_Query($args);

            $get_info_obj = new ravis_booking_get_info();

            $ravis_booking_services_code = '
				<section id="our-services">
					<div class="inner-container container">';

            if (!empty($ravis_booking_services_attr['title']) || !empty($ravis_booking_services_attr['subtitle']))
            {
                $ravis_booking_services_code .= '
						<div class="ravis-title">
							<div class="inner-box">
								<div class="title">' . esc_html($ravis_booking_services_attr['title']) . '</div>
								<div class="sub-title">' . esc_html($ravis_booking_services_attr['subtitle']) . '</div>
							</div>
						</div>';
            }

            if ($ravis_booking_services_query->have_posts())
            {
                $ravis_booking_services_code .= '<div id="services-box" class="owl-carousel owl-theme">';

                $services_i = 0;

                while ($ravis_booking_services_query->have_posts())
                {
                    $ravis_booking_services_query->the_post();
                    $post_id       = get_the_ID();
                    $services_info = $get_info_obj->service_info($post_id);

                    $ravis_booking_services_code .= '<div class="item">';

                    if ($services_info['has_image'])
                    {
                        $ravis_booking_services_code .= $services_info['img']['large'];
                    }

                    $ravis_booking_services_code .= '
							<div class="title">' . esc_html($services_info['title']) . '</div>
						</div>';
                    $services_i++;
                }

                $ravis_booking_services_code .= '</div>';
            }
            else
            {
                $ravis_booking_services_code .= esc_html__('There is not any services here.', 'ravis-booking');
            }

            $ravis_booking_services_code .= '
					</div>
				</section>';

            return balancetags($ravis_booking_services_code);
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Generate Clients
         * ------------------------------------------------------------------------------------------
         */
        public function ravis_booking_clients($attr)
        {
            $ravis_booking_clients_attr = shortcode_atts(array(
                'count' => 4,
            ), $attr);

            $client_i                   = 0;
            $ravis_booking_clients_code = '
				<section id="client-section">
					<div class="inner-container container">';

            if (!empty($this->ravis_booking_option['client']))
            {
                $ravis_booking_clients_code .= '<ul class="client-list clearfix">';

                foreach ($this->ravis_booking_option['client'] as $client)
                {
                    if ($client_i >= $ravis_booking_clients_attr['count'] && $ravis_booking_clients_attr['count'] != -1)
                    {
                        continue;
                    }

                    $client_logo                = wp_get_attachment_image($client['logo'], 'large');
                    $ravis_booking_clients_code .= '
						<li class="col-xs-6 col-md-3 animated-box" data-animation="fadeInUp">
							<a href="' . esc_url($client['url']) . '" title="' . esc_attr($client['title']) . '">
								' . balanceTags($client_logo) . '
							</a>
						</li>';
                    $client_i++;
                }

                $ravis_booking_clients_code .= '</ul>';
            }
            else
            {
                $ravis_booking_clients_code .= esc_html__('You have not set any client for your hotel.', 'ravis-booking');
            }

            $ravis_booking_clients_code .= '
					</div>
				</section>
			';

            return balancetags($ravis_booking_clients_code);
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Generate Staff
         * ------------------------------------------------------------------------------------------
         */
        public function ravis_booking_staff($attr)
        {
            $ravis_booking_staff_attr = shortcode_atts(array(
                'ids'   => '',
                'count' => -1,
            ), $attr);

            $get_info_obj = new ravis_booking_get_info();

            if (empty($ravis_booking_staff_attr['ids']))
            {
                $args = array(
                    'post_type'      => 'staff',
                    'post_status'    => 'publish',
                    'order'          => 'DESC',
                    'orderby'        => 'date',
                    'posts_per_page' => $ravis_booking_staff_attr['count'],
                );

                $ravis_booking_staff_query = new WP_Query($args);
                $ravis_booking_staff_code  = '
				<section id="staff-section">
					<div class="inner-container container">
						<div class="row staff-row">';

                if ($ravis_booking_staff_query->have_posts())
                {
                    $staff_i = 0;

                    while ($ravis_booking_staff_query->have_posts())
                    {
                        if (($staff_i % 2 == 0) && $staff_i !== 0)
                        {
                            $ravis_booking_staff_code .= '</div><div class="row staff-row">';
                        }

                        $ravis_booking_staff_query->the_post();
                        $post_id    = get_the_ID();
                        $staff_info = $get_info_obj->staff_info($post_id);

                        $ravis_booking_staff_code .= '
						<div class="staff-box col-md-6 animated-box" data-animation="' . ($staff_i % 2 == 1 ? esc_attr('fadeInRight') : esc_attr('fadeInLeft')) . '">
							<div class="staff-box-inner">
								<div class="inner-box">
									<div class="staff-img col-md-6">';

                        if ($staff_info['has_image'])
                        {
                            $ravis_booking_staff_code .= $staff_info['img']['full'];
                        }

                        $ravis_booking_staff_code .= '</div>
									<div class="staff-info col-md-6">
										<div class="ravis-title-t-1">
											<div class="title"><span>' . esc_html($staff_info['title']) . '</span></div>
											<div class="sub-title">' . esc_html($staff_info['position']) . '</div>
										</div>
										<div class="desc">' . esc_html($staff_info['description']['main']) . '</div>
										<div class="social-icons">
											<ul class="list-inline">';

                        if (!empty($staff_info['email']))
                        {
                            $ravis_booking_staff_code .= '<li><a href="' . esc_url($staff_info['email']) . '"><i class="fa fa-envelope"></i></a></li>';
                        }

                        if (!empty($staff_info['skype']))
                        {
                            $ravis_booking_staff_code .= '<li><a href="' . esc_url($staff_info['skype']) . '"><i class="fa fa-facebook"></i></a></li>';
                        }

                        if (!empty($staff_info['facebook']))
                        {
                            $ravis_booking_staff_code .= '<li><a href="' . esc_url($staff_info['facebook']) . '"><i class="fa fa-twitter"></i></a></li>';
                        }

                        if (!empty($staff_info['twitter']))
                        {
                            $ravis_booking_staff_code .= '<li><a href="' . esc_url($staff_info['twitter']) . '"><i class="fa fa-google-plus"></i></a></li>';
                        }

                        if (!empty($staff_info['google_plus']))
                        {
                            $ravis_booking_staff_code .= '<li><a href="' . esc_url($staff_info['google_plus']) . '"><i class="fa fa-skype"></i></a></li>';
                        }

                        $ravis_booking_staff_code .= '
											</ul>
										</div>
									</div>
									<div class="clear-box"></div>
								</div>
							</div>
						</div>';

                        $staff_i++;

                        if ($staff_i === $ravis_booking_staff_query->post_count)
                        {
                            $ravis_booking_staff_code .= '</div>';
                        }
                    }
                }
                else
                {
                    $ravis_booking_staff_code .= esc_html__('There is not any staff here.', 'ravis-booking');
                }

                $ravis_booking_staff_code .= '
					</div>
				</section>';
            }
            else
            {
                $staff_ids_array = explode(',', $ravis_booking_staff_attr['ids']);
                $staff_count     = count($staff_ids_array);

                $ravis_booking_staff_code = '
				<section id="staff-section">
					<div class="inner-container container">
						<div class="row staff-row">';

                $staff_i = 0;

                foreach ($staff_ids_array as $staff_id)
                {
                    if (($staff_i % 2 == 0) && $staff_i !== 0)
                    {
                        $ravis_booking_staff_code .= '</div><div class="row staff-row">';
                    }

                    $staff_info = $get_info_obj->staff_info($staff_id);

                    $ravis_booking_staff_code .= '
						<div class="staff-box col-md-6 animated-box" data-animation="' . ($staff_i % 2 == 1 ? esc_attr('fadeInRight') : esc_attr('fadeInLeft')) . '">
							<div class="staff-box-inner">
								<div class="inner-box">
									<div class="staff-img col-md-6">';

                    if ($staff_info['has_image'])
                    {
                        $ravis_booking_staff_code .= $staff_info['img']['full'];
                    }

                    $ravis_booking_staff_code .= '</div>
									<div class="staff-info col-md-6">
										<div class="ravis-title-t-1">
											<div class="title"><span>' . esc_html($staff_info['title']) . '</span></div>
											<div class="sub-title">' . esc_html($staff_info['position']) . '</div>
										</div>
										<div class="desc">' . esc_html($staff_info['description']['main']) . '</div>
										<div class="social-icons">
											<ul class="list-inline">';

                    if (!empty($staff_info['email']))
                    {
                        $ravis_booking_staff_code .= '<li><a href="' . esc_url($staff_info['email']) . '"><i class="fa fa-envelope"></i></a></li>';
                    }

                    if (!empty($staff_info['skype']))
                    {
                        $ravis_booking_staff_code .= '<li><a href="' . esc_url($staff_info['skype']) . '"><i class="fa fa-facebook"></i></a></li>';
                    }

                    if (!empty($staff_info['facebook']))
                    {
                        $ravis_booking_staff_code .= '<li><a href="' . esc_url($staff_info['facebook']) . '"><i class="fa fa-twitter"></i></a></li>';
                    }

                    if (!empty($staff_info['twitter']))
                    {
                        $ravis_booking_staff_code .= '<li><a href="' . esc_url($staff_info['twitter']) . '"><i class="fa fa-google-plus"></i></a></li>';
                    }

                    if (!empty($staff_info['google_plus']))
                    {
                        $ravis_booking_staff_code .= '<li><a href="' . esc_url($staff_info['google_plus']) . '"><i class="fa fa-skype"></i></a></li>';
                    }

                    $ravis_booking_staff_code .= '
											</ul>
										</div>
									</div>
									<div class="clear-box"></div>
								</div>
							</div>
						</div>';

                    $staff_i++;

                    if ($staff_i === $staff_count)
                    {
                        $ravis_booking_staff_code .= '</div>';
                    }
                }

                $ravis_booking_staff_code .= '
					</div>
				</section>';
            }

            return balancetags($ravis_booking_staff_code);
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Generate Promo Section
         * ------------------------------------------------------------------------------------------
         */
        public function ravis_booking_promo($attr)
        {
            $ravis_booking_promo_attr = shortcode_atts(array(
                'title'    => '',
                'subtitle' => '',
                'bg_img'   => '',
            ), $attr);

            $ravis_booking_promo_code = '
				<section id="promo-section" data-bg-img="' . esc_url($ravis_booking_promo_attr['bg_img']) . '">
					<div class="ravis-title">
						<div class="inner-box">
							<div class="sub-title">' . esc_html($ravis_booking_promo_attr['subtitle']) . '</div>
							<div class="title">' . esc_html($ravis_booking_promo_attr['title']) . '</div>
						</div>
					</div>
				</section>';

            return balancetags($ravis_booking_promo_code);
        }

        /**
         * ------------------------------------------------------------------------------------------
         * Generate Social icons
         * ------------------------------------------------------------------------------------------
         */
        public function ravis_booking_social_icon($attr)
        {
            $ravis_booking_social_icon_attr = shortcode_atts(array(
                'id'    => 'social-icons',
                'class' => '',
                'print' => false,
            ), $attr);

            $social_icons_list = $this->ravis_booking_option['social_icons'];

            $social_icons_codes = '<ul class="list-inline list-unstyled social-icons">';

            if (!empty($social_icons_list['twitter'])):
                $social_icons_codes .= '<li><a href="' . esc_url($social_icons_list['twitter']) . '" class="ravis-booking-icon-twitter"></a></li>';
            endif;

            if (!empty($social_icons_list['facebook'])):
                $social_icons_codes .= '<li><a href="' . esc_url($social_icons_list['facebook']) . '" class="ravis-booking-icon-facebook"></a></li>';
            endif;

            if (!empty($social_icons_list['gplus'])):
                $social_icons_codes .= '<li><a href="' . esc_url($social_icons_list['gplus']) . '" class="ravis-booking-icon-google-plus"></a></li>';
            endif;

            if (!empty($social_icons_list['flickr'])):
                $social_icons_codes .= '<li><a href="' . esc_url($social_icons_list['flickr']) . '" class="ravis-booking-icon-flickr"></a></li>';
            endif;

            if (!empty($social_icons_list['rss'])):
                $social_icons_codes .= '<li><a href="' . esc_url($social_icons_list['rss']) . '" class="ravis-booking-icon-rss"></a></li>';
            endif;

            if (!empty($social_icons_list['vimeo'])):
                $social_icons_codes .= '<li><a href="' . esc_url($social_icons_list['vimeo']) . '" class="ravis-booking-icon-vimeo"></a></li>';
            endif;

            if (!empty($social_icons_list['youtube'])):
                $social_icons_codes .= '<li><a href="' . esc_url($social_icons_list['youtube']) . '" class="ravis-booking-icon-youtube"></a></li>';
            endif;

            if (!empty($social_icons_list['pinterest'])):
                $social_icons_codes .= '<li><a href="' . esc_url($social_icons_list['pinterest']) . '" class="ravis-booking-icon-pinterest"></a></li>';
            endif;

            if (!empty($social_icons_list['tumblr'])):
                $social_icons_codes .= '<li><a href="' . esc_url($social_icons_list['tumblr']) . '" class="ravis-booking-icon-tumblr"></a></li>';
            endif;

            if (!empty($social_icons_list['dribbble'])):
                $social_icons_codes .= '<li><a href="' . esc_url($social_icons_list['dribbble']) . '" class="ravis-booking-icon-dribbble"></a></li>';
            endif;

            if (!empty($social_icons_list['digg'])):
                $social_icons_codes .= '<li><a href="' . esc_url($social_icons_list['digg']) . '" class="ravis-booking-icon-digg"></a></li>';
            endif;

            if (!empty($social_icons_list['linkedin'])):
                $social_icons_codes .= '<li><a href="' . esc_url($social_icons_list['linkedin']) . '" class="ravis-booking-icon-linkedin"></a></li>';
            endif;

            if (!empty($social_icons_list['blogger'])):
                $social_icons_codes .= '<li><a href="' . esc_url($social_icons_list['blogger']) . '" class="ravis-booking-icon-blogger"></a></li>';
            endif;

            if (!empty($social_icons_list['skype'])):
                $social_icons_codes .= '<li><a href="' . esc_url($social_icons_list['skype']) . '" class="ravis-booking-icon-skype"></a></li>';
            endif;

            if (!empty($social_icons_list['forrst'])):
                $social_icons_codes .= '<li><a href="' . esc_url($social_icons_list['forrst']) . '" class="ravis-booking-icon-forrst"></a></li>';
            endif;

            if (!empty($social_icons_list['deviantart'])):
                $social_icons_codes .= '<li><a href="' . esc_url($social_icons_list['deviantart']) . '" class="ravis-booking-icon-deviantart"></a></li>';
            endif;

            if (!empty($social_icons_list['yahoo'])):
                $social_icons_codes .= '<li><a href="' . esc_url($social_icons_list['yahoo']) . '" class="ravis-booking-icon-yahoo"></a></li>';
            endif;

            if (!empty($social_icons_list['reddit'])):
                $social_icons_codes .= '<li><a href="' . esc_url($social_icons_list['reddit']) . '" class="ravis-booking-icon-reddit"></a></li>';
            endif;

            if (!empty($social_icons_list['instagram'])):
                $social_icons_codes .= '<li><a href="' . esc_url($social_icons_list['instagram']) . '" class="ravis-booking-icon-instagram"></a></li>';
            endif;

            $social_icons_codes .= '</ul>';

            if ((!isset($ravis_booking_social_icon_attr['print']) or $ravis_booking_social_icon_attr['print'] == false) && $social_icons_codes != '')
            {
                return '<div class="social-icons-box clearfix ' . (!empty($ravis_booking_social_icon_attr['class']) ? esc_attr($ravis_booking_social_icon_attr['class']) : '') . '" ' . (!empty($ravis_booking_social_icon_attr['id']) ? 'id="' . esc_attr($ravis_booking_social_icon_attr['id']) . '"' : '') . '>' . balancetags($social_icons_codes) . '</div>';
            }
            else
            {
                if ($social_icons_codes != '')
                {
                    echo '<div class="social-icons-box clearfix ' . (!empty($ravis_booking_social_icon_attr['class']) ? esc_attr($ravis_booking_social_icon_attr['class']) : '') . '" ' . (!empty($ravis_booking_social_icon_attr['id']) ? 'id="' . esc_attr($ravis_booking_social_icon_attr['id']) . '"' : '') . '>' . balancetags($social_icons_codes) . '</div>';
                }
            }
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Generate Special Dishes
         * ------------------------------------------------------------------------------------------
         */
        public function ravis_booking_dishes($attr)
        {
            $ravis_booking_dishes_attr = shortcode_atts(array(
                'title'    => '',
                'subtitle' => '',
                'count'    => -1,
                'post_url' => true,
            ), $attr);

            $args = array(
                'post_type'      => 'dish',
                'post_status'    => 'publish',
                'order'          => 'DESC',
                'orderby'        => 'date',
                'posts_per_page' => $ravis_booking_dishes_attr['count'],
            );

            $ravis_booking_dishes_query = new WP_Query($args);

            $get_info_obj = new ravis_booking_get_info();

            $ravis_booking_dishes_code = '
				<section id="special-dishes">
					<div class="inner-container container">';

            if (!empty($ravis_booking_dishes_attr['title']) || !empty($ravis_booking_dishes_attr['subtitle']))
            {
                $ravis_booking_dishes_code .= '
						<div class="ravis-title">
							<div class="inner-box">
								<div class="title">' . esc_html($ravis_booking_dishes_attr['title']) . '</div>
								<div class="sub-title">' . esc_html($ravis_booking_dishes_attr['subtitle']) . '</div>
							</div>
						</div>';
            }

            if ($ravis_booking_dishes_query->have_posts())
            {
                $ravis_booking_dishes_code .= '
					<div class="dishes-container">
						<ul class="dishes-main-box clearfix">
				';

                $dishes_i = 0;

                while ($ravis_booking_dishes_query->have_posts())
                {
                    $ravis_booking_dishes_query->the_post();
                    $post_id     = get_the_ID();
                    $dishes_info = $get_info_obj->dish_info($post_id);

                    $ravis_booking_dishes_code .= '
						<li class="item col-xs-6 col-md-' . (4 * $dishes_info['box_col']) . ' ' . ($dishes_info['box_col'] === 1 ? esc_attr('small-box') : '') . '">
							<figure>';

                    if (!empty($dishes_info['has_image']))
                    {
                        $ravis_booking_dishes_code .= $dishes_info['img']['full']['generated'];
                    }

                    $ravis_booking_dishes_code .= '
								<figcaption>
									<a href="' . ($ravis_booking_dishes_attr['post_url'] !== true ? '#' : esc_url($dishes_info['url'])) . '">
										<span class="title-box">
											<span class="title">' . esc_html($dishes_info['title']) . '</span>
											<span class="sub-title">' . esc_html__('Price', 'ravis-booking') . ' : ' . esc_html($dishes_info['price']['generated']) . '</span>
										</span>
										<span class="desc">' . esc_html($dishes_info['description']['main']) . '</span>
									</a>
								</figcaption>
							</figure>
						</li>';

                    $dishes_i++;
                }

                $ravis_booking_dishes_code .= '
						</ul>
					</div>';
            }
            else
            {
                $ravis_booking_dishes_code .= esc_html__('There is not any dishes here.', 'ravis-booking');
            }

            $ravis_booking_dishes_code .= '
					</div>
				</section>';

            return balancetags($ravis_booking_dishes_code);
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Generate Special Dishes
         * ------------------------------------------------------------------------------------------
         */
        public function ravis_booking_menu($attr)
        {
            $ravis_booking_menu_attr = shortcode_atts(array(
                'title'       => '',
                'subtitle'    => '',
                'description' => '',
                'count'       => -1,
            ), $attr);

            $args = array(
                'post_type'      => 'menu',
                'post_status'    => 'publish',
                'order'          => 'DESC',
                'orderby'        => 'date',
                'posts_per_page' => $ravis_booking_menu_attr['count'],
            );

            $ravis_booking_menu_query = new WP_Query($args);

            $get_info_obj     = new ravis_booking_get_info();
            $current_currency = new Ravis_booking_currency();

            $ravis_booking_menu_code = '
				<section id="restaurant-menus">
					<div class="inner-container container">
						<div class="t-sec">';

            if (!empty($ravis_booking_menu_attr['title']) || !empty($ravis_booking_menu_attr['subtitle']))
            {
                $ravis_booking_menu_code .= '
						<div class="ravis-title-t-2">
							<div class="title">' . esc_html($ravis_booking_menu_attr['title']) . '</div>
							<div class="sub-title">' . esc_html($ravis_booking_menu_attr['subtitle']) . '</div>
						</div>';
            }

            $ravis_booking_menu_code .= '
							<div class="content">' . esc_html($ravis_booking_menu_attr['description']) . '</div>
						</div>';

            if ($ravis_booking_menu_query->have_posts())
            {
                $menu_i    = 0;
                $tab_title = $tab_content = '';

                while ($ravis_booking_menu_query->have_posts())
                {
                    $ravis_booking_menu_query->the_post();
                    $post_id   = get_the_ID();
                    $menu_info = $get_info_obj->menu_info($post_id);

                    $tab_title .= '
						<a href="#menu-' . esc_attr($menu_i) . '" class="tab-box ' . ($menu_i === 0 ? esc_attr('active') : '') . '">
							<span class="title">' . esc_html($menu_info['title']) . '</span>
							<span class="sub-title">' . esc_html($menu_info['subtitle']) . '</span>
						</a>
					';

                    $tab_bg = $first_tab_bg = '';
                    if (!empty($menu_info['has_image']))
                    {
                        $tab_bg = $menu_info['img']['full']['url'];

                        if ($menu_i == 0)
                        {
                            $first_tab_bg = $tab_bg;
                        }
                    }

                    $tab_content .= '
						<div class="tab-pane fadeInLeft clearfix ' . ($menu_i === 0 ? esc_attr('active') : '') . '" id="menu-' . esc_attr($menu_i) . '" data-img-name="' . esc_url($tab_bg) . '">
							<div class="chef-selection col-md-6 fadeInLeft">';

                    if (!empty($menu_info['menu_items']['chief_select']))
                    {
                        $chief_selection_index = $menu_info['menu_items']['chief_select'];
                        $tab_content .= '
								<div class="ravis-title-t-2">
									<div class="title"><span>' . esc_html($menu_info['menu_items']['items'][ $chief_selection_index ]['title']) . '</span></div>
									<div class="sub-title"><span>' . esc_html__('Chef Selection', 'ravis-booking') . '</span></div>
								</div>';
                    }

                    $tab_content .= '
							</div>
							<div class="menu-list col-md-6 fadeInLeft">
								<ul>';

                    if (!empty($menu_info['menu_items']))
                    {
                        foreach ($menu_info['menu_items']['items'] as $menu)
                        {
                            $item_price  = $current_currency->price_full_generator($menu['price']);
                            $tab_content .= '
									<li>
										<div class="price">' . esc_html($item_price) . '</div>
										<div class="title">' . esc_html($menu['title']) . '</div>
									</li>';
                        }
                    }

                    $tab_content .= '
								</ul>
							</div>
						</div>';

                    $menu_i++;
                }

                $ravis_booking_menu_code .= '
					<div class="b-sec clearfix">
						<div class="col-md-4 tab-container">' . balanceTags($tab_title) . '</div>
						<div class="col-md-8 tab-content" data-bg-img="' . esc_url($first_tab_bg) . '">' . balanceTags($tab_content) . '</div>
					</div>';
            }
            else
            {
                $ravis_booking_menu_code .= esc_html__('There is not any menus here.', 'ravis-booking');
            }

            $ravis_booking_menu_code .= '
					</div>
				</section>';

            return balancetags($ravis_booking_menu_code);
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Generate Testimonial Form
         * ------------------------------------------------------------------------------------------
         */
        public function ravis_booking_testimonial_form($attr)
        {
            $ravis_booking_testimonial_form_attr = shortcode_atts(array(
                'title'    => '',
                'subtitle' => '',
                'class'    => '',
            ), $attr);
            $ravis_booking_testimonial_form_code = '
				<div class="guest-book-item guest-book-form-box ' . esc_attr($ravis_booking_testimonial_form_attr['class']) . '">
					<div class="inner-box">';

            if (!empty($ravis_booking_testimonial_form_attr['title']) || !empty($ravis_booking_testimonial_form_attr['subtitle']))
            {
                $ravis_booking_testimonial_form_code .= '
						<div class="ravis-title-t-2">
							<div class="title"><span>' . esc_html($ravis_booking_testimonial_form_attr['title']) . '</span></div>
							<div class="sub-title">' . esc_html($ravis_booking_testimonial_form_attr['subtitle']) . '</div>
						</div>';
            }

            $rand_digit                          = rand(1, 10000);
            $ravis_booking_testimonial_form_code .= '
						<form action="#" class="guest-book-form guest-book-form-' . esc_attr($rand_digit) . '">
							' . wp_nonce_field('testimonial_form_nonce') . '
							<div class="field-row">
								<input type="text" placeholder="' . esc_html__('Name *', 'ravis-booking') . '" name="guest-name" class="guest-name" required>
							</div>
							<div class="field-row">
								<input type="email" placeholder="' . esc_html__('Email', 'ravis-booking') . '" name="guest-email" class="guest-email">
							</div>
							<div class="field-row">
								<input type="text" placeholder="' . esc_html__('Phone', 'ravis-booking') . '" name="guest-phone" class="guest-phone">
							</div>
							<div class="field-row">
								<input type="text" placeholder="' . esc_html__('Your Job', 'ravis-booking') . '" name="guest-job" class="guest-job">
							</div>
							<div class="field-row">
								<input type="text" placeholder="' . esc_html__('Testimonial\'s Title *', 'ravis-booking') . '" name="testimonial-title" class="testimonial-title" required>
							</div>
							<div class="field-row">
								<textarea name="testimonial-message" class="testimonial-message" placeholder="' . esc_html__('Your Testimonial *', 'ravis-booking') . '"></textarea>
							</div>
							<div class="message-container"></div>
							<div class="field-row">
								<input type="submit" value="' . esc_html__('Send', 'ravis-booking') . '">
							</div>
						</form>
					</div>
				</div>';
            $ravis_booking_testimonial_js        = "
				jQuery('.guest-book-form-" . esc_js($rand_digit) . "').on('submit', function(e) {
			        e.preventDefault();
			        var _this       = jQuery(this),
			            name        = _this.find('.guest-name').val(),
						email       = _this.find('.guest-email').val(),
						phone       = _this.find('.guest-phone').val(),
						job         = _this.find('.guest-job').val(),
						title       = _this.find('.testimonial-title').val(),
						message     = _this.find('.testimonial-message').val(),
						nonce       = _this.find('#_wpnonce').val(),
						messageBox  = _this.find('.message-container');

			        _this.addClass('loading');
					messageBox.removeClass('active success info danger').html('');

			        var data = {
			            action: 'ravis_booking_insert_testimonials',
			            name: name,
			            email: email,
			            tel: phone,
			            job: job,
			            title: title,
			            nonce: nonce,
			            testimonials: message
			        };

			        jQuery.post('" . esc_js(admin_url('admin-ajax.php')) . "', data, function(data){
			            var data = JSON.parse(jQuery.trim(data));
			            _this.removeClass('loading');
			            messageBox.addClass('active').html(data.message);
						if(data.status === true) messageBox.addClass('success');
						if(data.status === false) messageBox.addClass('danger');
			        });
			    });";

            wp_add_inline_script('ravis-booking-front-js', $ravis_booking_testimonial_js);

            return balancetags($ravis_booking_testimonial_form_code);
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Generate Upcoming Events
         * ------------------------------------------------------------------------------------------
         */
        public function ravis_booking_upcoming_events($attr)
        {
            $ravis_booking_upcoming_events_attr = shortcode_atts(array(
                'title'    => '',
                'subtitle' => '',
                'count'    => -1,
            ), $attr);

            $args = array(
                'post_type'      => 'events',
                'post_status'    => 'publish',
                'order'          => 'DESC',
                'orderby'        => 'date',
                'posts_per_page' => $ravis_booking_upcoming_events_attr['count'],
                'meta_query'     => array(
                    array(
                        'key'     => 'ravis_booking_events_date',
                        'value'   => date('Y-m-d'),
                        'compare' => '>=',
                    ),
                ),
            );

            $ravis_booking_upcoming_events_query = new WP_Query($args);

            $get_info_obj = new ravis_booking_get_info();

            $ravis_booking_upcoming_events_code = '
				<section id="upcoming-events">
					<div class="inner-container container">';

            if (!empty($ravis_booking_upcoming_events_attr['title']) || !empty($ravis_booking_upcoming_events_attr['subtitle']))
            {
                $ravis_booking_upcoming_events_code .= '
						<div class="ravis-title">
							<div class="inner-box">
								<div class="title">' . esc_html($ravis_booking_upcoming_events_attr['title']) . '</div>
								<div class="sub-title">' . esc_html($ravis_booking_upcoming_events_attr['subtitle']) . '</div>
							</div>
						</div>';
            }

            if ($ravis_booking_upcoming_events_query->have_posts())
            {
                $ravis_booking_upcoming_events_code .= '
					<div class="event-container">
						<ul class="event-main-box clearfix">
				';

                $upcoming_events_i = 0;

                while ($ravis_booking_upcoming_events_query->have_posts())
                {
                    $ravis_booking_upcoming_events_query->the_post();
                    $post_id              = get_the_ID();
                    $upcoming_events_info = $get_info_obj->event_info($post_id);

                    $ravis_booking_upcoming_events_code .= '
						<li class="item col-xs-6 col-md-' . (4 * $upcoming_events_info['box_col']) . ' ' . ($upcoming_events_info['box_col'] === 1 ? esc_attr('small-box') : '') . '">
							<figure>';

                    if (!empty($upcoming_events_info['gallery']['count']))
                    {
                        $ravis_booking_upcoming_events_code .= $upcoming_events_info['gallery']['img'][0]['code']['full'];
                    }

                    $ravis_booking_upcoming_events_code .= '
								<figcaption>
									<a href="' . esc_url($upcoming_events_info['url']) . '">
										<span class="title-box">
											<span class="title">' . esc_html($upcoming_events_info['title']) . '</span>
											<span class="sub-title">' . esc_html($upcoming_events_info['subtitle']) . '</span>
										</span>
										<span class="desc">' . esc_html($upcoming_events_info['description']['short']) . '</span>
									</a>
								</figcaption>
							</figure>
						</li>';

                    $upcoming_events_i++;
                }

                $ravis_booking_upcoming_events_code .= '
						</ul>
					</div>';
            }
            else
            {
                $ravis_booking_upcoming_events_code .= esc_html__('There is not any events here.', 'ravis-booking');
            }

            $ravis_booking_upcoming_events_code .= '
					</div>
				</section>';

            return balancetags($ravis_booking_upcoming_events_code);
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Generate Past Events
         * ------------------------------------------------------------------------------------------
         */
        public function ravis_booking_past_events($attr)
        {
            $ravis_booking_past_events_attr = shortcode_atts(array(
                'title'    => '',
                'subtitle' => '',
                'count'    => -1,
            ), $attr);

            $args = array(
                'post_type'      => 'events',
                'post_status'    => 'publish',
                'order'          => 'DESC',
                'orderby'        => 'date',
                'posts_per_page' => $ravis_booking_past_events_attr['count'],
                'meta_query'     => array(
                    array(
                        'key'     => 'ravis_booking_events_date',
                        'value'   => date('Y-m-d'),
                        'compare' => '<',
                    ),
                ),
            );

            $ravis_booking_past_events_query = new WP_Query($args);

            $get_info_obj = new ravis_booking_get_info();

            $ravis_booking_past_events_code = '
				<section id="past-events">
					<div class="inner-container container">';

            if (!empty($ravis_booking_past_events_attr['title']) || !empty($ravis_booking_past_events_attr['subtitle']))
            {
                $ravis_booking_past_events_code .= '
						<div class="ravis-title">
							<div class="inner-box">
								<div class="title">' . esc_html($ravis_booking_past_events_attr['title']) . '</div>
								<div class="sub-title">' . esc_html($ravis_booking_past_events_attr['subtitle']) . '</div>
							</div>
						</div>';
            }

            if ($ravis_booking_past_events_query->have_posts())
            {
                $ravis_booking_past_events_code .= '
					<div class="event-container">
						<ul class="event-main-box clearfix">
				';

                $past_events_i = 0;

                while ($ravis_booking_past_events_query->have_posts())
                {
                    $ravis_booking_past_events_query->the_post();
                    $post_id          = get_the_ID();
                    $past_events_info = $get_info_obj->event_info($post_id);

                    $ravis_booking_past_events_code .= '
						<li class="item col-xs-6 col-md-4">
							<figure>';

                    if (!empty($past_events_info['gallery']['count']))
                    {
                        $ravis_booking_past_events_code .= $past_events_info['gallery']['img'][0]['code']['full'];
                    }

                    $ravis_booking_past_events_code .= '
								<figcaption>
									<a href="' . esc_url($past_events_info['url']) . '">
										<span class="title-box">
											<span class="title">' . esc_html($past_events_info['title']) . '</span>
											<span class="sub-title">' . esc_html($past_events_info['subtitle']) . '</span>
										</span>
										<span class="desc">' . esc_html($past_events_info['description']['short']) . '</span>
									</a>
								</figcaption>
							</figure>
						</li>';

                    $past_events_i++;
                }

                $ravis_booking_past_events_code .= '
						</ul>
					</div>';
            }
            else
            {
                $ravis_booking_past_events_code .= esc_html__('There is not any events here.', 'ravis-booking');
            }

            $ravis_booking_past_events_code .= '
					</div>
				</section>';

            return balancetags($ravis_booking_past_events_code);
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Generate Upcoming Events
         * ------------------------------------------------------------------------------------------
         */
        public function ravis_booking_other_events($attr)
        {
            $ravis_booking_upcoming_events_attr = shortcode_atts(array(
                'title'    => '',
                'subtitle' => '',
                'count'    => -1,
                'event_id' => '',
            ), $attr);

            $args = array(
                'post_type'      => 'events',
                'post_status'    => 'publish',
                'order'          => 'DESC',
                'orderby'        => 'date',
                'posts_per_page' => $ravis_booking_upcoming_events_attr['count'],
                'post__not_in'   => array((!empty($ravis_booking_upcoming_events_attr['event_id']) ? $ravis_booking_upcoming_events_attr['event_id'] : '')),
                'meta_query'     => array(
                    array(
                        'key'     => 'ravis_booking_events_date',
                        'value'   => date('Y-m-d'),
                        'compare' => '>=',
                    ),
                ),
            );

            $ravis_booking_upcoming_events_query = new WP_Query($args);

            $get_info_obj = new ravis_booking_get_info();

            $ravis_booking_upcoming_events_code = '
				<section id="upcoming-events">
					<div class="inner-container container">';

            if (!empty($ravis_booking_upcoming_events_attr['title']) || !empty($ravis_booking_upcoming_events_attr['subtitle']))
            {
                $ravis_booking_upcoming_events_code .= '
						<div class="ravis-title">
							<div class="inner-box">
								<div class="title">' . esc_html($ravis_booking_upcoming_events_attr['title']) . '</div>
								<div class="sub-title">' . esc_html($ravis_booking_upcoming_events_attr['subtitle']) . '</div>
							</div>
						</div>';
            }

            if ($ravis_booking_upcoming_events_query->have_posts())
            {
                $ravis_booking_upcoming_events_code .= '
					<div class="event-container">
						<ul class="event-main-box clearfix">';

                $upcoming_events_i = 0;

                while ($ravis_booking_upcoming_events_query->have_posts())
                {
                    $ravis_booking_upcoming_events_query->the_post();
                    $post_id              = get_the_ID();
                    $upcoming_events_info = $get_info_obj->event_info($post_id);

                    $ravis_booking_upcoming_events_code .= '
						<li class="item col-xs-6 col-md-4">
							<figure>';

                    if (!empty($upcoming_events_info['gallery']['count']))
                    {
                        $ravis_booking_upcoming_events_code .= $upcoming_events_info['gallery']['img'][0]['code']['full'];
                    }

                    $ravis_booking_upcoming_events_code .= '
								<figcaption>
									<a href="' . esc_url($upcoming_events_info['url']) . '">
										<span class="title-box">
											<span class="title">' . esc_html($upcoming_events_info['title']) . '</span>
											<span class="sub-title">' . esc_html($upcoming_events_info['subtitle']) . '</span>
										</span>
										<span class="desc">' . esc_html($upcoming_events_info['description']['short']) . '</span>
									</a>
								</figcaption>
							</figure>
						</li>';

                    $upcoming_events_i++;
                }

                $ravis_booking_upcoming_events_code .= '
						</ul>
					</div>';
            }
            else
            {
                $ravis_booking_upcoming_events_code .= esc_html__('There is not any events here.', 'ravis-booking');
            }

            $ravis_booking_upcoming_events_code .= '
					</div>
				</section>';

            return balancetags($ravis_booking_upcoming_events_code);
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Generate Event Booking Form
         * ------------------------------------------------------------------------------------------
         */
        public function ravis_booking_event_booking($attr)
        {
            $ravis_booking_event_booking_attr = shortcode_atts(array(
                'event_id' => '',
            ), $attr);

            if (!empty($ravis_booking_event_booking_attr['event_id']))
            {
                $ravis_booking_event_booking_code = '';
                $rand_digit                       = rand(1, 10000);
                $ravis_booking_event_booking_code .= '
				<form class="event-booking-form event-booking-form-' . esc_attr($rand_digit) . ' clearfix" action="#">
					<input type="hidden" name="event_id" class="event-id" value="' . esc_attr($ravis_booking_event_booking_attr['event_id']) . '">
					<div class="field-row">
						<input type="text" placeholder="' . esc_html__('Name', 'ravis-booking') . '" name="guest-name" class="guest-name" required>
					</div>
					<div class="field-row">
						<input type="email" placeholder="' . esc_html__('Email', 'ravis-booking') . '" name="guest-email" class="guest-email" required>
					</div>
					<div class="field-row">
						<input type="text" placeholder="' . esc_html__('Phone', 'ravis-booking') . '" name="guest-phone" class="guest-phone" required>
					</div>
					<div class="field-row">
						<select name="guest-count" class="guest-count" placeholder="' . esc_html__('Guests', 'ravis-booking') . '" required>
							<option></option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
						</select>
					</div>
					<div class="message-container"></div>
					<div class="field-row">
						<input type="submit" value="' . esc_html__('Book Now', 'ravis-booking') . '">
					</div>
				</form>';
                $ravis_booking_event_booking_js   = "
				jQuery('.event-booking-form-" . esc_js($rand_digit) . "').on('submit', function(e) {
			        e.preventDefault();
			        var _this       = jQuery(this),
			            eventID     = _this.find('.event-id').val(),
			            name        = _this.find('.guest-name').val(),
						email       = _this.find('.guest-email').val(),
						phone       = _this.find('.guest-phone').val(),
						guestCount  = _this.find('select.guest-count').val(),
						nonce       = '" . wp_create_nonce('event_booking_form_nonce') . "'
						messageBox  = _this.find('.message-container');

			        _this.addClass('loading');
					messageBox.removeClass('active success info danger').html('');

			        var data = {
			            action: 'ravis_booking_event_booking_submit',
			            eventID: eventID,
			            name: name,
			            email: email,
			            tel: phone,
			            nonce: nonce,
			            guestCount: guestCount
			        };

			        jQuery.post('" . esc_js(admin_url('admin-ajax.php')) . "', data, function(data){
			            var data = JSON.parse(jQuery.trim(data));
			            _this.removeClass('loading');
			            messageBox.addClass('active').html(data.message);
						if(data.status === true) messageBox.addClass('success');
						if(data.status === false) messageBox.addClass('danger');
			        });
			    });";

                wp_add_inline_script('ravis-booking-front-js', $ravis_booking_event_booking_js);
            }
            else
            {
                $ravis_booking_event_booking_code = esc_html__('You have not set any events this form.', 'ravis-booking');
            }

            return balancetags($ravis_booking_event_booking_code);
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Generate Room Listings
         * ------------------------------------------------------------------------------------------
         */
        public function ravis_booking_room_listing($attr)
        {
            $ravis_booking_room_listing_attr = shortcode_atts(array(
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
                'posts_per_page' => $ravis_booking_room_listing_attr['count'],
            );

            $ravis_booking_room_query = new WP_Query($args);

            $get_info_obj = new ravis_booking_get_info();

            $ravis_booking_room_listing_code = '
				<section id="rooms-section" ' . ($ravis_booking_room_listing_attr['layout'] == 'list' ? wp_kses_post('class="row-view"') : '') . '>
					<div class="inner-container container">';

            if (!empty($ravis_booking_room_listing_attr['title']) || !empty($ravis_booking_room_listing_attr['subtitle']))
            {
                if ($ravis_booking_room_listing_attr['title_type'] === '1')
                {
                    $ravis_booking_room_listing_code .= '
						<div class="ravis-title-t-2">
							<div class="title"><span>' . esc_html($ravis_booking_room_listing_attr['title']) . '</span></div>
							<div class="sub-title">' . esc_html($ravis_booking_room_listing_attr['subtitle']) . '</div>
						</div>';
                }
                else
                {
                    $ravis_booking_room_listing_code .= '
						<div class="ravis-title">
							<div class="inner-box">
								<div class="title">' . esc_html($ravis_booking_room_listing_attr['title']) . '</div>
								<div class="sub-title">' . esc_html($ravis_booking_room_listing_attr['subtitle']) . '</div>
							</div>
						</div>';
                }
            }

            if (!empty($ravis_booking_room_listing_attr['description']))
            {
                $ravis_booking_room_listing_code .= '<div class="desc">' . esc_html($ravis_booking_room_listing_attr['description']) . '</div>';
            }

            if ($ravis_booking_room_query->have_posts())
            {
                $ravis_booking_room_listing_code .= '<div class="room-container clearfix">';

                $room_i = 0;

                while ($ravis_booking_room_query->have_posts())
                {
                    $ravis_booking_room_query->the_post();
                    $post_id   = get_the_ID();
                    $room_info = $get_info_obj->room_info($post_id);

                    if ($ravis_booking_room_listing_attr['layout'] == 'list')
                    {
                        $ravis_booking_room_listing_code .= '
							<div class="room-box row animated-box" data-animation="fadeInUp">
                                <div class="col-md-4 room-img">';
                        if (empty($this->ravis_booking_option['listing_image_slider']))
                        {
                            $ravis_booking_room_listing_code .= '<a href="' . esc_url($room_info['url']) . '" class="cover-link"></a>';
                        }
                        $ravis_booking_room_listing_code .= '<div class="img-container">';
                        if ($room_info['gallery']['count'] > 0)
                        {
                            $img_gallery_i = 0;
                            foreach ($room_info['gallery']['img'] as $img_item)
                            {
                                if (empty($this->ravis_booking_option['listing_image_slider']) && $img_gallery_i > 0)
                                {
                                    continue;
                                }
                                $ravis_booking_room_listing_code .= '<div class="img-box" data-bg-img="' . esc_url($img_item['url']) . '"></div>';
                                $img_gallery_i++;
                            }
                        }
                        else
                        {
                            $ravis_booking_room_listing_code .= '<div class="img-box no-img"></div>';
                        }

                        $ravis_booking_room_listing_code .= '
									</div>
								</div>
								<div class="r-sec col-md-8">
									<div class="col-md-6 m-sec">
										<div class="title-box">
											<div class="title">' . esc_html($room_info['title']) . '</div>
											<div class="price">
												<div class="title">' . esc_html__('Starting from :', 'ravis-booking') . '</div>
												<div class="value">' . esc_html($room_info['start_price']) . '</div>
											</div>
										</div>
										<div class="amenities">
											<ul class="list-inline clearfix">';

                        if (!empty($room_info['room_view']))
                        {
                            $ravis_booking_room_listing_code .= '
												<li class="col-md-6">
													<div class="title">' . esc_html__('View :', 'ravis-booking') . '</div>
													<div class="value">' . esc_html($room_info['room_view']) . '</div>
												</li>';
                        }

                        if (!empty($room_info['room_size']['qnt']))
                        {
                            $ravis_booking_room_listing_code .= '
												<li class="col-md-6">
													<div class="title">' . esc_html__('Room Size :', 'ravis-booking') . '</div>
													<div class="value">' . esc_html($room_info['room_size']['qnt']) . ' ' . wp_kses_post($room_info['room_size']['unit']) . '</div>
												</li>';
                        }

                        if (!empty($room_info['max_people']))
                        {
                            $ravis_booking_room_listing_code .= '
												<li class="col-md-6">
													<div class="title">' . esc_html__('Max People :', 'ravis-booking') . '</div>
													<div class="value">' . esc_html($room_info['max_people']) . '</div>
												</li>';
                        }

                        if (!empty($room_info['service']))
                        {
                            foreach ($room_info['service'] as $service)
                            {
                                $ravis_booking_room_listing_code .= '
												<li class="col-md-6">
													<div class="title">' . esc_html($service['title']) . ' :</div>
													<div class="value">' . esc_html($service['value']) . '</div>
												</li>';
                            }
                        }

                        if (!empty($room_info['facilities']))
                        {
                            $facility_str = '';

                            foreach ($room_info['facilities'] as $facility)
                            {
                                $facility_str .= $facility['title'] . ', ';
                            }

                            $facility_str = trim($facility_str, ', ');

                            $ravis_booking_room_listing_code .= '
												<li class="col-md-12">
													<div class="title">' . esc_html__('Facilities :', 'ravis-booking') . '</div>
													<div class="value">' . esc_html($facility_str) . '</div>
												</li>';
                        }

                        $ravis_booking_room_listing_code .= '
											</ul>
										</div>
										<a href="' . esc_url($room_info['url']) . '" class="more-info">' . esc_html__('More Info', 'ravis-booking') . '</a>
									</div>
									<div class="col-md-6 desc">' . esc_html($room_info['description']['short']) . '</div>
								</div>
							</div>';
                    }
                    else
                    {
                        $ravis_booking_room_listing_code .= '
							<div class="room-box col-xs-6 col-md-4 animated-box" data-animation="fadeInUp" data-delay="' . esc_attr(($room_i % 3) * 300) . '">
								<div class="inner-box">
                                    <div class="room-img">';

                        if (empty($this->ravis_booking_option['listing_image_slider']))
                        {
                            $ravis_booking_room_listing_code .= '<a href="' . esc_url($room_info['url']) . '" class="cover-link"></a>';
                        }

                        $ravis_booking_room_listing_code .= '<div class="img-container">';
                        if ($room_info['gallery']['count'] > 0)
                        {
                            $img_gallery_i = 0;
                            foreach ($room_info['gallery']['img'] as $img_item)
                            {
                                if (empty($this->ravis_booking_option['listing_image_slider']) && $img_gallery_i > 0)
                                {
                                    continue;
                                }
                                $ravis_booking_room_listing_code .= '<div class="img-box" data-bg-img="' . esc_url($img_item['url']) . '"></div>';
                                $img_gallery_i++;
                            }
                        }
                        else
                        {
                            $ravis_booking_room_listing_code .= '<div class="img-box no-img"></div>';
                        }
                        $ravis_booking_room_listing_code .= '
										</div>
									</div>
									<div class="caption">
										<div class="title"><a href="' . esc_url($room_info['url']) . '">' . esc_html($room_info['title']) . '</a></div>
										<div class="price">
											<div class="title">' . esc_html__('Starting from :', 'ravis-booking') . '</div>
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

                $ravis_booking_room_listing_code .= '</div>';
            }
            else
            {
                $ravis_booking_room_listing_code .= esc_html__('There is not any rooms here.', 'ravis-booking');
            }

            $ravis_booking_room_listing_code .= '
					</div>
				</section>';
            wp_reset_postdata();

            return balancetags($ravis_booking_room_listing_code);
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Generate Room Search Form
         * ------------------------------------------------------------------------------------------
         */
        public function ravis_booking_room_search_form($attr)
        {
            $ravis_booking_room_search_form_attr = shortcode_atts(array(
                'title'    => '',
                'subtitle' => '',
                // layout attribute can be "horizontal" or "vertical"
                'layout'   => 'horizontal',
                'class'    => '',
            ), $attr);

            $send_info_method = 'post';

            if (!empty($this->ravis_booking_option['external_booking']))
            {
                if (!empty($this->ravis_booking_option['external_booking_method']))
                {
                    if ($this->ravis_booking_option['external_booking_method'] === '2')
                    {
                        $send_info_method = 'get';
                    }
                    else
                    {
                        $send_info_method = 'post';
                    }
                }
            }

            $ravis_booking_room_search_form_code = '';

            if ($ravis_booking_room_search_form_attr['layout'] === 'horizontal')
            {
                $ravis_booking_room_search_form_code = '
					<section class="main-availability-form ' . (!empty($ravis_booking_room_search_form_attr['class']) ? esc_attr($ravis_booking_room_search_form_attr['class']) : '') . '">
						<div class="inner-container container">';

                if (!empty($ravis_booking_room_search_form_attr['title']) || !empty($ravis_booking_room_search_form_attr['subtitle']))
                {
                    $ravis_booking_room_search_form_code .= '
							<div class="l-sec col-md-4">
								<div class="ravis-title">
									<div class="inner-box">
										<div class="title">' . esc_html($ravis_booking_room_search_form_attr['title']) . '</div>
										<div class="sub-title">' . esc_html($ravis_booking_room_search_form_attr['subtitle']) . '</div>
									</div>
								</div>
							</div>';
                }

                $ravis_booking_room_search_form_code .= '
							<div class="r-sec ' . ((!empty($ravis_booking_room_search_form_attr['title']) || !empty($ravis_booking_room_search_form_attr['subtitle'])) ? esc_attr('col-md-8') : '') . '">
								<form class="booking-form clearfix" action="' . esc_url(Ravis_booking_get_info::booking_page_url()) . '" method="' . esc_attr($send_info_method) . '">
									<div class="col-md-10">
										<div class="row">
											<div class="input-daterange col-md-8">
												<div class="booking-fields col-md-6">
													<input placeholder="' . esc_html__('Check in', 'ravis-booking') . '" class="datepicker-fields check-in" type="text" name="start"/>
													<i class="fa fa-calendar"></i>
												</div>
												<div class="booking-fields col-md-6">
													<input placeholder="' . esc_html__('Check out', 'ravis-booking') . '" class="datepicker-fields check-out" type="text" name="end"/>
													<i class="fa fa-calendar"></i>
												</div>
											</div>
											<div class="col-md-4">
												<select name="room-count" class="room-count">
													<option value=""></option>
													<option value="1" selected="selected">1 ' . esc_html__('Room', 'ravis-booking') . '</option>
													<option value="2">2 ' . esc_html__('Rooms', 'ravis-booking') . '</option>
													<option value="3">3 ' . esc_html__('Rooms', 'ravis-booking') . '</option>
													<option value="4">4 ' . esc_html__('Rooms', 'ravis-booking') . '</option>
													<option value="5">5 ' . esc_html__('Rooms', 'ravis-booking') . '</option>
												</select>
											</div>
										</div>
										<div class="room-field-container">
											<div class="row">
												<div class="booking-fields col-md-4">
													<div class="room-title">' . esc_html__('Room 1', 'ravis-booking') . ' : </div>
												</div>
												<div class="booking-fields col-md-4">
													<select name="room[0][adult]">
														<option value="1">1 ' . esc_html__('Adult', 'ravis-booking') . '</option>
														<option value="2">2 ' . esc_html__('Adults', 'ravis-booking') . '</option>
														<option value="3">3 ' . esc_html__('Adults', 'ravis-booking') . '</option>
														<option value="4">4 ' . esc_html__('Adults', 'ravis-booking') . '</option>
														<option value="5">5 ' . esc_html__('Adults', 'ravis-booking') . '</option>
														<option value="6">6 ' . esc_html__('Adults', 'ravis-booking') . '</option>
														<option value="7">7 ' . esc_html__('Adults', 'ravis-booking') . '</option>
														<option value="8">8 ' . esc_html__('Adults', 'ravis-booking') . '</option>
														<option value="9">9 ' . esc_html__('Adults', 'ravis-booking') . '</option>
														<option value="10">10 ' . esc_html__('Adults', 'ravis-booking') . '</option>
													</select>
												</div>
												<div class="booking-fields col-md-4">
													<select name="room[0][child]">
														<option value="0">' . esc_html__('No Child', 'ravis-booking') . '</option>
														<option value="1">1 ' . esc_html__('Children', 'ravis-booking') . '</option>
														<option value="2">2 ' . esc_html__('Children', 'ravis-booking') . '</option>
														<option value="3">3 ' . esc_html__('Children', 'ravis-booking') . '</option>
														<option value="4">4 ' . esc_html__('Children', 'ravis-booking') . '</option>
														<option value="5">5 ' . esc_html__('Children', 'ravis-booking') . '</option>
														<option value="6">6 ' . esc_html__('Children', 'ravis-booking') . '</option>
														<option value="7">7 ' . esc_html__('Children', 'ravis-booking') . '</option>
														<option value="8">8 ' . esc_html__('Children', 'ravis-booking') . '</option>
														<option value="9">9 ' . esc_html__('Children', 'ravis-booking') . '</option>
														<option value="10">10 ' . esc_html__('Children', 'ravis-booking') . '</option>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-2">
										<button type="submit" class="ravis-btn btn-type-1">
											<span class="inner-box">' . esc_html__('Book Now', 'ravis-booking') . '</span>
										</button>
									</div>
								</form>
								<div class="row room-field-tmpl">
									<div class="booking-fields col-md-4">
										<div class="room-title">' . esc_html__('Room', 'ravis-booking') . ' {{id_}} : </div>
									</div>
									<div class="booking-fields col-md-4">
										<select name="room[{{id}}][adult]" class="disable-select2">
											<option value="1">1 ' . esc_html__('Adult', 'ravis-booking') . '</option>
											<option value="2">2 ' . esc_html__('Adults', 'ravis-booking') . '</option>
											<option value="3">3 ' . esc_html__('Adults', 'ravis-booking') . '</option>
											<option value="4">4 ' . esc_html__('Adults', 'ravis-booking') . '</option>
											<option value="5">5 ' . esc_html__('Adults', 'ravis-booking') . '</option>
											<option value="6">6 ' . esc_html__('Adults', 'ravis-booking') . '</option>
											<option value="7">7 ' . esc_html__('Adults', 'ravis-booking') . '</option>
											<option value="8">8 ' . esc_html__('Adults', 'ravis-booking') . '</option>
											<option value="9">9 ' . esc_html__('Adults', 'ravis-booking') . '</option>
											<option value="10">10 ' . esc_html__('Adults', 'ravis-booking') . '</option>
										</select>
									</div>
									<div class="booking-fields col-md-4">
										<select name="room[{{id}}][child]" class="disable-select2">>
											<option value="0">' . esc_html__('No Child', 'ravis-booking') . '</option>
											<option value="1">1 ' . esc_html__('Children', 'ravis-booking') . '</option>
											<option value="2">2 ' . esc_html__('Children', 'ravis-booking') . '</option>
											<option value="3">3 ' . esc_html__('Children', 'ravis-booking') . '</option>
											<option value="4">4 ' . esc_html__('Children', 'ravis-booking') . '</option>
											<option value="5">5 ' . esc_html__('Children', 'ravis-booking') . '</option>
											<option value="6">6 ' . esc_html__('Children', 'ravis-booking') . '</option>
											<option value="7">7 ' . esc_html__('Children', 'ravis-booking') . '</option>
											<option value="8">8 ' . esc_html__('Children', 'ravis-booking') . '</option>
											<option value="9">9 ' . esc_html__('Children', 'ravis-booking') . '</option>
											<option value="10">10 ' . esc_html__('Children', 'ravis-booking') . '</option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</section>';
            }
            elseif ($ravis_booking_room_search_form_attr['layout'] === 'vertical')
            {
                $ravis_booking_room_search_form_code = '
					<div class="room-booking-form-container">
						<form class="room-booking-form ' . (!empty($ravis_booking_room_search_form_attr['class']) ? esc_attr($ravis_booking_room_search_form_attr['class']) : '') . '" action="' . esc_url(Ravis_booking_get_info::booking_page_url()) . '" method="' . esc_attr($send_info_method) . '">
							<div class="input-daterange">
								<div class="field-row">
									<input placeholder="' . esc_html__('Check in', 'ravis-booking') . '" class="datepicker-fields check-in" type="text" name="start"/>
									<i class="fa fa-calendar"></i>
								</div>
								<div class="field-row">
									<input placeholder="' . esc_html__('Check out', 'ravis-booking') . '" class="datepicker-fields check-out" type="text" name="end"/>
									<i class="fa fa-calendar"></i>
								</div>
							</div>
							<div class="field-row">
								<select name="room-count" class="room-count">
									<option value=""></option>
									<option value="1" selected="selected">1 ' . esc_html__('Room', 'ravis-booking') . '</option>
									<option value="2">2 ' . esc_html__('Rooms', 'ravis-booking') . '</option>
									<option value="3">3 ' . esc_html__('Rooms', 'ravis-booking') . '</option>
									<option value="4">4 ' . esc_html__('Rooms', 'ravis-booking') . '</option>
									<option value="5">5 ' . esc_html__('Rooms', 'ravis-booking') . '</option>
								</select>
							</div>
							<div class="room-field-container">
								<div class="field-row">
									<div class="title">' . esc_html__('Room 1 :', 'ravis-booking') . '</div>
									<select name="room[0][adult]">
										<option value="1">1 ' . esc_html__('Adult', 'ravis-booking') . '</option>
										<option value="2">2 ' . esc_html__('Adults', 'ravis-booking') . '</option>
										<option value="3">3 ' . esc_html__('Adults', 'ravis-booking') . '</option>
										<option value="4">4 ' . esc_html__('Adults', 'ravis-booking') . '</option>
										<option value="5">5 ' . esc_html__('Adults', 'ravis-booking') . '</option>
										<option value="6">6 ' . esc_html__('Adults', 'ravis-booking') . '</option>
										<option value="7">7 ' . esc_html__('Adults', 'ravis-booking') . '</option>
										<option value="8">8 ' . esc_html__('Adults', 'ravis-booking') . '</option>
										<option value="9">9 ' . esc_html__('Adults', 'ravis-booking') . '</option>
										<option value="10">10 ' . esc_html__('Adults', 'ravis-booking') . '</option>
									</select>
									<select name="room[0][child]">
										<option value="0">' . esc_html__('No Child', 'ravis-booking') . '</option>
										<option value="1">1 ' . esc_html__('Children', 'ravis-booking') . '</option>
										<option value="2">2 ' . esc_html__('Children', 'ravis-booking') . '</option>
										<option value="3">3 ' . esc_html__('Children', 'ravis-booking') . '</option>
										<option value="4">4 ' . esc_html__('Children', 'ravis-booking') . '</option>
										<option value="5">5 ' . esc_html__('Children', 'ravis-booking') . '</option>
										<option value="6">6 ' . esc_html__('Children', 'ravis-booking') . '</option>
										<option value="7">7 ' . esc_html__('Children', 'ravis-booking') . '</option>
										<option value="8">8 ' . esc_html__('Children', 'ravis-booking') . '</option>
										<option value="9">9 ' . esc_html__('Children', 'ravis-booking') . '</option>
										<option value="10">10 ' . esc_html__('Children', 'ravis-booking') . '</option>
									</select>
								</div>
							</div>
							<div class="field-row">
								<input type="submit" value="' . esc_html__('Book Now', 'ravis-booking') . '">
							</div>
						</form>
						<div class="field-row room-field-tmpl">
							<div class="title">' . esc_html__('Room', 'ravis-booking') . ' {{id_}} :</div>
							<select name="room[{{id}}][adult]" class="disable-select2">
								<option value="1">' . esc_html__('1 Adult', 'ravis-booking') . '</option>
								<option value="2">' . esc_html__('2 Adults', 'ravis-booking') . '</option>
								<option value="3">' . esc_html__('3 Adults', 'ravis-booking') . '</option>
								<option value="4">' . esc_html__('4 Adults', 'ravis-booking') . '</option>
								<option value="5">' . esc_html__('5 Adults', 'ravis-booking') . '</option>
							</select>
							<select name="room[{{id}}][child]" class="disable-select2">
								<option value="0">' . esc_html__('No Child', 'ravis-booking') . '</option>
								<option value="1">' . esc_html__('1 Children', 'ravis-booking') . '</option>
								<option value="2">' . esc_html__('2 Children', 'ravis-booking') . '</option>
								<option value="3">' . esc_html__('3 Children', 'ravis-booking') . '</option>
								<option value="4">' . esc_html__('4 Children', 'ravis-booking') . '</option>
								<option value="5">' . esc_html__('5 Children', 'ravis-booking') . '</option>
							</select>
						</div>
					</div>';
            }

            return balancetags($ravis_booking_room_search_form_code);
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Generate Room Listings
         * ------------------------------------------------------------------------------------------
         */
        public function ravis_booking_other_rooms($attr)
        {
            $ravis_booking_room_listing_attr = shortcode_atts(array(
                'title'    => '',
                'subtitle' => '',
                'post_id'  => '',
                'order'    => '',
                'count'    => -1,
            ), $attr);

            if (!empty($ravis_booking_room_listing_attr['order']))
            {
                switch ($ravis_booking_room_listing_attr['order'])
                {
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
                'posts_per_page' => $ravis_booking_room_listing_attr['count'],
                'post__not_in'   => array((!empty($ravis_booking_room_listing_attr['post_id']) ? $ravis_booking_room_listing_attr['post_id'] : '')),
            );

            $ravis_booking_room_query = new WP_Query($args);

            $get_info_obj = new ravis_booking_get_info();

            $ravis_booking_room_listing_code = '
				<section id="rooms-section">
					<div class="inner-container container">';

            if (!empty($ravis_booking_room_listing_attr['title']) || !empty($ravis_booking_room_listing_attr['subtitle']))
            {
                $ravis_booking_room_listing_code .= '
						<div class="ravis-title">
							<div class="inner-box">
								<div class="title">' . esc_html($ravis_booking_room_listing_attr['title']) . '</div>
								<div class="sub-title">' . esc_html($ravis_booking_room_listing_attr['subtitle']) . '</div>
							</div>
						</div>';
            }

            if ($ravis_booking_room_query->have_posts())
            {
                $ravis_booking_room_listing_code .= '<div class="room-container clearfix">';

                $room_i = 0;

                while ($ravis_booking_room_query->have_posts())
                {
                    $ravis_booking_room_query->the_post();
                    $post_id   = get_the_ID();
                    $room_info = $get_info_obj->room_info($post_id);

                    $ravis_booking_room_listing_code .= '
						<div class="room-box col-xs-6 col-md-4 animated-box" data-animation="fadeInUp" data-delay="' . esc_attr(($room_i % 3) * 300) . '">
							<div class="inner-box">
                                <div class="room-img">';
                    if (empty($this->ravis_booking_option['listing_image_slider']))
                    {
                        $ravis_booking_room_listing_code .= '<a href="' . esc_url($room_info['url']) . '" class="cover-link"></a>';
                    }
                    $ravis_booking_room_listing_code .= '<div class="img-container">';
                    if ($room_info['gallery']['count'] > 0)
                    {
                        $img_gallery_i = 0;
                        foreach ($room_info['gallery']['img'] as $img_item)
                        {
                            if (empty($this->ravis_booking_option['listing_image_slider']) && $img_gallery_i > 0)
                            {
                                continue;
                            }
                            $ravis_booking_room_listing_code .= '<div class="img-box" data-bg-img="' . esc_url($img_item['url']) . '"></div>';
                            $img_gallery_i++;
                        }
                    }
                    else
                    {
                        $ravis_booking_room_listing_code .= '<div class="img-box no-img"></div>';
                    }

                    $ravis_booking_room_listing_code .= '
									</div>
								</div>
								<div class="caption">
									<div class="title"><a href="' . esc_url($room_info['url']) . '">' . esc_html($room_info['title']) . '</a></div>
									<div class="price">
										<div class="title">' . esc_html__('Starting from :', 'ravis-booking') . '</div>
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

                $ravis_booking_room_listing_code .= '</div>';
            }
            else
            {
                $ravis_booking_room_listing_code .= esc_html__('There is not any rooms here.', 'ravis-booking');
            }

            $ravis_booking_room_listing_code .= '
					</div>
				</section>';
            wp_reset_postdata();

            return balancetags($ravis_booking_room_listing_code);
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Generate Room Rating Section
         * ------------------------------------------------------------------------------------------
         */
        public function ravis_booking_room_rating($attr)
        {
            $ravis_booking_room_rating_attr = shortcode_atts(array(
                'title'    => '',
                'subtitle' => '',
                'room_id'  => '',
            ), $attr);
            $get_inf_obj                    = new Ravis_booking_get_info();
            $room_id                        = !empty($ravis_booking_room_rating_attr['room_id']) ? Ravis_booking_get_info::original_post_id($ravis_booking_room_rating_attr['room_id']) : '';
            $room_info                      = $get_inf_obj->room_info($room_id);

            $plugin_options = get_option('ravis-booking-setting');

            if (empty($this->ravis_booking_option['rating_status']))
            {
                $ravis_booking_room_rating_code = esc_html__('Rating system is not enabled. Please check your settings.', 'ravis-booking');
            }
            else
            {
                $ravis_booking_room_rating_code = '<div class="room-rating">';

                if (!empty($ravis_booking_room_rating_attr['title']))
                {
                    $ravis_booking_room_rating_code .= '
						<div class="ravis-title-t-2">
							<div class="title"><span>' . esc_html($ravis_booking_room_rating_attr['title']) . '</span></div>';

                    if (!empty($ravis_booking_room_rating_attr['subtitle']))
                    {
                        $ravis_booking_room_rating_code .= '<div class="sub-title">' . esc_html($ravis_booking_room_rating_attr['subtitle']) . '</div>';
                    }

                    $ravis_booking_room_rating_code .= '</div>';
                }

                if (is_user_logged_in())
                {
                    wp_enqueue_script('barrating-js', RAVIS_BOOKING_JS_PATH . 'jquery.barrating.min.js', array('jquery'), RAVIS_BOOKING_VERSION, true);
                    $rating_post_meta_txt = 'ravis_booking_room_rating';
                    $rate_meta            = get_post_meta($room_id, $rating_post_meta_txt, true);
                    $current_user_info    = wp_get_current_user();
                    $current_user_id      = $current_user_info->ID;

                    $ravis_booking_room_rating_code .= '<div class="rate-box-container">';

                    foreach ($plugin_options['rating_item'] as $rate_index => $rating_item)
                    {
                        $ravis_booking_room_rating_code .= '
						<div class="rate-box">
							<div class="title">' . esc_html($rating_item) . '</div>
							<div class="progress">
							<select class="rate-items disable-select2" data-security="' . wp_create_nonce('ravis-rating-item') . '" name="rate_' . esc_attr($rate_index) . '" data-room-id="' . esc_attr($room_id) . '">';

                        for ($i = 0; $i < 11; $i++)
                        {
                            $i_counter                      = $i * 10;
                            $ravis_booking_room_rating_code .= '<option value="' . esc_attr($i_counter) . '"';

                            if (!empty($rate_meta[ $current_user_id ][ $room_id ][ $rate_index ]))
                            {
                                $ravis_booking_room_rating_code .= selected($i_counter, $rate_meta[ $current_user_id ][ $room_id ][ $rate_index ], false);
                            }

                            $ravis_booking_room_rating_code .= '>' . esc_html($i_counter . '%') . '</option>';
                        }

                        $ravis_booking_room_rating_code .= '</select>
								</div>
							<div class="message-box"></div>
						</div>';
                    }

                    $ravis_booking_room_rating_code .= '</div>';
                }
                else
                {
                    $ravis_booking_room_rating_code .= '
						<div class="rate-box-container">';

                    if (!empty($room_info['rate']))
                    {
                        foreach ($plugin_options['rating_item'] as $rate_index => $rate_title)
                        {
                            $current_rate_val = 0;

                            if (!empty($room_info['rate'][ $rate_index ]) && !empty($room_info['rate'][ $rate_index ]['count']))
                            {
                                $current_rate_val = ($room_info['rate'][ $rate_index ]['value'] / $room_info['rate'][ $rate_index ]['count']);
                            }

                            $ravis_booking_room_rating_code .= '
							<div class="rate-box">
								<div class="title">' . esc_html($rate_title) . '</div>
								<div class="progress">
									<div class="progress-bar" role="progressbar" aria-valuenow="' . esc_attr($current_rate_val) . '" aria-valuemin="0"
										 aria-valuemax="100" style="width: ' . esc_attr($current_rate_val) . '%"><span>' . esc_html($current_rate_val) . '%</span></div>
								</div>
							</div>';
                        }
                    }

                    $ravis_booking_room_rating_code .= '
						</div>
					</div>';
                }
            }

            return balancetags($ravis_booking_room_rating_code);
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Generate Currency Switcher
         * ------------------------------------------------------------------------------------------
         */
        public function ravis_booking_currency_switcher($attr)
        {
            $ravis_booking_currency_switcher_attr = shortcode_atts(array(
                'class' => '',
            ), $attr);

            $currency_currency = !empty($_COOKIE['currencyTitle']) && is_string($_COOKIE['currencyTitle']) ? $_COOKIE['currencyTitle'] : '';

            $random_id = 'currency-switcher-select-' . random_int(10000, 100000);

            $options_code = '';

            if (is_array($this->ravis_booking_option['currency']))
            {
                foreach ($this->ravis_booking_option['currency'] as $index => $currency)
                {
                    if ($index == $this->ravis_booking_option['default_currency'])
                    {
                        $first_options = '<option value="' . esc_attr($currency['title']) . '" ' . selected($currency['title'], $currency_currency, false) . '>' . esc_attr($currency['title']) . '</option>';
                    }
                    else
                    {
                        $options_code .= '<option value="' . esc_attr($currency['title']) . '" ' . selected($currency['title'], $currency_currency, false) . '>' . esc_attr($currency['title']) . '</option>';
                    }
                }
            }

            $ravis_booking_currency_switcher = '<select id="' . esc_attr($random_id) . '" ' . (!empty($ravis_booking_currency_switcher_attr['class']) ? wp_kses_post('class="' . $ravis_booking_currency_switcher_attr['class'] . '"') : '') . '>' . balanceTags($first_options . $options_code) . '</select>';

            return balancetags($ravis_booking_currency_switcher);
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Generate the contact section
         * ------------------------------------------------------------------------------------------
         */
        public function ravis_booking_contact($attr)
        {
            include_once ABSPATH . 'wp-admin/includes/plugin.php';
            /**
             * Ravis Booking Contact Section Attribute
             */
            $ravis_booking_contact_attr = shortcode_atts(array(
                'title'       => '',
                'subtitle'    => '',
                'description' => '',
            ), $attr);

            $rand_i                     = rand(10, 100);
            $ravis_booking_contact_code = '
				<section id="contact-section">
				<div class="inner-container container">
					<div class="t-sec">
						<div class="content">
						<div class="ravis-title-t-2">
							<div class="title"><span>' . esc_html($ravis_booking_contact_attr['title']) . '</span></div>
							<div class="sub-title">' . esc_html($ravis_booking_contact_attr['subtitle']) . '</div>
						</div>
							' . (!empty($ravis_booking_contact_attr['description']) ? esc_html($ravis_booking_contact_attr['description']) : '') . '
						</div>
						<div class="contact-info">';

            if (get_theme_mod('colosseum_option_contact_address'))
            {
                $ravis_booking_contact_code .= '
									<div class="contact-inf-box">
										<div class="icon-box">
											<i class="fa fa-home"></i>
										</div>
										<div class="text">' . esc_html(get_theme_mod('colosseum_option_contact_address')) . '</div>
									</div>';
            }

            if (get_theme_mod('colosseum_option_contact_email'))
            {
                $ravis_booking_contact_code .= '
										<div class="contact-inf-box">
											<div class="icon-box">
												<i class="fa fa-envelope"></i>
											</div>
											<div class="text">' . esc_html(get_theme_mod('colosseum_option_contact_email')) . '</div>
										</div>';
            }

            if (get_theme_mod('colosseum_option_contact_email'))
            {
                $ravis_booking_contact_code .= '
									<div class="contact-inf-box">
										<div class="icon-box">
											<i class="fa fa-phone"></i>
										</div>
										<div class="text">' . esc_html(get_theme_mod('colosseum_option_contact_phone')) . '</div>
									</div>';
            }

            $ravis_booking_contact_code .= '
						</div>
					</div>
					<div class="b-sec clearfix">
						<div class="contact-form col-md-6">';
            $contact7_id                = get_theme_mod('colosseum_option_contact7_id');

            if (is_plugin_active('contact-form-7/wp-contact-form-7.php') && !empty($contact7_id))
            {
                if (function_exists('icl_object_id'))
                {
                    if (strpos($contact7_id, '||'))
                    {
                        $contact_languages = explode('||', $contact7_id);
                        $lang_i            = 0;
                        $has_lang          = false;

                        foreach ($contact_languages as $lang_item)
                        {
                            $language_parts = explode(':', $lang_item);

                            if ($lang_i === 0)
                            {
                                $first_lang_form = $language_parts[1];
                            }

                            if (ICL_LANGUAGE_CODE == $language_parts[0])
                            {
                                $has_lang    = true;
                                $contact7_id = $language_parts[1];
                                break;
                            }

                            $lang_i++;
                        }

                        if ($has_lang === false)
                        {
                            $contact7_id = $first_lang_form;
                        }
                    }
                }

                $ravis_booking_contact_code .= do_shortcode('[contact-form-7 id="' . esc_html($contact7_id) . '"]');
            }

            $ravis_booking_contact_code .= '
						</div>
						<div id="google-map" class="col-md-6"></div>
					</div>
				</div>
			</section>';

            $map_lat          = get_theme_mod('colosseum_option_map_lat', 40.6700);
            $map_lng          = get_theme_mod('colosseum_option_map_lng', -73.9400);
            $map_zoom         = get_theme_mod('colosseum_option_map_zoom', 15);
            $map_marker       = get_theme_mod('colosseum_option_map_marker', RAVIS_BOOKING_IMG_PATH . 'marker.png');
            if (strpos($map_marker, RAVIS_BOOKING_IMG_PATH) < -1)
            {
                $img_meta_info = wp_get_attachment_metadata($this->colosseum_get_image_id($map_marker));
                $marker_size   = array($img_meta_info['width'], $img_meta_info['height']);
            }
            else
            {
                $marker_size = array('147', '74');
            }

            $contact_map_code = '
            var centerLoc = [ ' . $map_lat . ', ' . $map_lng . ' ],
                map = L.map( "google-map" ).setView( centerLoc, ' . $map_zoom . ' ),
                markerIcon = L.icon(
                {
                    iconUrl: "' . $map_marker . '",
                    iconSize: [ ' . $marker_size[0] . ', ' . $marker_size[1] . ' ],
                    iconAnchor: [ ' . ($marker_size[0] / 2) . ', ' . $marker_size[1] . ' ],
                } ),
                marker = L.marker( centerLoc,{ icon: markerIcon } ).addTo( map );
                L.tileLayer( "https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw",
                {';
            switch (get_theme_mod('colosseum_option_map_style', 1))
                {
                    case '1':
                        $contact_map_code .= 'id: "mapbox.dark",';
                    break;
                    case '2':
                        $contact_map_code .= 'id: "mapbox.light",';
                    break;
                    case '3':
                        $contact_map_code .= 'id: "mapbox.streets",';
                    break;
                }
            $contact_map_code .= '
                    maxZoom: 20
                } ).addTo( map )
            ';

            wp_enqueue_style('contact-map-css', RAVIS_BOOKING_CSS_PATH . 'leaflet.min.css');
            wp_enqueue_script('contact-map', RAVIS_BOOKING_JS_PATH . 'leaflet.js', array(), get_bloginfo('version'), true);
            wp_add_inline_script('contact-map', $contact_map_code);

            return balancetags($ravis_booking_contact_code);
        }

        /**
         * ------------------------------------------------------------------------------------------
         *  Generate Booking Overview Section
         * ------------------------------------------------------------------------------------------
         */
        public function ravis_booking_booking_overview($attr)
        {
            /**
             * Ravis Booking Overview Attribute
             */
            $ravis_booking_overview_attr = shortcode_atts(array(
                'room_id' => '',
                'class'   => '',
            ), $attr);

            $rand_digit = rand(1, 10000);
            $room_id    = !empty($ravis_booking_overview_attr['room_id']) ? Ravis_booking_get_info::original_post_id($ravis_booking_overview_attr['room_id']) : '';

            $ravis_booking_overview_content = '
				<div id="booking-overview-section">
					<div class="inner-container ' . (!empty($ravis_booking_overview_attr['class']) ? esc_attr($ravis_booking_overview_attr['class']) : '') . '">
						<div id="overview-calendar-' . esc_attr($rand_digit) . '" ' . (!empty($$room_id) ? ' class="single-room-calendar"' : '') . '>';

            if (!empty($room_id))
            {
                $ravis_booking_overview_content .= '
									<div class="day-status-guide">
										<div class="status-box">
											<div class="box not-available"></div>
											<div class="title">' . esc_html__('Not Available', 'ravis-booking') . '</div>
										</div>
										<div class="status-box">
											<div class="box available"></div>
											<div class="title">' . esc_html__('Available', 'ravis-booking') . '</div>
										</div>
										<div class="status-box">
											<div class="box today">1</div>
											<div class="title">' . esc_html__('Today', 'ravis-booking') . '</div>
										</div>
									</div>
								';
            }

            $ravis_booking_overview_content .= '
						</div>
					</div>
				</div>
			';

            wp_enqueue_script('moment-js', RAVIS_BOOKING_JS_PATH . 'moment.min.js', array('jquery'), get_bloginfo('version'), true);
            wp_enqueue_script('fullcalendar-js', RAVIS_BOOKING_JS_PATH . 'fullcalendar.min.js', array(
                'jquery',
                'moment-js',
            ), get_bloginfo('version'), true);

            $web_current_locale = 'en';

            if (get_locale() !== 'en_US')
            {
                if (file_exists(RAVIS_BOOKING_PATH . 'assets/js/locales.php'))
                {
                    require RAVIS_BOOKING_PATH . 'assets/js/locales.php';
                }

                $web_current_locale = isset($plugin_locales[ get_locale() ]) ? $plugin_locales[ get_locale() ] : 'en';
                wp_enqueue_script('fullcalendar-locales-js', RAVIS_BOOKING_JS_PATH . 'locale/' . $web_current_locale . '.js', array('jquery'), RAVIS_BOOKING_VERSION, true);
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
											action:     "' . (!empty($room_id) ? esc_html('ravis_booking_room_overview') : esc_html('ravis_booking_booking_overview')) . '",
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

            if (get_locale() !== 'en_US')
            {
                wp_add_inline_script('fullcalendar-locales-js', $full_calendar_js_codes);
            }
            else
            {
                wp_add_inline_script('fullcalendar-js', $full_calendar_js_codes);
            }

            return balancetags($ravis_booking_overview_content);
        }

        public function colosseum_get_image_id($image_url)
        {
            global $wpdb;
            $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url));

            return $attachment[0];
        }
    }

    $ravis_shortcode_obj = new Ravis_booking_plg_shortcode;
