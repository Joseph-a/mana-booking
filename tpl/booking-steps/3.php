<div class="col-md-4 l-sec">
	<div class="mana-title-t-2">
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
			<div class="price">{{bookingInfo.package.total_price.value | manaPrice:this}}</div>
		</div>
	</div>
	<div class="price-details-container">
		<div class="price-detail-box">
			<div class="title">{{bookingAppVar.room_service}} :</div>
			<div class="value">{{bookingInfo.rawPrice | manaPrice:this }}</div>
		</div>
		<div class="price-detail-box" ng-if="bookingInfo.user_membership">
			<div class="title">{{bookingAppVar.membership_discount}} :</div>
			<div class="value"> - {{bookingInfo.membershipDiscount | manaPrice:this }} <span>(%{{bookingInfo.user_membership.discount}})</span></div>
		</div>
		<div class="price-detail-box" ng-if="bookingAppVar.user_vat != 0">
			<div class="title">{{bookingAppVar.vat}} {{bookingAppVar.user_vat}}% :</div>
			<div class="value">{{bookingInfo.vat | manaPrice:this }}</div>
		</div>
		<div class="price-detail-box" ng-if="bookingInfo.couponPrice">
			<div class="title">{{bookingAppVar.coupon}} :</div>
			<div class="value"> - {{bookingInfo.couponPrice | manaPrice:this }} <span></span></div>
		</div>
		<div class="price-detail-box total">
			<div class="title">{{bookingAppVar.total_price}} :</div>
			<div class="value">{{bookingInfo.totalBookingPrice | manaPrice:this }}</div>
		</div>
		<div class="payment-method" ng-if="bookingAppVar.deposit_status">
			<div class="mana-radio">
				<label for="full-payment">
					<input type="radio" name="payment-method" ng-model="bookingInfo.paymentPriceMethod" value="1" id="full-payment" ng-init="bookingInfo.paymentPriceMethod = '1' ">
					<span></span>
					{{bookingAppVar.full_payment}}
				</label>
			</div>
			<div class="mana-radio">
				<label for="deposit">
					<input type="radio" name="payment-method" ng-model="bookingInfo.paymentPriceMethod" value="2" id="deposit">
					<span></span>
					{{bookingAppVar.user_deposit}}% {{bookingAppVar.deposit}}
				</label>
			</div>
			<div class="deposit-price" ng-if="bookingInfo.paymentPriceMethod == '2'">
				<div class="title-box">
					<div class="title">{{bookingAppVar.user_deposit}}% {{bookingAppVar.deposit}}</div>
					<div class="sub-title">{{bookingAppVar.pay_on_arrival}}</div>
				</div>
				<div class="value">{{(bookingInfo.totalBookingPrice * bookingAppVar.user_deposit ) / 100 | manaPrice:this }}</div>
			</div>
		</div>
	</div>
</div>
<div class="col-md-8 r-sec">
	<div class="inner-box">
		<div class="steps">
			<ul class="list-inline">
				<li>{{bookingAppVar.choose_date}}</li>
				<li>{{bookingAppVar.choose_room}}</li>
				<li class="active">{{bookingAppVar.make_a_reservation}}</li>
				<li>{{bookingAppVar.confirmation}}</li>
			</ul>
		</div>
		<div id="booking-guest-info-form">
			<div class="loading-box" ajax-loading>
				<div class="loader"></div>
			</div>
			<div class="field-row clearfix">
				<div class="col-md-6">
					<input type="text" placeholder="{{bookingAppVar.first_name}} *" ng-model="bookingInfo.fname" required>
				</div>
				<div class="col-md-6">
					<input type="text" placeholder="{{bookingAppVar.last_name}} *" ng-model="bookingInfo.lname" required>
				</div>
			</div>
			<div class="field-row clearfix">
				<div class="col-md-6">
					<input type="text" placeholder="{{bookingAppVar.phone}} *" ng-model="bookingInfo.phone" required>
				</div>
				<div class="col-md-6">
					<input type="email" placeholder="{{bookingAppVar.email}} *" ng-model="bookingInfo.email" required>
				</div>
			</div>
			<div class="field-row clearfix">
				<input type="text" placeholder="{{bookingAppVar.address}}" ng-model="bookingInfo.address">
			</div>
			<div class="field-row clearfix">
				<textarea placeholder="{{bookingAppVar.special_requirements}}" ng-model="bookingInfo.requirements"></textarea>
			</div>
			<div class="field-row coupon-row clearfix">
				<div class="title">{{bookingAppVar.coupon}}</div>
				<input type="text" placeholder="{{bookingAppVar.add_coupon}}" ng-model="bookingInfo.coupon">
				<input type="submit" class="btn" ng-click="checkCoupon()" value="{{bookingAppVar.send}}">
			</div>
			<div class="alert alert-danger" ng-if="couponError.length > 0">
				<ul>
					<li ng-repeat="error in couponError">{{error}}</li>
				</ul>
			</div>
			<div class="field-row clearfix">
				<div class="mana-checkbox">
					<label for="terms-condition">
						<input type="checkbox" name="terms" value="1" id="terms-condition" ng-model="bookingInfo.terms" required>
						<span></span>
						<b ng-bind-html="bookingAppVar.condition_text"></b>
					</label>
				</div>
			</div>
			<div class="alert alert-danger" ng-if="finalStepError.length > 0">
				<ul>
					<li ng-repeat="error in finalStepError">{{error}}</li>
				</ul>
			</div>
			<div class="field-row btn-container clearfix">
				<div class="t-sec" ng-if="bookingAppVar.email_booking">
					<div class="by-email" ng-click="finalizeBooking('email')">{{bookingAppVar.book_by_email}}</div>
				</div>
				<div class="b-sec" ng-if="bookingAppVar.paypal_booking || bookingAppVar.paymill_booking || bookingAppVar.stripe_booking">
					<div class="or" ng-if="bookingAppVar.email_booking">{{bookingAppVar.or}}</div>
					<div class="title">{{bookingAppVar.book_by}}</div>
					<div class="by-paypal" ng-click="finalizeBooking('paypal')" ng-if="bookingAppVar.paypal_booking">
						<img src="{{bookingAppVar.asset_url}}paypal.png" alt="{{bookingAppVar.paypal}}">
					</div>
					<div class="by-paymill" ng-click="finalizeBooking('paymill')" ng-if="bookingAppVar.paymill_booking">
						<img src="{{bookingAppVar.asset_url}}paymill.png" alt="{{bookingAppVar.paymill}}">
					</div>
					<div class="by-stripe" ng-click="finalizeBooking('stripe')" ng-if="bookingAppVar.stripe_booking">
						<img src="{{bookingAppVar.asset_url}}stripe.png" alt="{{bookingAppVar.stripe}}">
					</div>
				</div>
			</div>
			<div ng-bind-html="paymentForm"></div>
		</div>
	</div>
</div>