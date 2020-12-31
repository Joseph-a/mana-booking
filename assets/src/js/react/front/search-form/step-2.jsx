import React, { Fragment, useEffect, useState } from 'react';
import t from 'prop-types';
import { serialize } from 'object-to-formdata';
import moment from 'moment';
import { __ } from '@wordpress/i18n';

const Step2 = (props) => {
    console.log('Step-2', props);
    const { checkIn, checkOut, selectedRooms } = props,
        [servicesList, setServices] = useState(),
        totalGuest = () => {
            let count = 0;
            selectedRooms.map(room => count += (parseInt(room.adult) + parseInt(room.child)));
            return count;
        },
        getServices = async () => {
            const duration = moment(checkOut).diff(checkIn, 'days'),
                roomList = await fetch(mana_booking_obj.ajaxurl, {
                    method: "POST",
                    body: serialize({
                        action: "mana_booking_services",
                        security: props.security,
                        data: {
                            totalGuest: totalGuest(),
                            duration,
                            roomCount: selectedRooms.length
                        }
                    })
                });
            return await roomList.json()
        },
        serviceListOutput = (list) => {
            return (
                list.map((service, i) => {
                    return (
                        <tr>
                            <td>
                                <div className="service-row">
                                    <span className="title">
                                        {service.title}
                                        {
                                            service.total_price.value != 0 &&
                                            <span className="info" dangerouslySetInnerHTML={{ __html: service.price.generated }}></span>
                                        }
                                    </span>
                                    <span className="price">{service.total_price.generated}</span>
                                </div>
                            </td>
                        </tr>
                    )
                })
            )
        };


    useEffect(() => {
        if (mana_booking_obj.booking_service) {
            getServices().then(res => setServices(res));
        }
    }, []);

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
                        servicesList &&
                        <Fragment>
                            <tr>
                                <th colSpan="5">{__('Services', 'mana-booking')}</th>
                            </tr>
                            {
                                servicesList.mandatory &&
                                <tr>
                                    <th>{__('Mandatory', 'mana-booking')} :</th>
                                    <td colSpan="4">
                                        {serviceListOutput(servicesList.mandatory)}
                                    </td>
                                </tr>
                            }
                            {
                                servicesList.optional &&
                                <tr>
                                    <th>{__('Optional', 'mana-booking')} :</th>
                                    <td colSpan="4">
                                        {serviceListOutput(servicesList.optional)}
                                    </td>
                                </tr>
                            }

                        </Fragment>
                    }
                    <tr>
                        <th colSpan="4">{__('Total Price', 'mana-booking')}:</th>
                        <th colSpan="1"><span className="value">{checkOut}</span></th>
                    </tr>
                </tbody>
            </table>
            {
                servicesList &&
                <div className="mana-booking-booking-services">
                    {
                        servicesList.optional &&
                        <div className="service-row-container">
                            <h4 className="title">
                                {__('Optional Services', 'mana-booking')}
                                <span className="info">{__('Please select services you want to have in your staying.', 'mana-booking')}</span>
                            </h4>
                            <table>
                                <tbody>
                                    {serviceListOutput(servicesList.optional)}
                                </tbody>
                            </table>
                        </div>
                    }
                    {
                        servicesList.mandatory &&
                        <div className="service-row-container">
                            <h4 className="title">
                                {__('Mandatory Services', 'mana-booking')}
                                <span className="info">{__('The below services will be added in your booking automatically.', 'mana-booking')}</span>
                            </h4>
                            <table>
                                <tbody>
                                    {serviceListOutput(servicesList.mandatory)}
                                </tbody>
                            </table>
                        </div>
                    }
                </div>
            }
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