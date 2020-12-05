import React, { useState, useEffect } from 'react';
import { __ } from '@wordpress/i18n';

const Gallery = (props) => {
    const [imgInfo, setInfo] = useState();

    useEffect(() => {
        let imgs = [];
        const imgLoader = async ID => {
            if (!wp.media.attachment(ID).get('url')) {
                return await wp.media.attachment(ID).fetch();
            }
            return wp.media.attachment(ID).attributes;
        }
        console.log(props.info.value);

        if (props.info.value.length > 0) {
            props.info.value.map(ID => {
                imgLoader(ID).then(newAttachment => {
                    setInfo([...imgs, newAttachment]);
                    imgs.push(newAttachment);
                });
            });
        } else {
            setInfo([]);
        }
    }, [props.info.value]);

    return (
        <div className="gallery-main-container">
            <div className="gallery-images-list">
                {
                    imgInfo && imgInfo.map(item => {
                        return (
                            <div className="img-box" key={item.id}>
                                <img src={item.sizes.thumbnail.url} alt={item.name} />
                            </div>
                        )
                    })
                }
            </div>
            <button className="button button-primary" onClick={(e) => {
                e.preventDefault();
                let mediaUploader = window.wp.media({
                    frame: 'select',
                    title: __('Select Images', 'mana-property'),
                    multiple: true,
                    library: {
                        order: 'DESC',
                        orderby: 'date',
                        type: 'image',
                        search: null,
                        uploadedTo: null
                    },
                    button: {
                        text: __('Select', 'mana-property')
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
            }}>{__('Select Image', 'mana-property')}</button>
            <button className="button button-danger" onClick={() => props.onFieldChanged([])}>{__('Remove Images', 'mana-booking')}</button>
        </div>
    )
}

export default Gallery
