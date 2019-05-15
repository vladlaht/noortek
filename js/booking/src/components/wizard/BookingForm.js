import React from 'react';
import BookingRoomDate from './BookingRoomDate';
import BookingTimeResources from './BookingTimeResources';
import BookingGoal from './BookingGoal';

import BookingResponsible from './BookingResponsible';
import BookingRules from './BookingRules';
import BookingConfirmation from './BookingConfirmation';

class BookingForm extends React.Component {
    constructor(props) {
        super(props)
        this.state = {
            currentStep: 1,
            date: '',
            room: '',
            timeFrom: '',
            timeUntil: '',
            resources: '',
            participants: '',
            purpose: '',
            info: '',
            firstName: '',
            lastName: '',
            phone: '',
            email: '',
            address: '',
        }
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
        this.setState({ [input] : event.target.value })
    }

    render() {
        const {currentStep} = this.state;
        const {date, room, timeFrom, timeUntil, resources, participants, purpose, info, firstName, lastName, phone, email, address} = this.state;
        const values = {
            date,
            room,
            timeFrom,
            timeUntil,
            resources,
            participants,
            purpose,
            info,
            firstName,
            lastName,
            phone,
            email,
            address
        };

        switch (currentStep) {
            case 1:
                return <BookingRoomDate
                    nextStep={this.nextStep}
                    handleChange={this.handleChange}
                    values={values}
                />;
            case 2:
                return <BookingTimeResources
                    nextStep={this.nextStep}
                    prevStep={this.prevStep}
                    handleChange={this.handleChange}
                    values={values}
                />;
            case 3:
                 return <BookingGoal
                     nextStep={this.nextStep}
                     prevStep={this.prevStep}
                     handleChange={this.handleChange}
                     values={values}
                 />;
             case 4:
                 return <BookingResponsible
                     nextStep={this.nextStep}
                     prevStep={this.prevStep}
                     handleChange={this.handleChange}
                     values={values}
                 />;
             case 5:
                 return <BookingRules
                     nextStep={this.nextStep}
                     prevStep={this.prevStep}
                 />;
             case 6:
                 return <BookingConfirmation
                     prevStep={this.prevStep}
                     values={values}
                 />
        }
    }
}

export default BookingForm;