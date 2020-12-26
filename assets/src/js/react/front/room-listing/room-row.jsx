import React from 'react'
import t from 'prop-types'
import { __ } from '@wordpress/i18n';

const RoomRow = props => {
    const { roomInfo } = props;

    return (
        <div className="room-box">
            <div className="in-row">
                <div className="l-sec">
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
                <div className="m-sec">
                    <div className="main-info">
                        <div className="title">
                            <a href={roomInfo.url}>{roomInfo.title}</a>
                        </div>
                        <div className="price">{__('Start from', 'mana-booking')}: {roomInfo.start_price}</div>
                    </div>
                    <div className="extra-info">
                        <ul>
                            {
                                roomInfo.room_view &&
                                <li>
                                    <span className="label">{__('View', 'mana-booking')}: </span>
                                    <span className="value">{roomInfo.room_view}</span>
                                </li>
                            }
                            {
                                roomInfo.room_size.qnt &&
                                <li>
                                    <span className="label">{__('Room size', 'mana-booking')}: </span>
                                    <span className="value">
                                        {roomInfo.room_size.qnt}
                                        <span dangerouslySetInnerHTML={{ __html: roomInfo.room_size.unit }}></span>
                                    </span>
                                </li>
                            }
                            {
                                roomInfo.max_people &&
                                <li>
                                    <span className="label">{__('Max People', 'mana-booking')}: </span>
                                    <span className="value">{roomInfo.max_people}</span>
                                </li>
                            }
                            {
                                roomInfo.service.length > 0 &&
                                roomInfo.service.map(service => {
                                    <li>
                                        <span className="label">{service.title}: </span>
                                        <span className="value">{service.value}</span>
                                    </li>
                                })
                            }
                            {
                                roomInfo.facilities.length > 0 &&
                                <li>
                                    <span className="label">{__('Facilities', 'mana-booking')}: </span>
                                    <span className="value">{
                                        roomInfo.facilities.map(service => `${service.title} ,`)
                                    }
                                    </span>
                                </li>
                            }
                        </ul>
                    </div>
                </div>
                <div className="r-sec">{roomInfo.description.short}</div>
            </div>
        </div>
    )
}

RoomRow.propTypes = {
    roomInfo: t.object
}

export default RoomRow
