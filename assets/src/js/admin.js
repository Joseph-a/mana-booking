"use strict";
import "./react/room-meta";
import "./react/block-dates";

// jQuery.fn.digits = function()
// {
// 	return this.each( function()
// 	{
// 		jQuery( this ).next().find( '.digit' ).text( jQuery( this ).val().replace( /(\d)(?=(\d\d\d)+(?!\d))/g, "$1," ) );
// 	} )
// };

// function downloadInnerHtml( filename, elId, mimeType )
// {
// 	var elHtml = document.getElementById( elId ).value;
// 	var link = document.createElement( 'a' );
// 	mimeType = mimeType || 'text/plain';

// 	link.setAttribute( 'download', filename );
// 	link.setAttribute( 'href', 'data:' + mimeType + ';charset=utf-8,' + encodeURIComponent( elHtml ) );
// 	link.click();
// }

// jQuery( document ).ready( function( )
// {

// 	jQuery( "#tabs" ).tabs();

// 	jQuery( '.price-field' ).on( 'keyup', function()
// 	{
// 		jQuery( this ).digits();
// 	} );
// 	jQuery( '.repeatable-add' ).on( 'click', function()
// 	{
// 		var field = jQuery( this ).next( 'ul' ).children( 'li' ).clone( true ),
// 			// fieldLocation = jQuery(this).closest('td').find('.custom_repeatable li:last'),
// 			fieldIndex = jQuery( '.custom_repeatable li' ).length;

// 		var firstField = jQuery( this ).closest( 'td' ).find( '.custom_repeatable' ).append( field );
// 		firstField.find( 'li' ).last().find( 'input' ).each( function( )
// 		{
// 			var _this = jQuery( this );
// 			if ( _this.hasClass( 'multiple-name' ) )
// 			{
// 				if ( _this.data( 'prefix' ) === 'extra' )
// 				{
// 					_this.attr( 'name', _this.attr( 'id' ) + "[" + fieldIndex + "][" + _this.data( 'prefix' ) + "][" + _this.data( 'fname' ) + "][" + _this.data( 'sname' ) + "]" );
// 					_this.attr( 'id', _this.attr( 'id' ) + "_" + fieldIndex + "_" + _this.data( 'prefix' ) + "_" + _this.data( 'fname' ) + "_" + _this.data( 'sname' ) );
// 				}
// 				else
// 				{
// 					_this.attr( 'name', _this.attr( 'id' ) + "[" + fieldIndex + "][" + _this.data( 'fname' ) + "][" + _this.data( 'sname' ) + "]" );
// 					_this.attr( 'id', _this.attr( 'id' ) + "_" + fieldIndex + "_" + _this.data( 'fname' ) + "_" + _this.data( 'sname' ) );
// 				}
// 			}
// 			else
// 			{
// 				_this.attr( 'name', _this.attr( 'id' ) + "[" + fieldIndex + "][" + _this.data( 'name' ) + "]" );
// 				if ( _this.data( 'id' ) )
// 				{
// 					_this.attr( 'id', ( _this.data( 'id' ) ).replace( /{{id}}/g, fieldIndex ) );
// 				}
// 			}

// 			if ( _this.hasClass( 'from' ) )
// 			{
// 				_this.datepicker(
// 				{
// 					dateFormat: "yy-mm-dd",
// 					minDate: 0,
// 					numberOfMonths: 2,
// 					onClose: function( selectedDate )
// 					{
// 						_this.parents( '.row' ).find( ".to" ).datepicker( "option", "minDate", selectedDate );
// 					}
// 				} );
// 			}
// 			else if ( _this.hasClass( 'to' ) )
// 			{
// 				_this.datepicker(
// 				{
// 					dateFormat: "yy-mm-dd",
// 					minDate: 0,
// 					numberOfMonths: 2,
// 					onClose: function( selectedDate )
// 					{
// 						_this.parents( '.row' ).find( ".from" ).datepicker( "option", "maxDate", selectedDate );
// 					}
// 				} );
// 			}
// 		} );

// 		return false;
// 	} );

// 	jQuery( '.repeatable-remove' ).on( 'click', function()
// 	{
// 		jQuery( this ).parent().remove();
// 		return false;
// 	} );

// 	if ( jQuery.isFunction( jQuery.fn.datepicker ) )
// 	{
// 		jQuery( ".datepicker" ).datepicker(
// 		{
// 			dateFormat: "yy-mm-dd",
// 			minDate: 0
// 		} );

