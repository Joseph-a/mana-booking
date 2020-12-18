import React from 'react';
import { __ } from '@wordpress/i18n';

const SimpleRepeater = (props) => {
    const { info, fields, savedValue } = props;
    const inputChanges = (val, name, index) => {
        let newVal = [...savedValue];
        newVal[index][name] = val;
        props.onFieldChanged(info.fieldIndex, newVal);
    }
    return (
        <div className="repeater-box-container">
            {
                savedValue.map((item, index) => {
                    return (
                        <div className={`repeater-row box-${fields.length}`} key={index}>
                            {
                                fields.map((field, i) => {
                                    return (
                                        <input
                                            key={i}
                                            type={field.type}
                                            value={item[field.field] || ''}
                                            placeholder={field.title}
                                            onChange={e => inputChanges(e.target.value, field.field, index)}
                                        />
                                    )
                                })
                            }
                            <div
                                onClick={() => {
                                    const newVal = [...savedValue];
                                    newVal.splice(index, 1);
                                    props.onFieldChanged(info.fieldIndex, newVal);
                                }}
                                className="remove-item"
                            ><i className="dashicons dashicons-no-alt"></i></div>
                        </div>
                    )
                })
            }
            <button
                onClick={() => {
                    const newVal = [...savedValue, { [fields[0].field]: '', [fields[1].field]: '' }];
                    props.onFieldChanged(info.fieldIndex, newVal);
                }}
                className="button button-primary button-large"
            >{__('Add New', 'mana-booking')}</button>
        </div>
    )
}

export default SimpleRepeater
