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

    handleChange = input => event => {
        this.setState({
            [input]: event.target.value
        })
    };

    handleFieldChange = (input, value) => {
        this.setState({
            [input]: value
        })
    };

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