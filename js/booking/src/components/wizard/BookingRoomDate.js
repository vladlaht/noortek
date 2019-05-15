import React from 'react';
import {Container, Button, Col, Row} from 'reactstrap';
import datepicker from './BookingDatePicker';

class BookingRoomDate extends React.Component {

    saveAndContinue = (e) => {
        e.preventDefault();
        this.props.nextStep()
    };

    render() {
        const {values} = this.props;
        return (
            <Container className='booking-container'>
                <Row>
                    <Col lg='4'>
                        <label>Kuupäev*</label>
                        <input className='form-control' id='date' name='date' type='text'
                               placeholder='Valige kuupaev'
                               onChange={this.props.handleChange('date')}
                               defaultValue={values.date}
                        />
                    </Col>
                    <Col lg='12'>
                        <label>Ruum*</label>
                        <input className='form-control' id='room' name='room' type='text'
                               placeholder='Valige room'
                               onChange={this.props.handleChange('room')}
                               defaultValue={values.lastName}
                        />
                    </Col>

                    <Col lg='12'>
                        <Button className='next-button' onClick={this.saveAndContinue}>Next</Button>
                    </Col>
                </Row>
            </Container>
        );
    }
}

export default BookingRoomDate;