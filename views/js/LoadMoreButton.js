async function postData(url = '', data = {}) {

    const response = await fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    });
    return await response.json();
}

class LoadMoreButton extends React.Component {
    default = 'Load more';
    step = 10;
    limit = 20;
    constructor(props) {
        super(props);
        this.state = {
          limit: this.limit,
          value: this.default,
          disabled: false
        };
        this.handleClick = this.handleClick.bind(this);
    }

    handleClick(event){
        postData("/loadMore", {"limit": this.state.limit}).then((data) => {ReactDOM.render(<div dangerouslySetInnerHTML={{__html: data.html}} />, document.getElementById('res'));
        this.setState({value: data.all ? "All entries shown" : this.default,
                        disabled: data.all ? true : false})} );
        this.setState({
            limit: this.state.limit + this.step
        });
    }

    render() {
      return (
        <button class="btn btn-primary" onClick={this.handleClick} disabled={this.state.disabled}>{this.state.value}</button>
      );
    }
  }

ReactDOM.render(<LoadMoreButton />, document.getElementById('loadMoreButton'))