// 		jQuery( ".datepicker.from, .datepicker.to" ).datepicker( "destroy" );
// 		jQuery( ".datepicker.from" ).datepicker(
// 		{
// 			dateFormat: "yy-mm-dd",
// 			minDate: 0,
// 			numberOfMonths: 2,
// 			onClose: function( selectedDate )
// 			{
// 				jQuery( ".to" ).datepicker( "option", "minDate", selectedDate );
// 			}
// 		} );
// 		jQuery( ".datepicker.to" ).datepicker(
// 		{
// 			dateFormat: "yy-mm-dd",
// 			minDate: 0,
// 			numberOfMonths: 2,
// 			onClose: function( selectedDate )
// 			{
// 				jQuery( ".from" ).datepicker( "option", "maxDate", selectedDate );
// 			}
// 		} );
// 	}

// 	/**
// 	 * ------------------------------------------------------------------------------------------
// 	 *  Gallery Uploader - Meta Boxes
// 	 * ------------------------------------------------------------------------------------------
// 	 */
// 	// Uploading files
// 	var slideshow_frame;
// 	jQuery( '.add_slideshow_images' ).on( 'click', function( event )
// 	{

// 		event.preventDefault();

// 		var _this = jQuery( this ),
// 			image_slideshow_ids = _this.prev( 'input' ),
// 			currentSliderShowContainer = _this.parents( '.ravis_slideshow_wrapper' ),
// 			attachment_ids = image_slideshow_ids.val();

// 		// Create the media frame.
// 		slideshow_frame = wp.media.frames.downloadable_file = wp.media(
// 		{
// 			// Set to true to allow multiple files to be selected
// 			multiple: true
// 		} );

// 		// When an image is selected, run a callback.
// 		slideshow_frame.on( 'select', function()
// 		{
// 			var selection = slideshow_frame.state().get( 'selection' );

// 			selection.map( function( attachment )
// 			{
// 				attachment = attachment.toJSON();
// 				if ( attachment.id )
// 				{
// 					attachment_ids = ( jQuery.trim( attachment_ids ) != '' ? jQuery.trim( attachment_ids ) + "---" + attachment.id : attachment.id );
// 					if ( currentSliderShowContainer.hasClass( 'attachments' ) )
// 					{
// 						currentSliderShowContainer.children( 'ul' ).append( '<li class="image" data-attachment_id="' + attachment.id + '">' + attachment.filename + '<span><a href="#" class="delete_slide"><i class="dashicons dashicons-no"></i></a></span></li>' );
// 					}
// 					else
// 					{
// 						currentSliderShowContainer.children( 'ul' ).append( '<li class="image" data-attachment_id="' + attachment.id + '"><img src="' + ( attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.sizes.full.url ) + '" /><span><a href="#" class="delete_slide"><i class="dashicons dashicons-no"></i></a></span></li>' );
// 					}
// 				}
// 			} );
// 			image_slideshow_ids.val( attachment_ids );
// 		} );

// 		// Finally, open the modal
// 		slideshow_frame.open();
// 	} );
// 	// Remove files
// 	jQuery( '.ravis_slideshow_wrapper' ).on( 'click', 'a.delete_slide', function()
// 	{
// 		var _this = jQuery( this ),
// 			currentSliderShowContainer = _this.parents( '.ravis_slideshow_wrapper' ),
// 			attachment_ids = '',
// 			i = 0;

// 		_this.closest( '.image' ).remove();
// 		currentSliderShowContainer.find( '.image' ).each( function()
// 		{
// 			var attachment_id = jQuery( this ).attr( 'data-attachment_id' );
// 			attachment_ids = ( i === 0 ? attachment_id : attachment_ids + '---' + attachment_id );
// 			i++;
// 		} );

// 		currentSliderShowContainer.find( 'input[type="hidden"]' ).val( attachment_ids );
// 		return false;
// 	} );


// 	/**
// 	 * ------------------------------------------------------------------------------------------
// 	 *  Currency Management
// 	 * ------------------------------------------------------------------------------------------
// 	 */

// 	jQuery( '.currency-add' ).on( 'click', function()
// 	{
// 		var field = jQuery( this ).parent().next().children().clone( true ),
// 			fieldContainer = jQuery( '.currency-boxes-container' ),
// 			fieldIndex = fieldContainer.find( '.currency-box' ).length;

