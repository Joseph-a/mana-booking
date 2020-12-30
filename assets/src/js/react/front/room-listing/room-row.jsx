import React from 'react'
import t from 'prop-types'
import { __ } from '@wordpress/i18n';
import ImgSlider from "./img-slider";

const RoomRow = props => {
    const { roomInfo, imageSlider, inSearch, activeRoom } = props;

    return (
        <div className="room-box">
            <div className="in-row">
                <div className="l-sec">
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
                <div className="m-sec">
                    <div className="main-info">
                        <h4 className="title">
                            <a href={roomInfo.url}>{roomInfo.title}</a>
                        </h4>
                        <div className="price">{__('Start from', 'mana-booking')}: <span className="value">{roomInfo.start_price}</span></div>
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
                                roomInfo.service.map((service, i) => {
                                    return (
                                        <li key={i}>
                                            <span className="label">{service.title}: </span>
                                            <span className="value">{service.value}</span>
                                        </li>
                                    )
                                })
                            }
                            {
                                roomInfo.facilities.length > 0 &&
                                <li>
                                    <span className="label">{__('Facilities', 'mana-booking')}: </span>
                                    <span className="value">{
                                        roomInfo.facilities.map(facility => `${facility.title}, `)
                                    }
                                    </span>
                                </li>
                            }
                        </ul>
                    </div>
                </div>
                <div className="r-sec">
                    {roomInfo.description.short}
                    <div className="btn-container">
                        <button>
                            {
                                inSearch && <div
                                    className="button"
                                    onClick={() => props.roomHandle(activeRoom, 'room', {
                                        id: roomInfo.id,
                                        title: roomInfo.title
                                    })}
                                >{__('Select This Room', 'mana-booking')}</div>
                            }
                            {
                                !inSearch && <a className="button" href={roomInfo.url}>{__('More Info', 'mana-booking')}</a>
                            }

                        </button>
                    </div>
                </div>
            </div>
        </div>
    )
}

RoomRow.propTypes = {
    roomInfo: t.object
}

export default RoomRow
