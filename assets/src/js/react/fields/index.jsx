import React, { Component } from 'react';
import { __ } from '@wordpress/i18n';

import SimpleRepeater from './simple-repeater';
import Capacity from './capacity';
import Gallery from './gallery';
import Price from './price';
import SeasonalPrice from './seasonal-price';

export default class Fields extends Component {
	constructor( props ) {
		super( props );
		this.state = {
			startDate: null,
			endDate: null,
			focusedInput: null,
		};
	}

	fieldSwitcher = ( info ) => {
		let returnVal;
		switch ( info.type ) {

			// TextArea Field
			case ( 'textarea' ):
				returnVal = 
                    <textarea
                        placeholder={info.label}
                        value={info.value}
                        onChange={e => this.props.onFieldChanged(e.target.value)}
                    ></textarea>;
				break;

				// Select Field
			case ( 'select' ):
				returnVal = 
                    <select value={info.value} onChange={e => this.props.onFieldChanged(e.target.value)}>
                        {
                            info.options.map((item, index) => <option key={index} value={item.value}>{item.label}</option>)
                        }
                    </select>
				break;

				// Text Field
			case ( 'text' ):
				returnVal = 
                    <input
                        type="text"
                        placeholder={info.label}
                        value={info.value}
                        onChange={val => this.props.onFieldChanged(val.target.value)}
                    />;
				break;
				// number Field
			case ( 'number' ):
				returnVal = 
                    <input
                        type="number"
                        placeholder={info.label}
                        value={info.value}
                        onChange={val => this.props.onFieldChanged(val.target.value)}
                    />;
				break;

				// Toggle Field
			case ( 'toggle' ):
				returnVal = 
						<label className="toggle-box">
							<input
								type="checkbox"
								checked={info.value}
								onChange={val => {
									this.props.onFieldChanged(val.target.checked);
								}}
							/>
							<span></span>
						</label>
				break;

				// Capacity Field
			case ( 'capacity' ):
				returnVal = <Capacity info={info} {...this.props} />
				break;

				// Facility Field
			case ( 'facility' ):
				const facilityFields = [
					{ field: 'icon', type: 'text', title: __( 'Icon', 'mana-booking' ) },
					{ field: 'title', type: 'text', title: __( 'Title', 'mana-booking' ) }
				]
				returnVal = <SimpleRepeater fields={facilityFields} info={info} {...this.props} />;
				break;


				// Services Field
			case ( 'service' ):
				const serviceFields = [
					{ field: 'title', type: 'text', title: __( 'Title', 'mana-booking' ) },
					{ field: 'value', type: 'text', title: __( 'Value', 'mana-booking' ) }
				]
				returnVal = <SimpleRepeater fields={serviceFields} info={info} {...this.props} />;
				break;

				// Discount Field
			case ( 'discount' ):
				const discountFields = [
					{ field: 'night', type: 'number', title: __( 'Night', 'mana-booking' ) },
					{ field: 'percent', type: 'number', title: __( '%', 'mana-booking' ) }
				]
				returnVal = <SimpleRepeater fields={discountFields} info={info} {...this.props} />;
				break;

				// Gallery Field
			case ( 'gallery' ):
				returnVal = <Gallery info={info} {...this.props} />
				break;

				// Price Fields
			case ( 'price' ):
                returnVal = 
                    <Price 
                        {...this.props} 
                        priceInfo={info.value} 
                        onPriceChanged={(newPrice)=>{
                            this.props.onFieldChanged( newPrice );
                        }}

                    />
				break;

				// Seasonal Price Fields
			case ( 'seasonal-price' ):
				returnVal = <SeasonalPrice info={info} {...this.props}/>
				break;
		}

		return (
			<div className={`field-row ${info.type}`}>
				<label className="components-base-control__label">
					{info.label}
					{
						info.desc && info.type !== 'toggle' &&
						<div className="more-details-box">
							<i className={`dashicons dashicons-info`}></i>
							<div className="desc-box">{info.desc}</div>			
						</div>
					}
				</label>
                <div className="value-box">{returnVal}</div> 
				{
					info.type === 'toggle' && <div className="desc-box">{info.desc}</div>
				}				
            </div>
		);
	}
	render() {
		return (
			this.fieldSwitcher(this.props.info)
		)
	}
}
