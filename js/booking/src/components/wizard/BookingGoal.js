import React from 'react';
import {Button, Col, Form, FormGroup, Input, Label, Row} from 'reactstrap';
import SimpleReactValidator from "simple-react-validator";

class BookingGoal extends React.Component {
    constructor(props) {
        super(props);
        this.validator = new SimpleReactValidator({
            validators: {
                maxParticipants: {
                    message: 'Ruumis võib olla maksimaalselt 35 inimest',
                    rule: (val, params, validator) => {

                        return validator.helpers.testRegex(val, /^([0-9]|[12][0-9]|3[0-5])$/i)
                    }
                }
            },
            messages: {
                required: 'See väli on kohustuslik',
                numeric: 'Palun sisestage ainult numbrid'
            },
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
                        <Col md='12'>
                            <Label for='participants'>Osalejate arv*</Label>
                            <Input id='participants' name='participants' type='text'
                                   placeholder='Maksimum 30 inimest'
                                   onChange={this.props.handleChange('participants')}
                                   defaultValue={values.participants}
                            />
                            <div className='validationMsg'>
                                {this.validator.message('participants', values.participants, 'maxParticipants|numeric|required')}
                            </div>
                        </Col>
                    </Row>
                </FormGroup>
                <FormGroup>
                    <Row>
                        <Col md='12'>
                            <Label for='purpose'>Eesmärk*</Label>
                            <Input id='purpose' name='purpose' type='text'
                                   placeholder='Kirjutage lühidalt ruumi kasutamise eesmärki'
                                   onChange={this.props.handleChange('purpose')}
                                   defaultValue={values.purpose}
                            />
                            <div className='validationMsg'>
                                {this.validator.message('purpose', values.purpose, 'required|max:10,string')}
                            </div>
                        </Col>
                    </Row>
                </FormGroup>
                <FormGroup>
                    <Row>
                        <Col md='12'>
                            <Label for='info'>Lisainfo</Label>
                            <Input id='info' name='info' type='textarea'
                                   placeholder='Kui teil on soovi midagi lisada, siis kirjutage siia'
                                   onChange={this.props.handleChange('info')}
                                   defaultValue={values.info}
                            />
                        </Col>
                    </Row>
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


        );
    }
}

export default BookingGoal;