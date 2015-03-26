var Settings = require('../classes/Settings');

var Pregnancy = Backbone.Model.extend({
    defaults: {
        id: null,
        user_id: null,
        type: undefined,
        mother: undefined,
        partner: undefined,
        duedate: undefined,
        photo_url: undefined
    },

    urlRoot: Settings.API + '/pregnancies'
});

module.exports = Pregnancy;