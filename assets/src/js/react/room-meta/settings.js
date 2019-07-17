import { __ } from '@wordpress/i18n';

export const roomSettings = [
    {
        label: __('Basic Information'),
        value: {
            short_desc: {
                value: "",
                type: 'text'
            },
            count: {
                value: "",
                type: 'text'
            },
            capacity: {
                value: "",
                type: 'text'
            },
            min_stay: {
                value: "",
                type: 'text'
            },
            room_size: {
                value: "",
                type: 'text'
            },
            room_view: {
                value: "",
                type: 'text'
            },
            gallery: {
                value: [],
                type: 'text'
            },
            facilities: {
                value: [],
                type: 'text'
            },
            service: {
                value: [],
                type: 'text'
            }
        }
    },
    {
        label: __('Price Information'),
        value: "2222"
    },
    {
        label: __('Settings'),
        value: "3333"
    },
];