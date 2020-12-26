import React from 'react'
import t from 'prop-types'
import { __ } from '@wordpress/i18n';

const RoomBox = props => {
    const { roomInfo } = props;

    return (
        <div className="room-box">
            <div className="in-row">
                <div className="t-sec">
                    <div className="gallery-container">
                        {
                            roomInfo.gallery.count > 0 &&
                            roomInfo.gallery.img.map(img => {
                                return <img key={img.id} src={img.code.thumbnail} alt={roomInfo.title} />
                            })
                        }
                        {
                            roomInfo.gallery.count == 0 && <div className="img-placeholder">No Image</div>
                        }
                    </div>
                </div>
                <div className="b-sec">
                    <div className="title">
                        <a href={roomInfo.url}>{roomInfo.title}</a>
                    </div>
                    <div className="price">{__('Start from', 'mana-booking')}: {roomInfo.start_price}</div>
                    <div className="desc">{roomInfo.description.short}</div>
                </div>

            </div>
        </div>
    )
}

RoomBox.propTypes = {
    roomInfo: t.object
}

export default RoomBox
