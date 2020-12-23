<div class="col-md-4 l-sec">
	<div class="mana-title-t-2">
		<div class="title">
			<span>{{bookingAppVar.reservation_info}}</span>
		</div>
	</div>
	<form id="room-information-form" method="post" ng-submit="validateForm()">
		<div class="input-daterange">
			<div class="field-row check-in">
				<input type="hidden" class="check-in-input" name="start" ng-model="bookingInfo.checkIn" value="{{bookingInfo.checkIn}}" />
				<div class="check-in-box">
					<div class="title">{{bookingAppVar.check_in}}</div>
					<div class="value">{{bookingInfo.checkIn ? bookingInfo.checkIn : bookingAppVar.choose_a_date}}</div>
				</div>
			</div>
			<div class="field-row check-out">
				<input type="hidden" class="check-out-input" name="end" ng-model="bookingInfo.checkOut" value="{{bookingInfo.checkOut}}" />
				<div class="check-out-box">
					<div class="title">{{bookingAppVar.check_out}}</div>
					<div class="value">{{bookingInfo.checkOut ? bookingInfo.checkOut : bookingAppVar.choose_a_date}}</div>
				</div>
			</div>
			<div class="field-row duration">
				<input type="hidden" name="duration" ng-model="bookingInfo.checkDuration" />
				<div class="duration-box">
					<div class="title">{{bookingAppVar.duration}}</div>
					<div class="value">
						{{bookingInfo.duration > 0 ? bookingInfo.duration : bookingAppVar.choose_a_date}}
						<span ng-if="bookingInfo.duration == 1"> {{bookingAppVar.night}}</span>
						<span ng-if="bookingInfo.duration > 1"> {{bookingAppVar.nights}}</span>
					</div>
				</div>
			</div>
		</div>
		<div class="field-row">
			<div class="alert alert-danger" ng-if="roomCountAlert">{{roomCountAlert}}</div>
			<select name="room-count" class="room-count" ng-model="bookingInfo.roomCount" ng-init="bookingInfo.roomCount = (bookingInfo.roomCount ? bookingInfo.roomCount : '1' )">
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
				<select ng-model="bookingInfo.room[$index]['adult']" name="room[$index]['adult']" class="adult-field" ng-init="bookingInfo.room[$index]['adult'] = (bookingInfo.room[$index]['adult'] ? bookingInfo.room[$index]['adult'] : '1')">
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
				<select ng-model="bookingInfo.room[$index]['child']" name="room[$index]['child']" ng-init="bookingInfo.room[$index]['child'] = (bookingInfo.room[$index]['child'] ? bookingInfo.room[$index]['child'] : '0')">
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
		<div class="field-row btn-container">
			<input type="submit" value="{{bookingAppVar.book_now}}">
		</div>
	</form>
</div>
<div class="col-md-8 r-sec">
	<div class="inner-box">
		<div class="steps">
			<ul class="list-inline">
				<li class="active">{{bookingAppVar.choose_date}}</li>
				<li>{{bookingAppVar.choose_room}}</li>
				<li>{{bookingAppVar.make_a_reservation}}</li>
				<li>{{bookingAppVar.confirmation}}</li>
			</ul>
		</div>
		<div class="alert alert-danger" ng-if="dateAlert">{{dateAlert}}</div>
		<div id="booking-date-range-inline" class="clearfix">
			<div class="check-in col-md-6" name="start" value="{{bookingInfo.checkIn}}"></div>
			<div class="check-out col-md-6" name="end" value="{{bookingInfo.checkOut}}"></div>
		</div>
	</div>
</div>