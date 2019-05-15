import React from 'react';
import {Button, Col, Container, Row} from 'reactstrap';

class BookingRules extends React.Component {

    saveAndContinue = (e) => {
        e.preventDefault();
        this.props.nextStep()
    };

    back = (e) => {
        e.preventDefault();
        this.props.prevStep();
    };

    render() {
        return (
            <Container>
                <Row>
                    <Col>
                        <div className='form-group'>
                            <div>
                                <span>Ruumide kasutaja vastutus: </span>
                            </div>
                            <ul>
                                <li>Rummi kasutaja vastutab materiaalselt ruumi heakorra ja sisustuse säilitamise
                                    eest.
                                </li>
                                <li>Ruumi üle andes palume vaadata, et kõik oleks korras (aknad kinni, tahvel puhas
                                    jne.).
                                </li>
                            </ul>
                            <div>
                            <span>
                                <strong>KEELATUD:</strong>
                            </span>
                            </div>
                            <div>
                                1. Suitsetada ja tarbida alkohoolseid jooke NNK sees ja NNK territooriumil
                            </div>
                            <div>
                                2. Reostada NNK sees ja territooriumil
                            </div>
                            <div></div>
                            <div>
                                3. Keelatud ropendada, teise sõimata või halvustada.
                            </div>
                            <div>
                                4. Keelatud tekitama ebamugavusi teiste kasutajate töö teostamiseks.
                            </div>
                            Reeglite rikkumise korral Teie kaotate õiguse edaspidi NNK ruumi kasutada.
                        </div>

                        <div className="form-group form-check">
                            <input className="form-check-input" type="checkbox" id="rules_checkbox"
                                   name="rules" required/>
                            <label className="form-check-label" htmlFor="rules_checkbox">
                                Olen lugenud reegleid ja nõustun neid järgima.
                            </label>
                        </div>

                        <Row>
                            <Col lg='12'>
                                <Button className='previous-button' onClick={this.back}>Previous</Button>
                                <Button className='next-button' onClick={this.saveAndContinue}>Next</Button>

                            </Col>
                        </Row>
                    </Col>
                </Row>
            </Container>
        );
    }
}

export default BookingRules;