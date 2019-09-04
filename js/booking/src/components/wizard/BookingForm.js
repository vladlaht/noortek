import React from 'react';
import BookingRoomDate from './BookingRoomDate';
import BookingTimeResources from './BookingTimeResources';
import BookingGoal from './BookingGoal';
import BookingResponsible from './BookingResponsible';
import BookingRules from './BookingRules';
import BookingConfirmation from './BookingConfirmation';

class BookingForm extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            currentStep: 1,
            date: '',
            selectedRoom: '',
            timeFrom: '',
            timeUntil: '',
            resourceList: '',
            participants: '',
            purpose: '',
            info: '',
            firstName: '',
            lastName: '',
            phone: '',
            email: '',
            address: ''
        };
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    nextStep = () => {
        const {currentStep} = this.state;
        this.setState({
            currentStep: currentStep + 1
        })
    };

    prevStep = () => {
        const {currentStep} = this.state;
        this.setState({
            currentStep: currentStep - 1
        })
    };

    handleChange = (e) => {
        this.setState({
            [e.target.name] : e.target.value
        })
    };

    handleFieldChange = (input, value) => {
        this.setState({
            [input]: value
        })
    };

    handleSubmit(e) {
        e.preventDefault();
        const url = 'http://localhost/noortek/wp-json/noortek-booking/v1/save';
        const debuggerLink = '?XDEBUG_SESSION_START=PHPSTORM';
        console.log(this.state);
        fetch(url + debuggerLink, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
            date: this.state.date,
            room: this.state.selectedRoom.id,
            timeFrom: this.state.timeFrom,
            timeUntil: this.state.timeUntil,
            resources: this.state.resourceList.map((resource)=> resource.id),
            participants: this.state.participants,
            purpose: this.state.purpose,
            info: this.state.info,
            firstName: this.state.firstName,
            lastName: this.state.lastName,
            phone: this.state.phone,
            email: this.state.email,
            address: this.state.address
            })
        }).then(res => res.json())
            .then(data => console.log('post data:' + data))
            .catch(err => console.log(err))
    }

    render() {
        const {currentStep} = this.state;

        switch (currentStep) {
            case 1:
                return <BookingRoomDate
                    nextStep={this.nextStep}
                    handleChange={this.handleChange}
                    handleFieldChange={this.handleFieldChange}
                    values={this.state}
                />;
            case 2:
                return <BookingTimeResources
                    nextStep={this.nextStep}
                    prevStep={this.prevStep}
                    handleChange={this.handleChange}
                    handleFieldChange={this.handleFieldChange}
                    values={this.state}
                />;
            case 3:
                return <BookingGoal
                    nextStep={this.nextStep}
                    prevStep={this.prevStep}
                    handleChange={this.handleChange}
                    values={this.state}
                />;
            case 4:
                return <BookingResponsible
                    nextStep={this.nextStep}
                    prevStep={this.prevStep}
                    handleChange={this.handleChange}
                    values={this.state}
                />;
            case 5:
                return <BookingRules
                    nextStep={this.nextStep}
                    prevStep={this.prevStep}
                />;
            case 6:
                return <BookingConfirmation
                    prevStep={this.prevStep}
                    handleSubmit={this.handleSubmit}
                    values={this.state}
                />;
            default :
                return <BookingRoomDate
                    nextStep={this.nextStep}
                    handleChange={this.handleChange}
                    handleFieldChange={this.handleFieldChange}
                    values={this.state}
                />;
        }
    }
}

export default BookingForm;