// 		var firstField = fieldContainer.append( field );
// 		firstField.find( '.currency-box' ).last().find( 'input' ).each( function( )
// 		{
// 			var _this = jQuery( this );
// 			if ( !_this.is( ':radio' ) )
// 			{
// 				_this.attr( 'name', "ravis-booking-setting[currency][" + fieldIndex + "][" + _this.data( 'name' ) + "]" );
// 				_this.removeAttr( 'id' );
// 			}
// 			else
// 			{
// 				_this.attr( 'value', fieldIndex );
// 			}
// 		} );

// 		return false;
// 	} );
// 	jQuery( '.currency-box' ).on( 'click', '.remove-box', function()
// 	{
// 		jQuery( this ).parent().remove();
// 		return false;
// 	} );
// 	jQuery( '.currency-default' ).find( 'input[type="radio"]' ).on( 'click', function( )
// 	{
// 		jQuery( this ).parents( '.currency-box' ).addClass( 'default' ).siblings().removeClass( 'default' );
// 	} );

// 	/**
// 	 * ------------------------------------------------------------------------------------------
// 	 *  Email Receiver Management
// 	 * ------------------------------------------------------------------------------------------
// 	 */
// 	jQuery( '.add-email-receiver' ).on( 'click', function( e )
// 	{
// 		e.preventDefault();
// 		var _this = jQuery( this ),
// 			field = _this.parent().next( '.email-receiver-tpl' ).children().clone( true ),
// 			fieldContainer = _this.parents( '.email-receiver-container' ).children( 'ul' ).first(),
// 			fieldLength = fieldContainer.find( 'li' ).length,
// 			highestIndex = 0;

// 		if ( fieldLength > 0 )
// 		{
// 			fieldContainer.find( 'li' ).each( function( )
// 			{
// 				var _this_li = jQuery( this ),
// 					itemIndex = ( _this_li.children( 'input' ).attr( 'name' ) ).replace( 'ravis-booking-setting[rating_item][', '' ),
// 					itemIndexVal = parseInt( itemIndex.slice( ']', -1 ) );

// 				if ( itemIndexVal > highestIndex )
// 				{
// 					highestIndex = itemIndexVal;
// 				}
// 			} );
// 			highestIndex += 1;
// 		}

// 		fieldContainer.append( field );
// 		fieldContainer.find( 'li' ).last().find( 'input' ).each( function( )
// 		{
// 			var _this = jQuery( this ),
// 				fieldName = _this.data( 'name' );
// 			_this.attr( 'name', "ravis-booking-setting[" + fieldName + "][" + highestIndex + "]" );
// 		} );

// 		return false;
// 	} );
// 	jQuery( '.email-receiver-container' ).on( 'click', '.remove-box', function()
// 	{
// 		jQuery( this ).parent().remove();
// 		return false;
// 	} );

// 	/**
// 	 * ------------------------------------------------------------------------------------------
// 	 *  Currency Updater Codes
// 	 * ------------------------------------------------------------------------------------------
// 	 */
// 	jQuery( '#currency-update-now' ).on( 'click', 'a', function( e )
// 	{
// 		e.preventDefault();
// 		var _parent = jQuery( '#currency-update-now' );
// 		_parent.addClass( 'loading' );
// 		jQuery.ajax(
// 		{
// 			type: "POST",
// 			url: ravis_booking.ajaxurl,
// 			data:
// 			{
// 				action: "ravis_booking_update_currency"
// 			}
// 		} ).done( function( data )
// 		{
// 			_parent.removeClass( 'loading' );
// 			var dataReturn = JSON.parse( data ),
// 				currencyItems = jQuery( '#tabs-3' ).find( '.currency-box-active' );

// 			currencyItems.each( function( index )
// 			{
// 				var rateBox = jQuery( this ).find( '.currency-rate' );
// 				rateBox.val( dataReturn[ index ] );
// 			} );

// 			jQuery( '#ravis-booking-setting-page' ).find( '#submit' ).trigger( 'click' );
// 		} );
// 	} );

// 	/**
// 	 * ------------------------------------------------------------------------------------------
// 	 *  Gallery and Slider Code in Plugin Options
// 	 * ------------------------------------------------------------------------------------------
// 	 */
// 	jQuery( '.admin-img-uploader' ).on( 'click', function( event )
// 	{
// 		event.preventDefault();
// 		var _this = jQuery( this ),
// 			_parent = _this.parent(),
// 			imgField = _parent.find( '.img-field' ),
// 			imageContainer = _parent.find( '.img-uploader' );

