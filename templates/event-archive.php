<?php
	/**
	 *  Event Archive Page
	 *  Template Name: Event Archive
	 */
	global $post, $wp_query;
	get_header();
	
	$info_obj                  = new Ravis_booking_get_info();
	$paged                     = $wp_query->query_vars['paged'];
	$args                      = array (
		'post_type'      => 'events',
		'post_status'    => 'publish',
		'order'          => 'DESC',
		'orderby'        => 'date',
		'paged'          => $paged,
		'posts_per_page' => get_option( 'posts_per_page' )
	);
	$ravis_booking_event_query = new WP_Query( $args );
	
	echo '
		<section id="upcoming-events">
			<div class="inner-container container">';
	if ( $ravis_booking_event_query->have_posts() )
	{
		echo '
				<div class="event-container">
					<ul class="event-main-box clearfix">';
		$event_i  = 0;
		$events_i = 0;
		while ( $ravis_booking_event_query->have_posts() )
		{
			$ravis_booking_event_query->the_post();
			$post_id     = get_the_ID();
			$events_info = $info_obj->event_info( $post_id );
			
			echo '
				<li class="item col-xs-6 col-md-' . ( 4 * $events_info['box_col'] ) . ' ' . ( $events_info['box_col'] === 1 ? esc_attr( 'small-box' ) : '' ) . '">
					<figure>';
			if ( ! empty( $events_info['gallery']['count'] ) )
			{
				echo $events_info['gallery']['img'][0]['code']['full'];
			}
			echo '
						<figcaption>
							<a href="' . esc_url( $events_info['url'] ) . '">
								<span class="title-box">
									<span class="title">' . esc_html( $events_info['title'] ) . '</span>
									<span class="sub-title">' . esc_html( $events_info['subtitle'] ) . '</span>
								</span>
								<span class="desc">' . esc_html( $events_info['description']['short'] ) . '</span>
							</a>
						</figcaption>
					</figure>
				</li>';
			
			$events_i ++;
		}
		
		echo '
					</ul>
				</div>';
		
		wp_reset_query();
	}
	else
	{
		$ravis_booking_event_code .= esc_html__( 'There is not any event here.', 'ravis-booking' );
	}
	echo '</div>';
	Ravis_booking_main::ravis_booking_pagination( $ravis_booking_event_query );
	echo '</section>';
	
	
	get_footer();