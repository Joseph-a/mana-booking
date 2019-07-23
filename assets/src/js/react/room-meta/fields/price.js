import React from 'react'
import { __ } from '@wordpress/i18n';

const BasePrice = ( props ) => {
	const { info } = props;
	const priceGenerator = ( val, type, day ) => {
		const newVal = { ...info.value, [ type ]: { ...info.value[ type ], [ day ]: val } };
		props.onFieldChanged( newVal );
	}
	return (
		<div className="base-price-row">
            <div className="adult-row">
                <div className="weekday">
                    <div className="title">{__('Adult Weekday Price', 'ravis-booking')}</div>
                    <input
                        type="number"
                        placeholder={__('Price (number only)', 'ravis-booking')}
                        value={info.value.main}
                        onChange={val => priceGenerator(val.target.value, 'adult', 'weekday')}
                    />
                </div>
                <div className="weekday">
                    <div className="title">{__('Adult Weekend Price', 'ravis-booking')}</div>
                    <input
                        type="number"
                        placeholder={__('Price (number only)', 'ravis-booking')}
                        value={info.value.extra}
                        onChange={val => priceGenerator(val.target.value, 'adult', 'weekend')}
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
                        onChange={val => priceGenerator(val.target.value, 'child', 'weekday')}
                    />
                </div>
                <div className="weekday">
                    <div className="title">{__('Child Weekend Price', 'ravis-booking')}</div>
                    <input
                        type="number"
                        placeholder={__('Price (number only)', 'ravis-booking')}
                        value={info.value.extra}
                        onChange={val => priceGenerator(val.target.value, 'child', 'weekend')}
                    />
                </div>
            </div>
        </div>
	)
}

export default BasePrice
