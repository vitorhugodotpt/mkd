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
                <form class="form-signin" onSubmit={this.handleSubmit}>
                    <div className="text-center mb-4">
                            <h1 className="h3 mb-3 font-weight-normal">Login</h1>
                    </div>

                    <div className="form-label-group">
                        <input type="text" className="form-control" name="email"
                               onChange={this.handleInputChange}/>
                            <label htmlFor="inputEmail">Email address</label>
                    </div>

                    <div className="form-label-group">
                        <input type="password" className="form-control" name="password"
                               onChange={this.handleInputChange}/>
                            <label htmlFor="inputPassword">Password</label>
                    </div>

                    <button className="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                </form>
            </div>
        );
    }
}


export default Login;
