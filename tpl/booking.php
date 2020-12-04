<?php
	get_header();
?>
	<div class="booking-app-container" ng-app="manaBooking">
		<section id="booking-section" ng-controller="manaBookingProcess">
			<div class="inner-container container">
				<div class="loading-box" view-loader>
					<div class="loader"></div>
				</div>
				<div ng-view></div>
			</div>
		</section>
	</div>
<?php
	get_footer();