<?php
	if ( ! defined( 'ABSPATH' ) )
	{
		die( 'Your are in wrong place.' );
	}
	define( 'RAVIS_BOOKING_SHORTCODE_WIZARD', true );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<form action="#" id="shortcode-form">
		<div class="button-container">
			<input type="submit" value="<?php esc_html_e( 'Insert', 'ravis-booking' ); ?>">
		</div>
		<div class="inner-container">
			<div class="rows" id="shortcode-item-container">
				<label for="shortcode-item"><?php esc_html_e( 'ShortCode : ', 'ravis-booking' ); ?></label>
				<select name="shortcode-item" id="shortcode-item" class="disable-select2">
					<option value="0"><?php esc_html_e( 'Select a shortcode', 'ravis-booking' ); ?></option>
					<option value="ravis-booking-main-slider"><?php esc_html_e( 'Main Slider', 'ravis-booking' ) ?></option>
					<option value="ravis-booking-text-section"><?php esc_html_e( 'Text Section', 'ravis-booking' ) ?></option>
					<option value="ravis-booking-gallery"><?php esc_html_e( 'Gallery', 'ravis-booking' ) ?></option>
					<option value="ravis-booking-gallery-slideshow"><?php esc_html_e( 'Gallery Slideshow', 'ravis-booking' ) ?></option>
					<option value="ravis-booking-special-rooms"><?php esc_html_e( 'Special Rooms', 'ravis-booking' ) ?></option>
					<option value="ravis-booking-testimonials"><?php esc_html_e( 'Testimonials', 'ravis-booking' ) ?></option>
					<option value="ravis-booking-hotel-section"><?php esc_html_e( 'Hotel Section', 'ravis-booking' ) ?></option>
					<option value="ravis-booking-package"><?php esc_html_e( 'Package', 'ravis-booking' ) ?></option>
					<option value="ravis-booking-video-tour"><?php esc_html_e( 'Video Tour', 'ravis-booking' ) ?></option>
					<option value="ravis-booking-timeline"><?php esc_html_e( 'Timeline', 'ravis-booking' ) ?></option>
					<option value="ravis-booking-services"><?php esc_html_e( 'Services', 'ravis-booking' ) ?></option>
					<option value="ravis-booking-clients"><?php esc_html_e( 'Clients', 'ravis-booking' ) ?></option>
					<option value="ravis-booking-staff"><?php esc_html_e( 'Staff', 'ravis-booking' ) ?></option>
					<option value="ravis-booking-promo"><?php esc_html_e( 'Promo', 'ravis-booking' ) ?></option>
					<option value="ravis-booking-social-icons"><?php esc_html_e( 'Social Icons', 'ravis-booking' ) ?></option>
					<option value="ravis-booking-dishes"><?php esc_html_e( 'Dishes', 'ravis-booking' ) ?></option>
					<option value="ravis-booking-menu"><?php esc_html_e( 'Menu', 'ravis-booking' ) ?></option>
					<option value="ravis-booking-testimonial-form"><?php esc_html_e( 'Testimonial Form', 'ravis-booking' ) ?></option>
					<option value="ravis-booking-upcoming-events"><?php esc_html_e( 'Upcoming Events', 'ravis-booking' ) ?></option>
					<option value="ravis-booking-past-events"><?php esc_html_e( 'Past Events', 'ravis-booking' ) ?></option>
					<option value="ravis-booking-other-events"><?php esc_html_e( 'Other Events', 'ravis-booking' ) ?></option>
					<option value="ravis-booking-event-booking"><?php esc_html_e( 'Event Booking', 'ravis-booking' ) ?></option>
					<option value="ravis-booking-room-listing"><?php esc_html_e( 'Room Listing', 'ravis-booking' ) ?></option>
					<option value="ravis-booking-room-search-form"><?php esc_html_e( 'Room Search Form', 'ravis-booking' ) ?></option>
					<option value="ravis-booking-other-rooms"><?php esc_html_e( 'Other Rooms', 'ravis-booking' ) ?></option>
					<option value="ravis-booking-room-rating"><?php esc_html_e( 'Room Rating', 'ravis-booking' ) ?></option>
					<option value="ravis-booking-currency-switcher"><?php esc_html_e( 'Currency Switcher', 'ravis-booking' ) ?></option>
					<option value="ravis-booking-contact"><?php esc_html_e( 'Contact Section', 'ravis-booking' ) ?></option>
					<option value="ravis-booking-booking-overview"><?php esc_html_e( 'Booking Overview', 'ravis-booking' ) ?></option>
				</select>
				<div class="hint"><?php esc_html_e( 'Please select the shortcode you want to add.', 'ravis-booking' ) ?></div>
			</div>
			<div class="rows no-attributes hide"><?php esc_html_e( 'This shortcode doesn\'t have any attributes', 'ravis-booking' ); ?></div>
			<div id="ravis-booking-text-section" class="hide">
				<div class="rows">
					<label for="ravis-booking-text-section-title"><?php esc_html_e( 'Title : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="title" id="ravis-booking-text-section-title">
					<div class="hint"><?php esc_html_e( 'Add the title text section in this field', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-text-section-subtitle"><?php esc_html_e( 'Subtitle : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="subtitle" id="ravis-booking-text-section-subtitle">
					<div class="hint"><?php esc_html_e( 'Add the subtitle text section in this field', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-text-section-text"><?php esc_html_e( 'Text : ', 'ravis-booking' ); ?></label>
					<textarea name="text" id="ravis-booking-text-section-text" class="form-item"></textarea>
					<div class="hint"><?php esc_html_e( 'Add main text of this section in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-text-section-img-url"><?php esc_html_e( 'Image URL : ', 'ravis-booking' ); ?></label>
					<input type="url" class="form-item" name="img_url" id="ravis-booking-text-section-img-url">
					<div class="hint"><?php esc_html_e( 'If your text section has an image, add its url in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-text-section-person-url"><?php esc_html_e( 'Person\'s Image : ', 'ravis-booking' ); ?></label>
					<select class="form-item disable-select2" name="person_img" id="ravis-booking-text-section-person-url">
						<option value="1"><?php esc_html_e( 'Yes', 'ravis-booking' ); ?></option>
						<option value="0" selected="selected"><?php esc_html_e( 'No', 'ravis-booking' ); ?></option>
					</select>
					<div class="hint"><?php esc_html_e( 'Select that if the above image is a person image or not.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-text-section-cite"><?php esc_html_e( 'Cite : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="cite" id="ravis-booking-text-section-cite">
					<div class="hint"><?php esc_html_e( 'Add the cite of text section in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-text-section-btn_txt"><?php esc_html_e( 'Button Text : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="btn_txt" id="ravis-booking-text-section-btn_txt">
					<div class="hint"><?php esc_html_e( 'If your text section has a button, add its text in this field', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-text-section-btn_url"><?php esc_html_e( 'Button URL : ', 'ravis-booking' ); ?></label>
					<input type="url" class="form-item" name="btn_url" id="ravis-booking-text-section-btn_url">
					<div class="hint"><?php esc_html_e( 'If your text section has a button, add its URL in this field', 'ravis-booking' ) ?></div>
				</div>
			</div>
			<div id="ravis-booking-gallery" class="hide">
				<div class="rows">
					<label for="ravis-booking-gallery-title"><?php esc_html_e( 'Title : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="title" id="ravis-booking-gallery-title">
					<div class="hint"><?php esc_html_e( 'Add the title galler section in this field', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-gallery-subtitle"><?php esc_html_e( 'Subtitle : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="subtitle" id="ravis-booking-gallery-subtitle">
					<div class="hint"><?php esc_html_e( 'Add the subtitle galler section in this field', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-gallery-type"><?php esc_html_e( 'Type : ', 'ravis-booking' ); ?></label>
					<select class="form-item disable-select2" name="type" id="ravis-booking-gallery-type">
						<option value="grid" selected="selected"><?php esc_html_e( 'Grid', 'ravis-booking' ); ?></option>
						<option value="list"><?php esc_html_e( 'List', 'ravis-booking' ); ?></option>
					</select>
					<div class="hint"><?php esc_html_e( 'Select which type of gallery you want.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-gallery-img_count"><?php esc_html_e( 'Image Count : ', 'ravis-booking' ); ?></label>
					<input type="number" class="form-item" name="img_count" id="ravis-booking-gallery-img_count" placeholder="-1">
					<div class="hint"><?php esc_html_e( 'Add how many images you want to show in gallery section.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-gallery-more_url"><?php esc_html_e( 'More Button\'s URL : ', 'ravis-booking' ); ?></label>
					<input type="url" class="form-item" name="more_url" id="ravis-booking-gallery-more_url">
					<div class="hint"><?php esc_html_e( 'If you want to have more link below the gallery add your gallery\'s URL in this field. Leave it blank if you do not need more button.', 'ravis-booking' ) ?></div>
				</div>
			</div>
			<div id="ravis-booking-gallery-slideshow" class="hide">
				<div class="rows">
					<label for="ravis-booking-gallery-slideshow-pre_text"><?php esc_html_e( 'Pre Text : ', 'ravis-booking' ); ?></label>
					<textarea name="pre_text" id="ravis-booking-gallery-slideshow-pre_text" class="form-item"></textarea>
					<div class="hint"><?php esc_html_e( 'If you want to show a text above the gallery show, add your text here.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-gallery-slideshow-post_text"><?php esc_html_e( 'Post Text : ', 'ravis-booking' ); ?></label>
					<textarea name="post_text" id="ravis-booking-gallery-slideshow-post_text" class="form-item"></textarea>
					<div class="hint"><?php esc_html_e( 'If you want to show a text below the gallery show, add your text here.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-gallery-img_count"><?php esc_html_e( 'Image Count : ', 'ravis-booking' ); ?></label>
					<input type="number" class="form-item" name="img_count" id="ravis-booking-gallery-img_count" placeholder="-1">
					<div class="hint"><?php esc_html_e( 'Add how many images you want to show in gallery section.', 'ravis-booking' ) ?></div>
				</div>
			</div>
			<div id="ravis-booking-special-rooms" class="hide">
				<div class="rows">
					<label for="ravis-booking-special-rooms-room_count"><?php esc_html_e( 'Room Count : ', 'ravis-booking' ); ?></label>
					<input type="number" class="form-item" name="room_count" id="ravis-booking-special-rooms-room_count" placeholder="4">
					<div class="hint"><?php esc_html_e( 'Add how many rooms you want to show in this section.', 'ravis-booking' ) ?></div>
				</div>
			</div>
			<div id="ravis-booking-testimonials" class="hide">
				<div class="rows">
					<label for="ravis-booking-testimonials-bg_img"><?php esc_html_e( 'Background Image : ', 'ravis-booking' ); ?></label>
					<input type="url" class="form-item" name="bg_img" id="ravis-booking-testimonials-bg_img">
					<div class="hint"><?php esc_html_e( 'Add the URL of image that you want to show as background.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-testimonials-count"><?php esc_html_e( 'Count : ', 'ravis-booking' ); ?></label>
					<input type="number" class="form-item" name="count" id="ravis-booking-testimonials-count" placeholder="3">
					<div class="hint"><?php esc_html_e( 'Add how many testimonials you want to show in this section.', 'ravis-booking' ) ?></div>
				</div>
			</div>
			<div id="ravis-booking-hotel-section" class="hide">
				<div class="rows">
					<label for="ravis-booking-hotel-section-count"><?php esc_html_e( 'Count : ', 'ravis-booking' ); ?></label>
					<input type="number" class="form-item" name="count" id="ravis-booking-hotel-section-count" placeholder="3">
					<div class="hint"><?php esc_html_e( 'Add how many sections you want to show in this section.', 'ravis-booking' ) ?></div>
				</div>
			</div>
			<div id="ravis-booking-package" class="hide">
				<div class="rows">
					<label for="ravis-booking-package-title_type"><?php esc_html_e( 'Title Type : ', 'ravis-booking' ); ?></label>
					<select class="form-item disable-select2" name="title_type" id="ravis-booking-package-title_type">
						<option value="simple" selected="selected"><?php esc_html_e( 'Simple', 'ravis-booking' ); ?></option>
						<option value="box"><?php esc_html_e( 'Box', 'ravis-booking' ); ?></option>
					</select>
					<div class="hint"><?php esc_html_e( 'Select which type of title you want for this section.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-package-title"><?php esc_html_e( 'Title : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="title" id="ravis-booking-package-title">
					<div class="hint"><?php esc_html_e( 'Add the title of this section in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-package-subtitle"><?php esc_html_e( 'Subtitle : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="subtitle" id="ravis-booking-package-subtitle">
					<div class="hint"><?php esc_html_e( 'Add the title of this section in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-package-description"><?php esc_html_e( 'Post Text : ', 'ravis-booking' ); ?></label>
					<textarea name="description" id="ravis-booking-package-description" class="form-item"></textarea>
					<div class="hint"><?php esc_html_e( 'If you want to add any description to be shown above of the packages, add it in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-package-count"><?php esc_html_e( 'Count : ', 'ravis-booking' ); ?></label>
					<input type="number" class="form-item" name="count" id="ravis-booking-package-count" placeholder="3">
					<div class="hint"><?php esc_html_e( 'Add how many packages you want to show in this section.', 'ravis-booking' ) ?></div>
				</div>
			</div>
			<div id="ravis-booking-video-tour" class="hide">
				<div class="rows">
					<label for="ravis-booking-video-tour-type"><?php esc_html_e( 'Type : ', 'ravis-booking' ); ?></label>
					<select class="form-item disable-select2" name="type" id="ravis-booking-video-tour-type">
						<option value="two-cols" selected="selected"><?php esc_html_e( '2 Columns', 'ravis-booking' ); ?></option>
						<option value="simple"><?php esc_html_e( 'Simple', 'ravis-booking' ); ?></option>
					</select>
					<div class="hint"><?php esc_html_e( 'Select which type of title you want for this section.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-video-tour-title"><?php esc_html_e( 'Title : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="title" id="ravis-booking-video-tour-title">
					<div class="hint"><?php esc_html_e( 'Add the title of this section in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-video-tour-subtitle"><?php esc_html_e( 'Subtitle : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="subtitle" id="ravis-booking-video-tour-subtitle">
					<div class="hint"><?php esc_html_e( 'Add the title of this section in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-video-tour-description"><?php esc_html_e( 'Description : ', 'ravis-booking' ); ?></label>
					<textarea name="description" id="ravis-booking-video-tour-description" class="form-item"></textarea>
					<div class="hint"><?php esc_html_e( 'If you want to add any description to be shown above of the video, add it in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-video-tour-bg_img"><?php esc_html_e( 'Background Image URL : ', 'ravis-booking' ); ?></label>
					<input type="url" class="form-item" name="bg_img" id="ravis-booking-video-tour-bg_img">
					<div class="hint"><?php esc_html_e( 'Add the URL of background image in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-video-tour-video"><?php esc_html_e( 'Video URL : ', 'ravis-booking' ); ?></label>
					<input type="url" class="form-item" name="video" id="ravis-booking-video-tour-video">
					<div class="hint"><?php esc_html_e( 'Add the URL of embed code of video in this field.', 'ravis-booking' ) ?></div>
				</div>
			</div>
			<div id="ravis-booking-timeline" class="hide">
				<div class="rows">
					<label for="ravis-booking-timeline-title"><?php esc_html_e( 'Title : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="title" id="ravis-booking-timeline-title">
					<div class="hint"><?php esc_html_e( 'Add the title of this section in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-timeline-subtitle"><?php esc_html_e( 'Subtitle : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="subtitle" id="ravis-booking-timeline-subtitle">
					<div class="hint"><?php esc_html_e( 'Add the title of this section in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-timeline-description"><?php esc_html_e( 'Description : ', 'ravis-booking' ); ?></label>
					<textarea name="description" id="ravis-booking-timeline-description" class="form-item"></textarea>
					<div class="hint"><?php esc_html_e( 'If you want to add any description to be shown above of the timeline, add it in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-timeline-count"><?php esc_html_e( 'Count : ', 'ravis-booking' ); ?></label>
					<input type="number" class="form-item" name="count" id="ravis-booking-timeline-count" placeholder="-1">
					<div class="hint"><?php esc_html_e( 'Add how many items you want to show in this section.', 'ravis-booking' ) ?></div>
				</div>
			</div>
			<div id="ravis-booking-services" class="hide">
				<div class="rows">
					<label for="ravis-booking-services-title"><?php esc_html_e( 'Title : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="title" id="ravis-booking-services-title">
					<div class="hint"><?php esc_html_e( 'Add the title of this section in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-services-subtitle"><?php esc_html_e( 'Subtitle : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="subtitle" id="ravis-booking-services-subtitle">
					<div class="hint"><?php esc_html_e( 'Add the title of this section in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-services-description"><?php esc_html_e( 'Description : ', 'ravis-booking' ); ?></label>
					<textarea name="description" id="ravis-booking-services-description" class="form-item"></textarea>
					<div class="hint"><?php esc_html_e( 'If you want to add any description to be shown above of the timeline, add it in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-services-count"><?php esc_html_e( 'Count : ', 'ravis-booking' ); ?></label>
					<input type="number" class="form-item" name="count" id="ravis-booking-services-count" placeholder="-1">
					<div class="hint"><?php esc_html_e( 'Add how many items you want to show in this section.', 'ravis-booking' ) ?></div>
				</div>
			</div>
			<div id="ravis-booking-clients" class="hide">
				<div class="rows">
					<label for="ravis-booking-clients-count"><?php esc_html_e( 'Count : ', 'ravis-booking' ); ?></label>
					<input type="number" class="form-item" name="count" id="ravis-booking-clients-count" placeholder="4">
					<div class="hint"><?php esc_html_e( 'Add how many items you want to show in this section.', 'ravis-booking' ) ?></div>
				</div>
			</div>
			<div id="ravis-booking-staff" class="hide">
				<div class="rows">
					<label for="ravis-booking-staff-ids"><?php esc_html_e( 'Staff IDs : ', 'ravis-booking' ); ?></label>
					<input type="number" class="form-item" name="ids" id="ravis-booking-staff-ids" placeholder="10,122,9,87">
					<div class="hint"><?php esc_html_e( 'If you want to show some specified staff, you just need to add their IDs in this field in CSV(Comma Separated Value) format.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-staff-count"><?php esc_html_e( 'Count : ', 'ravis-booking' ); ?></label>
					<input type="number" class="form-item" name="count" id="ravis-booking-staff-count" placeholder="-1">
					<div class="hint"><?php esc_html_e( 'Add how many items you want to show in this section.', 'ravis-booking' ) ?></div>
				</div>
			</div>
			<div id="ravis-booking-promo" class="hide">
				<div class="rows">
					<label for="ravis-booking-promo-title"><?php esc_html_e( 'Title : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="title" id="ravis-booking-promo-title">
					<div class="hint"><?php esc_html_e( 'Add the title of this section in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-promo-subtitle"><?php esc_html_e( 'Subtitle : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="subtitle" id="ravis-booking-promo-subtitle">
					<div class="hint"><?php esc_html_e( 'Add the title of this section in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-promo-bg_img"><?php esc_html_e( 'Background Image : ', 'ravis-booking' ); ?></label>
					<input type="url" class="form-item" name="bg_img" id="ravis-booking-promo-bg_img">
					<div class="hint"><?php esc_html_e( 'Add the URL of image that you want to show as background.', 'ravis-booking' ) ?></div>
				</div>
			</div>
			<div id="ravis-booking-social-icons" class="hide">
				<div class="rows">
					<label for="ravis-booking-social-icons-id"><?php esc_html_e( 'ID : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="id" id="ravis-booking-social-icons-id">
					<div class="hint"><?php esc_html_e( 'If you want this section has a unique ID, add your ID in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-social-icons-class"><?php esc_html_e( 'Class : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="class" id="ravis-booking-social-icons-class">
					<div class="hint"><?php esc_html_e( 'If you want this section has a class, add your class in this field.', 'ravis-booking' ) ?></div>
				</div>
			</div>
			<div id="ravis-booking-dishes" class="hide">
				<div class="rows">
					<label for="ravis-booking-dishes-title"><?php esc_html_e( 'Title : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="title" id="ravis-booking-dishes-title">
					<div class="hint"><?php esc_html_e( 'Add the title of this section in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-dishes-subtitle"><?php esc_html_e( 'Subtitle : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="subtitle" id="ravis-booking-dishes-subtitle">
					<div class="hint"><?php esc_html_e( 'Add the title of this section in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-dishes-count"><?php esc_html_e( 'Count : ', 'ravis-booking' ); ?></label>
					<input type="number" class="form-item" name="count" id="ravis-booking-dishes-count" placeholder="-1">
					<div class="hint"><?php esc_html_e( 'Add how many items you want to show in this section.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-dishes-post-url"><?php esc_html_e( 'Post URL : ', 'ravis-booking' ); ?></label>
					<select class="form-item disable-select2" name="post_url" id="ravis-booking-dishes-post-url">
						<option value="" selected="selected"><?php esc_html_e( 'Yes', 'ravis-booking' ); ?></option>
						<option value="1"><?php esc_html_e( 'No', 'ravis-booking' ); ?></option>
					</select>
					<div class="hint"><?php esc_html_e( 'You can disable/enable more links for the dishes with this option', 'ravis-booking' ) ?></div>
				</div>
			</div>
			<div id="ravis-booking-menu" class="hide">
				<div class="rows">
					<label for="ravis-booking-menu-title"><?php esc_html_e( 'Title : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="title" id="ravis-booking-menu-title">
					<div class="hint"><?php esc_html_e( 'Add the title of this section in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-menu-subtitle"><?php esc_html_e( 'Subtitle : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="subtitle" id="ravis-booking-menu-subtitle">
					<div class="hint"><?php esc_html_e( 'Add the title of this section in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-menu-description"><?php esc_html_e( 'Description : ', 'ravis-booking' ); ?></label>
					<textarea name="description" id="ravis-booking-menu-description" class="form-item"></textarea>
					<div class="hint"><?php esc_html_e( 'If you want to add any description to be shown above of the timeline, add it in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-menu-count"><?php esc_html_e( 'Count : ', 'ravis-booking' ); ?></label>
					<input type="number" class="form-item" name="count" id="ravis-booking-menu-count" placeholder="-1">
					<div class="hint"><?php esc_html_e( 'Add how many items you want to show in this section.', 'ravis-booking' ) ?></div>
				</div>
			</div>
			<div id="ravis-booking-testimonial-form" class="hide">
				<div class="rows">
					<label for="ravis-booking-testimonial-form-title"><?php esc_html_e( 'Title : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="title" id="ravis-booking-testimonial-form-title">
					<div class="hint"><?php esc_html_e( 'Add the title of this section in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-testimonial-form-subtitle"><?php esc_html_e( 'Subtitle : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="subtitle" id="ravis-booking-testimonial-form-subtitle">
					<div class="hint"><?php esc_html_e( 'Add the title of this section in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-testimonial-form-class"><?php esc_html_e( 'Class : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="class" id="ravis-booking-testimonial-form-class">
					<div class="hint"><?php esc_html_e( 'If you want this section has a class, add your class in this field.', 'ravis-booking' ) ?></div>
				</div>
			</div>
			<div id="ravis-booking-upcoming-events" class="hide">
				<div class="rows">
					<label for="ravis-booking-upcoming-events-title"><?php esc_html_e( 'Title : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="title" id="ravis-booking-upcoming-events-title">
					<div class="hint"><?php esc_html_e( 'Add the title of this section in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-upcoming-events-subtitle"><?php esc_html_e( 'Subtitle : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="subtitle" id="ravis-booking-upcoming-events-subtitle">
					<div class="hint"><?php esc_html_e( 'Add the title of this section in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-upcoming-events-count"><?php esc_html_e( 'Count : ', 'ravis-booking' ); ?></label>
					<input type="number" class="form-item" name="count" id="ravis-booking-upcoming-events-count" placeholder="-1">
					<div class="hint"><?php esc_html_e( 'Add how many items you want to show in this section.', 'ravis-booking' ) ?></div>
				</div>
			</div>
			<div id="ravis-booking-past-events" class="hide">
				<div class="rows">
					<label for="ravis-booking-past-events-title"><?php esc_html_e( 'Title : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="title" id="ravis-booking-past-events-title">
					<div class="hint"><?php esc_html_e( 'Add the title of this section in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-past-events-subtitle"><?php esc_html_e( 'Subtitle : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="subtitle" id="ravis-booking-past-events-subtitle">
					<div class="hint"><?php esc_html_e( 'Add the title of this section in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-past-events-count"><?php esc_html_e( 'Count : ', 'ravis-booking' ); ?></label>
					<input type="number" class="form-item" name="count" id="ravis-booking-past-events-count" placeholder="-1">
					<div class="hint"><?php esc_html_e( 'Add how many items you want to show in this section.', 'ravis-booking' ) ?></div>
				</div>
			</div>
			<div id="ravis-booking-other-events" class="hide">
				<div class="rows">
					<label for="ravis-booking-other-events-event_id"><?php esc_html_e( 'Event ID : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="event_id" id="ravis-booking-other-events-event_id">
					<div class="hint"><?php esc_html_e( 'Add the ID of the event that you want to exclude it from the result.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-other-events-title"><?php esc_html_e( 'Title : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="title" id="ravis-booking-other-events-title">
					<div class="hint"><?php esc_html_e( 'Add the title of this section in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-other-events-subtitle"><?php esc_html_e( 'Subtitle : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="subtitle" id="ravis-booking-other-events-subtitle">
					<div class="hint"><?php esc_html_e( 'Add the title of this section in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-other-events-count"><?php esc_html_e( 'Count : ', 'ravis-booking' ); ?></label>
					<input type="number" class="form-item" name="count" id="ravis-booking-other-events-count" placeholder="-1">
					<div class="hint"><?php esc_html_e( 'Add how many items you want to show in this section.', 'ravis-booking' ) ?></div>
				</div>
			</div>
			<div id="ravis-booking-event-booking" class="hide">
				<div class="rows">
					<label for="ravis-booking-event-booking-event_id"><?php esc_html_e( 'Event ID : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="event_id" id="ravis-booking-event-booking-event_id">
					<div class="hint"><?php esc_html_e( 'Add the ID of the event that you want user book for it in this field.', 'ravis-booking' ) ?></div>
				</div>
			</div>
			<div id="ravis-booking-room-listing" class="hide">
				<div class="rows">
					<label for="ravis-booking-room-listing-layout"><?php esc_html_e( 'Layout : ', 'ravis-booking' ); ?></label>
					<select class="form-item disable-select2" name="layout" id="ravis-booking-room-listing-layout">
						<option value="gird" selected="selected"><?php esc_html_e( 'Gird', 'ravis-booking' ); ?></option>
						<option value="list"><?php esc_html_e( 'List', 'ravis-booking' ); ?></option>
					</select>
					<div class="hint"><?php esc_html_e( 'Select layout that you want to show the rooms.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-room-listing-title"><?php esc_html_e( 'Title : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="title" id="ravis-booking-room-listing-title">
					<div class="hint"><?php esc_html_e( 'Add the title of this section in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-room-listing-subtitle"><?php esc_html_e( 'Subtitle : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="subtitle" id="ravis-booking-room-listing-subtitle">
					<div class="hint"><?php esc_html_e( 'Add the title of this section in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-room-listing-description"><?php esc_html_e( 'Description : ', 'ravis-booking' ); ?></label>
					<textarea name="description" id="ravis-booking-room-listing-description" class="form-item"></textarea>
					<div class="hint"><?php esc_html_e( 'If you want to add any description to be shown above of the timeline, add it in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-room-listing-count"><?php esc_html_e( 'Count : ', 'ravis-booking' ); ?></label>
					<input type="number" class="form-item" name="count" id="ravis-booking-room-listing-count" placeholder="-1">
					<div class="hint"><?php esc_html_e( 'Add how many items you want to show in this section.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-room-listing-title_type"><?php esc_html_e( 'Title Type : ', 'ravis-booking' ); ?></label>
					<select class="form-item disable-select2" name="title_type" id="ravis-booking-room-listing-title_type">
						<option value="1" selected="selected"><?php esc_html_e( 'Simple', 'ravis-booking' ); ?></option>
						<option value="2"><?php esc_html_e( 'Box', 'ravis-booking' ); ?></option>
					</select>
					<div class="hint"><?php esc_html_e( 'Select which type of title you want for this section.', 'ravis-booking' ) ?></div>
				</div>
			</div>
			<div id="ravis-booking-room-search-form" class="hide">
				<div class="rows">
					<label for="ravis-booking-room-search-form-layout"><?php esc_html_e( 'Layout : ', 'ravis-booking' ); ?></label>
					<select class="form-item disable-select2" name="layout" id="ravis-booking-room-search-form-layout">
						<option value="horizontal" selected="selected"><?php esc_html_e( 'Horizontal', 'ravis-booking' ); ?></option>
						<option value="vertical"><?php esc_html_e( 'Vertical', 'ravis-booking' ); ?></option>
					</select>
					<div class="hint"><?php esc_html_e( 'Select layout that search form', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-room-search-form-title"><?php esc_html_e( 'Title : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="title" id="ravis-booking-room-search-form-title">
					<div class="hint"><?php esc_html_e( 'Add the title of this section in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-room-search-form-subtitle"><?php esc_html_e( 'Subtitle : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="subtitle" id="ravis-booking-room-search-form-subtitle">
					<div class="hint"><?php esc_html_e( 'Add the title of this section in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-room-search-form-class"><?php esc_html_e( 'Class : ', 'ravis-booking' ); ?></label>
					<textarea name="class" id="ravis-booking-room-search-form-class" class="form-item"></textarea>
					<div class="hint"><?php esc_html_e( 'If you want that this section has a specified class, add it in this field.', 'ravis-booking' ) ?></div>
				</div>
			</div>
			<div id="ravis-booking-other-rooms" class="hide">
				<div class="rows">
					<label for="ravis-booking-other-rooms-post_id"><?php esc_html_e( 'Room ID : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="post_id" id="ravis-booking-other-rooms-post_id">
					<div class="hint"><?php esc_html_e( 'Add the id of room that you want to exclude it from the result.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-other-rooms-title"><?php esc_html_e( 'Title : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="title" id="ravis-booking-other-rooms-title">
					<div class="hint"><?php esc_html_e( 'Add the title of this section in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-other-rooms-subtitle"><?php esc_html_e( 'Subtitle : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="subtitle" id="ravis-booking-other-rooms-subtitle">
					<div class="hint"><?php esc_html_e( 'Add the title of this section in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-other-rooms-count"><?php esc_html_e( 'Count : ', 'ravis-booking' ); ?></label>
					<input type="number" class="form-item" name="count" id="ravis-booking-other-rooms-count" placeholder="-1">
					<div class="hint"><?php esc_html_e( 'Add how many items you want to show in this section.', 'ravis-booking' ) ?></div>
				</div>
			</div>
			<div id="ravis-booking-room-rating" class="hide">
				<div class="rows">
					<label for="ravis-booking-room-rating-room_id"><?php esc_html_e( 'Room ID : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="room_id" id="ravis-booking-room-rating-room_id">
					<div class="hint"><?php esc_html_e( 'Add the id of room that you want to show its rating.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-room-rating-title"><?php esc_html_e( 'Title : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="title" id="ravis-booking-room-rating-title">
					<div class="hint"><?php esc_html_e( 'Add the title of this section in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-room-rating-subtitle"><?php esc_html_e( 'Subtitle : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="subtitle" id="ravis-booking-room-rating-subtitle">
					<div class="hint"><?php esc_html_e( 'Add the title of this section in this field.', 'ravis-booking' ) ?></div>
				</div>
			</div>
			<div id="ravis-booking-contact" class="hide">
				<div class="rows">
					<label for="ravis-booking-contact-title"><?php esc_html_e( 'Title : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="title" id="ravis-booking-contact-title" placeholder="<?php esc_html_e( 'Contact Us', 'ravis-booking' ); ?>">
					<div class="hint"><?php esc_html_e( 'Add the title of this section in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-contact-subtitle"><?php esc_html_e( 'Subtitle : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="subtitle" id="ravis-booking-contact-subtitle" placeholder="<?php esc_html_e( 'Do not hesitate to contact me if you have any further questions', 'ravis-booking' ); ?>">
					<div class="hint"><?php esc_html_e( 'Add the title of this section in this field.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-contact-description"><?php esc_html_e( 'Description : ', 'ravis-booking' ); ?></label>
					<textarea name="description" id="ravis-booking-contact-description" class="form-item"></textarea>
					<div class="hint"><?php esc_html_e( 'If you want to add any description to be shown above of this section, add it in this field.', 'ravis-booking' ) ?></div>
				</div>
			</div>
			<div id="ravis-booking-booking-overview" class="hide">
				<div class="rows">
					<label for="ravis-booking-overview-class"><?php esc_html_e( 'Class : ', 'ravis-booking' ); ?></label>
					<input type="text" class="form-item" name="class" id="ravis-booking-overview-class">
					<div class="hint"><?php esc_html_e( 'Add class for the calendar container, if you need special class for future uses.', 'ravis-booking' ) ?></div>
				</div>
				<div class="rows">
					<label for="ravis-booking-overview-room"><?php esc_html_e( 'Room ID : ', 'ravis-booking' ); ?></label>
					<input type="number" class="form-item" name="room_id" id="ravis-booking-overview-room">
					<div class="hint"><?php esc_html_e( 'If you want to show an specific room\'s availability, put its ID in this field.', 'ravis-booking' ) ?></div>
				</div>
			</div>
		</div>
	</form>
	<?php wp_footer(); ?>
</body>
</html>