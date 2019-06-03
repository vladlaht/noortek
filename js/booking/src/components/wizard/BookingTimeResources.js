import React from 'react';
import {Button, Col, Form, FormGroup, Input, Label, Row} from 'reactstrap';
import SimpleReactValidator from "simple-react-validator";
import InputMask from 'react-input-mask';

class BookingTimeResources extends React.Component {
    constructor(props) {
        super(props);
        this.validator = new SimpleReactValidator({
            validators: {
                time: {
                    message: 'Palun sisestage valiidne aeg',
                    rule: (val, params, validator) => {
                        return validator.helpers.testRegex(val, /^(0[0-9]|1[0-9]|2[0-3]|[0-9]):[0-5][0-9]$/i)
                    }
                }
            },
            messages: {
                required: 'See väli on kohustuslik',
            }
        });
    }

    saveAndContinue = (e) => {
        e.preventDefault();
        if (this.validator.allValid()) {
            this.props.nextStep()
        } else {
            this.validator.showMessages();
            this.forceUpdate();
        }
    };

    back = (e) => {
        e.preventDefault();
        this.props.prevStep();
    };

    render() {
        const {values} = this.props;
        return (
            <Form className='booking-container'>
                <FormGroup>
                    <Row>
                        <Col md='3'>
                            <Label for='timeFrom'>Aeg alates*</Label>

                            <InputMask className='custom-input-form' mask="99:99" maskChar={null}
                                       placeholder='12:00' id='timeFrom' name='timeFrom'
                                       onChange={this.props.handleChange('timeFrom')}
                                       defaultValue={values.timeFrom}
                            />

                            <div className='validationMsg'>
                                {this.validator.message('timeFrom', values.timeFrom, 'required|time')}
                            </div>
                        </Col>
                        <Col md='3'>
                            <Label for='timeUntil'>Aeg kuni*</Label>
                            <InputMask className='custom-input-form' mask="99:99" maskChar={null}
                                       placeholder='13:00' id='timeUntil' name='timeUntil'
                                       onChange={this.props.handleChange('timeUntil')}
                                       defaultValue={values.timeUntil}
                            />
                            <div className='validationMsg'>
                                {this.validator.message('timeUntil', values.timeUntil, 'required|time')}
                            </div>
                        </Col>
                    </Row>
                </FormGroup>
                <FormGroup>
                    <Label>Vajalikud lisavahendid:</Label>
                    <FormGroup check>
                        <Label check>
                            <Input type="checkbox" id='resources1' onChange={this.props.handleChange('resources')}
                                   defaultValue={values.resources}/>{' '}
                            Kõlarid 6 EUR / tund
                        </Label>
                    </FormGroup>
                    <FormGroup check>
                        <Label check>
                            <Input type="checkbox" id='resources2' onChange={this.props.handleChange('resources')}
                                   defaultValue={values.resources}/>{' '}
                            Sülearvuti 7 EUR / tund
                        </Label>
                    </FormGroup>
                    <FormGroup check>
                        <Label check>
                            <Input type="checkbox" id='resources3' onChange={this.props.handleChange('resources')}
                                   defaultValue={values.resources}/>{' '}
                            Projektor 5 EUR / tund
                        </Label>
                    </FormGroup>
                </FormGroup>
                <FormGroup>
                    <Row>
                        <Col md='12'>
                            <Button className='previous-button' onClick={this.back}>Tagasi</Button>
                            <Button className='next-button' onClick={this.saveAndContinue}>Edasi</Button>
                        </Col>
                    </Row>
                </FormGroup>
            </Form>
        )
            ;
    }
}

export default BookingTimeResources;