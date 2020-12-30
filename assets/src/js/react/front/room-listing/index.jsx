import React, { Fragment, Component } from 'react'
import ReactDOM from 'react-dom';
import RoomBoxed from './room-boxed';
import RoomRow from './room-row';

export default class ManaRoomListing extends Component {

    constructor(props) {
        super(props);
        this.state = {
            type: mana_booking_obj.room_listing_layout === '1' ? 'boxed' : '',
            rooms: []
        }
    }

    fetchRooms = async () => {
        const rooms = await fetch(mana_booking_obj.apiUrl + 'rooms');
        return await rooms.json();
    }

    componentDidMount() {
        const { rooms } = this.props;
        if (!rooms) {
            this.fetchRooms().then(res => {
                if (res.status) {
                    this.setState({ rooms: res.rooms });
                }
            })
        } else {
            this.setState({ rooms });
        }
    }

    render() {
        const { inSearch } = this.props;
        const { rooms, type } = this.state;
        const ComponentTag = type === 'boxed' ? RoomBoxed : RoomRow;

        return (
            <Fragment>
                {
                    rooms.map((room, i) => <ComponentTag key={i} roomInfo={room} imageSlider={mana_booking_obj.image_slider_listing} inSearch={inSearch} {...this.props} />)
                }
            </Fragment>
        )
    }
}


const roomListing = document.getElementsByClassName("mana-booking-room-listing-container");
if (roomListing.length > 0) {
    const layout = mana_booking_obj.room_listing_layout === '1' ? 'boxed' : 'list';
    for (let item of roomListing) {
        const roomContainer = item.children[2];
        roomContainer.classList.add(layout);
        ReactDOM.render(<ManaRoomListing />, roomContainer);
    }
}
