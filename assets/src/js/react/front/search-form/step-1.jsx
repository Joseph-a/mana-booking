import React, { Fragment, useState } from 'react';
import t from 'prop-types';
import { serialize } from 'object-to-formdata';
import 'react-dates/initialize';
import { DateRangePicker } from 'react-dates';
import moment from 'moment';
import { __ } from '@wordpress/i18n';

const Step1 = (props) => {
    const randId = Math.random() * 100,
        bookableRooms = 10,
        [startEndDatesField, setDates] = useState({
            startDate: moment(),
            endDate: moment().add(2, 'days'),
        }),
        [selectedRoomsField, setRooms] = useState([{
            adult: 1,
            child: 0,
            room: null
        }]),
        [focusedInputField, setFocusedInput] = useState(null),

        roomHandle = (index, type, value) => {
            let newRoomArray = [...selectedRoomsField];
            newRoomArray[index][type] = value;
            setRooms(newRoomArray);
        };


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
        return roomList
    }
    const selectRoom = async (checkIn, checkOut, adult, child) => {

        availableRooms(checkIn, checkOut, adult, child).then(res => console.log(res));
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
                        onDatesChange={({ startDate, endDate }) => setDates({ startDate, endDate })}
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
                        onChange={e => {
                            let newVal = [];
                            for (let i = 0; i < e.target.value; i++) {
                                newVal.push({
                                    adult: 1,
                                    child: 0,
                                    room: null
                                });
                            }
                            setRooms(newVal);
                        }}
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
                        <div className="room-row" key={i}>
                            <div className="title">{__('Room', 'mana-booking')} {i + 1}</div>
                            <div className="adult">
                                <label>{__('Adult', 'mana-booking')}:</label>
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
                            </div>
                            <div className="child">
                                <label>{__('Child', 'mana-booking')}:</label>
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
                            </div>
                            <div className="room">
                                {/* <label>{__('Room', 'mana-booking')}:</label> */}
                                <label></label>
                                <button
                                    onClick={() => selectRoom(startEndDatesField.startDate.format('YYYY-MM-DD'), startEndDatesField.endDate.format('YYYY-MM-DD'), item.adult, item.child)}
                                >{__('Check Availability', 'mana-booking')}</button>
                            </div>
                        </div>
                    ))
                }
            </div>
            {/* <div className="btn-sec">
                <button
                    onClick={() => props.handleStep1(startEndDatesField.startDate.format('YYYY-MM-DD'), startEndDatesField.endDate.format('YYYY-MM-DD'), selectedRoomsField)}
                >{__('Next Step', 'mana-booking')}</button>
            </div> */}
        </Fragment>
    )
}

Step1.propTypes = {
    handleStep1: t.func
};

export default Step1
