var Settings = require('../classes/Settings');
var User = require('../model/User');

var Users = Backbone.Collection.extend({
   model: User,
   url: Settings.API + '/users'
});

module.exports = Users;