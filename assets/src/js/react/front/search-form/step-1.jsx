import React, { Fragment, useEffect, useState } from 'react';
import t from 'prop-types';
import { serialize } from 'object-to-formdata';
import 'react-dates/initialize';
import { DateRangePicker } from 'react-dates';
import moment from 'moment';
import { __ } from '@wordpress/i18n';
import ManaRoomListing from "../room-listing";

const Step1 = (props) => {
    const randId = Math.random() * 100,
        bookableRooms = 10,
        [stepCompleted, setStep] = useState(false),
        [modalStatus, setModal] = useState(false),
        [activeRoom, setActiveRoom] = useState(0),
        [availableRoomsArray, setAvailableRooms] = useState([]),
        [startEndDatesField, setDates] = useState({
            startDate: moment(props.checkIn) || moment(),
            endDate: moment(props.checkOut) || moment().add(2, 'days'),
        }),
        [selectedRoomsField, setRooms] = useState(props.selectedRooms || [{
            adult: 1,
            child: 0,
            room: null
        }]),
        [focusedInputField, setFocusedInput] = useState(null),
        roomHandle = (index, type, value) => {
            let newRoomArray = [...selectedRoomsField];
            newRoomArray[index][type] = value;
            setRooms(newRoomArray);
            resetSearchResult();
        },
        resetSearchResult = () => {
            setActiveRoom(0);
            setModal(false);
            setAvailableRooms([]);
        },
        resetRoomItem = (index) => {
            let newRoomArray = [...selectedRoomsField];
            newRoomArray[index]['room'] = null;
            setRooms(newRoomArray);
        },
        resetRooms = (value) => {
            let e = value || selectedRoomsField.length,
                newVal = [];
            for (let i = 0; i < e; i++) {
                newVal.push({
                    adult: 1,
                    child: 0,
                    room: null
                });
            }
            setRooms(newVal);
        };

    useEffect(() => {
        let completedRooms = [];
        selectedRoomsField.map(item => item.room ? completedRooms.push(1) : '');

        if (selectedRoomsField.length === completedRooms.length) {
            setStep(true);
        } else {
            setStep(false);
        }
    }, [selectedRoomsField])


    const availableRooms = async (checkIn, checkOut, adult, child) => {
        const roomList = await fetch(mana_booking_obj.ajaxurl, {
            method: "POST",
            body: serialize({
                action: "mana_booking_check_availability",
                security: props.security,
                data: {
                    checkIn,
                    checkOut,
                    adult,
                    child
                }
            })
        });
        return await roomList.json()
    }
    const searchRoom = async (checkIn, checkOut, adult, child, i) => {
        setActiveRoom(i + 1);
        availableRooms(checkIn, checkOut, adult, child).then(res => {
            if (res.status) {
                setModal(true);
                setAvailableRooms(res.rooms);
            }
        });
    };


    return (
        <Fragment>
            <div className="top-sec">
                <div className="date-box">
                    <div className="input-box">
                        <label>{__('Check In', 'mana-booking')}:</label>
                        <input
                            type="text"
                            placeholder={__('Check In', 'mana-booking')}
                            value={startEndDatesField.startDate ? moment(startEndDatesField.startDate).format('YYYY-MM-DD') : ''}
                            onClick={() => setFocusedInput('startDate')}
                            readOnly
                        />
                    </div>
                    <div className="input-box">
                        <label>{__('Check Out', 'mana-booking')}:</label>
                        <input
                            type="text"
                            placeholder={__('Check Out', 'mana-booking')}
                            value={startEndDatesField.endDate ? moment(startEndDatesField.endDate).format('YYYY-MM-DD') : ''}
                            onClick={() => setFocusedInput('endDate')}
                            readOnly
                        />
                    </div>
                    <DateRangePicker
                        startDateId={`startDate_${randId}`}
                        endDateId={`endDate_${randId}`}
                        startDate={startEndDatesField.startDate}
                        endDate={startEndDatesField.endDate}
                        onDatesChange={({ startDate, endDate }) => {
                            resetRooms();
                            resetSearchResult();
                            setDates({ startDate, endDate });
                        }}
                        focusedInput={focusedInputField}
                        onFocusChange={focusedInput => setFocusedInput(focusedInput)}
                        displayFormat="YYYY-MM-DD"
                        noBorder={true}
                        small={true}
                        readOnly={true}
                    />
                </div>
                <div className="rooms">
                    <label>{__('Rooms', 'mana-booking')}:</label>
                    <select
                        value={selectedRoomsField.length}
                        placeholder={__('Rooms', 'mana-booking')}
                        onChange={e => resetRooms(e.target.value)}
                    >
                        {
                            [...Array(bookableRooms).keys()].map((item, i) => <option key={i} value={i + 1}>{i + 1} {i + 1 > 1 ? __('Rooms', 'mana-booking') : __('Room', 'mana-booking')}</option>)
                        }
                    </select>
                </div>
            </div>
            <div className="room-sec">
                {
                    selectedRoomsField.map((item, i) => (
                        <div className={`room-row ${activeRoom - 1 === i ? 'active' : ''}`} key={i}>
                            <div className="title">{__('Room', 'mana-booking')} {i + 1}</div>
                            <div className="adult">
                                <label>{__('Adult', 'mana-booking')}:</label>
                                {
                                    item.room && <div className="value">{item.adult}</div>
                                }
                                {
                                    !item.room &&
                                    <select
                                        value={item.adult}
                                        onChange={e => roomHandle(i, 'adult', e.target.value)}
                                    >
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                }
                            </div>
                            <div className="child">
                                <label>{__('Child', 'mana-booking')}:</label>
                                {
                                    item.room && <div className="value">{item.child}</div>
                                }
                                {
                                    !item.room &&
                                    <select
                                        value={item.child}
                                        onChange={e => roomHandle(i, 'child', e.target.value)}
                                    >
                                        <option value="0">{__('No Child', 'mana-booking')}</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                }
                            </div>
                            <div className="room">
                                {item.room && <label>{__('Room', 'mana-booking')}:</label>}
                                {!item.room && <label></label>}
                                {
                                    item.room &&
                                    <div className="value">
                                        {item.room.title}
                                        <button
                                            onClick={() => resetRoomItem(i)}
                                        >{__('Edit', 'mana-booking')}</button>
                                    </div>
                                }
                                {
                                    !item.room &&
                                    <button
                                        onClick={() => searchRoom(startEndDatesField.startDate.format('YYYY-MM-DD'), startEndDatesField.endDate.format('YYYY-MM-DD'), item.adult, item.child, i)}
                                    >{__('Check Availability', 'mana-booking')}</button>
                                }
                            </div>
                        </div>
                    ))
                }
            </div>
            {
                stepCompleted &&
                <div className="btn-sec">
                    <button
                        onClick={() => props.handleStep1(startEndDatesField.startDate.format('YYYY-MM-DD'), startEndDatesField.endDate.format('YYYY-MM-DD'), selectedRoomsField)}
                    >{__('Next Step', 'mana-booking')}</button>
                </div>
            }

            {
                modalStatus &&
                <div className="mana-booking-modal">
                    <div className="inner-content site-main">
                        <div className="close-button" onClick={() => resetSearchResult()}>X</div>
                        {
                            availableRoomsArray.length > 0 &&
                            <div className="mana-booking-search-result">
                                <h3>{__('Room', 'mana-booking')} {activeRoom}</h3>
                                <div className={`mana-booking-room-listing ${mana_booking_obj.room_listing_layout === '1' ? 'boxed' : 'list'}`}>
                                    <ManaRoomListing rooms={availableRoomsArray} inSearch={true} activeRoom={activeRoom - 1} roomHandle={roomHandle} />
                                </div>
                            </div>
                        }
                        {
                            availableRoomsArray.length === 0 && <div className="no-room">{__('There is no room available!', 'mana-booking')}</div>
                        }
                    </div>
                </div>
            }
        </Fragment>
    )
}

Step1.propTypes = {
    handleStep1: t.func
};

export default Step1
