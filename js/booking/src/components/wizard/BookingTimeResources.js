import React from 'react';
import {Button, Col, Container, Row} from 'reactstrap';

class BookingTimeResources extends React.Component {
    saveAndContinue = (e) => {
        e.preventDefault();
        this.props.nextStep()
    };

    back = (e) => {
        e.preventDefault();
        this.props.prevStep();
    };

    render() {
        const {values} = this.props;
        return (
            <Container className='booking-container'>
                <Row>
                    <Col lg='3'>
                        <label>Aeg alates*</label>
                        <input className='form-control' id='timeFrom' name='timeFrom' type='text'
                               placeholder='Aeg alates'
                               onChange={this.props.handleChange('timeFrom')}
                               defaultValue={values.timeFrom}
                        />
                    </Col>
                    <Col lg='3'>
                        <label>Aeg kuni*</label>
                        <input className='form-control' id='timeUntil' name='timeUntil' type='text'
                               placeholder='Aeg kuni'
                               onChange={this.props.handleChange('timeUntil')}
                               defaultValue={values.timeUntil}
                        />
                    </Col>
                </Row>
                <Row>
                    <Col lg='12'>
                        <label>Vajalikud vahendid:</label>
                        <div className='form-check'>
                            <input type='checkbox' className='form-check-input' id='resources1'/>
                            <label className='form-check-label' style={{ marginLeft: 8 }}>Kõlarid 6 EUR / tund </label>
                        </div>
                        <div className='form-check'>
                            <input type='checkbox' className='form-check-input' id='resources2'/>
                            <label className='form-check-label' style={{ marginLeft: 8 }}>Sülearvuti 7 EUR / tund </label>
                        </div>
                        <div className='form-check'>
                            <input type='checkbox' className='form-check-input' id='resources3'/>
                            <label className='form-check-label' style={{ marginLeft: 8 }}>Projektor 5 EUR / tund </label>
                        </div>
                    </Col>
                </Row>
                <Row>
                    <Col lg='12'>
                        <Button className='previous-button' onClick={this.back}>Previous</Button>
                        <Button className='next-button' onClick={this.saveAndContinue}>Next</Button>
                    </Col>
                </Row>
                <Row>
                    <Col>

                    </Col>
                </Row>
            </Container>
        )
            ;
    }
}

export default BookingTimeResources;