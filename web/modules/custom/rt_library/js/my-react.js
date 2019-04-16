
class App extends React.Component {
  render() {
    return (
      <div className="App">
        <header className="App-header">
          <h1 className="App-title">Welcome to React</h1>
        </header>
        <p className="App-intro">
          Why did you do ??
        </p>
      </div>
    );
  }
}

ReactDOM.render(
  <App/>,
  document.getElementById('my-react-app')
  );
