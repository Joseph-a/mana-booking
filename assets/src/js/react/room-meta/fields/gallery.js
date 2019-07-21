import React from 'react';
import { __ } from '@wordpress/i18n';

const Gallery = (props) => {
    const { info } = props;
    return (
        <div className="gallery-main-container">
            <div className="gallery-images-list">
                {
                    info.value.map(item => {
                        const imgInfo = wp.media.attachment(item);
                        return (
                            <div className="img-box" key={imgInfo.id}>
                                <img src={imgInfo.attributes.sizes.thumbnail.url} alt={imgInfo.attributes.name} />
                            </div>
                        )
                    })
                }
                <div className="image-box"></div>
            </div>
            <button onClick={(e) => {
                e.preventDefault();
                let mediaUploader = window.wp.media({
                    frame: 'select',
                    title: __('Select Images', 'ravis-property'),
                    multiple: true,
                    library: {
                        order: 'DESC',
                        orderby: 'date',
                        type: 'image',
                        search: null,
                        uploadedTo: null
                    },
                    button: {
                        text: __('Select', 'ravis-property')
                    }
                });

                mediaUploader.on('select', function () {
                    let attachment = mediaUploader.state().get('selection');
                    let images = [];
                    if (attachment.length > 0) {
                        attachment.map(item => {
                            images.push(item.id);
                        });
                    }
                    props.onFieldChanged(images);
                });
                mediaUploader.open();
            }}>{__('Select Image', 'ravis-property')}</button>
            <button onClick={() => props.onFieldChanged([])}>{__('Remove Images', 'ravis-booking')}</button>
        </div>
    )
}

export default Gallery
