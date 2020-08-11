import React from 'react';
import auth from "../auth";
import axios from "axios";

class Dashboard extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            isFetching: true,
            error: false,
            dashboard: []
        };

        if(auth.isAuthenticated() === null) {
            this.props.history.push("/login");
        }
    }

    async componentDidMount() {
        const response = await axios.get('api/dashboard', {headers: {'Authorization': `Bearer ${auth.getToken()}`}});
        if(response.data.success) {
            this.setState({
                isFetching: false,
                dashboard: response.data.dashboard
            });
        }else {
            this.setState({
                isFetching: false,
                error: true
            });
        }
    }
    render() {
        return (
            <div>
                <h2>Dashboard</h2>
                <p>token: {auth.getToken()}</p>
                <button
                    onClick={() => {
                        auth.logout(() => {
                            this.props.history.push("/login");
                        });
                    }}
                >
                    Logout
                </button>
            </div>
        );
    }
}
export default Dashboard;
