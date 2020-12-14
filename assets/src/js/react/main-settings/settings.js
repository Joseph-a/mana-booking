import {
    __
} from '@wordpress/i18n';
import {
    manaMainSetting
} from '../../constant'

export const manaMainSettings = [{
        label: __('General', 'mana-booking'),
        fields: [{
                label: __('Room Archive Page Layout', 'mana-booking'),
                desc: __('"Room Archive Page Layout" will be used for "Room Archive" page template.', 'mana-booking'),
                fieldIndex: manaMainSetting.ROOM_ARCHIVE_LAYOUT,
                type: 'select',
                options: [{
                        label: __('Grid View', 'mana-booking'),
                        value: '1'
                    },
                    {
                        label: __('List View', 'mana-booking'),
                        value: '2'
                    },
                ],
                value: '1'
            },
            {
                label: __('Booking URL', 'mana-booking'),
                desc: __('Booking URL is used for booking page that you can modify it. It will be show in address bar after ? and the default value is "?mana-booking"', 'mana-booking'),
                fieldIndex: manaMainSetting.BOOKING_URL,
                type: 'text',
                value: 'mana-booking'
            },
            {
                label: __('Contact Page URL', 'mana-booking'),
                desc: __('The contact page\'s URL will be used in every sections that users need extra information.', 'mana-booking'),
                fieldIndex: manaMainSetting.CONTACT_URL,
                type: 'url',
                value: ''
            },
            {
                label: __('Booking Archive Items Per Page', 'mana-booking'),
                desc: '',
                fieldIndex: manaMainSetting.BOOKING_ARCHIVE_PER_PAGE,
                type: 'number',
                value: 12
            },
            {
                label: __('Payment Archive Items Per Page', 'mana-booking'),
                desc: '',
                fieldIndex: manaMainSetting.PAYMENT_ARCHIVE_PER_PAGE,
                type: 'number',
                value: 12
            },
            {
                label: __('Room Listing Image Slider', 'mana-booking'),
                desc: __('If you enable "Room Listing Image Slider", all the rooms\' images will be shown in slider in listing views.', 'mana-booking'),
                fieldIndex: manaMainSetting.ROOM_LISTING_IMAGE_SLIDER,
                type: 'toggle',
                value: false
            },
            {
                label: __('Room Rating status', 'mana-booking'),
                desc: __('You can enable/disable rating system and handle its items in this section.', 'mana-booking'),
                fieldIndex: manaMainSetting.ROOM_RATING_STATUS,
                type: 'toggle',
                value: false
            },
            {
                label: __('Room Rating Item', 'mana-booking'),
                desc: '',
                fieldIndex: manaMainSetting.ROOM_RATING_ITEMS,
                type: 'single-repeater',
                value: []
            },
            {
                label: __('Default Email Sender', 'mana-booking'),
                desc: __('By help of "Default Email Sender" and "Default Email Sender\'s Name" you can change the default WordPress email sender and its name. It is used for sending core feature\'s notification like registration and etc. The default email sender of WordPress is "wordpress@your_domain.com" and its name is "WordPress".', 'mana-booking'),
                fieldIndex: manaMainSetting.DEFAULT_EMAIL_SENDER,
                type: 'email',
                value: ''
            },
            {
                label: __('Default Email Sender\'s Name', 'mana-booking'),
                desc: __('By help of "Default Email Sender" and "Default Email Sender\'s Name" you can change the default WordPress email sender and its name. It is used for sending core feature\'s notification like registration and etc. The default email sender of WordPress is "wordpress@your_domain.com" and its name is "WordPress".', 'mana-booking'),
                fieldIndex: manaMainSetting.DEFAULT_EMAIL_SENDER_NAME,
                type: 'email',
                value: ''
            },
        ]
    },
    {
        label: __('Booking', 'mana-booking'),
        fields: [{
                label: __('Room Base Price', 'mana-booking'),
                desc: __('If you enable "Room Base Price", all of your room\'s price will be calculated based on the room\'s main capacity. It means that the price will be fixed untill the guest count is more than the main capacity of rooms.', 'mana-booking'),
                fieldIndex: manaMainSetting.ROOM_BASE_PRICE,
                type: 'toggle',
                value: false
            },
            {
                label: __('Vat (percent)', 'mana-booking'),
                desc: __('Default value for vat is 8%, if you want to use the default value leave it blank.', 'mana-booking'),
                fieldIndex: manaMainSetting.VAT,
                type: 'percent',
                value: 8
            },
            {
                label: __('Deposit in Booking Process', 'mana-booking'),
                desc: __('You can enable/disable deposit in the booking process, if you disable it, all users must pay full price of their bookings', 'mana-booking'),
                fieldIndex: manaMainSetting.DEPOSIT_IN_BOOKING,
                type: 'toggle',
                value: false
            },
            {
                label: __('Deposit (percent)', 'mana-booking'),
                desc: __('Default value of deposit us 20%, so if you want to use the default value leave it blank.', 'mana-booking'),
                fieldIndex: manaMainSetting.DEPOSIT,
                type: 'percent',
                value: 20
            },
            {
                label: __('Booking By Email', 'mana-booking'),
                desc: __('You can enable/disable booking by email, in booking by email process, users can book without any payments.', 'mana-booking'),
                fieldIndex: manaMainSetting.BOOKING_BY_EMAIL,
                type: 'toggle',
                value: false
            },
            {
                label: __('Terms & Condition Page URL', 'mana-booking'),
                desc: '',
                fieldIndex: manaMainSetting.TERM_CONDITION_PAGE_URL,
                type: 'url',
                value: ''
            },
            {
                label: __('Final Booking Page Title', 'mana-booking'),
                desc: '',
                fieldIndex: manaMainSetting.FINAL_BOOKING_PAGE_TITLE,
                type: 'text',
                value: ''
            },
            {
                label: __('Final Booking Page Subtitle', 'mana-booking'),
                desc: '',
                fieldIndex: manaMainSetting.FINAL_BOOKING_PAGE_SUBTITLE,
                type: 'text',
                value: ''
            },
            {
                label: __('Final Booking Page Description', 'mana-booking'),
                desc: '',
                fieldIndex: manaMainSetting.FINAL_BOOKING_PAGE_DESC,
                type: 'textarea',
                value: ''
            },
            {
                label: __('External Booking System', 'mana-booking'),
                desc: __('You can enable/disable booking by email, in booking by email process, users can book without any payments.', 'mana-booking'),
                fieldIndex: manaMainSetting.EXTERNAL_BOOKING_SYSTEM,
                type: 'toggle',
                value: false
            },
            {
                label: __('External Booking URL', 'mana-booking'),
                desc: '',
                fieldIndex: manaMainSetting.EXTERNAL_BOOKING_URL,
                type: 'url',
                value: ''
            },
            {
                label: __('External Booking Send Method', 'mana-booking'),
                desc: __('If you set external booking system for your website, you can set that booking information will be sent to your URL in POST or GET method.', 'mana-booking'),
                fieldIndex: manaMainSetting.EXTERNAL_BOOKING_SEND_METHOD,
                type: 'select',
                options: [{
                        label: __('POST', 'mana-booking'),
                        value: '1'
                    },
                    {
                        label: __('GET', 'mana-booking'),
                        value: '2'
                    },
                ],
                value: '1'
            }
        ]
    },
    {
        label: __('Payment', 'mana-booking'),
        fields: [{
                label: __('Booking By PayPal', 'mana-booking'),
                desc: __('', 'mana-booking'),
                fieldIndex: manaMainSetting.BOOKING_BY_PAYPAL,
                type: 'toggle',
                value: false
            },
            {
                label: __('Paypal Email', 'mana-booking'),
                desc: __('', 'mana-booking'),
                fieldIndex: manaMainSetting.PAYPAL_EMAIL,
                type: 'email',
                value: '',
                conditional: {
                    ifField: manaMainSetting.BOOKING_BY_PAYPAL,
                    ifValue: true
                }
            },
            {
                label: __('Paypal Action URL', 'mana-booking'),
                desc: __('You can change the action url for payment\'s form. For testing paypayl use https://www.sandbox.paypal.com/cgi-bin/webscr and after testing use the real one : https://www.paypal.com/cgi-bin/webscr', 'mana-booking'),
                fieldIndex: manaMainSetting.PAYPAL_ACTION_URL,
                type: 'url',
                value: '',
                alertBox: __('Do not forget to change https://www.sandbox.paypal.com/cgi-bin/webscr to https://www.paypal.com/cgi-bin/webscr after your tests.', 'mana-booking'),
                conditional: {
                    ifField: manaMainSetting.BOOKING_BY_PAYPAL,
                    ifValue: true
                }
            },
            {
                label: __('Paypal Default Currency', 'mana-booking'),
                desc: __('If you set a "Current Currency" default currency for Paypal, total booking price will calculated based on the user-selected or current currency before sending to Paypal website.', 'mana-booking'),
                fieldIndex: manaMainSetting.PAYPAL_DEFAULT_CURRENCY,
                type: 'select',
                options: [{
                    label: __('Current Currency', 'mana-booking'),
                    value: 'no_item'
                }],
                value: 'no_item',
                alertBox: __('If you set a default currency for Paypal, total booking price will be exchanged to this currency before sending to Paypal website.', 'mana-booking'),
                conditional: {
                    ifField: manaMainSetting.BOOKING_BY_PAYPAL,
                    ifValue: true
                }
            },
            {
                label: __('Booking By Paymill', 'mana-booking'),
                desc: __('If you need to have Paymill payments in your booking process, after enabling its option, you must enter both Private and Public keys in this section. For further information, you can check this URL : https://developers.paymill.com/guides/introduction/your-account#2-api-keys', 'mana-booking'),
                fieldIndex: manaMainSetting.BOOKING_BY_PAYMILL,
                type: 'toggle',
                value: false
            },
            {
                label: __('Paymill Public Key', 'mana-booking'),
                desc: __('', 'mana-booking'),
                fieldIndex: manaMainSetting.PAYMILL_PUBLIC_KEY,
                type: 'textarea',
                value: '',
                conditional: {
                    ifField: manaMainSetting.BOOKING_BY_PAYMILL,
                    ifValue: true
                }
            },
            {
                label: __('Booking By Stripe', 'mana-booking'),
                desc: __('If you need to have Stripe payments in your booking process, after enabling its option, you must enter both Publishable and Secret keys in this section. For further information, you can check this URL : https://stripe.com/docs/dashboard#api-keys', 'mana-booking'),
                fieldIndex: manaMainSetting.BOOKING_BY_STRIPE,
                type: 'toggle',
                value: false
            },
            {
                label: __('Stripe Publishable Key', 'mana-booking'),
                desc: __('', 'mana-booking'),
                fieldIndex: manaMainSetting.STRIPE_PUBLISHABLE_KEY,
                type: 'textarea',
                value: '',
                conditional: {
                    ifField: manaMainSetting.BOOKING_BY_STRIPE,
                    ifValue: true
                }
            },
            {
                label: __('Stripe Secret Key', 'mana-booking'),
                desc: __('', 'mana-booking'),
                fieldIndex: manaMainSetting.STRIPE_SECRET_KEY,
                type: 'textarea',
                value: '',
                conditional: {
                    ifField: manaMainSetting.BOOKING_BY_STRIPE,
                    ifValue: true
                }
            },

        ]
    },
    {
        label: __('Email Notification', 'mana-booking'),
        fields: [{
                label: __('Email Notification Status', 'mana-booking'),
                desc: __('You can enable/disable email notification by switching this field.', 'mana-booking'),
                fieldIndex: manaMainSetting.EMAIL_NOTIFICATION_STATUS,
                type: 'toggle',
                value: false
            },
            {
                label: __('Email Sender', 'mana-booking'),
                desc: __('', 'mana-booking'),
                fieldIndex: manaMainSetting.EMAIL_SENDERS,
                type: 'email',
                value: '',
                alertBox: __('Use an email from your website for email sender. For example if your website is "your_website.com", your email must be something like "sender@your_website.com"', 'mana-booking')
            },
            {
                label: __('Email Receivers', 'mana-booking'),
                desc: __('', 'mana-booking'),
                fieldIndex: manaMainSetting.EMAIL_RECEIVERS,
                type: 'single-repeater',
                value: []
            },
            {
                label: __('Booking Details For Users', 'mana-booking'),
                desc: __('If you want your guests receive their booking information you set for the admins of website, enable this option.', 'mana-booking'),
                fieldIndex: manaMainSetting.BOOKING_DETAILS_FOR_USERS,
                type: 'toggle',
                value: false
            },
            {
                label: __('Email Template of Admins', 'mana-booking'),
                desc: __('', 'mana-booking'),
                fieldIndex: manaMainSetting.EMAIL_TEMPLATE_FOR_ADMINS,
                type: 'editor',
                value: '',
                alertBox: __('For putting extra information in your email, you can use these shortcode to provide more details about the booking. Here is the list of shortcode that you can use in this field :[guest-first-name][guest-last-name][guest-email][guest-phone][guest-address][guest-special-requirement][guest-check-in][guest-check-out][guest-room][guest-services][guest-booking-total-price]', 'mana-booking')
            },
            {
                label: __('Email template of users', 'mana-booking'),
                desc: __('', 'mana-booking'),
                fieldIndex: manaMainSetting.EMAIL_TEMPLATE_FOR_USERS,
                type: 'editor',
                value: '',
                alertBox: __('For putting extra information in your email, you can use these shortcode to provide more details about the booking. Here is the list of shortcode that you can use in this field :[guest-first-name][guest-last-name][guest-email][guest-phone][guest-address][guest-special-requirement][guest-check-in][guest-check-out][guest-room][guest-services][guest-booking-total-price]', 'mana-booking')
            },
        ]
    },
    {
        label: __('Currency', 'mana-booking'),
        fields: [{
                label: __('Currency Separator', 'mana-booking'),
                desc: __('', 'mana-booking'),
                fieldIndex: manaMainSetting.CURRENCY_SEPARATOR,
                type: 'select',
                options: [{
                        label: ',',
                        value: '1'
                    },
                    {
                        label: '.',
                        value: '2'
                    },
                    {
                        label: __('Space', 'mana-booking'),
                        value: '3'
                    },
                ],
                value: '1'
            },
            {
                label: __('Currency Decimal', 'mana-booking'),
                desc: __('', 'mana-booking'),
                fieldIndex: manaMainSetting.CURRENCY_DECIMAL,
                type: 'select',
                options: [{
                        label: __('None', 'mana-booking'),
                        value: ''
                    },
                    {
                        label: '1',
                        value: '1'
                    },
                    {
                        label: '2',
                        value: '2'
                    },
                    {
                        label: '3',
                        value: '3'
                    },
                    {
                        label: '4',
                        value: '4'
                    },
                    {
                        label: '5',
                        value: '5'
                    },
                ],
                value: '1'
            },
            {
                label: __('Currency Decimal Separator', 'mana-booking'),
                desc: __('', 'mana-booking'),
                fieldIndex: manaMainSetting.CURRENCY_DECIMAL_SEPARATOR,
                type: 'select',
                options: [{
                        label: '.',
                        value: '1'
                    },
                    {
                        label: ',',
                        value: '2'
                    }
                ],
                value: '1'
            },
            {
                label: __('', 'mana-booking'),
                desc: __('', 'mana-booking'),
                fieldIndex: manaMainSetting.CURRENCY_LIST,
                type: 'currency',
                value: {
                    defaultCurrency: 0,
                    currencyList: []
                }
            }
        ]
    },
    {
        label: __('Membership', 'mana-booking'),
        fields: [{
            label: __('', 'mana-booking'),
            desc: __('', 'mana-booking'),
            fieldIndex: manaMainSetting.MEMBERSHIP,
            type: 'membership',
            value: []
        }]
    },
    {
        label: __('Seasonal Price', 'mana-booking'),
        fields: [{
            label: __('', 'mana-booking'),
            desc: __('', 'mana-booking'),
            fieldIndex: manaMainSetting.SEASONAL_PRICE,
            type: 'seasons',
            value: []
        }]
    },
    {
        label: __('Export & Import', 'mana-booking'),
        fields: [{
                label: __('Export', 'mana-booking'),
                desc: __('After downloading the content, you can open the downloaded file with a simple text editor.', 'mana-booking'),
                fieldIndex: manaMainSetting.EXPORT,
                type: 'export',
                value: {}
            },
            {
                label: __('Import', 'mana-booking'),
                desc: __('The import section accepts JSON content, so please be sure that your content has correct format.', 'mana-booking'),
                fieldIndex: manaMainSetting.IMPORT,
                type: 'import',
                value: ''
            }
        ]
    }
];