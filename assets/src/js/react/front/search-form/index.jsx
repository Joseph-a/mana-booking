import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { __ } from '@wordpress/i18n';
import 'react-dates/initialize';
import { DateRangePicker } from 'react-dates';
import moment from 'moment';

export default class ManaSearchForm extends Component {
    constructor(props) {
        super(props);
        this.state = {
            randId: Math.random() * 100,
            startDate: moment(),
            endDate: moment().add(2, 'days'),
            selectedRooms: [{
                adult: 1,
                child: 0
            }
            ],
            bookableRooms: 10,
            focusedInput: null,
        }
    }

    roomHandle = (index, type, value) => {
        const { selectedRooms } = this.state;
        let newRoomArray = [...selectedRooms];
        newRoomArray[index][type] = value;
        this.setState({
            selectedRooms: newRoomArray
        })
    }

    submitFormHandle = () => {
        const { selectedRooms, startDate, endDate } = this.state;
        console.log(selectedRooms, startDate.format('DD-MM-YYYY'), endDate.format('DD-MM-YYYY'));
    }

    render() {
        const { randId, selectedRooms, bookableRooms, startDate, endDate } = this.state;
        return (
            <div className="mana-booking-search-form">
                <div className="top-sec">
                    <div className="date-box">
                        <DateRangePicker
                            startDateId={`startDate_${randId}`}
                            endDateId={`endDate_${randId}`}
                            startDate={startDate}
                            endDate={endDate}
                            onDatesChange={({ startDate, endDate }) => this.setState({ startDate, endDate })}
                            focusedInput={this.state.focusedInput}
                            onFocusChange={focusedInput => this.setState({ focusedInput })}
                            displayFormat="DD-MM-YYYY"
                            noBorder={true}
                            small={true}
                            readOnly={true}
                        />
                    </div>
                    <div className="rooms">
                        <select
                            value={selectedRooms.length}
                            placeholder={__('Rooms', 'mana-booking')}
                            onChange={e => {
                                let newVal = [];
                                for (let i = 0; i < e.target.value; i++) {
                                    newVal.push({
                                        adult: 1,
                                        child: 0
                                    });
                                }
                                this.setState({ selectedRooms: newVal })
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
                        selectedRooms.map((item, i) => (
                            <div className="room-row" key={i}>
                                <div className="title">{__('Room', 'mana-booking')} {i + 1}</div>
                                <div className="adult">
                                    <label>{__('Adult', 'mana-booking')}:</label>
                                    <select
                                        value={item.adult}
                                        onChange={e => this.roomHandle(i, 'adult', e.target.value)}
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
                                        onChange={e => this.roomHandle(i, 'child', e.target.value)}
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
                            </div>
                        ))
                    }
                </div>
                <div className="btn-sec">
                    <button
                        onClick={() => this.submitFormHandle()}
                    >{__('Book Now', 'mana-booking')}</button>
                </div>
            </div>
        )
    }
}

const searchForms = document.getElementsByClassName("mana-booking-search-form-container");
if (searchForms.length > 0) {
    for (let item of searchForms) {
        ReactDOM.render(<ManaSearchForm />, item.children[2]);
    }
}
