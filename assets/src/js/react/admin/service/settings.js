import {
	__
} from '@wordpress/i18n';
import {
	manaServiceSettings
} from '../../../constant'

export const serviceSettings = [{
		label: __('Load in Shortcode', 'mana-booking'),
		desc: __('Enable this field if you want this service loads in [mana-booking-services] shortcode.', 'mana-booking'),
		fieldIndex: manaServiceSettings.SHORTCODE,
		type: 'toggle',
		value: true
	},
	{
		label: __('Load in Booking Process', 'mana-booking'),
		desc: __('Enable this field if you want this service loads in booking process that users can select it as extra services.', 'mana-booking'),
		fieldIndex: manaServiceSettings.BOOKING,
		type: 'toggle',
		value: false,
		affectedId: 'mana_booking_service_booking'
	},
	{
		label: __('Price Type', 'mana-booking'),
		desc: __('Select if this service is free or paid.', 'mana-booking'),
		fieldIndex: manaServiceSettings.PRICE_TYPE,
		type: 'select',
		options: [{
				label: __('Free', 'mana-booking'),
				value: 'free'
			},
			{
				label: __('Paid', 'mana-booking'),
				value: 'paid'
			},
		],
		value: 'free'
	},
	{
		label: __('Price', 'mana-booking'),
		desc: __('Add price details for your service', 'mana-booking'),
		fieldIndex: manaServiceSettings.PRICE,
		type: 'single-price',
		value: '',
		conditional: {
			ifField: manaServiceSettings.PRICE_TYPE,
			ifValue: 'paid'
		}
	},
	{
		label: __('Price Type', 'mana-booking'),
		desc: __('Set the price type', 'mana-booking'),
		fieldIndex: manaServiceSettings.PRICE_TYPE_GUEST,
		type: 'select',
		options: [{
				label: __('Per Guest', 'mana-booking'),
				value: 1
			},
			{
				label: __('Booking', 'mana-booking'),
				value: 2
			},
			{
				label: __('Per Room', 'mana-booking'),
				value: 3
			},
		],
		value: 1,
		conditional: {
			ifField: manaServiceSettings.PRICE_TYPE,
			ifValue: 'paid'
		}
	},
	{
		label: __('Price Period', 'mana-booking'),
		desc: __('Set the price period', 'mana-booking'),
		fieldIndex: manaServiceSettings.PRICE_TYPE_NIGHT,
		type: 'select',
		options: [{
				label: __('Per Night', 'mana-booking'),
				value: 1
			},
			{
				label: __('Booking', 'mana-booking'),
				value: 2
			}
		],
		value: 1,
		conditional: {
			ifField: manaServiceSettings.PRICE_TYPE,
			ifValue: 'paid'
		}
	},
	{
		label: __('Mandatory', 'mana-booking'),
		desc: __('Enable this field if you want this service will un-selectable by user during the booking process. It always will be checked.', 'mana-booking'),
		fieldIndex: manaServiceSettings.MANDATORY,
		type: 'toggle',
		value: false
	},
];