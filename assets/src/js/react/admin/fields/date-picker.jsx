import React, { Component } from 'react'
import 'react-dates/initialize';
import { SingleDatePicker } from 'react-dates';
import moment from 'moment';

export default class ManaDatePicker extends Component {
    constructor(props) {
        super(props);

        this.state = {
            randId: Math.random() * 100,
            date: props.date ? moment(props.date, 'DD-MM-YYYY') : null,
            focusedInput: null,
        }
    }

    render() {
        const { randId } = this.state;
        return (
            <SingleDatePicker
                date={this.state.date}
                onDateChange={date => {
                    this.setState({ date });
                    this.props.onDateChange(date.format('DD-MM-YYYY'));
                }}
                focused={this.state.focused}
                onFocusChange={({ focused }) => this.setState({ focused })}
                id={randId + ''}
                displayFormat="DD-MM-YYYY"
                noBorder={true}
                small={true}
                readOnly={true}
                numberOfMonths={1}
            />
        )
    }
}
