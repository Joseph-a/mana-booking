import React, { Fragment, useEffect, useState } from 'react';
import t from 'prop-types';
import { serialize } from 'object-to-formdata';
import { __ } from '@wordpress/i18n';
import { priceFormatter } from '../../utils/price';
import PayPalButton from '../../utils/paypal-btn';


const Step2 = (props) => {
    const { checkIn, checkOut, selectedRooms, services, paymentValue } = props,
        [init, setInit] = useState(false),
        [coupon, setCoupon] = useState(''),
        [couponInfo, setCouponInfo] = useState(null),
        [couponError, setCouponError] = useState(''),
        [priceDetails, setPriceDetails] = useState({}),
        [formError, setFormError] = useState([]),
        [termsAndCondition, setTermsAndCondition] = useState(false),
        [paymentOptionSec, setPaymentOptionSec] = useState(false),
        [paymentValueIn, setPaymentValueIn] = useState(paymentValue),
        [finalPayablePrice, setFinalPayablePrice] = useState(paymentValue),
        [guestInfo, setGuestInfo] = useState({
            firstName: '',
            lastName: '',
            phone: '',
            email: '',
            address: '',
            requirements: '',
        }),

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

            errorArray.length === 0 ? (setPaymentOptionSec(true), setFinalPayablePrice(priceDetails.payablePrice)) : setPaymentOptionSec(false);
        },

        handlePaymentValue = (value) => {
            setPaymentValueIn(value);
            props.handleStep2(guestInfo, priceDetails, couponInfo, value);

            let finalPayablePrice;

            switch (value) {
                case 'deposit':
                    finalPayablePrice = Math.round((priceDetails.payablePrice * mana_booking_obj.deposit) / 100);
                    break;

                default:
                    finalPayablePrice = priceDetails.payablePrice;
                    break;
            }

            setFinalPayablePrice(finalPayablePrice);
        },

        finalizePaidBooking = paymentInfo => {

        };

    useEffect(() => {
        setPriceDetails({
            serviceAndRoom: totalPrice(true),
            vat: vatPrice(true),
            payablePrice: payablePrice(true),
            currencyInfo: mana_booking_obj.currency
        });
        props.handleStep2(null, priceDetails);
        if (init) {
            validateForm();
        }
        setInit(true);
    }, [guestInfo, termsAndCondition])

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
            {
                paymentOptionSec &&
                <div className="booking-option-section">
                    {
                        mana_booking_obj.bookingOptions.email &&
                        <div className="t-sec">
                            <button
                                className="email"
                                onClick={() => props.finalizeBooking('email', guestInfo)}
                            >{__('Book by Email', 'mana-booking')}</button>
                        </div>
                    }
                    {
                        (mana_booking_obj.bookingOptions.paypal || mana_booking_obj.bookingOptions.paymill || mana_booking_obj.bookingOptions.stripe) &&
                        <div className="b-sec" data-prefix={__('Or', 'mana-booking')}>
                            <div className="payable-options">
                                <table className="payable-price-tbl">
                                    <tbody>
                                        <tr>
                                            <td colSpan="2">
                                                <div className="mana-radiobox">
                                                    <label>
                                                        <input type="checkbox"
                                                            checked={paymentValueIn === 'full'}
                                                            onChange={() => handlePaymentValue('full')}
                                                        />
                                                        <span></span>
                                                        {__('Full payment', 'mana-booking')}
                                                    </label>
                                                </div>
                                                <div className="mana-radiobox">
                                                    <label>
                                                        <input type="checkbox"
                                                            checked={paymentValueIn === 'deposit'}
                                                            onChange={() => handlePaymentValue('deposit')}
                                                        />
                                                        <span></span>
                                                        {mana_booking_obj.deposit}% {__('Deposit', 'mana-booking')} <i>{__('Pay the rest on arrival', 'mana-booking')}</i>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>{__('Payable Price', 'mana-booking')}:</th>
                                            <th className="price">{priceFormatter(finalPayablePrice)}</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div className="btn-container">
                                <span className="title-box">{__('Book and pay by', 'mana-booking')}:</span>
                                {
                                    mana_booking_obj.bookingOptions.paypal &&
                                    <Fragment>
                                        <PayPalButton finalizeBooking={props.finalizeBooking} guestInfo={guestInfo} price={finalPayablePrice} />
                                        <button
                                            className="paypal"
                                            onClick={() => props.finalizeBooking('paypal', guestInfo)}
                                        >{__('Paypal', 'mana-booking')}</button>
                                    </Fragment>
                                }
                                {
                                    mana_booking_obj.bookingOptions.paymill &&
                                    <button
                                        className="paymill"
                                        onClick={() => props.finalizeBooking('paymill', guestInfo)}
                                    >{__('Paymill', 'mana-booking')}</button>
                                }
                                {
                                    mana_booking_obj.bookingOptions.stripe &&
                                    <button
                                        className="stripe"
                                        onClick={() => props.finalizeBooking('stripe', guestInfo)}
                                    >{__('Stripe', 'mana-booking')}</button>
                                }
                            </div>
                        </div>
                    }
                </div>
            }

            <div className="btn-sec">
                {
                    formError.length > 0 &&
                    <span className="validate-form-error">{__('Please fill all the required fields with valid values.', 'mana-booking')}</span>
                }
                <button
                    className="left"
                    onClick={() => props.setStep(1)}
                >{__('Previous Step', 'mana-booking')}</button>
                {/* <button
                    className={`right ${paymentOptionSec ? 'active' : ''}`}
                    onClick={() => {
                        validateForm();
                    }}
                >{__('Payment Options', 'mana-booking')}</button> */}
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
    paymentValue: t.string,
    setStep: t.func,
    handleStep2: t.func,
    finalizeBooking: t.func
};

export default Step2