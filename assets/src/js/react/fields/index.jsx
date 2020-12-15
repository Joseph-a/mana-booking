import React, { Component } from 'react';
import { __ } from '@wordpress/i18n';
import {
	manaMainSetting
} from '../../constant'

import SimpleRepeater from './simple-repeater';
import SingleRepeater from './single-repeater';
import Capacity from './capacity';
import Gallery from './gallery';
import Price from './price';
import SeasonalPrice from './seasonal-price';
import ManaDateRangePicker from './date-rang-picker';
import ManaDatePicker from './date-picker';
import RoomList from './room-list';
import TextEditor from './editor';
import Seasons from './seasons';
import Currency from './currency';
import Membership from './membership';
import Export from './export';
import Import from './import';

export default class Fields extends Component {
	constructor(props) {
		super(props);
		this.state = {
			startDate: null,
			endDate: null,
			focusedInput: null,
			conditionalField: true
		};
	}

	componentDidUpdate() {
		this.conditionalField()
	}

	componentDidMount() {
		this.conditionalField()
	}

	conditionalField = () => {
		const { info, generalInfo, savedInfo } = this.props;
		const { conditionalField } = this.state;
		let newConditionalField = true;
		if (info.conditional) {
			let parentField = generalInfo && Object.keys(savedInfo).length === 0 ?
				generalInfo.filter(val => val.fieldIndex === info.conditional.ifField).length > 0 ? generalInfo.filter(val => val.fieldIndex === info.conditional.ifField)[0].value : '' :
				savedInfo[info.conditional.ifField];
			newConditionalField = parentField === info.conditional.ifValue;
		}
		if (newConditionalField !== conditionalField) {
			this.setState({ conditionalField: newConditionalField });
		}
	}

	fieldSwitcher = (info, savedValue) => {
		const { conditionalField } = this.state;
		let returnVal,
			fieldValue = (savedValue && Object.keys(savedValue).length > 0 && typeof savedValue[info.fieldIndex] !== 'undefined') ? savedValue[info.fieldIndex] : info.value;
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

			// Currency Select Field
			case ('currency-select'):
				let options = [{
					label: __('Current Currency', 'mana-booking'),
					value: 'no_item'
				}],
					currencyListValue = this.props.getFieldValue(manaMainSetting.CURRENCY_LIST);

				if (currencyListValue) {
					currencyListValue.currencyList.map(item => {
						if (item.title) {
							options.push({
								label: item.title,
								value: item.title
							})
						}
					});
				}
				returnVal =
					<select value={fieldValue} onChange={e => this.props.onFieldChanged(info.fieldIndex, e.target.value)}>
						{
							options.map((item, index) => <option key={index} value={item.value}>{item.label}</option>)
						}
					</select>;
				break;

			// Select Field
			case ('select'):
				returnVal =
					<select value={fieldValue} onChange={e => this.props.onFieldChanged(info.fieldIndex, e.target.value)}>
						{
							info.options.map((item, index) => <option key={index} value={item.value}>{item.label}</option>)
						}
					</select>;
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

			// URL Field
			case ('url'):
				returnVal =
					<input
						type="url"
						placeholder={info.label}
						value={fieldValue}
						onChange={e => this.props.onFieldChanged(info.fieldIndex, e.target.value)}
					/>;
				break;

			// Email Field
			case ('email'):
				returnVal =
					<input
						type="email"
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

			// Percent Field
			case ('percent'):
				returnVal =
					<div className="price-input-holder">
						<input
							type="number"
							placeholder={info.label}
							value={fieldValue}
							onChange={e => this.props.onFieldChanged(info.fieldIndex, e.target.value)}
						/>
						<span className="value-container">%</span>
					</div>;
				break;

			// Single Price Field
			case ('single-price'):
				returnVal =
					<div className="price-input-holder">
						<input
							type="number"
							placeholder={info.label}
							value={fieldValue}
							onChange={e => this.props.onFieldChanged(info.fieldIndex, e.target.value)}
						/>
						{
							fieldValue &&
							<span className="value-container">
								<span className="price-unit">$</span>
								{parseInt(fieldValue).toLocaleString()}
							</span>
						}
					</div>;
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
					</label>;
				break;

			// Single repeater Field
			case ('single-repeater'):
				let repeaterInfo = {
					type: 'text',
					title: __('Item', 'mana-booking')
				}
				returnVal = <SingleRepeater field={repeaterInfo} info={info} savedValue={fieldValue} {...this.props} />;
				break;

			// Editor Field
			case ('editor'):
				returnVal = <TextEditor info={info} savedValue={fieldValue} {...this.props} />;
				break;

			// Capacity Field
			case ('capacity'):
				returnVal = <Capacity info={info} savedValue={fieldValue} {...this.props} />;
				break;

			// Facility Field
			case ('facility'):
				let facilityFields = [
					{ field: 'icon', type: 'text', title: __('Icon', 'mana-booking') },
					{ field: 'title', type: 'text', title: __('Title', 'mana-booking') }
				]
				returnVal = <SimpleRepeater fields={facilityFields} info={info} savedValue={fieldValue} {...this.props} />;
				break;

			// Services Field
			case ('service'):
				let serviceFields = [
					{ field: 'title', type: 'text', title: __('Title', 'mana-booking') },
					{ field: 'value', type: 'text', title: __('Value', 'mana-booking') }
				]
				returnVal = <SimpleRepeater fields={serviceFields} info={info} savedValue={fieldValue} {...this.props} />;
				break;

			// Discount Field
			case ('discount'):
				let discountFields = [
					{ field: 'night', type: 'number', title: __('Night', 'mana-booking') },
					{ field: 'percent', type: 'number', title: __('%', 'mana-booking') }
				]
				returnVal = <SimpleRepeater fields={discountFields} info={info} savedValue={fieldValue} {...this.props} />;
				break;

			// Gallery Field
			case ('gallery'):
				returnVal = <Gallery info={info} savedValue={fieldValue} onImageChanged={val => this.props.onFieldChanged(info.fieldIndex, val)} {...this.props} />;
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
				returnVal = <SeasonalPrice info={info} savedValue={fieldValue} {...this.props} />;
				break;

			// Room List Fields
			case ('room-list'):
				returnVal = <RoomList info={info} savedValue={fieldValue} {...this.props} />;
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
					</div>;
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
					</div>;
				break;

			// Seasons Fields
			case ('seasons'):
				returnVal = <Seasons info={info} savedValue={fieldValue} {...this.props} />;
				break;

			// Membership Fields
			case ('membership'):
				returnVal = <Membership info={info} savedValue={fieldValue} {...this.props} />;
				break;

			// Currency Fields
			case ('currency'):
				returnVal = <Currency info={info} savedValue={fieldValue} {...this.props} />;
				break;

			// Export Fields
			case ('export'):
				returnVal = <Export info={info} savedValue={fieldValue} {...this.props} />;
				break;

			// Import Fields
			case ('import'):
				returnVal = <Import info={info} savedValue={fieldValue} {...this.props} />;
				break;

			// Demo Fields
			case ('demo'):
				returnVal = <div className="demo-txt">{fieldValue}</div>;
				break;
		}

		return (
			conditionalField &&
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
				<div className={`value-box ${info.type}`}>{returnVal}</div>
				{
					info.type === 'toggle' && <div className="desc-box">{info.desc}</div>
				}
				{
					info.alertBox && <div className="desc-box alert">{info.alertBox}</div>
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
