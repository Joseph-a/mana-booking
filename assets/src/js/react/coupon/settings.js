import {
	__
} from '@wordpress/i18n';
import {
	manaCouponSettings
} from '../../constant'

export const couponSettings = [{
		label: __('Description', 'mana-booking'),
		desc: __('Add a short description about this coupon.', 'mana-booking'),
		fieldIndex: manaCouponSettings.DESCRIPTION,
		type: 'textarea',
		value: ''
	},
	{
		label: __('Discount Type', 'mana-booking'),
		desc: __('Select which type of discount you want to set for the total booking price.', 'mana-booking'),
		fieldIndex: manaCouponSettings.DISCOUNT_TYPE,
		type: 'select',
		options: [{
				value: 'percent',
				label: __('Percent', 'mana-booking')
			},
			{
				value: 'price',
				label: __('Fixed Price', 'mana-booking')
			}
		],
		value: 'percent'
	},
	{
		label: __('Percent', 'mana-booking'),
		desc: __('If you have set Percent for your coupon, you can set the discount\'s percent in this field. Please add just a digit', 'mana-booking'),
		fieldIndex: manaCouponSettings.PERCENT,
		type: 'number',
		value: ''
	},
	{
		label: __('Price', 'mana-booking'),
		desc: __('If you have set fixed price for your coupon, you can set the fixed discount in this field. Please add just a digit', 'mana-booking'),
		fieldIndex: manaCouponSettings.PRICE,
		type: 'number',
		value: ''
	},
	{
		label: __('Expire Date', 'mana-booking'),
		desc: __('Set when this coupon will be expired.', 'mana-booking'),
		fieldIndex: manaCouponSettings.EXPIRE_DATE,
		type: 'date-picker',
		value: null
	},
	{
		label: __('Coupon Amount', 'mana-booking'),
		desc: __('Set how many coupon you need to set for this coupon.', 'mana-booking'),
		fieldIndex: manaCouponSettings.COUPON_AMOUNT,
		type: 'number',
		value: ''
	},
	{
		label: __('Used Coupon', 'mana-booking'),
		desc: __('How many coupon have been used until now.', 'mana-booking'),
		fieldIndex: manaCouponSettings.USED_COUPON,
		type: 'demo',
		value: 0,
	}
];