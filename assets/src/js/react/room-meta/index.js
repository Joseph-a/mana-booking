import { __ } from '@wordpress/i18n';

import {
	Modal,
	ButtonGroup,
	ToggleControl,
	PanelBody,
	RangeControl,
	SelectControl,
	TextControl,
	Button,
	BaseControl
} from "@wordpress/components";

import React, { Component } from 'react'
import { roomSettings } from './settings'
import Tabs from './tabs'

export default class RoomMetaData extends Component {
	constructor( props ) {
		super( props );
		this.state = {
			roomSettings,
			activeTab: 0
		}
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
                        roomSettings.map((item, index) => index === activeTab && <Tabs key={index} tabInfo={item.value} />)
                    }
                </div>
            </div>
		)
	}
}




const signalApiReader = document.getElementById( "ravis-room-setting-info-box" );
ReactDOM.render( <RoomMetaData />, signalApiReader );
