import React, { useState, useEffect } from 'react';
import { __ } from '@wordpress/i18n';

const RoomList = (props) => {
    const { info, savedValue } = props;
    const url = mana_booking.rest_url + 'rooms';
    const [roomList, setData] = useState();

    useEffect(() => {
        async function fetchData() {
            const response = await fetch(url);
            const json = await response.json();
            setData(json);
        }
        fetchData();
    }, [url]);

    const roomListGenerator = id => {
        const idIndex = savedValue.indexOf(id + '');
        const newRooms = idIndex < 0 ? [...savedValue, id] : savedValue.filter(el => el !== id + '');
        props.onFieldChanged(info.fieldIndex, newRooms)
    }
    return (
        <div className="room-list-main-container">
            <div className="room-list-images-list">
                {
                    roomList && roomList.map(item => {
                        return (
                            <div key={item.id}>
                                <input
                                    type="checkbox"
                                    value={item.id}
                                    checked={savedValue.indexOf(item.id + '') > -1}
                                    onChange={e => roomListGenerator(e.target.value)}
                                />
                                {item.title.rendered}
                            </div>
                        )
                    })
                }
            </div>
        </div>
    )
}

export default RoomList
