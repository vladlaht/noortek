import React from 'react';
import {Button, Col, Container, Row} from 'reactstrap';


class BookingResponsible extends React.Component {
    saveAndContinue = (e) => {
        e.preventDefault()
        this.props.nextStep()
    }

    back = (e) => {
        e.preventDefault();
        this.props.prevStep();
    };

    render() {
        const {values} = this.props;
        return (
            <Container>
                <Row>
                    <Col lg='6'>
                        <label>Vastutava isiku andmed</label>
                    </Col>
                </Row>
                <Row>
                    <Col lg='6'>
                        <label>Eesnimi*</label>
                        <input className='form-control' id='firstname' name='firstname' type='text'
                               onChange={this.props.handleChange('firstName')}
                               defaultValue={values.firstName}

                        />
                    </Col>
                    <Col lg='6'>
                        <label>Perekonnanimi*</label>
                        <input className='form-control' id='lastname' name='lastname' type='text'
                               onChange={this.props.handleChange}
                               defaultValue={values.lastName}
                        />
                    </Col>
                </Row>
                <Row>
                    <Col lg='6'>
                        <label>Telefoninumber*</label>
                        <input className='form-control' id='phone' name='phone' type='number'
                               onChange={this.props.handleChange}
                               defaultValue={values.phone}

                        />
                    </Col>
                    <Col lg='6'>
                        <label>Email*</label>
                        <input className='form-control' id='email' name='email' type='email'
                               onChange={this.props.handleChange}
                               defaultValue={values.email}
                        />
                    </Col>
                </Row>
                <Row>
                    <Col lg='6'>
                        <label>Aadress*</label>
                        <input className='form-control' id='address' name='address' type='text'
                               placeholder='Linn,tänav,maja number'
                               onChange={this.props.handleChange}
                               defaultValue={values.address}
                        />
                    </Col>
                </Row>
                <Row>
                    <Col lg='12'>
                        <Button className='previous-button' onClick={this.back}>Previous</Button>
                        <Button className='next-button' onClick={this.saveAndContinue}>Next</Button>

                    </Col>
                </Row>
            </Container>
        );

    }
}

export default BookingResponsible;
