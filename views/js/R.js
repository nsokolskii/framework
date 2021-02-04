const Router = ReactRouterDOM.BrowserRouter;
const Route = ReactRouterDOM.Route;
const Switch = ReactRouterDOM.Switch;
const Link = ReactRouterDOM.Link;
  
function renderAfterMounting(path){
  switch(path){
    case '': ReactDOM.render(<LoadMoreButton />, document.getElementById('loadMoreButton'));
    case '/shots/8': ReactDOM.render(<CommentForm />, document.getElementById('commentForm'));
  }
}

function App() {
    return (
      <Router>
        <div>
          <nav>
            <ul>
              <li>
                <Link to="/shots/8">8-th shot</Link>
              </li>
              <li>
                <Link to="">All shots</Link>
              </li>
            </ul>
          </nav>
  
          <Switch>
            <Route exact path="/shots/8">
              <Content key={1} page="/shots/8" />
            </Route>
            <Route exact path="">
              <Content key={2} page="" />
            </Route>
          </Switch>
        </div>
      </Router>
    );
  }
  
  function Home() {
    return <h2>Home</h2>;
  }
  
  function About() {
    return <h2>About</h2>;
  }
  
class Content extends React.Component{
    constructor(props){
        super(props);
        this.state = {
            value: '',
            page: this.props.page
        }
        
    }
    componentDidMount(){
      getData(this.state.page).then((data) => {
            this.setState({
                value: data.html
            });
            renderAfterMounting(this.props.page);
        });
    }
    render(){
      // document.getElementById('routeCheck').innerHTML = this.state.value;
      return <div dangerouslySetInnerHTML={{__html: this.state.value}}></div>;
    }
}

ReactDOM.render(
    <App />,
    document.getElementById('routeCheck')
);