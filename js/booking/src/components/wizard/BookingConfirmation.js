import React from 'react';
import {Button, Col, Container, Row} from 'reactstrap';

class BookingConfirmation extends React.Component {
    saveAndContinue = (e) => {
        e.preventDefault();
        this.props.nextStep()
    };

    back = (e) => {
        e.preventDefault();
        this.props.prevStep();
    };

    render() {
        const {values: { date, room, timeFrom, timeUntil, resources, participants, purpose, info, firstName, lastName, phone, email, address }} = this.props;

        return (
            <Container>
                <label>{firstName}</label>
            </Container>
        );
    }
}

export default BookingConfirmation;