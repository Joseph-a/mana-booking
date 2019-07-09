<?php
	/**
	 *  Guest Book
	 *  Template Name: Guest Book
	 */
	global $post, $wp_query;
	get_header();
	
	$info_obj                 = new Ravis_booking_get_info();
	$paged                    = $wp_query->query_vars['paged'];
	$args                     = array (
		'post_type'      => 'testimonials',
		'post_status'    => 'publish',
		'order'          => 'DESC',
		'orderby'        => 'date',
		'paged'          => $paged,
		'posts_per_page' => get_option( 'posts_per_page' )
	);
	$ravis_booking_testimonial_query = new WP_Query( $args );
?>
	<section id="guest-book">
		<div class="inner-container container">
			<?php
				echo do_shortcode('[ravis-booking-testimonial-form title="'. esc_html__('Share Your Experience', 'ravis-booking') .'" subtitle="'. esc_html__('Let us know your testimonials', 'ravis-booking') .'" class="col-md-4"]');
				if ( $ravis_booking_testimonial_query->have_posts() )
				{
					while ( $ravis_booking_testimonial_query->have_posts() )
					{
						$ravis_booking_testimonial_query->the_post();
						$post_id          = get_the_ID();
						$testimonial_info = $info_obj->testimonials_info( $post_id );
						
						echo '
							<div class="guest-book-item col-md-4">
								<div class="inner-box">
									<div class="ravis-title-t-2">
										<div class="title"><span>'. esc_html($testimonial_info['title']) .'</span></div>
									</div>
									<div class="content">'. esc_html($testimonial_info['description']['main']) .'</div>
									<cite>'. esc_html($testimonial_info['guest_name']) .'</cite>
								</div>
							</div>
						';
					}
					wp_reset_query();
				}
			?>
		</div>
		<?php Ravis_booking_main::ravis_booking_pagination( $ravis_booking_testimonial_query ); ?>
	</section>
<?php
	get_footer();