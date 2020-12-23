<?php
if (!is_user_logged_in()) {
	wp_redirect(home_url());
}
get_header();
$mana_booking_user_obj = new Mana_booking_user();
$mana_booking_user_obj->automatic_profile_updater();
?>
<div id="user-panel-main-container">
	<div class="inner-container container">
		<?php
		switch ($_GET['page']) {
			case ('payment'):
				require_once 'user-panel/payment.php';
				break;
			case ('booking'):
				require_once 'user-panel/booking.php';
				break;
			default:
				require_once 'user-panel/profile.php';
				break;
		}
		?>
	</div>
</div>
<?php
get_footer();
