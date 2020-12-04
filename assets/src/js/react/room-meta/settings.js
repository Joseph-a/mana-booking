import { __ } from '@wordpress/i18n';

export const roomSettings = [ {
		label: __( 'Basic Information', 'mana-booking' ),
		icon: 'dashicons-admin-generic',
		value: [ {
				label: __( 'Short Description', 'mana-booking' ),
				type: 'textarea',
				value: "",
				desc: __( 'Add a short description about this room to be shown in the room listing pages. Do Not use HTML tags.', 'mana-booking' )
			},
			{
				label: __( 'Room Count', 'mana-booking' ),
				type: 'number',
				value: "",
				desc: __( 'Add the count of this kind of room in the hotel like : 30', 'mana-booking' )
			},
			{
				label: __( 'Room Capacity', 'mana-booking' ),
				type: 'capacity',
				value: {
					main: 0,
					extra: 0
				},
				desc: __( 'Set the capacity of the room here. Main Capacity is the capacity of the room without extra guests. Extra capacity is for rooms in which can be accepted extra guests.', 'mana-booking' )
			},
			{
				label: __( 'Minimum Stay', 'mana-booking' ),
				type: 'number',
				value: "",
				desc: __( 'Add the minimum stay night for this room like : "2". which means that guests must book this room for 2 or more nights. Leave it blank if the room doesn\'t have minimum stay limitation.', 'mana-booking' )
			},
			{
				label: __( 'Room Size', 'mana-booking' ),
				type: 'number',
				value: "",
				desc: __( 'Add the area of room', 'mana-booking' )
			},
			{
				label: __( 'Size Unit', 'mana-booking' ),
				type: 'select',
				value: "",
				options: [
					{ value: "sqft", label: __( "Square Foot (sqft)" ) },
					{ value: "m2", label: __( "Square Meter (m2)" ) },
					{ value: "acre", label: __( "Acre (acre)" ) },
					{ value: "ha", label: __( "Hectare (ha)" ) },
					{ value: "sqkm", label: __( "Square Kilometer (sqkm)" ) },
					{ value: "sqmi", label: __( "Square Mile (sqmi)" ) },
					{ value: "sqyd", label: __( "Square Yard (sqyd)" ) }
				],
				desc: ''
			},
			{
				label: __( 'View', 'mana-booking' ),
				type: 'text',
				value: "",
				desc: __( 'Add the view of room, for example: Garden, Sea.', 'mana-booking' )
			},
			{
				label: __( 'Facilities', 'mana-booking' ),
				type: 'facility',
				value: [],
				desc: __( 'Add the facilities of this room.', 'mana-booking' )
			},
			{
				label: __( 'Services', 'mana-booking' ),
				type: 'service',
				value: [],
				desc: __( 'Add the services of this room.', 'mana-booking' )
			}
		]
	},
	{
		label: __( 'Price Information', 'mana-booking' ),
		icon: 'dashicons-clipboard',
		value: [ {
				label: __( 'Base Price', 'mana-booking' ),
				type: 'price',
				value: {},
				desc: __( 'Add base price, the price which is used for main capacity of room, of room in this field.', 'mana-booking' )
			},
			{
				label: __( 'Extra Guest Price', 'mana-booking' ),
				type: 'price',
				value: {},
				desc: __( 'Add base price, the price which is used for extra capacity of room, of room in this field.', 'mana-booking' )
			},
			{
				label: __( 'Seasonal Price', 'mana-booking' ),
				type: 'seasonal-price',
				value: [],
				desc: __( 'Set the room price based on the date. These prices will override the base price during the period you set.', 'mana-booking' )
			},
			{
				label: __( 'Discount', 'mana-booking' ),
				type: 'discount',
				value: [],
				desc: __( 'Add the discount of this room.', 'mana-booking' )
			}
		]
	},
	{
		label: __( 'Gallery', 'mana-booking' ),
		icon: 'dashicons-format-gallery',
		value: [ {
			label: __( 'Gallery', 'mana-booking' ),
			type: 'gallery',
			value: [],
			desc: __( 'Manage room\'s images with this field.', 'mana-booking' )
		} ]
	},
	{
		label: __( 'Settings' ),
		icon: 'dashicons-admin-settings',
		value: [ {
				label: __( 'Rating System', 'mana-booking' ),
				type: 'toggle',
				value: false,
				desc: __( 'Enable / Disable Rating for rooms', 'mana-booking' )
			},
			{
				label: __( 'Booking Overview', 'mana-booking' ),
				type: 'toggle',
				value: false,
				desc: __( 'Enable / Disable Booking Overview Calendar in Rooms', 'mana-booking' )
			},
			{
				label: __( 'Special Room', 'mana-booking' ),
				type: 'toggle',
				value: false,
				desc: __( 'Mark this room as a special room to be listed in [mana-booking-special-rooms] shortcode', 'mana-booking' )
			},
		]
	},
];
