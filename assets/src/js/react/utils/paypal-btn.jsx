import React from 'react';
import ReactDOM from "react-dom";

const PayPalBtn = paypal.Buttons.driver("react", { React, ReactDOM });

const PayPalButton = props => {
    const { price, guestInfo } = props;

    const createOrder = (data, actions) => {
        return actions.order.create({
            purchase_units: [
                {
                    amount: {
                        value: price,
                    },
                },
            ],
        });
    };

    const onApprove = (data, actions) => {
        console.log('PayPal Yoosef: On Approved', data);
        props.finalizeBooking('paypal', guestInfo, data)
        return actions.order.capture();
    };

    return (
        <PayPalBtn
            createOrder={(data, actions) => createOrder(data, actions)}
            onApprove={(data, actions) => onApprove(data, actions)}
        />
    )
}

export default PayPalButton;