import React from 'react';
import ReactDOM from "react-dom";
import {
    BrowserRouter as Router,
    Switch,
    Route
} from "react-router-dom";

import {AuthenticatedRoute} from "./autenticated.route";
import Home from "./pages/home";
import Login from "./pages/login";
import Quiz from "./pages/quiz";
import Dashboard from "./pages/dashboard";
import ThankYou from "./pages/thank_you";
import Error from "./pages/error";


class App extends React.Component {
    render() {
        return (
            <Router>
                <div>
                    <Switch>
                        <Route exact path="/" component={Home} />
                        <Route exact path="/thank-you" component={ThankYou} />
                        <Route exact path="/error" component={Error} />
                        <Route path="/login" component={Login} />
                        <AuthenticatedRoute path="/dashboard" component={Dashboard} />
                        <Route path="/:hash" component={Quiz} />
                    </Switch>
                </div>
            </Router>
        );
    }
}


ReactDOM.render(
    <App />,
    document.getElementById('root')
);
