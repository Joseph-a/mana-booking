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
            passengerInfo: {},
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

    handleStep2(checkIn, checkOut, selectedRooms) {
        console.log('Handle Step 2');
        // this.setState({
        //     step: 2,
        //     checkIn,
        //     checkOut,
        //     selectedRooms
        // })
    }

    setStep(step) {
        this.setState({
            step
        })
    }

    render() {
        const { step, checkIn, checkOut, selectedRooms, services, securityNonce } = this.state;
        switch (step) {
            case 2:
                return (<Step2 security={securityNonce} handleStep2={this.handleStep2} checkIn={checkIn} checkOut={checkOut} selectedRooms={selectedRooms} services={services} setStep={this.setStep} />)
                break;
            case 3:
                return (<Step3 />)
                break;
            default:
                return (<Step1 security={securityNonce} handleStep1={this.handleStep1} checkIn={checkIn} checkOut={checkOut} selectedRooms={selectedRooms} services={services} setStep={this.setStep} />)
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
