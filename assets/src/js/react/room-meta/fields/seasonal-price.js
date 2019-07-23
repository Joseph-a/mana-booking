import React, { Component } from 'react';
import { __ } from '@wordpress/i18n';

import RavisDateRangePicker from './date-rang-picker';
import Price from './price';

export default class SeasonalPrice extends Component {
    constructor(props) {
        super(props);
        this.state = {
            focusedInput: null
        }
    }

    outputGenerator = (index, field, val) => {
        const { info } = this.props;
        let newVal;
        if (field === 'field') {
            newVal = { ...info.value, [index]: { ...info.value[index], [field]: val } };
        } else {
            newVal = val;
        }

        // console.log(newVal);

        // props.onFieldChanged(newVal);
    }

    priceRow = (seasonPrice, index) => {
        return (
            <div className="base-price-row" key={index}>
                <div className="date-row">
                    <RavisDateRangePicker
                        {...this.props}
                        startDate={seasonPrice.date.start}
                        endDate={seasonPrice.date.end}
                        onDateChange={(dateInfo) => {
                            const newDate = { start: dateInfo[0], end: dateInfo[1] || null }
                            this.outputGenerator(index, 'date', newDate)
                        }}
                    />
                </div>
                <Price
                    {...this.props}
                    info={seasonPrice}
                    onPriceChanged={(newPrice) => {
                        console.log(newPrice)
                        this.outputGenerator(index, 'main', newPrice)
                    }}
                />
                <div className="extra-guest-separator">{__('Extra Guest Price', 'ravis-booking')}</div>
                <Price
                    {...this.props}
                    info={seasonPrice}
                    onPriceChanged={(newPrice) => {
                        this.outputGenerator(index, 'extra', newPrice)
                    }}
                />
            </div>
        )
    }

    render() {
        const { info } = this.props;
        return (
            <div className="seasonal-price-main-container">
                {
                    info.value.map((item, index) => this.priceRow(item, index))
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
                        const newVal = [...info.value, rawVal];
                        console.log(newVal);

                        this.props.onFieldChanged(newVal);
                    }}
                >{__('Add New', 'ravis-booking')}</button>
            </div>
        );
    }
}
