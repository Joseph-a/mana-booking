import React from 'react';
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


const Tabs = ( props ) => {
	return (
		<div className="tab-content-container">
            {
                props.tabInfo.map((item,index) =>{
                    console.log(item);
                })



            }
            {/* <BaseControl>
                <label className="components-base-control__label" htmlFor="short-description">{__( 'Short Description', 'ravis-booking' )}</label>
                <textarea id="short-description" placeholder={ __( 'Short Description', 'ravis-booking' ) }></textarea>
            </BaseControl>

            <TextControl
                label={__( 'Short Description', 'ravis-booking' )}
                placeholder={ __( 'Short Description', 'ravis-booking' ) }
                value={ `11111` }
            />
            <TextControl
                label={__( 'Room Count', 'ravis-booking' )}
                placeholder={ __( 'Room Count', 'ravis-booking' ) }
                value={ `11111` }
            /> */}
        </div>
	)
}

export default Tabs
