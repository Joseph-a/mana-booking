import {
	__
} from '@wordpress/i18n';
import {
	manaRoomSettings
} from '../../../constant'


export const roomSettings = [{
		label: __('Basic Information', 'mana-booking'),
		icon: 'dashicons-admin-generic',
		value: [{
				label: __('Short Description', 'mana-booking'),
				type: 'textarea',
				fieldIndex: manaRoomSettings.SHORT_DESC_INDEX,
				value: '',
				desc: __('Add a short description about this room to be shown in the room listing pages. Do Not use HTML tags.', 'mana-booking')
			},
			{
				label: __('Room Count', 'mana-booking'),
				type: 'number',
				fieldIndex: manaRoomSettings.ROOM_COUNT_INDEX,
				value: '',
				desc: __('Add the count of this kind of room in the hotel like : 30', 'mana-booking')
			},
			{
				label: __('Room Capacity', 'mana-booking'),
				type: 'capacity',
				fieldIndex: manaRoomSettings.CAPACITY_INDEX,
				value: {
					main: 0,
					extra: 0
				},
				desc: __('Set the capacity of the room here. Main Capacity is the capacity of the room without extra guests. Extra capacity is for rooms in which can be accepted extra guests.', 'mana-booking')
			},
			{
				label: __('Minimum Stay', 'mana-booking'),
				type: 'number',
				fieldIndex: manaRoomSettings.MIN_STAY_INDEX,
				value: '',
				desc: __('Add the minimum stay night for this room like : "2". which means that guests must book this room for 2 or more nights. Leave it blank if the room doesn\'t have minimum stay limitation.', 'mana-booking')
			},
			{
				label: __('Room Size', 'mana-booking'),
				type: 'number',
				fieldIndex: manaRoomSettings.ROOM_SIZE_INDEX,
				value: '',
				desc: __('Add the area of room', 'mana-booking')
			},
			{
				label: __('Size Unit', 'mana-booking'),
				type: 'select',
				fieldIndex: manaRoomSettings.SIZE_UNIT_INDEX,
				value: '',
				options: [{
						value: 'sqft',
						label: __('Square Foot (sqft)', 'mana-booking')
					},
					{
						value: 'm2',
						label: __('Square Meter (m2)', 'mana-booking')
					},
					{
						value: 'acre',
						label: __('Acre (acre)', 'mana-booking')
					},
					{
						value: 'ha',
						label: __('Hectare (ha)', 'mana-booking')
					},
					{
						value: 'sqkm',
						label: __('Square Kilometer (sqkm)', 'mana-booking')
					},
					{
						value: 'sqmi',
						label: __('Square Mile (sqmi)', 'mana-booking')
					},
					{
						value: 'sqyd',
						label: __('Square Yard (sqyd)', 'mana-booking')
					}
				],
				desc: ''
			},
			{
				label: __('View', 'mana-booking'),
				type: 'text',
				fieldIndex: manaRoomSettings.VIEW_INDEX,
				value: '',
				desc: __('Add the view of room, for example: Garden, Sea.', 'mana-booking')
			},
			{
				label: __('Facilities', 'mana-booking'),
				type: 'facility',
				fieldIndex: manaRoomSettings.FACILITY_INDEX,
				value: [],
				desc: __('Add the facilities of this room.', 'mana-booking')
			},
			{
				label: __('Services', 'mana-booking'),
				type: 'service',
				fieldIndex: manaRoomSettings.SERVICE_INDEX,
				value: [],
				desc: __('Add the services of this room.', 'mana-booking')
			}
		]
	},
	{
		label: __('Price Information', 'mana-booking'),
		icon: 'dashicons-clipboard',
		value: [{
				label: __('Base Price', 'mana-booking'),
				type: 'price',
				fieldIndex: manaRoomSettings.BASE_PRICE_INDEX,
				value: {},
				desc: __('Add base price, the price which is used for main capacity of room, of room in this field.', 'mana-booking')
			},
			{
				label: __('Extra Guest Price', 'mana-booking'),
				type: 'price',
				fieldIndex: manaRoomSettings.EXTRA_GUEST_PRICE_INDEX,
				value: {},
				desc: __('Add base price, the price which is used for extra capacity of room, of room in this field.', 'mana-booking')
			},
			{
				label: __('Seasonal Price', 'mana-booking'),
				type: 'seasonal-price',
				fieldIndex: manaRoomSettings.SEASONAL_PRICE_INDEX,
				value: [],
				desc: __('Set the room price based on the date. These prices will override the base price during the period you set.', 'mana-booking')
			},
			{
				label: __('Discount', 'mana-booking'),
				type: 'discount',
				fieldIndex: manaRoomSettings.DISCOUNT_INDEX,
				value: [],
				desc: __('Add the discount of this room.', 'mana-booking')
			}
		]
	},
	{
		label: __('Gallery', 'mana-booking'),
		icon: 'dashicons-format-gallery',
		value: [{
			label: __('Gallery', 'mana-booking'),
			type: 'gallery',
			fieldIndex: manaRoomSettings.GALLERY_INDEX,
			value: [],
			desc: __('Manage room\'s images with this field.', 'mana-booking')
		}]
	},
	{
		label: __('Settings'),
		icon: 'dashicons-admin-settings',
		value: [{
				label: __('Rating System', 'mana-booking'),
				type: 'toggle',
				fieldIndex: manaRoomSettings.RATING_SYSTEM_INDEX,
				value: false,
				desc: __('Enable / Disable Rating for rooms', 'mana-booking')
			},
			{
				label: __('Booking Overview', 'mana-booking'),
				type: 'toggle',
				fieldIndex: manaRoomSettings.BOOKING_OVERVIEW_INDEX,
				value: false,
				desc: __('Enable / Disable Booking Overview Calendar in Rooms', 'mana-booking')
			},
			{
				label: __('Special Room', 'mana-booking'),
				type: 'toggle',
				fieldIndex: manaRoomSettings.SPECIAL_ROOM_INDEX,
				value: false,
				desc: __('Mark this room as a special room to be listed in [mana-booking-special-rooms] shortcode', 'mana-booking')
			},
		]
	},
];