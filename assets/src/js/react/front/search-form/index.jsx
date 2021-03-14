import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { __ } from '@wordpress/i18n';
import { serialize } from 'object-to-formdata';
import moment from 'moment';

import Step1 from './step-1';
import Step2 from './step-2';
import Step3 from './step-3';

export default class ManaSearchForm extends Component {
    constructor(props) {
        super(props);
        this.state = {
            step: 1,
            securityNonce: props.securityNonce,
            checkIn: moment(),
            checkOut: moment().add(2, 'days'),
            selectedRooms: [{
                adult: 1,
                child: 0,
                room: null
            }],
            services: [],
            guestInfo: {},
            paymentValue: 'full',
            coupon: {},
            priceDetails: {}
        }
        this.handleStep1 = this.handleStep1.bind(this);
        this.handleStep2 = this.handleStep2.bind(this);
        // this.handleStep3 = this.handleStep3.bind(this);
        this.setStep = this.setStep.bind(this);
        this.finalizeBooking = this.finalizeBooking.bind(this);
    }

    handleStep1(checkIn, checkOut, selectedRooms, services) {
        this.setState({
            step: 2,
            checkIn,
            checkOut,
            selectedRooms,
            services
        })
    }

    handleStep2(guestInfo = {}, priceDetails = {}, coupon = {}, paymentValue = 'full') {
        this.setState({
            guestInfo,
            paymentValue,
            coupon,
            priceDetails
        })
    }

    finalizeBooking(type, guestInfo, paymentInfo = {}) {
        const { checkIn, checkOut, selectedRooms, services, priceDetails, paymentValue } = this.state,
            { duration, weekends } = this.daysCalculator(checkIn, checkOut),
            bookingInfo = {
                checkIn,
                checkOut,
                guestInfo,
                room: selectedRooms,
                paymentMethod: type,
                services,
                priceDetails,
                duration,
                weekends,
                totalBookingPrice: priceDetails.payablePrice,
                paymentPriceMethod: paymentValue,
                vat: priceDetails.vat,
                userID: mana_booking_obj.user_id
            };

        console.log('YoosefHEERRR', paymentInfo);
        this.setState({ guestInfo });
        this.sendBookingInfo(bookingInfo);
    }

    async sendBookingInfo(bookingInfo) {
        const { securityNonce } = this.state,
            options = {
                indices: true,
                allowEmptyArrays: false,
            },
            insertBooking = await fetch(mana_booking_obj.ajaxurl, {
                method: "POST",
                body: serialize({
                    action: "mana_booking_insert_booking",
                    security: securityNonce,
                    bookingInfo
                }, options)
            });

        return await insertBooking.json()
    }

    daysCalculator(from, to) {
        const fromDate = new Date(from),
            toDate = new Date(to),
            fromDateTime = fromDate.getTime(),
            toDateTime = toDate.getTime(),
            aDay = 24 * 60 * 60 * 1000,
            daysDiff = parseInt((toDateTime - fromDateTime) / aDay, 10) + 1;

        let weekends = 0;
        for (var i = fromDateTime; i <= toDateTime; i += aDay) {

            var d = new Date(i);
            if (d.getDay() == 6 || d.getDay() == 0) {
                weekends++;
            }
        }
        return {
            duration: daysDiff,
            weekends
        }
    }

    setStep(step) {
        this.setState({
            step
        })
    }

    render() {
        const { step, checkIn, checkOut, selectedRooms, services, securityNonce, priceDetails, paymentValue } = this.state;
        const componentProps = {
            security: securityNonce,
            checkIn,
            checkOut,
            selectedRooms,
            services,
            priceDetails,
            paymentValue,
            setStep: this.setStep,
            finalizeBooking: this.finalizeBooking
        }
        switch (step) {
            case 2:
                return (<Step2 handleStep2={this.handleStep2} {...componentProps} />)
                break;
            case 3:
                return (<Step3 />)
                break;
            default:
                return (<Step1 handleStep1={this.handleStep1} {...componentProps} />)
                break;
        }
    }
}

const searchForms = document.getElementsByClassName("mana-booking-search-form-container");
if (searchForms.length > 0) {
    for (let item of searchForms) {
        const formContainer = item.children[2];
        let securityNonce = formContainer.getAttribute('data-security')
        ReactDOM.render(<ManaSearchForm securityNonce={securityNonce} />, formContainer);
    }
}
