import React, { Fragment, useEffect, useState } from 'react';
import { serialize } from 'object-to-formdata';
import { __ } from '@wordpress/i18n';

function Services(props) {
    const { checkIn, checkOut, selectedRooms } = props,
        [selectedServices, setSelectedServices] = useState(props.serviceList || []),
        [servicesList, setServices] = useState(),
        totalGuest = () => {
            let count = 0;
            selectedRooms.map(room => count += (parseInt(room.adult) + parseInt(room.child)));
            return count;
        },
        getServices = async () => {
            const duration = checkOut.diff(checkIn, 'days'),
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
                        <tr key={i}>
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
        let mandatoryServices = []
        getServices().then(res => {
            setServices(res)

            // Set Mandatory Services
            res.mandatory.map(service => {
                mandatoryServices.push({
                    id: service.id,
                    title: service.title,
                    price: service.total_price
                })
            });
            console.log(mandatoryServices);

            setSelectedServices(mandatoryServices);
        });

    }, []);

    return (
        <Fragment>
            <h3>{__('Services', 'mana-booking')}</h3>
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
                    onClick={() => props.handleServices(selectedServices)}
                >{__('Next Step', 'mana-booking')}</button>
            </div>
        </Fragment >
    )
}

export default Services
