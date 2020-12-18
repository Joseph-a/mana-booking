import React, { Component } from 'react';
import { __ } from '@wordpress/i18n';

import Gallery from './gallery';

export default class Membership extends Component {
    constructor(props) {
        super(props);
        this.state = {
            focusedInput: null
        }
    }

    outputGenerator = (index, val, field) => {
        const { info, savedValue } = this.props;
        let newVal = [...savedValue];
        newVal[index][field] = val;

        this.props.onFieldChanged(info.fieldIndex, newVal);
    }

    priceInfoRow = (seasonInfo, index) => {
        const { info, savedValue } = this.props;

        return (
            <div className="season-price-row" key={index}>
                <div className="season-info-container">
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
                    <div className="info-row">
                        <div className="title-box">
                            {__('Title', 'mana-booking')}
                            <div className="more-details-box">
                                <i className={`dashicons dashicons-info`}></i>
                                <div className="desc-box">
                                    {__('In title field you can set a title for your package', 'mana-booking')}
                                </div>
                            </div>
                        </div>
                        <input
                            type="text"
                            placeholder={__('Title', 'mana-booking')}
                            value={seasonInfo.title}
                            onChange={val => this.outputGenerator(index, val.target.value, 'title')}
                        />
                    </div>
                    <div className="info-row">
                        <div className="title-box">
                            {__('Badge', 'mana-booking')}
                            <div className="more-details-box">
                                <i className={`dashicons dashicons-info`}></i>
                                <div className="desc-box">
                                    {__('You can set a badge for your package to be shown in the profile section of users', 'mana-booking')}
                                </div>
                            </div>
                        </div>
                        <Gallery
                            imgType="single"
                            savedValue={seasonInfo.badge || []}
                            onImageChanged={val => this.outputGenerator(index, val, 'badge')}
                        />
                    </div>
                    <div className="info-row">
                        <div className="title-box">
                            {__('Conditions', 'mana-booking')}
                            <div className="more-details-box">
                                <i className={`dashicons dashicons-info`}></i>
                                <div className="desc-box">
                                    {__('You can set a condition of your package in these 3 ways: based on Total Booking Price, Total Booking items and both of them.', 'mana-booking')}
                                </div>
                            </div>
                        </div>
                        <select value={seasonInfo.condition} onChange={e => this.outputGenerator(index, e.target.value, 'condition')}>
                            <option value="1">{__('Total Booking Price', 'mana-booking')}</option>
                            <option value="2">{__('Total Booking Items', 'mana-booking')}</option>
                            <option value="3">{__('Total Booking Price / Total Booking Items', 'mana-booking')}</option>
                        </select>
                    </div>
                    {
                        (!seasonInfo.condition || seasonInfo.condition === '1') &&
                        <div className="info-row">
                            <div className="title-box">{__('Total Booking Price', 'mana-booking')}</div>
                            <input
                                type="number"
                                value={seasonInfo.singleConditionPrice}
                                onChange={val => this.outputGenerator(index, val.target.value, 'singleConditionPrice')}
                            />
                        </div>
                    }
                    {
                        seasonInfo.condition === '2' &&
                        <div className="info-row">
                            <div className="title-box">{__('Total Booking Items', 'mana-booking')}</div>
                            <input
                                type="number"
                                value={seasonInfo.singleConditionItem}
                                onChange={val => this.outputGenerator(index, val.target.value, 'singleConditionItem')}
                            />
                        </div>
                    }
                    {
                        seasonInfo.condition === '3' &&
                        <div className="info-row">
                            <div className="title-box">{__('Condition Type', 'mana-booking')}</div>
                            <select value={seasonInfo.conditionType} onChange={e => this.outputGenerator(index, e.target.value, 'conditionType')}>
                                <option value="1">{__('AND', 'mana-booking')}</option>
                                <option value="2">{__('OR', 'mana-booking')}</option>
                            </select>
                        </div>
                    }
                    <div className="info-row">
                        <div className="title-box">
                            {__('Discount', 'mana-booking')}
                            <div className="more-details-box">
                                <i className={`dashicons dashicons-info`}></i>
                                <div className="desc-box">
                                    {__('Every packages must have discount, so you must add discount that you have considered for your package.', 'mana-booking')}
                                </div>
                            </div>
                        </div>
                        <div className="price-input-holder">
                            <input
                                type="number"
                                value={seasonInfo.discount}
                                onChange={val => this.outputGenerator(index, val.target.value, 'discount')}
                            />
                            <span className="value-container">%</span>
                        </div>
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
                <div className="notice-warning notice">
                    <ol>
                        <li>{__('You can add as much as membership package you need in this section.', 'mana-booking')}</li>
                        <li>{__('After choosing the condition of package some fields based on your selected item will be shown that you can set your prices or count of booking item or both.', 'mana-booking')}</li>
                        <li>{__('Please note that in all the price and count fields you just need to add numbers.', 'mana-booking')}</li>
                    </ol>
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
                                badge: [],
                                condition: '1',
                                singleConditionPrice: 0,
                                singleConditionItem: 0,
                                conditionType: '1',
                                discount: 0
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
