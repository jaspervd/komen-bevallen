var Settings = require('../classes/Settings');

var User = Backbone.Model.extend({
    defaults: {
        id: null,
        email: undefined,
        mother: undefined,
        partner: undefined,
        photo_url: undefined,
        duedate: undefined,
        type: undefined
    },

    urlRoot: Settings.API + '/users'
});

module.exports = User;