// 		if ( _this.hasClass( 'clear-btn' ) )
// 		{
// 			imageContainer.html( '' );
// 			imgField.val( '' );
// 		}
// 		else
// 		{

// 			wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend(
// 			{
// 				template: function( )
// 				{
// 					return;
// 				}
// 			} );

// 			var val = imgField.val();
// 			var final;

// 			if ( !val )
// 			{
// 				final = '[gallery ids="0"]';
// 			}
// 			else
// 			{
// 				final = '[gallery ids="' + val + '"]';
// 			}

// 			var frame = wp.media.gallery.edit( final );

// 			frame.state( 'gallery-edit' ).on(
// 				'update',
// 				function( selection )
// 				{
// 					imageContainer.html( '' );
// 					var ids = selection.models.map(
// 						function( e )
// 						{
// 							var element = e.toJSON(),
// 								preview_img = typeof element.sizes.thumbnail !== 'undefined' ? element.sizes.thumbnail.url : element.url,
// 								preview_html = '<div class="image-preview-box"><img src="' + preview_img + '"/></div>';
// 							imageContainer.append( preview_html );
// 							return e.id;
// 						}
// 					);
// 					imgField.val( ids.join( ',' ) );
// 				}
// 			);
// 		}
// 	} );

// 	/**
// 	 * ------------------------------------------------------------------------------------------
// 	 *  Client Managements
// 	 * ------------------------------------------------------------------------------------------
// 	 */
// 	jQuery( '.client-add' ).on( 'click', function()
// 	{
// 		var field = jQuery( this ).parent().next( '.client-box-tpl' ).children().clone( true ),
// 			fieldContainer = jQuery( '.client-boxes-container' ),
// 			fieldIndex = fieldContainer.find( '.client-box' ).length;

// 		var firstField = fieldContainer.append( field );

// 		firstField.find( '.client-box' ).last().find( 'input' ).each( function( )
// 		{
// 			var _this = jQuery( this );
// 			_this.attr( 'name', "ravis-booking-setting[client][" + fieldIndex + "][" + _this.data( 'name' ) + "]" );
// 			_this.removeAttr( 'id' );
// 		} );

// 		return false;
// 	} );
// 	jQuery( '.client-box' ).on( 'click', '.remove-box', function()
// 	{
// 		jQuery( this ).parent().remove();
// 		return false;
// 	} );
// 	jQuery( '.client-default' ).find( 'input[type="radio"]' ).on( 'click', function( )
// 	{
// 		jQuery( this ).parents( '.client-box' ).addClass( 'default' ).siblings().removeClass( 'default' );
// 	} );

// 	/**
// 	 * ------------------------------------------------------------------------------------------
// 	 *  Single Image Uploader Management
// 	 * ------------------------------------------------------------------------------------------
// 	 */

// 	var singleImageUploader = jQuery( '.single-image-uploader' );
// 	singleImageUploader.on( 'click', '.add-image', function( event )
// 	{
// 		event.preventDefault();
// 		var _this = jQuery( this ),
// 			_parent = _this.parents( '.single-image-uploader' ),
// 			img_id = _parent.find( 'input[type="hidden"]' ),
// 			img_container = _parent.find( '.img-container' );

// 		// Create the media frame.
// 		slideshow_frame = wp.media.frames.downloadable_file = wp.media();

// 		// When an image is selected, run a callback.
// 		slideshow_frame.on( 'select', function()
// 		{
// 			var selection = slideshow_frame.state().get( 'selection' );

// 			selection.map( function( attachment )
// 			{
// 				attachment = attachment.toJSON();
// 				if ( attachment.id )
// 				{
// 					var preview_html = '<div class="image-preview-box"><img src="' + ( attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.sizes.full.url ) + '"/></div>';
// 					img_container.html( '' ).append( preview_html );
// 					img_id.val( attachment.id );

// 					_this.addClass( 'hidden' ).siblings( '.remove-image' ).removeClass( 'hidden' );
// 				}
// 			} );
// 		} );

// 		// Finally, open the modal
// 		slideshow_frame.open();
// 	} );
// 	// Remove files
// 	singleImageUploader.on( 'click', '.remove-image', function( event )
// 	{
// 		event.preventDefault();
// 		var _this = jQuery( this ),
// 			_parent = _this.parents( '.single-image-uploader' ),
// 			img_id = _parent.find( 'input[type="hidden"]' ),
// 			img_container = _parent.find( '.img-container' );

