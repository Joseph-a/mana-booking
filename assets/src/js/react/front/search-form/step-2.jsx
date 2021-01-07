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
        [formError, setFormError] = useState([]),
        [termsAndCondition, setTermsAndCondition] = useState(false),
        [paymentOptionSec, setPaymentOptionSec] = useState(false),
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
        },

        validateForm = () => {
            const { firstName, lastName, phone, email } = guestInfo;
            let errorArray = [];
            if (firstName === '') {
                errorArray.push('firstName');
            }
            if (lastName === '') {
                errorArray.push('lastName');
            }
            if (phone === '') {
                errorArray.push('phone');
            }
            var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
            if (email === '' || !pattern.test(email)) {
                errorArray.push('email');
            }
            if (!termsAndCondition) {
                errorArray.push('termsAndCondition');
            }
            setFormError(errorArray);
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
                    <div className={`guest-info-field ${formError.indexOf('firstName') >= 0 ? 'has-error' : ''}`}>
                        <label>
                            <div className="title-box">
                                {__('First Name', 'mana-booking')}
                                <span className="required-txt">{__('(required)', 'mana-booking')}</span>
                                {
                                    formError.indexOf('firstName') >= 0 &&

                                    <span className="error-box">{__('Please fill this field.', 'mana-booking')}</span>
                                }
                            </div>
                            <input
                                type="text"
                                onChange={(e) => handleInputChange(e.target.value, 'firstName')}
                                value={guestInfo.firstName}
                            />
                        </label>
                    </div>
                    <div className={`guest-info-field ${formError.indexOf('lastName') >= 0 ? 'has-error' : ''}`}>
                        <label>
                            <div className="title-box">
                                {__('Last Name', 'mana-booking')}
                                <span className="required-txt">{__('(required)', 'mana-booking')}</span>
                                {
                                    formError.indexOf('lastName') >= 0 &&
                                    <span className="error-box">{__('Please fill this field.', 'mana-booking')}</span>
                                }
                            </div>
                            <input
                                type="text"
                                onChange={(e) => handleInputChange(e.target.value, 'lastName')}
                                value={guestInfo.lastName}
                            />
                        </label>
                    </div>
                </div>
                <div className="guest-info-row">
                    <div className={`guest-info-field ${formError.indexOf('phone') >= 0 ? 'has-error' : ''}`}>
                        <label>
                            <div className="title-box">
                                {__('Phone', 'mana-booking')}
                                <span className="required-txt">{__('(required)', 'mana-booking')}</span>
                                {
                                    formError.indexOf('phone') >= 0 &&
                                    <span className="error-box">{__('Please fill this field.', 'mana-booking')}</span>
                                }
                            </div>
                            <input
                                type="text"
                                onChange={(e) => handleInputChange(e.target.value, 'phone')}
                                value={guestInfo.phone}
                            />
                        </label>
                    </div>
                    <div className={`guest-info-field ${formError.indexOf('email') >= 0 ? 'has-error' : ''}`}>
                        <label>
                            <div className="title-box">
                                {__('Email', 'mana-booking')}
                                <span className="required-txt">{__('(required)', 'mana-booking')}</span>
                                {
                                    formError.indexOf('email') >= 0 &&
                                    <span className="error-box">{__('Please fill this field with the correct format.', 'mana-booking')}</span>
                                }
                            </div>
                            <input
                                type="email"
                                onChange={(e) => handleInputChange(e.target.value, 'email')}
                                value={guestInfo.email}
                            />
                        </label>
                    </div>
                </div>
                <div className="guest-info-row single">
                    <div className="guest-info-field">
                        <label>
                            <div className="title-box">{__('Address', 'mana-booking')}</div>
                            <input
                                type="text"
                                onChange={(e) => handleInputChange(e.target.value, 'address')}
                                value={guestInfo.address}
                                placeholder={__('Address', 'mana-booking')}
                            />
                        </label>
                    </div>
                </div>
                <div className="guest-info-row single">
                    <div className="guest-info-field">
                        <label>
                            <div className="title-box">{__('Special Requirements', 'mana-booking')}</div>
                            <textarea
                                onChange={(e) => handleInputChange(e.target.value, 'requirements')}
                                value={guestInfo.requirements}
                            ></textarea>
                        </label>
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
            <div className={`terms-condition-row ${formError.indexOf('termsAndCondition') >= 0 ? 'has-error' : ''}`}>
                <span className="mana-checkbox">
                    <label>
                        <input
                            type="checkbox"
                            checked={termsAndCondition}
                            onChange={e => setTermsAndCondition(!termsAndCondition)}
                        />
                        <span></span>
                        {__('I have read and accept the terms and conditions.', 'mana-booking')}
                    </label>
                    <span className="required-txt">{__('(required)', 'mana-booking')}</span>
                </span>
            </div>
            <div className="btn-sec">
                {
                    formError.length > 0 &&
                    <div className="validate-form-error">{__('Please fill all the required fields with valid values.', 'mana-booking')}</div>
                }
                <button
                    className="left"
                    onClick={() => props.setStep(1)}
                >{__('Previous Step', 'mana-booking')}</button>
                <button
                    className="right"
                    onClick={() => {
                        validateForm();
                    }}
                >{__('Payment Options', 'mana-booking')}</button>
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