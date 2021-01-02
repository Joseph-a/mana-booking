import React, { Component, Fragment } from 'react';
import ReactDOM from 'react-dom';
import { __ } from '@wordpress/i18n';

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
            paymentMethod: 'full',
            coupon: {},
        }
        this.handleStep1 = this.handleStep1.bind(this);
        this.handleStep2 = this.handleStep2.bind(this);
        // this.handleStep3 = this.handleStep3.bind(this);
        this.setStep = this.setStep.bind(this);
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

    handleStep2(guestInfo = {}, paymentMethod = 'full', coupon = {}) {
        this.setState({
            guestInfo,
            paymentMethod,
            coupon
        })
    }

    setStep(step) {
        this.setState({
            step
        })
    }

    render() {
        const { step, checkIn, checkOut, selectedRooms, services, securityNonce } = this.state;
        const componentProps = {
            security: securityNonce,
            checkIn,
            checkOut,
            selectedRooms,
            services,
            setStep: this.setStep
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
