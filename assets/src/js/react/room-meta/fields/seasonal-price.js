import React, { Component } from 'react';
import { __ } from '@wordpress/i18n';

import 'react-dates/initialize';
import { DateRangePicker } from 'react-dates';

export default class SeasonalPrice extends Component {
	constructor( props ) {
		super( props );
		this.state = {
			startDate: null,
			endDate: null,
			focusedInput: null,
		};
	}

	priceGenerator = ( val, type, day ) => {
		const newVal = { ...info.value, [ type ]: { ...info.value[ type ], [ day ]: val } };
		props.onFieldChanged( newVal );
	}

	render() {
		const { info } = this.props;
		return (
			<div className="base-price-row">
                <div className="date-row">
                    <DateRangePicker
                        startDateId="startDate"
                        endDateId="endDate"
                        startDate={this.state.startDate}
                        endDate={this.state.endDate}
                        onDatesChange={({ startDate, endDate }) => { this.setState({ startDate, endDate }) }}
                        focusedInput={this.state.focusedInput}
                        onFocusChange={(focusedInput) => { this.setState({ focusedInput }) }}
                        displayFormat="DD-MM-YYYY"
                        noBorder={true}
                        small={true}
                    />
                </div>
                <div className="adult-row">
                    <div className="weekday">
                        <div className="title">{__('Adult Weekday Price', 'ravis-booking')}</div>
                        <input
                            type="number"
                            placeholder={__('Price (number only)', 'ravis-booking')}
                            value={info.value.main}
                            onChange={val => this.priceGenerator(val.target.value, 'adult', 'weekday')}
                        />
                    </div>
                    <div className="weekday">
                        <div className="title">{__('Adult Weekend Price', 'ravis-booking')}</div>
                        <input
                            type="number"
                            placeholder={__('Price (number only)', 'ravis-booking')}
                            value={info.value.extra}
                            onChange={val => this.priceGenerator(val.target.value, 'adult', 'weekend')}
                        />
                    </div>
                </div>
                <div className="child-row">
                    <div className="weekday">
                        <div className="title">{__('Child Weekday Price', 'ravis-booking')}</div>
                        <input
                            type="number"
                            placeholder={__('Price (number only)', 'ravis-booking')}
                            value={info.value.main}
                            onChange={val => this.priceGenerator(val.target.value, 'child', 'weekday')}
                        />
                    </div>
                    <div className="weekday">
                        <div className="title">{__('Child Weekend Price', 'ravis-booking')}</div>
                        <input
                            type="number"
                            placeholder={__('Price (number only)', 'ravis-booking')}
                            value={info.value.extra}
                            onChange={val => this.priceGenerator(val.target.value, 'child', 'weekend')}
                        />
                    </div>
                </div>
            </div>
		)
	}
}
