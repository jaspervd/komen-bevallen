var Settings = require('../classes/Settings');
var Pregnancy = require('../model/Pregnancy');

var Pregnancies = Backbone.Collection.extend({
   model: Pregnancy,
   url: Settings.API + '/pregnancies'
});

module.exports = Pregnancies;