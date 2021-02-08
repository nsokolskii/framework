class LoadMoreButton extends React.Component {
    default = 'Load more';
    step = 5;
    limit = 5;
    from = 10;
    loadedHtml = document.querySelector('.wrapper').innerHTML;

    constructor(props) {
        super(props);
        this.state = {
            from: this.from,
            limit: this.limit,
            value: this.default,
            disabled: false
        };
        this.handleClick = this.handleClick.bind(this);
    }

    handleClick(event) {
        postData("/loadMore", { "limit": this.state.limit, "from": this.state.from }).then((data) => {
            this.loadedHtml += data.html;
            document.querySelector('.wrapper').innerHTML = this.loadedHtml;
            this.setState({
                value: data.all ? "All entries shown" : this.default,
                disabled: data.all ? true : false
            })
        });
        this.setState({
            from: this.state.from + this.step
        });
    }

    render() {
        return (
            <button className="btn btn-primary" onClick={this.handleClick} disabled={this.state.disabled}>{this.state.value}</button>
        );
    }
}

ReactDOM.render(<LoadMoreButton />, document.getElementById('loadMoreButton'))