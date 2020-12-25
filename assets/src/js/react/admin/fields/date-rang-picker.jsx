import React, { Component } from 'react'
import 'react-dates/initialize';
import { DateRangePicker } from 'react-dates';
import moment from 'moment';

export default class ManaDateRangPicker extends Component {
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
        const startDate = this.state.startDate ? this.state.startDate.format('DD-MM-YYYY') : null,
            endDate = this.state.endDate ? this.state.endDate.format('DD-MM-YYYY') : null;

        if (startDate !== prevState.startDate || endDate !== prevState.endDate) {

            let newVal = [startDate];
            if (this.state.endDate) newVal.push(endDate);

            this.props.onDateChange(newVal);
        }
    }

    dateChangeHandle = (startDate, endDate) => {
        const { affectedIds } = this.props;

        this.setState({ startDate, endDate })
        if (affectedIds.length > 0) {
            document.getElementById(affectedIds[0]).value = startDate.format('DD-MM-YYYY');
            if (endDate) {
                document.getElementById(affectedIds[1]).value = endDate.format('DD-MM-YYYY');
            }
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
                onDatesChange={({ startDate, endDate }) => this.dateChangeHandle(startDate, endDate)}
                focusedInput={this.state.focusedInput}
                onFocusChange={focusedInput => this.setState({ focusedInput })}
                displayFormat="DD-MM-YYYY"
                noBorder={true}
                small={true}
                readOnly={true}
            />
        )
    }
}
