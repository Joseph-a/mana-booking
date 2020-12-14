import React from 'react';
import { __ } from '@wordpress/i18n';

const Export = (props) => {
    const settings = document.getElementById('mana_booking_main_setting').value;

    const copyToClipboard = (e) => {
        let el = document.createElement('textarea');
        el.value = settings;
        el.setAttribute('readonly', '');
        document.body.appendChild(el);
        el.select();
        document.execCommand('copy');
        document.body.removeChild(el);
    }

    const downloadFile = (filename, elId, mimeType) => {
        let elHtml = document.getElementById(elId).value,
            link = document.createElement('a');

        mimeType = mimeType || 'text/plain';

        link.setAttribute('download', filename);
        link.setAttribute('href', 'data:' + mimeType + ';charset=utf-8,' + encodeURIComponent(elHtml));
        link.click();
    }

    return (
        <div className="export-container">
            <div className="code">{settings}</div>
            <div className="btn-container">
                <button className="button button-primary" onClick={e => downloadFile('mana-booking-settings.json', 'mana-booking-export-data', 'application/json')}>{__('Export as JSON file', 'mana-booking')}</button>
                <button className="button button-primary" onClick={e => copyToClipboard(e)}>{__('Copy to Clipboard', 'mana-booking')}</button>
            </div>
        </div>
    )
}

export default Export
