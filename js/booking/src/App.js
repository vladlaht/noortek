import React from 'react';
import './App.css';
import BookingWizard from "./components/wizard/Wizard";
import SearchComponent from "./components/wizard/SearchComponent";


function App() {
    return (
        <div className="Wizard">
            <SearchComponent/>
            {/*<BookingWizard/>*/}

        </div>

    );
}

export default App;
