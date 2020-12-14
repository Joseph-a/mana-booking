import React, { useState } from 'react';
import { __ } from '@wordpress/i18n';

const Import = (props) => {
    const settings = document.getElementById('mana_booking_main_setting');
    const [newSetting, setInfo] = useState();

    const importSetting = async e => {
        e.preventDefault();
        if (newSetting !== '') {
            settings.value = newSetting;
            // console.log(document.getElementById('mana-options-setting-form'));
            // document.getElementById('mana-options-setting-form').submit();
        }
    }

    return (
        <div className="export-container">
            <textarea
                placeholder={__('Import', 'mana-booking')}
                value={newSetting}
                onChange={e => setInfo(e.target.value)}
            ></textarea>
            <div className="btn-container">
                <button className="button button-primary" onClick={e => importSetting(e)}>{__('Import', 'mana-booking')}</button>
                <span className="desc-box alert">{__('WARNING : by importing your data, the current settings will be overwritten.', 'mana-booking')}</span>
            </div>
        </div >
    )
}

export default Import
