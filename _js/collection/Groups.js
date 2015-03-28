var Settings = require('../classes/Settings');
var Group = require('../model/Group');

var Groups = Backbone.Collection.extend({
   model: Group,
   url: Settings.API + '/groups'
});

module.exports = Groups;