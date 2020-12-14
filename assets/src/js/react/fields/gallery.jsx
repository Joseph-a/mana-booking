import React, { useState, useEffect } from 'react';
import { __ } from '@wordpress/i18n';

const Gallery = (props) => {
    const { imgType } = props;
    const [imgInfo, setInfo] = useState();

    useEffect(() => {
        let imgs = [];
        const imgLoader = async ID => {
            if (!wp.media.attachment(ID).get('url')) {
                return await wp.media.attachment(ID).fetch();
            }
            return wp.media.attachment(ID).attributes;
        }

        if (props.savedValue.length > 0) {
            props.savedValue.map(ID => {
                imgLoader(ID).then(newAttachment => {
                    setInfo([...imgs, newAttachment]);
                    imgs.push(newAttachment);
                });
            });
        } else {
            setInfo([]);
        }
    }, [props.savedValue]);

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
                {
                    (!imgInfo || imgInfo.length === 0) && <div className="img-box placeholder"></div>
                }
            </div>
            <button className="button button-primary" onClick={(e) => {
                e.preventDefault();
                let uploaderOpt = {
                    frame: 'select',
                    title: __('Select Images', 'mana-property'),
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
                };

                if (imgType !== 'single') {
                    uploaderOpt.multiple = true;
                }

                let mediaUploader = window.wp.media(uploaderOpt);

                mediaUploader.on('select', function () {
                    let attachment = mediaUploader.state().get('selection');
                    let images = [];
                    if (attachment.length > 0) {
                        attachment.map(item => {
                            images.push(item.id);
                        });
                    }
                    props.onImageChanged(images);
                });
                mediaUploader.open();
            }}>{__('Select Image', 'mana-property')}</button>
            {
                (imgInfo && imgInfo.length > 0) &&
                <button className="button button-danger" onClick={() => props.onImageChanged([])}>
                    {
                        imgInfo.length === 1 && __('Remove Image', 'mana-booking')
                    }
                    {
                        imgInfo.length > 1 && __('Remove Images', 'mana-booking')
                    }
                </button>

            }
        </div>
    )
}

export default Gallery
