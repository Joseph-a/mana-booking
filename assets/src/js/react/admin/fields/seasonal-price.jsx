import React, { Component } from 'react';
import { __ } from '@wordpress/i18n';

import ManaDateRangePicker from './date-rang-picker';
import Price from './price';

export default class SeasonalPrice extends Component {
    constructor(props) {
        super(props);
        this.state = {
            focusedInput: null
        }
    }

    outputGenerator = (index, field, val) => {
        const { info, savedValue } = this.props;
        let newVal = [...savedValue];
        newVal[index][field] = val;

        this.props.onFieldChanged(info.fieldIndex, newVal);
    }

    priceRow = (seasonPrice, index) => {
        const { info, savedValue } = this.props;

        return (
            <div className="base-price-row" key={index}>
                <div className="mana-date-row">
                    <ManaDateRangePicker
                        {...this.props}
                        startDate={seasonPrice.date.start}
                        endDate={seasonPrice.date.end}
                        onDateChange={(dateInfo) => {
                            const newDate = { start: dateInfo[0], end: dateInfo[1] || null }
                            this.outputGenerator(index, 'date', newDate)
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
                <Price
                    {...this.props}
                    priceInfo={seasonPrice.main}
                    onPriceChanged={(newPrice) => {
                        this.outputGenerator(index, 'main', newPrice)
                    }}
                />
                <div className="extra-guest-separator">{__('Extra Guest Price', 'mana-booking')}</div>
                <Price
                    {...this.props}
                    priceInfo={seasonPrice.extra}
                    onPriceChanged={(newPrice) => {
                        this.outputGenerator(index, 'extra', newPrice)
                    }}
                />
            </div>
        )
    }

    render() {
        const { info, savedValue } = this.props;
        const rowInfo = typeof savedValue === 'object' ? Object.values(savedValue) : savedValue;

        return (
            <div className="seasonal-price-main-container">
                {
                    rowInfo.map((item, index) => this.priceRow(item, index))
                }
                <button
                    className="button button-primary button-large"
                    onClick={() => {
                        const rawVal = {
                            date: { start: null, end: null },
                            main: {
                                adult: { weekday: '', weekend: '' },
                                child: { weekday: '', weekend: '' }
                            },
                            extra: {
                                adult: { weekday: '', weekend: '' },
                                child: { weekday: '', weekend: '' }
                            },
                        }
                        const newVal = typeof savedValue === 'object' ? [...Object.values(savedValue), rawVal] : [...savedValue, rawVal];

                        this.props.onFieldChanged(info.fieldIndex, newVal);
                    }}
                >{__('Add New', 'mana-booking')}</button>
            </div>
        );
    }
}
