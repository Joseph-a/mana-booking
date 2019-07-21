import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { __ } from '@wordpress/i18n';
import { roomSettings } from './settings';
import Tabs from './tabs';

export default class RoomMetaData extends Component {
	constructor( props ) {
		super( props );

		const savedSetting = document.getElementById( 'ravis_booking_room_new_meta_info' ).value;

		this.state = {
			roomSettings: savedSetting ? JSON.parse( savedSetting ) : roomSettings,
			activeTab: 0
		}
	}

	onFieldChanged = ( val, ii, i ) => {
        let roomSettingsN = [ ...this.state.roomSettings ];
		roomSettingsN[ i ][ 'value' ][ ii ][ 'value' ] = val;
		this.setState( {
			roomSettings: roomSettingsN
		} )

		document.getElementById( 'ravis_booking_room_new_meta_info' ).value = JSON.stringify( this.state.roomSettings );
	}
	render() {
		const { roomSettings, activeTab } = this.state;
		return (
			<div className="room-settings-tabular">
                <div className="tab-container">
                    {
                        roomSettings.map((item, index) => {
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
                                >{item.label}</div>
                            )
                        })
                    }
                </div>
                <div className="tab-content">
                    {
                        roomSettings.map((item, index) => index === activeTab && <Tabs key={index} onFieldChanged={(v, a) => this.onFieldChanged(v, a, index)} tabInfo={item.value} />)
                    }
                </div>
            </div>
		)
	}
}

const signalApiReader = document.getElementById( "ravis-room-setting-info-box" );
if ( signalApiReader ) {
	ReactDOM.render( <RoomMetaData />, signalApiReader );
}
