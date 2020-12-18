import React, { Component } from 'react'
import { __ } from '@wordpress/i18n';
import deepmerge from 'deepmerge';

export default class BasePrice extends Component {

    constructor(props) {
        super(props);
        let initialInfo = {
            adult: { weekday: '', weekend: '' },
            child: { weekday: '', weekend: '' }
        }
        this.state = {
            info: deepmerge(initialInfo, props.priceInfo)
        }
    }

    priceGenerator = (val, type, day) => {
        const { info } = this.state;
        const newVal = { ...info, [type]: { ...info[type], [day]: val } };

        this.props.onPriceChanged(newVal);
        this.setState({
            info: newVal
        })
    }

    render() {
        const { info } = this.state;
        return (
            <div className="base-price-row">
                <div className="adult-row">
                    <div className="box-title">{__('Adult', 'mana-booking')}</div>
                    <div className="weekday">
                        <div className="title">{__('Weekday', 'mana-booking')}</div>
                        <input
                            type="number"
                            placeholder={__('Price (number only)', 'mana-booking')}
                            value={info.adult.weekday}
                            onChange={val => this.priceGenerator(val.target.value, 'adult', 'weekday')}
                        />
                    </div>
                    <div className="weekday">
                        <div className="title">{__('Weekend', 'mana-booking')}</div>
                        <input
                            type="number"
                            placeholder={__('Price (number only)', 'mana-booking')}
                            value={info.adult.weekend}
                            onChange={val => this.priceGenerator(val.target.value, 'adult', 'weekend')}
                        />
                    </div>
                </div>
                <div className="child-row">
                    <div className="box-title">{__('Child', 'mana-booking')}</div>
                    <div className="weekday">
                        <div className="title">{__('Weekday', 'mana-booking')}</div>
                        <input
                            type="number"
                            placeholder={__('Price (number only)', 'mana-booking')}
                            value={info.child.weekday}
                            onChange={val => this.priceGenerator(val.target.value, 'child', 'weekday')}
                        />
                    </div>
                    <div className="weekday">
                        <div className="title">{__('Weekend', 'mana-booking')}</div>
                        <input
                            type="number"
                            placeholder={__('Price (number only)', 'mana-booking')}
                            value={info.child.weekend}
                            onChange={val => this.priceGenerator(val.target.value, 'child', 'weekend')}
                        />
                    </div>
                </div>
            </div>
        )
    }
}