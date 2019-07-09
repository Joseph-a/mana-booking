<?php
	/**
	 *  Package Archive Page
	 *  Template Name: Package Archive
	 */
	global $post, $wp_query;
	get_header();
	
	$info_obj                    = new Ravis_booking_get_info();
	$paged                       = $wp_query->query_vars['paged'];
	$args                        = array (
		'post_type'      => 'packages',
		'post_status'    => 'publish',
		'order'          => 'DESC',
		'orderby'        => 'date',
		'paged'          => $paged,
		'posts_per_page' => get_option( 'posts_per_page' )
	);
	$ravis_booking_package_query = new WP_Query( $args );
	
	
	if ( $ravis_booking_package_query->have_posts() )
	{
		echo '
			<section id="special-offers">
				<div class="inner-container container">
					<div class="packages-container clearfix">';
		if ( $ravis_booking_package_query->have_posts() )
		{
			$package_i = 0;
			while ( $ravis_booking_package_query->have_posts() )
			{
				$ravis_booking_package_query->the_post();
				$post_id      = get_the_ID();
				$package_info = $info_obj->package_info( $post_id );
				
				echo '
							
				<div class="package-box col-sm-6 col-md-4">
					<div class="main-inner-box" data-bg-img="' . esc_url( $package_info['img']['full']['url'] ) . '">
						<div class="title-box">
							<div class="title">' . esc_html( $package_info['title'] ) . '</div>
							<div class="sub-title">' . esc_html( $package_info['subtitle'] ) . '</div>
						</div>
						<div class="price-box">
							<div class="price">' . esc_html( $package_info['price']['generated'] ) . '</div>
							<div class="type">' . esc_html__( 'Per Night', 'ravis-booking' ) . '</div>
						</div>
						<div class="detail-box">';
				if ( ! empty( $package_info['items'] ) )
				{
					echo '<ul>';
					foreach ( $package_info['items'] as $item )
					{
						if ( ! empty( $item['title'] ) )
						{
							echo '<li><div class="inner-box">' . esc_html( $item['title'] ) . '</div></li>';
						}
					}
					echo '</ul>';
				}
				echo '
							</div>
							<a href="' . esc_url( $package_info['book_url'] ) . '" class="ravis-btn btn-type-2">' . esc_html__( 'Select', 'ravis-booking' ) . '</a>
						</div>
				</div>';
				
				$package_i ++;
			}
			
			echo '</section>';
		}
		else
		{
			$ravis_booking_package_code .= esc_html__( 'You have not set any packages for your hotel.', 'ravis-booking' );
		}
		echo '
				</div>
			</div>
		</section>';
		
		wp_reset_query();
	}
	else
	{
		echo esc_html__( 'You have not set any packages for your hotel.', 'ravis-booking' );
	}
	Ravis_booking_main::ravis_booking_pagination( $ravis_booking_package_query );
	
	
	get_footer();