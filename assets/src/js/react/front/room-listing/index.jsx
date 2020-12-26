import React, { Fragment, Component } from 'react'
import ReactDOM from 'react-dom';
import RoomBoxed from './room-boxed';
import RoomRow from './room-row';

export default class ManaRoomListing extends Component {

    constructor(props) {
        super(props);
        this.state = {
            type: 'boxed',
            rooms: []
        }
    }

    fetchRooms = async () => {
        const rooms = await fetch(mana_booking_obj.apiUrl + 'rooms');
        return await rooms.json();
    }

    componentDidMount() {
        this.fetchRooms().then(res => {
            if (res.status) {
                this.setState({ rooms: res.rooms });
            }
        })
    }

    render() {
        const { rooms, type } = this.state;
        const ComponentTag = type === 'boxed' ? RoomBoxed : RoomRow;

        return (
            <Fragment>
                {
                    rooms.map((room, i) => <ComponentTag key={i} roomInfo={room} />)
                }
            </Fragment>
        )
    }
}


const roomListing = document.getElementsByClassName("mana-booking-room-listing-container");
if (roomListing.length > 0) {
    for (let item of roomListing) {
        const roomContainer = item.children[2];
        ReactDOM.render(<ManaRoomListing />, roomContainer);
    }
}
