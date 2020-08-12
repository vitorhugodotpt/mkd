import React from 'react';
import auth from "../auth";
import axios from "axios";
import Table from "../components/table";

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
        if(!this.state.isFetching) {


            return (
                <div>
                    <div className="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded shadow-sm">
                        <div className="lh-100 d-flex justify-content-between align-items-center w-100">
                            <h6 className="mb-0 text-white lh-100">Dashboard</h6>
                            <button
                                className="logout rounded"
                                onClick={() => {
                                    auth.logout(() => {
                                        this.props.history.push("/login");
                                    });
                                }}
                            >
                                Logout
                            </button>
                        </div>
                    </div>

                    <h2>Average</h2>

                    <Table title="All Questions" rows={this.state.dashboard.average}/>


                    {
                        this.state.dashboard.average_clients.map((row) =>
                            <Table title={row.title} rows={row.data}/>
                        )
                    }

                    <h2>Free text questions</h2>

                    {
                        this.state.dashboard.free_text.map((row) =>
                            <Table title={row.title} rows={row.data}/>
                        )
                    }

                    <h2>Projects ({this.state.dashboard.total_projects})</h2>
                    {
                        this.state.dashboard.projects.map((row) =>
                            <Table title={row.title} rows={row.data}/>
                        )
                    }

                </div>
            );
        }

        return(
          <div>

          </div>
        );
    }
}
export default Dashboard;
