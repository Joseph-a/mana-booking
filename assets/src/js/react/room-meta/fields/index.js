import React, { Component } from 'react';
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


export default class Fields extends Component {
	constructor( props ) {
		super( props );
	}

	fieldSwitcher = ( info ) => {
		let returnVal;
		switch ( info.type ) {

			// TextArea Field
			case ( 'textarea' ):
				returnVal = <BaseControl>
                    <label className="components-base-control__label">{info.label}</label>
                    <textarea
                        placeholder={info.label}
                        value={info.value}
                        onChange={e => this.props.onFieldChanged(e.target.value)}
                    ></textarea>
                </BaseControl>;
				break;

				// Select Field
			case ( 'select' ):
				returnVal = <SelectControl
                    label={info.label}
                    value={info.value}
                    options={info.options}
                    onChange={val => this.props.onFieldChanged(val)}
                />
				break;

				// Text Field
			case ( 'text' ):
				returnVal = <TextControl
                    label={info.label}
                    placeholder={info.label}
                    value={info.value}
                    onChange={val => this.props.onFieldChanged(val)}
                />;
				break;

				// Toggle Field
			case ( 'toggle' ):
				returnVal = <ToggleControl
                    label={info.label}
                    placeholder={info.label}
                    checked={ info.value === true }
                    onChange={val => this.props.onFieldChanged(val)}
                />;
				break;

				// Facility Field
			case ( 'facility' ):
				const facilityInputChanges = ( val, name, index ) => {
					let newVal = [ ...info.value ];
					newVal[ index ][ name ] = val;
					this.props.onFieldChanged( newVal );
				}

				returnVal = <BaseControl>
                <label className="components-base-control__label">{info.label}</label>
                {
                    info.value.map((item, index) =>{
                        return (
                            <div className="facility-row" key={index}>
                                <input type="text" value={item.icon} placeholder={__('Icon', 'ravis-booking')} onChange={e=>facilityInputChanges(e.target.value, 'icon', index)}/>
                                <input type="text" value={item.title} placeholder={__('Title', 'ravis-booking')} onChange={e=>facilityInputChanges(e.target.value, 'title', index)}/>
                                <div
                                    onClick={() =>{
                                        const newVal = [...info.value];
                                        newVal.splice(index, 1);
                                        this.props.onFieldChanged(newVal);
                                    }}
                                    className="remove-item"
                                >X</div>
                            </div>
                        )
                    })
                }
                <Button
                    onClick={()=>{
                        const newVal = [...info.value, {icon:'', title:''}];
                        this.props.onFieldChanged(newVal);
                    }}
                    className="button button-primary button-large"
                >{__('Add New', 'ravis-booking')}</Button>
            </BaseControl>;
				break;


				// Services Field
			case ( 'service' ):
				const serviceInputChanges = ( val, name, index ) => {
					let newVal = [ ...info.value ];
					newVal[ index ][ name ] = val;
					this.props.onFieldChanged( newVal );
				}

				returnVal = <BaseControl>
                <label className="components-base-control__label">{info.label}</label>
                {
                    info.value.map((item, index) =>{
                        return (
                            <div className="service-row" key={index}>
                                <input type="text" value={item.title} placeholder={__('Title', 'ravis-booking')} onChange={e=>serviceInputChanges(e.target.value, 'title', index)}/>
                                <input type="text" value={item.value} placeholder={__('Value', 'ravis-booking')} onChange={e=>serviceInputChanges(e.target.value, 'value', index)}/>
                                <div
                                    onClick={() =>{
                                        const newVal = [...info.value];
                                        newVal.splice(index, 1);
                                        this.props.onFieldChanged(newVal);
                                    }}
                                    className="remove-item"
                                >X</div>
                            </div>
                        )
                    })
                }
                <Button
                    onClick={()=>{
                        const newVal = [...info.value, {title:'', value:'',}];
                        this.props.onFieldChanged(newVal);
                    }}
                    className="button button-primary button-large"
                >{__('Add New', 'ravis-booking')}</Button>
            </BaseControl>;
				break;

				// Gallery Field
			case ( 'gallery' ):
				returnVal = <BaseControl>
                    <label className="components-base-control__label">{info.label}</label>
                    <Button onClick={(e) => {
                            e.preventDefault();

                            const slideshow_frame = wp.media({ multiple: true });

                            // slideshow_frame.on('select', () => {
                            //     const selection = slideshow_frame.state().get('selection');

                            //     selection.map((attachment) => {
                            //         console.log(attachment);
                            //     });
                            // });
                            slideshow_frame.open();

                    }}>Select Image</Button>
                </BaseControl>;
				break;
		}

		return returnVal;
	}
	render() {
		return (
			<div className="field-row">
                {this.fieldSwitcher(this.props.info)}
            </div>
		)
	}
}
