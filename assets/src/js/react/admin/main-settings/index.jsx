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
import {
    manaMainSetting
} from '../../../constant';


export default class ManaBookingMainSettings extends Component {
    constructor(props) {
        super(props);

        let savedSetting = document.getElementById('mana_booking_main_setting').value || "{}";
        if (typeof savedSetting === 'undefined' || savedSetting === 'undefined') {
            savedSetting = "{}";
        }

        this.state = {
            savedSetting: JSON.parse(savedSetting),
            manaMainSettings,
            activeTab: 0
        }
    }

    componentDidMount() {
        this.initialSetting();
    }

    onFieldChanged = (fieldIndex, val) => {
        let savedSetting = { ...this.state.savedSetting, [fieldIndex]: val };
        this.setState({
            savedSetting
        })

        /*
        *  TODO: Validate the inputs and remove Empty Fields
        */

        document.getElementById('mana_booking_main_setting').value = JSON.stringify(savedSetting);
    }

    initialSetting = () => {
        const { manaMainSettings, savedSetting } = this.state;
        let initialValue = {};

        manaMainSettings.map(tab => {
            (tab.fields).map(field => {
                if (field.fieldIndex !== manaMainSetting.IMPORT && field.fieldIndex !== manaMainSetting.EXPORT) {
                    initialValue[field.fieldIndex] = typeof savedSetting[field.fieldIndex] !== 'undefined' ? savedSetting[field.fieldIndex] : field.value;
                }
            })
        });

        this.setState({ savedSetting: initialValue });
        document.getElementById('mana_booking_main_setting').value = JSON.stringify(initialValue);
    }

    getFieldValue = (index) => {
        return this.state.savedSetting[index];
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
                        manaMainSettings.map((item, index) => index === activeTab && <Tabs generalInfo={manaMainSettings} savedSetting={savedSetting} key={index} tabIndex={index} onFieldChanged={(v, a) => this.onFieldChanged(v, a)} tabInfo={item.fields} getFieldValue={i => this.getFieldValue(i)} />)
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