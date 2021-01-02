import React, { Fragment, useEffect, useState } from 'react';
import t from 'prop-types';
import { __ } from '@wordpress/i18n';
import NumberFormat from 'react-number-format';


const Step2 = (props) => {
    const { checkIn, checkOut, selectedRooms, services } = props,
        [guestInfo, setGuestInfo] = useState({
            firstName: '',
            lastName: '',
            phone: '',
            email: '',
            address: '',
            requirements: '',
        }),

        priceFormatter = value => {
            let currencyInfo = mana_booking_obj.currency,
                settings = {
                    displayType: 'text',
                    thousandSeparator: mana_booking_obj.currencySeparator,
                    decimalSeparator: mana_booking_obj.currencyDecimalSeparator,
                    decimalScale: mana_booking_obj.currencyDecimal,
                    value
                };

            currencyInfo.position !== '1' ?
                settings['suffix'] = currencyInfo.symbol :
                settings['prefix'] = currencyInfo.symbol;

            console.log(settings);

            return <NumberFormat {...settings} />;
        },


        totalPrice = (value = false) => {
            let totalValue = 0;

            selectedRooms.map(room => {
                totalValue += room.room.price.raw;
            });

            services.map(service => {
                totalValue += service.price.value;
            });

            if (value) {
                return totalValue;
            }

            return priceFormatter(totalValue);
        },

        vatPrice = (value = false) => {
            const vat = Math.round((totalPrice(true) * parseInt(mana_booking_obj.vat)) / 100);
            if (value) {
                return vat;
            }
            return priceFormatter(vat);
        },

        payablePrice = (value = false) => {

            if (value) {
                return vatPrice(true) + totalPrice(true);
            }

            return priceFormatter(vatPrice(true) + totalPrice(true));
        },

        handleInputChange = (value, field) => {
            let newGuestInfo = { ...guestInfo, [field]: value };
            setGuestInfo(newGuestInfo);
            props.handleStep2(newGuestInfo);
        }

    return (
        <Fragment>
            <table className="booking-info-tbl">
                <tbody>
                    <tr>
                        <th colSpan="5">{__('Booking information', 'mana-booking')}</th>
                    </tr>
                    <tr>
                        <td colSpan="3">{__('Check In', 'mana-booking')}: <span className="value">{checkIn}</span></td>
                        <td colSpan="2">{__('Check In', 'mana-booking')}: <span className="value">{checkOut}</span></td>
                    </tr>
                    {
                        selectedRooms.map((room, i) => {
                            return (
                                <Fragment key={i}>
                                    <tr>
                                        <td>{__('Rooms', 'mana-booking')}: <span className="value">{i + 1}</span></td>
                                        <td>{__('Adult', 'mana-booking')}: <span className="value">{room.adult}</span></td>
                                        <td>{__('Child', 'mana-booking')}: <span className="value">{room.child}</span></td>
                                        <td>{__('Room', 'mana-booking')}: <span className="value">{room.room.title}</span></td>
                                        <td>{__('Price', 'mana-booking')}: <span className="value">{room.room.price.generated}</span></td>
                                    </tr>
                                </Fragment>
                            )
                        })
                    }
                    {
                        services.length > 0 &&
                        <Fragment>
                            <tr>
                                <th colSpan="5">{__('Services', 'mana-booking')}</th>
                            </tr>
                            {
                                services.map((service, i) => {
                                    return (
                                        <tr className="service-row" key={i}>
                                            <td colSpan="4">#{i + 1} : <span className="value">{service.title}</span></td>
                                            <td>{__('Price', 'mana-booking')}: <span className="value">{service.price.generated}</span></td>
                                        </tr>
                                    )
                                })
                            }
                        </Fragment>
                    }
                </tbody>
            </table>

            <div className="guest-info-container">
                <div className="guest-info-row">
                    <div className="guest-info-field">
                        <input
                            type="text"
                            onChange={(e) => handleInputChange(e.target.value, 'firstName')}
                            value={guestInfo.firstName}
                            placeholder={__('First Name *', 'mana-booking')}
                        />
                    </div>
                    <div className="guest-info-field">
                        <input
                            type="text"
                            onChange={(e) => handleInputChange(e.target.value, 'lastName')}
                            value={guestInfo.lastName}
                            placeholder={__('Last Name *', 'mana-booking')}
                        />
                    </div>
                </div>
                <div className="guest-info-row">
                    <div className="guest-info-field">
                        <input
                            type="text"
                            onChange={(e) => handleInputChange(e.target.value, 'phone')}
                            value={guestInfo.phone}
                            placeholder={__('Phone *', 'mana-booking')}
                        />
                    </div>
                    <div className="guest-info-field">
                        <input
                            type="email"
                            onChange={(e) => handleInputChange(e.target.value, 'email')}
                            value={guestInfo.email}
                            placeholder={__('Email *', 'mana-booking')}
                        />
                    </div>
                </div>
                <div className="guest-info-row single">
                    <div className="guest-info-field">
                        <input
                            type="text"
                            onChange={(e) => handleInputChange(e.target.value, 'address')}
                            value={guestInfo.address}
                            placeholder={__('Address', 'mana-booking')}
                        />
                    </div>
                </div>
                <div className="guest-info-row single">
                    <div className="guest-info-field">
                        <textarea
                            placeholder={__('Special Requirements', 'mana-booking')}
                            onChange={(e) => handleInputChange(e.target.value, 'requirements')}
                            value={guestInfo.requirements}
                        ></textarea>
                    </div>
                </div>
            </div>

            <table className="booking-info-tbl">
                <tbody>
                    <tr>
                        <th>{__('Rooms & Services', 'mana-booking')}:</th>
                        <th><span className="value">{totalPrice()}</span></th>
                    </tr>
                    <tr>
                        <th>{__('VAT', 'mana-booking')} %{mana_booking_obj.vat}:</th>
                        <th><span className="value">{vatPrice()}</span></th>
                    </tr>
                    <tr>
                        <th>{__('Total Price', 'mana-booking')}:</th>
                        <th className="total-price-value">{payablePrice()}</th>
                    </tr>
                </tbody>
            </table>
            <div className="btn-sec">
                <button
                    onClick={() => props.setStep(1)}
                >{__('Previous Step', 'mana-booking')}</button>
            </div>
        </Fragment >
    )
}

Step2.propTypes = {
    security: t.string,
    checkIn: t.oneOfType([
        t.string,
        t.object
    ]),
    checkOut: t.oneOfType([
        t.string,
        t.object
    ]),
    selectedRooms: t.array,
    services: t.array,
    setStep: t.func,
    handleStep2: t.func
};

export default Step2