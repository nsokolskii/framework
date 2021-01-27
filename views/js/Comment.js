class CommentForm extends React.Component {
    default = 'Your comment';
    constructor(props) {
        super(props);
        this.state = {
          value: this.default,
          invalid: "form-control",
          invalidInfo: ""
        };
    
        this.handleChange = this.handleChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
        this.handleFocus = this.handleFocus.bind(this);
        this.handleBlur = this.handleBlur.bind(this);
    }
    
    handleChange(event) {
        this.setState({value: event.target.value});
        if(event.target.value != this.default && event.target.value != ''){
            this.setState({
                invalid: "form-control"
            })
        }
    }

    handleSubmit(event) {
        event.preventDefault();
        if(this.state.value == this.default || this.state.value == ''){
            this.setState({
                invalid: this.state.invalid + " is-invalid",
                invalidInfo: "Comment must not be empty"})
        }
        else{
            asyncRequest('/comment', this.state.value, 'shots', 'comments');
            this.setState({
                value: ""
            });
        }
        
    }

    handleFocus(event){
        if(this.state.value == this.default){
            this.setState({value: ''});
        }
    }

    handleBlur(event){
        if(this.state.value == ''){
            this.setState({value: this.default});
        }
    }
    render() {
      return (
        <form onSubmit={this.handleSubmit}>
            <div className="form-group">
                <input type="text" name="comment" value={this.state.value} className={this.state.invalid} onChange={this.handleChange} onFocus={this.handleFocus} onBlur={this.handleBlur} />
                <div className="invalid-feedback">
                    {this.state.invalidInfo}
                </div>
            </div>
            <input type="submit" value="Submit" className="btn btn-primary" />
        </form>
      );
    }
  }

ReactDOM.render(<CommentForm />, document.getElementById('commentForm'))