import React from 'react'
import t from 'prop-types'
import { __ } from '@wordpress/i18n';
import ImgSlider from "./img-slider";

const RoomBox = props => {
    const { roomInfo, imageSlider } = props;

    return (
        <div className="room-box">
            <div className="in-row">
                <div className="t-sec">
                    <div className="gallery-container">
                        {
                            roomInfo.gallery.count > 0 && imageSlider && <ImgSlider imgList={roomInfo.gallery.img} title={roomInfo.title} />
                        }
                        {
                            roomInfo.gallery.count > 0 && !imageSlider && <div className="single-img-container"><img src={roomInfo.gallery.img[0].code.large} alt={roomInfo.title} /></div>
                        }
                        {
                            roomInfo.gallery.count == 0 && <div className="img-placeholder">No Image</div>
                        }
                    </div>
                </div>
                <div className="b-sec">
                    <h4 className="title">
                        <a href={roomInfo.url}>{roomInfo.title}</a>
                    </h4>
                    <div className="price">{__('Start from', 'mana-booking')}: <span className="value">{roomInfo.start_price}</span></div>
                    <div className="desc">{roomInfo.description.short}</div>
                    <div className="btn-container">
                        <button>
                            <a className="button" href={roomInfo.url}>{__('More Info', 'mana-booking')}</a>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    )
}

RoomBox.propTypes = {
    roomInfo: t.object
}

export default RoomBox
