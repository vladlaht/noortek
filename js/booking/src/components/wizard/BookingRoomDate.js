import React from 'react';
import {
    Button, Col, Row, Form, FormGroup, Card, CardText, CardImg, CardBody, CardTitle
} from 'reactstrap';
import 'react-datepicker/dist/react-datepicker.css';
import DatePicker from 'react-datepicker';
import moment from 'moment';

import SimpleReactValidator from 'simple-react-validator';


class BookingRoomDate extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            rooms: ''
        };

        this.validator = new SimpleReactValidator({
            validators: {
                randomValidator: {
                    message: 'Where is email?',
                    rule: (val, params, validator) => {
                        return validator.helpers.testRegex(val, /^[A-Z0-9.!#$%&'*+-/=?^_`{|}~]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i)
                    }
                }
            },
            messages: {
                required: 'See väli on kohustuslik',
                date: 'Palun sisestage valiidne kuupäev'
            }
        });
        this.handleRoomChange = this.handleRoomChange.bind(this);
    }

    componentDidMount() {
        const roomURL = 'http://localhost/noortek/wp-json/noortek-booking/v1/rooms';
        fetch(roomURL)
            .then(response => response.json())
            .then(response => {
                this.setState({rooms: response});
            })
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

    handleDateFormat = (input) => {
        const dateFormat = 'DD.MM.YYYY';
        let newDate = moment(input).format(dateFormat);
        this.props.handleFieldChange('date', newDate);
    };

    handleRoomChange(e) {
        const matchRoom = this.state.rooms.filter(room => room.id == e.target.value);
        this.props.handleFieldChange('selectedRoom', matchRoom[0])
    }

    render() {
        const {values} = this.props;
        return (

            <Form className='booking-container'>
                <FormGroup>
                    <Row>
                        <Col md='12'>
                            <label htmlFor='date'>Kuupäev*</label>
                            <DatePicker className='custom-input-form' id='date' name='date' type='text'
                                        selected={values.date ? moment(values.date, 'DD.MM.YYYY').toDate() : null}
                                        onChange={this.handleDateFormat}
                                        dateFormat='dd.MM.YYYY'/>
                            {/*<div className='validationMsg'>
                                {this.validator.message('date', values.date, 'required')}
                            </div>*/}
                        </Col>
                    </Row>
                </FormGroup>
                <FormGroup>
                    <Row>
                        <Col md='12'>
                            <label htmlFor='room'>Ruum*</label>
                        </Col>
                        {this.state.rooms && this.state.rooms.map((room, index) => {
                            return (
                                <Col md='4' key={index}>
                                    <Card className='card-content'>
                                        <CardImg className='card-img' top width='100%' src={room.roomImg} alt='img'/>
                                        <CardBody className='card-text'>
                                            <CardTitle>
                                                <h4>{room.roomName}</h4>
                                            </CardTitle>
                                            <CardText className='card-price'>
                                                <strong>Hind: </strong> {room.roomPrice} EUR / tund
                                            </CardText>
                                            <div className="room-selection">
                                                <label className="btn btn-secondary">
                                                    <input type='radio' name='room'
                                                           id='room'
                                                           autoComplete='off'
                                                           onChange={this.handleRoomChange}
                                                           value={room.id}/> Valin
                                                </label>
                                            </div>
                                            {/*<div className='validationMsg'>
                                                {this.validator.message('room', values.selectedRoom, 'required')}
                                            </div>*/}
                                        </CardBody>
                                    </Card>
                                </Col>
                            )
                        })}
                    </Row>
                    <div>
                        Selected room: {values.selectedRoom.roomName} {values.selectedRoom.id}
                    </div>
                </FormGroup>
                <FormGroup className='booking-form-buttons'>
                    <Row>
                        <Col md='12'>
                            <Button className='next-button' onClick={this.saveAndContinue}>Edasi</Button>
                        </Col>
                    </Row>
                </FormGroup>
            </Form>
        );
    }
}

export default BookingRoomDate;