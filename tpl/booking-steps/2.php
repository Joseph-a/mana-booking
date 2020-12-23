<div class="col-md-4 l-sec">
	<div class="mana-title-t-2">
		<div class="title">
			<span>{{bookingAppVar.reservation_info}}</span>
		</div>
	</div>
	<div class="selected-room-container">
		<div class="selected-room-box" ng-class="{'active': $index == activeRoom}" ng-repeat="roomItem in bookingInfo.room track by $index">
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
			<a class="edit-box" ng-if="$index != activeRoom && bookingInfo.room[$index].roomID" ng-click="changeActiveRoom($index)">{{bookingAppVar.edit}}</a>
		</div>
	</div>
	<form id="room-information-form">
		<div class="input-daterange">
			<div class="field-row">
				<input placeholder="{{bookingAppVar.check_in}}" class="datepicker-fields check-in" type="text" name="start" value="{{bookingInfo.checkIn ? generateDate(bookingInfo.checkIn) : ''}}" ng-model="bookingInfo.checkIn" ng-change="updateSearchResult()" />
				<i class="fa fa-calendar"></i>
			</div>
			<div class="field-row">
				<input placeholder="{{bookingAppVar.check_out}}" class="datepicker-fields check-out" type="text" name="end" value="{{bookingInfo.checkOut ? generateDate(bookingInfo.checkOut) : ''}}" ng-model="bookingInfo.checkOut" ng-change="updateSearchResult()" />
				<i class="fa fa-calendar"></i>
			</div>
		</div>
		<div class="field-row">
			<div class="alert alert-danger" ng-if="roomCountAlert">{{roomCountAlert}}</div>
			<select name="room-count" class="room-count" ng-model="bookingInfo.roomCount" ng-init="bookingInfo.roomCount = bookingInfo.roomCount" ng-change="updateSearchResult()">
				<option value="1">1 {{bookingAppVar.room}}</option>
				<option value="2">2 {{bookingAppVar.rooms}}</option>
				<option value="3">3 {{bookingAppVar.rooms}}</option>
				<option value="4">4 {{bookingAppVar.rooms}}</option>
				<option value="5">5 {{bookingAppVar.rooms}}</option>
			</select>
		</div>
		<div class="room-field-container">
			<div class="field-row room-field" ng-repeat="roomItem in createArray(bookingInfo.roomCount)">
				<div class="title">{{bookingAppVar.room}} {{$index+1}} :</div>
				<select ng-model="bookingInfo.room[$index]['adult']" name="room[$index]['adult']" class="adult-field" ng-init="bookingInfo.room[$index]['adult'] = (bookingInfo.room[$index]['adult'] ? bookingInfo.room[$index]['adult'] : '1')" ng-change="updateSearchResult()">
					<option value="1">1 {{bookingAppVar.adult}}</option>
					<option value="2">2 {{bookingAppVar.adults}}</option>
					<option value="3">3 {{bookingAppVar.adults}}</option>
					<option value="4">4 {{bookingAppVar.adults}}</option>
					<option value="5">5 {{bookingAppVar.adults}}</option>
					<option value="6">6 {{bookingAppVar.adults}}</option>
					<option value="7">7 {{bookingAppVar.adults}}</option>
					<option value="8">8 {{bookingAppVar.adults}}</option>
					<option value="9">9 {{bookingAppVar.adults}}</option>
					<option value="10">10 {{bookingAppVar.adults}}</option>
				</select>
				<select ng-model="bookingInfo.room[$index]['child']" name="room[$index]['child']" ng-init="bookingInfo.room[$index]['child'] = (bookingInfo.room[$index]['child'] ? bookingInfo.room[$index]['child'] : '0')" ng-change="updateSearchResult()">
					<option value="0">{{bookingAppVar.no_child}}</option>
					<option value="1">1 {{bookingAppVar.child}}</option>
					<option value="2">2 {{bookingAppVar.children}}</option>
					<option value="3">3 {{bookingAppVar.children}}</option>
					<option value="4">4 {{bookingAppVar.children}}</option>
					<option value="5">5 {{bookingAppVar.children}}</option>
					<option value="6">6 {{bookingAppVar.children}}</option>
					<option value="7">7 {{bookingAppVar.children}}</option>
					<option value="8">8 {{bookingAppVar.children}}</option>
					<option value="9">9 {{bookingAppVar.children}}</option>
					<option value="10">10 {{bookingAppVar.children}}</option>
				</select>
			</div>
		</div>
	</form>
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

		<div id="booking-room-container">
			<div class="loading-box" ajax-loading>
				<div class="loader"></div>
			</div>
			<div class="alert alert-danger" ng-if="selectRoomError">{{selectRoomError}}</div>
			<div class="room-box" ng-if="availableRoomsStatus" ng-repeat="roomItem in availableRooms">
				<div class="col-md-5 room-img" style="background-image: url({{roomItem.gallery ? roomItem.gallery.img[0].url: '#'}})">
					<div class="select-room-box">
						<a ng-click="selectRoom(activeRoom, roomItem, roomItem.booking_price)">{{bookingAppVar.select_room}}</a>
					</div>
				</div>
				<div class="r-sec col-md-7">
					<div class="title-box">
						<div class="title">{{roomItem.title}}</div>
						<div class="price">
							<div class="title">{{bookingAppVar.start_from}} :</div>
							<div class="value">{{roomItem.start_price}}</div>
						</div>
						<a href="#price-break-down-{{$index}}" magnific-image class="price-breakdown" ng-if="durationCalc(bookingInfo.checkIn, bookingInfo.checkOut) > 0">
							<i class="fa fa-caret-right"></i>{{bookingAppVar.price_breakdown}}
						</a>
						<div id="price-break-down-{{$index}}" class="price-breakdown-popup mfp-hide" ng-if="durationCalc(bookingInfo.checkIn, bookingInfo.checkOut) > 0">
							<table>
								<tr ng-if="roomItem.booking_price.total.weekday">
									<td>
										<div class="title">{{bookingAppVar.base_price}}</div>
										<div class="duration">x {{roomItem.booking_price.total.weekday.count}} {{bookingAppVar.night_weekday}}</div>
									</td>
									<td class="price">
										<div class="adult">
											<span>
												{{roomItem.booking_price.total.weekday.adult.main}}
											</span>
											<span class="price-counter">
												({{roomItem.booking_price.guest.adult.main}} {{roomItem.booking_price.guest.adult.main == '1' ? bookingAppVar.adult : bookingAppVar.adults }})
											</span>
										</div>
										<div class="adult" ng-if="roomItem.booking_price.guest.adult.extra > 0">
											<span>
												{{roomItem.booking_price.total.weekday.adult.extra}}
											</span>
											<span class="price-counter">
												({{roomItem.booking_price.guest.adult.extra}} {{bookingAppVar.extra}} {{roomItem.booking_price.guest.adult.extra == '1' ? bookingAppVar.adult : bookingAppVar.adults }})
											</span>
										</div>
										<div class="child" ng-if="roomItem.booking_price.guest.child.main > 0">
											<span>
												{{roomItem.booking_price.total.weekday.child.main}}
											</span>
											<span class="price-counter">
												({{roomItem.booking_price.guest.child.main}} {{roomItem.booking_price.guest.child.main == '1' ? bookingAppVar.child : bookingAppVar.children }})
											</span>
										</div>
										<div class="child" ng-if="roomItem.booking_price.guest.child.extra">
											<span>
												{{roomItem.booking_price.total.weekday.child.extra}}
											</span>
											<span class="price-counter">
												({{roomItem.booking_price.guest.child.extra}} {{bookingAppVar.extra}} {{roomItem.booking_price.guest.child.extra == '1' ? bookingAppVar.child : bookingAppVar.children }})
											</span>
										</div>
									</td>
								</tr>
								<tr ng-if="roomItem.booking_price.total.weekend">
									<td>
										<div class="title">{{bookingAppVar.base_price}}</div>
										<div class="duration">x {{roomItem.booking_price.total.weekend.count}} {{bookingAppVar.night_weekend}}</div>
									</td>
									<td class="price">
										<div class="adult">
											<span>
												{{roomItem.booking_price.total.weekend.adult.main}}
											</span>
											<span class="price-counter">
												({{roomItem.booking_price.guest.adult.main}} {{roomItem.booking_price.guest.adult.main == '1' ? bookingAppVar.adult : bookingAppVar.adults }})
											</span>
										</div>
										<div class="adult" ng-if="roomItem.booking_price.guest.adult.extra > 0">
											<span>
												{{roomItem.booking_price.total.weekend.adult.extra}}
											</span>
											<span class="price-counter">
												({{roomItem.booking_price.guest.adult.extra}} {{bookingAppVar.extra}} {{roomItem.booking_price.guest.adult.extra == '1' ? bookingAppVar.adult : bookingAppVar.adults }})
											</span>
										</div>
										<div class="child" ng-if="roomItem.booking_price.guest.child.main > 0">
											<span>
												{{roomItem.booking_price.total.weekend.child.main}}
											</span>
											<span class="price-counter">
												({{roomItem.booking_price.guest.child.main}} {{roomItem.booking_price.guest.child.main == '1' ? bookingAppVar.child : bookingAppVar.children }})
											</span>
										</div>
										<div class="child" ng-if="roomItem.booking_price.guest.child.extra">
											<span>
												{{roomItem.booking_price.total.weekend.child.extra}}
											</span>
											<span class="price-counter">
												({{roomItem.booking_price.guest.child.extra}} {{bookingAppVar.extra}} {{roomItem.booking_price.guest.child.extra == '1' ? bookingAppVar.child : bookingAppVar.children }})
											</span>
										</div>
									</td>
								</tr>
								<tr ng-if="roomItem.booking_price.total.discount">
									<td>
										<div class="title">{{bookingAppVar.discount}}</div>
										<div class="duration">{{roomItem.duration}}{{bookingAppVar.nights}}, {{roomItem.discount_details.percent}}%{{bookingAppVar.off}}</div>
									</td>
									<td class="price">
										{{roomItem.booking_price.total.discount}}
									</td>
								</tr>
								<tr>
									<td>
										<div class="title">{{bookingAppVar.total}}</div>
										<div class="duration">{{bookingAppVar.vat_not_include}}</div>
									</td>
									<td class="price">
										<span>
											{{roomItem.booking_price.total.payable}}
										</span>
									</td>
								</tr>
							</table>
						</div>
					</div>
					<div class="amenities">
						<ul class="list-inline clearfix">
							<li ng-if="roomItem.room_view">
								<div class="title">{{bookingAppVar.view}} :</div>
								<div class="value">{{roomItem.room_view}}</div>
							</li>
							<li ng-if="roomItem.room_size.qnt">
								<div class="title">{{bookingAppVar.room_size}} :</div>
								<div class="value">{{roomItem.room_size.qnt}} {{roomItem.room_size.unit}}</div>
							</li>
							<li ng-if="roomItem.max_people">
								<div class="title">{{bookingAppVar.max_people}} :</div>
								<div class="value">{{roomItem.max_people}}</div>
							</li>
							<li ng-if="roomItem.service" ng-repeat="serviceItem in roomItem.service">
								<div class="title">{{serviceItem.title}} :</div>
								<div class="value">{{serviceItem.value}}</div>
							</li>
							<li ng-if="roomItem.facilities">
								<div class="title">{{bookingAppVar.facilities}} :</div>
								<div class="value">
									<span ng-repeat="facilityItem in roomItem.facilities">{{facilityItem.title}}<span ng-if="!$last">,</span> </span>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="no-room-available" ng-if="availableRoomsStatus === false">
				<div class="mana-title-t-2">
					<div class="title"><span>{{availableRoomsMessage}}</span></div>
					<div class="sub-title">{{bookingAppVar.room_not_available}}</div>
				</div>
			</div>
		</div>
	</div>
</div>