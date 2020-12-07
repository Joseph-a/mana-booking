import {
	__
} from '@wordpress/i18n';
import {
	manaBlockDatesSettings
} from '../../constant'

export const blockDatesSettings = [{
		label: __('Start / End date', 'mana-booking'),
		type: 'date-range-picker',
		fieldIndex: manaBlockDatesSettings.PERIOD,
		value: {
			start: null,
			end: null
		},
		desc: __('Select when the block date starts and ends.', 'mana-booking')
	},
	{
		label: __('Rooms', 'mana-booking'),
		type: 'room-list',
		fieldIndex: manaBlockDatesSettings.ROOMS,
		value: [],
		desc: __('Select rooms that are blocked during this block dates.', 'mana-booking')
	},

];