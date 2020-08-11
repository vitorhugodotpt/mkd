import React from 'react';
import axios from 'axios';
import auth from "../auth";

class Quiz extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            isFetching: true,
            error: false,
            quiz: [],
            formData: []
        };
        this.hash = this.props.match.params.hash;

        this.handleInputChange = this.handleInputChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    async componentDidMount() {
        const response = await axios.get(`api/quiz/${this.hash}`);
        if(response.data.success) {
            this.setState({
                isFetching: false,
                quiz: response.data.quiz,
                formData: {...this.state.formData, 'project_id': response.data.quiz.project.id}
            });
        }else {
            this.setState({
                isFetching: false,
                error: true
            });
        }
    }

    handleInputChange(event) {
        const target = event.target;
        let value = target.value.trim();
        const name = target.name;

        this.setState({
            formData: {...this.state.formData, [name]: value}
        });
    }

    handleSubmit(event) {
        event.preventDefault();

        axios.post('/api/answers', this.state.formData)
            .then(
                response => {
                    if(response.data.success) {
                        this.props.history.push("/thank-you");
                    }else {
                        this.props.history.push("/error");
                    }
                }
            );
    }


    render() {
        if(this.state.isFetching) {
            return ('Fetching data...');
        }else if(this.state.error) {
            return ('Error the project does not exist.');
        }else {
            const questions = [];

            for (const [index, value] of this.state.quiz.questions.entries()) {
                if(value.is_free_text) {
                    questions.push(<div className="row py-4" key={index}>
                        <div className="form-group col-8">
                            {value.name}
                        </div>
                        <div className="form-group col-4">
                            <input type="text" name={'question' + value.id} onChange={this.handleInputChange} className="form-control" required />
                        </div>
                    </div>)
                }else {
                    questions.push(<div className="row py-4" key={index}>
                        <div className="form-group col-8">
                            {value.name}
                        </div>
                        <div className="form-group col-4">
                            <input type="number" min="1" max="10" name={'question' + value.id} onChange={this.handleInputChange} className="form-control" required />
                        </div>
                    </div>)
                }

            }

            return (
                <div>
                    <div className="row py-4">
                        <h2>Project: {this.state.quiz.project.name}</h2>
                    </div>
                    <form onSubmit={this.handleSubmit}>
                        <div className="row py-4">
                            <div className="form-group col-8">
                                <label>Name</label>
                                <input type="text" name="name" onChange={this.handleInputChange} className="form-control" required />
                            </div>
                            <div className="form-group col-4">
                                <label>Role</label>
                                <input type="text" name="role" onChange={this.handleInputChange} className="form-control" required />
                            </div>
                        </div>
                        {questions}
                        <button type="submit" className="btn btn-primary">Submit</button>
                    </form>
                </div>
            );
        }

    }
}
export default Quiz;
