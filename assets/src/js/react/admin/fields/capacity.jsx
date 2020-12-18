import React from 'react'

const Capacity = (props) => {
    const { info, savedValue } = props;
    const capacityGenerator = (val, type) => {
        const newVal = { ...savedValue, [type]: val };
        props.onFieldChanged(info.fieldIndex, newVal);
    }
    return (
        <div className="capacity-row">
            <input
                type="number"
                min="0"
                step="1"
                placeholder={info.label}
                value={savedValue.main}
                onChange={e => capacityGenerator(e.target.value, 'main')}
            /> +
            <input
                type="number"
                min="0"
                step="1"
                placeholder={info.label}
                value={savedValue.extra}
                onChange={e => capacityGenerator(e.target.value, 'extra')}
            />
        </div>
    )
}

export default Capacity
