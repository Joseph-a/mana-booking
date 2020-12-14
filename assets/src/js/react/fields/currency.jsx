import React, { Component } from 'react';
import { __ } from '@wordpress/i18n';

export default class Currency extends Component {
    constructor(props) {
        super(props);
    }

    outputGenerator = (index, val, field) => {
        const { info, savedValue: { currencyList, defaultCurrency } } = this.props;
        let newVal = currencyList.map((value, i) => {
            if (i === index) {
                return { ...value, [field]: val }
            }
            return value
        });
        this.props.onFieldChanged(info.fieldIndex, { defaultCurrency, currencyList: newVal });
    }

    defaultCurrencyHandle = (index) => {
        const { info, savedValue: { currencyList } } = this.props;
        this.props.onFieldChanged(info.fieldIndex, { defaultCurrency: index, currencyList });
    }

    currencyInfoRow = (currencyInfo, index, length) => {
        const { info, savedValue: { currencyList, defaultCurrency } } = this.props;

        return (
            <div className={`season-price-row ${index === defaultCurrency ? 'default-currency' : ''}`} key={index}>
                <div className="season-info-container">
                    {
                        length > 1 &&
                        <div
                            onClick={() => {
                                const newVal = Object.values(currencyList);
                                newVal.splice(index, 1);
                                this.props.outputGenerator(info.fieldIndex, { defaultCurrency, newVal });
                            }}
                            className="remove-item"
                        >
                            <i className="dashicons dashicons-no-alt"></i>
                        </div>
                    }
                    <div className="info-row">
                        <div className="title-box">{__('Title', 'mana-booking')}</div>
                        <input
                            type="text"
                            placeholder={__('Title', 'mana-booking')}
                            value={currencyInfo.title}
                            onChange={val => this.outputGenerator(index, val.target.value, 'title')}
                        />
                    </div>
                    <div className="info-row">
                        <div className="title-box">{__('Symbol', 'mana-booking')}</div>
                        <input
                            type="text"
                            placeholder={__('Symbol', 'mana-booking')}
                            value={currencyInfo.symbol}
                            onChange={val => this.outputGenerator(index, val.target.value, 'symbol')}
                        />
                    </div>
                    <div className="info-row">
                        <div className="title-box">{__('Rate', 'mana-booking')}</div>
                        <input
                            type="number"
                            placeholder="0"
                            value={currencyInfo.rate}
                            onChange={val => this.outputGenerator(index, val.target.value, 'rate')}
                        />
                    </div>
                    <div className="info-row">
                        <div className="title-box">
                            {__('Symbol Position', 'mana-booking')}
                            <div className="more-details-box">
                                <i className={`dashicons dashicons-info`}></i>
                                <div className="desc-box">
                                    {__('Check this field if you want to show the currency before its value', 'mana-booking')}
                                </div>
                            </div>
                        </div>
                        <select value={currencyInfo.position} onChange={e => this.outputGenerator(index, e.target.value, 'position')}>
                            <option value="1">{__('Before', 'mana-booking')}</option>
                            <option value="2">{__('After', 'mana-booking')}</option>
                        </select>
                    </div>
                    {
                        length > 1 &&
                        <div className="info-row">
                            <div className="title-box">
                                {__('Default Currency', 'mana-booking')}
                                <div className="more-details-box">
                                    <i className={`dashicons dashicons-info`}></i>
                                    <div className="desc-box">
                                        {__('Set this currency as default currency of your website.', 'mana-booking')}
                                    </div>
                                </div>
                            </div>
                            <label className="toggle-box">
                                <input
                                    type="checkbox"
                                    checked={index === defaultCurrency}
                                    onChange={e => this.defaultCurrencyHandle(index)}
                                />
                                <span></span>
                            </label>
                        </div>
                    }
                </div>
            </div>
        )
    }

    render() {
        const { info, savedValue: { currencyList, defaultCurrency } } = this.props;
        const rowInfo = typeof currencyList === 'object' ? Object.values(currencyList) : currencyList;

        return (
            <div className="seasonal-price-main-container">
                <div className="notice-warning notice">
                    <ol>
                        <li>{__('If you don\'t set the default currency, the first currency will be considered as the default.', 'mana-booking')}</li>
                        <li>
                            {__('You can find your currency title from the below URL. "Currency Code" is the column that you must search on.', 'mana-booking')} <br />
                            <a target="_blank" href="http://www.xe.com/symbols.php">http://www.xe.com/symbols.php</a>
                        </li>
                        <li>
                            {__('You can find your currency symbol from the below URL. "Arial Unicode MS" is the column that you must search on.', 'mana-booking')}
                            <br />
                            <a target="_blank" href="http://www.xe.com/symbols.php">http://www.xe.com/symbols.php</a>
                        </li>
                    </ol>
                </div>
                <div className="season-box-container">
                    {
                        rowInfo.map((item, index) => this.currencyInfoRow(item, index, rowInfo.length))
                    }
                </div>
                <div className="btn-container">
                    <button
                        className="button button-primary button-large"
                        onClick={() => {
                            const rawVal = {
                                title: '',
                                symbol: '',
                                rate: '',
                                position: 1,
                            }
                            const newVal = { defaultCurrency, currencyList: [...currencyList, rawVal] };

                            this.props.onFieldChanged(info.fieldIndex, newVal);
                        }}
                    >{__('Add New', 'mana-booking')}</button>
                </div>
            </div>
        );
    }
}
