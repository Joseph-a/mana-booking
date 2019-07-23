import React, { Component } from 'react'
import 'react-dates/initialize';
import { DateRangePicker } from 'react-dates';
import moment from 'moment';

export default class RavisDateRangPicker extends Component {

    constructor(props) {
        super(props);

        this.state = {
            randId: Math.random() * 100,
            startDate: props.startDate ? moment(props.startDate, 'DD-MM-YYYY') : null,
            endDate: props.endDate ? moment(props.endDate, 'DD-MM-YYYY') : null,
            focusedInput: null,
        }
    }
    componentDidUpdate = (prevState) => {
        if (this.state.startDate !== prevState.startDate || this.state.endDate !== prevState.endDate) {

            let newVal = [this.state.startDate.format('DD-MM-YYYY')];
            if(this.state.endDate) newVal.push(this.state.endDate.format('DD-MM-YYYY'));

            this.props.onDateChange(newVal);
        }
    }

    render() {
        const { randId } = this.state;
        return (
            <DateRangePicker
                startDateId={`startDate_${randId}`}
                endDateId={`endDate_${randId}`}
                startDate={this.state.startDate}
                endDate={this.state.endDate}
                onDatesChange={({ startDate, endDate }) => { this.setState({ startDate, endDate }) }}
                focusedInput={this.state.focusedInput}
                onFocusChange={(focusedInput) => { this.setState({ focusedInput }) }}
                displayFormat="DD-MM-YYYY"
                noBorder={true}
                small={true}
                readOnly={true}
            />
        )
    }
}
