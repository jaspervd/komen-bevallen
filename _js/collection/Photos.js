var Settings = require('../classes/Settings');
var Photo = require('../model/Photo');

var Photos = Backbone.Collection.extend({
   model: Photo,
   url: Settings.API + '/photos'
});

module.exports = Photos;