module.exports = {
  entry: ['whatwg-fetch', './favourite.js'],
  output: {
    path: __dirname,
    filename: 'favourite.bundle.js'
  },
  module: {
    loaders: [
      { test: /\.js$/, exclude: /node_modules/, loader: 'babel-loader' },
      { test: /\.css$/, loader: "style-loader!css-loader" }
