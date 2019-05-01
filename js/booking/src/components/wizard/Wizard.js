import * as React from "react";
import StepWizard from 'react-step-wizard';


class BookingWizard extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            data: null
        }
    }

    componentDidMount() {
        fetch('http://dummy.restapiexample.com/api/v1/employees')
            .then(response => response.json())
            .then(data => this.setState({data: data}
            ));
    }

    render() {
        return (
            <div>
                <table>
                    <tbody>
                    <tr>
                        <td>
                            Employee name
                        </td>
                        <td>
                            Employee age
                        </td>
                    </tr>
                    {this.state.data && this.state.data.map((record, i) =>
                        <tr key={i}>
                            <td>
                                {record.employee_name}
                            </td>
                            <td>
                                {record.employee_age}
                            </td>
                        </tr>
                    )}
                    </tbody>
                </table>
            </div>
        );
    }
}

export default BookingWizard;