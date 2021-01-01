import React, { Fragment } from 'react';
import t from 'prop-types';
import { __ } from '@wordpress/i18n';

const Step2 = (props) => {
    const { checkIn, checkOut, selectedRooms, services } = props;
    const totalPrice = () => {
        let totalValue = 0,
            currencySymbol = '',
            symbolPosition = 'left';

        selectedRooms.map((room, i) => {
            totalValue += room.room.price.raw;

            if (i === 0) {
                let priceParts = room.room.price.generated.split(room.room.price.raw + '');
                if (priceParts[1] === '') {
                    currencySymbol = priceParts[0];
                } else {
                    symbolPosition = 'right';
                    currencySymbol = priceParts[1];
                }
            }
        });

        services.map(service => {
            totalValue += service.price.value;
        });

        if (symbolPosition === 'right') {
            return totalValue + currencySymbol;
        }

        return currencySymbol + (totalValue + '');
    };

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
                    <tr>
                        <th colSpan="4">{__('Total Price', 'mana-booking')}:</th>
                        <th colSpan="1" className="total-price-value">{totalPrice()}</th>
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
    checkIn: t.string,
    checkOut: t.string,
    selectedRooms: t.array,
    handleStep2: t.func
};

export default Step2