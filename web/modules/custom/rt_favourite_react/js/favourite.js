import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import 'whatwg-fetch';



class Favourite extends Component {

  constructor() {
    super();
    this.toggleFavourite = this.toggleFavourite.bind(this);
    this.saveFavourite = this.saveFavourite.bind(this);
    this.getData = this.getData.bind(this);

    this.state = {
      favourited: '',
      user_uuid: '',
      user_uid: '0',
      node_type: '',
      node_uuid: ''
    }

    this.getData();
  }

  getData() {

    var path = drupalSettings.path.currentPath;

    var nid = path.split('/')[1]; // path is node/12

    fetch('/favourite/data/' + nid, {
      method: 'GET',
      credentials: 'include',
      headers: {
        'Content-Type' : 'application/vnd.api+json'
      }
    }).then((response) => {
      if (response.ok) {
        response.json().then((data) => {
          this.setState({
            favourited: data.favourited,
            user_uid: data.user_uid,
            user_uuid: data.user_uuid,
            node_type: data.node_type,
            node_uuid: data.node_uuid
          })
        })
      } else {
        console.log('error getting data');
      }

    });
  }


  toggleFavourite() {
    var favourited = !this.state.favourited;
    this.saveFavourite(favourited);
  }

  saveFavourite(favourited) {
    var endpoint = '/jsonapi/user/user/' + this.state.user_uuid + '/relationships/field_favourites';

    var method = 'POST';

    if ( !favourited) {
      method = 'DELETE';
    }

    fetch(endpoint, {
      method: method,
      credentials: 'include',
      headers: {
        'Accept' : 'application/vnd.api+json',
        'Content-Type': 'application/vnd.api+json'
      },
      body: JSON.stringify({
        "data": [
          {
            "type" : 'node--' + this.state.node_type, "id": this.state.node_uuid
          }
        ]
      })
    }).then((response) => {
      if (response.ok) {
        response.json().then((data) => {
          this.setState({
            favourited: favourited
          });
        })
      } else {
        console.log('error favouriting node');
      }
    })
  }


  render() {
    if (this.state.user_uuid == "0") {
      return null;
    }

    var linkClass = 'unfavourited';

    var text = 'Favourite';

    if (this.state.favourited) {
      linkClass = 'favourited';
      text = "Unfavourite";
    }

    return (
      <a href="#" className={linkClass} onClick={this.toggleFavourite}>{text}</a>
      );
  }
}


ReactDOM.render(<Favourite/>, document.getElementById('favourite'));
