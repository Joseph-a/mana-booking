<?php
	/**
	 *  Staff Archive Page
	 *  Template Name: Staff Archive
	 */
	global $post, $wp_query;
	get_header();
	
	$info_obj                  = new Ravis_booking_get_info();
	$paged                     = $wp_query->query_vars['paged'];
	$args                      = array (
		'post_type'      => 'staff',
		'post_status'    => 'publish',
		'order'          => 'DESC',
		'orderby'        => 'date',
		'paged'          => $paged,
		'posts_per_page' => get_option( 'posts_per_page' )
	);
	$ravis_booking_staff_query = new WP_Query( $args );
	
	echo '
				<section id="staff-section">
					<div class="inner-container container">
						<div class="row staff-row">';
	
	if ( $ravis_booking_staff_query->have_posts() )
	{
		$staff_i = 0;
		while ( $ravis_booking_staff_query->have_posts() )
		{
			if ( ( $staff_i % 2 == 0 ) && $staff_i !== 0 )
			{
				echo '</div><div class="row staff-row">';
			}
			
			$ravis_booking_staff_query->the_post();
			$post_id    = get_the_ID();
			$staff_info = $info_obj->staff_info( $post_id );
			
			echo '
						<div class="staff-box col-md-6 animated-box" data-animation="' . ( $staff_i % 2 == 1 ? esc_attr( 'fadeInRight' ) : esc_attr( 'fadeInLeft' ) ) . '">
							<div class="staff-box-inner">
								<div class="inner-box">
									<div class="staff-img col-md-6">';
			
			if ( $staff_info['has_image'] )
			{
				echo $staff_info['img']['full'];
			}
			
			echo '</div>
									<div class="staff-info col-md-6">
										<div class="ravis-title-t-1">
											<div class="title"><span>' . esc_html( $staff_info['title'] ) . '</span></div>
											<div class="sub-title">' . esc_html( $staff_info['position'] ) . '</div>
										</div>
										<div class="desc">' . esc_html( $staff_info['description']['main'] ) . '</div>
										<div class="social-icons">
											<ul class="list-inline">';
			
			if ( ! empty( $staff_info['email'] ) )
			{
				echo '<li><a href="' . esc_url( $staff_info['email'] ) . '"><i class="fa fa-envelope"></i></a></li>';
			}
			if ( ! empty( $staff_info['skype'] ) )
			{
				echo '<li><a href="' . esc_url( $staff_info['skype'] ) . '"><i class="fa fa-facebook"></i></a></li>';
			}
			if ( ! empty( $staff_info['facebook'] ) )
			{
				echo '<li><a href="' . esc_url( $staff_info['facebook'] ) . '"><i class="fa fa-twitter"></i></a></li>';
			}
			if ( ! empty( $staff_info['twitter'] ) )
			{
				echo '<li><a href="' . esc_url( $staff_info['twitter'] ) . '"><i class="fa fa-google-plus"></i></a></li>';
			}
			if ( ! empty( $staff_info['google_plus'] ) )
			{
				echo '<li><a href="' . esc_url( $staff_info['google_plus'] ) . '"><i class="fa fa-skype"></i></a></li>';
			}
			
			echo '
											</ul>
										</div>
									</div>
									<div class="clear-box"></div>
								</div>
							</div>
						</div>';
			
			$staff_i ++;
			
			if ( $staff_i === $ravis_booking_staff_query->post_count )
			{
				echo '</div>';
			}
		}
		wp_reset_query();
	}
	else
	{
		echo esc_html__( 'You have not set any staff for your hotel.', 'ravis-booking' );
	}
	echo '</div>';
	
	Ravis_booking_main::ravis_booking_pagination( $ravis_booking_staff_query );
	
	echo '</section>';
	
	
	get_footer();