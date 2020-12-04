import { __ } from '@wordpress/i18n';

export const blockDatesSettings = [ {
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
	}
];
