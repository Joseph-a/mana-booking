import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { __ } from '@wordpress/i18n';
import { blockDatesSettings } from './settings';
import Fields from '../fields';

export default class BlockDatesMetaData extends Component {
    constructor(props) {
        super(props);

        const savedSetting = document.getElementById('mana_booking_block_dates_meta_info').value || "{}";

        this.state = {
            savedSetting: JSON.parse(savedSetting),
            blockDatesSettings
        }
    }

    onFieldChanged = (fieldIndex, val) => {
        let savedSetting = { ...this.state.savedSetting, [fieldIndex]: val };
        if (JSON.stringify(savedSetting) !== JSON.stringify(this.state.savedSetting)) {
            this.setState({
                savedSetting
            })
        }

        document.getElementById('mana_booking_block_dates_meta_info').value = JSON.stringify(savedSetting);
    }

    render() {
        const { blockDatesSettings, savedSetting } = this.state;
        let fblockDatesSettings;
        if (typeof blockDatesSettings === 'object') {
            fblockDatesSettings = Object.values(blockDatesSettings);
        } else {
            fblockDatesSettings = blockDatesSettings;
        }
        return (
            <div className="room-settings-tabular">
                <div className="tab-content">
                    <div className="tab-content-container">
                        {
                            fblockDatesSettings.map((item, index) => <Fields info={item} key={index} savedInfo={savedSetting} onFieldChanged={(v, a) => this.onFieldChanged(v, a)} />)
                        }
                    </div>
                </div>
            </div>
        )
    }
}

const blockDatesMetaData = document.getElementById("mana-block-date-settings-info-box");
if (blockDatesMetaData) {
    ReactDOM.render(<BlockDatesMetaData />, blockDatesMetaData);
}
