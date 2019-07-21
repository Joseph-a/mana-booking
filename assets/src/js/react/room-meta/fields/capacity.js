import React from 'react'

const Capacity = (props) => {
    const { info } = props;
    const capacityGenerator = (val, type) => {
        const newVal = { ...info.value, [type]: val };
        props.onFieldChanged(newVal);
    }
    return (
        <div className="capacity-row">
            <input
                type="number"
                placeholder={info.label}
                value={info.value.main}
                onChange={val => capacityGenerator(val.target.value, 'main')}
            /> +
            <input
                type="number"
                placeholder={info.label}
                value={info.value.extra}
                onChange={val => capacityGenerator(val.target.value, 'extra')}
            />
        </div>
    )
}

export default Capacity
