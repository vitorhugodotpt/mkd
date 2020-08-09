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


function App() {
    return (
        <Router>
            <div>
                <Switch>
                    <Route exact path="/">
                        <Home />
                    </Route>
                    <Route path="/login">
                        <Login />
                    </Route>
                    <AuthenticatedRoute path="/dashboard">
                        <Dashboard />
                    </AuthenticatedRoute>
                    <Route path="/:hash">
                        <Quiz />
                    </Route>
                </Switch>
            </div>
        </Router>
    );
}


ReactDOM.render(
    <App />,
    document.getElementById('root')
);
