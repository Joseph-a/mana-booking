import React, { Fragment, useState } from 'react';
import t from 'prop-types';
import { __ } from '@wordpress/i18n';

const Step2 = (props) => {
    console.log('Step-2', props);
    const [selectedRooms, setRoom] = useState(props.selectedRooms);
    return (
        <Fragment>
            .

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