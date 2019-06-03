import React from 'react';
import {Button, Col, Row, Form, FormGroup, Label, Input} from 'reactstrap';
import "react-datepicker/dist/react-datepicker.css";
import DatePicker from "react-datepicker";
import moment from "moment";
import SimpleReactValidator from 'simple-react-validator'


class BookingRoomDate extends React.Component {
    constructor(props) {
        super(props);
        this.validator = new SimpleReactValidator({
            validators: {
                randomValidator: {
                    message: 'Where is email?',
                    rule: (val, params, validator) => {
                        return validator.helpers.testRegex(val, /^[A-Z0-9.!#$%&'*+-/=?^_`{|}~]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i)
                    }
                }
            },
            messages: {
                required: 'See väli on kohustuslik',
                date: 'Palun sisestage valiidne kuupäev'
            }
        });
    }

    saveAndContinue = (e) => {
        e.preventDefault();
        if (this.validator.allValid()) {
            this.props.nextStep()
        } else {
            this.showErrorMessages();
        }
    };

    showErrorMessages = () => {
        this.validator.showMessages();
        this.forceUpdate();
    };

    handleDateFormat = (input) => {
        const dateFormat = 'DD.MM.YYYY';
        let newDate = moment(input).format(dateFormat);
        console.log(newDate);
        this.props.handleFieldChange('date', newDate);
    };

    render() {
        const {values} = this.props;
        return (
            <Form className='booking-container'>
                <FormGroup>
                    <Row>
                        <Col md='12'>
                            <Label for='date'>Kuupäev*</Label>
                            <DatePicker className='custom-input-form' id='date' name='date' type='text'
                                        selected={values.date ? moment(values.date, 'DD.MM.YYYY').toDate() : null}
                                        onChange={this.handleDateFormat}
                                        dateFormat="dd.MM.YYYY"/>
                            <div className='validationMsg'>
                                {this.validator.message('date', values.date, 'required')}
                            </div>
                        </Col>
                    </Row>
                </FormGroup>
                <FormGroup>
                    <Label for='room'>Ruum*</Label>
                    <Input id='room' name='room' type='text'
                           placeholder='Valige room'
                           onChange={this.props.handleChange('room')}
                           defaultValue={values.room}
                    />
                    <div className='validationMsg'>
                        {this.validator.message('room', values.room, 'required')}
                    </div>
                </FormGroup>
                <FormGroup>
                    <Row>
                        <Col md='12'>
                            <Button className='next-button' onClick={this.saveAndContinue}>Next</Button>
                        </Col>
                    </Row>
                </FormGroup>
            </Form>
        );
    }
}

export default BookingRoomDate;