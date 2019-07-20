import { __ } from '@wordpress/i18n';

export const roomSettings = [ {
		label: __( 'Basic Information' ),
		value: [ {
				label: __( 'Short Description', 'ravis-booking' ),
				type: 'textarea',
				value: ""
			},
			{
				label: __( 'Room Count', 'ravis-booking' ),
				type: 'text',
				value: ""
			},
			{
				label: __( 'Room Capacity', 'ravis-booking' ),
				type: 'capacity',
				value: ""
			},
			{
				label: __( 'Minimum Stay', 'ravis-booking' ),
				type: 'text',
				value: ""
			},
			{
				label: __( 'Room Size', 'ravis-booking' ),
				type: 'text',
				value: ""
			},
			{
				label: __( 'Size Unit', 'ravis-booking' ),
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
				]
			},
			{
				label: __( 'View', 'ravis-booking' ),
				type: 'text',
				value: ""
			},
			{
				label: __( 'Gallery', 'ravis-booking' ),
				type: 'gallery',
				value: []
			},
			{
				label: __( 'Facilities', 'ravis-booking' ),
				type: 'text',
				value: []
			},
			{
				label: __( 'Services', 'ravis-booking' ),
				type: 'text',
				value: []
			}
		]
	},
	{
		label: __( 'Price Information' ),
		value: "2222"
	},
	{
		label: __( 'Settings' ),
		value: "3333"
	},
];