// 		img_id.val( '' );
// 		img_container.html( '' );
// 		_this.addClass( 'hidden' ).siblings( '.add-image' ).removeClass( 'hidden' );
// 	} );


// 	var fileName = 'ravis-booking-settings.json';
// 	jQuery( '#export-ravis-booking-setting' ).click( function()
// 	{
// 		downloadInnerHtml( fileName, 'ravis-booking-export-data', 'application/json' );
// 	} );

// 	jQuery( '#import-ravis-booking-setting' ).on( 'click', function( e )
// 	{
// 		e.preventDefault();
// 		var _this = jQuery( this ),
// 			importOptions = jQuery( '#import-ravis-booking-setting-field' ).val(),
// 			messageBox = _this.next( '.message-box' );
// 		if ( importOptions !== '' )
// 		{
// 			_this.addClass( 'loading' );
// 			jQuery.ajax(
// 			{
// 				type: "POST",
// 				url: ravis_booking.ajaxurl,
// 				data:
// 				{
// 					action: "ravis_booking_import_options",
// 					options: importOptions
// 				}
// 			} ).done( function( data )
// 			{
// 				var parsedData = JSON.parse( data );
// 				if ( parsedData.status === true )
// 				{
// 					messageBox.removeClass( 'red' ).addClass( 'green' ).text( parsedData.message );
// 					_this.removeClass( 'loading' );
// 					location.reload();
// 				}
// 				if ( parsedData.status === false )
// 				{
// 					messageBox.text( parsedData.message );
// 					_this.removeClass( 'loading' );
// 				}
// 			} );
// 		}
// 	} );

// 	/**
// 	 * ------------------------------------------------------------------------------------------
// 	 *  Menu Items add
// 	 * ------------------------------------------------------------------------------------------
// 	 */
// 	jQuery( '.menu-item-add' ).on( 'click', function()
// 	{
// 		var _this = jQuery( this ),
// 			field = _this.next( 'ul' ).children( 'li' ).clone( true ),
// 			fieldIndex = _this.siblings( '.custom_repeatable' ).find( 'li' ).length;

// 		var firstField = _this.closest( 'td' ).find( '.custom_repeatable' ).append( field );
// 		firstField.find( 'li' ).last().find( 'input' ).each( function( )
// 		{
// 			var _this = jQuery( this ),
// 				inputName = _this.data( 'name' );
// 			if ( inputName )
// 			{
// 				_this.attr( 'name', _this.attr( 'id' ) + "[items][" + fieldIndex + "][" + inputName + "]" );
// 			}
// 			else
// 			{
// 				_this.val( fieldIndex );
// 			}
// 		} );

// 		return false;
// 	} );
// 	jQuery( '.menu-item-remove' ).on( 'click', function()
// 	{
// 		jQuery( this ).parent().remove();
// 		return false;
// 	} );


// 	/**
// 	 * ------------------------------------------------------------------------------------------
// 	 *  Event Booking List
// 	 * ------------------------------------------------------------------------------------------
// 	 */
// 	var event_booking_tbl = jQuery( '#event-booking-list' );
// 	event_booking_tbl.on( 'click', '.confirm-item', function( e )
// 	{
// 		e.preventDefault();
// 		var _this = jQuery( this ),
// 			nonce = _this.data( 'nonce' ),
// 			eventBookingID = _this.parents( 'tr' ).data( 'event-booking-id' );

// 		if ( !_this.hasClass( 'confirmed' ) )
// 		{
// 			var data = {
// 				action: 'ravis_booking_event_booking_status',
// 				nonce: nonce,
// 				eventBookingID: eventBookingID
// 			};
// 			jQuery.post( ravis_booking.ajaxurl, data, function( data )
// 			{
// 				var data = JSON.parse( jQuery.trim( data ) );
// 				if ( data.status === true )
// 				{
// 					location.reload();
// 				}
// 			} );
// 		}

// 	} );

// 	event_booking_tbl.on( 'click', '.delete-item', function( e )
// 	{
// 		e.preventDefault();
// 		var _this = jQuery( this ),
// 			nonce = _this.data( 'nonce' ),
// 			eventBookingID = _this.parents( 'tr' ).data( 'event-booking-id' ),
// 			result = confirm( "Do you really want to remove this item?" );

