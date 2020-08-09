import React from "react";
import {
    Route,
    Redirect
} from "react-router-dom";
import auth from "./auth";

export const AuthenticatedRoute = ({ children, ...rest }) => {
    return (
        <Route
            {...rest}
            render={({ location }) =>
                auth.isAuthenticated() ? (
                    children
                ) : (
                    <Redirect
                        to={{
                            pathname: "/login",
                            state: { from: location }
                        }}
                    />
                )
            }
        />
    );
};
