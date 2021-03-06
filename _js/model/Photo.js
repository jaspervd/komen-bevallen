var Settings = require('../classes/Settings');

var Photo = Backbone.Model.extend({
    defaults: {
        id: null,
        user_id: null,
        group_id: null,
        photo_url: undefined,
        contender_id: undefined
    },

    urlRoot: Settings.API + '/photos'
});

module.exports = Photo;