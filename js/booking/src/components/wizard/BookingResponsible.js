import React from 'react';
import {Button, Col, Form, Input, Label, Row} from 'reactstrap';
import FormGroup from "reactstrap/es/FormGroup";
import SimpleReactValidator from "simple-react-validator";
import InputMask from 'react-input-mask';


class BookingResponsible extends React.Component {
    constructor(props) {
        super(props);
        this.validator = new SimpleReactValidator({
            messages: {
                required: 'See väli on kohustuslik',
                time: 'Palun sisestage korrektne aeg',
                email: 'Palun sisestage valiidne email',
                alpha: 'See väli võib sisaldama ainult tähti'
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
                        <Col md='6'>
                            <Label for='firstname'>Eesnimi*</Label>
                            <Input id='firstname' name='firstName' type='text'
                                   onChange={this.props.handleChange}
                                   defaultValue={values.firstName}
                            />
                           {/* <div className='validationMsg'>
                                {this.validator.message('firstname', values.firstName, 'required|alpha')}
                            </div>*/}
                        </Col>
                        <Col md='6'>
                            <Label for='lastname'>Perekonnanimi*</Label>
                            <Input id='lastname' name='lastName' type='text'
                                   onChange={this.props.handleChange}
                                   defaultValue={values.lastName}
                            />
                           {/* <div className='validationMsg'>
                                {this.validator.message('lastname', values.lastName, 'required|alpha')}
                            </div>*/}
                        </Col>
                    </Row>
                </FormGroup>
                <FormGroup>
                    <Row>
                        <Col md='6'>
                            <Label for='phone'>Telefoninumber*</Label>
                            <InputMask className='custom-input-form' mask="+372 99 999 99 99" maskChar={null}
                                       placeholder='+372' id='phone' name='phone'
                                       onChange={this.props.handleChange}
                                       defaultValue={values.phone}
                            />
                           {/* <div className='validationMsg'>
                                {this.validator.message('phone', values.phone, 'required')}
                            </div>*/}
                        </Col>
                        <Col md='6'>
                            <Label for='email'>Email*</Label>
                            <Input id='email' name='email' type='email'
                                   onChange={this.props.handleChange}
                                   defaultValue={values.email}
                            />
                          {/*  <div className='validationMsg'>
                                {this.validator.message('email', values.email, 'required|email')}
                            </div>*/}
                        </Col>
                    </Row>
                </FormGroup>
                <FormGroup>
                    <Row>
                        <Col md='6'>
                            <Label for='address'>Aadress*</Label>
                            <Input id='address' name='address' type='text'
                                   placeholder='Linn,tänav,maja number'
                                   onChange={this.props.handleChange}
                                   defaultValue={values.address}
                            />
                          {/*  <div className='validationMsg'>
                                {this.validator.message('participants', values.participants, 'required|numeric')}
                            </div>*/}
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

export default BookingResponsible;
