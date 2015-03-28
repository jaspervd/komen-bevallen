var Settings = require('../classes/Settings');

var Group = Backbone.Model.extend({
    defaults: {
        id: null,
        week: undefined,
        users: {}
    },

    urlRoot: Settings.API + '/groups'
});

module.exports = Group;