import React, { useState, useEffect } from 'react';
import { __ } from '@wordpress/i18n';

const SingleRepeater = (props) => {
    const { info, field, savedValue } = props;
    const [hasEmptyInput, setEmptyInput] = useState();

    const inputChanges = (val, index) => {
        let newVal = [...savedValue];
        newVal[index] = val;
        props.onFieldChanged(info.fieldIndex, newVal);
    }

    const validateInputValue = () => {
        let hasEmpty = false;
        savedValue.map(item => {
            if (item === '') hasEmpty = true;
        });
        setEmptyInput(hasEmpty);
    }

    useEffect(() => {
        validateInputValue();
    });

    return (
        <div className="repeater-box-container">
            {
                savedValue.map((item, index) => {
                    return (
                        <div className={`repeater-row single`} key={index}>
                            <input
                                type={field.type}
                                value={item || ''}
                                placeholder={field.title}
                                onChange={e => {
                                    inputChanges(e.target.value, index)
                                    validateInputValue(e.target.value, index)
                                }}
                            />
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
            {
                !hasEmptyInput &&
                <button
                    onClick={() => {
                        const newVal = [...savedValue, ''];
                        props.onFieldChanged(info.fieldIndex, newVal);
                    }}
                    className="button button-primary button-large"
                >{__('Add New', 'mana-booking')}</button>
            }
        </div>
    )
}

export default SingleRepeater
