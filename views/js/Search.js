class SearchField extends React.Component {
    default = 'Search';
    constructor(props) {
        let pageId = window.location.href.split('/');
        pageId = pageId[pageId.indexOf('search') + 1];
        pageId = pageId.replace("%20", " ");
        super(props);
        this.state = {
          value: pageId || this.default,
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
        if(event.target.value != this.default){
            let parsedValue = event.target.value;
            parsedValue = parsedValue.replace(/</g, "").replace(/>/g, "");
            getData("/search/"+parsedValue).then((data) => {
                document.getElementById("searchRes").innerHTML = data.html;
                this.setState({
                    
                });
                window.history.pushState('page2', 'Search results for'+parsedValue, parsedValue || "./");
            });
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
            
            let pageId = window.location.href.split('/');
            pageId = pageId[pageId.indexOf('shots') + 1];
            
            
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

    componentDidMount(){
        this.nameInput.focus(); 
    }

    render() {
      return (
        <div class="container">
            <div class="row">
                <div class="col-md-12" style={{paddingRight: 5}}>
                    <form className="form-inline" onSubmit={this.handleSubmit}>
                        <input type="text" ref={(input) => { this.nameInput = input; }}  name="comment" value={this.state.value} className={this.state.invalid} onChange={this.handleChange} onFocus={this.handleFocus} onBlur={this.handleBlur} />
                        
                    </form>
                </div>
            </div>
        </div>
      );
    }
  }

ReactDOM.render(<SearchField />, document.getElementById('searchField'))