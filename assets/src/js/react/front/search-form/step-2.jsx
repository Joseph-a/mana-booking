import React, { Fragment, useEffect, useState } from 'react';
import t from 'prop-types';
import { serialize } from 'object-to-formdata';
import { __ } from '@wordpress/i18n';
import NumberFormat from 'react-number-format';


const Step2 = (props) => {
    const { checkIn, checkOut, selectedRooms, services } = props,
        [coupon, setCoupon] = useState(''),
        [couponInfo, setCouponInfo] = useState(null),
        [couponError, setCouponError] = useState(''),
        [priceDetails, setPriceDetails] = useState({}),
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
            props.handleStep2(newGuestInfo, priceDetails, couponInfo);
        },

        checkCoupon = async () => {
            const fetchCoupon = await fetch(mana_booking_obj.ajaxurl, {
                method: "POST",
                body: serialize({
                    action: "mana_booking_check_coupon",
                    security: mana_booking_obj.coupon_security,
                    coupon
                })
            });
            return await fetchCoupon.json()
        },

        couponCalculator = (info) => {
            let newPriceDetails = { ...priceDetails };
            if (info.type === 'percent') {
                let couponValue = Math.round(((totalPrice(true) + vatPrice(true)) * info.percent) / 100);
                newPriceDetails['coupon'] = couponValue;
                newPriceDetails['payablePrice'] = newPriceDetails.payablePrice - couponValue;
            } else {
                newPriceDetails['coupon'] = info.price;
                newPriceDetails['payablePrice'] = newPriceDetails.payablePrice - info.price;
            }

            return newPriceDetails;
        },

        submitCoupon = () => {
            setCouponError('');
            checkCoupon().then(res => {
                if (!res.status) {
                    setCouponError(res.message);
                } else {
                    setCouponInfo(res.info);
                    setCouponError(res.message);

                    let newPriceDetails = couponCalculator(res.info);
                    setPriceDetails(newPriceDetails);
                    props.handleStep2(guestInfo, newPriceDetails, res.info);
                }
            });
        };



    useEffect(() => {
        setPriceDetails({
            serviceAndRoom: totalPrice(true),
            vat: vatPrice(true),
            payablePrice: payablePrice(true),
            currencyInfo: mana_booking_obj.currency
        });
        props.handleStep2(null, priceDetails);
    }, [])

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

            <div className="coupon-input-container">
                {
                    !couponInfo &&
                    <Fragment>
                        <div className={`coupon-row ${coupon ? 'has-coupon' : ''}`}>
                            <input
                                type="text"
                                value={coupon}
                                placeholder={__('Coupon', 'mana-booking')}
                                onChange={e => setCoupon(e.target.value)}
                            />
                            {
                                coupon !== '' &&
                                <button
                                    onClick={() => submitCoupon()}
                                >{__('Submit', 'mana-booking')}</button>
                            }
                        </div>
                        {
                            couponError && <div className="message-container error">{couponError}</div>
                        }
                    </Fragment>
                }
                {
                    couponInfo && <div className="message-container success">{couponError}</div>
                }
            </div>

            <table className="booking-info-tbl">
                <tbody>
                    {
                        priceDetails.serviceAndRoom &&
                        <tr>
                            <th>{__('Rooms & Services', 'mana-booking')}:</th>
                            <th><span className="value">{priceFormatter(priceDetails.serviceAndRoom)}</span></th>
                        </tr>
                    }
                    {
                        priceDetails.vat &&
                        <tr>
                            <th>{__('VAT', 'mana-booking')} %{mana_booking_obj.vat}:</th>
                            <th><span className="value">{priceFormatter(priceDetails.vat)}</span></th>
                        </tr>
                    }
                    {
                        priceDetails.coupon &&
                        <tr>
                            <th>{__('Coupon', 'mana-booking')}:</th>
                            <th><span className="value">{priceFormatter(priceDetails.coupon)}</span></th>
                        </tr>
                    }
                    {
                        priceDetails.payablePrice &&
                        <tr>
                            <th>{__('Total Price', 'mana-booking')}:</th>
                            <th className="total-price-value">{priceFormatter(priceDetails.payablePrice)}</th>
                        </tr>
                    }
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