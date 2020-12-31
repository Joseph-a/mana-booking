import React, { Fragment, useEffect, useState } from 'react';
import t from 'prop-types';
import { serialize } from 'object-to-formdata';
import moment from 'moment';
import { __ } from '@wordpress/i18n';

const Step2 = (props) => {
    console.log('Step-2', props);
    const { checkIn, checkOut, selectedRooms } = props,
        [services, setServices] = useState([]),
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
        };


    useEffect(() => {
        if (mana_booking_obj.booking_service) {
            getServices().then(res => console.log(res));
        }
    });

    // mana_booking_obj.booking_service
    return (
        <Fragment>
            <table className="booking-info-tbl">
                <tbody>
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
                </tbody>
            </table>
            <div className="btn-sec">
                <button
                    onClick={() => props.setStep(1)}
                >{__('Previous Step', 'mana-booking')}</button>
            </div>
        </Fragment>
    )
}

Step2.propTypes = {
    checkIn: t.string,
    checkOut: t.string,
    selectedRooms: t.array,
    handleStep2: t.func
};

export default Step2