// 		if ( result )
// 		{
// 			var data = {
// 				action: 'ravis_booking_event_booking_delete',
// 				nonce: nonce,
// 				eventBookingID: eventBookingID
// 			};
// 			jQuery.post( ravis_booking.ajaxurl, data, function( data )
// 			{
// 				var data = JSON.parse( jQuery.trim( data ) );
// 				if ( data.status === true )
// 				{
// 					location.reload();
// 				}
// 			} );
// 		}
// 	} );

// 	var service_price_type = jQuery( '#ravis_booking_service_price_type' ),
// 		service_booking = jQuery( '#ravis_booking_service_booking' );

// 	if ( service_booking.is( ':checked' ) )
// 	{
// 		service_booking.parents( 'tr' ).siblings( '.price-type' ).show();
// 	}
// 	if ( service_price_type.val() === '2' )
// 	{
// 		service_price_type.parents( 'tr' ).siblings( '.paid-service' ).show();
// 	}

// 	service_booking.on( 'change', function( e )
// 	{
// 		e.preventDefault();
// 		var _this = jQuery( this );
// 		if ( _this.is( ':checked' ) )
// 		{
// 			_this.parents( 'tr' ).siblings( '.price-type' ).show();
// 		}
// 		else
// 		{
// 			_this.parents( 'tr' ).siblings( '.price-type' ).hide();
// 			var paidRows = _this.parents( 'tr' ).siblings( '.paid-service' );
// 			paidRows.hide();
// 			paidRows.find( 'input' ).val( '' );
// 			paidRows.find( 'select' ).val( '' );
// 			service_price_type.val( '1' );
// 		}
// 	} );
// 	service_price_type.on( 'change', function( e )
// 	{
// 		e.preventDefault();
// 		var _this = jQuery( this );
// 		if ( _this.val() === '2' )
// 		{
// 			_this.parents( 'tr' ).siblings( '.paid-service' ).show();
// 		}
// 		else
// 		{
// 			var paidRows = _this.parents( 'tr' ).siblings( '.paid-service' );
// 			paidRows.hide();
// 			paidRows.find( 'input' ).val( '' );
// 			paidRows.find( 'select' ).val( '' );
// 		}
// 	} );

// 	var guestSelect = jQuery( '.ravis-service-price-box' ).find( '[name*=guest]' );
// 	guestSelect.on( 'change', function( e )
// 	{
// 		e.preventDefault();
// 		var _this = jQuery( this );

// 		if ( _this.val() === '2' )
// 		{
// 			_this.next( '.service-price-type' ).hide();
// 		}
// 		else
// 		{
// 			_this.next( '.service-price-type' ).show();
// 		}
// 	} );

// 	if ( guestSelect.val() === '2' )
// 	{
// 		guestSelect.next( '.service-price-type' ).hide();
// 	}
// 	else
// 	{
// 		guestSelect.next( '.service-price-type' ).show();
// 	}

// 	/**
// 	 * ------------------------------------------------------------------------------------------
// 	 *  Membership Management
// 	 * ------------------------------------------------------------------------------------------
// 	 */

// 	var membershipSwitcher = jQuery( '.membership-condition-switcher' );
// 	membershipSwitcher.each( function( )
// 	{
// 		var _this = jQuery( this ),
// 			parentBox = _this.parents( '.membership-package-box' ),
// 			priceBox = parentBox.find( '.total-booking-price' ),
// 			countBox = parentBox.find( '.total-booking-item' ),
// 			priceCountBox = parentBox.find( '.total-booking-price-item' );
// 		switch ( _this.val() )
// 		{
// 			case '1':
// 				priceBox.removeClass( 'hidden' );
// 				countBox.addClass( 'hidden' ).find( 'input' ).val( '' );
// 				priceCountBox.addClass( 'hidden' ).find( 'input' ).val( '' );
// 				break;
// 			case '2':
// 				priceBox.addClass( 'hidden' ).find( 'input' ).val( '' );
// 				countBox.removeClass( 'hidden' );
// 				priceCountBox.addClass( 'hidden' ).find( 'input' ).val( '' );
// 				break;
// 			case '3':
// 				priceBox.addClass( 'hidden' ).find( 'input' ).val( '' );
// 				countBox.addClass( 'hidden' ).find( 'input' ).val( '' );
// 				priceCountBox.removeClass( 'hidden' );
// 				break;
// 		}
// 	} );

