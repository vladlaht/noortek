import React from 'react';
import {Button, Col, Form, Input, Label, Row} from 'reactstrap';
import FormGroup from "reactstrap/es/FormGroup";

class BookingRules extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            nextBtnDisabled: true
        }
    }

    saveAndContinue = (e) => {
        e.preventDefault();
        this.props.nextStep()
    };

    back = (e) => {
        e.preventDefault();
        this.props.prevStep();
    };

    enableButton = () => {
        this.setState({nextBtnDisabled: false});
    };

    render() {
        return (
            <Form className='booking-container'>
                <FormGroup>
                    <FormGroup>
                        <div><strong>RUUMINE KASUTAJA VASTUTUS:</strong></div>
                        <ul>
                            <li>
                                Rummi kasutaja vastutab materiaalselt ruumi heakorra ja sisustuse säilitamise
                                eest.
                            </li>
                            <li>
                                Ruumi üle andes palume vaadata, et kõik oleks korras (aknad kinni, tahvel puhas
                                jne.).
                            </li>
                        </ul>
                    </FormGroup>
                    <FormGroup>
                        <div><strong>KEELATUD:</strong></div>
                        <ul>
                            <li>
                                Suitsetada ja tarbida alkohoolseid jooke NNK sees ja NNK territooriumil
                            </li>
                            <li>
                                Reostada NNK sees ja territooriumil
                            </li>
                            <li>
                                Keelatud ropendada, teise sõimata või halvustada.
                            </li>
                            <li>
                                Keelatud tekitama ebamugavusi teiste kasutajate töö teostamiseks.
                            </li>
                        </ul>

                    </FormGroup>
                    <FormGroup>
                        Reeglite rikkumise korral Teie kaotate õiguse edaspidi NNK ruumi kasutada.
                    </FormGroup>
                    <FormGroup check>
                        <Label check>
                            <Input type="checkbox" name="rules" id='rules' onClick={this.enableButton}/>
                            Olen lugenud reegleid ja nõustun neid järgima.
                        </Label>
                    </FormGroup>
                    <FormGroup>
                        <Row>
                            <Col md='12'>
                                <Button className='previous-button' onClick={this.back}>Tagasi</Button>
                                <Button className='next-button' id='rulesButton' onClick={this.saveAndContinue}
                                    /*disabled={this.state.nextBtnDisabled}*/>Edasi</Button>
                            </Col>
                        </Row>
                    </FormGroup>
                </FormGroup>
            </Form>
        );
    }
}

export default BookingRules;