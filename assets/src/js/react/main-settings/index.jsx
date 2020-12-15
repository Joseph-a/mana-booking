import React, {
    Component
} from 'react';
import ReactDOM from 'react-dom';
import {
    __
} from '@wordpress/i18n';
import {
    manaMainSettings
} from './settings';
import Tabs from './tabs';


export default class ManaBookingMainSettings extends Component {
    constructor(props) {
        super(props);

        const savedSetting = document.getElementById('mana_booking_main_setting').value || "{}";

        this.state = {
            savedSetting: JSON.parse(savedSetting),
            manaMainSettings,
            activeTab: 0
        }
    }

    onFieldChanged = (fieldIndex, val) => {
        let savedSetting = { ...this.state.savedSetting, [fieldIndex]: val };
        this.setState({
            savedSetting
        })

        document.getElementById('mana_booking_main_setting').value = JSON.stringify(savedSetting);
    }

    render() {
        const { manaMainSettings, activeTab, savedSetting } = this.state;
        return (
            <div className="room-settings-tabular">
                <div className="tab-container">
                    {
                        manaMainSettings.map((tab, index) => {
                            return (
                                <div
                                    onClick={() => {
                                        this.setState({
                                            activeTab: index
                                        });
                                    }}
                                    className={`tab ${activeTab === index ? 'active' : ''}`}
                                    key={index}
                                    tabIndex={index}
                                >{tab.label}</div>
                            )
                        })
                    }
                </div>
                <div className="tab-content">
                    {
                        manaMainSettings.map((item, index) => index === activeTab && <Tabs generalInfo={manaMainSettings} savedSetting={savedSetting} key={index} tabIndex={index} onFieldChanged={(v, a) => this.onFieldChanged(v, a)} tabInfo={item.fields} />)
                    }
                </div>
            </div>
        )
    }
}

const manaBookingSettingsMainContainer = document.getElementById("mana-booking-main-setting-container");
if (manaBookingSettingsMainContainer) {
    ReactDOM.render(< ManaBookingMainSettings />, manaBookingSettingsMainContainer);
}