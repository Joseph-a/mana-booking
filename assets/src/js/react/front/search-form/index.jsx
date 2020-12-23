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
        this.handleStep2 = this.handleStep1.bind(this);
        this.handleStep3 = this.handleStep1.bind(this);
    }

    handleStep1(checkIn, checkOut, selectedRooms) {
        this.setState({
            step: 2,
            checkIn,
            checkOut,
            selectedRooms
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

    render() {
        const { step, checkIn, checkOut, selectedRooms, securityNonce } = this.state;
        switch (step) {
            case 2:
                return (<Step2 security={securityNonce} handleStep2={this.handleStep2} checkIn={checkIn} checkOut={checkOut} selectedRooms={selectedRooms} />)
                break;
            case 3:
                return (<Step3 />)
                break;
            default:
                return (<Step1 security={securityNonce} handleStep1={this.handleStep1} />)
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
