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
				<div class="edit-btn" ng-click="editRoom($index)">{{bookingAppVar.edit_room}}</div>
			</div>
		</div>
	</div>
	<div class="services-container">
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
</div>
<div class="col-md-8 r-sec">
	<div class="inner-box">
		<div class="steps">
			<ul class="list-inline">
				<li>{{bookingAppVar.choose_date}}</li>
				<li class="active">{{bookingAppVar.choose_room}}</li>
				<li>{{bookingAppVar.make_a_reservation}}</li>
				<li>{{bookingAppVar.confirmation}}</li>
			</ul>
		</div>
		<form id="service-selection-form">
			<div class="optional-service-container" ng-if="servicesList.optional">
				<div class="ravis-title-t-2">
					<div class="title"><span>{{bookingAppVar.optional_services}}</span></div>
					<div class="sub-title">{{bookingAppVar.optional_services_desc}}</div>
				</div>
				<div class="optional-services">
					<ul>
						<li ng-repeat="opService in servicesList.optional track by $index">
							<div class="ravis-checkbox">
								<label>
									<input type="checkbox" ng-click="addService(opService)">
									<span></span>
									<b ng-bind-html="opService.title"></b>
								</label>
							</div>
							<div class="price" ng-bind-html="opService.price.generated"></div>
						</li>
					</ul>
				</div>
			</div>
			<div class="mandatory-service-container" ng-if="servicesList.mandatory">
				<div class="ravis-title-t-2">
					<div class="title"><span>{{bookingAppVar.mandatory_services}}</span></div>
					<div class="sub-title">{{bookingAppVar.mandatory_services_desc}}</div>
				</div>
				<div class="not-optional-services">
					<ul>
						<li ng-repeat="manService in servicesList.mandatory track by $index">
							<div class="title" ng-bind-html="manService.title"></div>
							<div class="price" ng-bind-html="manService.price.generated"></div>
						</li>
					</ul>
				</div>
			</div>
		</form>
		<div class="services-btn-container">
			<button class="btn btn-defailt" ng-click="goToNextPage()">{{bookingAppVar.next_step}}</button>
		</div>
	</div>
</div>