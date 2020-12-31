import React, { useState } from 'react';
import t from 'prop-types'
import { __ } from '@wordpress/i18n';
import ImgSlider from "./img-slider";

const RoomRow = props => {
    const { roomInfo, imageSlider, inSearch, activeRoom } = props,
        { total, guest } = roomInfo.booking_price,
        [priceBreakDown, setPriceBreakDown] = useState(false);



    return (
        <div className="room-box">
            <div className="in-row">
                <div className="t-sec">
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
                    <div className={`m-sec ${inSearch ? 'in-search' : ''}`}>
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
                        {
                            inSearch &&
                            <div className="btn-container">
                                <button
                                    className="select-room"
                                    onClick={() => props.roomHandle(activeRoom, 'room', {
                                        id: roomInfo.id,
                                        title: roomInfo.title
                                    })}
                                >{__('Select This Room', 'mana-booking')}</button>
                                <button
                                    className={`price-breakdown ${priceBreakDown ? 'active' : ''}`}
                                    onClick={() => setPriceBreakDown(!priceBreakDown)}
                                >{__('Price Breakdown', 'mana-booking')}</button>
                            </div>
                        }
                    </div>
                    {
                        !inSearch && <div className="r-sec">
                            {roomInfo.description.short}
                            <div className="btn-container">
                                <button><a className="button" href={roomInfo.url}>{__('More Info', 'mana-booking')}</a></button>
                            </div>
                        </div>
                    }
                </div>
                <div className="b-sec">
                    {
                        priceBreakDown &&
                        <div className="price-break-down">
                            <table>
                                <tbody>
                                    {
                                        total.weekday &&
                                        <tr>
                                            <td>
                                                {__('Weekday', 'mana-booking')}
                                                <span className="info">X {total.weekday.count} {__('Nights', 'mana-booking')}</span>
                                            </td>
                                            <td>
                                                {
                                                    total.weekday.adult.main != 0 &&
                                                    <div className="price-row">
                                                        <div className="value">{total.weekday.adult.main}</div>
                                                        <div className="desc">({guest.adult.main} {__('adult', 'mana-booking')})</div>
                                                    </div>
                                                }
                                                {
                                                    total.weekday.adult.extra != 0 &&
                                                    <div className="price-row">
                                                        <div className="value">{total.weekday.adult.extra}</div>
                                                        <div className="desc">({guest.adult.extra} {__('extra adult', 'mana-booking')})</div>
                                                    </div>
                                                }
                                                {
                                                    total.weekday.child.main != 0 &&
                                                    <div className="price-row">
                                                        <div className="value">{total.weekday.child.main}</div>
                                                        <div className="desc">({guest.child.main} {__('child', 'mana-booking')})</div>
                                                    </div>
                                                }
                                                {
                                                    total.weekday.child.extra != 0 &&
                                                    <div className="price-row">
                                                        <div className="value">{total.weekday.child.extra}</div>
                                                        <div className="desc">({guest.child.extra} {__('extra child', 'mana-booking')})</div>
                                                    </div>
                                                }
                                            </td>
                                        </tr>
                                    }
                                    {
                                        total.weekend &&
                                        <tr>
                                            <td>
                                                {__('Weekend', 'mana-booking')}
                                                <span className="info">X {total.weekend.count} {__('Nights', 'mana-booking')}</span>
                                            </td>
                                            <td>
                                                {
                                                    total.weekend.adult.main != 0 &&
                                                    <div className="price-row">
                                                        <div className="value">{total.weekend.adult.main}</div>
                                                        <div className="desc">({guest.adult.main} {__('adult', 'mana-booking')})</div>
                                                    </div>
                                                }
                                                {
                                                    total.weekend.adult.extra != 0 &&
                                                    <div className="price-row">
                                                        <div className="value">{total.weekend.adult.extra}</div>
                                                        <div className="desc">({guest.adult.extra} {__('extra adult', 'mana-booking')})</div>
                                                    </div>
                                                }
                                                {
                                                    total.weekend.child.main != 0 &&
                                                    <div className="price-row">
                                                        <div className="value">{total.weekend.child.main}</div>
                                                        <div className="desc">({guest.child.main} {__('child', 'mana-booking')})</div>
                                                    </div>
                                                }
                                                {
                                                    total.weekend.child.extra != 0 &&
                                                    <div className="price-row">
                                                        <div className="value">{total.weekend.child.extra}</div>
                                                        <div className="desc">({guest.child.extra} {__('extra child', 'mana-booking')})</div>
                                                    </div>
                                                }
                                            </td>
                                        </tr>
                                    }
                                    {
                                        total.discount &&
                                        <tr>
                                            <td>
                                                {__('Discount', 'mana-booking')}
                                                <span className="info">{roomInfo.discount_details.percent} {__('% Off', 'mana-booking')}</span>
                                            </td>
                                            <td>{total.discount}</td>
                                        </tr>
                                    }
                                    <tr className="total">
                                        <td>
                                            {__('Total', 'mana-booking')}
                                            <span className="info">{__('vat is not included yet', 'mana-booking')}</span>
                                        </td>
                                        <td>{total.payable}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    }
                </div>
            </div>
        </div>
    )
}

RoomRow.propTypes = {
    roomInfo: t.object
}

export default RoomRow
