var Settings = require('../classes/Settings');
var Rating = require('../model/Rating');

var Ratings = Backbone.Collection.extend({
   model: Rating,
   url: Settings.API + '/ratings'
});

module.exports = Ratings;