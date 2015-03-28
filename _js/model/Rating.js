var Settings = require('../classes/Settings');

var Rating = Backbone.Model.extend({
    defaults: {
        id: null,
        user_id: null,
        points_show: null,
        points_baby: null,
        points_partner: null,
        contender_id: null,
        group_id: null
    },

    urlRoot: Settings.API + '/ratings'
});

module.exports = Rating;