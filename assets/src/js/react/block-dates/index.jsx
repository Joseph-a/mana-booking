import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { __ } from '@wordpress/i18n';
import { blockDatesSettings } from './settings';

export default class BlockDatesMetaData extends Component {
    constructor(props) {
        super(props);

        const savedSetting = document.getElementById('ravis_booking_block_dates_meta_info').value;

        this.state = {
            blockDatesSettings: savedSetting ? { ...JSON.parse(savedSetting), ...blockDatesSettings } : blockDatesSettings,
            activeTab: 0
        }
    }

    onFieldChanged = (val, ii, i) => {
        let blockDatesSettings = [...Object.values(this.state.blockDatesSettings)];
        blockDatesSettings[i]['value'][ii]['value'] = val;

        this.setState({
            blockDatesSettings
        })

        document.getElementById('ravis_booking_block_dates_meta_info').value = JSON.stringify(this.state.blockDatesSettings);
    }

    render() {
        const { blockDatesSettings, activeTab } = this.state;
        let fblockDatesSettings;
        if (typeof blockDatesSettings === 'object') {
            fblockDatesSettings = Object.values(blockDatesSettings);
        } else {
            fblockDatesSettings = blockDatesSettings;
        }
        return (
            <div className="room-settings-tabular">
                <div className="tab-content">
                    aaaaa
                </div>
            </div>
        )
    }
}

const signalApiReader = document.getElementById("ravis-block-date-settings-info-box");
if (signalApiReader) {
    ReactDOM.render(<BlockDatesMetaData />, signalApiReader);
}
