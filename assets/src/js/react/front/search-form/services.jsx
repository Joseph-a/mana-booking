import React, { Fragment, useEffect, useState } from 'react';
import { serialize } from 'object-to-formdata';
import { __ } from '@wordpress/i18n';

function Services(props) {
    const { checkIn, checkOut, selectedRooms, serviceList, security } = props,
        [selectedServices, setSelectedServices] = useState(serviceList || []),
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
                        security,
                        data: {
                            totalGuest: totalGuest(),
                            duration,
                            roomCount: selectedRooms.length
                        }
                    })
                });
            return await roomList.json()
        },
        isSelected = (serviceInfo) => {
            const filteredServices = selectedServices.filter(serviceItem => serviceItem.id === serviceInfo.id);
            if (filteredServices.length > 0) {
                return true
            }

            return false;
        },
        handleOptional = (serviceInfo) => {
            let newServices;
            if (isSelected(serviceInfo)) {
                newServices = selectedServices.filter(serviceItem => serviceItem.id !== serviceInfo.id)
            } else {
                newServices = [...selectedServices, serviceInfo];
            }
            setSelectedServices(newServices);
        },
        serviceListOutput = (list, optional = false) => {

            return (
                list.map((service, i) => {
                    const serviceInfo = {
                        id: service.id,
                        title: service.title,
                        price: service.total_price
                    };
                    return (
                        <tr key={i}>
                            <td>
                                <div className="service-row">
                                    <span className="title">
                                        {
                                            optional &&
                                            <span className="mana-checkbox">
                                                <label>
                                                    <input
                                                        type="checkbox"
                                                        checked={isSelected(serviceInfo)}
                                                        onChange={() => handleOptional(serviceInfo)}
                                                    />
                                                    <span></span>
                                                    {service.title}
                                                </label>
                                            </span>
                                        }
                                        {
                                            !optional && <Fragment>{service.title}</Fragment>
                                        }

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

            if (selectedServices.length === 0) {
                // Set Mandatory Services
                res.mandatory.map(service => {
                    mandatoryServices.push({
                        id: service.id,
                        title: service.title,
                        price: service.total_price
                    })
                });

                setSelectedServices(mandatoryServices);
            }
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
                        <div className="service-row-container optional">
                            <h4 className="title">
                                {__('Optional Services', 'mana-booking')}
                                <span className="info">{__('Please select services you want to have in your staying.', 'mana-booking')}</span>
                            </h4>
                            <table>
                                <tbody>
                                    {serviceListOutput(servicesList.optional, true)}
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
