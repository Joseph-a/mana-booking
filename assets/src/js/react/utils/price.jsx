import React from 'react';
import NumberFormat from 'react-number-format';

export const priceFormatter = value => {
    let currencyInfo = mana_booking_obj.currency,
        settings = {
            displayType: 'text',
            thousandSeparator: mana_booking_obj.currencySeparator === 'space' ? ' ' : mana_booking_obj.currencySeparator,
            decimalSeparator: mana_booking_obj.currencyDecimalSeparator,
            decimalScale: parseInt(mana_booking_obj.currencyDecimal),
            fixedDecimalScale: true,
            value
        };

    currencyInfo.position !== '1' ?
        settings['suffix'] = currencyInfo.symbol :
        settings['prefix'] = currencyInfo.symbol;

    return <NumberFormat {...settings} />;
}