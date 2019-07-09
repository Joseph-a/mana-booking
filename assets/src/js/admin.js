import "./react/api-reader";

jQuery( document ).ready( () => {

	/**
	 * ------------------------------------------------------------------------------------------
	 *  Single Image Uploader Management
	 * ------------------------------------------------------------------------------------------
	 */

	let slideshow_frame;
	let singleImageUploader = jQuery( ".single-image-uploader" );
	singleImageUploader.on( "click", ".add-image", function ( event ) {
		event.preventDefault();
		let _this         = jQuery( this ),
		    _parent       = _this.parents( ".single-image-uploader" ),
		    img_id        = _parent.find( "input[type=\"hidden\"]" ),
		    img_container = _parent.find( ".img-container" );

		// Create the media frame.
		slideshow_frame = wp.media.frames.downloadable_file = wp.media();

		// When an image is selected, run a callback.
		slideshow_frame.on( "select", function () {
			let selection = slideshow_frame.state().get( "selection" );

			selection.map( function ( attachment ) {
				attachment = attachment.toJSON();
				if ( attachment.id ) {
					let preview_html = "<div class=\"image-preview-box\"><img src=\"" + ( attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.sizes.full.url ) + "\"/></div>";
					img_container.html( "" ).append( preview_html );
					img_id.val( attachment.id );

					_this.addClass( "hidden" ).siblings( ".remove-image" ).removeClass( "hidden" );
				}
			} );
		} );

		// Finally, open the modal
		slideshow_frame.open();
	} );
	// Remove files
	singleImageUploader.on( "click", ".remove-image", function ( event ) {
		event.preventDefault();
		let _this         = jQuery( this ),
		    _parent       = _this.parents( ".single-image-uploader" ),
		    img_id        = _parent.find( "input[type=\"hidden\"]" ),
		    img_container = _parent.find( ".img-container" );

		img_id.val( "" );
		img_container.html( "" );
		_this.addClass( "hidden" ).siblings( ".add-image" ).removeClass( "hidden" );
	} );

} );
