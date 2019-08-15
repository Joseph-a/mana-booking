import React, { Component } from 'react'
import { __ } from '@wordpress/i18n';
import deepmerge from 'deepmerge';


export default class BasePrice extends Component {

    constructor(props) {
        super(props);
        this.state = {
            info: {
                adult: { weekday: '', weekend: '' },
                child: { weekday: '', weekend: '' }
            }
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
                    <div className="weekday">
                        <div className="title">{__('Adult Weekday Price', 'ravis-booking')}</div>
                        <input
                            type="number"
                            placeholder={__('Price (number only)', 'ravis-booking')}
                            value={info.main}
                            onChange={val => this.priceGenerator(val.target.value, 'adult', 'weekday')}
                        />
                    </div>
                    <div className="weekday">
                        <div className="title">{__('Adult Weekend Price', 'ravis-booking')}</div>
                        <input
                            type="number"
                            placeholder={__('Price (number only)', 'ravis-booking')}
                            value={info.extra}
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
                            value={info.main}
                            onChange={val => this.priceGenerator(val.target.value, 'child', 'weekday')}
                        />
                    </div>
                    <div className="weekday">
                        <div className="title">{__('Child Weekend Price', 'ravis-booking')}</div>
                        <input
                            type="number"
                            placeholder={__('Price (number only)', 'ravis-booking')}
                            value={info.extra}
                            onChange={val => this.priceGenerator(val.target.value, 'child', 'weekend')}
                        />
                    </div>
                </div>
            </div>
        )
    }
}