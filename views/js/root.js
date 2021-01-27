class SortForm extends React.Component {
  constructor(props) {
    super(props);
    this.state = {value: 'descending'};

    this.handleChange = this.handleChange.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
  }

  handleChange(event) {
    this.setState({value: event.target.value});
    asyncRequest('/test', event.target.value, 'user', 'container');
  }

  handleSubmit(event) {
    event.preventDefault();
  }

  render() {
    return (
      <form onSubmit={this.handleSubmit}>
        <label>
          <select value={this.state.value} onChange={this.handleChange} className="form-control selectpicker show-tick">
            <option value="descending">From newest to oldest</option>
            <option value="ascending">From oldest to newest</option>
          </select>
        </label>
      </form>
    );
  }
}

ReactDOM.render(
  <SortForm />,
  document.getElementById('root')
);