// 	membershipSwitcher.on( 'change', function( e )
// 	{
// 		e.preventDefault();
// 		var _this = jQuery( this ),
// 			parentBox = _this.parents( '.membership-package-box' ),
// 			priceBox = parentBox.find( '.total-booking-price' ),
// 			countBox = parentBox.find( '.total-booking-item' ),
// 			priceCountBox = parentBox.find( '.total-booking-price-item' );

// 		switch ( _this.val() )
// 		{
// 			case '1':
// 				priceBox.removeClass( 'hidden' );
// 				countBox.addClass( 'hidden' ).find( 'input' ).val( '' );
// 				priceCountBox.addClass( 'hidden' ).find( 'input' ).val( '' );
// 				break;
// 			case '2':
// 				priceBox.addClass( 'hidden' ).find( 'input' ).val( '' );
// 				countBox.removeClass( 'hidden' );
// 				priceCountBox.addClass( 'hidden' ).find( 'input' ).val( '' );
// 				break;
// 			case '3':
// 				priceBox.addClass( 'hidden' ).find( 'input' ).val( '' );
// 				countBox.addClass( 'hidden' ).find( 'input' ).val( '' );
// 				priceCountBox.removeClass( 'hidden' );
// 				break;
// 		}
// 	} );

// 	jQuery( '.membership-add' ).on( 'click', function()
// 	{
// 		var field = jQuery( this ).parent().next( '.membership-box-tpl' ).children().clone( true ),
// 			fieldContainer = jQuery( '.membership-package-main-container' ),
// 			fieldIndex = fieldContainer.find( '.membership-package-box' ).length;

// 		var firstField = fieldContainer.append( field );

// 		firstField.find( '.membership-package-box' ).last().find( 'input' ).each( function( )
// 		{
// 			var _this = jQuery( this );
// 			_this.attr( 'name', "ravis-booking-setting[membership][" + fieldIndex + "][" + _this.data( 'name' ) + "]" );
// 		} );
// 		firstField.find( '.membership-package-box' ).last().find( 'select' ).each( function( )
// 		{
// 			var _this = jQuery( this );
// 			_this.attr( 'name', "ravis-booking-setting[membership][" + fieldIndex + "][" + _this.data( 'name' ) + "]" );
// 		} );

// 		return false;
// 	} );
// 	jQuery( '.membership-package-box' ).on( 'click', '.remove-box', function()
// 	{
// 		jQuery( this ).parent().remove();
// 		return false;
// 	} );

// 	/**
// 	 * ------------------------------------------------------------------------------------------
// 	 *  Booking Archive Codes
// 	 * ------------------------------------------------------------------------------------------
// 	 */
// 	var bookingArchiveMainContainer = jQuery( '#ravis-booking-booking-archive' );
// 	bookingArchiveMainContainer.on( 'click', '.booking-more', function( e )
// 	{
// 		e.preventDefault();
// 		var _this = jQuery( this );
// 		_this.toggleClass( 'active' ).parent( 'tr' ).next().toggleClass( 'hidden' ).siblings( 'tr.more-details' ).addClass( 'hidden' ).prev().find( '.booking-more' ).removeClass( 'active' );
// 	} );

// 	bookingArchiveMainContainer.on( 'click', '.update-status-item', function( e )
// 	{
// 		e.preventDefault();
// 		var _this = jQuery( this );
// 		jQuery.ajax(
// 		{
// 			type: "POST",
// 			url: ravis_booking.ajaxurl,
// 			data:
// 			{
// 				action: "ravis_booking_update_booking_status",
// 				id: _this.data( 'id' ),
// 				security: _this.data( 'nonce' ),
// 				lang: _this.data( 'lang' )
// 			}
// 		} ).done( function( data )
// 		{
// 			var dataN = JSON.parse( data );
// 			if ( dataN.status === true )
// 			{
// 				_this.removeClass( 'confirmed not-confirmed' ).addClass( dataN.class );
// 			}
// 		} );
// 	} );

// 	bookingArchiveMainContainer.on( 'click', '.delete-item', function( e )
// 	{
// 		var response = confirm( ravis_booking.delete_alert );
// 		e.preventDefault();
// 		if ( response === true )
// 		{
// 			var _this = jQuery( this );
// 			jQuery.ajax(
// 			{
// 				type: "POST",
// 				url: ravis_booking.ajaxurl,
// 				data:
// 				{
// 					action: "ravis_booking_delete_booking",
// 					id: _this.data( 'id' ),
// 					security: _this.data( 'nonce' )
// 				}
// 			} ).done( function( data )
// 			{
// 				var dataN = JSON.parse( data );
// 				if ( dataN.status === true )
// 				{
// 					window.location.reload();
// 				}
// 			} );
// 		}
// 	} );

