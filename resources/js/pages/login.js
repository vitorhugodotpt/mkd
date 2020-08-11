import React from 'react';
import axios from 'axios';
import auth from "../auth";
import {
    useHistory,
    useLocation
} from "react-router-dom";

class Login extends React.Component {

    constructor(props){
        super(props);
        this.state = {
            email:null,
            password:null,
        };

        this.handleInputChange = this.handleInputChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    handleInputChange(event) {
        const target = event.target;
        let value = target.value;
        const name = target.name;

        this.setState({
            [name]: value
        });
    }

    handleSubmit(event) {
        event.preventDefault();

        axios.post('/api/login', this.state)
            .then(
                response => {
                    if(response.data.success) {
                        auth.login(response.data.token, () => {
                            this.props.history.push("/dashboard");
                        })
                    }else {
                        console.log('error')
                    }
                }
            );
    }

    render(){
        return (
            <div>
                <h2>Login</h2>
                <form onSubmit={this.handleSubmit}>
                    <div className="form-row">
                        <div className="form-group">
                            <label>Email:</label>
                            <input type="text" className="form-control" name="email"
                                   onChange={this.handleInputChange}/>
                        </div>
                    </div>
                    <div className="form-row">
                        <div className="form-group">
                            <label>Password:</label>
                            <input type="password" className="form-control" name="password"
                                   onChange={this.handleInputChange}/>
                        </div>
                    </div>
                    <div className="form-row">
                        <div className="form-group">
                            <input type="submit" value="Submit" />
                        </div>
                    </div>
                </form>
            </div>
        );
    }
}


export default Login;
