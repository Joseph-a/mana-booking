import React, { useState } from 'react';
import { __ } from '@wordpress/i18n';

const Import = (props) => {
    const settings = document.getElementById('mana_booking_main_setting');
    const [validJson, validateJsonInput] = useState();
    const [newSetting, setInfo] = useState();

    const importSetting = async e => {
        e.preventDefault();
        if (newSetting !== '') {
            settings.value = newSetting;
            let form = document.getElementById('mana-options-setting-form'),
                submitFormFunction = Object.getPrototypeOf(form).submit;
            submitFormFunction.call(form);
        }
    }

    const validateJson = (str) => {
        let returnVal = true;
        try {
            JSON.parse(str);
        } catch (e) {
            returnVal = false;
        }
        validateJsonInput(returnVal);
    }

    return (
        <div className="export-container">
            <p>
                <span className="desc-box alert">{__('WARNING : by importing your data, the current settings will be overwritten.', 'mana-booking')}</span>
            </p>
            <br />
            <textarea
                className={newSetting && !validJson ? 'invalid-input' : ''}
                placeholder={__('Import', 'mana-booking')}
                value={newSetting}
                onChange={e => {
                    setInfo(e.target.value);
                    validateJson(e.target.value);
                }}
            ></textarea>
            <div className="btn-container">
                {
                    (newSetting && validJson) && <button className="button button-primary" onClick={e => importSetting(e)}>{__('Import', 'mana-booking')}</button>
                }
                {
                    (newSetting && !validJson) && <div className="desc-box alert">{__('Please enter a proper JSON value.', 'mana-booking')}</div>
                }
            </div>
        </div >
    )
}

export default Import
