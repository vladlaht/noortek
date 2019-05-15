import React from 'react';
import {Button, Col, Container, Row} from 'reactstrap';

class BookingGoal extends React.Component {
    saveAndContinue = (e) => {
        e.preventDefault()
        this.props.nextStep()
    }

    back = (e) => {
        e.preventDefault();
        this.props.prevStep();
    }

    render() {
        const {values} = this.props;
        return (
            <Container>
                <Row>
                    <Col>
                        <label>Osalejate arv*</label>
                        <input className='form-control' id='participants' name='participants' type='number'
                               placeholder='Enter your goal'
                               onChange={this.props.handleChange}
                               defaultValue={values.participants}

                        />
                    </Col>
                    <Col>
                        <label>Eesmärk*</label>
                        <input className='form-control' id='purpose' name='purpose' type='text'
                               placeholder='Enter your goal'
                               onChange={this.props.handleChange}
                               defaultValue={values.purpose}
                        />
                    </Col>
                    <Col>
                        <label>Lisainfo</label>
                        <textarea className='form-control' id='info' name='info' type='text'
                                  placeholder='Kui teil on soovi midagi lisada, siis kirjutage siia'
                                  onChange={this.props.handleChange}
                                  defaultValue={values.info}
                        />
                    </Col>
                </Row>
                <Row>
                    <Col>
                        <Button className='previous-button' onClick={this.back}>Previous</Button>
                        <Button className='next-button' onClick={this.saveAndContinue}>Next</Button>

                    </Col>
                </Row>
            </Container>


        );
    }
}

export default BookingGoal;