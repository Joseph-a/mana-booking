<?php
    /**
     *  Room Archive Page
     *  Template Name: Room Archive
     */
    global $post, $wp_query;
    get_header();

    $options                  = get_option('ravis-booking-setting');
    $room_info_obj            = new Ravis_booking_get_info();
    $archive_pg_template      = (!empty($options['archive_page_layout']) ? esc_attr($options['archive_page_layout']) : '1');
    $paged                    = $wp_query->query_vars['paged'];
    $args                     = array(
        'post_type'      => 'rooms',
        'post_status'    => 'publish',
        'order'          => 'DESC',
        'orderby'        => 'date',
        'paged'          => $paged,
        'posts_per_page' => get_option('posts_per_page')
    );
    $ravis_booking_room_query = new WP_Query($args);
?>
	<section id="rooms-section" <?php echo($archive_pg_template === '2' ? wp_kses_post('class="row-view"') : '') ?>>
		<div class="inner-container container">
			<div class="room-container clearfix">
				<?php
                    if ($ravis_booking_room_query->have_posts())
                    {
                        $room_i = 0;
                        while ($ravis_booking_room_query->have_posts())
                        {
                            $ravis_booking_room_query->the_post();
                            $post_id   = get_the_ID();
                            $room_info = $room_info_obj->room_info($post_id);

                            if ($archive_pg_template === '1')
                            {
                                echo '
									<div class="room-box col-xs-6 col-md-4 animated-box" data-animation="fadeInUp" data-delay="' . esc_attr(($room_i % 3) * 300) . '">
										<div class="inner-box">
                                            <div class="room-img">';
                                if (empty($options['listing_image_slider']))
                                {
                                    echo '<a href="' . esc_url($room_info['url']) . '" class="cover-link"></a>';
                                }
                                echo '<div class="img-container">';
                                if ($room_info['gallery']['count'] > 0)
                                {
                                    $img_gallery_i = 0;
                                    foreach ($room_info['gallery']['img'] as $img_item)
                                    {
                                        if (empty($options['listing_image_slider']) && $img_gallery_i > 0)
                                        {
                                            continue;
                                        }
                                        echo '<div class="img-box" data-bg-img="' . esc_url($img_item['url']) . '"></div>';
                                        $img_gallery_i++;
                                    }
                                }
                                else
                                {
                                    echo '<div class="img-box no-img"></div>';
                                }
                                echo '
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
                            elseif ($archive_pg_template === '2')
                            {
                                echo '
									<div class="room-box row animated-box" data-animation="fadeInUp">
                                        <div class="col-md-4 room-img">';
                                if (empty($options['listing_image_slider']))
                                {
                                    echo '<a href="' . esc_url($room_info['url']) . '" class="cover-link"></a>';
                                }
                                echo'<div class="img-container">';
                                if ($room_info['gallery']['count'] > 0)
                                {
                                    $img_gallery_i = 0;
                                    foreach ($room_info['gallery']['img'] as $img_item)
                                    {
                                        if (empty($options['listing_image_slider']) && $img_gallery_i > 0)
                                        {
                                            continue;
                                        }
                                        echo '<div class="img-box" data-bg-img="' . esc_url($img_item['url']) . '"></div>';
                                        $img_gallery_i++;
                                    }
                                }
                                else
                                {
                                    echo '<div class="img-box no-img"></div>';
                                }
                                echo '
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
                                    echo '
										<li class="col-md-6">
											<div class="title">' . esc_html__('View :', 'ravis-booking') . '</div>
											<div class="value">' . esc_html($room_info['room_view']) . '</div>
										</li>';
                                }
                                if (!empty($room_info['room_size']['qnt']))
                                {
                                    echo '
										<li class="col-md-6">
											<div class="title">' . esc_html__('Room Size :', 'ravis-booking') . '</div>
											<div class="value">' . esc_html($room_info['room_size']['qnt']) . ' ' . wp_kses_post($room_info['room_size']['unit']) . '</div>
										</li>';
                                }

                                if (!empty($room_info['max_people']))
                                {
                                    echo '
										<li class="col-md-6">
											<div class="title">' . esc_html__('Max People :', 'ravis-booking') . '</div>
											<div class="value">' . esc_html($room_info['max_people']) . '</div>
										</li>';
                                }
                                if (!empty($room_info['service']))
                                {
                                    foreach ($room_info['service'] as $service)
                                    {
                                        echo '
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

                                    echo '
										<li class="col-md-12">
											<div class="title">' . esc_html__('Facilities :', 'ravis-booking') . '</div>
											<div class="value">' . esc_html($facility_str) . '</div>
										</li>';
                                }
                                echo '
													</ul>
												</div>
												<a href="' . esc_url($room_info['url']) . '" class="more-info">' . esc_html__('More Info', 'ravis-booking') . '</a>
											</div>
											<div class="col-md-6 desc">' . esc_html($room_info['description']['short']) . '</div>
										</div>
									</div>';
                            }

                            $room_i++;
                        }
                    }
                    wp_reset_postdata();
                ?>
			</div>

			<?php Ravis_booking_main::ravis_booking_pagination($ravis_booking_room_query); ?>
		</div>
	</section>
<?php
    get_footer();
