import React from 'react';
import {Alert, Button, Col, Form, Row} from 'reactstrap';
import Table from "reactstrap/es/Table";

class BookingConfirmation extends React.Component {

    back = (e) => {
        e.preventDefault();
        this.props.prevStep();
    };

    render() {
        const {values} = this.props;
        return (
            <Form className='booking-container'>
                <div className='step-content'>
                    <Row >
                        <Col md='12'>
                            <h3><strong>Ülevaade</strong></h3>
                            <Alert color="warning" fade={false}>
                                Palun, kontrollige et teie sisestatud andmed on õiged.
                            </Alert>
                        </Col>
                    </Row>
                    <Row>
                        <Col md='2' sm='4'>
                            <strong>Broneerija:</strong>
                        </Col>
                        <Col md='10' sm='8'>
                            <div>{values.firstName} {values.lastName}</div>
                            <div>+372 {values.phone}</div>
                            <div>{values.email}</div>
                            <div>{values.address}</div>
                            <div></div>
                        </Col>
                    </Row>
                    <Row>
                        <Col md='12'>
                            <div>
                                <p><strong>Kuupäev: </strong> {values.date}</p>
                            </div>
                            <div>
                                <p><strong>Eesmärk: </strong> {values.purpose}</p>
                            </div>
                            <div>
                                <p><strong>Osalejate arv: </strong> {values.participants} inimest</p>
                            </div>
                            <div>
                                <p><strong>Lisainfo: </strong> {values.info}</p>
                            </div>
                        </Col>
                    </Row>
                    <Row>
                        <Col>
                            <Table>
                                <thead>
                                <tr>
                                    <th>Nimetus</th>
                                    <th>Kestvus</th>
                                    <th>Tunnihind</th>
                                    <th>Summa</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{values.room}</td>
                                    <td>{values.timeFrom} - {values.timeUntil}</td>
                                    <td>15 EUR</td>
                                    <td>30 EUR</td>
                                </tr>
                                </tbody>
                            </Table>
                        </Col>
                    </Row>

                    <Row>
                        <Col md='12'>
                            <Button className='previous-button' onClick={this.back}>Tagasi</Button>
                            <Button className='next-button' >Esita broneering</Button>
                        </Col>
                    </Row>
                </div>

            </Form>
        );
    }
}

export default BookingConfirmation;