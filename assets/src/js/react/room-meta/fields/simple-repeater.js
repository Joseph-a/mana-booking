import React from 'react';
import { __ } from '@wordpress/i18n';

const SimpleRepeater = (props) => {
    const { info, fields } = props;
    const inputChanges = (val, name, index) => {
        let newVal = [...info.value];
        newVal[index][name] = val;
        props.onFieldChanged(newVal);
    }
    return (
        <div className="repeater-box-container">
            {
                info.value.map((item, index) => {
                    return (
                        <div className="repeater-row" key={index}>
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
                                    const newVal = [...info.value];
                                    newVal.splice(index, 1);
                                    props.onFieldChanged(newVal);
                                }}
                                className="remove-item"
                            >X</div>
                        </div>
                    )
                })
            }
            <button
                onClick={() => {
                    const newVal = [...info.value, { icon: '', title: '' }];
                    props.onFieldChanged(newVal);
                }}
                className="button button-primary button-large"
            >{__('Add New', 'ravis-booking')}</button>
        </div>
    )
}

export default SimpleRepeater
