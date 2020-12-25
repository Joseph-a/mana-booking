import React, { Component } from 'react'
import 'react-dates/initialize';
import { DateRangePicker } from 'react-dates';
import moment from 'moment';

export default class ManaDateRangPicker extends Component {
    constructor(props) {
        super(props);

        this.state = {
            randId: Math.random() * 100,
            startDate: props.startDate ? moment(props.startDate, 'YYYY-MM-DD') : null,
            endDate: props.endDate ? moment(props.endDate, 'YYYY-MM-DD') : null,
            focusedInput: null,
        }
    }
    componentDidUpdate = (prevState) => {
        const startDate = this.state.startDate ? this.state.startDate.format('YYYY-MM-DD') : null,
            endDate = this.state.endDate ? this.state.endDate.format('YYYY-MM-DD') : null;

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
            document.getElementById(affectedIds[0]).value = startDate.format('YYYY-MM-DD');
            if (endDate) {
                document.getElementById(affectedIds[1]).value = endDate.format('YYYY-MM-DD');
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
                displayFormat="YYYY-MM-DD"
                noBorder={true}
                small={true}
                readOnly={true}
            />
        )
    }
}
