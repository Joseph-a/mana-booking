<div class="col-md-4 l-sec">
	<div class="ravis-title-t-2">
		<div class="title"><span>{{bookingAppVar.reservation_info}}</span></div>
	</div>
	<div class="check-in-out-container">
		<div class="check-in-out-box">
			<div class="title">{{bookingAppVar.check_in}}</div>
			<div class="value">{{generateDate(bookingInfo.checkIn)}}</div>
		</div>
		<div class="check-in-out-box">
			<div class="title">{{bookingAppVar.check_out}}</div>
			<div class="value">{{generateDate(bookingInfo.checkOut)}}</div>
		</div>
	</div>
	<div class="selected-room-container">
		<div class="selected-room-box has-price" ng-repeat="roomItem in bookingInfo.room">
			<div class="room-title">
				<div class="title">{{bookingAppVar.room}} {{$index+1}} :</div>
				<div class="value">{{bookingInfo.room[$index]['info'] ? bookingInfo.room[$index]['info']['title'] : ''}}</div>
			</div>
			<div class="adult-count">
				<div class="title">{{bookingAppVar.adult}} :</div>
				<div class="value">{{bookingInfo.room[$index]['adult']}}</div>
			</div>
			<div class="child-count">
				<div class="title">{{bookingAppVar.children}} :</div>
				<div class="value">{{bookingInfo.room[$index]['child']}}</div>
			</div>
			<div class="price">
				<div class="title">{{bookingAppVar.price}} :</div>
				<div class="value">{{bookingInfo.room[$index]['priceDetails']['total']['payable']}}</div>
			</div>
		</div>
	</div>
	<div class="services-container" ng-if="bookingInfo.services">
		<div class="title-box">{{bookingAppVar.services}}</div>
		<div class="selected-services clearfix" ng-repeat="serviceItem in bookingInfo.services">
			<div class="title" ng-bind-html="serviceItem.title"></div>
			<div class="price" ng-bind-html="serviceItem.total_price.generated"></div>
		</div>
	</div>
	<div class="services-container" ng-if="bookingInfo.package">
		<div class="title-box">{{bookingAppVar.package}}</div>
		<div class="selected-services clearfix">
			<div class="title" ng-bind-html="bookingInfo.package.title"></div>
			<div class="price">{{bookingInfo.package.total_price.value | ravisPrice:this}}</div>
		</div>
	</div>
	<div class="price-details-container">
		<div class="price-detail-box">
			<div class="title">{{bookingAppVar.room_service}} :</div>
			<div class="value">{{bookingInfo.rawPrice | ravisPrice:this }}</div>
		</div>
		<div class="price-detail-box" ng-if="bookingInfo.user_membership">
			<div class="title">{{bookingAppVar.membership_discount}} :</div>
			<div class="value"> - {{bookingInfo.membershipDiscount | ravisPrice:this }}
				<span>(%{{bookingInfo.user_membership.discount}})</span></div>
		</div>
		<div class="price-detail-box" ng-if="bookingAppVar.user_vat != 0">
			<div class="title">{{bookingAppVar.vat}} {{bookingAppVar.user_vat}}% :</div>
			<div class="value">{{bookingInfo.vat | ravisPrice:this }}</div>
		</div>
		<div class="price-detail-box total">
			<div class="title">{{bookingAppVar.total_price}} :</div>
			<div class="value">{{(bookingInfo.totalPrice + bookingInfo.totalServicesPrice + bookingInfo.package.total_price.value + bookingInfo.vat) | ravisPrice:this }}</div>
		</div>
	</div>
</div>
<div class="col-md-8 r-sec">
	<div class="inner-box">
		<div class="steps">
			<ul class="list-inline">
				<li>{{bookingAppVar.choose_date}}</li>
				<li>{{bookingAppVar.choose_room}}</li>
				<li>{{bookingAppVar.make_a_reservation}}</li>
				<li class="active">{{bookingAppVar.confirmation}}</li>
			</ul>
		</div>

		<div id="confirmation-message">
			<div class="ravis-title-t-2">
				<div class="title"><span>{{bookingAppVar.final_booking_title}}</span></div>
				<div class="sub-title">{{bookingAppVar.final_booking_subtitle}}</div>
			</div>
			<div class="desc" ng-bind-html="bookingAppVar.final_booking_desc"></div>
		</div>
	</div>
</div>