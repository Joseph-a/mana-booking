import React, { Component } from 'react';
import { __ } from '@wordpress/i18n';

import {
    Modal,
    ButtonGroup,
    ToggleControl,
    PanelBody,
    RangeControl,
    SelectControl,
    TextControl,
    Button,
    BaseControl
} from "@wordpress/components";


export default class Fields extends Component {
    constructor(props) {
        super(props);
    }

    fieldSwitcher = (info) => {
        let returnVal;
        switch (info.type) {
            
            // TextArea Field
            case ('textarea'):
                returnVal = <BaseControl>
                    <label className="components-base-control__label">{info.label}</label>
                    <textarea
                        placeholder={info.label}
                        value={info.value}
                        onChange={e => this.props.onFieldChanged(e.target.value)}
                    ></textarea>
                </BaseControl>;
                break;

            // Select Field
            case ('select'):
                returnVal = <SelectControl
                    label={info.label}
                    value={info.value}
                    options={info.options}
                    onChange={val => this.props.onFieldChanged(val)}
                />
                break;

            // Text Field
            case ('text'):
                returnVal = <TextControl
                    label={info.label}
                    placeholder={info.label}
                    value={info.value}
                    onChange={val => this.props.onFieldChanged(val)}
                />;
                break;

        }

        return returnVal;
    }
    render() {
        return (
            <div className="field-row">
                {this.fieldSwitcher(this.props.info)}
            </div>
        )
    }
}
