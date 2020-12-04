"use strict";
jQuery(function ($) {
	var main_image_slider = $("#main-image-slider");
	var thumbnail_slider = $("#thumbnail-slider");

	main_image_slider.owlCarousel({
		singleItem: true,
		slideSpeed: 1000,
		navigation: true,
		pagination: false,
		autoPlay: true,
		afterAction: syncPosition,
		navigationText: ['<span>Prev</span>', '<span>Next</span>'],
		responsiveRefreshRate: 200,
		afterInit: function (el) {
			el.find(".owl-item").eq(0).addClass("active");
		}
	});

	thumbnail_slider.owlCarousel({
		items: 5,
		itemsDesktop: [1199, 6],
		itemsDesktopSmall: [979, 4],
		itemsTablet: [768, 3],
		itemsMobile: [479, 2],
		pagination: false,
		responsiveRefreshRate: 100,
		afterInit: function (el) {
			el.find(".owl-item").eq(0).addClass("synced");
		}
	});

	function syncPosition(el) {
		var current = this.currentItem;
		thumbnail_slider.find(".owl-item").removeClass("synced").eq(current).addClass("synced");
		main_image_slider.find(".owl-item").removeClass("active").eq(current).addClass("active");
		if (thumbnail_slider.data("owlCarousel") !== undefined) {
			center(current);
		}
	}

	thumbnail_slider.on("click", ".owl-item", function (e) {
		e.preventDefault();
		var number = $(this).data("owlItem");
		main_image_slider.trigger("owl.goTo", number);
	});

	function center(number) {
		var thumbnail_slidervisible = thumbnail_slider.data("owlCarousel").owl.visibleItems;
		var num = number;
		var found = false;
		for (var i in thumbnail_slidervisible) {
			if (num === thumbnail_slidervisible[i]) {
				found = true;
			}
		}

		if (found === false) {
			if (num > thumbnail_slidervisible[thumbnail_slidervisible.length - 1]) {
				thumbnail_slider.trigger("owl.goTo", num - thumbnail_slidervisible.length + 2);
			} else {
				if (num - 1 === -1) {
					num = 0;
				}
				thumbnail_slider.trigger("owl.goTo", num);
			}
		} else if (num === thumbnail_slidervisible[thumbnail_slidervisible.length - 1]) {
			thumbnail_slider.trigger("owl.goTo", thumbnail_slidervisible[1]);
		} else if (num === thumbnail_slidervisible[0]) {
			thumbnail_slider.trigger("owl.goTo", num - 1);
		}
	}

	var mainBookingForm = $('.main-availability-form'),
		roomFieldContainer = mainBookingForm.find('.room-field-container'),
		roomItemTmpl = mainBookingForm.find('.room-field-tmpl');

	mainBookingForm.find('.room-count').on('change', function () {
		var _this = $(this),
			_thisVal = parseInt(_this.val(), 10);

		roomFieldContainer.empty();
		if (_thisVal) {
			for (var i = 0; i < _thisVal; i++) {
				var cloneTmpl = roomItemTmpl.clone();
				cloneTmpl.removeClass('room-field-tmpl');
				cloneTmpl.html(function (j, cloneTmplOld) {
					return cloneTmplOld.replace(/{{id}}/g, i).replace(/{{id_}}/g, (i + 1));
				});
				cloneTmpl.appendTo(roomFieldContainer);
			}
		}

		roomFieldContainer.find('select').select2({
			minimumResultsForSearch: 10
		});
	});

	var roomBookingForm = $('.room-booking-form-container'),
		roomFieldContainerV = roomBookingForm.find('.room-field-container'),
		roomItemTmplV = roomBookingForm.find('.room-field-tmpl');

	roomBookingForm.find('.room-count').on('change', function () {
		var _this = $(this),
			_thisVal = parseInt(_this.val(), 10);

		roomFieldContainerV.empty();
		if (_thisVal) {
			for (var i = 0; i < _thisVal; i++) {
				var cloneTmpl = roomItemTmplV.clone();
				cloneTmpl.removeClass('room-field-tmpl');
				cloneTmpl.html(function (j, cloneTmplOld) {
					return cloneTmplOld.replace(/{{id}}/g, i).replace(/{{id_}}/g, (i + 1));
				});
				cloneTmpl.appendTo(roomFieldContainerV);
			}
		}

		roomFieldContainerV.find('select').select2({
			minimumResultsForSearch: 10
		});
	});

	$('#login-form-url, #login-register-url, .booking-more-info-btn').magnificPopup({
		type: 'inline',
		preloader: false,
		mainClass: 'mfp-fade',
		removalDelay: 600
	});

	// Login Ajax
	var loginFrom = $('#login-form').find('form');
	loginFrom.on("submit", function (e) {
		e.preventDefault();
		loginFrom.parent().addClass("loading");
		loginFrom.find('.error-box').removeClass("alert alert-danger").text('');
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: mana_booking_front.ajaxurl,
			data: {
				'action': 'mana_booking_login',
				'username': loginFrom.find('.email').val(),
				'password': loginFrom.find('.pass').val(),
				'security': loginFrom.find('#security-login').val()
			},
			success: function (data) {
				loginFrom.parent().removeClass("loading");
				if (data.loggedin === true) {
					document.location.href = mana_booking_front.redirecturl;
				} else {
					loginFrom.find('.error-box').addClass("alert alert-danger").text(data.message);
				}
			}
		});
	});

	// Register Ajax
	var registerFrom = $('#register-form').find('form');
	registerFrom.on("submit", function (e) {
		e.preventDefault();
		registerFrom.find('.error-box').removeClass("alert alert-danger").text('');
		var userName = registerFrom.find('.user-name'),
			email = registerFrom.find('.email');

		if (userName.val() !== '' && email.val() !== '') {
			registerFrom.parent().addClass("loading");
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: mana_booking_front.ajaxurl,
				data: {
					'action': 'mana_booking_register',
					'username': userName.val(),
					'email': email.val(),
					'security': registerFrom.find('#security-register').val()
				},
				success: function (data) {
					registerFrom.parent().removeClass("loading");
					userName.parent().removeClass('has-error');
					email.parent().removeClass('has-error');
					if (data.loggedin === true) {
						registerFrom.find('.error-box').addClass("alert alert-success").text(data.message);
					} else {
						registerFrom.find('.error-box').addClass("alert alert-danger").text(data.message);
					}
				}
			});
		} else {
			registerFrom.removeClass("loading");
			userName.parent().removeClass('has-error');
			email.parent().removeClass('has-error');
			if (userName.val() === '') {
				userName.parent().addClass('has-error');
			}
			if (email.val() === '') {
				email.parent().addClass('has-error');
			}
			return false;
		}
	});

	// Profile Form Ajax
	var profileForm = $('#profile-form');
	profileForm.on('submit', function (e) {
		e.preventDefault();
		var _this = $(this),
			messageBox = profileForm.find('.message-box'),
			fName = _this.find('#profile-first-name').val(),
			lName = _this.find('#profile-last-name').val(),
			phone = _this.find('#profile-phone').val(),
			email = _this.find('#profile-email').val(),
			address = _this.find('#profile-address').val();
		_this.addClass('loading');
		messageBox.addClass('not-active');
		if (!fName || !lName || !email) {
			messageBox.removeClass('not-active');
		} else {
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: mana_booking_front.ajaxurl,
				data: {
					'action': 'mana_booking_update_profile',
					'fName': fName,
					'lName': lName,
					'phone': phone,
					'email': email,
					'address': address,
					'security': _this.find('#_wpnonce').val()
				},
				success: function (data) {
					_this.removeClass('loading');
					if (data.status === true) {
						messageBox.removeClass('not-active alert-danger').addClass('alert-success').text(data.message);
					} else {
						messageBox.removeClass('not-active alert-success').addClass('alert-danger').text(data.message);
					}
				}
			});
		}
	});

	if (typeof $.fn.barrating === 'function') {
		$(".rate-items").barrating("show", {
			onSelect: function (value, text, event) {
				var _this = $(event.srcElement),
					selectBox = _this.parent().siblings('select'),
					clickedItem = selectBox.attr('name'),
					security = selectBox.data('security'),
					postID = selectBox.data('room-id'),
					messageBox = selectBox.parents('.progress').next('.message-box');

				messageBox.addClass("hidden");

				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: mana_booking_front.ajaxurl,
					data: {
						'action': "mana_booking_rating",
						'id': postID,
						'rateVal': value,
						'security': security,
						'rateItem': clickedItem
					},
					success: function (data) {
						if (data.status === true) {
							messageBox.removeClass("hidden").text(data.message);
						} else {
							messageBox.removeClass("hidden").text(data.message);
						}
					}
				});
			}
		});
	}

	var currencySwitchers = $('[id*="currency-switcher-select-"]');
	if (currencySwitchers.length > 0) {
		currencySwitchers.on('change', function () {
			var _this = $(this),
				postData = {
					action: "mana_booking_currency_cookie",
					currency: _this.val()
				};
			$.ajax({
				url: mana_booking_front.ajaxurl,
				type: 'POST',
				dataType: 'json',
				data: postData,
				success: function (data) {
					if (data.status === true) {
						location.reload();
					}
				}
			});
		});
	}
});