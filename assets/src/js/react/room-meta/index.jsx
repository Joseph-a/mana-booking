import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { __ } from '@wordpress/i18n';
import { roomSettings } from './settings';
import Tabs from './tabs';

export default class RoomMetaData extends Component {
    constructor(props) {
        super(props);

        const savedSetting = document.getElementById('mana_booking_room_meta_info').value;

        this.state = {
            roomSettings: savedSetting ? { ...roomSettings, ...JSON.parse(savedSetting) } : roomSettings,
            activeTab: 0
        }
    }

    onFieldChanged = (val, ii, i) => {
        let roomSettings = [...Object.values(this.state.roomSettings)];
        roomSettings[i]['value'][ii]['value'] = val;

        this.setState({
            roomSettings
        })

        document.getElementById('mana_booking_room_meta_info').value = JSON.stringify(this.state.roomSettings);
    }
    render() {
        const { roomSettings, activeTab } = this.state;
        let fRoomSettings;
        if (typeof roomSettings === 'object') {
            fRoomSettings = Object.values(roomSettings);
        } else {
            fRoomSettings = roomSettings;
        }
        return (
            <div className="room-settings-tabular">
                <div className="tab-container">
                    {
                        fRoomSettings.map((item, index) => {
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
                                ><i className={`dashicons ${item.icon}`}></i>{item.label}</div>
                            )
                        })
                    }
                </div>
                <div className="tab-content">
                    {
                        fRoomSettings.map((item, index) => index === activeTab && <Tabs settingInfo={roomSettings} key={index} onFieldChanged={(v, a) => this.onFieldChanged(v, a, index)} tabInfo={item.value} />)
                    }
                </div>
            </div>
        )
    }
}

const roomMetaDataBox = document.getElementById("mana-room-settings-info-box");
if (roomMetaDataBox) {
    ReactDOM.render(<RoomMetaData />, roomMetaDataBox);
}
