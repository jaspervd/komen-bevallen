require('./helpers');
var AppRouter = require('./router/AppRouter');

var router = new AppRouter();
Backbone.history.start();