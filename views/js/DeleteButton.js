class DeleteButton extends React.Component {
    default = 'Delete this shot';
    constructor(props) {
        super(props);
        this.state = {
          href: "#",
          value: this.default,
          focused: 0
        };
    
        this.handleClick = this.handleClick.bind(this);
        this.handleBlur = this.handleBlur.bind(this);
    }

    handleBlur(event){
        this.setState({value: this.default, href: "#", focused: 0});
    }

    handleClick(event){
        
        if(this.state.focused < 1){
            this.setState({focused: this.state.focused + 1, value: "Click one more time to delete this shot"});
        }
        else{
            let pageId = window.location.href.split('/');
            pageId = pageId[pageId.indexOf('edit') + 1];
            this.setState({href: "/delete/"+pageId});
        }
    }

    render() {
      return (
        <a href={this.state.href} className="btn btn-danger" onBlur={this.handleBlur} onClick={this.handleClick}>{this.state.value}</a>
      );
    }
  }

ReactDOM.render(<DeleteButton />, document.getElementById('deleteButton'))