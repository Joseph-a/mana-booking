<?php
    $currency_obj      = new Ravis_booking_currency();
    $current_user_info = wp_get_current_user();
    $current_user_meta = get_user_meta($current_user_info->ID);
?>
<div class="personal-information">
	<div class="inner-container clearfix">
		<div class="col-md-7">
			<div class="box-title">
				<span><?php esc_html_e('Personal Information', 'ravis-booking') ?></span>
			</div>
			<form action="#" id="profile-form">
				<div class="loading-box">
					<div class="loader"></div>
				</div>
				<?php wp_nonce_field('profile-update') ?>
				<div class="field-row">
					<label for="profile-first-name"><?php esc_html_e('First Name* :', 'ravis-booking') ?></label>
					<input type="text" id="profile-first-name" name="first-name" value="<?php echo !empty($current_user_meta['first_name'][0]) ? esc_attr($current_user_meta['first_name'][0]) : ''; ?>" required>
				</div>
				<div class="field-row">
					<label for="profile-last-name"><?php esc_html_e('Last Name* :', 'ravis-booking') ?></label>
					<input type="text" id="profile-last-name" name="first-name" value="<?php echo !empty($current_user_meta['last_name'][0]) ? esc_attr($current_user_meta['last_name'][0]) : ''; ?>" required>
				</div>
				<div class="field-row">
					<label for="profile-phone"><?php esc_html_e('Phone :', 'ravis-booking') ?></label>
					<input type="text" id="profile-phone" name="phone" value="<?php echo !empty($current_user_meta['phone'][0]) ? esc_attr($current_user_meta['phone'][0]) : ''; ?>">
				</div>
				<div class="field-row">
					<label for="profile-email"><?php esc_html_e('Email* :', 'ravis-booking') ?></label>
					<input type="email" name="email" id="profile-email" value="<?php echo !empty($current_user_info->data->user_email) ? esc_attr($current_user_info->data->user_email) : '' ?>" required>
				</div>
				<div class="field-row">
					<label for="profile-address"><?php esc_html_e('Address :', 'ravis-booking') ?></label>
					<textarea id="profile-address" name="address"><?php echo !empty($current_user_meta['address'][0]) ? esc_attr($current_user_meta['address'][0]) : ''; ?></textarea>
				</div>
				<div class="message-box not-active">
					<?php esc_html_e('Please fill all required fields.', 'ravis-booking') ?>
				</div>
				<div class="field-row">
					<input type="submit" value="<?php esc_html_e('Save', 'ravis-booking') ?>">
				</div>
			</form>
		</div>
		<div class="offset-col-md-1 col-md-4">
			<div class="box-title">
				<span><?php esc_html_e('Additional Information', 'ravis-booking') ?></span>
			</div>
			<div class="membership-info-container">
				<ul>
					<?php
                        if (!empty($current_user_meta['membership'][0]))
                        {
                            $membership_info = unserialize($current_user_meta['membership'][0]);
                            if (!empty($membership_info['badge']))
                            {
                                $img_info    = wp_get_attachment_url($membership_info['badge']);
                                $img_preview = (!empty($img_info) ? '<div class="image-preview-box"><img src="' . esc_url($img_info) . '"/></div>' : '');
                            } ?>
							<li><?php echo wp_kses_post($img_preview) ?></li>
							<?php
                        }
                        if (!empty($current_user_meta['total_booking_price'][0]))
                        {
                            $ravis_options         = get_option('ravis-booking-setting');
                            $default_currency      = $ravis_options['default_currency'];
                            $default_currency_info = $ravis_options['currency'][ $default_currency ]; ?>
							<li>
								<div class="title"><?php esc_html_e('Total Booking Price :', 'ravis-booking') ?></div>
								<div class="value"><?php echo esc_html($currency_obj->price_generator_no_exchange($current_user_meta['total_booking_price'][0], $default_currency_info)) ?></div>
							</li>
							<?php
                        }
                        if (!empty($current_user_meta['total_booking_item'][0]))
                        {
                            ?>
							<li>
								<div class="title"><?php esc_html_e('Total Booking Item :', 'ravis-booking') ?></div>
								<div class="value"><?php echo esc_html($current_user_meta['total_booking_item'][0]) ?></div>
							</li>
							<?php
                        }
                    ?>
				</ul>
			</div>
		</div>
	</div>
</div>
