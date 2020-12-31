import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { __ } from '@wordpress/i18n';
import { serviceSettings } from './settings';
import Fields from '../fields';

export default class ServiceMetaData extends Component {
    constructor(props) {
        super(props);

        const savedSetting = document.getElementById('mana_booking_service_meta_info').value || "{}";

        this.state = {
            savedSetting: JSON.parse(savedSetting),
            serviceSettings
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

        document.getElementById('mana_booking_service_meta_info').value = JSON.stringify(savedSetting);
    }

    initialSetting = () => {
        const { serviceSettings, savedSetting } = this.state;
        let initialValue = {};

        serviceSettings.map(field => {
            initialValue[field.fieldIndex] = typeof savedSetting[field.fieldIndex] !== 'undefined' ? savedSetting[field.fieldIndex] : field.value;
        });

        this.setState({ savedSetting: initialValue });
        document.getElementById('mana_booking_service_meta_info').value = JSON.stringify(initialValue);
    }

    render() {
        const { serviceSettings, savedSetting } = this.state;
        let fserviceSettings;
        if (typeof serviceSettings === 'object') {
            fserviceSettings = Object.values(serviceSettings);
        } else {
            fserviceSettings = serviceSettings;
        }
        return (
            <div className="room-settings-tabular">
                <div className="tab-content">
                    <div className="tab-content-container">
                        {
                            fserviceSettings.map((item, index) => <Fields generalInfo={fserviceSettings} info={item} key={index} savedInfo={savedSetting} onFieldChanged={(v, a) => this.onFieldChanged(v, a)} />)
                        }
                    </div>
                </div>
            </div>
        )
    }
}

const serviceMetaData = document.getElementById("mana-service-settings-info-box");
if (serviceMetaData) {
    ReactDOM.render(<ServiceMetaData />, serviceMetaData);
}