// 	/**
// 	 * ------------------------------------------------------------------------------------------
// 	 *  Payment Archive
// 	 * ------------------------------------------------------------------------------------------
// 	 */
// 	jQuery( '#ravis-payment-archive' ).on( 'click', '.delete-item', function( e )
// 	{
// 		var response = confirm( ravis_booking.delete_alert );
// 		e.preventDefault();
// 		if ( response === true )
// 		{
// 			var _this = jQuery( this );
// 			jQuery.ajax(
// 			{
// 				type: "POST",
// 				url: ravis_booking.ajaxurl,
// 				data:
// 				{
// 					action: "ravis_booking_delete_invoice",
// 					id: _this.data( 'id' ),
// 					security: _this.data( 'nonce' )
// 				}
// 			} ).done( function( data )
// 			{
// 				var dataN = JSON.parse( data );
// 				if ( dataN.status === true )
// 				{
// 					window.location.reload();
// 				}
// 			} );
// 		}
// 	} );

// 	/**
// 	 * ------------------------------------------------------------------------------------------
// 	 * Booking Archive Print
// 	 * ------------------------------------------------------------------------------------------
// 	 */
// 	jQuery( '#booking-archive-tbl' ).find( '.print-item' ).on( 'click', function( e )
// 	{
// 		e.preventDefault();
// 		var _this = jQuery( this ),
// 			_parent = _this.parents( 'tr' ),
// 			virtualTbl = jQuery( '#booking-archive-tbl-virtual' ).find( 'tbody' );

// 		virtualTbl.html( '' );
// 		virtualTbl.append( _parent.clone() );
// 		virtualTbl.append( _parent.next( 'tr' ).clone().removeClass( 'hidden' ) );
// 		virtualTbl.find( '.more-details' ).children( 'td' ).attr( 'colspan', 7 );
// 		window.print();
// 	} );

// 	/**
// 	 * ------------------------------------------------------------------------------------------
// 	 *  Seasonal Price
// 	 * ------------------------------------------------------------------------------------------
// 	 */
// 	jQuery( '.season-add' ).on( 'click', function()
// 	{
// 		var field = jQuery( this ).parent().next( '.season-box-tpl' ).children().clone( true ),
// 			fieldContainer = jQuery( '.season-package-main-container' ),
// 			fieldIndex = fieldContainer.find( '.season-package-box' ).length;

// 		var firstField = fieldContainer.append( field );

// 		firstField.find( '.season-package-box' ).last().find( 'input' ).each( function( )
// 		{
// 			var _this = jQuery( this );
// 			_this.attr( 'name', "ravis-booking-setting[seasonal_price][" + fieldIndex + "][" + _this.data( 'name' ) + "]" );

// 			if ( _this.hasClass( 'from' ) )
// 			{
// 				_this.datepicker(
// 				{
// 					dateFormat: "yy-mm-dd",
// 					minDate: 0,
// 					numberOfMonths: 2,
// 					onClose: function( selectedDate )
// 					{
// 						_this.parent().next().find( ".to" ).datepicker( "option", "minDate", selectedDate );
// 					}
// 				} );
// 			}
// 			else if ( _this.hasClass( 'to' ) )
// 			{
// 				_this.datepicker(
// 				{
// 					dateFormat: "yy-mm-dd",
// 					minDate: 0,
// 					numberOfMonths: 2,
// 					onClose: function( selectedDate )
// 					{
// 						_this.parent().prev().find( ".from" ).datepicker( "option", "maxDate", selectedDate );
// 					}
// 				} );
// 			}
// 		} );
// 		firstField.find( '.season-package-box' ).last().find( 'select' ).each( function( )
// 		{
// 			var _this = jQuery( this );
// 			_this.attr( 'name', "ravis-booking-setting[seasonal_price][" + fieldIndex + "][" + _this.data( 'name' ) + "]" );
// 		} );

// 		return false;
// 	} );
// 	jQuery( '.season-package-box' ).on( 'click', '.remove-box', function()
// 	{
// 		jQuery( this ).parent().remove();
// 		return false;
// 	} );
// } );
