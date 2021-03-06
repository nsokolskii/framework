class CommentForm extends React.Component {
    default = 'Your comment';
    constructor(props) {
        super(props);
        this.state = {
          value: this.default,
          invalid: "flex-fill mr-2 form-control",
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
                invalid: "flex-fill mr-2 form-control"
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
            let parsedValue = this.state.value
            parsedValue = parsedValue.replace(/</g, "").replace(/>/g, "");
            let pageId = window.location.href.split('/');
            pageId = pageId[pageId.indexOf('shots') + 1];
            postData("/comment", { "value": parsedValue, "post": pageId }).then((data) => {
                document.querySelector('#comments').innerHTML = data.html;
                this.setState({
                    value: ""
                });
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
        <div className="container">
            <div className="row">
                <div className="col-md-12">
                    <form className="form-inline" onSubmit={this.handleSubmit}>
                        <input type="text" name="comment" value={this.state.value} className={this.state.invalid} onChange={this.handleChange} onFocus={this.handleFocus} onBlur={this.handleBlur} />
                        <input type="submit" value="Submit" className="btn btn-primary" />
                        <div className="invalid-feedback">
                            {this.state.invalidInfo}
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
      );
    }
  }

ReactDOM.render(<CommentForm />, document.getElementById('commentForm'))