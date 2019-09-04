import React from 'react';
import {Alert, Button, Col, Form, Row} from 'reactstrap';
import Table from "reactstrap/es/Table";

class BookingConfirmation extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            invoiceRows : []
        }
    }

    back = (e) => {
        e.preventDefault();
        this.props.prevStep();
    };

    componentDidMount() {
        const roomURL = 'http://localhost/noortek/wp-json/noortek-booking/v1/save';
        fetch(roomURL)
            .then(response => response.json())
            .then(response => {
                this.setState({invoiceRows: response});
            })
    }

    render() {
        {console.log(this.state.invoiceRows)}
        const {values} = this.props;
        return (
            <Form className='booking-container' onSubmit={this.props.handleSubmit}>
                <div className='step-content'>
                    <Row>
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
                                    <td>{values.selectedRoom.roomName}</td>
                                    <td>{values.timeFrom} - {values.timeUntil}</td>
                                    <td>{values.selectedRoom.roomPrice} EUR</td>
                                    <td>{values.selectedRoom.roomPrice} EUR</td>
                                </tr>

                                {(values.resourceList && values.resourceList.length > 0) ? values.resourceList.map((item,index)=>{
                                    return(
                                        <tr key={index}>
                                            <td>{item.equipmentName}</td>
                                            <td>{values.timeFrom}-{values.timeUntil}</td>
                                            <td>{item.equipmentPrice}EUR</td>
                                            <td>{item.equipmentPrice}EUR</td>
                                        </tr>
                                    )
                                }) : null}

                                </tbody>
                            </Table>
                        </Col>
                    </Row>

                    <Row>
                        <Col md='12'>
                            <Button className='previous-button' onClick={this.back}>Tagasi</Button>
                            <Button className='next-button' type='submit'>Esita broneering</Button>
                        </Col>
                    </Row>
                </div>

            </Form>
        );
    }
}

export default BookingConfirmation;