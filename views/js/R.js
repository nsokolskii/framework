const Router = ReactRouterDOM.BrowserRouter;
const Route = ReactRouterDOM.Route;
const Switch = ReactRouterDOM.Switch;
const Link = ReactRouterDOM.Link;

document.getElementById('routeCheck').innerHTML = "dwqdwe";
  
function App() {
    return (
      <Router>
        <div>
          <nav>
            <ul>
              <li>
                <Link to="/">Home</Link>
              </li>
              <li>
                <Link to="/about">About</Link>
              </li>
              <li>
                <Link to="/shots/43">Shots</Link>
              </li>
            </ul>
          </nav>
  
          {/* A <Switch> looks through its children <Route>s and
              renders the first one that matches the current URL. */}
          <Switch>
            <Route path="/about">
              <About />
            </Route>
            <Route path="/shots/43">
              <Shots />
            </Route>
            <Route path="/">
              <Home />
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
  
class Shots extends React.Component{
    constructor(props){
        super(props);
        this.state = {
            value: 11
        }
        getData('/routingCheck').then((data) => {
            this.setState({
                value: data.value
            })
        });
    }
    render(){
        return <div>{this.state.value}</div>;
    }
}



ReactDOM.render(
    <App />,
    document.getElementById('routeCheck')
);