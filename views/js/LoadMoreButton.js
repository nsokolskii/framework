class LoadMoreButton extends React.Component {
    default = 'Load more';
    step = 5;
    limit = 10;
    from = document.querySelector('.wrapper').childElementCount;
    loadedHtml = document.querySelector('.wrapper').innerHTML;

    constructor(props) {
        super(props);
        this.state = {
            from: this.from,
            limit: this.limit,
            value: this.default,
            search: {table: this.props.table || 0, query: this.props.query || 0},
            user: this.props.user || 0,
            disabled: false
        };
        console.log(this.state.search);
        this.handleClick = this.handleClick.bind(this);
    }

    handleClick(event) {
        postData("/loadMore", { "limit": this.state.limit, "from": this.state.from, "table": this.state.search.table, "query": this.state.search.query,
        "user": this.state.user}).then((data) => {
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
            <div style={{paddingTop:20}}>
            <button className="btn btn-primary" onClick={this.handleClick} disabled={this.state.disabled}>{this.state.value}</button>
            </div>
        );
    }
}

ReactDOM.render(<LoadMoreButton />, document.getElementById('loadMoreButton'))