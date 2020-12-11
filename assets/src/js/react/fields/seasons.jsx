import React, { Component } from 'react';
import { __ } from '@wordpress/i18n';

import ManaDateRangePicker from './date-rang-picker';

export default class Seasons extends Component {
    constructor(props) {
        super(props);
        this.state = {
            focusedInput: null
        }
    }

    outputGenerator = (index, val, field) => {
        const { info, savedValue } = this.props;
        let newVal = { ...savedValue, [index]: { ...savedValue[index], [field]: val } };

        this.props.onFieldChanged(info.fieldIndex, newVal);
    }

    priceInfoRow = (seasonInfo, index) => {
        const { info, savedValue } = this.props;

        return (
            <div className="season-price-row" key={index}>
                <div className="mana-date-row">
                    <ManaDateRangePicker
                        {...this.props}
                        startDate={seasonInfo.date.start}
                        endDate={seasonInfo.date.end}
                        onDateChange={(dateInfo) => {
                            const newDate = { start: dateInfo[0], end: dateInfo[1] || null }
                            this.outputGenerator(index, newDate, 'date')
                        }}
                    />

                    <div
                        onClick={() => {
                            const newVal = Object.values(savedValue);
                            newVal.splice(index, 1);
                            this.props.onFieldChanged(info.fieldIndex, newVal);
                        }}
                        className="remove-item"
                    >
                        <i className="dashicons dashicons-no-alt"></i>
                    </div>
                </div>
                <div className="season-info-container">
                    <div className="info-row">
                        <div className="title-box">{__('Title', 'mana-booking')}</div>
                        <input
                            type="text"
                            placeholder={__('Title', 'mana-booking')}
                            value={seasonInfo.title}
                            onChange={val => this.outputGenerator(index, val.target.value, 'title')}
                        />
                    </div>
                    <div className="info-row">
                        <div className="title-box">{__('Season Type', 'mana-booking')}</div>
                        <select value={seasonInfo.type} onChange={e => this.outputGenerator(index, e.target.value, 'type')}>
                            <option value="1">{__('High Season', 'mana-booking')}</option>
                            <option value="2">{__('Low Season', 'mana-booking')}</option>
                        </select>
                    </div>
                    <div className="info-row">
                        <div className="title-box">{__('Decrease / Increase Percent', 'mana-booking')}</div>
                        <input
                            type="number"
                            value={seasonInfo.percent}
                            onChange={val => this.outputGenerator(index, val.target.value, 'percent')}
                        />
                    </div>
                </div>

            </div>
        )
    }

    render() {
        const { info, savedValue } = this.props;
        const rowInfo = typeof savedValue === 'object' ? Object.values(savedValue) : savedValue;

        return (
            <div className="seasonal-price-main-container">
                <div class="error notice">
                    <ul>
                        <li>{__('Please note that these seasonal prices will override the single room prices. It means that they have higher priority of room\'s seasonal prices.', 'mana-booking')}</li>
                        <li>{__('This prices will be applied on all rooms of website.', 'mana-booking')}</li>
                    </ul>
                </div>
                <div className="season-box-container">
                    {
                        rowInfo.map((item, index) => this.priceInfoRow(item, index))
                    }
                </div>
                <div className="btn-container">
                    <button
                        className="button button-primary button-large"
                        onClick={() => {
                            const rawVal = {
                                title: '',
                                type: 1,
                                date: { start: null, end: null },
                                percent: 0
                            }
                            const newVal = typeof savedValue === 'object' ? [...Object.values(savedValue), rawVal] : [...savedValue, rawVal];

                            this.props.onFieldChanged(info.fieldIndex, newVal);
                        }}
                    >{__('Add New', 'mana-booking')}</button>
                </div>
            </div>
        );
    }
}
