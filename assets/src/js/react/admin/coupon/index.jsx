import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { __ } from '@wordpress/i18n';
import { couponSettings } from './settings';
import Fields from '../fields';

export default class CouponMetaData extends Component {
    constructor(props) {
        super(props);

        const savedSetting = document.getElementById('mana_booking_coupon_meta_info').value || "{}";

        this.state = {
            savedSetting: JSON.parse(savedSetting),
            couponSettings,
            activeTab: 0
        }
    }

    componentDidMount() {
        this.initialSetting();
    }

    onFieldChanged = (fieldIndex, val) => {
        let savedSetting = { ...this.state.savedSetting, [fieldIndex]: val };
        if (JSON.stringify(savedSetting) !== JSON.stringify(this.state.savedSetting)) {
            this.setState({
                savedSetting
            })
        }

        document.getElementById('mana_booking_coupon_meta_info').value = JSON.stringify(savedSetting);
    }

    initialSetting = () => {
        const { couponSettings, savedSetting } = this.state;
        let initialValue = {};

        couponSettings.map(field => {
            initialValue[field.fieldIndex] = typeof savedSetting[field.fieldIndex] !== 'undefined' ? savedSetting[field.fieldIndex] : field.value;
        });

        this.setState({ savedSetting: initialValue });
        document.getElementById('mana_booking_coupon_meta_info').value = JSON.stringify(initialValue);
    }

    render() {
        const { couponSettings, savedSetting } = this.state;
        let fcouponSettings;
        if (typeof couponSettings === 'object') {
            fcouponSettings = Object.values(couponSettings);
        } else {
            fcouponSettings = couponSettings;
        }
        return (
            <div className="room-settings-tabular">
                <div className="tab-content">
                    <div className="tab-content-container">
                        {
                            fcouponSettings.map((item, index) => <Fields generalInfo={fcouponSettings} info={item} key={index} savedInfo={savedSetting} onFieldChanged={(v, a) => this.onFieldChanged(v, a)} />)
                        }
                    </div>
                </div>
            </div>
        )
    }
}

const couponMetaData = document.getElementById("mana-coupon-settings-info-box");
if (couponMetaData) {
    ReactDOM.render(<CouponMetaData />, couponMetaData);
}
