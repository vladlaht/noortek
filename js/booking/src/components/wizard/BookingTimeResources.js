import React from 'react';
import {
    Button, Col, Form, FormGroup, Input, Label, Row
} from 'reactstrap';
import SimpleReactValidator from "simple-react-validator";
import InputMask from 'react-input-mask';

class BookingTimeResources extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            resources: [],
            selectedResourcesList: []
        };

        this.validator = new SimpleReactValidator({
            validators: {
                time: {
                    message: 'Palun sisestage valiidne aeg',
                    rule: (val, params, validator) => {
                        return validator.helpers.testRegex(val, /^(0[0-9]|1[0-9]|2[0-3]|[0-9]):[0-5][0-9]$/i)
                    }
                }
            },
            messages: {
                required: 'See väli on kohustuslik',
            }
        });
        this.handleSelectedResources = this.handleSelectedResources.bind(this);
    }

    componentDidMount() {
        let roomURL = 'http://localhost/noortek/wp-json/noortek-booking/v1/resources';
        fetch(roomURL)
            .then(response => response.json())
            .then(response => {
                this.setState({resources: response});
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

    back = (e) => {
        e.preventDefault();
        this.props.prevStep();
    };

    handleSelectedResources(e) {

        const value = e.target.value;
        const isChecked = e.target.checked;

        if (isChecked) {
            let clickedResource = this.state.resources && this.state.resources.filter(resource => resource.id == value);
            if (clickedResource && clickedResource.length > 0) {
                clickedResource = clickedResource[0];
                let list = [...this.state.selectedResourcesList, clickedResource];
                this.setState({
                    selectedResourcesList: list
                });
                this.props.handleFieldChange('resourceList', list);
            }
        } else {
            let list = this.state.selectedResourcesList && this.state.selectedResourcesList.filter(resource => resource.id != value);
            this.setState({
                selectedResourcesList: list
            });
            this.props.handleFieldChange('resourceList', list);
        }


    }

    render() {
        const {values} = this.props;
        return (
            <Form className='booking-container'>
                <FormGroup>
                    <Row>
                        <Col md='3'>
                            <Label for='timeFrom'>Aeg alates*</Label>
                            <InputMask className='custom-input-form' mask="99:99" maskChar={null}
                                       placeholder='12:00' id='timeFrom' name='timeFrom'
                                       onChange={this.props.handleChange('timeFrom')}
                                       value={values.timeFrom}
                            />
                            {/*<div className='validationMsg'>
                                {this.validator.message('timeFrom', values.timeFrom, 'required|time')}
                            </div>*/}
                        </Col>
                        <Col md='3'>
                            <Label for='timeUntil'>Aeg kuni*</Label>
                            <InputMask className='custom-input-form' mask="99:99" maskChar={null}
                                       placeholder='13:00' id='timeUntil' name='timeUntil'
                                       onChange={this.props.handleChange('timeUntil')}
                                       value={values.timeUntil}
                            />
                            {/* <div className='validationMsg'>
                                {this.validator.message('timeUntil', values.timeUntil, 'required|time')}
                            </div>*/}
                        </Col>
                    </Row>
                </FormGroup>
                <FormGroup>
                    <Label>Vajalikud lisavahendid:</Label>
                    {this.state.resources && this.state.resources.map((resource, index) => {
                        return (
                            <FormGroup key={index} check>
                                <Label check>
                                    <Input type="checkbox" id='resources' name='resources'
                                           onChange={this.handleSelectedResources}
                                           value={resource.id}/>{' '}
                                    {resource.equipmentName} {resource.equipmentPrice} EUR / tund
                                </Label>
                            </FormGroup>
                        )
                    })}


                </FormGroup>
                <FormGroup>
                    <Row>
                        <Col md='12'>
                            <Button className='previous-button' onClick={this.back}>Tagasi</Button>
                            <Button className='next-button' onClick={this.saveAndContinue}>Edasi</Button>
                        </Col>
                    </Row>
                </FormGroup>
            </Form>
        )
            ;
    }
}

export default BookingTimeResources;