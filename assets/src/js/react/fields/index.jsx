import React, { Component } from 'react';
import { __ } from '@wordpress/i18n';

import SimpleRepeater from './simple-repeater';
import Capacity from './capacity';
import Gallery from './gallery';
import Price from './price';
import SeasonalPrice from './seasonal-price';
import ManaDateRangePicker from './date-rang-picker';
import ManaDatePicker from './date-picker';
import RoomList from './room-list';

export default class Fields extends Component {
	constructor(props) {
		super(props);
		this.state = {
			startDate: null,
			endDate: null,
			focusedInput: null,
		};
	}

	fieldSwitcher = (info, savedValue) => {
		let returnVal,
			fieldValue = (savedValue && savedValue[info.fieldIndex]) ? savedValue[info.fieldIndex] : info.value;
		switch (info.type) {

			// TextArea Field
			case ('textarea'):
				returnVal =
					<textarea
						placeholder={info.label}
						value={fieldValue}
						onChange={e => this.props.onFieldChanged(info.fieldIndex, e.target.value)}
					></textarea>;
				break;

			// Select Field
			case ('select'):
				returnVal =
					<select value={fieldValue} onChange={e => this.props.onFieldChanged(info.fieldIndex, e.target.value)}>
						{
							info.options.map((item, index) => <option key={index} value={item.value}>{item.label}</option>)
						}
					</select>
				break;

			// Text Field
			case ('text'):
				returnVal =
					<input
						type="text"
						placeholder={info.label}
						value={fieldValue}
						onChange={e => this.props.onFieldChanged(info.fieldIndex, e.target.value)}
					/>;
				break;
			// number Field
			case ('number'):
				returnVal =
					<input
						type="number"
						placeholder={info.label}
						value={fieldValue}
						onChange={e => this.props.onFieldChanged(info.fieldIndex, e.target.value)}
					/>;
				break;

			// Toggle Field
			case ('toggle'):
				returnVal =
					<label className="toggle-box">
						<input
							type="checkbox"
							checked={fieldValue}
							onChange={e => this.props.onFieldChanged(info.fieldIndex, e.target.checked)}
						/>
						<span></span>
					</label>
				break;

			// Capacity Field
			case ('capacity'):
				returnVal = <Capacity info={info} savedValue={fieldValue} {...this.props} />
				break;

			// Facility Field
			case ('facility'):
				const facilityFields = [
					{ field: 'icon', type: 'text', title: __('Icon', 'mana-booking') },
					{ field: 'title', type: 'text', title: __('Title', 'mana-booking') }
				]
				returnVal = <SimpleRepeater fields={facilityFields} info={info} savedValue={fieldValue} {...this.props} />;
				break;


			// Services Field
			case ('service'):
				const serviceFields = [
					{ field: 'title', type: 'text', title: __('Title', 'mana-booking') },
					{ field: 'value', type: 'text', title: __('Value', 'mana-booking') }
				]
				returnVal = <SimpleRepeater fields={serviceFields} info={info} savedValue={fieldValue} {...this.props} />;
				break;

			// Discount Field
			case ('discount'):
				const discountFields = [
					{ field: 'night', type: 'number', title: __('Night', 'mana-booking') },
					{ field: 'percent', type: 'number', title: __('%', 'mana-booking') }
				]
				returnVal = <SimpleRepeater fields={discountFields} info={info} savedValue={fieldValue} {...this.props} />;
				break;

			// Gallery Field
			case ('gallery'):
				returnVal = <Gallery info={info} savedValue={fieldValue} {...this.props} />
				break;

			// Price Fields
			case ('price'):
				returnVal =
					<Price
						{...this.props}
						priceInfo={fieldValue}
						onPriceChanged={newPrice => {
							this.props.onFieldChanged(info.fieldIndex, newPrice);
						}}

					/>
				break;

			// Seasonal Price Fields
			case ('seasonal-price'):
				returnVal = <SeasonalPrice info={info} savedValue={fieldValue} {...this.props} />
				break;

			// Room List Fields
			case ('room-list'):
				returnVal = <RoomList info={info} savedValue={fieldValue} {...this.props} />
				break;

			// Date Range Picker Fields
			case ('date-range-picker'):
				returnVal =
					<div className="mana-date-row normal">
						<ManaDateRangePicker
							{...this.props}
							startDate={fieldValue.start}
							endDate={fieldValue.end}
							onDateChange={dateInfo => {
								const newDate = { start: dateInfo[0], end: dateInfo[1] }
								this.props.onFieldChanged(info.fieldIndex, newDate);
							}}
						/>
					</div>
				break;

			// Date Picker Fields
			case ('date-picker'):
				returnVal =
					<div className="mana-date-row normal">
						<ManaDatePicker
							{...this.props}
							date={fieldValue}
							onDateChange={newDate => {
								this.props.onFieldChanged(info.fieldIndex, newDate);
							}}
						/>
					</div>
				break;

			// Demo Fields
			case ('demo'):
				returnVal =
					<div className="demo-txt">{fieldValue}</div>
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
		const { info, savedInfo } = this.props;
		return (
			this.fieldSwitcher(info, savedInfo)
		)
	}
}
