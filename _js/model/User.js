var Settings = require('../classes/Settings');

var User = Backbone.Model.extend({
    defaults: {
        id: null,
        email: undefined,
        date_created: undefined
    },

    urlRoot: Settings.API + '/users'
});

module.exports = User;